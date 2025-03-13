<?php
require_once('../defines/functions.php');
require_once('../validate.php');

$CreatedBy = CreatedBy($_SESSION['AccId']);

$LoanId = (isset($_REQUEST['LoanId'])) ?  $_REQUEST['LoanId'] : null;
$Status = (isset($_REQUEST['Status'])) ?  $_REQUEST['Status'] : null;
$Reason = (isset($_REQUEST['Reason'])) ?  $_REQUEST['Reason'] : null;
$dateUpdated = date('Y-m-d H:i:s');

$loan = DB::queryFirstRow('SELECT * from loanrequests where LoanId=%s', $LoanId);

if (!$loan) {
	echo "This loan does not exist or has already been approved. Please contact the Administrator for assistance.";
} else {
	$member = DB::queryFirstRow('SELECT * from members where AccNumber=%s', $loan['AccNumber']);
	$approval = DB::queryFirstRow('SELECT * from loanapprovals where LoanId=%s order by Id desc', $loan['LoanId']);
	//Update Approvals based on the Action
	DB::update('loanapprovals', array('ReviewBy' => $CreatedBy, 'Status' => $Status, 'Narration' => $Reason, 'Date' => $dateUpdated), 'Id=%s', $approval['Id']);
	// Approval flow: HoF(2) >> Chairperson(1) >> Treasurer(3)
	if ($approval['RoleId'] == 3) { //HOF Level
		if ($Status == "APPROVED") {
			DB::update('loanapprovals', array('ReviewBy' => $CreatedBy, 'Status' => "COMPLETED", 'Narration' => $Reason, 'Date' => $dateUpdated), 'Id=%s', $approval['Id']);
			$DueDate = date('Y-m-d h:i:s', strtotime(date('Y-m-d h:i:s') . ' + 1 months'));
			$UpdateLoan = array(
				"Status" => "OUTSTANDING",
				"DueDate" => $DueDate,
			);
			DB::update('loanrequests', $UpdateLoan, 'LoanId=%s', $LoanId);

			//Update the Guarantors
			DB::update('guarantors', array('LoanStatus' => 'OUTSTANDING'), 'LoanId=%s', $LoanId);

			//Add Interests
			$Interests = array(
				'LoanId' => $LoanId,
				'AccNumber' => $loan['AccNumber'],
				'Amount' => $loan['Interest'],
				'CreatedBy' => $CreatedBy,
			);
			DB::insert('interests', $Interests);

			//Record this History
			$LoanHistory = array(
				'LoanId' => $LoanId,
				'TransactionType' => 'Loan Approved',
				'Amount' => $loan['TotalAmount'],
				'AddedBy' => $CreatedBy,
			);
			DB::insert('loanhistory', $LoanHistory);

			// Send Notification
			$TableId = "LR - " . $loan['Id'];
			$SMS = "Your e-GP Investment Club Loan of UGX" . number_format($loan['Principal']) . " has been Approved.";
			SendSms(formatNumber($member['MSISDN']), $SMS, $TableId, "SYSTEM");

			echo $member['Name'] . "'s loan of UGX" . number_format($loan['Principal']) . " has been fully approved and disbursed.";
		} else {
			$UpdateLoan = array(
				"Status" => "REJECTED",
				"ApprovalStatus" => "Rejected at Treasury",
				"ApprovedBy" => $CreatedBy,
				"ApprovalReason" => $Reason,
			);
			DB::update('loanrequests', $UpdateLoan, 'LoanId=%s', $LoanId);

			//Update the Guarantors
			DB::update('guarantors', array('LoanStatus' => 'REJECTED'), 'LoanId=%s', $LoanId);

			//Loan History
			$LoanHistory = array(
				'LoanId' => $LoanId,
				'TransactionType' => 'Loan Rejected',
				'Amount' => $loan['TotalAmount'],
				'AddedBy' => $CreatedBy,
			);
			DB::insert('loanhistory', $LoanHistory);

			// Send Notification
			$TableId = "LR - " . $loan['Id'];
			$SMS = "Your e-GP Investment Club Loan of UGX" . number_format($loan['Principal']) . " has been Rejected. Reason: " . $Reason;
			SendSms(formatNumber($member['MSISDN']), $SMS, $TableId, "SYSTEM");

			echo "You have Rejected " . $member['Name'] . "'s Loan of UGX" . number_format($loan['Principal']) . "<br/><br/>Reason: " . $Reason;
		}
	}
}
