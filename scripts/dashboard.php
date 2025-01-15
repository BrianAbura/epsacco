<!DOCTYPE html>
<html>
<head>
<?php include('headLinks.php');?>
<style>
   .table-striped>tbody>tr:nth-child(even)>td, 
	.table-striped>tbody>tr:nth-child(even)>th {
	   background-color: #c8f9d3;
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
        <li class="active">
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
        Dashboard
      </h1>

    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
       <!-- First Row-->
	  <div class="row">
    <div class="col-md-3 col-sm-3 col-xs-12" title="Members">
          <div class="info-box bg-green">
            <span class="info-box-icon"><i class="fa fa-users"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Members</span>
              <span class="info-box-number"><?php echo sumMembers();?></span>
              <br/>
                  <span class="progress-description dash-green">
                  <a href="allMembers.php">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

        <div class="col-md-3 col-sm-3 col-xs-12" title="Total Members Savings">
          <div class="info-box bg-green">
            <span class="info-box-icon"> <span class="glyphicon glyphicon-piggy-bank"></span></span>
            <div class="info-box-content">
              <span class="info-box-text">Total Members Savings</span>
              <span class="info-box-number"><?php echo 'UGX '.number_format(sumSavings());?></span>
              <br/>
                  <span class="progress-description dash-green">
                  <a href="savings.php">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

        <div class="col-md-3 col-sm-3 col-xs-12" title="Current Outstanding Savings">
          <div class="info-box bg-green">
            <span class="info-box-icon"><span class="glyphicon glyphicon-piggy-bank"></span></span>
            <div class="info-box-content">
              <span class="info-box-text">Current Outstanding Savings</span>
              <span class="info-box-number" <?php if(outstandingSavings() != 0) {echo 'style="color:orange"';}?>>
              <?php echo 'UGX '.number_format(outstandingSavings());?></span>
              <br/>
                  <span class="progress-description dash-green">
                  <a style="cursor:pointer" data-toggle="modal" data-target="#viewOutstandingSavings">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

        <div class="col-md-3 col-sm-3 col-xs-12" title="Membership Fee collected">
              <div class="info-box bg-green">
                <span class="info-box-icon"><i class="fa fa-star"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Total Welfare</span>
                  <span class="info-box-number"><?php echo 'UGX '.number_format(sumWelfare()); ?></span>
                  <br/>
                      <span class="progress-description dash-green">
                      <a href="welfare.php">More info <i class="fa fa-arrow-circle-right"></i></a>
                      </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
      </div>
        <!-- First Row-->
	  
       <!-- Second Row-->
	   <div class="row">
        <div class="col-md-3 col-sm-3 col-xs-12" title="Total Loans Disbursed">
              <div class="info-box bg-blue">
                <span class="info-box-icon"><i class="fa fa-money"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Total Loans Disbursed</span>
                  <span class="info-box-number"><?php  echo 'UGX '.number_format(totalLoans()); ?></span>
                  <br/>
                      <span class="progress-description dash-blue">
                      <a href="loanRequests.php">More info <i class="fa fa-arrow-circle-right"></i></a>
                      </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>

            <div class="col-md-3 col-sm-3 col-xs-12" title="Total Loans Paid (Interest Inclusive)">
              <div class="info-box bg-blue">
                <span class="info-box-icon"><i class="fa fa-money"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Total Loans Paid</span>
                  <span class="info-box-number"><?php echo 'UGX '.number_format(paidLoans()); ?></span>
                  <br/>
                      <span class="progress-description dash-blue">
                      <a href="loanPayments.php">More info <i class="fa fa-arrow-circle-right"></i></a>
                      </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>

            <div class="col-md-3 col-sm-3 col-xs-12" title="Current Outstanding Loans">
              <div class="info-box bg-blue">
                <span class="info-box-icon"><i class="fa fa-money"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text" style="text-transform:capitalize">Current Outstanding Loans</span>
                  <span class="info-box-number" <?php if(outstandingLoans() != 0) {echo 'style="color:orange"';}?>>
                  <?php echo 'UGX '.number_format(outstandingLoans()); ?>
                </span>
                  <br/>
                      <span class="progress-description dash-blue">
                      <a href="loanRequests.php">More info <i class="fa fa-arrow-circle-right"></i></a>
                      </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>

            <div class="col-md-3 col-sm-3 col-xs-12" title="Interests Earned From Loans">
              <div class="info-box bg-blue">
                <span class="info-box-icon"><i class="fa fa-money"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text" style="text-transform:capitalize">Interests Earned From Loans</span>
                  <span class="info-box-number"><?php echo 'UGX '.number_format(totalLoanInterests()); ?></span>
                  <br/>
                      <span class="progress-description dash-blue">
                      <a href="#">More info <i class="fa fa-arrow-circle-right"></i></a>
                      </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>

      </div>
  <!-- End of Second Row End-->
         <!-- Third Row-->
         <div class="row">

         <div class="col-md-3 col-sm-3 col-xs-12" title="Shared Interests">
              <div class="info-box bg-blue">
                <span class="info-box-icon"><i class="fa fa-bar-chart-o"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text" style="text-transform:capitalize">Shared Interests</span>
                  <span class="info-box-number"><?php echo '-'; ?></span>
                  <br/>
                      <span class="progress-description dash-blue">
                      <a class="small-box-footer" style="cursor:pointer" data-toggle="modal" data-target="#viewSharedInterest">More info <i class="fa fa-arrow-circle-right"></i></a>
                      </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>

            <div class="col-md-3 col-sm-3 col-xs-12" title="Total Savings + Interest Earned">
              <div class="info-box bg-blue">
                <span class="info-box-icon"><i class="fa fa-bar-chart-o"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text" style="text-transform:capitalize">Total Savings + Interest Earned</span>
                  <span class="info-box-number"><?php echo 'UGX '.number_format(sumSavings() + totalLoanInterests()); ?></span>
                  <br/>
                      <span class="progress-description dash-blue">
                      
                      </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>

        <div class="col-md-3 col-sm-3 col-xs-12" title="Bank Charges">
              <div class="info-box bg-red">
                <span class="info-box-icon"><i class="fa fa-bank"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Bank Charges</span>
                  <span class="info-box-number"><?php echo 'UGX '.number_format(sumBankCharges()); ?></span>
                  <br/>
                      <span class="progress-description dash-red">
                      <a href="bankcharges.php">More info <i class="fa fa-arrow-circle-right"></i></a>
                      </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>

            <div class="col-md-3 col-sm-3 col-xs-12" title="Cash at Bank">
              <div class="info-box bg-blue">
                <span class="info-box-icon"><i class="fa fa-bank"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">Cash at Bank</span>
                  <span class="info-box-number"><?php echo 'UGX '.number_format( (sumSavings()+paidLoans()+sumWelfare()+sumFines()+invWithdraws()) - totalLoans() - sumBankCharges() -invDeposits() ); ?></span>
                  <br/>
                      <span class="progress-description dash-blue">
                      
                      </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>

      </div>
  <!-- Third Row End-->
                     <!-- Fourth Row End-->
<div class="row">
<div class="col-md-3 col-sm-3 col-xs-12" title="Bank Charges">
     <div class="info-box bg-purple">
       <span class="info-box-icon"><i class="fa fa-btc" style="color:gold" aria-hidden="true"></i>
</span>
       <div class="info-box-content">
         <span class="info-box-text">Investments</span>
         <span class="info-box-number"><?php echo 'UGX '.number_format(invDeposits() + invInterests() - invWithdraws()); ?></span>
         <br/>
             <span class="progress-description dash-purple">
             <a href="Investments.php">More info <i class="fa fa-arrow-circle-right"></i></a>
             </span>
       </div>
       <!-- /.info-box-content -->
     </div>
     <!-- /.info-box -->
   </div>
</div>
   <!-- Fourth Row End-->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<!--/View the Shared Interest-->
<div class="modal fade" id="viewSharedInterest">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header bg-blue">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span></button>
			<h5 class="modal-title">Shared Interests per Individual</h5>
		  </div>
		
			<div class="modal-body">
				<table id="example4" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Member</th>
                  <th>Interest Earned</th>
                </tr>
                </thead>
                <tbody>
				<?php
				$cnt=1;
				$totalInterestEarned = 0;
				$members = DB::query('SELECT * from members where AccStatus=%s order by Id desc', 'Active');
				foreach($members as $member){
					$totalSavings = DB::queryFirstRow('SELECT sum(Amount)from savings where AccNumber=%s', $member['AccNumber']);
					$interestEarned = ($totalSavings['sum(Amount)'] * Interests())/sumSavings();
				?>
				 <tr>
                  <td><?php echo $cnt;?></td>
                  <td><?php echo $member['Name'];?></td>
                  <td><?php echo number_format($interestEarned);?></td>
                </tr>
				<?php 
				$cnt++;
				$totalInterestEarned = $totalInterestEarned + $interestEarned;
				}
				?>
				</tbody>
			</table>
			</div>
			<div class="modal-footer">
			<h4 class="pull-left">
			<b>Total: <?php echo 'UGX '.number_format($totalInterestEarned);?></b>
			</h4>
				<button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Close</button>
			</div>
		</div>
		<!-- /.modal-content -->
	  </div>
	  <!-- /.modal-dialog -->
</div>

<?php include('externalScripts.php');?>

<!--/View the Savings  Summary-->
<div class="modal fade" id="viewOutstandingSavings">
	  <div class="modal-dialog modal-lg">
		<div class="modal-content">
		  <div class="modal-header bg-blue">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span></button>
			<h5 class="modal-title">Current Outstanding Savings</h5>
		  </div>
		
			<div class="modal-body">
				<table id="example4" class="table table-bordered table-d">
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
          if($outstandingSaving > 0){
				?>
				 <tr>
                  <td><?php echo $cnt;?></td>
                  <td><?php echo $member['AccNumber'];?></td>
                  <td><?php echo $member['Name'];?></td>
                  <td><?php echo number_format($expectedSaving);?></td>
                  <td><?php echo number_format($currentSaving);?></td>
                  <td <?php if($outstandingSaving > 0){echo 'style="color:maroon"';}?>><?php echo number_format($outstandingSaving);?></td>
                </tr>
				<?php 
				$cnt++;
        $sumExpected += $expectedSaving;
        $sumCurrent += $currentSaving;
        $sumOutstanding += $outstandingSaving;
          }
				}
				?>
				</tbody>
          <tfoot>
            <tr style="font-weight:bold; font-size:14px; background-color:#D8FFE1">
            <td></td>
            <td></td>
            <td>Total: </td>
            <td></td>
            <td></td>
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

<!-- Page script -->
<script>
 
    $(function () {
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
	 $('#example3').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
	$('#example4').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
</script>
</body>
</html>