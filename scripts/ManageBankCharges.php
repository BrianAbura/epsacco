<?php 
#Manage the Investments from here

require_once('../defines/functions.php');
require_once('../validate.php');

$CreatedBy = CreatedBy($_SESSION['AccId']);

$bankChargeType = htmlspecialchars(( isset( $_REQUEST['bankChargeType'] ) )?  $_REQUEST['bankChargeType']: null);
$bankchargeID = htmlspecialchars(( isset( $_REQUEST['bankchargeID'] ) )?  $_REQUEST['bankchargeID']: null);

$Amount = htmlspecialchars(( isset( $_REQUEST['Amount'] ) )?  $_REQUEST['Amount']: null);
$Narration = htmlspecialchars(( isset( $_REQUEST['Narration'] ) )?  $_REQUEST['Narration']: null);
$transaction_date = htmlspecialchars(( isset( $_REQUEST['transaction_date'] ) )?  $_REQUEST['transaction_date']: null);

//# Some Edits
$Amount = str_replace(',','', $Amount);
$transaction_date = date_format(date_create($transaction_date),"Y-m-d");

if($bankChargeType == "ADD"){
        $NewBankInterest = array(
        'Amount'=>$Amount,
        'Details'=>$Narration,
        'Date'=>$transaction_date,
        'AddedBy'=>$CreatedBy,
        );
        
        DB::insert('bankcharges', $NewBankInterest);
        $_SESSION['Success'] = "Bank Charge of UGX ".number_format($Amount)." for ".$Narration." has been captured Successfully.";
        header('Location:bankcharges.php');
    }
elseif($bankChargeType == "EDIT"){

    $EditBankCharge = array(
    'Amount'=>$Amount,
    'Details'=>$Narration,
    'Date'=>$transaction_date,
    );
    
    DB::update('bankcharges', $EditBankCharge, 'Id=%s', $bankchargeID);
    $_SESSION['Success'] = "Bank Charge of UGX ".number_format($Amount)." for ".$Narration." has been updated Successfully.";
    header('Location:bankcharges.php');
}
?>