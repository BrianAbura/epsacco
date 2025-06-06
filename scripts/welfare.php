<!DOCTYPE html>
<html>
<head>
<?php include('headLinks.php');?>
	<style>
  .form-control{
		color:blue;
	}
   .borderImg{
    border: 1px solid navy;
    width:  25px;
    height: 20px;
    object-fit: cover
   }
   .tr_parent{
    background-color: #F5F5F5;
    cursor: pointer;
}
	</style>

</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

<?php include('header.php');?>

  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">NAVIGATION</li>
        <li>
          <a href="dashboard.php">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-users"></i>
            <span>Members</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="allMembers.php"><i class="fa fa-circle-o"></i> All Members</a></li>
			      <li><a href="inactiveMembers.php"><i class="fa fa-circle-o"></i> Inactive Members</a></li>
            <li><a href="administrativeMembers.php"><i class="fa fa-circle-o"></i> Administrative Members</a></li>
          </ul>
        </li>

            <!--Investments-->	
        <li>
          <a href="Investments.php">
            <i class="fa fa-money"></i>
            <span>Investments</span>
          </a>
        </li>
    
        <!--Shares-->	
        	<li class="active treeview">
          <a href="welfare.php">
            <i class="fa fa-star"></i>
            <span>Welfare</span>
            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
          </a>
        </li> <!-- //Shares-->	

        <!--Savings-->	
        <li >
          <a href="savings.php">
          <span class="glyphicon glyphicon-piggy-bank"></span>
            <span>Savings</span>
            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
          </a>
        </li> <!-- //Savings-->	
        
      	<!--Loan Requests-->	
        <li>
          <a href="loanRequests.php">
          <span class="glyphicon glyphicon-list-alt"></span>
            <span>Loan Requests</span>
            <?php 
            if(PendingApprovals($user['Role']) != 0)
            {
            ?>
            <small class="label pull-right bg-red">
            <?php 
            echo number_format(PendingApprovals($user['Role']));
            ?>
            </small>
            <?php 
            }
            ?>
          </a>
        </li>

        <!--Loan Payments-->	
		<li>
          <a href="loanPayments.php">
          <span class="glyphicon glyphicon-list-alt"></span>
            <span>Loan Payments</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-money"></i> <span>Administrative Fees</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="bankcharges.php"><i class="fa fa-circle-o"></i> Bank Charges</a></li>
          </ul>
        </li> <!-- //Admin Fees-->
          <!-- //Notifications-->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-bell-o"></i> <span>Notifications</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="treeview"><a href="#"><i class="fa fa-circle-o"></i>
            <span>SMS</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="sms.php"><span class="glyphicon glyphicon-send"></span></i> Sent SMS</a></li>
            <li><a href="scheduledSMS.php"><span class="glyphicon glyphicon-list-alt"></span> Scheduled SMS</a></li>
          </ul>
         </li>
          </ul>
        </li><!-- //Notifications-->
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Welfare
      <?php if($user['Role'] == 1 || $user['Role'] == 3 || $user['Role'] == 4){?>
        <button class="btn btn-primary" style="font-size:12px;cursor:pointer" data-toggle="modal" data-target="#AddNewMember">Add New <i class="fa fa-plus"></i></button>
        <?php }?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Welfare</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
			 <div class="col-md-12">
			<div class="box box-primary">	
			<div class="box-body table-responsive">


      <form class="searchFilter" id="searchFilter" method="POST" action="welfare.php" >
  <div class="form-row ">
    <div class="col-md-2">
      <input type="text" class="form-control datepicker" placeholder="Filter From" name="dateFrom" id="dateFrom" required autocomplete="off">
    </div>
    <div class="col-md-2">
      <input type="text" class="form-control datepicker" placeholder="Filter To" name="dateTo" id="dateTo" required autocomplete="off">
    </div>

    <div class="col-md-2">
    <button class="btn btn-primary" type="submit">Search</button> <i title="Refresh Page" onClick="location.href='welfare.php'"  class="fa fa-refresh" style="margin-left:10px; color:green; font-weight:bold; cursor:pointer; font-size:16px"></i>
    </div>
  </div>
 <?php 
   if(isset($_POST['dateFrom']) && isset($_POST['dateTo'])){
     echo "<p>Data filtered from { ".date_format(date_create($_POST['dateFrom']),"d-m-Y")." to ".date_format(date_create($_POST['dateTo']),"d-m-Y")." }</p>";
   }
 ?>
