<?php 
require_once('../defines/functions.php');
require_once('../validate.php');

$LoanId = genSavId();
$AccNumber = $_SESSION['AccNumber'];
$LoanType = htmlspecialchars(( isset( $_REQUEST['LoanType'] ) )?  $_REQUEST['LoanType']: null);
$Principal = htmlspecialchars(( isset( $_REQUEST['Amount'] ) )?  $_REQUEST['Amount']: null);
$Rate = htmlspecialchars(( isset( $_REQUEST['Rate'] ) )?  $_REQUEST['Rate']: null);
$Interest = htmlspecialchars(( isset( $_REQUEST['Interest'] ) )?  $_REQUEST['Interest']: null);
$TotalAmount = htmlspecialchars(( isset( $_REQUEST['TotalAmount'] ) )?  $_REQUEST['TotalAmount']: null);
$LoanPeriod = htmlspecialchars(( isset( $_REQUEST['LoanPeriod'] ) )?  $_REQUEST['LoanPeriod']: null);
$GuarantorAccNumber = ( isset( $_REQUEST['GuarantorAccNumber'] ) )?  $_REQUEST['GuarantorAccNumber']: null;
$GuarantorAmount = ( isset( $_REQUEST['GuarantorAmount'] ) )?  $_REQUEST['GuarantorAmount']: null;
$Status = "PENDING APPROVAL";
$Principal = str_replace(',','', $Principal);
$Interest = str_replace(',','', $Interest);
$TotalAmount = str_replace(',','', $TotalAmount);
$GuarantorAmount = str_replace(',','', $GuarantorAmount);

$Member = DB::queryFirstRow('SELECT * from members where AccNumber=%s', $AccNumber);

if($Principal > 20000000){
	$_SESSION['Error'] = "You cannot make a loan request of more than <b>UGX 20,000,000.</b>";
	header('Location: requestLoan.php');
	exit();
}
if(empty($Interest) || empty($TotalAmount) || empty($GuarantorAmount)){
	$_SESSION['Error'] = "Please fill in all the required fields.";
	header('Location: requestLoan.php');
	exit();
}

if($LoanType == "Top-Up"){
	//In-case you have an outstanding top-up loan
	$LoanTopUp = DB::queryFirstRow('SELECT * from loanrequests where AccNumber=%s AND (Status=%s or Status=%s) AND LoanType=%s', $AccNumber,'OUTSTANDING', 'PENDING APPROVAL', 'Top-Up');
	if($LoanTopUp){
        if($LoanTopUp['Status'] == "OUTSTANDING"){
            $_SESSION['Error'] = "You still have an outstanding Top-Up Loan of <b>UGX " .number_format($LoanTopUp['Balance'])."</b>";
            header('Location: requestLoan.php');
            exit();
        }
        elseif($LoanTopUp['Status'] == "PENDING APPROVAL"){
            $_SESSION['Error'] = "You already have a Top-Up loan pending approval.";
            header('Location: requestLoan.php');
            exit();
        }
    }

	//You must be having a Main Loan first
	$MainLoanRequest = DB::queryFirstRow('SELECT * from loanrequests where AccNumber=%s AND (Status=%s or Status=%s) AND LoanType=%s', $AccNumber,'OUTSTANDING', 'PENDING APPROVAL', 'Main');
		if(!$MainLoanRequest){
			$_SESSION['Error'] = "You cannot request for a Loan Top-Up if you don't have an outstanding main loan.";
			header('Location: requestLoan.php');
			exit();
		}
		else{
			//Main should have been cleared to 75%
			echo "Main Cleared to 75%";
			$main_amount = $MainLoanRequest['TotalAmount'];
			$balance = $MainLoanRequest['Balance'];
			$amount_paid = $main_amount - $balance;

			$percent_paid = ($amount_paid/$main_amount)*100;

			if($percent_paid < 75){
				$_SESSION['Error'] = "You are required to have cleared atleast 75% of your main loan before requesting for a top-up.";
				header('Location: requestLoan.php');
				exit();
			}
			else{
				//Add the Top-Up Loan
				$NewLoan = array(
					'LoanId'=>$LoanId,
					'LoanType'=>$LoanType,
					'AccNumber'=>$AccNumber,
					'Principal'=>$Principal,
					'Rate'=>$Rate,
					'Interest'=>$Interest,
					'TotalAmount'=>$TotalAmount,
					'LoanPeriod'=>$LoanPeriod,
					'Status'=>$Status,
					'Balance'=>$TotalAmount,
					'CreatedBy'=>$Member['Name']."{SACCO Member}",
					);
					DB::insert('loanrequests', $NewLoan);

					//Record the Approval level
					// Approval flow: HoF(2) >> Chairperson(1) >> Treasurer(3)
					$loanapprovals = array(
					'LoanId'=>$LoanId,
					'RoleId'=>3,
					'Status'=>'Pending Review by Treasurer.'
					);
					DB::insert('loanapprovals', $loanapprovals);
					
				//Record this history
					$LoanHistory = array(
					'LoanId'=>$LoanId,
					'TransactionType'=>'Loan Top-Up Request',
					'Amount'=>$TotalAmount,
					'AddedBy'=>$Member['Name']."{SACCO Member}",
					);
					DB::insert('loanhistory', $LoanHistory);

				//End Task			
					$_SESSION['Success'] = "Your loan Top-Up request has been received and is pending approval.";
					header('Location: requestLoan.php');		
			}		
		}
}

