<!DOCTYPE html>
<html>
<head>
<?php include('headLinks.php');?>
<style>
.inner h3{
	font-size: 30px;
}
</style>
</head>
<body class="hold-transition skin-green sidebar-mini">
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
		<li>
          <a href="memberProfile.php">
            <i class="fa fa-user"></i> <span>Profile</span>
          </a>
        </li>
              <!--Welfare-->
        <li>
          <a href="viewWelfare.php">
          <i class="fa fa-star"></i> <span>Welfare</span>
          </a>
        </li>
           <!--Savings-->
		    <li>
          <a href="viewSavings.php">
          <span class="glyphicon glyphicon-piggy-bank"></span> <span>Savings</span>
          </a>
        </li>
		
		<li class="treeview">
          <a href="#">
          <span class="glyphicon glyphicon-list-alt"></span>
            <span>Loan Requests</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="requestLoan.php"><i class="fa fa-circle-o"></i> Request for a Loan</a></li>
            <li><a href="viewLoanRequests.php"><i class="fa fa-circle-o"></i> View Loan Requests</a></li>
            <li><a href="GuaranteeRequests.php"><i class="fa fa-circle-o"></i> Guarantee Requests  
            <?php 
				if(GuaranteeRequests($_SESSION['AccNumber']) != 0)
				{
				?>
			  <small class="label pull-right bg-red">
				<?php 
				echo number_format(GuaranteeRequests($_SESSION['AccNumber']));
				?>
			  </small>
				<?php 
				}
				?>
          </a></li>
            <li><a href="GuaranteedLoans.php"><i class="fa fa-circle-o"></i> Guaranteed Loans</a></li>
          </ul>
        </li>
		
		<li>
          <a href="viewLoanPayments.php">
          <span class="glyphicon glyphicon-list-alt"></span> <span>Loan Payments</span>
          </a>
        </li>
		<li>
          <a href="signout.php">
            <i class="fa fa-power-off"></i> <span>Sign out</span>
          </a>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  <section class="content-header">
      <h1>
        Dashboard
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>
  
	<section class="content">
      <!-- Basic Information -->

       <!-- First Row General Information-->
	  <div class="row">
       <div class="col-md-4 col-sm-3 col-xs-12" title="Name and Membership Number">
          <div class="info-box bg-blue">
          <div class="small-box">
            <div class="inner">
			      <p>Name and Account Number</p>
			        <h3 style="font-size:20px"><?php echo $user['Name']."<br/>".''.$_SESSION['AccNumber'];?></h3>
            </div>
          </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

        <div class="col-md-4 col-sm-3 col-xs-12" title="Monthly Savings Premium">
          <div class="info-box bg-green">
            <span class="info-box-icon"> <span class="glyphicon glyphicon-piggy-bank"></span></span>
            <div class="info-box-content">
              <span class="info-box-text">Monthly Savings Premium</span>
              <span class="info-box-number"><?php echo 'UGX 150,000';?></span>
              <br/>
                  <span class="progress-description dash-green">
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

        <div class="col-md-4 col-sm-3 col-xs-12" title="Total Loans Borrowed">
          <div class="info-box bg-yellow">
            <span class="info-box-icon"> <i class="fa fa-money"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Total Loans Borrowed</span>
              <span class="info-box-number"><?php echo 'UGX '.number_format(LoansRequests($_SESSION['AccNumber']));?></span>
              <br/>
                  <span class="progress-description dash-yellow">
                  <a href="viewLoanRequests.php">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

    </div>

      
      
        <!-- Row 2 Svings Details-->
      <div class="row">
      <div class="col-md-4 col-sm-3 col-xs-12" title="Total Welfare">
          <div class="info-box bg-blue">
            <span class="info-box-icon"> <i class="fa fa-star"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Welfare Collections</span>
              <span class="info-box-number"><?php echo number_format(TotalWelfare($_SESSION['AccNumber']));?></span>
              <br/>
                  <span class="progress-description dash-blue">
                  <a href="viewWelfare.php">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>


        <div class="col-md-4 col-sm-3 col-xs-12" title="Total Savings to Date">
          <div class="info-box bg-green">
            <span class="info-box-icon"> <span class="glyphicon glyphicon-piggy-bank"></span></span>
            <div class="info-box-content">
              <span class="info-box-text">Total Savings to Date</span>
              <span class="info-box-number"><?php echo 'UGX '.number_format(TotalSavings($_SESSION['AccNumber']));?></span>
              <br/>
                  <span class="progress-description dash-green">
                  <a href="viewSavings.php">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

        <div class="col-md-4 col-sm-4 col-xs-12" title="Total Loans Paid">
          <div class="info-box bg-yellow">
            <span class="info-box-icon"> <i class="fa fa-money"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Total Loans Paid</span>
              <span class="info-box-number"><?php echo 'UGX '.number_format(LoanPayments($_SESSION['AccNumber']));?></span>
              <br/>
                  <span class="progress-description dash-yellow">
                  <a href="viewLoanPayments.php">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

    </div>

           <!-- Row 3 Loan Details-->
           <div class="row">
           <div class="col-md-4 col-sm-4 col-xs-12" title="Total Loans Guaranteed">
          <div class="info-box bg-blue">
            <span class="info-box-icon"> <i class="fa fa-money"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Total Loans Guaranteed</span>
              <span class="info-box-number"><?php echo 'UGX '.number_format(LoanGuaranteed($_SESSION['AccNumber']));?></span>
              <br/>
                  <span class="progress-description dash-blue">
                  <a href="GuaranteedLoans.php">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        
        <?php 
        $outStandingSaving = ExpectedMemberSavings() - MembersumSavings($_SESSION['AccNumber']);
        if($outStandingSaving < 0){
          $val = "+".number_format(-$outStandingSaving);
        }
        else{
          $val = number_format($outStandingSaving);
        }
        
        ?>
        
        <div class="col-md-4 col-sm-3 col-xs-12" title="Current Outstanding Savings">
          <div class="info-box bg-green">
            <span class="info-box-icon"> <span class="glyphicon glyphicon-piggy-bank"></span></span>
            <div class="info-box-content">
              <span class="info-box-text">Current Outstanding Savings</span>
              <span class="info-box-number" <?php if($outStandingSaving !=0) {echo 'style="color:orange"';}?>
              ><?php echo 'UGX '.$val;?></span>
              <br/>
                  <span class="progress-description dash-green">
                  <a href="viewSavings.php">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

        
        <div class="col-md-4 col-sm-3 col-xs-12" title="Current Outstanding Loan">
          <div class="info-box bg-yellow">
            <span class="info-box-icon"> <i class="fa fa-money"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Current Outstanding Loan Balance</span>
              <span class="info-box-number" 
              <?php if(MemOutstandingLoans($_SESSION['AccNumber']) !=0) {echo 'style="color:crimson"';}?>
              
              ><?php echo 'UGX '.number_format(MemOutstandingLoans($_SESSION['AccNumber']));?></span>
              <br/>
                  <span class="progress-description dash-yellow">
                  <a href="viewLoanRequests.php">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
      </div>

	</section>
  </div>
  <!-- /.content-wrapper -->

<?php include('../scripts/externalScripts.php');?>
</body>
</html>