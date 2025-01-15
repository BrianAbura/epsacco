<?php 
#require_once('/var/www/epsacco.com/defines.php');
require_once('defines.php');
$log = new Logger(LOG_FILE,Logger::DEBUG);

function CreatedBy($id){
	$sysUser = DB::queryFirstRow('SELECT * from systemusers where AccId=%s',$id);
	$Role = DB::queryFirstRow('SELECT Designation as Role from roles where RoleId=%s', $sysUser['Role']);
	$CreatedBy = $sysUser['Name']."{".$Role['Role']."}";
	return $CreatedBy;	
}

function formatNumber($num){
    $num = trim($num);
    $num = preg_replace('/^07/','2567',$num);
    $num = preg_replace('/^7/','2567',$num);
    $num = preg_replace('/^\+2567/','2567',$num);
    $num = preg_replace('/^\+/','',$num);
    return $num;
}

function genPassword() {
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789#@%";
	return substr(str_shuffle($chars),0,9);
}

function CheckEmail($EmailAddress){
	$query = DB::queryFirstRow('SELECT * from members where EmailAddress=%s AND AccStatus=%s',$EmailAddress, 'Active');
		if($query){
			return TRUE;
		}
		else{
        	return false;
        }
}

function CheckAdminEmail($EmailAddress){
	$query = DB::queryFirstRow('SELECT * from systemusers where EmailAddress=%s',$EmailAddress);
		if(isset($query['Id'])){
			return true;
		}
		else{
			return false;
		}
}

function PendingApprovals($Role){
	DB::query("SELECT * FROM loanapprovals WHERE RoleId=%s AND Status LIKE %ss", $Role, "Pending");
	$requests = DB::count();
	return $requests;
}

//Sending SMS
function SendSms($Mobile, $Message, $TableId, $CreatedBy) {
	$data = array('client_data'=> array('client_id' => CLIENT_ID,'api_username'=>SMS_USER, 'api_key'=>SMS_PASS),
	'message_data'=> array('mobile_number' => $Mobile, 'message' => $Message));
	$url = SMS_URL;
	$json_data = json_encode($data); 
	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
	curl_setopt($ch, CURLOPT_HEADER, 0); 
	curl_setopt($ch, CURLOPT_POST, 1); 
	curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data); 
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	$ch_result = curl_exec($ch); 
	curl_close($ch);
	//$log->LogInfo("EGO SMS Response: ".print_r($ch_result,true));
	#var_dump($ch_result);
	DB::insert('smsnotice', array('TableId'=>$TableId, 'MSISDN'=>$Mobile, 'Message'=>$Message, 'Response'=>$ch_result, 'CreatedBy'=>$CreatedBy));
}

function send_notice($Mobile, $Message) {
	$data = array('client_data'=> array('client_id' => CLIENT_ID,'api_username'=>SMS_USER, 'api_key'=>SMS_PASS),
	'message_data'=> array('mobile_number' => $Mobile, 'message' => $Message));
	$url = SMS_URL;
	$json_data = json_encode($data); 
	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
	curl_setopt($ch, CURLOPT_HEADER, 0); 
	curl_setopt($ch, CURLOPT_POST, 1); 
	curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data); 
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	$ch_result = curl_exec($ch); 
	curl_close($ch);
	//$log->LogInfo("EGO SMS Response: ".print_r($ch_result,true));
	#var_dump($ch_result);
	$response = $ch_result;
	return $response;
}

//Sending SMS
function SendEmail($TableId, $Subject, $Receipient, $Message, $CreatedBy) {
	$Name = $Receipient['Fullname'];
	$Email = $Receipient['EmailAddress'];

	$msgBody = $Message['MsgBody'];
	$msgAttachment = $Message['MsgAttachment'];

	$data = array('client_data'=> array('client_id' => CLIENT_ID,'api_username'=>EMAIL_USER, 'api_key'=>EMAIL_PASS),
            'message_data'=> array('subject'=>$Subject,'recipient_name'=>$Name, 'recipient_email' => $Email, 'message' => $Message));
			$url = EMAIL_URL;
			$json_data = json_encode($data); 
			$ch = curl_init(); 
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
			curl_setopt($ch, CURLOPT_HEADER, 0); 
			curl_setopt($ch, CURLOPT_POST, 1); 
			curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data); 
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
			$ch_result = curl_exec($ch); 
			curl_close($ch);

	DB::insert('emails', array('TableId'=>$TableId, 'ReceiverName'=>$Name, 'ReceiverEmail'=>$Email, 'Subject'=>$Subject, 
	'Message'=>$msgBody, 'Attachments'=>$msgAttachment, 'Response'=>$ch_result, 'CreatedBy'=>$CreatedBy));
}

