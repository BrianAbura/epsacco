<!DOCTYPE html>
<html>
<head>
<?php include('headLinks.php');?>
	<style>
	.table-striped>tbody>tr:nth-child(even)>td, 
	.table-striped>tbody>tr:nth-child(even)>th {
	   background-color: #c8f9d3;
	 }
   .text-muted{
     padding-bottom: 3px;
     color:royalblue;
   }
   .form-control{
		color:blue;
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
        <li class="treeview active">
          <a href="#">
            <i class="fa fa-users"></i>
            <span>Members</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="active"><a href="allMembers.php"><i class="fa fa-circle-o"></i> All Members</a></li>
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
          Profile
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Member Profile</li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="row">
          <?php
          $AccNumber = $_GET['AccNumber'];
          $member = DB::queryFirstRow('SELECT * from members where AccNumber=%s', $AccNumber);
          ?>
          <div class="col-md-3">
            <!-- Profile Image -->
            <div class="box box-primary">
              <div class="box-body box-profile">
                <img class="profile-user-img img-responsive" src="<?php echo $member['ProfilePicture']; ?>" alt="User profile picture">
                <h4 class="text-center"><?php echo $member['Fullname'] . "<br/> " . $member['AccNumber']; ?></h3>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->


            <div class="box box-primary">
              <!-- /.box-header -->
              <div class="box-body">
                <strong><i class="fa fa-calendar"></i> Date Joined</strong>
                <p class="text-muted">
                  <?php echo date_format(date_create($member['Joining_date']), 'd-M-Y'); ?>
                </p>

                <strong><i class="fa fa-phone"></i> Mobile</strong>
                <p class="text-muted">
                  <?php echo $member['MSISDN']; ?>
                </p>

                <strong><i class="fa fa-globe"></i> Email</strong>
                <p class="text-muted">
                  <?php echo $member['EmailAddress']; ?>
                </p>


                <strong><i class="fa fa-calendar"></i> Last Update</strong>
                <p class="text-muted">
                  <?php echo date_format(date_create($member['DateUpdated']), 'd-M-Y H:i'); ?>
                </p>
                <br />
                <?php if ($user['Role'] == 1) { ?>
                  <strong><i class="fa fa-gear margin-r-5"></i> Actions</strong>
                  <p>
                    <a title="Edit Member Profile" href="#editMember" data-id="<?php echo $member['AccNumber'] ?>" data-toggle="modal"><span class="label label-success">Edit Account</span></a>
                    <a style="cursor: pointer"><span class="label label-warning" onclick="ResetPass('<?php echo $member['AccNumber'] ?>');">Reset Password</span></a>
                    <?php
                    if ($member['AccStatus'] == "Active") {
                    ?>
                      <a style="cursor: pointer"><span class="label label-danger" onclick="DeActivateAcc('<?php echo $member['Fullname'] ?>','<?php echo $member['AccNumber'] ?>', 'DeActivate');">Deactivate Account</span></a>
                    <?php }
                    if ($member['AccStatus'] == "Inactive") {
                    ?>
                      <a style="cursor: pointer"><span class="label label-success" onclick="DeActivateAcc('<?php echo $member['Fullname'] ?>','<?php echo $member['AccNumber'] ?>', 'Activate');">Activate Account</span></a>
                    <?php } ?>
                  </p>
                <?php } ?>
                <hr>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>

          <div class="col-md-9">
            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#Welfare" data-toggle="tab"><strong>Welfare</strong></a></li>
                <li><a href="#Savings" data-toggle="tab"><strong>Savings</strong></a></li>
                <li><a href="#LoanRequests" data-toggle="tab"><strong>Loan Requests</strong></a></li>
                <li><a href="#LoanPayments" data-toggle="tab"><strong>Loan Payments</strong></a></li>
                <li><a href="#NextofKin" data-toggle="tab"><strong>Next of Kin</strong></a></li>
              </ul>
              <div class="tab-content">
                <!--Welfare Tab-Pane -->
                <div class="active tab-pane" id="Welfare">
                  <div class="box-body table-responsive">
                    <img class="borderDloadImg" src="../dist/img/excel_download.png" title="Export to Excel" onclick="ExportToExcel('example5', '<?php echo $member['Fullname'] . '-' . $member['AccNumber'] ?>-Welfare')" />
                    <!-- /.box-header -->
                    <table id="example5" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Amount(UGX)</th>
                          <th>Payment Mode</th>
                          <th>Narration</th>
                          <th>Receipt No.</th>
                          <th>Receipt</th>
                          <th>Payment Date</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $cnt = 1;
                        $sumWelfares = 0;
                        $welfares = DB::query('SELECT * from welfare where AccNumber=%s order by DateCreated desc', $AccNumber);
                        foreach ($welfares as $welfare) {
                        ?>
                          <tr>
                            <td><?php echo $cnt; ?></td>
                            <td><?php echo number_format($welfare['Amount']); ?></td>
                            <td><?php echo $welfare['PaymentMode']; ?></td>
                            <td><?php echo $welfare['Narration']; ?></td>
                            <td><?php echo $welfare['ReceiptNumber']; ?></td>
                            <td>
                              <?php
                              if ($welfare['ReceiptImage'] != NULL) {
                              ?>
                                <a class="image-popup-no-margins" href="<?php echo $welfare['ReceiptImage']; ?>">
                                  <img class="img-responsive borderImg" src="<?php echo $welfare['ReceiptImage']; ?>" width="30" height="50">
                                </a>
                              <?php
                              } else {
                              ?>
                                <i class="fa fa-warning" style="color:orange" title="No Attachment"></i>
                                </a>
                              <?php } ?>
                            </td>
                            <td><?php echo date_format(date_create($welfare['PaymentDate']), 'd-m-Y'); ?></td>
                          </tr>
                        <?php
                          $cnt++;
                          $sumWelfares += $welfare['Amount'];
                        }
                        ?>
                      </tbody>
                      <!--Summary of the Values-->
                      <tfoot>
                        <tr style="font-weight:bold; font-size:14px; background-color:#E3DAFF">
                          <td>
                            Total Welfare:
                          </td>
                          <td>
                            <?php echo 'UGX ' . number_format($sumWelfares); ?>
                          </td>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
                <!-- /.tab-pane Welfare-->

                <!--Savings Tab-Pane -->
                <div class="tab-pane" id="Savings">
                  <div class="box-body table-responsive">
                    <img class="borderDloadImg" src="../dist/img/excel_download.png" title="Export to Excel" onclick="ExportToExcel('example1', '<?php echo $member['Fullname'] . '-' . $member['AccNumber'] ?>-Savings')" />
                    <!-- /.box-header -->
                    <table id="example1" class="table table-bordered table-striped small">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Amount(UGX)</th>
                          <th>Savings Mode</th>
                          <th>Narration</th>
                          <th>Receipt No.</th>
                          <th>Receipt</th>
                          <th>Savings Date</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $savings = DB::query('SELECT * from savings where AccNumber=%s order by DateCreated desc', $AccNumber);
                        $cnt = 1;
                        $sumSavings = 0;
                        foreach ($savings as $saving) {
                        ?>
                          <tr title="<?php echo "Added by: " . $saving['CreatedBy'] . " on " . date_format(date_create($saving['DateCreated']), 'd-m-Y'); ?>">
                            <td><?php echo $cnt; ?></td>
                            <td><?php echo number_format($saving['Amount']); ?></td>
                            <td><?php echo $saving['SavingMode']; ?></td>
                            <td><?php echo $saving['Narration']; ?></td>
                            <td><?php echo $saving['ReceiptNumber']; ?></td>
                            <td>
                              <?php
                              if ($saving['ReceiptImage'] != NULL) {
                              ?>
                                <a class="image-popup-no-margins" href="<?php echo $saving['ReceiptImage']; ?>">
                                  <img class="img-responsive borderImg" src="<?php echo $saving['ReceiptImage']; ?>" width="30" height="50">
                                </a>
                              <?php
                              } else {
                              ?>
                                <i class="fa fa-warning" style="color:orange" title="No Attachment"></i>
                                </a>
                              <?php } ?>
                            </td>
                            <td><?php echo date_format(date_create($saving['SavingDate']), 'd-m-Y'); ?></td>
                          </tr>
                        <?php
                          $cnt++;
                          $sumSavings += $saving['Amount'];
                        }
                        ?>
                      </tbody>
                      <tfoot>
                        <tr style="font-weight:bold; font-size:14px; background-color:#E3DAFF">
                          <td>
                            Total Savings:
                          </td>
                          <td>
                            <?php echo 'UGX ' . number_format($sumSavings); ?>
                          </td>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
                <!-- /.tab-pane Savings-->
                <!--Welfare Tab-Pane -->
                <div class="tab-pane" id="LoanRequests">
                  <i style="cursor:pointer;color:teal;font-size:15px" title="Information" class="fa fa-info-circle" onclick="ShowLables()"></i>
                  <h6 id="LR-Labels" style="display:none">
                    <label><i class="fa fa-square-o btn-info"></i>Pending Approval</label>
                    <label><i class="fa fa-square-o btn-warning"></i>Outstanding</label>
                    <label><i class="fa fa-square-o btn-danger"></i>Rejected</label>
                    <label><i class="fa fa-square-o btn-success"></i>Cleared</label>
                  </h6>
                  <div class="box-body table-responsive">
                    <img class="borderDloadImg" src="../dist/img/excel_download.png" title="Export to Excel" onclick="ExportToExcel('example3', '<?php echo $member['Fullname'] . '-' . $member['AccNumber'] ?>-Loan Requests')" />
                    <!-- /.box-header -->
                    <table id="example3" class="table small table-bordered">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Type</th>
                          <th title="Principal">P</th>
                          <th title="Rate">R (%)</th>
                          <th title="Interest">I</th>
                          <th>Total Amount</th>
                          <th>Balance Due</th>
                          <th>Guarantors</th>
                          <th>Status</th>
                          <th>Due Date</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $loans = DB::query('SELECT * from loanrequests where AccNumber=%s order by DateCreated desc', $AccNumber);
                        foreach ($loans as $loan) {
                          $loanBalance = $loan['Balance'];
                          if ($loan['Status'] == "OUTSTANDING") {
                            echo "<tr class='warning'>";
                          } elseif ($loan['Status'] == "PENDING APPROVAL") {
                            echo "<tr class='info'>";
                          } elseif ($loan['Status'] == "REJECTED") {
                            echo "<tr class='danger'>";
                          } else {
                            echo "<tr class='success'>";
                          }
                        ?>
                          <td><?php echo $loan['LoanId']; ?></td>
                          <td><?php echo $loan['LoanType']; ?></td>
                          <td><?php echo number_format($loan['Principal']); ?></td>
                          <td><?php echo $loan['Rate']; ?></td>
                          <td><?php echo number_format($loan['Interest']); ?></td>
                          <td><?php echo number_format($loan['TotalAmount']); ?></td>
                          <td <?php if ($loanBalance != 0) {
                                echo 'style="color:crimson"';
                              } ?>><?php echo number_format($loanBalance); ?></td>
                          <td>
                            <i style="cursor:pointer;color:teal;font-size:15px" title="Guarantors List" class="fa fa-user-circle"
                              onclick="ViewGuarantors('<?php echo $loan['LoanId'] ?>',
                      '<?php
                          $cnt = 1;
                          $guarantors = DB::query('SELECT * from guarantors where LoanId=%s', $loan['LoanId']);
                          foreach ($guarantors as $guarantor) {
                            $Guarantor_name = DB::queryFirstRow('SELECT * from members where AccNumber=%s', $guarantor['AccNumber']);
                            echo $cnt . '. ' . $Guarantor_name['Fullname'] . ' >>> |' . number_format($guarantor['Amount']) . '| >>> |' . $guarantor['Status'] . '| >> ' . $guarantor['Comments'] . '<br/>';
                            $cnt++;
                          }
                        ?>'
                      );">
                            </i>
                          </td>
                          <td><?php echo $loan['Status'];
                              if ($loan['Status'] == "REJECTED") {
                              ?>
                              <i style="cursor:pointer;color:blue;font-size:15px" title="Reason for Rejection" class="fa fa-info-circle" onclick="ViewReason('<?php echo $loan['LoanId'] ?>','<?php echo $loan['ApprovalReason'] ?>');"></i>
                            <?php } ?>
                          </td>
                          <td><?php echo date_format(date_create($loan['DueDate']), 'd-m-Y'); ?></td>
                          </tr>
                        <?php
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
                <!-- /.tab-pane Welfare-->
                <!--LoanPayments Tab-Pane -->
                <div class="tab-pane" id="LoanPayments">
                  <div class="box-body table-responsive">
                    <img class="borderDloadImg" src="../dist/img/excel_download.png" title="Export to Excel" onclick="ExportToExcel('example4', '<?php echo $member['Fullname'] . '-' . $member['AccNumber'] ?>-Loan Payments')" />
                    <!-- /.box-header -->
                    <table id="example4" class="table small table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Loan ID</th>
                          <th>Loan Type</th>
                          <th>Total Amount</th>
                          <th>Installment Paid</th>
                          <th>Balance</th>
                          <th>Date Added</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $cnt = 1;
                        $sumPayments = 0;
                        $loans = DB::query('SELECT * from loanpayments where AccNumber=%s order by DateAdded desc', $AccNumber);
                        foreach ($loans as $loan) {
                        ?>
                          <td><?php echo $cnt; ?></td>
                          <td><?php echo $loan['LoanId']; ?></td>
                          <td><?php echo $loan['LoanType']; ?></td>
                          <td><?php echo number_format($loan['TotalAmount']); ?></td>
                          <td><?php echo number_format($loan['AmountPaid']); ?></td>
                          <td><?php echo number_format($loan['Balance']); ?></td>
                          <td><?php echo date_format(date_create($loan['DateAdded']), 'd-m-Y'); ?></td>
                          </tr>
                        <?php
                          $cnt++;
                          $sumPayments += $loan['AmountPaid'];
                        }
                        ?>
                      </tbody>
                      <tfoot>
                        <tr style="font-weight:bold; font-size:14px; background-color:#E3DAFF">
                          <td style="background:white"></td>
                          <td style="background:white"></td>
                          <td style="background:white"></td>
                          <td>
                            Total Loans Paid:</td>
                          <td>
                            <?php echo 'UGX ' . number_format($sumPayments); ?>
                          </td>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
                <!-- /.tab-pane LoanPayments-->

                <!--Nexk of Kin Tab-Pane -->
                <div class="tab-pane" id="NextofKin">
                  <div class="card-header-action">
                    <a data-toggle="modal" data-target="#addkin" class="btn btn-sm btn-primary">Add Next of Kin</a>
                  </div>
                  <div class="box-body table-responsive">
                    <img class="borderDloadImg" src="../dist/img/excel_download.png" title="Export to Excel" onclick="ExportToExcel('example7', '<?php echo $member['Fullname'] . '-' . $member['AccNumber'] ?>-Next of Kin')" />
                    <!-- /.box-header -->
                    <table id="example7" class="table small table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Fullname</th>
                          <th>Phone Number</th>
                          <th>Email Address</th>
                          <th>Relationship</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $cnt = 1;
                        $next_of_kin = DB::query('SELECT * from next_of_kin where AccNumber=%s', $AccNumber);
                        foreach ($next_of_kin as $member) {
                        ?>
                          <tr>
                            <td><?php echo $cnt; ?></td>
                            <td><?php echo $member['Fullname']; ?></td>
                            <td><?php echo $member['MSISDN']; ?></td>
                            <td><?php echo $member['EmailAddress']; ?></td>
                            <td><?php echo $member['Relation']; ?></td>
                            <td> <a data-toggle="modal" data-target="#editNextofkin" data-id="<?php echo $member['Id']; ?>" class="btn btn-sm btn-info">Edit</a>
                              <a data-toggle="modal" data-target="#delNextofkin" data-id="<?php echo $member['Id']; ?>" class="btn btn-sm btn-danger">Delete</a>
                            </td>
                          </tr>
                        <?php
                          $cnt++;
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
                <!-- /.tab-pane LoanPayments-->
              </div>
              <!-- /.tab-content -->
            </div>
          </div>
        </div>
        <!-- /.row -->
        <!-- Main row -->
      </section>
      <!-- /.content -->
    </div>
  <!-- /.content-wrapper -->
       <!-- Next of Kin div -->
       <div class="modal fade" id="addkin">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header bg-blue">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h5 class="modal-title">Add Next Of Kin</h5>
          </div>
          <form role="form" class="form-content" method="POST" action="ManageNextofKin.php">
            <input type="hidden" name="kin_action" value="Create">
            <input type="hidden" name="AccNumber" value="<?php echo $AccNumber; ?>">
            <div class="modal-body mt-2">
              <div class="form-group col-sm-3">
                <label for="Amount">Fullname</label>
                <input type="text" class="form-control" name="Fullname" placeholder="Enter Fullname" required autocomplete="off" />
              </div>
              <div class="form-group col-sm-3">
                <label for="Amount">Phone Number</label>
                <input type="text" class="form-control" name="Phone_Number" placeholder="Enter Phone Number" required autocomplete="off" />
              </div>
              <div class="form-group col-sm-3">
                <label for="Amount">Email Address</label>
                <input type="email" class="form-control" name="Email_Address" placeholder="Enter Email Address" required autocomplete="off" />
              </div>
              <div class="form-group col-sm-3">
                <label for="Amount">Relationship</label>
                <input type="text" class="form-control" name="Relationship" placeholder="Enter Relationship" required autocomplete="off" />
              </div>
            </div>
            <div class="modal-footer mt-2">
              <button type="submit" class="btn btn-success">Add Next of Kin</button>
              <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Close</button>
            </div>
          </form>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
<?php include('externalScripts.php');?>
    
<!-- Edit Clients Modal-->
    <div class="modal fade" id="editMember">
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
    $('#editMember').on('show.bs.modal', function (e) {
      
        var MemberID = $(e.relatedTarget).data('id');
        $.ajax({
            type : 'post',
            url : 'member_modal.php', //Here you will fetch records 
            data :  'MemberID='+ MemberID, //Pass $id
            success : function(data){
            $('.fetched-data').html(data);//Show fetched data from database
            $('.ModalDatepicker').datepicker();
            }
            
        });
     });
     
});
</script>

