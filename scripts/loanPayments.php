<!DOCTYPE html>
<html>
<head>
<?php include('headLinks.php');?>
	<style>
  .form-control{
		color:blue;
	}
  .tr_parent{
    background-color: #F5F5F5;
    cursor: pointer;
}
   .borderImg{
    border: 1px solid navy;
    width:  25px;
    height: 20px;
    object-fit: cover
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

        <!--Savings-->	
        <li>
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
		<li class="active treeview">
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
      Loan Payments
      <?php if($user['Role'] == 1 || $user['Role'] == 3 || $user['Role'] == 4){?>
        <button class="btn btn-primary" style="font-size:12px;cursor:pointer" data-toggle="modal" data-target="#AddNewTransaction">Add New <i class="fa fa-plus"></i></button>
        <?php } ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Loan Payments</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
			 <div class="col-md-12">
			<div class="box box-success">	
			<div class="box-body table-responsive">

      <form class="searchFilter" id="searchFilter" method="POST" action="loanPayments.php" >
  <div class="form-row ">
    <div class="col-md-2">
      <input type="text" class="form-control datepicker" placeholder="Filter From" name="dateFrom" id="dateFrom" required autocomplete="off">
    </div>
    <div class="col-md-2">
      <input type="text" class="form-control datepicker" placeholder="Filter To" name="dateTo" id="dateTo" required autocomplete="off">
    </div>

    <div class="col-md-2">
    <button class="btn btn-primary" type="submit">Search</button> <i title="Refresh Page" onClick="location.href='loanPayments.php'"  class="fa fa-refresh" style="margin-left:10px; color:green; font-weight:bold; cursor:pointer; font-size:16px"></i>
    </div>
  </div>
 <?php 
   if(isset($_POST['dateFrom']) && isset($_POST['dateTo'])){
     echo "<p>Data filtered from { ".date_format(date_create($_POST['dateFrom']),"d-m-Y")." to ".date_format(date_create($_POST['dateTo']),"d-m-Y")." }</p>";
   }
 ?>
</form>
        

      <img class="borderDloadImg" src="../dist/img/excel_download.png" title="Export to Excel" onclick="ExportToExcel('exportTable', 'Loan Payments')"/>  
            <!-- /.box-header -->
			<table id="example1" class="table table-striped table-bordered">
            <thead>
                <tr>
                  <th>#</th>
                  <th>Acc No.</th>
                  <th>Name</th>
                  <th>Amount Paid in Loans</th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
			      	<?php 
                $allLoans = 0;
                $cnt = 1;
                $members = DB::query('SELECT * from members order by Name');
                foreach($members as $member){
                  $sum_loanpayments = 0;
                  if(isset($_POST['dateFrom']) && isset($_POST['dateTo'])){
                    $dateFrom = date_format(date_create($_POST['dateFrom']),"Y-m-d");
                    $dateTo = date_format(date_create($_POST['dateTo']),"Y-m-d");
                    $loanpayments = DB::query('SELECT * from loanpayments where AccNumber=%s AND PaymentDate >=%s AND PaymentDate <=%s ', $member['AccNumber'], $dateFrom, $dateTo);
                  }
                  else{
                    $loanpayments = DB::query('SELECT * from loanpayments where AccNumber=%s', $member['AccNumber']);
                  }

                  foreach($loanpayments as $loanpayment){
                      $sum_loanpayments += $loanpayment['AmountPaid'];
                  }
                  if(!empty($loanpayments)){
                    ?>
                    <tr class="tr_parent">
                        <td><?php echo $cnt;?></td>    
                        <td><?php echo $member['AccNumber'];?></td>
                        <td><?php echo $member['Name'];?></td>
                        <td><?php echo number_format($sum_loanpayments);?></td>
                        <td><label title="View More Details" href="#viewDetails" data-id="<?php echo $member['AccNumber']?>" data-toggle="modal" class="label label-warning">View</label></td>
                    </tr>
                     <?php
                     $cnt++;
                       }
                    $allLoans += $sum_loanpayments;
                      } 
                    ?>
				          </tbody>
                  <tfoot>
                    <tr style="font-weight:bold; font-size:14px; background-color:#D8FFE1">
                    <td colspan="2"></td>
                    <td class="text-center">Total Loans Paid:</td>
                    <td colspan="2"><?php echo number_format($allLoans);?></td>
                    </tr>
                </tfoot>
			</table>

<!--Export Table Hidden-->
<table id="exportTable" class="table table-bordered hidden">
                <thead>
                <tr>
                <th>#</th>
                <th>LoanID</th>
                <th>AccNum</th>
                <th>Name</th>
                <th>Amount Paid</th>
                <th>PaymentMode</th>
                <th>Payment Date </th>
                <th>Date Added</th>
                </tr>
                </thead>
                <tbody>
                    
                <?php 
                $totalLoanPayments = 0;
                $cnt = 1;
                    if(isset($_POST['dateFrom']) && isset($_POST['dateTo'])){
                      $dateFrom = date_format(date_create($_POST['dateFrom']),"Y-m-d");
                      $dateTo = date_format(date_create($_POST['dateTo']),"Y-m-d");
                      $loanpayments = DB::query('SELECT * from loanpayments where PaymentDate >=%s AND PaymentDate <=%s order by LoanId', $dateFrom, $dateTo);
                    }
                    else{
                      $loanpayments = DB::query('SELECT * from loanpayments order by LoanId');
                    }
                    
                    foreach($loanpayments as $loanpayment){
                        $member = DB::queryFirstRow('SELECT * from members where AccNumber=%s', $loanpayment['AccNumber']);
                ?>
                <tr class="tr_parent">
                    <td><?php echo $cnt;?></td>    
                    <td><?php echo $loanpayment['LoanId'];?></td>
                    <td><?php echo $loanpayment['AccNumber'];?></td>
                    <td><?php echo $member['Name'];?></td>
                    <td><?php echo number_format($loanpayment['AmountPaid']);?></td>
                    <td><?php echo $loanpayment['PaymentMode'];?></td>
                    <td><?php echo date_format(date_create($loanpayment['PaymentDate']), 'd-m-Y');?></td>
                    <td><?php echo date_format(date_create($loanpayment['DateAdded']), 'd-m-Y');?></td>
                </tr>
                 <?php
                 $cnt++;

                $totalLoanPayments += $loanpayment['AmountPaid'];
                  } 
                ?>
                </tbody>
                <tfoot>
                    <tr style="font-weight:bold; font-size:14px; background-color:#D8FFE1">
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-center">Total Loan Payments:</td>
                    <td><?php echo number_format($totalLoanPayments);?></td>
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
<div class="modal fade" id="AddNewTransaction">
<div class="modal-dialog modal-lg ">
<div class="modal-content ">

<div class="modal-header bg-green color-palette">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
      <h5 class="modal-title">Add Loan Payment</h5>
      </div>
      <div class="modal-body">
      <form role="form" class="form-content" method="POST" action="ManageLoanPayments.php" enctype="multipart/form-data">
      <input type="hidden" value="ADD" name="lnPaymentAction">
            <div class="box-body">
			<div class="row">
                <div class="form-group col-sm-3">
                <label for="SelectMem">Member</label>
                <select class="form-control" name="AccNumber" id="AccNumber" required>
              <option></option>
              <?php 
              $loans = DB::query('SELECT AccNumber from loanrequests where Status=%s group by AccNumber', 'OUTSTANDING');
              #$loans = DB::query('SELECT * from loanrequests where Status=%s', 'OUTSTANDING');
              foreach($loans as $loan){
                $member = DB::queryFirstRow('SELECT * from members where AccNumber=%s order by Name', $loan['AccNumber']);
                ?>
                <option value="<?php echo $member['AccNumber'];?>"><?php echo $member['Name'];?></option>
                <?php }?>
                </select>
                </div>

                <div class="form-group col-sm-3">
                <label for="Amount">Loan Type</label>
                <select class="form-control" id="LoanType" name="LoanType" required >
                <option></option>
                <option value="Main">Main Loan</option>
				        <option value="Top-Up">Top-Up</option>
                </select>
              </div>

                <div class="form-group col-sm-3">
                <label for="Balance">Loan Balance</label>
                <input type="text" class="form-control " id="LoanBalance" name="LoanBalance" readonly />
                </div>

               <div class="form-group col-sm-3">
                  <label for="Amount">Amount Paid</label>
                  <input type="text" class="form-control CommaAmount" id="InputAmount" name="Amount" placeholder="Enter Amount" required autocomplete="off"/>
                </div>
			</div>
      <hr/>

      <div class="row">
      <div class="form-group col-sm-3">
                <label for="Amount">Payment Date</label>
                <input type="text" class="form-control datepicker" name="PaymentDate" required autocomplete="off" />
                </div>

                <div class="form-group">
                <label class="col-md-4 control-label">Upload Payment Receipt</label>
                <div class="col-md-6">
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
                <button type="submit" class="btn btn-success">Add Loan Payment</button>
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
    <div class="modal-dialog modal-lg" style="width: 90%">
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
            url : 'Modal_loanPayments.php', //Here you will fetch records 
            data :  'AccNumber='+ AccNumber, //Pass $id
            success : function(data){
            $('.fetched-data').html(data);//Show fetched data from database
            }
        });
     });
});
</script>

