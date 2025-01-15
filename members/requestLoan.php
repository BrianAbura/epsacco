<!DOCTYPE html>
<html>
<head>
<?php include('headLinks.php');?>

<style>
/* The container */
.container {
  display: block;
  position: relative;
  padding-right: 120px;
  margin-bottom: 12px;
  cursor: pointer;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}


/* Create a custom checkbox */
.checkmark {
  position: absolute;
  top: 0;
  left: 10px;
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
tfoot{
  text-align: center;
  color: midnightblue;
  font-weight: bold;
}
.alertify-notifier .ajs-message.ajs-error{
    color: #fff;
    background: rgba(217, 92, 92, 0,95);
    text-shadow: -1px -1px 0 rgba(0, 0, 0, 0,5);
}
.form-control{
  color: blue;
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
		
		<li class="treeview active">
          <a href="#">
          <span class="glyphicon glyphicon-list-alt"></span>
            <span>Loan Requests</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="active"><a href="requestLoan.php"><i class="fa fa-circle-o"></i> Request for a Loan</a></li>
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
        Loan Application
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Loan Application</li>
      </ol>
    </section>

      <!-- Main content -->
      <section class="content">
      <div class="row">
			 <div class="col-md-12">
			<div class="box box-success">		

            <!-- form start -->
            <form role="form" class="form-content" method="POST" action="AddLoanRequest.php" enctype="multipart/form-data">
              <div class="box-body">
			  <div class="row">
				<div class="form-group col-sm-2">
                  <label for="Amount">Loan Type</label>
				  <select class="form-control" id="LoanType" name="LoanType" required >
				  <option></option>
				  <option value="Main">Main Loan</option>
				  <option value="Top-Up">Top-Up Loan</option>
				  </select>
                </div>			  
				<div class="form-group col-sm-2">
                  <label for="Amount">Loan Amount</label>
                  <input type="text" class="form-control InputAmount" id="InputAmount" name="Amount" placeholder="Enter Loan Amount" required />
                </div>
				
				<div class="form-group col-sm-1">
                  <label for="Rate">Rate(%)</label>
                  <input type="text" class="form-control" id="Rate" name="Rate" min=1 value="2" readonly />
                </div>
				
				<div class="form-group col-sm-2">
                  <label for="Interest">Interest</label>
                  <input type="text" class="form-control" id="Interest" name="Interest" readonly />
                </div>
				
			   <div class="form-group col-sm-2">
                  <label for="TotalAmount">Loan Period (Months)</label>
                  <input type="text" class="form-control" id="LoanPeriod" name="LoanPeriod" readonly required />
                </div>
			   
			   <div class="form-group col-sm-2">
                  <label for="TotalAmount">Total Amount</label>
                  <input type="text" class="form-control" id="TotalAmount" name="TotalAmount" readonly required/>
                </div>
		</div>
				<!-- /.First Row -->
        <hr/>
				
					
				<div class="row col-lg-8" id="GuarantorTableRow">
        <div class="col table-responsive">
				<h4>Guarantors
				<a href='javascript:void(0);' style="font-size:14px;" id='addMore'><span class="glyphicon glyphicon-plus"></span><label> Add More</label></a>
				</h4>
        <p style="color:brown"><strong>Note:</strong> Guarantors have to Accept or Reject the guarantee request before the loan the issued.</p>

        <table class="table table-bordered" style="background: #D3D3D3" id="GuarantorTable">
				<thead>
				  <tr>
				   <th>Guarantor</th>
					<th>Amount</th>
				  </tr>
				</thead>
                <tr>
                  <td>
					  <select class="form-control" name="GuarantorAccNumber[]" id="GuarantorAccNumber" >
					  <option></option>
					  <?php 
					  $members = DB::query('SELECT * from members where AccStatus=%s', 'Active');
					  foreach($members as $member){
						  $savings = DB::queryFirstRow('SELECT sum(Amount) from savings where AccNumber=%s', $member['AccNumber']);
					  ?>
					  <option value="<?php echo $member['AccNumber'];?>"><?php echo $member['Name']." (".number_format($savings['sum(Amount)']).")";?></option>
					  <?php }?>
					  </select>
				  </td>
                  <td>
						<input type="text" class="form-control InputAmount" id="GuarantorAmount" name="GuarantorAmount[]" placeholder="Enter Guarantor's Contribution"  />
                  </td>
				   <td>
				   <a href='javascript:void(0);' style="font-size:12px;" id='DeleteRow'><i class="fa fa-close" style="color:red"></i></a>
						
                  </td>
		        </tr>
              </table>
				</div>
        </div>
			  <!-- /.Second Row -->

			<div class="row">
				<hr/>
				<div class="col-md-8">
                <label class="container">
                <input type="checkbox" class="flat-red" required > I accept the E-GP Savings and Investments Group <a style="cursor:pointer" data-toggle="modal" data-target="#termsConditions">Terms and Conditions</a>
				        <span class="checkmark"></span>
                </label>
              </div>	
				
			</div>
			  <!-- /.Third Row -->
           
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-success">Submit Loan Request</button>
                <a class="btn btn-danger" href="viewLoanRequests.php">Cancel</a>
              </div>
            </form>

          </div>
          <!-- /.box -->
			 </div>
		</div>
      <!-- /.row -->
      <!-- Main row -->
    </section>
  </div>
  
  <!--Terms and Conditions-->
  <div class="modal fade" id="termsConditions">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header bg-green">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span></button>
			<h5 class="modal-title"><b>E-GP Savings and Investments Group</b> Terms and Conditions</h5>
		  </div>
		
			<div class="modal-body">
				
				This agreement is made this day <b><?php echo date('d M, Y');?></b> between the (Lender) <b>E-GP Investments Club</b> and (Borrower) <b><?php echo $user['Name'];?>.</b><br/>
				<b>And whereas,</b><br/>
				The lender as a financing agency is desirous to lending the borrower and the borrower is desirous of borrowing from the lender and the terms and conditions here in below agreed.<br/>
				<b>THIS AGREEMENT WITNESSETH AS BELOW,</b><br/>
				The lender lends the borrower the principal requested for the specified period to be paid to the lender as principle and interest (Total Amount) there at the rate of <b>2%</b> per month at reducing balance for Main Loans and <b>10%</b> per month for loan Top-Up's.<br/><br/>
				Without the prejudice to the provisions above , its hereby agreed between both parties that in the event the borrower failing to pay back within the specified loan period herein after the borrower shall be liable to pay <b>10%</b> for the Main Loan and <b>10%</b> for Loan Top-Up's on the 
				(principle and interest) due to the date of default of payment. The system will automatically enforce this change once the loan period has elapsed.<br/><br/> 
				The borrower will inform the lender in time in case of indebtedness and failure to pay so that a new agreement/contract can be entered into and so
				will the lender notify the borrower about his/her current obligation and the period when the contract is expiring.<br/><br/>
				
				The lender will have a right to fully possess the collateral security of the borrower and that is the shares of borrower and the guarantors, after time of expiry of agreement and shall use it to recover his 
				principal amount. <br/><br/>
				In case of ratification of the agreement, the borrower will pay the amount due and any other expenses/charges that might have been incurred by the lender as per that period. After fully 
				fulfilling his/her obligations, the borrower and the guarantors will fully claim their shares back, the lender is not liable according to the law of contract.<br/><br/>
				
				<b>THE AGREEMENT FURTHER WITNESSES THAT;</b><br/>
				The borrower will use his/her shares and shares of his/her guarantors which will be used as collateral security or as a guarantee to acquire the loan.
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Close</button>
			</div>
		</div>
		<!-- /.modal-content -->
	  </div>
	  <!-- /.modal-dialog -->
</div>
  <!-- /.content-wrapper -->
  <script>
function commaSeparateNumber(val){
    while (/(\d+)(\d{3})/.test(val.toString())){
      val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
    }
    return val;
  }
  
var InputAmount = document.getElementById("InputAmount");
var Rate = document.getElementById("Rate");
var Interest = document.getElementById("Interest");
var TotalAmount = document.getElementById("TotalAmount");
var LoanType = document.getElementById("LoanType");
var LoanPeriod = document.getElementById("LoanPeriod");
var GuarantorTableRow = document.getElementById("GuarantorTableRow");

	//Type of Loan First
	//3% interest rate for Main loan with Guarantors
	//10% interest for Top-Up without Guarantors
	
	LoanType.onchange = function(){
		//If This is the Main Loan
		if(LoanType.value == "Main"){
      InputAmount.value = "";
			Rate.value = 2;
			GuarantorTableRow.style.display = "block";
			NewInputAmount = InputAmount.value.replace(/,/g,"");
			Interest.value = (NewInputAmount * (Rate.value/100));
			if (NewInputAmount == ""){
				TotalAmount.value = "";
				}
				else{
				TotalAmount.value = commaSeparateNumber(parseInt(NewInputAmount) + parseInt(Interest.value));
			}
			Interest.value = commaSeparateNumber((NewInputAmount * (Rate.value/100)));
		}
		//If This is A Loan Top-Up
		else if(LoanType.value == "Top-Up"){
      InputAmount.value = "";
			Rate.value = 10
			GuarantorTableRow.style.display = "none";
			NewInputAmount = InputAmount.value.replace(/,/g,"");
			Interest.value = (NewInputAmount * (Rate.value/100));
			if (NewInputAmount == ""){
				TotalAmount.value = "";
				}
				else{
				TotalAmount.value = commaSeparateNumber(parseInt(NewInputAmount) + parseInt(Interest.value));
			}
			Interest.value = commaSeparateNumber((NewInputAmount * (Rate.value/100)));
			LoanPeriod.value = 1;
		}
		else{
			//Rate.value = 3;
			//GuarantorTableRow.style.display = "block";
		}
	}

	//When the Amount Changes
	InputAmount.onchange = function() {	
	NewInputAmount = InputAmount.value.replace(/,/g,"");
      if(NewInputAmount > 15000000){
        alertify.alert("Error!","You cannot make a loan request of more than <b>UGX 15,000,000.</b>");
        InputAmount.value = "";
      }
	Interest.value = (NewInputAmount * (Rate.value/100));
		if (NewInputAmount == ""){
		TotalAmount.value = "";
		}
		else{
		TotalAmount.value = commaSeparateNumber(parseInt(NewInputAmount) + parseInt(Interest.value));
			}
	  Interest.value = commaSeparateNumber(Interest.value);
      
    if(LoanType.value == "Top-Up"){
      LoanPeriod.value = 1;
    }
    else{
      //*** Loan Period changes based on the Input Amount ***//
				if((NewInputAmount >= 1) && (NewInputAmount < 3000000)){
              LoanPeriod.value = 3;
          }
          else if((NewInputAmount >= 3000000) && (NewInputAmount < 5000000)){
              LoanPeriod.value = 5;
          }
          else if((NewInputAmount >= 5000000) && (NewInputAmount < 8000000)){
              LoanPeriod.value = 6;
          }
          else if((NewInputAmount >= 8000000) && (NewInputAmount < 10000000)){
            LoanPeriod.value = 8;
          }
          else if(NewInputAmount >= 10000000){
            LoanPeriod.value = 12;
          }
          else{
            LoanPeriod.value = 0;
          }
		//*** END Loan Period changes based on the Input Amount END ***//
    }
		
	}
	
</script>
<?php include('../scripts/externalScripts.php');?>
<script>
$('.InputAmount').keyup(function(event) {

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
<script>
$('.GuarantorAmount').keyup(function(event) {
  // skip for arrow keys
 
  // format number
  $(this).val(function(index, value) {
    return value
    .replace(/\D/g, "")
    .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    ;
  });
});
</script>
<script>
//Script to add more rows to the end of venues table
$(function(){
    $('#addMore').on('click', function() {
        var data = $("#GuarantorTable tr:eq(1)").clone(true).appendTo("#GuarantorTable");
        data.find("input").val('');
        data.find("select").val('');
     });
     $('#DeleteRow').on('click', function() {
         var trIndex = $(this).closest("tr").index();
            if(trIndex>=1) {
             $(this).closest("tr").remove();
           } else {
             alertify.alert("Error!","Sorry you Cannot remove this row.");
           }
      });
});      
</script>
<script>
 function numberWithCommas(x) {
    x = x.toString();
    var pattern = /(-?\d+)(\d{3})/;
    while (pattern.test(x))
        x = x.replace(pattern, "$1,$2");
    return x;
}

//Date picker
$(function () {
    $('.datepicker').datepicker({
      autoclose: true,
      todayHighlight: true,
      startDate: "currentDate",
    })
  })

</script>
</body>
</html>
