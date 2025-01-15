<?php 
#Manage the Welfare from here

require_once('../defines/functions.php');
require_once('../defines/templates.php');
require_once('../validate.php');

$CreatedBy = CreatedBy($_SESSION['AccId']);

//Incase of Edits
$WelfareAction = htmlspecialchars(( isset( $_REQUEST['WelfareAction'] ) )?  $_REQUEST['WelfareAction']: null);
$EditWelfareId = htmlspecialchars(( isset( $_REQUEST['EditWelfareId'] ) )?  $_REQUEST['EditWelfareId']: null);

$WelfareId = genSavId();
$AccNumber = htmlspecialchars(( isset( $_REQUEST['AccNumber'] ) )?  $_REQUEST['AccNumber']: null);
$Amount = htmlspecialchars(( isset( $_REQUEST['Amount'] ) )?  $_REQUEST['Amount']: null);
$PaymentMode = htmlspecialchars(( isset( $_REQUEST['PaymentMode'] ) )?  $_REQUEST['PaymentMode']: null);
$PaymentDate = htmlspecialchars(( isset( $_REQUEST['PaymentDate'] ) )?  $_REQUEST['PaymentDate']: null);
$ReceiptNumber = htmlspecialchars(( isset( $_REQUEST['ReceiptNumber'] ) )?  $_REQUEST['ReceiptNumber']: null);
$NarrationYear = htmlspecialchars(( isset( $_REQUEST['NarrationYear'] ) )?  $_REQUEST['NarrationYear']: null);
$target_dir = "../fileUploads/receipts/";

#Some Edits
$Narration = "Welfare for: ".$NarrationYear;
$Amount = str_replace(',','', $Amount);
$PaymentDate = date_format(date_create($PaymentDate),"Y-m-d");
$ReceiptNumber = strtoupper($ReceiptNumber);

$Member = DB::queryFirstRow('SELECT * from members where AccNumber=%s', $AccNumber);

if($WelfareAction == "Add_New_Welfare"){
	$Fullname = DB::queryFirstRow('SELECT Name from members where AccNumber=%s', $AccNumber);
	$Fullname = $Fullname['Name'];

	$CheckWelfare = DB::queryFirstRow('SELECT sum(Amount) as total from welfare where AccNumber=%s AND Narration=%s', $AccNumber, $Narration);
	if($CheckWelfare['total'] >= 600000){
			$_SESSION['Error'] = $Fullname." <b>".$Narration."</b> has already been fully cleared.";
	}
	else{
		//Adding the ReceiptImage
		//Check the Profile Picture properties
		$target_file = basename($_FILES["ReceiptImage"]["name"]);
		if(empty($target_file)){
			$target_file = "";
		}
		else{
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
				$_SESSION['Error'] = "Sorry, only JPG, JPEG, PNG file extensions are allowed.";
				header("Location:welfare.php");
				exit();
			}
			else{
				$imageName = 'Welfare-'.$WelfareId.'-'.$AccNumber.'.' . $imageFileType;
				$target_file = $target_dir . $imageName;
				move_uploaded_file($_FILES["ReceiptImage"]["tmp_name"], $target_dir . $imageName);
			}
		}

	//Add the Welfare record
		$NewWelfare = array(
		'PaymentId'=>$WelfareId,
		'AccNumber'=>$AccNumber,
		'Amount'=>$Amount,
		'PaymentMode'=>$PaymentMode,
		'PaymentDate'=>$PaymentDate,
		'Narration'=>$Narration,
		'ReceiptNumber'=>$ReceiptNumber,
		'ReceiptImage'=>$target_file,
		'CreatedBy'=>$CreatedBy,
		);
		DB::insert('welfare', $NewWelfare);
		
		//Send the Notifications.
		$TableId = "WF - ".DB::insertId();
		$TotalWelfare = DB::queryFirstRow('SELECT sum(Amount) from welfare where AccNumber=%s', $AccNumber);
		$Balance =  DB::queryFirstRow('SELECT sum(Amount) from welfare where AccNumber=%s AND Narration=%s', $AccNumber, $Narration);
		$Balance = 600000 - $Balance['sum(Amount)'];

		$SMS = "Your ".$Narration." of UGX".number_format($Amount)." to e-GP Investment Club has been captured. Welfare Balance for ".$NarrationYear." is UGX".number_format($Balance).". Total welfare collection is UGX".number_format($TotalWelfare['sum(Amount)']);
		SendSms(formatNumber($Member['MSISDN']), $SMS, $TableId, "SYSTEM");

		$_SESSION['Success'] = $Fullname."'s <b>" .$Narration."</b> has been captured Successfully. Welfare Balance for ".$NarrationYear. " is UGX".number_format($Balance);
		}
	header('Location: welfare.php');
	}

	elseif($WelfareAction == "Edit_Welfare"){

		$UpdateDate = date('Y-m-d H:i:s');
		$Timestamp = date('YmdHis');
		$welfare = DB::queryFirstRow('SELECT * from welfare where PaymentId=%s', $EditWelfareId);
		$Narration = "Welfare for: ".$NarrationYear;
		
		$Fullname = DB::queryFirstRow('SELECT Name from members where AccNumber=%s', $welfare['AccNumber']);
		$Fullname = $Fullname['Name'];
						
			//Check properties of the Image. If Changed or Now
			$target_file = basename($_FILES["ReceiptImage"]["name"]);
			if(empty($target_file)){
				$target_file = $welfare['ReceiptImage'];
			}
			else{
				$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
				if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
					$_SESSION['Error'] = "Sorry, only JPG, JPEG, PNG file extensions are allowed.";
					header("Location: welfare.php");
					exit();
				}
				else{
					$imageName = 'Welfare-'.$EditWelfareId.'-'.$welfare['AccNumber'].'_'.$Timestamp.'.' . $imageFileType;
					$target_file = $target_dir . $imageName;
					move_uploaded_file($_FILES["ReceiptImage"]["tmp_name"], $target_dir . $imageName);
				}
			}

			$EditWelfare = array(
			'Amount'=>$Amount,
			'PaymentMode'=>$PaymentMode,
			'PaymentDate'=>$PaymentDate,
			'Narration'=>$Narration,
			'ReceiptNumber'=>$ReceiptNumber,
			'ReceiptImage'=>$target_file,
			'DateUpdated'=>$UpdateDate,
			);
			DB::update('welfare', $EditWelfare, 'PaymentId=%s', $EditWelfareId);
			$_SESSION['Success'] = $Fullname."'s " .$Narration." has been updated Successfully.";
		
		header('Location: welfare.php');
	}	
?>
