<!DOCTYPE html>
<html>
<head>
<?php include('headLinks.php');?>
	<style>
	.form-control{
		color:blue;
	}
	.btn-danger a{
		color:#fff;
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
        <li >
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
	  $sysUser = DB::queryFirstRow('SELECT * from systemusers where AccId=%s',$_SESSION['AccId']);
	  if(empty($sysUser['ProfilePicture'])){
		  $ProfilePicture = "../dist/img/avatar5.png";
	  }
	  else{
		  $ProfilePicture = $sysUser['ProfilePicture'];
	  }
	  ?>
		<div class="col-md-3">
          <!-- Profile Image -->
          <div class="box box-success">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive" src="<?php echo $src;?>" alt="User profile picture">

              <h3 class="profile-username text-center"><?php echo $sysUser['Name']."<br/> #".$sysUser['AccId'];?></h3>

              <ul class="list-group list-group-unbordered">
                <!--
				<li class="list-group-item">
                  <b>DOB</b> <a class="pull-right"><?php echo date_format(date_create($sysUser['DOB']), 'd-M-Y');?></a>
                </li>
                <li class="list-group-item">
                  <b>Phone Number</b> <a class="pull-right"><?php echo $sysUser['MSISDN'];?></a>
                </li>
                <li class="list-group-item">
                  <b>Email</b> <a class="pull-right"><?php echo $sysUser['EmailAddress'];?></a>
                </li>
				-->
				<li class="list-group-item">
                  <b>Role</b> <a class="pull-right"><?php echo $role['Role'];?></a>
                </li>
				<li class="list-group-item">
                  <b>Date Added</b> <a class="pull-right"><?php echo date_format(date_create($sysUser['DateCreated']), 'd-M-Y');?></a>
                </li>
				<li class="list-group-item">
                  <b>Last Login </b> <a class="pull-right"><?php echo date_format(date_create($sysUser['LastLogin']), 'd-M-Y H:i');?></a>
                </li>
              </ul>

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
			        <div class="active tab-pane" id="passwordChange">
                <form class="form-horizontal" method="POST" action="changePassword.php">
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Old Password</label>
                    <div class="col-sm-8">
				          	<input class="form-control hidden" id="inputName" name="AccId" value="#">
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
<?php include('externalScripts.php');?>

<script>
  $(function () {
    //Date picker
    $('#datepicker').datepicker({
      autoclose: true,
	  format: "d-m-yyyy"
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
</script>
<script>
$('#InputAmount').keyup(function(event) {

  // skip for arrow keys
  if(event.which >= 37 && event.which <= 40) return;

  // format number
  $(this).val(function(index, value) {
    return value
    .replace(/\D/g, "")
    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    ;
  });
});
</script>
</body>
</html>