function getSMSBalance() {
	$data = array('client_data'=> array('client_id' => CLIENT_ID,'api_username'=>SMS_USER, 'api_key'=>SMS_PASS),
	'message_data'=> array('balance' =>'getBalance'));
	$url = SMS_URL;
	$json_data = json_encode($data); 
	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
	curl_setopt($ch, CURLOPT_HEADER, 0); 
	curl_setopt($ch, CURLOPT_POST, 1); 
	curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data); 
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	$ch_result = curl_exec($ch); 
	curl_close($ch);
	$response = json_decode($ch_result);
	if($response->Status == "ERROR"){
		$res = "ERROR!";
	}
	else{
		$res = number_format($response->Response);
	}
	print($res);
}

function genSysUserId(){
	$AccId = mt_rand(11111,99999);
	$query = DB::queryFirstRow('SELECT * from systemusers where AccId=%s',$AccId);
	if(!isset($query['AccId'])){
		return $AccId;
	}
}

function genAccNumber(){
	$AccId = mt_rand(11111,99999);
	$query = DB::queryFirstRow('SELECT * from members where AccNumber=%s',$AccId);
	if(!isset($query['AccNumber'])){
		return $AccId;
	}
}

function genSavId(){
	$SavingsId = mt_rand(1111,9999);
	$query = DB::queryFirstRow('SELECT * from savings where SavingsId=%s',$SavingsId);
	if(isset($query['SavingsId'])){
		$SavingsId = mt_rand(1111,9999);
	}
	return $SavingsId;
}

						##Dashboard
function sumMembers(){
	DB::query('SELECT * from members where AccStatus=%s', 'Active');
	return DB::count();
}
/**Savings */
function sumSavings(){
	$total = 0;
	$members = DB::query('SELECT * from members where AccStatus=%s', 'Active');
	foreach($members as $member){
		$savings = DB::queryFirstRow('SELECT sum(Amount) as sumSavings from savings where AccNumber=%s', $member['AccNumber']);
		$total = $total + $savings['sumSavings'];
	}
	return $total;
}

function sumFines(){
	$total = 0;
	$members = DB::query('SELECT * from members where AccStatus=%s', 'Active');
	foreach($members as $member){
		$fines = DB::queryFirstRow('SELECT sum(Amount) as sumFines from fines where AccNumber=%s', $member['AccNumber']);
		$total = $total + $fines['sumFines'];
	}
	return $total;
}

function MembersumSavings($AccNumber){
	$MembersumSavings = DB::queryFirstRow('SELECT sum(Amount) as MembersumSavings from savings where AccNumber=%s', $AccNumber);
	return $MembersumSavings['MembersumSavings'];
}

//Expected Savings All Members
function ExpectedTotalSavings(){
	$expectedAmount = 0;
	$CurrentDate = date('Y-m-d');
	$members = DB::query('SELECT * from members where AccStatus=%s', 'Active');
	foreach($members as $member){
		$StartDate = "2019-04-01"; #Initial Saving Date
		$Years = date('Y', strtotime($CurrentDate)) - date('Y', strtotime($StartDate)); #Full Years
		$Months = date('m', strtotime($CurrentDate)) - date('m', strtotime($StartDate)); #Full Months
		$TotalMonths = ($Years * 12) + $Months+2;
		$TotalAmount = $TotalMonths * 100000;
		$expectedAmount += $TotalAmount;
	}
	return $expectedAmount;
}

//Updated Individual Savings by 50k
function newExpectedMemberSavings()
{
	$CurrentDate = date('Y-m-d');
	$StartDate = "2024-01-01"; // Updated Date of January 2024
	$Years = date('Y', strtotime($CurrentDate)) - date('Y', strtotime($StartDate)); #Full Years
	$Months = date('m', strtotime($CurrentDate)) - date('m', strtotime($StartDate)); #Full Months
	$TotalMonths = ($Years * 12) + $Months;
	$TotalAmount = $TotalMonths * 50000;
	$expectedAmount += $TotalAmount;
return $expectedAmount;
}

//Expected Indivdual Savings
function ExpectedMemberSavings(){
	$expectedAmount = 0;
	$CurrentDate = date('Y-m-d');
		$StartDate = "2019-04-01"; //From the date they joined
		$Years = date('Y', strtotime($CurrentDate)) - date('Y', strtotime($StartDate)); #Full Years
		$Months = date('m', strtotime($CurrentDate)) - date('m', strtotime($StartDate)); #Full Months
		$TotalMonths = ($Years * 12) + $Months+2;
		$TotalAmount = $TotalMonths * 100000;
		$expectedAmount += $TotalAmount;
	return ($expectedAmount + newExpectedMemberSavings());
	// return $expectedAmount;
}

//Outstanding Savings for all Members
function outstandingSavings(){
	$sumOutstanding = 0;
			$members = DB::query('SELECT * from members where AccStatus=%s order by Name', 'Active');
			foreach($members as $member){
			$expectedSaving = ExpectedMemberSavings();
        	$currentSaving = MembersumSavings($member['AccNumber']);
        	$outstandingSaving = $expectedSaving - $currentSaving;

            if($outstandingSaving < 0){
              $sumOutstanding -= $outstandingSaving;
            }
			$sumOutstanding += $outstandingSaving;
		}
		return $sumOutstanding ;
}

