<?php 
function GuaranteeRequests($AccNumber){
	DB::query("SELECT * FROM guarantors WHERE AccNumber=%s AND Status=%s", $AccNumber, "Pending");
	$requests = DB::count();
	return $requests;
}

function TotalSavings($AccNumber){
	$query = DB::queryFirstRow('SELECT sum(Amount) as TotalSavings from savings where AccNumber=%s', $AccNumber);
	return $query['TotalSavings'];
}

function TotalWelfare($AccNumber){
	$query = DB::queryFirstRow('SELECT sum(Amount) as TotalWelfare from welfare where AccNumber=%s', $AccNumber);
	return $query['TotalWelfare'];
}

function TotalShareValue($AccNumber){
	$query = DB::queryFirstRow('SELECT sum(SharesPurchased * ShareValue) as TotalShareValue from shares where AccNumber=%s', $AccNumber);
	return $query['TotalShareValue'];
}

function LoansRequests($AccNumber){
	$query = DB::queryFirstRow('SELECT sum(Principal) as TotalLoanBorrowed from loanrequests where AccNumber=%s AND (Status=%s or Status=%s)', $AccNumber, 'OUTSTANDING', 'CLEARED');
	return $query['TotalLoanBorrowed'];
}

function LoanPayments($AccNumber){
	$query = DB::queryFirstRow('SELECT sum(AmountPaid) as TotalLoanPayments from loanpayments where AccNumber=%s', $AccNumber);
	return $query['TotalLoanPayments'];
}

function LoanGuaranteed($AccNumber){
	$query = DB::queryFirstRow('SELECT sum(Amount) as LoanGuaranteed from guarantors where AccNumber=%s AND Status=%s AND (LoanStatus=%s or LoanStatus=%s)', $AccNumber, "Accepted", "OUTSTANDING", "CLEARED");
	return $query['LoanGuaranteed'];
}

function MemOutstandingLoans($AccNumber){
	$balance = 0;
	$query = DB::queryFirstRow('SELECT sum(Balance) as Balance from loanrequests where AccNumber=%s AND Status=%s', $AccNumber, "OUTSTANDING");
	if($query){
		$balance =  $query['Balance'];
	}
	return $balance;
}
function MemOutstandingSavings($AccNumber){
	
	return 0;
}
?>
