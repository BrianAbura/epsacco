
<?php 
require_once('../defines/functions.php');

if(isset($_REQUEST['MemberID'])) {
  $MemberID = htmlspecialchars(( isset( $_REQUEST['MemberID'] ) )?  $_REQUEST['MemberID']: null);
  $Member = DB::queryFirstRow('SELECT * from members where Id=%s', $MemberID);
?>
<!--Edit Client modal-->
<div class="modal-header bg-navy color-palette">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span></button>
    <h5 class="modal-title">Edit Member</h5>
    </div>
    <div class="modal-body">
    <form role="form" class="form-content" method="POST" action="ManageMembers.php" enctype="multipart/form-data">
    <input type="hidden" id="MemAction" name="MemAction" value="Edit_MEM">
    <input type="hidden" id="EditMemID" name="EditMemID" value="<?php echo $MemberID;?>">
              <div class="box-body">
			<div class="row">
      <div class="form-group col-sm-2">
          <label for="InputName">Acc No.</label>
          <input type="text" class="form-control" id="InputName" name="AccNumber" value="<?php echo $Member['AccNumber']?>" readonly>
        </div>
				<div class="form-group col-sm-4">
          <label for="InputName">Fullname</label>
          <input type="text" class="form-control" id="InputName" name="Name" value="<?php echo $Member['Name']?>" required>
        </div>

        <div class="form-group col-sm-3">
          <label for="exampleInputEmail1">Email Address</label>
          <input type="email" class="form-control" id="exampleInputEmail1" name="EmailAddress" value="<?php echo $Member['EmailAddress']?>" required>
        </div>

        <div class="form-group col-sm-3">
          <label for="InputPhone">Phone Number</label>
          <input type="text" class="form-control" id="InputPhone" name="MSISDN" value="<?php echo $Member['MSISDN']?>" required>
        </div>
			</div>
      <br/>

      <div class="row">
        <div class="form-group">
                <label class="col-md-4 control-label">Profile Photo</label>
                <div class="col-md-12">
                  <div class="fileupload fileupload-new" data-provides="fileupload">
                    <div class="input-append">
                      <div class="uneditable-input">
                        <span class="fileupload-preview" style="font-size: 12px; color:blue"></span>
                      </div>
                      <span class="btn btn-default btn-file">
                        <span class="fileupload-exists">Change</span>
                        <span class="fileupload-new">Select file</span>
                        <input type="file" name="ProfilePicture" onchange="ValidateSingleInput(this);"/>
                      </span>
                      <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
                      <?php echo str_replace('../fileUploads/profiles', '', $Member['ProfilePicture']);?>
                      <p class="help-block">Accepted Formats: jpg, jpeg and png</p>
                    </div>
                  </div>
                </div>
              </div>
			</div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-success">Update</button>
              </div>
            </form>   
    </div>
<?php } ?>
<script>

    //Date picker
   </script>
    

    