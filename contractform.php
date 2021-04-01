<?php 
session_start();
include("dbconn.php");
$user = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];

if(isset($_SESSION['ConNum']))
{
	$conid = $_SESSION['ConNum'];
}
else
{
	header('location: workerform.php');
}

?>

<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Contract</title>

	<!--<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="css/fontawesome.min.css" />
	<link rel="stylesheet" type="text/css" href="css/typography.css" />
	<link rel="stylesheet" type="text/css" href="css/custom.css" />
	<script src="js/jquery.min.js"></script>

</head>
<body>-->



	<!-- begin HEADER -->
	<?php require("inc/header.php"); ?>
	<!-- end HEADER -->



	<!-- begin LEFT PANEL -->
	<div id="leftpanel" class="leftpanel">

		<?php require("inc/leftpanel.php"); ?>

		<!-- sub buttons -->
		<ul class="subbuttons">
			<div class="leftpanel-title"><b>COMMANDS</b></div>
			<li><button id="myAddBtn"><span class="fa fa-plus"></span> Create Record</button></li>
			<li><button onClick="Delete();"><span class="fa fa-trash-alt"></span> Delete Record</button></li>
			<li><button id="myUpdateBtn"><span class="fa fa-edit"></span> Update Record</button></li>
		</ul>
		
		<!-- extra buttons -->
		<ul class="extrabuttons">
			<div class="leftpanel-title"><b>SET</b></div>
			<li><button onClick="RateFrm();"><span class="fa fa-plus"></span> Set Rate</button></li>
			<!-- <li><button onClick="downloadcontract();"><span class="fa fa-caret-down"></span> Download Contract</button></li> -->
			<li><button id="myUploadBtn" ><span class="fa fa-caret-down"></span> Print Contract</button></li>
		</ul>

		<!-- sub buttons -->
		<ul class="subbuttons">
			<li><button onClick="WorkerFrm();"><span class="fa fa-arrow-circle-left fa-lg"></span> Back</button></li>
		</ul>

	</div>
	<!-- end LEFT PANEL -->

	<!-- begin MAINPANEL -->
	<div id="mainpanel" class="mainpanel">
		<div class="container-fluid">
			<div class="row">

				<!-- start TABLE AREA -->
				<div id="tablearea1" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mainpanel-area">
					<div class="mainpanel-content">
						<!-- title & search -->
						<div class="mainpanel-title">
							<span class="fa fa-archive"></span> Overview
						</div>
						<div class="mainpanel-sub">
							<!-- cmd
							<div class="mainpanel-sub-cmd">
								<a href="" class="cmd-create"><span class="far fa-plus-square"></a>
								<a href="" class="cmd-update"><span class="fas fa-edit"></a>
								<a href="" class="cmd-delete"><span class="far fa-trash-alt"></a>
									<span class="mainpanel-sub-space">|</span>
								<a href="" class="cmd-others"><span class="fas fa-caret-up"></a>
								<a href="" class="cmd-others"><span class="fas fa-caret-down"></a>
									<span class="mainpanel-sub-space">|</span>
								<a href="" class="cmd-print"><span class="fas fa-print"></a>
							</div>-->
						</div>
						<!-- tableheader -->
						<div id="container1" class="full">
							<table width="100%" style="border: 1px solid #d9d9d9;" id="datatbl" class="table table-striped mainpanel-table">
								<thead>	
									<tr class="rowtitle">
										<td style="width:20px;" class="text-center"><span class="fa fa-asterisk fa-xs"></span></td>
										<td style="width:10%;">Contract No</td>
										<td style="width:10%;">Rate</td>
										<td style="width:10%;">Monthly Rate</td>
										<td style="width:10%;">Transportation</td>
										<td style="width:10%;">Meal</td>
										<td style="width:10%;">Type</td>
										<td style="width:10%;">Department</td>
										<td style="width:10%;">Payment</td>
										<td style="width:10%;">From Date</td>
										<td style="width:10%;">To Date</td>
										<td style="width: 17px;" class="text-center"><span class="fas fa-arrows-alt-v"></span></td>
									</tr>
									<tr class="rowsearch">
									  <td class="text-center"><span class="fas fa-search fa-xs"></span></td>
									  

										<td><input list="SearchId" class="search" disabled>
										<?php
											$query = "SELECT distinct lf.workerid FROM loanfile lf
														left join worker wk on wk.workerid	= lf.workerid and wk.dataareaid = lf.dataareaid

														where lf.dataareaid = '$dataareaid' and wk.inactive = 0";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchId">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["workerid"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchName" class="search" disabled>
										<?php
											$query = "SELECT distinct wk.name FROM loanfile lf
														left join worker wk on wk.workerid	= lf.workerid and wk.dataareaid = lf.dataareaid

														where lf.dataareaid = '$dataareaid' and wk.inactive = 0";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchName">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["name"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchVoucher" class="search" disabled>
										<?php
											$query = "SELECT distinct voucher FROM loanfile where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchVoucher">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["voucher"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchSubType" class="search" disabled>
										<?php
											$query = "SELECT distinct subtype FROM loanfile where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchSubType">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["subtype"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchLoanType" class="search" disabled>
										<?php
											$query = "SELECT distinct loantype FROM loanfile where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchLoanType">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["loantype"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchAcc" class="search" disabled>
										<?php
											$query = "SELECT distinct todate FROM loanfile where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchAcc">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["todate"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchLoanDate" class="search" disabled>
										<?php
											$query = "SELECT distinct loandate FROM loanfile where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchLoanDate">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["loandate"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchAmount" class="search" disabled>
										<?php
											$query = "SELECT distinct loanamount FROM loanfile where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchAmount">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["loanamount"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchFromDate" class="search" disabled>
										<?php
											$query = "SELECT distinct fromdate FROM loanfile where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchFromDate">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["fromdate"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchToDate" class="search" disabled>
										<?php
											$query = "SELECT distinct todate FROM loanfile where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchToDate">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["todate"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>

									  <td><span></span></td>
									</tr>
								</thead>
								<tbody id="result">
									<?php					
									$query = "SELECT ct.contractid,format(ct.rate,2) as rate,format(ct.mrate,2) as mrate,format(ct.transpo,2) transpo,format(ct.meal,2) as meal,
												case when ct.contracttype = 0 then 'Regular' 
													when ct.contracttype = 1 then 'Reliever'
													when ct.contracttype = 2 then 'Probationary'
													when ct.contracttype = 3 then 'Contractual' 
													when ct.contracttype = 4 then 'Trainee'
													when ct.contracttype = 5 then 'Project-Based' else '' end as contracttype,
												dept.name as department,
												case              
													when ct.paymenttype = 0 then 'Cash' 
													when ct.paymenttype = 1 then 'ATM' 
												else '' end as Payment,
												STR_TO_DATE(ct.fromdate, '%Y-%m-%d') as fromdate,
												STR_TO_DATE(ct.todate, '%Y-%m-%d') as todate,
												ct.departmentid,
												ct.contracttype as type,
												ct.paymenttype as paymenttype


												FROM contract ct
												left join department dept on dept.departmentid = ct.departmentid and dept.dataareaid = ct.dataareaid

												where ct.dataareaid = '$dataareaid' and ct.workerid = '$conid'

												order by ct.contractid";
									$result = $conn->query($query);
									while ($row = $result->fetch_assoc())
									{ ?>
										<tr class="<?php echo $rowclass; ?>">
											<!--<td style="width:10px;"><input type='checkbox' name="chkbox" value="" id="myCheck"></td>-->
											<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
											<td style="width:10%;"><?php echo $row['contractid'];?></td>
											<td style="width:10%;"><?php echo $row['rate'];?></td>
											<td style="width:10%;"><?php echo $row['mrate'];?></td>
											<td style="width:10%;"><?php echo $row['transpo'];?></td>
											<td style="width:10%;"><?php echo $row['meal'];?></td>
											<td style="width:10%;"><?php echo $row['contracttype'];?></td>
											<td style="width:10%;"><?php echo $row['department'];?></td>
											<td style="width:10%;"><?php echo $row['Payment'];?></td>
											<td style="width:10%;"><?php echo $row['fromdate'];?></td>
											<td style="width:10%;"><?php echo $row['todate'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['departmentid'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['type'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['paymenttype'];?></td>
											<!--<td style="width:50%;"><input type='password' value='" . $row["password"]."'readonly='readonly'></td>-->
											
										</tr>
									<?php }?>
								</tbody>
								<span class="temporary-container-input">
									<input type="hidden" id="hide">
								</span>
							</table>
						</div>
					</div>
				</div>
				<!-- end TABLE AREA -->
			</div>
		</div>
	</div>
	<!-- end MAINPANEL -->

<!-- The Modal -->
<div id="myModal" class="modal">
	<!-- Modal content -->
	<div class="modal-container">
		<div class="modal-content">
			<div class="modal-header">
				<div class="col-lg-6">Contract Details</div>
				<div class="col-lg-6"><span class="fas fa-times modal-close"></span></div>
			</div>
			
			<div id="container" class="modal-content-container">
				<form name="myForm" accept-charset="utf-8" action="contractformprocess.php" method="get">
					<div class="row">

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>Contract No:</label>
							<?php 
								$query2 = "SELECT 
											max(ct.linenum) as linenum
											FROM contract ct
											where ct.dataareaid = '$dataareaid' and ct.workerid = '$conid'";
								$result2 = $conn->query($query2);
								$row2 = $result2->fetch_assoc();
								$lastval = $row2["linenum"];
								$maxval = $lastval + 1; 
							?>
							<input type="text" value="<?php echo $conid.'-'.$maxval;?>" placeholder="Contract No." id="add-contract" name="CTcontract" class="modal-textarea" required="required">

							<!--<label>Rate:</label>
							<input type="number" step="1.00" value="0.00" placeholder="" id="add-rate" name="CTrate" class="modal-textarea" required="required">
						</div>

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>Ecola:</label>
							<input type="number" step="1.00" value="0.00" placeholder="" id="add-ecola" name="CTecola" class="modal-textarea" required="required">

							<label>Transpo:</label>
							<input type="number" step="1.00" value="0.00" placeholder="" id="add-transpo" name="CTtranspo" class="modal-textarea" required="required">
						</div>

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>Meal:</label>
							<input type="number" step="1.00" value="0.00" placeholder="" id="add-meal" name="CTmeal" class="modal-textarea" required="required">-->

							<label>Type:</label>
							<select class="formitem width-sm" name ="CTtype" id="add-type" class="modal-textarea" style="width:100%;height: 28px;">
								<option value="" selected="selected"></option>
								<option value="0">Regular</option>
								<option value="1">Reliever</option>
								<option value="2">Probationary</option>
								<option value="3">Contractual</option>
								<option value="4">Trainee</option>
								<option value="5">Project-Based</option>
							</select>
						
							<label>Department:</label>
							<select placeholder="Department" id="add-department" name="CTdeparment" class="modal-textarea" style="width:100%;height: 28px;">
								<option value="" selected="selected"></option>
								<?php
									$query = "SELECT distinct departmentid,name FROM department where dataareaid = '$dataareaid'";
									$result = $conn->query($query);			
									  	
										while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["departmentid"];?>"><?php echo $row["name"];?></option>
									<?php } ?>
							</select>
						</div>

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>Payment Type:</label>
							<select  value="" placeholder="Payment Type" name ="CTpayment" id="add-payment" class="modal-textarea" style="width:100%;height: 28px;" required="required">
									<option value=""></option>
									<option value="0">Cash</option>
									<option value="1">ATM</option>
							</select>
						
							<label>From Date:</label>
							<input type="date" value="" placeholder="" id="add-fromdate" name="CTfromdate" class="modal-textarea" required="required">
						</div>

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

						
							<label>To Date:</label>
							<input type="date" value="" placeholder="" id="add-todate" name="CTtodate" class="modal-textarea">
						</div>

					</div>

					<div class="button-container">
						<button id="addbt" name="save" value="save" class="btn btn-primary btn-action">Save</button>
						<button id="upbt" name="update" value="update" class="btn btn-success btn-action" onclick="return validateForm()">Update</button>
						<button onClick="Clear();" type="button" value="Reset" class="btn btn-danger">Clear</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- end modal-->

<!-- The Modal -->
<!-- The Modal -->
<div id="myModalUpload" class="modal">
	<!-- Modal content -->
	<div class="modal-container">
		<div class="modal-content">
			<div class="modal-header">
				<div class="col-lg-6">File Uploader</div>
				<div class="col-lg-6"><span class="fas fa-times modal-close-i"></span></div>
			</div>
			
			<div id="container" class="modal-content-container">
				<form name="myForm"  action="Contracts/downloadcontract2.php" method="post" enctype="multipart/form-data">
					<div class="row">

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<!-- <label>File Type:</label>
							<input type="text" value="" placeholder="File Type" name ="filetype" id="add-filetype" class="modal-textarea" required="required"> -->

							<label>Choose DOC File:</label><br>
							<input type="file" name="myfile" id="myfile" required="required">

							<p class="help-block">Only Word File is accepted to Print.</p>
							<input type="hidden"  id="add-uploadworkerid" name="uploadworkerid" class="modal-textarea" value="<?php echo $conid; ?>" >
							<input type="hidden"  id="add-uploadcontractid" name="uploadcontractid" class="modal-textarea" >
							
						</div>
						
						

					</div>

					<div class="button-container">
						<button type="submit" id="addbtUpload" name="saveUpload" value="saveUpload" class="btn btn-primary btn-action" >Upload</button>
						
						<button onClick="test()" type="button" value="Reset" class="btn btn-danger" >Clear</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- end modal-->
<!-- end modal-->

<!-- begin [JAVASCRIPT] -->
<script src="js/ajax.js"></script>
	<script  type="text/javascript">

	  	var so='';
	  	//var locWorkerId = "";
		var locContract = "";
		var locRate = "";
		var locEcola = "";
		var locTranspo = "";
		var locMeal = "";
		var locType = "";
		var locDepartment = "";
		var locPayment = "";
		var locFromdate = "";
		var locTodate = "";
  		$(document).ready(function(){
			$('#datatbl tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","red");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
				locRate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
				locEcola = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();
				locTranspo = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(4)").text();
				locMeal = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(5)").text();
				locType = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(12)").text();
				locDepartment = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(11)").text();
				locPayment = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(13)").text();
				locFromdate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(9)").text();
				locTodate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(10)").text();
				so = usernum.toString();
				document.getElementById("hide").value = so;
				//alert(document.getElementById("hide").value);
				//alert(so);
				document.getElementById("add-uploadcontractid").value = so;	
					  
			});
		});

		// Get the modal -------------------
		var modal = document.getElementById('myModal');
		// Get the button that opens the modal
		var CreateBtn = document.getElementById("myAddBtn");
		var UpdateBtn = document.getElementById("myUpdateBtn");
		// Get the <span> element that closes the modal
		var span = document.getElementsByClassName("modal-close")[0];
		// When the user clicks the button, open the modal 
		CreateBtn.onclick = function() {
			$("#myModal").stop().fadeTo(500,1);
		    //modal.style.display = "block";
		    $("#add-contract").prop('readonly', true);
		    //document.getElementById("add-id").value = '';
		    document.getElementById("upbt").style.visibility = "hidden";
		    document.getElementById("addbt").style.visibility = "visible";
		}
		UpdateBtn.onclick = function() {
			if(so != '') {
			    modal.style.display = "block";
			    $("#add-contract").prop('readonly', true);
			   
				document.getElementById("add-contract").value = so;
				document.getElementById("add-type").value = locType.toString();
				document.getElementById("add-department").value = locDepartment.toString();
				document.getElementById("add-payment").value = locPayment.toString();
				document.getElementById("add-fromdate").value = locFromdate.toString();
				document.getElementById("add-todate").value = locTodate.toString();
			    document.getElementById("addbt").style.visibility = "hidden";
			    document.getElementById("upbt").style.visibility = "visible";
			}
			else 
			{
				alert("Please Select a record you want to update.");
			}
		}
		// When the user clicks on <span> (x), close the modal
		span.onclick = function() {
		    modal.style.display = "none";
		    Clear();
		}
		// When the user clicks anywhere outside of the modal, close it
		/*window.onclick = function(event) {
		    if (event.target == modal || event.target == modal2) {
		        modal.style.display = "none";
		        Clear();
		        
		    }
		}*/
		//end modal ---------------------------

		function validateForm() {
		  var x = document.forms["myForm"]["update"].value;
		  if (x == "update") {
		    if(confirm("Are you sure you want to update this record?")) {
		    	return true;
		    }
		    else
		    {
		    	modal.style.display = "none";
		    	Clear();
		    	return false;
		    }
		  }
		}

		

  		//-----search-----//
		$( ".search" ).on( "keydown", function(event) {
		  if(event.which == 13){
			var search = document.getElementsByClassName('search');
			var slocWorkerId = "";
			var slocName = "";
			var slocVoucher = "";
			var slocSubtype = "";
			var slocLoantype = "";
			var slocAccount = "";
			var slocLoandate = "";
			var slocLoanamount = "";
			var slocAmortization = "";
			var slocBalance = "";
			var slocFromdate = "";
			var slocTodate = "";

			var action = "searchdata";
			var actionmode = "userform";
			var data=[];
			 for(i=0;i<search.length;i++){
				 data[i]=search[i].value;
				 //search[i].value = "";
			 }
			 
			 slocWorkerId = data[0];
			 slocName = data[1];
			 slocVoucher = data[2];
			
			 $.ajax({
						type: 'GET',
						url: 'loanfileformprocess.php',
						data:{action:action, actmode:actionmode, slocWorkerId:slocWorkerId, slocName:slocName, slocVoucher:slocVoucher},
						//data:'bkno='+BNo+'&bkdesc='+BDesc+'&bktit='+BTit+'&bkqty='+BQ,
						beforeSend:function(){
						
							$("#result").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
			
						},
						success: function(data){
							$('#result').html(data);
				}
			}); 
			 
		  }
		});
		//-----end search-----//

		function Clear()
		{
			if(so != '') {
				//document.getElementById("add-id").value = "";
				document.getElementById("add-prefix").value = "";
				document.getElementById("add-first").value = "";
				document.getElementById("add-last").value = "";
				document.getElementById("add-format").value = "";
				document.getElementById("add-next").value = "";
				document.getElementById("add-suffix").value = "";
			}
			else
			{
				document.getElementById("add-id").value = "";
				document.getElementById("add-prefix").value = "";
				document.getElementById("add-first").value = "";
				document.getElementById("add-last").value = "";
				document.getElementById("add-format").value = "";
				document.getElementById("add-next").value = "";
				document.getElementById("add-suffix").value = "";
			}
		}

		function Save()
		{
			
			modal.style.display = "none";
			/*var UId = document.getElementById("add-UserId");
			var UPass = document.getElementById("add-pass");
			var NM = document.getElementById("add-name");
			var DT = document.getElementById("add-dataareaid");*/
			var NumId = $('#add-id').val();
			var NumPrefix = $('#add-prefix').val();
			var NumFirst = $('#add-first').val();
			var NumLast = $('#add-last').val();
			var NumFormat = $('#add-format').val();
			var NumNext = $('#add-next').val();
			var NumSuffix = $('#add-suffix').val();
			var action = "save";
			var actionmode = "userform";
			$.ajax({	
					type: 'GET',
					url: 'numbersequenceprocess.php',
					//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
					data:{action:action, actmode:actionmode, NumId:NumId, NumPrefix:NumPrefix, NumFirst:NumFirst, NumLast:NumLast, NumFormat:NumFormat, NumNext:NumNext, NumSuffix:NumSuffix},
					beforeSend:function(){
							
					$("#datatbl").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
						
					},
					success: function(data){
					//$('#datatbl').html(data);
					location.reload();					
					}
			}); 
						
		}

		function Update()
		{
			
			modal.style.display = "none";
			/*var UId = document.getElementById("add-UserId");
			var UPass = document.getElementById("add-pass");
			var NM = document.getElementById("add-name");
			var DT = document.getElementById("add-dataareaid");*/
			var NumId = $('#add-id').val();
			var NumPrefix = $('#add-prefix').val();
			var NumFirst = $('#add-first').val();
			var NumLast = $('#add-last').val();
			var NumFormat = $('#add-format').val();
			var NumNext = $('#add-next').val();
			var NumSuffix = $('#add-suffix').val();
			var action = "update";
			var actionmode = "userform";
			if(so != '') {
				if(confirm("Are you sure you want to update this record?")) {
					$.ajax({	
							type: 'GET',
							url: 'numbersequenceprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action, actmode:actionmode, NumId:NumId, NumPrefix:NumPrefix, NumFirst:NumFirst, NumLast:NumLast, NumFormat:NumFormat, NumNext:NumNext, NumSuffix:NumSuffix},
							beforeSend:function(){
									
							$("#datatbl").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
								
							},
							success: function(data){
							//$('#conttables').html(data);
							location.reload();					
							}
					}); 
				}
				else 
				{
					return false;
				}
			}
			else 
			{
				alert("Please Select a record you want to update.");
			}			
		}

		function Delete()
		{
			
			var action = "delete";
			var actionmode = "userform";
			if(so != '') {
				if(confirm("Are you sure you want to remove this record?")) {
					$.ajax({	
							type: 'GET',
							url: 'contractformprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action, actmode:actionmode, CTcontract:so},
							beforeSend:function(){
									
							$("#datatbl").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
								
							},
							success: function(data){
							//$('#conttables').html(data);
							location.reload();					
							}
					}); 
				}
				else 
				{
					return false;
				}
			}
			else 
			{
				alert("Please Select a record you want to delete.");
			}			
		}

		function WorkerFrm()
		{
			var action = "worker";
			/*$.ajax({
				type: 'GET',
				url: 'contractformprocess.php',
				data:{action:action, WorkId:so},
				success: function(data) {
				    window.location.href='workerform.php';
			    }
			});*/
			window.location.href='workerform.php';
		}

		function RateFrm()
		{
			var action = "rate";
			if(so != ''){
				$.ajax({
					type: 'GET',
					url: 'contractformprocess.php',
					data:{action:action, WorkId:so},
					success: function(data) {
					    window.location.href='rateform.php';
				    }
				});
			}
			else {
				alert("Please Select Contract No.");
			}
		}

		function downloadcontract(){
			if( document.getElementById("hide").value == ""){
				alert("no selected contract");
			}else{
				var workerid = "<?php echo $conid; ?>";
				var contractid = document.getElementById("hide").value;
				var filePath=$('#myfile').val();


				alert(filePath);
				window.open('Contracts/downloadcontract.php?workerid='+workerid+'&contractid='+contractid+'&filepath='+filePath, "_blank");
			}
			

		}


		// Get the modal -------------------
		var modalUpload = document.getElementById('myModalUpload');
		// Get the button that opens the modal
		var UploadBtn = document.getElementById("myUploadBtn");
		// Get the <span> element that closes the modal
		var Uploadspan = document.getElementsByClassName("modal-close-i")[0];
		// When the user clicks the button, open the modal 
		UploadBtn.onclick = function() {
		    //modal.style.display = "block";
		    if(so == '')
		    {
		    	alert("Select Contract");
		    }
		    else
		    {
		    	 $("#myModalUpload").stop().fadeTo(500,1);
		   
			    document.getElementById("add-filetype").value = '';
			    document.getElementById("myfile").value = '';

			    
			    document.getElementById("addbtUpload").style.visibility = "visible";
		    }
		   
		}
		
		// When the user clicks on <span> (x), close the modal
		Uploadspan.onclick = function() {
		    modalUpload.style.display = "none";
		   // Clear();
		}
		
		//end modal ---------------------------

	</script>
<script type="text/javascript" src="js/custom.js"></script>
<!-- end [JAVASCRIPT] -->

</body>
</html>