else{
	//Add the Main Loan Now
	//Does Member have an Outstanding Main Loan
	$LoanRequest = DB::queryFirstRow('SELECT * from loanrequests where AccNumber=%s AND (Status=%s or Status=%s) AND LoanType=%s', $AccNumber,'OUTSTANDING', 'PENDING APPROVAL', 'Main');
		if($LoanRequest['Status'] == "OUTSTANDING"){
			$_SESSION['Error'] = "You still have an outstanding Main loan of <b>UGX " .number_format($LoanRequest['Balance'])."</b>";
			header('Location: requestLoan.php');
			exit();
		}
		elseif($LoanRequest['Status'] == "PENDING APPROVAL"){
			$_SESSION['Error'] = "You have a loan pending approval.";
			header('Location: requestLoan.php');
			exit();
		}
		else{	
	//Add the Main Loan
			$NewLoan = array(
			'LoanId'=>$LoanId,
			'LoanType'=>$LoanType,
			'AccNumber'=>$AccNumber,
			'Principal'=>$Principal,
			'Rate'=>$Rate,
			'Interest'=>$Interest,
			'TotalAmount'=>$TotalAmount,
			'LoanPeriod'=>$LoanPeriod,
			'Status'=>$Status,
			'Balance'=>$TotalAmount,
			'CreatedBy'=>$Member['Name']."{SACCO Member}",
			);
			DB::insert('loanrequests', $NewLoan);
			
	//Record the Approval level
	// Approval flow: HoF(2) >> Chairperson(1) >> Treasurer(3)
			$loanapprovals = array(
			'LoanId'=>$LoanId,
			'RoleId'=>3,
			'Status'=>'Pending Review by Treasurer.'
			);
			DB::insert('loanapprovals', $loanapprovals);


	//Record this history
			$LoanHistory = array(
			'LoanId'=>$LoanId,
			'TransactionType'=>'Loan Request',
			'Amount'=>$TotalAmount,
			'AddedBy'=>$Member['Name']."{SACCO Member}",
			);
			DB::insert('loanhistory', $LoanHistory);
			
	//Add the Guarantor
		
			foreach($GuarantorAccNumber as $a=> $b)
			{
				if($GuarantorAccNumber[$a] == $AccNumber){ //SELF
					DB::insert('guarantors', array('LoanId'=> $LoanId,'AccNumber'=> $AccNumber,'Amount'=> $GuarantorAmount[$a],'Status'=> 'Accepted','Comments'=> '','LoanStatus'=> $Status));
				}
				else{
					$GuarantorDetails = array(
					'LoanId'=> $LoanId,
					'AccNumber'=> $GuarantorAccNumber[$a],
					'Amount'=> $GuarantorAmount[$a],
					'Status'=> 'Pending',
					);
					DB::insert('guarantors', $GuarantorDetails);
					$TableId = "GR - ".DB::insertId();
			//Send the SMS to the Guarantors
					$GuarantorMember = DB::queryFirstRow("SELECT * from members where AccNumber=%s", $GuarantorAccNumber[$a]);
					$SMS = "Dear ".$GuarantorMember['Name'].", ".$Member['Name']." of e-GP Investment Club is requesting you to be a Loan Guarantor. Please login to your account to accept or decline the request.";
					SendSms(formatNumber($GuarantorMember['MSISDN']), $SMS, $TableId, "SYSTEM");	
				}
			}

			$_SESSION['Success'] = "Your loan request has been received and is pending approval.";
			header('Location: requestLoan.php');
		}
}
?>