function Interests(){
	$Interests = 0;
	$Members = DB::query('SELECT * from members where AccStatus=%s', 'Active');
		foreach($Members as $Member)
		{
			$MemberInterests = DB::queryFirstRow('SELECT sum(Amount) from interests where AccNumber=%s', $Member['AccNumber']);
			$Interests = $Interests + $MemberInterests['sum(Amount)'];
		}
	return $Interests;
}


/** Loans */
function totalLoans(){
	$loans = DB::queryFirstRow('SELECT sum(Principal) as totalLoans from loanrequests where (Status=%s OR Status=%s)', 'OUTSTANDING', 'CLEARED');
	return $loans['totalLoans'];
}

function totalLoanInterests(){
	$loans = DB::queryFirstRow('SELECT sum(Amount) as totalLoanInterests from interests');
	return $loans['totalLoanInterests'];
}

function outstandingLoans(){
	$loans = DB::queryFirstRow('SELECT sum(Balance) as outstandingLoans from loanrequests where Status=%s', 'OUTSTANDING');
	return $loans['outstandingLoans'];
}

function paidLoans(){
	$paidLoans = DB::queryFirstRow('SELECT sum(AmountPaid) as paidLoans from loanpayments');
	return $paidLoans['paidLoans'];
}

/**Shares */
function sumShares(){
	$sumShares = DB::queryFirstRow('SELECT sum(SharesPurchased * ShareValue ) as sumShares from shares');
	return $sumShares['sumShares'];
}


/** Investments */
function sumMTN(){
	$sumMTN = DB::queryFirstRow('SELECT sum(Amount) as sumMTN from investments where investmentType=%s', 'MTN');
	return $sumMTN['sumMTN'];
}

function sumAirtel(){
	$sumAirtel = DB::queryFirstRow('SELECT sum(Amount) as sumAirtel from investments where investmentType=%s', 'Airtel');
	return $sumAirtel['sumAirtel'];
}

function sumBoat(){
	$sumBoat = DB::queryFirstRow('SELECT sum(Amount) as sumBoat from investments where investmentType=%s', 'Boat');
	$invested = DB::queryFirstRow('SELECT Amount from initial_investments where investmentType=%s', 'Boat');
	return ($sumBoat['sumBoat'] + $invested['Amount']);
}

function sumBritam(){
	$sumBritam = DB::queryFirstRow('SELECT sum(Amount) as sumBritam from investments where investmentType=%s', 'Britam');
	$invested = DB::queryFirstRow('SELECT Amount from initial_investments where investmentType=%s', 'Britam');
	return ($sumBritam['sumBritam'] + $invested['Amount']);
}

function sumPicfare(){
	$sumPicfare = DB::queryFirstRow('SELECT sum(Amount) as sumPicfare from investments where investmentType=%s', 'Picfare');
	$invested = DB::queryFirstRow('SELECT Amount from initial_investments where investmentType=%s', 'Picfare');
	return ($sumPicfare['sumPicfare'] + $invested['Amount']);
}

function sumRefreshments(){
	$sumRefreshments = DB::queryFirstRow('SELECT sum(Amount) as sumRefreshments from investments where investmentType=%s', 'Refreshments');
	$invested = DB::queryFirstRow('SELECT Amount from initial_investments where investmentType=%s', 'Refreshments');
	return ($sumRefreshments['sumRefreshments'] + $invested['Amount']);
}

function sumPharmacy(){
	$sumPharmacy = DB::queryFirstRow('SELECT sum(Amount) as sumPharmacy from investments where investmentType=%s', 'Pharmacy');
	$invested = DB::queryFirstRow('SELECT Amount from initial_investments where investmentType=%s', 'Pharmacy');
	return ($sumPharmacy['sumPharmacy'] + $invested['Amount']);
}
//

/** Administrative Fees */
function sumBankCharges(){
	$BankCharges = DB::queryFirstRow('SELECT sum(Amount) from bankcharges');
	return $BankCharges['sum(Amount)'];
}

function sumWelfare(){ //Membership Fees
	$sumWelfare = DB::queryFirstRow('SELECT sum(Amount) as sumWelfare from welfare');
	return $sumWelfare['sumWelfare'];
}

/**Investments */

function invDeposits(){
	$invDeposits = DB::queryFirstRow('SELECT sum(amount) as sumDeposits from investment_transactions where trans_action=%s', 'Deposit');
	return $invDeposits['sumDeposits'];
}

function invInterests(){
	$invInterests = DB::queryFirstRow('SELECT sum(amount) as sumInterests from investment_transactions where trans_action=%s', 'Interest');
	return $invInterests['sumInterests'];
}

function invWithdraws(){
	$invWithdraws = DB::queryFirstRow('SELECT sum(amount) as sumWithdraws from investment_transactions where trans_action=%s', 'Withdraw');
	return $invWithdraws['sumWithdraws'];
}
?>