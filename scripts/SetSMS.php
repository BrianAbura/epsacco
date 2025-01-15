<?php 
//This Script, activates the scheduled messages and sends them

if (isset($_SERVER['REMOTE_ADDR'])) die('Permission denied.');
require_once('/var/www/epsacco.com/defines/functions.php');

$curDate = date('Y-m-d H:i:s');

///Check Scheduled Messages
$schedules = DB::query('SELECT * from scheduledsms where Schedule<=%s AND Status=%s',$curDate, 'Scheduled');

foreach($schedules as $message){
	$response = send_notice($message['MSISDN'], trim($message['Message']));
	DB::update('scheduledsms', ['Status'=>'Sent', 'Response'=> $response], 'Id=%s', $message['Id']);
}

?>