<!-- Edit Savings Modal-->
<div class="modal fade" id="editLoanPayment">
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
    $('#editLoanPayment').on('show.bs.modal', function (e) {
      $('#viewDetails').modal('hide');
        var loanPaymentId = $(e.relatedTarget).data('id');
        $.ajax({
            type : 'post',
            url : 'Modal_loanPayments.php', //Here you will fetch records 
            data :  'loanPaymentId='+ loanPaymentId, //Pass $id
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

<script>
  $(function () {
    //Date picker
    $('.datepicker').datepicker({
      autoclose: true,
      todayHighlight: true,
      endDate: "currentDate",
    })
  })
  
    $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
<script>
//Get the Loan Balance//
function commaSeparateNumber(val){
    while (/(\d+)(\d{3})/.test(val.toString())){
      val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
    }
    return val;
  }

var AccNumber = document.getElementById("AccNumber");
var LoanType = document.getElementById("LoanType");
var LoanBalance = document.getElementById("LoanBalance");

function getBalance(){
  var hr = new XMLHttpRequest();
  var url = "GetLoanBalance.php";
	//Post to file without refreshing page
    var vars = "AccNumber="+AccNumber.value+"&LoanType="+LoanType.value;
    hr.open("POST", url, true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function() {
	    if(hr.readyState == 4 && hr.status == 200) {
		  var return_data = hr.responseText;
      if(return_data == ""){
        LoanBalance.value = "0";
        $(":submit").attr("disabled", true);
      }
      else{
        LoanBalance.value = commaSeparateNumber(return_data);
        $(":submit").removeAttr("disabled");
      }
		}	}
    hr.send(vars);
}

LoanType.onchange = function(){
  getBalance();
}
AccNumber.onchange = function(){
  getBalance();
}
</script>
</body>
</html>
