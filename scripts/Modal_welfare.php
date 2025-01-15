<?php 
require_once('../defines/functions.php');
include('headLinks.php');

if(isset($_REQUEST['WelfareId'])) { //Incase Editing Welfare
  $WelfareId = htmlspecialchars(( isset( $_REQUEST['WelfareId'] ) )?  $_REQUEST['WelfareId']: null);
  $welfare = DB::queryFirstRow('SELECT * from welfare where PaymentId=%s', $WelfareId);
  $member = DB::queryFirstRow('SELECT * from members where AccNumber=%s', $welfare['AccNumber']);
  $narration = explode(" ",$welfare['Narration']);
  $NarYear = $narration[2];
?>
<!--Edit Welfare modal-->
<div class="modal-header bg-navy color-palette">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
      <h5 class="modal-title">Edit Welfare for <?php echo $member['Name']." - ".$member['AccNumber'];?></h5>
      </div>
      <div class="modal-body">
      <form role="form" class="form-content" method="POST" action="ManageWelfare.php" enctype="multipart/form-data">
      <input type="hidden" id="WelfareAction" name="WelfareAction" value="Edit_Welfare">
      <input type="hidden" id="EditWelfareId" name="EditWelfareId" value="<?php echo $WelfareId;?>">
            <div class="box-body">
			<div class="row">
                <div class="form-group col-sm-3">
                  <label for="InputAmount">Amount</label>
                  <input type="text" class="form-control CommaAmount" id="InputAmount" name="Amount" value="<?php echo number_format($welfare['Amount'])?>" autocomplete="off" required>
                </div>
				
				
			    <div class="form-group col-sm-3">
                  <label for="SelectMod">Mode of Payment</label>
				  <select class="form-control" name="PaymentMode" id="SelectMod">
				  <option selected="selected" value="<?php echo $welfare['PaymentMode']?>"><?php echo "{".$welfare['PaymentMode']."}" ;?></option>
                  <option value="Bank Deposit">Bank Deposit</option>
				  </select>
                </div>
				
				<div class="form-group col-sm-3">
                <label for="datepicker">Narration</label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" name="NarrationYear" id="NarrationYear" value="<?php echo $NarYear;?>" autocomplete="off" required>
                </div>
              </div>

              <div class="form-group col-sm-3">
                <label for="datepicker">Payment Date</label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" name="PaymentDate" id="datepicker" value="<?php echo date_format(date_create($welfare['PaymentDate']), 'd-m-Y');?>" required>
                </div>
              </div>
			</div>
      <br/>

            <div class="row">
              <div class="form-group col-sm-3">
                <label for="InputReceipt">Receipt Number</label>
                <input type="text" class="form-control" id="InputReceipt" style="text-transform:uppercase" name="ReceiptNumber" value="<?php echo $welfare['ReceiptNumber']?>" />
              </div>

                <div class="form-group">
                <label class="col-md-6 control-label">Receipt Photo</label>
                <div class="col-md-8">
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
                        <?php echo str_replace('../fileUploads/receipts', '', $welfare['ReceiptImage']);?>
                        <p class="help-block">Accepted Formats: jpg, jpeg and png</p>
                    </div>
                    </div>
                </div>
                </div>
			</div>

            </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-success">Update Welfare Information</button>
              </div>
            </form> 
      </div>
<?php }
if(isset($_REQUEST['AccNumber'])) {
  $AccNumber = htmlspecialchars(( isset( $_REQUEST['AccNumber'] ) )?  $_REQUEST['AccNumber']: null);
  $member = DB::queryFirstRow('SELECT * from members where AccNumber=%s', $AccNumber);
?>
<div class="modal-header bg-navy color-palette">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
      <h5 class="modal-title">Welfare Collection for <?php echo $member['Name']." - ".$AccNumber;?></h5>
      </div>
      <div class="modal-body">
      <table class="table table-bordered table-hover mb-5 border-0" id="summaryTable">
          <thead>
          <tr>
              <th>#</th>
              <th>Amount</th>
              <th>Payment Mode</th>
              <th>Narration</th>
              <th>Receipt Number</th>
              <th>Receipt</th>
              <th>Payment Date</th>
              <th></th>
          </tr>
          </thead>
          <tbody>
          <?php 
          $sumWelfare = 0;
          $cnt = 1;
          $allWelfares = DB::query('SELECT * from welfare where AccNumber=%s order by DateCreated desc', $AccNumber);
          foreach($allWelfares as $allWelfare){
          ?>
          <tr>
              <td><?php echo $cnt;?></td>
              <td class="text-right"><?php echo number_format($allWelfare['Amount']);?></td>
              <td><?php echo $allWelfare['PaymentMode'];?></td>  
              <td><?php echo $allWelfare['Narration'];?></td>  
              <td><?php echo $allWelfare['ReceiptNumber'];?></td>
              <td>
                  <?php 
                    if($allWelfare['ReceiptImage'] != NULL){
                  ?>
                    <a href="#" class="pop">
                    <img class="img-responsive borderImg" src="<?php echo $allWelfare['ReceiptImage'];?>" width="30" height="50">
										</a>
                  <?php 
                    }
                    else{
                  ?>  
                    <i class="fa fa-warning" style="color:orange" title="No Attachment"></i>
										</a>
                    <?php } ?>
                </td>  
                
                
                
                <td><?php echo date_format(date_create($allWelfare['PaymentDate']), 'd-m-Y');?></td> 
              <td>
              <?php if($user['Role'] == 1 || $user['Role'] == 3 || $user['Role'] == 4){?>
                <button title="Edit Welfare Record" href="#editWelfare" data-id="<?php echo $allWelfare['PaymentId']?>" data-toggle="modal" class="btn btn-primary btn-xs">EDIT</button>
                <?php }?>
              </td>
          </tr>
          <?php 
          $sumWelfare += $allWelfare['Amount'];
          $cnt++;
              }
          ?>
          </tbody>
           <tfoot>
                    <tr style="font-weight:bold; background-color:#D8FFE1">
                    <td class="text-left">Total Welfare:</td>
                    <td colspan="1" class="text-right"><?php echo number_format($sumWelfare);?></td>
                    </tr>
                </tfoot>
        </table>

      </div>


      
  <?php 
  } 
  ?>
<!--Comma On Amounts -->
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

              