</form>
        

      <img class="borderDloadImg" src="../dist/img/excel_download.png" title="Export to Excel" onclick="ExportToExcel('exportTable', 'Members Welfare')"/>
            <!-- /.box-header -->
			<table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                <th>#</th>
                <th>Acc No.</th>
                <th>Name</th>
                <th>Total Welfare Saved</th>
                <th></th>
                </tr>
                </thead>
                <tbody>
			      	<?php 
                $allWelfare = 0;
                $cnt = 1;
                $members = DB::query('SELECT * from members where AccStatus=%s order by Name', "Active");
                foreach($members as $member){
                  $sum_welfare = 0;

                  if(isset($_POST['dateFrom']) && isset($_POST['dateTo'])){
                    $dateFrom = date_format(date_create($_POST['dateFrom']),"Y-m-d");
                    $dateTo = date_format(date_create($_POST['dateTo']),"Y-m-d");
                    $welfares = DB::query('SELECT * from welfare where AccNumber=%s AND PaymentDate >=%s AND PaymentDate <=%s ', $member['AccNumber'], $dateFrom, $dateTo);
                  }
                  else{
                    $welfares = DB::query('SELECT * from welfare where AccNumber=%s', $member['AccNumber']);
                  }
                  foreach($welfares as $welfare){
                      $sum_welfare += $welfare['Amount'];
                  }
                  if(!empty($welfares)){
                    ?>
                    <tr class="tr_parent">
                        <td><?php echo $cnt;?></td>    
                        <td><?php echo $member['AccNumber'];?></td>
                        <td><?php echo $member['Name'];?></td>
                        <td><?php echo number_format($sum_welfare);?></td>
                        <td><label title="View More Details" href="#viewDetails" data-id="<?php echo $member['AccNumber']?>" data-toggle="modal" class="label label-warning">View</label></td>
                    </tr>
                     <?php
                     $cnt++;
                       }
                    $allWelfare += $sum_welfare;
                      } 
                    ?>
				</tbody>
        <tfoot>
                    <tr style="font-weight:bold; font-size:14px; background-color:#D8FFE1">
                    <td colspan="2"></td>
                    <td class="text-center">Total Welfare:</td>
                    <td colspan="2"><?php echo number_format($allWelfare);?></td>
                    </tr>
                </tfoot>
			</table>

<!--Export Table Hidden-->
<table id="exportTable" class="table table-bordered hidden">
                <thead>
                <tr>
                <th>#</th>
                <th>Acc No.</th>
                <th>Name</th>
                <th>Amount</th>
                <th>Narration</th>
                <th>Payment Mode</th>
                <th>Payment Date</th>
                <th>Date Added</th>
                <th></th>
                </tr>
                </thead>
                <tbody>
                    
                <?php 
                $totalWelfare = 0;
                $cnt = 1;
                    if(isset($_POST['dateFrom']) && isset($_POST['dateTo'])){
                      $dateFrom = date_format(date_create($_POST['dateFrom']),"Y-m-d");
                      $dateTo = date_format(date_create($_POST['dateTo']),"Y-m-d");
                      $welfares = DB::query('SELECT * from welfare where PaymentDate >=%s AND PaymentDate <=%s order by AccNumber', $dateFrom, $dateTo);
                    }
                    else{
                      $welfares = DB::query('SELECT * from welfare order by AccNumber');
                    }
                    
                    foreach($welfares as $welfare){
                        $member = DB::queryFirstRow('SELECT * from members where AccNumber=%s', $welfare['AccNumber']);
                ?>
                <tr class="tr_parent">
                    <td><?php echo $cnt;?></td>    
                    <td><?php echo $welfare['AccNumber'];?></td>
                    <td><?php echo $member['Name'];?></td>
                    <td><?php echo number_format($welfare['Amount']);?></td>
                    <td><?php echo $welfare['Narration'];?></td>
                    <td><?php echo $welfare['PaymentMode'];?></td>
                    <td><?php echo date_format(date_create($welfare['PaymentDate']), 'd-m-Y');?></td>
                    <td><?php echo date_format(date_create($welfare['DateCreated']), 'd-m-Y');?></td>
                </tr>
                 <?php
                 $cnt++;

                $totalWelfare += $welfare['Amount'];
                  } 
                ?>
                </tbody>
                <tfoot>
                    <tr style="font-weight:bold; font-size:14px; background-color:#D8FFE1">
                    <td></td>
                    <td></td>
                    <td class="text-center">Summary:</td>
                    <td><?php echo number_format($totalWelfare);?></td>
                    </tr>
                </tfoot>
                </table>
                <!--Export Table Hidden-->

          </div>
          </div>
          <!-- /.box -->
			 </div>


      </div>
      <!-- /.row -->
      <!-- Main row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Add New Admin MOdal-->
