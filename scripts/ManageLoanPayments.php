<?php 
#Manage the Savings from here

require_once('../defines/functions.php');
require_once('../validate.php');

$CreatedBy = CreatedBy($_SESSION['AccId']);

$lnPaymentAction = htmlspecialchars(( isset( $_REQUEST['lnPaymentAction'] ) )?  $_REQUEST['lnPaymentAction']: null);
$EditPaymentId = htmlspecialchars(( isset( $_REQUEST['loanPaymentId'] ) )?  $_REQUEST['loanPaymentId']: null);

$AccNumber = htmlspecialchars(( isset( $_REQUEST['AccNumber'] ) )?  $_REQUEST['AccNumber']: null);
$LoanType = htmlspecialchars(( isset( $_REQUEST['LoanType'] ) )?  $_REQUEST['LoanType']: null);
$AmountPaid = htmlspecialchars(( isset( $_REQUEST['Amount'] ) )?  $_REQUEST['Amount']: null);
$PaymentDate = htmlspecialchars(( isset( $_REQUEST['PaymentDate'] ) )?  $_REQUEST['PaymentDate']: null);

#Some Edits
$AmountPaid = str_replace(',','', $AmountPaid);
$PaymentDate = date_format(date_create($PaymentDate),"Y-m-d");
$target_dir = "../fileUploads/receipts/";