<script>
	function ViewReason(LoanId,Reason){
		//Prompt user to confirm
		alertify.alert('#'+LoanId+' - Reason for Rejection.',Reason);	
		}
    function ViewGuarantors(LoanId,List){
    //Prompt user to confirm
    alertify.alert('Loan #'+LoanId+' - Guarantors',List);	
  }
</script>

<script>
//Show the LR Lables
function ShowLables() {
  var x = document.getElementById("LR-Labels");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}
</script>

<script>
 $(function () {
    //Date picker
    $('#datepicker').datepicker({
      autoclose: true,
      todayHighlight: true,
      endDate: "currentDate",
    })
  })
  
    $(function () {
    $('#example1').DataTable()
    $('#example3').DataTable({
      'order'    : [[8 , "desc" ]]
    })
    $('#example4').DataTable()
    $('#example5').DataTable()
    $('#example6').DataTable()
    $('#example7').DataTable()
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
//Approve Loan
function DeActivateAcc(Name,AccNumber,Action){
		//Prompt user to confirm
		alertify.confirm(Action+" Account" ,"Are you sure you want to "+Action+" "+Name+"'s account?", function(){ 
		 var hr = new XMLHttpRequest();
	     var url = "DeActivateAcc.php";
	//Post to file without refreshing page
    var vars = "AccNumber="+AccNumber+"&Action="+Action;
    hr.open("POST", url, true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function() {
	    if(hr.readyState == 4 && hr.status == 200) {
		    var return_data = hr.responseText;
			alertify.alert('Response',return_data);
			function redirect(){window.location.href = "allMembers.php"}
			setTimeout(redirect, 3000);
		}	}
    hr.send(vars);
		}, function(){  });	
		}


    function ResetPass(AccNumber){
		//Prompt user to confirm
		alertify.confirm("Reset Password","Are you sure you want to reset the password for this account?", function(){ 
		 var hr = new XMLHttpRequest();
	     var url = "DeActivateAcc.php";
	//Post to file without refreshing page
  var vars = "AccNumber="+AccNumber+"&Action="+"Reset";
    hr.open("POST", url, true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function() {
	    if(hr.readyState == 4 && hr.status == 200) {
		    var return_data = hr.responseText;
			alertify.alert('Response',return_data);
			function redirect(){window.location.href = "allMembers.php"}
			//setTimeout(redirect, 3000);
		}	}
    hr.send(vars);
		}, function(){  });	
		}
    
</script>
 <!-- Edit Modal-->
 <div class="modal fade" id="editNextofkin">
      <div class="modal-dialog modal-lg">
        <div class="modal-content ">

          <div class="fetched-data"></div> <!--Fetched Header and body-->

        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>

    <script>
      $(document).ready(function() {
        $('#editNextofkin').on('show.bs.modal', function(e) {
          var nokID = $(e.relatedTarget).data('id');
          var kin_action = 'Edit';
          $.ajax({
            type: 'post',
            url: 'Modal_nok.php', //Here you will fetch records 
            data: 'nokID=' + nokID + '&kin_action=' + kin_action, //Pass $id
            success: function(data) {
              $('.fetched-data').html(data); //Show fetched data from database
            }
          });
        });
      });
    </script>

    <!-- Delete Modal-->
    <div class="modal fade" id="delNextofkin">
      <div class="modal-dialog modal-lg">
        <div class="modal-content ">

          <div class="fetched-data"></div> <!--Fetched Header and body-->

        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>

    <script>
      $(document).ready(function() {
        $('#delNextofkin').on('show.bs.modal', function(e) {
          var nokID = $(e.relatedTarget).data('id');
          var kin_action = 'Delete';
          $.ajax({
            type: 'post',
            url: 'Modal_nok.php', //Here you will fetch records 
            data: 'nokID=' + nokID + '&kin_action=' + kin_action, //Pass $id
            success: function(data) {
              $('.fetched-data').html(data); //Show fetched data from database
            }
          });
        });
      });
    </script>

</body>
</html>
