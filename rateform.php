<?php 
session_start();
session_regenerate_id();
include("dbconn.php");
$user = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];

if(isset($_SESSION['contract']))
{
	$conid = $_SESSION['contract'];
}
else
{
	header('location: contractform.php');
}

?>

<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Rate</title>

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
			<li><button id="myDelBtn" onClick="Delete();"><span class="fa fa-trash-alt"></span> Delete Record</button></li>
			<li><button id="myUpdateBtn"><span class="fa fa-edit"></span> Update Record</button></li>
		</ul>
		
		<!-- extra buttons -->
		<ul class="extrabuttons">
			<li><button id="myActBtn" onClick="ActivateRate();"><span class="fa fa-plus"></span> Activate Rate</button></li>
		</ul>

		<!-- sub buttons -->
		<ul class="subbuttons">
			<li><button onClick="ContractFrm();"><span class="fa fa-arrow-circle-left fa-lg"></span> Back</button></li>
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
										<td style="width:8%;">ACT M-Rate</td>							
										<td style="width:14%;">Rate</td>
										<td style="width:14%;">Monthly Rate</td>
										<td style="width:14%;">Transportation</td>
										<td style="width:14%;">Meal</td>
										<td style="width:14%;">From Date</td>
										<td style="width:14%;">To Date</td>
										<td style="width:14%;">Status</td>
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
									  <td><input list="SearchMrate" class="search" disabled>
										<?php
											$query = "SELECT distinct todate FROM loanfile where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchMrate">
										
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
									$query = "SELECT format(rh.rate,2) as rate,format(rh.mrate,2) as mrate,format(rh.transpo,2) transpo,format(rh.meal,2) as meal,
														STR_TO_DATE(rh.fromdate, '%Y-%m-%d') as fromdate,
														STR_TO_DATE(rh.todate, '%Y-%m-%d') as todate,
														case when rh.status = 0 then 'Created'
															when rh.status = 1 then 'Activated'
															when rh.status = 2 then 'Closed'
															else '' end as status,
														rh.linenum,
														rh.activemrate

														FROM ratehistory rh 

												where rh.dataareaid = '$dataareaid' and rh.contractid = '$conid'

												order by rh.contractid";
									$result = $conn->query($query);
									while ($row = $result->fetch_assoc())
									{ ?>
										<tr class="<?php echo $rowclass; ?>">
											<!--<td style="width:10px;"><input type='checkbox' name="chkbox" value="" id="myCheck"></td>-->
											<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
											<td style="width:8%;"><input type="checkbox" name="chkbox" class="checkbox"  value="true" <?php echo ($row['activemrate']==1 ? 'checked' : '');?> onclick="return false;"><div style="visibility:hidden;height: 1px;"><?php echo $row['activemrate'];?></div></td>
											<td style="width:14%;"><?php echo $row['rate'];?></td>
											<td style="width:14%;"><?php echo $row['mrate'];?></td>
											<td style="width:14%;"><?php echo $row['transpo'];?></td>
											<td style="width:14%;"><?php echo $row['meal'];?></td>
											<td style="width:14%;"><?php echo $row['fromdate'];?></td>
											<td style="width:14%;"><?php echo $row['todate'];?></td>
											<td style="width:14%;"><?php echo $row['status'];?></td>
											
											<td style="display:none;width:1%;"><?php echo $row['linenum'];?></td>
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
				<div class="col-lg-6">Rate Details</div>
				<div class="col-lg-6"><span class="fas fa-times modal-close"></span></div>
			</div>
			
			<div id="container" class="modal-content-container">
				<form name="myForm" accept-charset="utf-8" action="rateformprocess.php" method="get">
					<div class="row">

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>Activate Monthly Rate:</label><br>
							<span><input type="checkbox" value="0" id="add-actrate" class="modal-textarea" style="width: 50px;height: 25px;margin-top: 1px;margin-left: 100px;"></span>
							<br>
						
							<label>Rate:</label>
							<input type="number" step="0.0001" value="0.00" placeholder="" id="add-rate" name="RFrate" class="modal-textarea" required="required">
						
							<label>Monthly Rate:</label>
							<input type="number" step="0.01" value="0.00" placeholder="" id="add-mrate" name="RFmrate" class="modal-textarea" required="required">
						
							<label>Transportation:</label>
							<input type="number" step="0.0001" value="0.00" placeholder="" id="add-transpo" name="RFtranspo" class="modal-textarea" required="required">
						</div>

						

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>Meal:</label>
							<input type="number" step="0.0001" value="0.00" placeholder="" id="add-meal" name="RFmeal" class="modal-textarea" required="required">
						
							
							<label>From Date:</label>
							<input type="date" value="" placeholder="" id="add-fromdate" name="RFfromdate" class="modal-textarea">
						</div>
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>To Date:</label>
							<input type="date" value="" placeholder="" id="add-todate" name="RFtodate" class="modal-textarea">
							<input type="hidden" name ="RFline" id="add-line" value="" class="modal-textarea">
						</div>
						
						
						<input type="hidden" name="actrate" id="actrate" value="0" class="modal-textarea">

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

<!-- begin [JAVASCRIPT] -->
<script src="js/ajax.js"></script>
	<script  type="text/javascript">

	  	var so='';
	  	//var locWorkerId = "";
		var locRate = "";
		var locMrate = "";
		var locTranspo = "";
		var locMeal = "";
		var locFromdate = "";
		var locTodate = "";
		var locStatus = "";
		var locActMrate = "";
  		$(document).ready(function(){
			$('#datatbl tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","red");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(9)").text();
				locActMrate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
				locRate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
				locMrate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();
				locTranspo = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(4)").text();
				locMeal = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(5)").text();
				locFromdate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(6)").text();
				locTodate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(7)").text();
				locStatus = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(8)").text();
				so = usernum.toString();
				document.getElementById("hide").value = so;
				//alert(document.getElementById("hide").value);
				//alert(locMrate);	
				if(locStatus == 'Created')
				{
					document.getElementById("myUpdateBtn").disabled = false;
					document.getElementById("myDelBtn").disabled = false;
					document.getElementById("myActBtn").disabled = false;
				}
				else
				{
					document.getElementById("myUpdateBtn").disabled = true;
					document.getElementById("myDelBtn").disabled = true;
					document.getElementById("myActBtn").disabled = true;
				}
				
					  
			});
		});

		$('#add-actrate').change(function(){
		    if($(this).attr('checked'))
		    {
          		$(this).val('1');
          		document.getElementById("actrate").value =1;
		    }
		    else
		    {
		         $(this).val('0');
		         document.getElementById("actrate").value=0;
		    }
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
			Clear();
		    //modal.style.display = "block";
		    //$("#add-id").prop('readonly', false);
		    //document.getElementById("add-id").value = '';
		    document.getElementById("upbt").style.visibility = "hidden";
		    document.getElementById("addbt").style.visibility = "visible";
		}
		UpdateBtn.onclick = function() {
			if(so != '') {
			    modal.style.display = "block";
			    var uplocRate = locRate.replace(/[A-Za-z!@#$%^&*(),]/g, '');
			    var uplocMrate = locMrate.replace(/[A-Za-z!@#$%^&*(),]/g, '');
			    var uplocTranspo = locTranspo.replace(/[A-Za-z!@#$%^&*(),]/g, '');
			    var uplocMeal = locMeal.replace(/[A-Za-z!@#$%^&*(),]/g, '');
			    if(locActMrate == 1)
			    {
			    	document.getElementById("add-actrate").checked = true;
			    }
			    else
			    {
			    	document.getElementById("add-actrate").checked = false;
			    }
			    document.getElementById("actrate").value = locActMrate;
				document.getElementById("add-rate").value = uplocRate.toString();
				document.getElementById("add-mrate").value = uplocMrate.toString();
				document.getElementById("add-transpo").value = uplocTranspo.toString();
				document.getElementById("add-meal").value = uplocMeal.toString();
				document.getElementById("add-fromdate").value = locFromdate.toString();
				document.getElementById("add-todate").value = locTodate.toString();
				document.getElementById("add-line").value = so;
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
				document.getElementById("actrate").value = 0;
				document.getElementById("add-actrate").checked = false;
				document.getElementById("add-rate").value = "0.00";
				document.getElementById("add-mrate").value = "0.00";
				document.getElementById("add-meal").value = "0.00";
				document.getElementById("add-transpo").value = "0.00";
				document.getElementById("add-fromdate").value = "";
				document.getElementById("add-todate").value = "";
			}
			else
			{
				document.getElementById("actrate").value = 0;
				document.getElementById("add-actrate").checked = false;
				document.getElementById("add-rate").value = "0.00";
				document.getElementById("add-mrate").value = "0.00";
				document.getElementById("add-meal").value = "0.00";
				document.getElementById("add-transpo").value = "0.00";
				document.getElementById("add-fromdate").value = "";
				document.getElementById("add-todate").value = "";
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
							url: 'rateformprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action, actmode:actionmode, RFline:so},
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

		function ContractFrm()
		{
			var action = "contract";
			$.ajax({
				type: 'GET',
				url: 'rateformprocess.php',
				data:{action:action, WorkId:so},
				success: function(data) {
				    window.location.href='contractform.php';
			    }
			});
		}

		function ActivateRate()
		{
			var action = "activate";
			var actionmode = "userform";
			if(so != '') {
				if(confirm("Are you sure you want to activate this rate?")) {
					$.ajax({	
							type: 'GET',
							url: 'rateformprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action, actmode:actionmode, RFline:so},
							beforeSend:function(){
									
							$("#datatbl").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
								
							},
							success: function(data){
							//$('#datatbl').html(data);
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
				alert("Please Select a rate you want to activate.");
			}
		}

	</script>
<script type="text/javascript" src="js/custom.js"></script>
<!-- end [JAVASCRIPT] -->

</body>
</html>