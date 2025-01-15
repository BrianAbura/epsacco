<?php 
//Adding New member
require_once('../defines/functions.php');
require_once('../validate.php');

$CreatedBy = CreatedBy($_SESSION['AccId']);

//For Edits
$AdminAction = htmlspecialchars(( isset( $_REQUEST['AdminAction'] ) )?  $_REQUEST['AdminAction']: null);
$EditMemID = htmlspecialchars(( isset( $_REQUEST['EditMemID'] ) )?  $_REQUEST['EditMemID']: null);
$AccStatus = htmlspecialchars(( isset( $_REQUEST['AccStatus'] ) )?  $_REQUEST['AccStatus']: null);

//For DeleteDelRowId
$DelRowId = htmlspecialchars(( isset( $_REQUEST['DelRowId'] ) )?  $_REQUEST['DelRowId']: null);

$AccNumber = htmlspecialchars(( isset( $_REQUEST['AccNumber'] ) )?  $_REQUEST['AccNumber']: null);
$Role = htmlspecialchars(( isset( $_REQUEST['Role'] ) )?  $_REQUEST['Role']: null);


if($AdminAction == "Add_Admin"){
	$queryRole = DB::queryFirstRow('SELECT Designation from roles where RoleId=%s', $Role);
	$Designation = $queryRole['Designation'];

	$Member = DB::queryFirstRow('SELECT * from members where AccNumber=%s', $AccNumber);
    $checkAdminRole = DB::queryFirstRow('SELECT * from systemusers where EmailAddress=%s', $Member['EmailAddress']);
		//Check Email Availability
		if($checkAdminRole){
			$_SESSION['Error'] = $Member['Name']." has already been assigned an Administrative role.";
			header('Location: administrativeMembers.php');
			exit();
		}
		else{


			//Add the Administrative Member
			$tempPass = $Member['EmailAddress']; #genPassword();

			$NewAdminMember = array(
			'Name'=>$Member['Name'],
			'AccId'=>genSysUserId(),
			'MSISDN'=>formatNumber($Member['MSISDN']),
			'EmailAddress'=>$Member['EmailAddress'],
			'ProfilePicture'=>$Member['ProfilePicture'],
            'Password'=>password_hash($tempPass, PASSWORD_DEFAULT),
            'Role'=>$Role,
			'CreatedBy'=>$CreatedBy,
			);
			DB::insert('systemusers', $NewAdminMember);
			$tID = DB::insertId();


			#Send the password via mail and sms
			$SMS = "Dear ".$Member['Name']." you have been assigned the role of ".$Designation." for e-GP Investment Club. Login on: www.epsacco.co.ug <br/> Email: ".$Member['EmailAddress']." and temporary password: ".$tempPass.". <br/> Change your password once logged in.".
			#SendSms(formatNumber($Member['MSISDN']), $SMS, 'MEM - '.$tID, "SYSTEM");
			$_SESSION['Success'] = $Member['Name']." has been assigned the role of ".$Designation;
			header('Location: administrativeMembers.php');
		}
}

else{
	//Delete the Record
	$query = DB::queryFirstRow('SELECT * from systemusers where Id=%s', $DelRowId);
	if($query['Role'] == 1){
		echo "Systems Administrator role cannot be Deleted";
	}
	else{
		DB::delete('systemusers', 'Id=%s', $DelRowId);
		echo $query['Name']."'s Administrative role has been removed.";
	}
}
?>