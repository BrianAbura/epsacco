<!DOCTYPE html>
<html>
<head>
<?php include('headLinks.php');?>
<style>
  .text-muted{
  padding-bottom: 3px;
  color:royalblue;
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
        <li>
          <a href="dashboard.php">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
		<li class="active">
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
	  $member = DB::queryFirstRow('SELECT * from members where AccNumber=%s', $_SESSION['AccNumber']);
	  ?>
	<div class="col-md-3">
          <!-- Profile Image -->
          <div class="box box-success">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive" src="<?php echo $member['ProfilePicture'];?>" alt="User profile picture">
              <h4 class="text-center"><?php echo $member['Name']."<br/> ".$member['AccNumber'];?></h3>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->


          <div class="box box-success">
            <!-- /.box-header -->
            <div class="box-body">

              <strong><i class="fa fa-phone"></i> Mobile</strong>
              <p class="text-muted">
              <?php echo $member['MSISDN'];?>
              </p>
            
              <strong><i class="fa fa-globe"></i> Email</strong>
              <p class="text-muted">
              <?php echo $member['EmailAddress'];?>
              </p>

              <hr>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
		
		 <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#passwordChange" data-toggle="tab">Change Password</a></li>
            </ul>
			
            <div class="tab-content">
				<!--Alerts Starts -->
						<?php
						if(isset($_SESSION['Success'])){
						?>
						<div class="alert alert-success alert-dismissible small">
						<label class="close" data-dismiss="alert" aria-hidden="true">&times;</label>
						<i class="icon fa fa-check"></i>
						<?php echo $_SESSION['Success'];?>
						</div>
						<?php 
							unset($_SESSION['Success']);
							}else if(isset($_SESSION['Error'])){
						?>
						<div class="alert alert-danger alert-dismissible small">
						<label class="close" data-dismiss="alert" aria-hidden="true">&times;</label>
						<i class="icon fa fa-ban"></i>
						<?php echo $_SESSION['Error'];?>
						</div>
						<?php 
						unset($_SESSION['Error']);
							}
						?>
						<!--Alerts End -->
              <div class="active tab-pane" id="passwordChange">
                <form class="form-horizontal" method="POST" action="changePassword.php">
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Old Password</label>
                    <div class="col-sm-8">
					          <input class="form-control hidden" id="inputName" name="user_id" value="#">
                      <input type="password" class="form-control" id="inputName" name="oldPass" placeholder="Enter your old password">
                    </div>
                  </div>
				  
                  <div class="form-group">
                    <label for="inputEmail" class="col-sm-2 control-label">New Password</label>
                    <div class="col-sm-8">
                      <input type="password" class="form-control" id="inputEmail" name="newPass" placeholder="Enter new password">
                    </div>
                  </div>
				  
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Repeat New Password</label>
                    <div class="col-sm-8">
                      <input type="password" class="form-control" id="inputName" name="newPass2" placeholder="Repeat new password">
                    </div>
                  </div>
				  
				  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-success" name="btn" value="password_change">Change Password</button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
      </div>
      <!-- /.row -->
      <!-- Main row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php include('../scripts/externalScripts.php');?>
</body>
</html>