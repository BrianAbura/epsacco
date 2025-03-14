<?php 
require_once('../defines/functions.php');
require_once('../validate.php');

$GuarantorId = htmlspecialchars(( isset( $_REQUEST['GuarantorId'] ) )?  $_REQUEST['GuarantorId']: null);
$Status = htmlspecialchars(( isset( $_REQUEST['Status'] ) )?  $_REQUEST['Status']: null);
$Comments = htmlspecialchars(( isset( $_REQUEST['Comments'] ) )?  $_REQUEST['Comments']: null);

$guarantor_request = DB::queryFirstRow('SELECT * from guarantors where Id=%s', $GuarantorId);
$loan = DB::queryFirstRow('SELECT * from loanrequests where LoanId=%s', $guarantor_request['LoanId']);

$guarantor = DB::queryFirstRow('SELECT * from members where AccNumber=%s', $guarantor_request['AccNumber']);
$member = DB::queryFirstRow('SELECT * from members where AccNumber=%s', $loan['AccNumber']);

    $GurantAction = array(
    'Status'=>$Status,
    'Comments'=>$Comments,
    );

    DB::update('guarantors', $GurantAction, 'Id=%s', $GuarantorId);

    // Send Notification
    if ($Status == "Accepted") {
        $TableId = "LR - " . $loan['Id'];
        $SMS = "Dear ".$member['Name'].", ".$guarantor['Name']." has accepted to guarantee your e-GP Investment Club loan of UGX" . number_format($loan['Principal']);
        SendSms(formatNumber($member['MSISDN']), $SMS, $TableId, "SYSTEM");
    } else {
        $TableId = "LR - " . $loan['Id'];      
        $SMS = "Dear ".$member['Name'].", ".$guarantor['Name']." has declined to guarantee your e-GP Investment Club loan of UGX" . number_format($loan['Principal']);
        SendSms(formatNumber($member['MSISDN']), $SMS, $TableId, "SYSTEM");
    }
    
    echo "Your response has been successfully captured."
?>
