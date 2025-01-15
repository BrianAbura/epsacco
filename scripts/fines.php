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
/* Create a custom checkbox */
.checkmark {
  position: absolute;
  top: 0;
  left: 25px;
  height: 20px;
  width: 20px;
  background-color: #eee;
}

/* On mouse-over, add a grey background color */
.container:hover input ~ .checkmark {
  background-color: #ccc;
}

/* When the checkbox is checked, add a blue background */
.container input:checked ~ .checkmark {
  background-color: #2196F3;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the checkmark when checked */
.container input:checked ~ .checkmark:after {
  display: block;
}

/* Style the checkmark/indicator */
.container .checkmark:after {
  left: 9px;
  top: 5px;
  width: 5px;
  height: 10px;
  border: solid white;
  border-width: 0 3px 3px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
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
        	<li>
          <a href="welfare.php">
            <i class="fa fa-star"></i>
            <span>Welfare</span>
            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
          </a>
        </li> <!-- //Shares-->	

        <li class="treeview active">
          <a href="#">
             <span class="glyphicon glyphicon-piggy-bank"></span>
              <span>Savings</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="savings.php"><i class="fa fa-circle-o"></i> Savings</a></li>
            <li class="active"><a href="fines.php"><i class="fa fa-circle-o"></i> Fines</a></li>
          </ul>
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
      Fines
      <?php if($user['Role'] == 1 || $user['Role'] == 3 || $user['Role'] == 4){?>
        <button class="btn btn-primary" style="font-size:12px;cursor:pointer" data-toggle="modal" data-target="#AddNewMember">Add New <i class="fa fa-plus"></i></button>
        <?php }?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Fines</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
			 <div class="col-md-12">
			<div class="box box-primary">	
			<div class="box-body table-responsive">


      <form class="searchFilter" id="searchFilter" method="POST" action="fines.php" >
  <div class="form-row ">
    <div class="col-md-2">
      <input type="text" class="form-control datepicker" placeholder="Filter From" name="dateFrom" id="dateFrom" required autocomplete="off">
    </div>
    <div class="col-md-2">
      <input type="text" class="form-control datepicker" placeholder="Filter To" name="dateTo" id="dateTo" required autocomplete="off">
    </div>

    <div class="col-md-2">
    <button class="btn btn-primary" type="submit">Search</button> <i title="Refresh Page" onClick="location.href='fines.php'"  class="fa fa-refresh" style="margin-left:10px; color:green; font-weight:bold; cursor:pointer; font-size:16px"></i>
    </div>
  </div>
 <?php 
   if(isset($_POST['dateFrom']) && isset($_POST['dateTo'])){
     echo "<p>Data filtered from { ".date_format(date_create($_POST['dateFrom']),"d-m-Y")." to ".date_format(date_create($_POST['dateTo']),"d-m-Y")." }</p>";
   }
 ?>
</form>
        

      <img class="borderDloadImg" src="../dist/img/excel_download.png" title="Export to Excel" onclick="ExportToExcel('exportTable', 'Members Fines')"/>
            <!-- /.box-header -->
			<table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                <th>#</th>
                <th>Acc No.</th>
                <th>Name</th>
                <th>Total Fines</th>
                <th></th>
                </tr>
                </thead>
                <tbody>
			      	<?php 
                $allFines = 0;
                $cnt = 1;
                $members = DB::query('SELECT * from members where AccStatus=%s order by Name', "Active");
                foreach($members as $member){
                  $sum_fines = 0;

                  if(isset($_POST['dateFrom']) && isset($_POST['dateTo'])){
                    $dateFrom = date_format(date_create($_POST['dateFrom']),"Y-m-d");
                    $dateTo = date_format(date_create($_POST['dateTo']),"Y-m-d");
                    $fines = DB::query('SELECT * from fines where AccNumber=%s AND PaymentDate >=%s AND PaymentDate <=%s ', $member['AccNumber'], $dateFrom, $dateTo);
                  }
                  else{
                    $fines = DB::query('SELECT * from fines where AccNumber=%s', $member['AccNumber']);
                  }
                  foreach($fines as $fine){
                      $sum_fines += $fine['Amount'];
                  }
                  if(!empty($fines)){
                    ?>
                    <tr class="tr_parent">
                        <td><?php echo $cnt;?></td>    
                        <td><?php echo $member['AccNumber'];?></td>
                        <td><?php echo $member['Name'];?></td>
                        <td><?php echo number_format($sum_fines);?></td>
                        <td><label title="View More Details" href="#viewDetails" data-id="<?php echo $member['AccNumber']?>" data-toggle="modal" class="label label-warning">View</label></td>
                    </tr>
                     <?php
                     $cnt++;
                       }
                    $allFines += $sum_fines;
                      } 
                    ?>
				</tbody>
        <tfoot>
                    <tr style="font-weight:bold; font-size:14px; background-color:#D8FFE1">
                    <td colspan="2"></td>
                    <td class="text-center">Total Fines:</td>
                    <td colspan="2"><?php echo number_format($allFines);?></td>
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
                <th>Payment Date</th>
                <th>Date Added</th>
                <th></th>
                </tr>
                </thead>
                <tbody>
                    
                <?php 
                $totalFines = 0;
                $cnt = 1;
                    if(isset($_POST['dateFrom']) && isset($_POST['dateTo'])){
                      $dateFrom = date_format(date_create($_POST['dateFrom']),"Y-m-d");
                      $dateTo = date_format(date_create($_POST['dateTo']),"Y-m-d");
                      $fines = DB::query('SELECT * from fines where PaymentDate >=%s AND PaymentDate <=%s order by AccNumber', $dateFrom, $dateTo);
                    }
                    else{
                      $fines = DB::query('SELECT * from fines order by AccNumber');
                    }
                    
                    foreach($fines as $fine){
                        $member = DB::queryFirstRow('SELECT * from members where AccNumber=%s', $fine['AccNumber']);
                ?>
                <tr class="tr_parent">
                    <td><?php echo $cnt;?></td>    
                    <td><?php echo $fine['AccNumber'];?></td>
                    <td><?php echo $member['Name'];?></td>
                    <td><?php echo number_format($fine['Amount']);?></td>
                    <td><?php echo $fine['Narration'];?></td>
                    <td><?php echo date_format(date_create($fine['PaymentDate']), 'd-m-Y');?></td>
                    <td><?php echo date_format(date_create($fine['DateCreated']), 'd-m-Y');?></td>
                </tr>
                 <?php
                 $cnt++;

                $totalFines += $fine['Amount'];
                  } 
                ?>
                </tbody>
                <tfoot>
                    <tr style="font-weight:bold; font-size:14px; background-color:#D8FFE1">
                    <td></td>
                    <td></td>
                    <td class="text-center">Summary:</td>
                    <td><?php echo number_format($totalFines);?></td>
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
      <h5 class="modal-title">Add Members Fines</h5>
      </div>
      <div class="modal-body">
      <form role="form" class="form-content" method="POST" action="ManageFines.php" enctype="multipart/form-data">
      <input type="hidden" id="FineAction" name="FineAction" value="Add_New_Fines">
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
				
				<div class="form-group col-sm-5">
                <label for="narration">Narration</label>
                <input type="text" class="form-control pull-right" name="narration" id="narration" placeholder="Payment Narration" autocomplete="off" required>
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
			</div>
            </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-success">Add Fines</button>
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
            url : 'Modal_fines.php', //Here you will fetch records 
            data :  'AccNumber='+ AccNumber, //Pass $id
            success : function(data){
            $('.fetched-data').html(data);//Show fetched data from database
            }
        });
     });
});
</script>

<!-- Edit Savings Modal-->
<div class="modal fade" id="editFines">
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
    $('#editFines').on('show.bs.modal', function (e) {
      $('#viewDetails').modal('hide');
        var FinesId = $(e.relatedTarget).data('id');
        $.ajax({
            type : 'post',
            url : 'Modal_fines.php', //Here you will fetch records 
            data :  'FinesId='+ FinesId, //Pass $id
            success : function(data){
            $('.fetched-data').html(data);//Show fetched data from database
            }
        });
     });
});
</script>

<script>
  $(function () {
    //Date picker
    $('.datepicker').datepicker({
      autoclose: true,
      todayHighlight: true,
      endDate: "currentDate",
    })
  })
      //DataTables  
      $(function () {
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