<div class="modal fade" id="AddNewMember">
<div class="modal-dialog modal-lg ">
<div class="modal-content ">

<div class="modal-header bg-navy color-palette">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
      <h5 class="modal-title">Add Members Welfare</h5>
      </div>
      <div class="modal-body">
      <form role="form" class="form-content" method="POST" action="ManageWelfare.php" enctype="multipart/form-data">
      <input type="hidden" id="WelfareAction" name="WelfareAction" value="Add_New_Welfare">
            <div class="box-body">
			<div class="row">
                <div class="form-group col-sm-3">
                <label for="SelectMem">Member</label>
                <select class="form-control" name="AccNumber" id="AccNumber" required>
                <option></option>
                <?php 
                $members = DB::query('SELECT * from members where AccStatus=%s order by Name', 'Active');
                foreach($members as $member){
                ?>
                <option value="<?php echo $member['AccNumber'];?>"><?php echo $member['Name'];?></option>
                <?php }?>
                </select>
                </div>

                <div class="form-group col-sm-3">
                  <label for="InputAmount">Amount</label>
                  <input type="text" class="form-control CommaAmount" id="InputAmount" name="Amount" placeholder="Enter Amount" autocomplete="off" required>
                </div>
				
				
			    <div class="form-group col-sm-3">
                  <label for="SelectMod">Mode of Saving</label>
				  <select class="form-control" name="PaymentMode" id="SelectMod">
				  <option value="Bank Deposit">Bank Deposit</option>
				  </select>
                </div>
				
				<div class="form-group col-sm-3">
                <label for="datepicker">Payment Narration</label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" name="NarrationYear" id="NarrationYear" placeholder="Select Year" autocomplete="off" required>
                </div>
              </div>
			</div>
      <br/>

            <div class="row">				
				<div class="form-group col-sm-3">
                <label for="datepicker">Payment Date</label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right datepicker" name="PaymentDate" autocomplete="off" required>
                </div>
              </div>

              <div class="form-group col-sm-3">
                <label for="InputReceipt">Receipt Number</label>
                <input type="text" class="form-control" id="InputReceipt" style="text-transform:uppercase" name="ReceiptNumber" autocomplete="off" />
              </div>

                <div class="form-group">
                <label class="col-md-4 control-label">Receipt Photo</label>
                <div class="col-md-6">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                    <div class="input-append">
                        <div class="uneditable-input">
                        <span class="fileupload-preview" style="font-size: 12px; color:blue"></span>
                        </div>
                        <span class="btn btn-default btn-file">
                        <span class="fileupload-exists">Change</span>
                        <span class="fileupload-new">Select file</span>
                        <input type="file" id="InputReceiptImg" name="ReceiptImage" onchange="ValidateSingleInput(this);" required/>
                        </span>
                        <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
                        <p class="help-block">Accepted Formats: jpg, jpeg and png</p>
                    </div>
                    </div>
                </div>
                </div>

			</div>

            </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-success">Add Welfare</button>
                <button type="reset" class="btn btn-default">Reset</button>
              </div>
            </form> 
      </div>
  
  <div class="modal-footer">
    <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Close</button>
  </div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
    <!-- End of Modal for loan request summary-->
<?php include('externalScripts.php');?>
<!-- View More Details-->
<div class="modal fade" id="viewDetails">
    <div class="modal-dialog modal-lg" style="width: 80%">
    <div class="modal-content ">
    <div class="fetched-data"></div> <!--Fetched Header and body-->
      
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Close</button>
      </div>
    </div>
    <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <script>
$(document).ready(function(){
    $('#viewDetails').on('show.bs.modal', function (e) {
        var AccNumber = $(e.relatedTarget).data('id');
        $.ajax({
            type : 'post',
            url : 'Modal_welfare.php', //Here you will fetch records 
            data :  'AccNumber='+ AccNumber, //Pass $id
            success : function(data){
            $('.fetched-data').html(data);//Show fetched data from database
            }
        });
     });
});
</script>