if($lnPaymentAction == "ADD"){
            #Handle the Loan
        $Member = DB::queryFirstRow('SELECT * from members where AccNumber=%s', $AccNumber);
        $Loan = DB::queryFirstRow('SELECT * from loanrequests where AccNumber=%s AND Status=%s AND LoanType=%s',$AccNumber,'OUTSTANDING',$LoanType);
        $NewLoanBalance = round($Loan['Balance']) - $AmountPaid;

                //Check the Profile Picture properties
                $target_file = basename($_FILES["ReceiptImage"]["name"]);
                if(empty($target_file)){
                    $target_file = "";
                }
                else{
                    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                        $_SESSION['Error'] = "Sorry, only JPG, JPEG, PNG file extensions are allowed.";
                        header("Location:loanPayments.php");
                        exit();
                    }
                    else{
                        $imageName = 'LoanPayment-'.$Loan['LoanId'].'-'.$AccNumber.'-'.$PaymentDate.'.' . $imageFileType;
                        $target_file = $target_dir . $imageName;
                        move_uploaded_file($_FILES["ReceiptImage"]["tmp_name"], $target_dir . $imageName);
                    }
                }

        //Record the Loan Record			
            $LoanPayment = array(
            'LoanId'=>$Loan['LoanId'],
            'LoanType'=>$Loan['LoanType'],
            'AccNumber'=>$Loan['AccNumber'],
            'TotalAmount'=>round($Loan['Balance']),
            'AmountPaid'=>$AmountPaid,
            'Balance'=>$NewLoanBalance,
            'PaymentDate'=>$PaymentDate,
            'PaymentReceipts'=>$target_file,
            'AddedBy'=>$CreatedBy,
            );
            DB::insert('loanpayments', $LoanPayment);
            $TableId = "LP - ".DB::insertId();
            
        //Record this history
            $LoanHistory = array(
            'LoanId'=>$Loan['LoanId'],
            'TransactionType'=>'Loan Payment',
            'Amount'=>$AmountPaid,
            'AddedBy'=>$CreatedBy,
            );
            DB::insert('loanhistory', $LoanHistory);

        //Update Loan Balance
            if($NewLoanBalance <= 0){
                DB::update('loanrequests', array('Balance'=> $NewLoanBalance,'Status'=>'CLEARED'), 'LoanId=%s', $Loan['LoanId']);
                $SMS = "Your Loan Payment of UGX".number_format($AmountPaid)." to e-GP Investment Club has been received. Your Loan is now cleared.";
            }
            else{
                DB::update('loanrequests', array('Balance'=> $NewLoanBalance), 'LoanId=%s', $Loan['LoanId']);
                $SMS = "Your Loan Payment of UGX".number_format($AmountPaid)." to e-GP Investment Club has been received. Your Loan balance is UGX".number_format($NewLoanBalance).". and your due date is ".$Loan['DueDate'];
            }

            $_SESSION['Success'] = $Member['Name']."'s Loan Payment of UGX".number_format($AmountPaid)." has been SUCCESSFULLY added. Loan Balance is UGX".number_format($NewLoanBalance);
            
            //Send Member the SMS Notification.
            SendSms(formatNumber($Member['MSISDN']), $SMS, $TableId, "SYSTEM");	
            header('Location: loanPayments.php');
}
elseif($lnPaymentAction == "EDIT"){
        $UpdateDate = date('Y-m-d H:i:s');
		$Timestamp = date('YmdHis');
		$loanPayment = DB::queryFirstRow('SELECT * from loanpayments where Id=%s', $EditPaymentId);
        $Member = DB::queryFirstRow('SELECT * from members where AccNumber=%s', $loanPayment['AccNumber']);
        $LoanBalance = $loanPayment['TotalAmount'] - $AmountPaid;

        //Check the Profile Picture properties
        $target_file = basename($_FILES["ReceiptImage"]["name"]);
        if(empty($target_file)){
            $target_file = $loanPayment['PaymentReceipts'];
        }
        else{
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                $_SESSION['Error'] = "Sorry, only JPG, JPEG, PNG file extensions are allowed.";
                header("Location:loanPayments.php");
                exit();
            }
            else{
                $imageName = 'LoanPayment-'.$loanPayment['LoanId'].'-'.$loanPayment['AccNumber'].'-'.$Timestamp.'.' . $imageFileType;
                $target_file = $target_dir . $imageName;
                move_uploaded_file($_FILES["ReceiptImage"]["tmp_name"], $target_dir . $imageName);
            }
        }

            //Update the loan Record
            $EditLoanPayment = array(
            'AmountPaid'=>$AmountPaid,
            'Balance'=>$LoanBalance,
            'PaymentDate'=>$PaymentDate,
            'PaymentReceipts'=>$target_file,
            );
            DB::update('loanpayments', $EditLoanPayment, 'Id=%s', $EditPaymentId);
            $TableId = "LP - ".$EditPaymentId;

            //Record this history
            $LoanHistory = array(
            'LoanId'=>$loanPayment['LoanId'],
            'TransactionType'=>'Loan Payment Update',
            'Amount'=>$AmountPaid,
            'AddedBy'=>$CreatedBy,
            );
            DB::insert('loanhistory', $LoanHistory);

            $NewLoanBalance = 0;
            $getAllPayments = DB::query('SELECT * from loanpayments where LoanId=%s', $loanPayment['LoanId']);
            foreach($getAllPayments as $getAllPayment){
                $NewLoanBalance = $getAllPayment['TotalAmount'] - $getAllPayment['AmountPaid'];
            }

            //Update Loan Edited Balance
            if($NewLoanBalance <= 0){
                DB::update('loanrequests', array('Balance'=> $NewLoanBalance,'Status'=>'CLEARED'), 'LoanId=%s', $loanPayment['LoanId']);
                $SMS = "Your Loan Payment of UGX".number_format($loanPayment['AmountPaid'])." to e-GP Investment Club has been updated to UGX".number_format($AmountPaid).". Your Loan is now cleared.";
            }
            else{
                DB::update('loanrequests', array('Balance'=> $NewLoanBalance,'Status'=>'OUTSTANDING'), 'LoanId=%s', $loanPayment['LoanId']);
                $SMS = "Your Loan Payment of UGX".number_format($loanPayment['AmountPaid'])." to e-GP Investment Club has been updated to UGX".number_format($AmountPaid).". and your due date is still ".$loanPayment['DueDate'];
            }

            $_SESSION['Success'] = $Member['Name']."'s Loan Payment of UGX".number_format($AmountPaid)." has been updated Successfully. Loan Balance is UGX".number_format($NewLoanBalance);
            
            //Send Member the SMS Notification.
           	SendSms(formatNumber($Member['MSISDN']), $SMS, $TableId, "SYSTEM");	
            header('Location: loanPayments.php');       
}
?>
