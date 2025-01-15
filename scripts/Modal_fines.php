<?php 
require_once('../defines/functions.php');
include('headLinks.php');

if(isset($_REQUEST['FinesId'])) { //Incase Editing Fines
$FinesId = htmlspecialchars(( isset( $_REQUEST['FinesId'] ) )?  $_REQUEST['FinesId']: null);
$Fine = DB::queryFirstRow('SELECT * from fines where Id=%s', $FinesId);
$member = DB::queryFirstRow('SELECT * from members where AccNumber=%s', $Fine['AccNumber']);
?>
<!--Edit Fines modal-->
<div class="modal-header bg-navy color-palette">
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span></button>
<h5 class="modal-title">Edit Fines for <?php echo $member['Name']." - ".$member['AccNumber'];?></h5>
</div>
<div class="modal-body">
<form role="form" class="form-content" method="POST" action="ManageFines.php" enctype="multipart/form-data">
<input type="hidden" id="FineAction" name="FineAction" value="Edit_Fine">
<input type="hidden" id="editFinesId" name="editFinesId" value="<?php echo $FinesId;?>">
    <div class="box-body">
<div class="row">
        <div class="form-group col-sm-3">
          <label for="InputAmount">Amount</label>
          <input type="text" class="form-control CommaAmount" id="InputAmount" name="Amount" value="<?php echo number_format($Fine['Amount'])?>" autocomplete="off" required>
        </div>

<div class="form-group col-sm-5">
        <label for="narration">Narration</label>
        <input type="text" class="form-control pull-right" name="narration" id="narration" value="<?php echo $Fine['Narration']?>" autocomplete="off" required>
      </div>

      <div class="form-group col-sm-3">
        <label for="datepicker">Payment Date</label>
        <div class="input-group date">
          <div class="input-group-addon">
            <i class="fa fa-calendar"></i>
          </div>
          <input type="text" class="form-control pull-right" name="PaymentDate" id="datepicker" value="<?php echo date_format(date_create($Fine['PaymentDate']), 'd-m-Y');?>" required>
        </div>
      </div>
</div>
    </div>
      <!-- /.box-body -->

      <div class="box-footer">
        <button type="submit" class="btn btn-success">Update Information</button>
      </div>
    </form> 
</div>
<?php }
if(isset($_REQUEST['AccNumber'])) {
$AccNumber = htmlspecialchars(( isset( $_REQUEST['AccNumber'] ) )?  $_REQUEST['AccNumber']: null);
$member = DB::queryFirstRow('SELECT * from members where AccNumber=%s', $AccNumber);
?>
<div class="modal-header bg-success color-palette">
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span></button>
<h5 class="modal-title">Summary of Fines for <?php echo $member['Name']." - ".$AccNumber;?></h5>
</div>
<div class="modal-body">
<table class="table table-bordered table-hover mb-5 border-0" id="summaryTable">
  <thead>
  <tr>
      <th>#</th>
      <th>Amount</th>
      <th>Narration</th>
      <th>Payment Date</th>
      <th></th>
  </tr>
  </thead>
  <tbody>
  <?php 
  $sumFines = 0;
  $cnt = 1;
  $allFines = DB::query('SELECT * from fines where AccNumber=%s order by DateCreated desc', $AccNumber);
  foreach($allFines as $allFine){
  ?>
  <tr>
      <td><?php echo $cnt;?></td>
      <td class="text-right"><?php echo number_format($allFine['Amount']);?></td> 
      <td><?php echo $allFine['Narration'];?></td>  
      <td><?php echo date_format(date_create($allFine['PaymentDate']), 'd-m-Y');?></td> 
      <td>
      <?php if($user['Role'] == 1 || $user['Role'] == 3 || $user['Role'] == 4){?>
        <button title="Edit Fines Record" href="#editFines" data-id="<?php echo $allFine['Id']?>" data-toggle="modal" class="btn btn-primary btn-xs">EDIT</button>
        <?php }?>
      </td>
  </tr>
  <?php 
  $sumFines += $allFine['Amount'];
  $cnt++;
      }
  ?>
  </tbody>
    <tfoot>
            <tr style="font-weight:bold; background-color:#D8FFE1">
            <td class="text-left">Total Fines:</td>
            <td colspan="1" class="text-right"><?php echo number_format($sumFines);?></td>
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

//DataTables  
$(function () {
$('#summaryTable').DataTable({
'ordering'    : false,
'info'        : false,
})
})

</script>

      

