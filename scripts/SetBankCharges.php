<?php
if (isset($_SERVER['REMOTE_ADDR'])) die('Permission denied.');
	//Bank Charges
require_once('/var/www/epsacco.com/scripts/functions.php');
$log = new Logger(LOG_FILE,Logger::DEBUG);
//require_once('../validate.php');

		//Ledger Fee
$LedgerFee = array(
	'Details'=>'Ledger Fee',
	'Amount'=>'2000',
	'AddedBy'=>'SYS_AUTO',
	);
#DB::insert('bankcharges', $LedgerFee);
#$log->LogInfo("Monthly Ledger Information: ".print_r('Successful Logged',true));

		//Excise Duty
$ExciseButy = array(
	'Details'=>'Excise Duty',
	'Amount'=>'300',
	'AddedBy'=>'SYS_AUTO',
	);
#DB::insert('bankcharges', $ExciseButy);
#$log->LogInfo("Monthly Excise Duty Information: ".print_r('Successful Logged',true));
?>