<!-- Edit Savings Modal-->
<div class="modal fade" id="editWelfare">
    <div class="modal-dialog modal-lg">
    <div class="modal-content ">

    <div class="fetched-data"></div> <!--Fetched Header and body-->
      
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Close</button>
      </div>
    </div>
    <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <script>
$(document).ready(function(){
    $('#editWelfare').on('show.bs.modal', function (e) {
      $('#viewDetails').modal('hide');
        var WelfareId = $(e.relatedTarget).data('id');
        $.ajax({
            type : 'post',
            url : 'Modal_welfare.php', //Here you will fetch records 
            data :  'WelfareId='+ WelfareId, //Pass $id
            success : function(data){
            $('.fetched-data').html(data);//Show fetched data from database
            }
        });
     });
});
</script>

<div class="modal fade" id="imagemodal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
  <div class="modal-content">              
    <div class="modal-body">
      <button type="button" class="close" data-dismiss="modal"><span style="color:red" aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      <img src="" class="imagepreview" style="width: 100%;">
    </div>
  </div>
</div>
</div>


<!--/View the Welfare  Summary-->
<div class="modal fade" id="viewOutstandingWelfare">
	  <div class="modal-dialog modal-lg">
		<div class="modal-content">
		  <div class="modal-header bg-blue">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span></button>
			<h5 class="modal-title">Summary of Members Savings</h5>
		  </div>
		
			<div class="modal-body">
				<table id="example4" class="table table-bordered">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Acc No.</th>
                  <th>Name</th>
                  <th>Expected Savings</th>
                  <th>Current Savings</th>
                  <th>Outstanding Savings</th>
                </tr>
                </thead>
                <tbody>
				<?php
				$cnt=1;
        $sumExpected = 0;
        $sumCurrent = 0;
        $sumOutstanding = 0;
				$members = DB::query('SELECT * from members where AccStatus=%s order by Name', 'Active');
				foreach($members as $member){
					$expectedSaving = ExpectedMemberSavings($member['AccNumber']);
          $currentSaving = MembersumSavings($member['AccNumber']);
          $outstandingSaving = $expectedSaving - $currentSaving;

            if($outstandingSaving < 0){
              
              $sumOutstanding -= $outstandingSaving;
              $val = "+".number_format(-$outstandingSaving);
            }
            else{
              $val = number_format($outstandingSaving);
            }
          
				?>
				 <tr>
                  <td><?php echo $cnt;?></td>
                  <td><?php echo $member['AccNumber'];?></td>
                  <td><?php echo $member['Name'];?></td>
                  <td><?php echo number_format($expectedSaving);?></td>
                  <td><?php echo number_format($currentSaving);?></td>
                  <td <?php if($outstandingSaving > 0){echo 'style="color:maroon"';} elseif($outstandingSaving < 0){echo 'style="color:green"';}?>><?php echo $val;?></td>
                </tr>
				<?php 
				$cnt++;
        $sumExpected += $expectedSaving;
        $sumCurrent += $currentSaving;
        $sumOutstanding += $outstandingSaving;
				}
				?>
				</tbody>
          <tfoot>
            <tr style="font-weight:bold; font-size:14px; background-color:#D8FFE1">
            <td></td>
            <td></td>
            <td>Summary: </td>
            <td><?php echo number_format($sumExpected);?></td>
            <td><?php echo number_format($sumCurrent);?></td>
            <td><?php echo number_format($sumOutstanding);?></td>
            </tr>
          </tfoot>
			</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Close</button>
			</div>
		</div>
		<!-- /.modal-content -->
	  </div>
	  <!-- /.modal-dialog -->
</div>



<script>
  $(function () {
    //Date picker
    $('.datepicker').datepicker({
      autoclose: true,
      todayHighlight: true,
      endDate: "currentDate",
    })
  })

    //NarrationMonth
    $(function () {
    //Date picker
    $('#NarrationMonth').datepicker({
      autoclose: true,
	  minViewMode: 1,
	  format: "MM",
    })
  })
  //NarrationYear
   $(function () {
    //Date picker
    $('#NarrationYear').datepicker({
      autoclose: true,
	  minViewMode: 2,
	  format: "yyyy",
	  minDate: new Date(),
    })

  })

    //DataTables  
    $(function () {
    $('#summaryTable').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': [true],
      'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
</body>
</html>
