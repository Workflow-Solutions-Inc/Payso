<?php
session_id("payso");
session_start();
include("dbconn.php");
#$user = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];

if(isset($_SESSION['WKNumLoan']))
{
	$wkidLoan = $_SESSION['WKNumLoan'];
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
	<title>Loan Wizard</title>

	<!--<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="css/fontawesome.min.css" />
	<link rel="stylesheet" type="text/css" href="css/typography.css" />
	<link rel="stylesheet" type="text/css" href="css/custom.css" />
	<script src="js/jquery.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>

</head>
<body>-->
<style>


/* Style the tab */
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
  color: #656565;
}

/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
  font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #fff;
}

/* Style the tab content */
.tabcontent {
  display: none;
  padding: 6px 12px;
  border: 0px solid #ccc;
  /*border-top: none;*/
}
.loanwizard-step {
	text-align: center;
	padding: 20px 0px 10px 0px;
}
.loanwizard-title {
	background: #317fdf;
	color: #fff;
	padding: 10px 15px;
	margin-bottom: 30px;
}
</style>

	<!-- begin HEADER -->
	<?php require("inc/header.php"); ?>
	<!-- end HEADER -->


	<!-- begin LEFT PANEL -->
	<div id="leftpanel" class="leftpanel">

		<?php require("inc/leftpanel.php"); ?>

		<!-- sub buttons -->
		<ul class="subbuttons">
			<div class="leftpanel-title"><b>COMMANDS</b></div>
			<li><button onClick="Cancel();"><span class="fa fa-arrow-circle-left fa-lg"></span> Back</button></li>
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
							<span class="fa fa-archive"></span> Loan Wizard
						</div>
						<!-- tableheader -->
						<div id="calculator-container" class="calculator-container">
							<div class="calculator card">
								<div id="Step1" class="tabcontent">
									<div class="loanwizard-step"><img src="images/loanwizard1.png" class="img-fluid"></div>
									<h3 class="loanwizard-title"><i class="fas fa-mouse-pointer"></i> Loan &amp; Account Selection</h3>
									<h3>Instruction/s:</h3>
									<p>- Please select a specific Loan Type from the drop down menu list.</p>
									<p>- Click find button to select a specific account then click next.</p>

									<div class="half">
										<div class="row">
											<div class="formset">

												<!-- left -->
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
													
													<div class="formitem" style="margin-left: 0px;">
														<span class="label-xl" style="width: 140px;">Worker ID:</span>
														<input type="textbox" name ="loan-workerid" id="loan-workerid" value="<?php echo $wkidLoan; ?>"  class="textbox" readonly>
													</div>

													<div class="formitem" style="margin-left: 0px;">
														<span class="label-xl" style="width: 97px;">Loan Type:</span>
														<select class="formitem width-sm" name ="loan-loantype" id="loan-loantype" class="textbox width-md" style="width:183px;margin-left: 43px;">
															<option value="" selected="selected"></option>
															<?php
																$query = "SELECT distinct loantypeid,description FROM loantype";
																$result = $conn->query($query);			
																  	
																	while ($row = $result->fetch_assoc()) {
																	?>
																		<option value="<?php echo $row["loantypeid"];?>"><?php echo $row["description"];?></option>
																<?php } ?>
														</select>

													</div>

													<div class="formitem" style="margin-left: 0px;">
														<span class="label-xl" style="width: 140px;">Accounts:</span>
														<input type="textbox" name ="LoanAcc" id="LoanAcc" value="" class="textbox" readonly>
														<button id="calc-ac" style="height: 30px"><span class="fas fa-search fa-xs"></span></button>
													</div>
													
												</div>

											</div>
										</div>
									</div>
									<div class="button-container" >
										<button id="btnstep1" value="step1" onclick="NextStep(this.value);" class="btn btn-primary"><span class="fa fa-arrow-circle-right fa-lg"></span> Next</button>
									</div>

										
									
								</div>

								<div id="Step2" class="tabcontent">
									<div class="loanwizard-step"><img src="images/loanwizard2.png" class="img-fluid"></div>
									<h3 class="loanwizard-title"><i class="far fa-list-alt"></i> Loan Details</h3>
									<h3>Instruction/s:</h3>
									<p>- Fill up all the necessary given fields below before proceeeding to next step.</p>
									

									<div class="half" style="border: 0px solid gray;">
										<div class="row">
											<div class="formset">

											<!-- left -->
											<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" >
												
												<div class="formitem">
													<span class="label-xl" style="width: 140px;">Voucher:</span>
													<div id="loan-voucherno">
														<input type="textbox" name ="loan-voucher" id="loan-voucher" value=""  class="textbox width-full">
													</div>
												</div>

												<div class="formitem" >
													<span class="label-xl" style="width: 140px;">Sub Type:</span>
													<input type="textbox" name ="loan-subtype" id="loan-subtype" value="" class="textbox width-full">
												</div>

												<div class="formitem" >
													<span class="label-xl" style="width: 140px;">Loan Amount:</span>
													<input type="textbox" name ="loan-amount" id="loan-amount" value="" class="textbox width-full" onkeyup="Recom()">
												</div>

												<div class="formitem" >
													<span class="label-xl" style="width: 180px;">Amortization Amount:</span>
													<input type="textbox" name ="loan-amortization" id="loan-amortization" value="0" class="textbox width-full" readonly>
												</div>

												<div class="formitem" >
													<span class="label-xl" style="width: 140px;">Interest:</span>
													<input type="textbox" name ="loan-interest" id="loan-interest" value="0" class="textbox width-full" onkeyup="Recom()">
												</div>
												
											</div>


											<!-- left -->
											<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" >
												
												<div class="formitem">
													<span class="label-xl">Loan Date:</span>
													<input type="date" name ="loan-loandate" id="loan-loandate" value="" class="textbox width-full">
												</div>

												<div class="formitem">
													<span class="label-xl">From Date:</span>
													<input type="date" name ="loan-fromdate" id="loan-fromdate" value="" class="textbox width-full">
												</div>

												<div class="formitem">
													<span class="label-xl">To Date:</span>
													<input type="date" name ="loan-todate" id="loan-todate" value="" class="textbox width-full">
												</div>

												<div class="formitem">
													<span class="label-xl">No. of Cut-off:</span>
													<input type="number" name ="loan-cutoff" id="loan-cutoff" value="1" class="textbox width-full" onkeyup="Recom()">
													<!--<button id="sampbtn" onclick="samplealert();" style="height: 30px"><span class="fas fa-search fa-xs"></span></button>-->
												</div>
												
											</div>

											</div>
										</div>
									</div>
									<div class="button-container">
										<button id="btnback2" value="back2" onclick="NextStep(this.value);" class="btn btn-primary btn-danger"><span class="fa fa-arrow-circle-left fa-lg"></span> Back</button>
										<button id="btnstep2" value="step2" onclick="NextStep(this.value);" class="btn btn-primary"><span class="fa fa-arrow-circle-right fa-lg"></span> Next</button>
									</div>

								</div>

								<div id="Step3" class="tabcontent">
									<div class="loanwizard-step"><img src="images/loanwizard3.png" class="img-fluid"></div>
									<h3 class="loanwizard-title"><i class="fas fa-clipboard-check"></i> Details Overview</h3>
									<h3>Overview:</h3>
									<p>Note: Please review all the details before proceeding.</p>
									

									<div class="" style="border: 0px solid gray;">
										<div class="row">
											<div class="formset">

											<!-- left -->
											<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" style="border: 1px solid gray;margin-left: 20px;">
												
												<div class="formitem" >
													<span class="label-xl" style="width: 100px;">Loan Type:</span>
													<input type="textbox" name ="view-loantype" id="view-loantype" style="width: 150px;" class="textbox width-full" value="" readonly>
												</div>
												<div class="formitem" >
													<span class="label-xl" style="width: 100px;">Account:</span>
													<input type="textbox" name ="view-account" id="view-account" style="width: 150px;" class="textbox width-full" value="" readonly>
												</div>

												
												
											</div>


											<!-- left -->
											<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12" style="border: 1px solid gray;margin-left: 20px;"> 
												
												<div class="formitem">
													<span class="label-xl" style="width: 180px;">Voucher:</span>
													<input type="textbox" name ="view-voucher" id="view-voucher" style="width: 150px;" class="textbox width-full" value="" readonly>
												</div>

												<div class="formitem">
													<span class="label-xl" style="width: 180px;">Sub Type:</span>
													<input type="textbox" name ="view-subtype" id="view-subtype" style="width: 150px;" class="textbox width-full" value="" readonly>
												</div>

												<div class="formitem">
													<span class="label-xl" style="width: 180px;">Loan Amount:</span>
													<input type="textbox" name ="view-loanamount" id="view-loanamount" style="width: 150px;" class="textbox width-full" value="" readonly>
												</div>

												<div class="formitem">
													<span class="label-xl" style="width: 180px;">Amortization Amount:</span>
													<input type="textbox" name ="view-amortization" id="view-amortization" style="width: 150px;" class="textbox width-full" value="" readonly>
												</div>

												<div class="formitem">
													<span class="label-xl" style="width: 180px;">Loan Date:</span>
													<input type="date" name ="view-loandate" id="view-loandate" style="width: 150px;" class="textbox width-full" value="" readonly>
												</div>

												<div class="formitem">
													<span class="label-xl" style="width: 180px;">From Date:</span>
													<input type="date" name ="view-fromdate" id="view-fromdate" style="width: 150px;" class="textbox width-full" value="" readonly>
												</div>

												<div class="formitem">
													<span class="label-xl" style="width: 180px;">To Date:</span>
													<input type="date" name ="view-todate" id="view-todate" style="width: 150px;" class="textbox width-full" value="" readonly>
												</div>
												
											</div>

											</div>
										</div>
									</div>
									<div class="button-container">
										<button id="btnback3" value="back3" onclick="NextStep(this.value);" class="btn btn-primary btn-danger"><span class="fa fa-arrow-circle-left fa-lg"></span> Back</button>
										<button id="btnstep3" value="step3" onclick="NextStep(this.value);" class="btn btn-primary"><span class="fa fa-arrow-circle-right fa-lg"></span> Finish</button>
									</div>
								</div>
							</div>
						</div>
						<!--right pannel-->
						<div id="container1" class="half widthsplit">
							<table width="100%" border="1" id="datatbl" class="table table-striped mainpanel-table">
								<thead>	
									<tr class="rowB rowtitle">
										<td style="width:20px;" class="text-center"><span class="fa fa-asterisk fa-xs"></span></td>
										<td style="width:25%;">Include</td>
										<td style="width:25%;">Account Code</td>
										<td style="width:25%;">Name</td>
										<td style="width:25%;">Name</td>
										<td style="width: 17px;" class="text-center"><span class="fas fa-arrows-alt-v"></span></td>
									</tr>
									<tr class="rowsearch">
									  <td class="text-center"><span class="fas fa-search fa-xs"></span></td>
										
									  <td><input list="SearchCode" class="search" disabled>
										<?php
											$query = "SELECT distinct accountcode FROM accounts where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchCode">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["accountcode"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchName" class="search" disabled>
										<?php
											$query = "SELECT distinct name FROM accounts where dataareaid = '$dataareaid'";
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
									  <td><input list="SearchUm" class="search" disabled>
										<?php
											$query = "SELECT distinct um FROM accounts where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchUm">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["um"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchType" class="search" disabled>
										<?php
											$query = "SELECT distinct case when accounttype = 0 then 'Entry'
														when accounttype = 1 then 'Computed'
														when accounttype = 2 then 'Condition'
														else 'Total'
														end as accounttype FROM accounts where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchType">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["accounttype"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><span></span></td>
									</tr>
								</thead>
								<tbody id="result">
									<?php					
									$query = "SELECT autoinclude,
														accountcode,
														name,
														label,
														um,
														case when accounttype = 0 then 'Entry'
															when accounttype = 1 then 'Computed'
															when accounttype = 2 then 'Condition'
														else 'Total'
														end as accounttype,
														case when category = 0 then 'Lines'
														else 'Header' 
														end as category,
														formula,
														format(defaultvalue,2) defaultvalue,
														priority
														FROM accounts
														where dataareaid = '$dataareaid'
														order by priority asc";
									$result = $conn->query($query);
									$rowclass = "rowA";
									$rowcnt = 0;
									$rowcnt2 = 0;
									$lastrec ='';
									$collection = '';
									while ($row = $result->fetch_assoc())
									{ ?>
										<?php
											$rowcnt++;
											$rowcnt2++;
											if($rowcnt > 1) { $rowcnt = 0; $rowclass = "rowB"; }
											else { $rowclass = "rowA"; }
											$collection = $collection.','.$row['accountcode'];
										?>
										<tr id="<?php echo $row['accountcode'];?>" class="<?php echo $rowclass; ?>" tabindex="<?php echo $rowcnt2; ?>">
											<!--<td style="width:10px;"><input type='checkbox' name="chkbox" value="" id="myCheck"></td>-->
											<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
											<td style="width:25%;"><?php echo $row['accountcode'];?></td>
											<td style="width:25%;"><?php echo $row['name'];?></td>
											<td style="width:25%;"><?php echo $row['um'];?></td>
											<td style="width:25%;"><?php echo $row['accounttype'];?></td>
											
										</tr>
									<?php 
									
									}
										
										
									?>
								</tbody>
								<span class="temporary-container-input">
									<input type="hidden" id="hide" value="">
								</span>
							</table>
							<div class="button-ok">
								<button class="btn btn-danger btn-lg calc-confirmation">Cancel</button>
								<button class="btn btn-primary btn-lg calc-confirmation" onclick="AccInput();">Select</button>
							</div>
						</div>
						<!--right pannel-->
						

					</div>
				</div>
				<!-- end TABLE AREA -->
			</div>
		</div>
	</div>
	<!-- end MAINPANEL -->



<!-- begin [JAVASCRIPT] -->
<script src="js/ajax.js"></script>
	 <script  type="text/javascript">
	 	

  		var so='';
	  	//var locAmortAmount=0;
		var locAccName;
		var locAccUm;
		var locAccType;
		
  		$(document).ready(function(){
			$('#datatbl tbody tr').click(function(){
				//$('table tbody tr').css('background-color','');
				//$(this).css('background-color','#ffe6cb');
				$('table tbody tr').css("color","black");
				$(this).css("color","red");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
				locAccName = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
				locAccUm = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();
				locAccType = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(4)").text();
				
				
				so = usernum.toString();
				document.getElementById("hide").value = so;	
				//alert(usernum);
				//alert(locAccName);	
			});
		});
  		/*$('#calc-ac').click(function() {
			document.getElementById("AccountCont").style.display = "block";
		});
		$('#AccCancel').click(function() {
			document.getElementById("AccountCont").style.display = "None";
		});*/
		function AccInput()
		{
			document.getElementById('LoanAcc').value = so;
			//document.getElementById("AccountCont").style.display = "None";
		}

		$('#calc-ac').click(function() {
		document.getElementById("container1").style.display = "block";
		$('#calculator-container').addClass('visibleall').not('visibleall');
		$('#container1').addClass('visibleall').not('visibleall');
		
		});
		
		$('.calc-confirmation').click(function() {
			$('#calculator-container').removeClass('visibleall').hasClass("visibleall");
			$('#container1').removeClass('visibleall').hasClass("visibleall");
		});



		$(document).ready(function() {
		    $('#OverView').addClass("active");
		    document.getElementById("Step1").style.display = "block";
		    $('#London2').addClass("active");
		    
		});

		function NextStep(StepVal)
		{
			locWorkerid = document.getElementById('loan-workerid').value;
			locLoanType = document.getElementById('loan-loantype').value;
			locLoanAccount = document.getElementById('LoanAcc').value;

			locVoucher = document.getElementById('loan-voucher').value;
			locSubType = document.getElementById('loan-subtype').value;
			locLoan = document.getElementById('loan-amount').value;
			locAmort = document.getElementById('loan-amortization').value;
			locInterest = document.getElementById('loan-interest').value;
			locLoanDate = document.getElementById('loan-loandate').value;
			locFromdate = document.getElementById('loan-fromdate').value;
			locToDate = document.getElementById('loan-todate').value;
			locCutoff = document.getElementById('loan-cutoff').value;

			var d = new Date();
			var x = new Date(document.getElementById("loan-fromdate").value.toLowerCase());
			d.setDate(d.getDate());

			if(StepVal == "step1")
			{
				

				/*if(locLoanType == '' || locLoanAccount == '')
				{*/
					//alert(StepVal);
					if(locLoanType == 'CADV')
					{
						var action = "add-CA";
					    $.ajax({
									type: 'GET',
									url: 'loanwizardprocess.php',
									data:{action:action},
									//data:'bkno='+BNo+'&bkdesc='+BDesc+'&bktit='+BTit+'&bkqty='+BQ,
									beforeSend:function(){
										document.getElementById('loan-voucher').value = '';
										//$("#result").html('<img src="img/loading.gif" width="300" height="300">');
						
									},
									success: function(data){
										$('#loan-voucherno').html(data);
										$("#loan-voucher").prop('readonly', true); 
							}
						});

						document.getElementById('Step1').style.display = "None";
						document.getElementById('Step2').style.display = "block";
						//alert(document.getElementById("view-payrollid").value);
						$("#Step1").removeClass("active");
						$("#Step2").addClass("active");
					}
					else if(locLoanType == 'ELOAN')
					{
						var action = "add-EL";
					    $.ajax({
									type: 'GET',
									url: 'loanwizardprocess.php',
									data:{action:action},
									//data:'bkno='+BNo+'&bkdesc='+BDesc+'&bktit='+BTit+'&bkqty='+BQ,
									beforeSend:function(){
										document.getElementById('loan-voucher').value = '';
										//$("#result").html('<img src="img/loading.gif" width="300" height="300">');
						
									},
									success: function(data){
										$('#loan-voucherno').html(data);
										$("#loan-voucher").prop('readonly', true); 
							}
						});

						document.getElementById('Step1').style.display = "None";
						document.getElementById('Step2').style.display = "block";
						//alert(document.getElementById("view-payrollid").value);
						$("#Step1").removeClass("active");
						$("#Step2").addClass("active");
					}
					else
					{
						$("#loan-voucher").prop('readonly', false); 
						document.getElementById('loan-voucher').value = '';
						document.getElementById('Step1').style.display = "None";
						document.getElementById('Step2').style.display = "block";
						//alert(document.getElementById("view-payrollid").value);
						$("#Step1").removeClass("active");
						$("#Step2").addClass("active");
					}
					
				/*}
				else
				{
					alert("Please Fill up Loan Type and Accounts");
				}*/
				
			}
			else if(StepVal == "step2")
			{
				if(locCutoff == 0 || locCutoff == '' || locCutoff < 0)
				{
					alert("No. of Cut-off must be greater than 0");
				}
				else
				{
					if(locLoan == 0 || locLoan == '' || locLoan < 0)
					{
						alert("Loan Amount must be greater than 0");
					}
					else
					{
						if(locFromdate != '')
						{
							if(locFromdate > locToDate)
				 			{
				 				alert("To Date must be greater then From Date");
				 				
				 			}
				 			else
				 			{
				 				document.getElementById('view-loantype').value = document.getElementById('loan-loantype').value;
								document.getElementById('view-account').value = document.getElementById('LoanAcc').value;

								document.getElementById('view-voucher').value= document.getElementById('loan-voucher').value;
								document.getElementById('view-subtype').value = document.getElementById('loan-subtype').value;
								document.getElementById('view-loanamount').value = document.getElementById('loan-amount').value;
								document.getElementById('view-amortization').value = document.getElementById('loan-amortization').value;
								document.getElementById('view-loandate').value = document.getElementById('loan-loandate').value;
								document.getElementById('view-fromdate').value = document.getElementById('loan-fromdate').value;
								document.getElementById('view-todate').value = document.getElementById('loan-todate').value;
								

								document.getElementById('Step2').style.display = "None";
								document.getElementById('Step3').style.display = "block";
								$("#Step2").removeClass("active");
								$("#Step3").addClass("active");
				 			}
						}
						else
						{
							alert("Please select date.");
						}
						

					}
					
				}
					
				
			}
			else if(StepVal == "back2")
			{
				document.getElementById('Step2').style.display = "None";
				document.getElementById('Step1').style.display = "block";
				$("#Step2").removeClass("active");
				$("#Step1").addClass("active");
			}
			else if(StepVal == "back3")
			{
				document.getElementById('Step3').style.display = "None";
				document.getElementById('Step2').style.display = "block";
				$("#Step3").removeClass("active");
				$("#Step2").addClass("active");
			}
			else if(StepVal == "step3")
			{
				locWorkerid = document.getElementById('loan-workerid').value;
				locFromdate = document.getElementById('loan-fromdate').value;
				locToDate = document.getElementById('loan-todate').value;
				locVoucher = document.getElementById('loan-voucher').value;
				locSubType = document.getElementById('loan-subtype').value;
				locLoanType = document.getElementById('loan-loantype').value;
				locLoanAccount = document.getElementById('LoanAcc').value;
				locAmort = document.getElementById('loan-amortization').value;
				locBalance = parseInt(document.getElementById('loan-amount').value) + parseInt(document.getElementById('loan-interest').value);
				locLoanAmount = document.getElementById('loan-amount').value;
				locLoanDate = document.getElementById('loan-loandate').value;

				var action = "finish";
				    $.ajax({
								type: 'GET',
								url: 'loanwizardprocess.php',
								data:{action:action, locWorkerid:locWorkerid, locFromdate:locFromdate, locToDate:locToDate, locVoucher:locVoucher, locSubType:locSubType, locLoanType:locLoanType, locLoanAccount:locLoanAccount, locAmort:locAmort, locBalance:locBalance, locLoanAmount:locLoanAmount, locLoanDate:locLoanDate},
								//data:'bkno='+BNo+'&bkdesc='+BDesc+'&bktit='+BTit+'&bkqty='+BQ,
								beforeSend:function(){
									//document.getElementById('loan-voucher').value = '';
									//$("#Step3").html('<img src="img/loading.gif" width="300" height="300">');
					
								},
								success: function(data){
									//$('#Step3').html(data);
									//alert("Done Processing.");
									//$('#loan-voucherno').html(data);
									//$("#loan-voucher").prop('readonly', true); 
									window.location.href='loanfileform.php';
						}
					});

				/*document.getElementById('Step2').style.display = "None";
				document.getElementById('Step3').style.display = "block";
				$("#Step2").removeClass("active");
				$("#Step3").addClass("active");*/
				//alert(locBalance);
				//alert("Finish");
			}


			//document.getElementById(StepVal).style.display = "block";
			//alert(document.getElementById("view-payrollid").value);
			//$("#"+StepVal+"").addClass("active");
		}
		$("#loan-cutoff").bind('keyup mouseup', function () {
		   Recom();
		});
		function Recom()
		{
			var locAmortAmount = 0;
			var comLoan = document.getElementById('loan-amount').value;
			var comInterest = document.getElementById('loan-interest').value;
			var comCutoff = document.getElementById('loan-cutoff').value;

			//alert(comCutoff);
			if(comCutoff != 0)
			{
				if(comInterest == '')
				{
					comInterest = 0;
				}
				if(comLoan == '')
				{
					comLoan = 0;
				}
				locAmortAmount = (parseInt(comLoan) + parseInt(comInterest)) / parseInt(comCutoff);
				document.getElementById('loan-amortization').value = locAmortAmount;
			}
			else
			{
				document.getElementById('loan-amortization').value = 0;
			}
			
			//locAmortAmount = locAmortAmount + 1;
			//alert(locAmortAmount);
		}
		/*function openCity(evt, cityName) {
		  var i, tabcontent, tablinks;
		  tabcontent = document.getElementsByClassName("tabcontent");
		  for (i = 0; i < tabcontent.length; i++) {
		    tabcontent[i].style.display = "none";
		  }
		  tablinks = document.getElementsByClassName("tablinks");
		  for (i = 0; i < tablinks.length; i++) {
		    tablinks[i].className = tablinks[i].className.replace(" active", "");
		  }
		  document.getElementById(cityName).style.display = "block";
		  evt.currentTarget.className += " active";
		}*/

	
		function Activate(val)
		{
			
			//so = document.getElementById("hide").value;
			if(val == "0")
			{
				alert(val);
				/*flaglocation = 'workSummary';
				$('#SSbtn').css("display", "None");
				$('#WSbtn').css("display", "Block");
				$('#OverView').addClass("active");
				$('#Summary').removeClass("active");

				//-----------get line--------------//
				var action = "getline";
				var actionmode = "userform";
				$.ajax({
					type: 'POST',
					url: 'dtrwork.php',
					data:{action:action, actmode:actionmode, transval:so},
					beforeSend:function(){
					
						$("#dtrContent").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
					},
					success: function(data){
						//payline='';
						//document.getElementById("hide2").value = "";
						$('#dtrContent').html(data);
					}
				}); 
				//-----------get line--------------//*/
				
			}

			else
			{
				alert(val);
				/*flaglocation = 'schedSummary';
				$('#SSbtn').css("display", "Block");
				$('#WSbtn').css("display", "None");
				$('#Summary').addClass("active");
				$('#OverView').removeClass("active");

				//-----------get line--------------//
				var action = "getline";
				var actionmode = "userform";
				$.ajax({
					type: 'POST',
					url: 'dtrsummary.php',
					data:{action:action, actmode:actionmode, transval:so},
					beforeSend:function(){
					
						$("#dtrContent").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
					},
					success: function(data){
						//payline='';
						//document.getElementById("hide2").value = "";
						$('#dtrContent').html(data);
					}
				}); 
				//-----------get line--------------//*/

			}
			
			
			
			
		}

		

		function Cancel()
		{
			window.location.href='loanfileform.php';
		}

	</script>
	

	<script type="text/javascript" src="js/custom.js"></script>
	<!-- end [JAVASCRIPT] -->

</body>
</html>