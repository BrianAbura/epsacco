<?php 
require_once('../defines/functions.php');
require_once('../validate.php');

$AccNumber = ( isset( $_REQUEST['AccNumber'] ) )?  $_REQUEST['AccNumber']: null;
$LoanType = ( isset( $_REQUEST['LoanType'] ) )?  $_REQUEST['LoanType']: null;


$Loan = DB::queryFirstRow("Select Balance from loanrequests where AccNumber=%s AND LoanType=%s AND Status=%s", $AccNumber, $LoanType, "OUTSTANDING");
if($Loan){
    echo $Loan['Balance'];
}
?>