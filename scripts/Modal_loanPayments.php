<?php 
require_once('../defines/functions.php');
include('headLinks.php');

if(isset($_REQUEST['loanPaymentId'])) { 
  $Id = htmlspecialchars(( isset( $_REQUEST['loanPaymentId'] ) )?  $_REQUEST['loanPaymentId']: null);
  $loanPayment = DB::queryFirstRow('SELECT * from loanpayments where Id=%s', $Id);
  $member = DB::queryFirstRow('SELECT * from members where AccNumber=%s', $loanPayment['AccNumber']);
?>
<!--Edit Savings modal-->
<div class="modal-header bg-navy color-palette">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
        <h5 class="modal-title">Edit Loan Payment for <?php echo $member['Name']." - ".$member['AccNumber']." { Loan ID - ".$loanPayment['LoanId']." }";?></h5>
      </div>
      <div class="modal-body">
      <form role="form" class="form-content" method="POST" action="ManageLoanPayments.php" enctype="multipart/form-data">
      <input type="hidden" value="EDIT" name="lnPaymentAction">
      <input type="hidden" value="<?php echo $loanPayment['Id'];?>" name="loanPaymentId">
            <div class="box-body">
			<div class="row">
                <div class="form-group col-sm-3">
                <label for="Amount">Loan Type</label>
                <input type="text" class="form-control" value="<?php echo $loanPayment['LoanType'];?>" readonly />
              </div>

                <div class="form-group col-sm-3">
                <label for="Balance">Loan Amount</label>
                <input type="text" class="form-control" value="<?php echo number_format($loanPayment['TotalAmount']);?>" name="LoanBalance" readonly />
                </div>

               <div class="form-group col-sm-3">
                  <label for="Amount">Amount Paid</label>
                  <input type="text" class="form-control CommaAmount" id="InputAmount" name="Amount" value="<?php echo number_format($loanPayment['AmountPaid']);?>" required autocomplete="off"/>
                </div>

                <div class="form-group col-sm-3">
                <label for="Amount">Payment Date</label>
                <input type="text" class="form-control" name="PaymentDate" id="datepicker" required autocomplete="off" value="<?php echo date_format(date_create($loanPayment['PaymentDate']), 'd-m-Y');?>" />
                </div>
			</div>
      <hr/>
      <div class="row">
                <div class="form-group">
                <label class="col-md-4 control-label">Upload Payment Receipt</label>
                <div class="col-md-12">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                    <div class="input-append">
                        <div class="uneditable-input">
                        <span class="fileupload-preview" style="font-size: 12px; color:blue"></span>
                        </div>
                        <span class="btn btn-default btn-file">
                        <span class="fileupload-exists">Change</span>
                        <span class="fileupload-new">Select file</span>
                        <input type="file" id="InputReceiptImg" name="ReceiptImage" onchange="ValidateSingleInput(this);"/>
                        </span>
                        <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
                        <?php echo str_replace('../fileUploads/receipts', '', $loanPayment['PaymentReceipts']);?>
                        <p class="help-block">Accepted Formats: jpg, jpeg and png</p>
                    </div>
                    </div>
                </div>
                </div> 
			</div>
      <hr/>
            </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-success">Update Loan Payment Record</button>
              </div>
            </form>
      </div>
      <!--Comma On Amounts -->
<?php 
}
if(isset($_REQUEST['AccNumber'])) {
  $AccNumber = htmlspecialchars(( isset( $_REQUEST['AccNumber'] ) )?  $_REQUEST['AccNumber']: null);
  $member = DB::queryFirstRow('SELECT * from members where AccNumber=%s', $AccNumber);
?>

<div class="modal-header bg-navy color-palette">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
      <h5 class="modal-title">Loan Payments Summary for <?php echo $member['Name']." - ".$AccNumber;?></h5>
      </div>
      <div class="modal-body">
      <table class="table table-bordered table-hover mb-5 border-0" id="summaryTable">
          <thead>
          <tr>
              <th>#</th>
              <th>Loan ID</th>
              <th>Loan Type</th>
              <th>Loan Amount</th>
              <th>Installment Paid</th>
              <th>Current Balance</th>
              <th>Payment Receipt</th>
              <th>Payment Date</th>
              <th></th>
          </tr>
          </thead>
          <tbody>
          <?php 
          $sumLoanPayments = 0;
          $cnt = 1;
          $allLoanPayments = DB::query('SELECT * from loanpayments where AccNumber=%s order by DateAdded desc', $AccNumber);
          foreach($allLoanPayments as $allLoanPayment){
          ?>
          <tr>
              <td><?php echo $cnt;?></td>
              <td><?php echo $allLoanPayment['LoanId'];?></td> 
              <td><?php echo $allLoanPayment['LoanType'];?></td> 
              <td class="text-right"><?php echo number_format($allLoanPayment['TotalAmount']);?></td>
              <td class="text-right"><?php echo number_format($allLoanPayment['AmountPaid']);?></td>
              <td class="text-right"><?php echo number_format($allLoanPayment['Balance']);?></td> 
              <td>
                  <?php 
                    if($allLoanPayment['PaymentReceipts'] != NULL){
                  ?>
                    <a href="#" class="pop">
                    <img class="img-responsive borderImg" src="<?php echo $allLoanPayment['PaymentReceipts'];?>" width="30" height="50">
										</a>
                  <?php 
                    }
                    else{
                  ?>  
                    <i class="fa fa-warning" style="color:orange" title="No Attachment"></i>
										</a>
                    <?php } ?>
                </td> 
                <td><?php echo date_format(date_create($allLoanPayment['PaymentDate']), 'd-m-Y');?></td> 
              <td>
              <?php if($user['Role'] == 1 || $user['Role'] == 3 || $user['Role'] == 4){?>
                <button title="Edit Payment Record" href="#editLoanPayment" data-id="<?php echo $allLoanPayment['Id']?>" data-toggle="modal" class="btn btn-primary btn-xs">EDIT</button>
                <?php }?>
              </td>
          </tr>
          <?php 
          $sumLoanPayments += $allLoanPayment['AmountPaid'];
          $cnt++;
              }
          ?>
          </tbody>
           <tfoot>
                    <tr style="font-weight:bold; background-color:#D8FFE1">
                    <td></td>
                    <td></td>
                    <td colspan="2" class="text-left">Total Amount Paid in Loans:</td>
                    <td colspan="1" class="text-right"><?php echo number_format($sumLoanPayments);?></td>
                    </tr>
                </tfoot>
        </table>

      </div>

<?php } ?>

<script>
$('.CommaAmount').keyup(function(event) {
  if(event.which >= 37 && event.which <= 40) return;
  // format number
  $(this).val(function(index, value) {
    return value
    .replace(/\D/g, "")
    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    ;
  });
});

$(function () {
    //Date picker
    $('#datepicker').datepicker({
      autoclose: true,
      todayHighlight: true,
      endDate: "currentDate",
    })
  })

  
$(function() {
		$('.pop').on('click', function() {
			$('.imagepreview').attr('src', $(this).find('img').attr('src'));
			$('#imagemodal').modal('show');   
		});		
});

    //DataTables  
    $(function () {
    $('#summaryTable').DataTable({
      'ordering'    : false,
      'info'        : false,
    })
  })
</script>