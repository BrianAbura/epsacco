<?php 
//Adding New member
require_once('../defines/functions.php');
require_once('../validate.php');

$CreatedBy = CreatedBy($_SESSION['AccId']);

$MemAction = htmlspecialchars(( isset( $_REQUEST['MemAction'] ) )?  $_REQUEST['MemAction']: null);
$EditMemID = htmlspecialchars(( isset( $_REQUEST['EditMemID'] ) )?  $_REQUEST['EditMemID']: null);

$AccNumber = genAccNumber(); #Incase of New members
$Name = htmlspecialchars(( isset( $_REQUEST['Name'] ) )?  $_REQUEST['Name']: null);
$EmailAddress = htmlspecialchars(( isset( $_REQUEST['EmailAddress'] ) )?  $_REQUEST['EmailAddress']: null);
$MSISDN = htmlspecialchars(( isset( $_REQUEST['MSISDN'] ) )?  $_REQUEST['MSISDN']: null);
$target_dir = "../fileUploads/profiles/";

if($MemAction == "Add_MEM"){

		//Check Email Availability
		if(CheckEmail($EmailAddress)){
			$_SESSION['Error'] = "The Email Address already exists.";
			header('Location: viewMembers.php');
			exit();
		}
		else{
			//Adding the ProfilePicture
			//Check the Profile Picture properties
			$target_file = basename($_FILES["ProfilePicture"]["name"]);
			if(empty($target_file)){
				$target_file = "";
			}
			else{
				$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
				if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
					$_SESSION['Error'] = "Sorry, only JPG, JPEG, PNG file extensions are allowed.";
					header("Location:allMembers.php");
					exit();
				}
				else{
					$imageName = 'ProfilePicture-'.$AccNumber.'-'.str_replace(" ", "_", $Name).'.' . $imageFileType;
					$target_file = $target_dir . $imageName;
					move_uploaded_file($_FILES["ProfilePicture"]["tmp_name"], $target_dir . $imageName);
				}
			}

			//Add the Member
			$tempPass = $EmailAddress; #genPassword();

			$NewMember = array(
			'AccNumber'=>$AccNumber,
			'Name'=>$Name,
			'MSISDN'=>formatNumber($MSISDN),
			'EmailAddress'=>$EmailAddress,
			'ProfilePicture'=>$target_file,
			'Password'=>password_hash($tempPass, PASSWORD_DEFAULT),
			'CreatedBy'=>$CreatedBy,
			);
			DB::insert('members', $NewMember);
			$tID = DB::insertId();

			#Send the password via mail and sms
			$SMS = "Dear ".$Name." your account has been created on e-GP Investment Club. Login on: www.epsacco.com <br/> Email: ".$EmailAddress." and password: ".$tempPass.". <br/> Change your password once logged in.";
			SendSms(formatNumber($MSISDN), $SMS, 'MEM - '.$tID, "SYSTEM");
			$_SESSION['Success'] = $Name." has been SUCCESSFULLY added.";
			header('Location: allMembers.php');
		}
}

elseif($MemAction == "Edit_MEM"){
	
	$UpdateDate = date('Y-m-d H:i:s');
	$Member = DB::queryFirstRow('SELECT * from members where Id=%s', $EditMemID);
	$timeStamp = date('YmdHis');


	//Check properties of the Profile Picture
	$target_file = basename($_FILES["ProfilePicture"]["name"]);
	if(empty($target_file)){
		$target_file = $Member['ProfilePicture'];
	}
	else{
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
			$_SESSION['Error'] = "Sorry, only JPG, JPEG, PNG file extensions are allowed.";
			header("Location:memberProfile.php?AccNumber=".$Member['AccNumber']);
			exit();
		}
		else{
			$imageName = 'ProfilePicture-'.$AccNumber.'-'.str_replace(" ", "_", $Name).'_'.$timeStamp.'.' . $imageFileType;
			$target_file = $target_dir . $imageName;
			move_uploaded_file($_FILES["ProfilePicture"]["tmp_name"], $target_dir . $imageName);
		}
	}

		$EditMember = array(
		'Name'=>$Name,
		'MSISDN'=>formatNumber($MSISDN),
		'EmailAddress'=>$EmailAddress,
		'ProfilePicture'=>$target_file,
		'DateUpdated'=>$UpdateDate,
		);
		
		try {
			DB::update('members', $EditMember, 'Id=%s', $EditMemID);
			echo "Updated";
		} 
		catch(MeekroDBException $e) {
			echo "The Account Number: ".$AccNumber." is registered to another member";
		}

		$_SESSION['Success'] = $Name."'s information has been updated Successfully.";
		header("Location:memberProfile.php?AccNumber=".$Member['AccNumber']);

}

?>