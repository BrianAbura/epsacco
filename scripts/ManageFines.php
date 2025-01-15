<?php 
#Manage the Fines from here

require_once('../defines/functions.php');
require_once('../defines/templates.php');
require_once('../validate.php');

$CreatedBy = CreatedBy($_SESSION['AccId']);

//Incase of Edits
$FineAction = htmlspecialchars(( isset( $_REQUEST['FineAction'] ) )?  $_REQUEST['FineAction']: null);
$editFinesId = htmlspecialchars(( isset( $_REQUEST['editFinesId'] ) )?  $_REQUEST['editFinesId']: null);

$AccNumber = htmlspecialchars(( isset( $_REQUEST['AccNumber'] ) )?  $_REQUEST['AccNumber']: null);
$Amount = htmlspecialchars(( isset( $_REQUEST['Amount'] ) )?  $_REQUEST['Amount']: null);
$Narration = htmlspecialchars(( isset( $_REQUEST['narration'] ) )?  $_REQUEST['narration']: null);
$PaymentDate = htmlspecialchars(( isset( $_REQUEST['PaymentDate'] ) )?  $_REQUEST['PaymentDate']: null);

#Some Edits
$Amount = str_replace(',','', $Amount);
$PaymentDate = date_format(date_create($PaymentDate),"Y-m-d");

$Member = DB::queryFirstRow('SELECT * from members where AccNumber=%s', $AccNumber);
if($FineAction == "Add_New_Fines"){
	$Member = DB::queryFirstRow('SELECT * from members where AccNumber=%s', $AccNumber);
	$Fullname = $Member['Name'];
	//Add the Fines
		$NewFine = array(
		'AccNumber'=>$AccNumber,
		'Amount'=>$Amount,
		'PaymentDate'=>$PaymentDate,
		'Narration'=>$Narration,
		'CreatedBy'=>$CreatedBy,
		);
		DB::insert('fines', $NewFine);
		
		//Send the Notifications.
		$TableId = "FN - ".DB::insertId();
		$SMS = "Your payment of UGX".number_format($Amount)." to e-GP Investment Club for ".$Narration." has been captured successfully.";
		SendSms(formatNumber($Member['MSISDN']), $SMS, $TableId, "SYSTEM");

		$_SESSION['Success'] = $Fullname."'s " .$Narration." has been captured Successfully.";
		header('Location: fines.php');
	}

	elseif($FineAction == "Edit_Fine"){

        $UpdateDate = date('Y-m-d H:i:s');
		$fines = DB::queryFirstRow('SELECT * from fines where Id=%s', $editFinesId);
		
		$Member = DB::queryFirstRow('SELECT * from members where AccNumber=%s', $fines['AccNumber']);
		$Fullname = $Member['Name'];
	
			$EditFine = array(
			'Amount'=>$Amount,
			'PaymentDate'=>$PaymentDate,
			'Narration'=>$Narration,
			'DateUpdated'=>$UpdateDate,
			);
			DB::update('fines', $EditFine, 'Id=%s', $editFinesId);
			$_SESSION['Success'] = $Fullname."'s " .$Narration." has been updated Successfully.";
			header('Location: fines.php');
	}	
?>
