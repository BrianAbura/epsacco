<!DOCTYPE html>
<html>
<head>
<?php include('headLinks.php');?>
	<style>
  .form-control{
		color:blue;
	}
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
            <li><a href="allMembers.php"><i class="fa fa-circle-o"></i> All Members</a></li>
			      <li><a href="inactiveMembers.php"><i class="fa fa-circle-o"></i> Inactive Members</a></li>
            <li class="active"><a href="administrativeMembers.php"><i class="fa fa-circle-o"></i> Administrative Members</a></li>
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
        Administrative Members
        <?php if($user['Role'] == 4 || $user['Role'] == 1){?>
        <button class="btn btn-primary" style="font-size:12px;cursor:pointer" data-toggle="modal" data-target="#AddNewMember">Add New <i class="fa fa-plus"></i></button>
        <?php }?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Members</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
			 <div class="col-md-12">
			<div class="box box-success">	
			<div class="box-body table-responsive">
      <img class="borderDloadImg" src="../dist/img/excel_download.png" title="Export to Excel" onclick="ExportToExcel('example1', 'Administrators')"/> 	
            <!-- /.box-header -->
			<table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                <th>Acc ID.</th>
                <th>Name</th>
                <th>Mobile</th>
                <th>Email</th>
                <th>Role</th>
                <th>Last Login</th>
                <th></th>
                </tr>
                </thead>
                <tbody>
				<?php 
        $members = DB::query('SELECT * from systemusers');
				foreach($members as $member){
          $Role = DB::queryFirstRow('SELECT Designation from roles where RoleId=%s', $member['Role']);
				?>
				 <tr title="Added by: <?php echo $member['CreatedBy'];?>">
          <td><?php echo $member['AccId'];?></td>
          <td><?php echo $member['Name'];?></td>
				  <td><?php echo $member['MSISDN'];?></td>
				  <td><?php echo $member['EmailAddress'];?></td>        
          <td><?php echo $Role['Designation'];?></td>    
          <td><?php echo date_format(date_create($member['LastLogin']), 'd-m-Y H:i');?></td>
				  <td>
          <?php if($user['Role'] == 4 || $user['Role'] == 1){?>
            <button title="Delete Administrative Role" class="btn btn-danger btn-xs" onclick="deleteAdmin('<?php echo $member['Id']?>');">Delete</button>
            <?php }?>
            </td>
         </tr>
        <?php
				}
				?>
				</tbody>
			</table>
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
<div class="modal-dialog modal-lg" style="width:60%">
<div class="modal-content ">

<div class="modal-header bg-blue color-palette">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
      <h5 class="modal-title">Add Admininstrative Member</h5>
      </div>
      <div class="modal-body">
      <form role="form" class="form-content" method="POST" action="ManageAdmins.php" enctype="multipart/form-data">
      <input type="hidden" id="AdminAction" name="AdminAction" value="Add_Admin">
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
                <label for="SelectMem">Role Assigned</label>
                <select class="form-control" name="Role" id="Role" required>
                <option></option>
                <?php 
                $roles = DB::query('SELECT * from roles');
                foreach($roles as $role){
                  if ($role['Designation'] == "Member") {
                    continue;
                }
                ?>
                <option value="<?php echo $role['RoleId'];?>"><?php echo $role['Designation'];?></option>
                <?php }?>
                </select>
                </div>
			</div>
      <br/>

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-success">Add Member</button>
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

<!-- Edit Savings Modal-->
<div class="modal fade" id="editAdmin">
    <div class="modal-dialog modal-lg" style="width:60%">
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
    $('#editAdmin').on('show.bs.modal', function (e) {
        var AdminId = $(e.relatedTarget).data('id');
        $.ajax({
            type : 'post',
            url : 'Modal_Admin.php', //Here you will fetch records 
            data :  'AdminId='+ AdminId, //Pass $id
            success : function(data){
            $('.fetched-data').html(data);//Show fetched data from database
            }
        });
     });
});
</script>

<script>
	function deleteAdmin(id){
		//Prompt user to confirm
		alertify.confirm('Delete Record', 'Are you sure you want to delete this record?', function(){ 
      var hr = new XMLHttpRequest();
	     var url = "ManageAdmins.php";
	//Post to file without refreshing page
    var vars = "DelRowId="+id;
    hr.open("POST", url, true);
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function() {
	    if(hr.readyState == 4 && hr.status == 200) {
		    var return_data = hr.responseText;
			alertify.alert('Response',return_data);
			function redirect(){window.location.reload();}
			setTimeout(redirect, 1500);
		}	}
    hr.send(vars);
  }
                , function(){ alertify.error('Action Cancelled')});
		}
</script>

<script>
var _validFileExtensions = [".jpg", ".jpeg", ".png"];    
function ValidateSingleInput(oInput) {
    if (oInput.type == "file") {
        var sFileName = oInput.value;
         if (sFileName.length > 0) {
            var blnValid = false;
            for (var j = 0; j < _validFileExtensions.length; j++) {
                var sCurExtension = _validFileExtensions[j];
                if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                    blnValid = true;
                    break;
                }
            }
            if (!blnValid) {
                alertify.alert("Error","Sorry, the file type is invalid. Allowed file extensions are: JPG, JPEG and PNG");
                oInput.value = "";
                return false;
            }
        }
    }
    return true;
}

</script>

<script>
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
</body>
</html>
