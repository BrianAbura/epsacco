<?php 
#Manage the Savings from here

require_once('../defines/functions.php');
require_once('../defines/templates.php');
require_once('../validate.php');

$CreatedBy = CreatedBy($_SESSION['AccId']);

//Incase of Edits
$SavingAction = htmlspecialchars(( isset( $_REQUEST['SavingAction'] ) )?  $_REQUEST['SavingAction']: null);
$EditSavingsId = htmlspecialchars(( isset( $_REQUEST['EditSavingsId'] ) )?  $_REQUEST['EditSavingsId']: null);

$SavingsId = genSavId();
$AccNumber = htmlspecialchars(( isset( $_REQUEST['AccNumber'] ) )?  $_REQUEST['AccNumber']: null);
$Amount = htmlspecialchars(( isset( $_REQUEST['Amount'] ) )?  $_REQUEST['Amount']: null);
$SavingMode = htmlspecialchars(( isset( $_REQUEST['SavingMode'] ) )?  $_REQUEST['SavingMode']: null);
$SavingDate = htmlspecialchars(( isset( $_REQUEST['SavingDate'] ) )?  $_REQUEST['SavingDate']: null);
$ReceiptNumber = htmlspecialchars(( isset( $_REQUEST['ReceiptNumber'] ) )?  $_REQUEST['ReceiptNumber']: null);
$NarrationMonth = htmlspecialchars(( isset( $_REQUEST['NarrationMonth'] ) )?  $_REQUEST['NarrationMonth']: null);
$NarrationYear = htmlspecialchars(( isset( $_REQUEST['NarrationYear'] ) )?  $_REQUEST['NarrationYear']: null);
$target_dir = "../fileUploads/receipts/";

#Some Edits
$Narration = "Saving for: ".$NarrationMonth." ".$NarrationYear;
$Amount = str_replace(',','', $Amount);
$SavingDate = date_format(date_create($SavingDate),"Y-m-d");
$ReceiptNumber = strtoupper($ReceiptNumber);

$Member = DB::queryFirstRow('SELECT * from members where AccNumber=%s', $AccNumber);
if($SavingAction == "Add_New_Savings"){
	$Member = DB::queryFirstRow('SELECT * from members where AccNumber=%s', $AccNumber);
	$Fullname = $Member['Name'];

	// $CheckSaving = DB::queryFirstRow('SELECT Narration from savings where AccNumber=%s AND Narration=%s', $AccNumber, $Narration);
	// if(isset($CheckSaving['Narration'])){
	// $_SESSION['Error'] = $Narration." for ".$Fullname." already exists.";
	// }
	// else{
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
				header("Location:savings.php");
				exit();
			}
			else{
				$imageName = 'Savings-'.$SavingsId.'-'.$AccNumber.'.' . $imageFileType;
				$target_file = $target_dir . $imageName;
				move_uploaded_file($_FILES["ReceiptImage"]["tmp_name"], $target_dir . $imageName);
			}
		}

	//Add the Saving
		$NewSaving = array(
		'SavingsId'=>$SavingsId,
		'AccNumber'=>$AccNumber,
		'Amount'=>$Amount,
		'SavingMode'=>$SavingMode,
		'SavingDate'=>$SavingDate,
		'Narration'=>$Narration,
		'ReceiptNumber'=>$ReceiptNumber,
		'ReceiptImage'=>$target_file,
		'CreatedBy'=>$CreatedBy,
		);
		DB::insert('savings', $NewSaving);
		
		//Send the Notifications.
		$TableId = "SV - ".DB::insertId();
		$TotalSavings = DB::queryFirstRow('SELECT sum(Amount) from savings where AccNumber=%s', $AccNumber);
		$SMS = "Your ".$Narration." of UGX".number_format($Amount)." to e-GP Investment Club has been captured. Your total savings balance is UGX".number_format($TotalSavings['sum(Amount)']);
		SendSms(formatNumber($Member['MSISDN']), $SMS, $TableId, "SYSTEM");

		$_SESSION['Success'] = $Fullname."'s " .$Narration." has been captured Successfully.";
		// }
		header('Location: savings.php');
	}

	elseif($SavingAction == "Edit_Saving"){

        $UpdateDate = date('Y-m-d H:i:s');
		$Timestamp = date('YmdHis');
		$savings = DB::queryFirstRow('SELECT * from savings where SavingsId=%s', $EditSavingsId);
		$Narration = "Saving for: ".$NarrationMonth." ".$NarrationYear;
		
		$Member = DB::queryFirstRow('SELECT * from members where AccNumber=%s', $savings['AccNumber']);
		$Fullname = $Member['Name'];
		
			//Check properties of the Image. If Changed or Now
			$target_file = basename($_FILES["ReceiptImage"]["name"]);
			if(empty($target_file)){
				$target_file = $savings['ReceiptImage'];
			}
			else{
				$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
				if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
					$_SESSION['Error'] = "Sorry, only JPG, JPEG, PNG file extensions are allowed.";
					header("Location: savings.php");
					exit();
				}
				else{
					$imageName = 'Savings-'.$EditSavingsId.'-'.$savings['AccNumber'].'_'.$Timestamp.'.' . $imageFileType;
					$target_file = $target_dir . $imageName;
					move_uploaded_file($_FILES["ReceiptImage"]["tmp_name"], $target_dir . $imageName);
				}
			}

			$EditSaving = array(
			'Amount'=>$Amount,
			'SavingMode'=>$SavingMode,
			'SavingDate'=>$SavingDate,
			'Narration'=>$Narration,
			'ReceiptNumber'=>$ReceiptNumber,
			'ReceiptImage'=>$target_file,
			'DateUpdated'=>$UpdateDate,
			);
			DB::update('savings', $EditSaving, 'SavingsId=%s', $EditSavingsId);
			$_SESSION['Success'] = $Fullname."'s " .$Narration." has been updated Successfully.";
			header('Location: savings.php');
	}	
?>
