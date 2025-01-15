<?php 
require_once('../defines/functions.php');
require_once('../validate.php');

$CreatedBy = CreatedBy($_SESSION['AccId']);

$AccNumber = ( isset( $_REQUEST['AccNumber'] ) )?  $_REQUEST['AccNumber']: null;
$Action = ( isset( $_REQUEST['Action'] ) )?  $_REQUEST['Action']: null;

$UpdateDate = date('Y-m-d H:i:s');
//Deactivating Member's Account.

$Member = DB::queryFirstRow('SELECT * from members where AccNumber=%s', $AccNumber);

if($Action == "DeActivate"){
	$LoanRequest = DB::queryFirstRow('SELECT * from loanrequests where AccNumber=%s AND Status=%s',$AccNumber,'OUTSTANDING');
	if($LoanRequest){
		echo $Member['Name']."'s account cannot be de-activated due to an outstanding loan.";
	}
	else{
		//Deactivate account//More Action to be performed
		DB::update('members', array('AccStatus'=>'Inactive', 'DateUpdated'=> $UpdateDate), 'AccNumber=%s', $Member['AccNumber']);
		echo $Member['Name']."'s account has been De-Activated.";
	}
}
elseif($Action == "Activate"){
	DB::update('members', array('AccStatus'=>'Active', 'DateUpdated'=> $UpdateDate), 'AccNumber=%s', $Member['AccNumber']);
	echo $Member['Name']."'s account has been Activated.";
}
elseif($Action == "Reset"){
	$hashed_pass = password_hash($Member['EmailAddress'], PASSWORD_DEFAULT);
	DB::update("members",array("Password"=>$hashed_pass, 'DateUpdated'=>$UpdateDate),"AccNumber=%s",$AccNumber);
	echo $Member['Name']."'s password has been reset. New Password is the current Email Address.";
}
else{
	echo "No Action";
}
?>