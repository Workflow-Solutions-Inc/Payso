<?php 
session_start();
session_regenerate_id();
include("dbconn.php");
$user = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
?>

<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Payroll Period</title>

	<!--<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="css/fontawesome.min.css" />
	<link rel="stylesheet" type="text/css" href="css/typography.css" />
	<link rel="stylesheet" type="text/css" href="css/custom.css" />
	<script src="js/jquery.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>

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
			<li class="PayrollPeriodMaintain" style="display: none;"><button id="myAddBtn"><span class="fa fa-plus"></span> Create Record</button></li>
			<li class="PayrollPeriodMaintain" style="display: none;"><button onClick="Delete();"><span class="fa fa-trash-alt"></span> Delete Record</button></li>
			<li class="PayrollPeriodMaintain" style="display: none;"><button id="myUpdateBtn"><span class="fa fa-edit"></span> Update Record</button></li>
			<li><button onClick="Cancel();"><span class="fa fa-arrow-circle-left fa-lg"></span> Back</button></li>
		</ul>
		
		<!-- extra buttons -->
		<!--
		<ul class="extrabuttons">
			<li><button><span class="fas fa-arrow-up fa"></span> Move Up</button></li>
			<li><button><span class="fas fa-arrow-down fa"></span> Move Down</button></li>
		</ul>
		-->

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
							<span class="fa fa-archive"></span> Payroll Period
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
							<table width="100%" style="border: 1px solid #d9d9d9;" id="datatbl" class="table mainpanel-table">
								<thead>
									<tr class="rowtitle">
										<td style="width:20px;" class="text-center"><span class="fa fa-asterisk fa-xs"></span></td>
										<td style="width:16%;">Period</td>
										<td style="width:16%;">Payroll Period</td>
										<td style="width:16%;">From Date</td>
										<td style="width:16%;">To Date</td>
										<td style="width:16%;">Payout Date</td>
										<td style="width:16%;">Payroll Group</td>
										<td style="width: 17px;" class="text-center"><span class="fas fa-arrows-alt-v"></span></td>
									</tr>
									<tr class="rowsearch">
									  <td class="text-center"><span class="fas fa-search fa-xs"></span></td>
									  

										<td><input list="SearchPeriod" class="search" disabled>
										<?php
											$query = "SELECT distinct case when period = 0 then 'First Half' else 'Second Half' end as period FROM payrollperiod 
											where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchPeriod">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["period"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchPayroll" class="search">
										<?php
											$query = "SELECT distinct payrollperiod FROM payrollperiod where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchPayroll">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["payrollperiod"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									 
									  <td style="width:14%;"><input type="input" style="width:100%;height: 20px;" list="SearchStartDate" class="search" disabled></td>

									  <td style="width:14%;"><input type="input" style="width:100%;height: 20px;" list="SearchEndDate" class="search" disabled> </td>

									  <td style="width:14%;"><input type="date" style="width:100%;height: 20px;" list="SearchPayrollDate" class="search"></td>

									  <td><input list="SearchGroup" class="search" disabled>
										<?php
											$query = "SELECT distinct case when payrollgroup = 0 then 'Weekly' else 'Semi-Monthly' end as payrollgroup FROM payrollperiod 
											where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchGroup">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["payrollgroup"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><span></span></td>
									</tr>


								</thead>
								<tbody id="result">
									<?php					
									/*$query = "SELECT case when period = 0 then 'First Half' else 'Second Half' end as period,
													payrollperiod,
													date_format(startdate, '%m-%d-%Y') startdate,
													date_format(enddate, '%m-%d-%Y') enddate,
													date_format(payrolldate, '%m-%d-%Y') payrolldate,

													case when payrollgroup = 0 
													then 'Weekly' 
													else 'Semi-Monthly' end as payrollgroup,
													payrollgroup as payrollgroupid,
													STR_TO_DATE(startdate, '%Y-%m-%d') startdate2,
													STR_TO_DATE(enddate, '%Y-%m-%d') enddate2,
													STR_TO_DATE(payrolldate, '%Y-%m-%d') payrolldate2
													FROM payrollperiod where dataareaid = '$dataareaid'
													order by payrollperiod";*/

									$query = "SELECT case when period = 0 then 'First Half' 
													when period = 1 then 'Second Half'
													when period = 2 then 'First Week'
													when period = 3 then 'Second Week'
													when period = 4 then 'Third Week'
													when period = 5 then 'Fourth Week'

													else 'Last Week' end as period,

													payrollperiod,
													date_format(startdate, '%m-%d-%Y') startdate,
													date_format(enddate, '%m-%d-%Y') enddate,
													date_format(payrolldate, '%m-%d-%Y') payrolldate,

													case when payrollgroup = 0 
													then 'Weekly' 
													else 'Semi-Monthly' end as payrollgroup,
													payrollgroup as payrollgroupid,
													STR_TO_DATE(startdate, '%Y-%m-%d') startdate2,
													STR_TO_DATE(enddate, '%Y-%m-%d') enddate2,
													STR_TO_DATE(payrolldate, '%Y-%m-%d') payrolldate2
													FROM payrollperiod where dataareaid = '$dataareaid'
													order by payrollperiod";
									$result = $conn->query($query);
									$rowclass = "rowA";
									$rowcnt = 0;
									$rowcnt2 = 0;
									while ($row = $result->fetch_assoc())
									{ 
										$rowcnt++;
										$rowcnt2++;
											if($rowcnt > 1) { $rowcnt = 0; $rowclass = "rowB"; }
											else { $rowclass = "rowA";}
										?>
										<tr id="<?php echo $row['payrollperiod'];?>" class="<?php echo $rowclass; ?>" tabindex="<?php echo $rowcnt2; ?>">
											<!--<td style="width:10px;"><input type='checkbox' name="chkbox" value="" id="myCheck"></td>-->
											<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
											<td style="width:16%;"><?php echo $row['period'];?></td>
											<td style="width:16%;"><?php echo $row['payrollperiod'];?></td>
											<td style="width:16%;"><?php echo $row['startdate'];?></td>
											<td style="width:16%;"><?php echo $row['enddate'];?></td>
											<td style="width:16%;"><?php echo $row['payrolldate'];?></td>
											<td style="width:16%;"><?php echo $row['payrollgroup'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['payrollgroupid'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['startdate2'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['enddate2'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['payrolldate2'];?></td>

											<!--<td style="width:50%;"><input type='password' value='" . $row["password"]."'readonly='readonly'></td>-->
											
										</tr>
									<?php 
									$firstresult = $row["payrollperiod"];
									}
										$result2 = $conn->query($query);
										$row2 = $result2->fetch_assoc();
										
									?>
								</tbody>
								<span class="temporary-container-input">
									<input type="hidden" id="hide" value="<?php echo $firstresult; ?>">
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
				<div class="col-lg-6">Payroll Period Details</div>
				<div class="col-lg-6"><span class="fas fa-times modal-close"></span></div>
			</div>
			
			<div id="container" class="modal-content-container">
				<form name="myForm" accept-charset="utf-8" action="payrollperiodformprocess.php" method="get">
					<div class="row">

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>Payroll Period ID:</label>
							<div id="resultid">
								<input type="text" value="" placeholder="Payroll Period ID" name ="PayId" id="add-payrollperiod" class="modal-textarea" required="required">
							</div>

							<label>Payroll Group:</label>
							<select value="" placeholder="Group" name ="PayGroup" id="add-group" class="modal-textarea" style="width:100%;height: 28px;"  required="required">
									<option value=""></option>
									<option value="0">Weekly</option>
									<option value="1">Semi-Monthly</option>
							</select>

							<label>Period:</label>
							<select value="" placeholder="Period" name ="PayPer" id="add-period" class="modal-textarea" style="width:100%;height: 28px;"  required="required">
									<option value=""></option>
									<option value="0">First Half</option>
									<option value="1">Second Half</option>

									<option value="2">First Week</option>
									<option value="3">Second Week</option>
									<option value="4">Third Week</option>
									<option value="5">Fourth Week</option>
									<option value="6">Last Week</option>
							</select>

							
						</div>

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>From Date:</label>
							<input type="date" id="add-fromdate" name ="PayFromDate" class="modal-textarea" required="required">

							<label>To Date:</label>
							<input type="date" id="add-todate" name ="PayEndDate" class="modal-textarea" required="required">
						
							<label>Payout Date:</label>
							<input type="date" id="add-payrolldate" name ="PayDate" class="modal-textarea">
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

<!-- begin [JAVASCRIPT] -->

<script src="js/ajax.js"></script>
	<script  type="text/javascript">

	  	var so='';
	  	var locPayPer;
		var locPayFromDate;
		var locPayEndDate;
		var locPayDate;
		var locPayGroup;
  		$(document).ready(function(){
			$('#datatbl tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","red");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
				locPayPer = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
				locPayFromDate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(8)").text();
				locPayEndDate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(9)").text();
				locPayDate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(10)").text();
				locPayGroup = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(7)").text();
				so = usernum.toString();
				document.getElementById("hide").value = so;
				//alert(document.getElementById("hide").value);
				//alert(locPayFromDate);	
					  
			});
		});

		$(document).ready(function() {
			loc = document.getElementById("hide").value;
	            //$("#myUpdateBtn").prop("disabled", false);
	        if(loc != '')
	        {
	        	var pos = $("#"+loc+"").attr("tabindex");
	        }
	        else
	        {
	        	var pos = 1;
	        }
			//var pos = 1;
			//document.getElementById("hide").value;
		    //$("tr[tabindex="+pos+"]").focus();
		    $("tr[tabindex="+pos+"]").focus();
		    $("tr[tabindex="+pos+"]").css("color","red");
		    $("tr[tabindex="+pos+"]").addClass("info");
		    //$("tr[tabindex=0]").focus();
		    //$("tr[tabindex="+pos+"]").css("color","red");  
		    //var idx = $("tr:focus").attr("tabindex");
		    //alert(idx);
		    //document.onkeydown = checkKey;
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
		    //modal.style.display = "block";
		    $("#myModal").stop().fadeTo(500,1);
		    //$("#add-payrollperiod").prop('readonly', false);
		    //document.getElementById("add-payrollperiod").value = '';
		    document.getElementById("upbt").style.visibility = "hidden";
		    document.getElementById("addbt").style.visibility = "visible";
		    var action = "add";
		    $.ajax({
						type: 'GET',
						url: 'payrollperiodformprocess.php',
						data:{action:action},
						//data:'bkno='+BNo+'&bkdesc='+BDesc+'&bktit='+BTit+'&bkqty='+BQ,
						beforeSend:function(){
						
							//$("#result").html('<img src="img/loading.gif" width="300" height="300">');
			
						},
						success: function(data){
							$('#resultid').html(data);
							$("#add-payrollperiod").prop('readonly', true); 
				}
			});

		}
		UpdateBtn.onclick = function() {
			var enums;
			if(so != '') {
			    //modal.style.display = "block";
			    $("#myModal").stop().fadeTo(500,1);
			    $("#add-payrollperiod").prop('readonly', true);
			    if(locPayPer.toString() == "First Half")
			    {
			    	enums = 0;
			    }
			    else if(locPayPer.toString() == "Second Half")
			    {
			    	enums = 1;
			    }
			     else if(locPayPer.toString() == "First Week")
			    {
			    	enums = 2;
			    }
			     else if(locPayPer.toString() == "Second Week")
			    {
			    	enums = 3;
			    }
			     else if(locPayPer.toString() == "Third Week")
			    {
			    	enums = 4;
			    }
			    else if(locPayPer.toString() == "Fourth Week")
			    {
			    	enums = 5;
			    }
			    else
			    {
			    	enums = 6;
			    }
			    //alert(locPayFromDate);
				document.getElementById("add-period").value = enums;
				document.getElementById("add-payrollperiod").value = so;
				document.getElementById("add-fromdate").value = locPayFromDate;
				document.getElementById("add-todate").value = locPayEndDate;
				document.getElementById("add-payrolldate").value = locPayDate;
				document.getElementById("add-group").value = locPayGroup;
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
		  //alert($('#add-fromdate').val());
		}

		//-----search-----//
		$( ".search" ).on( "keydown", function(event) {
		  if(event.which == 13){
			var search = document.getElementsByClassName('search');
			var PayPer;
			var PayId;
			var PayFromDate;
			var PayEndDate;
			var PayDate;
			var action = "searchdata";
			var actionmode = "userform";
			var data=[];
			 for(i=0;i<search.length;i++){
				 data[i]=search[i].value;
				 //search[i].value = "";
			 }
			 
			 PayPer = data[0];
			 PayId = data[1];
			 PayFromDate = data[2];
			 PayEndDate = data[3];
			 PayDate = data[4];
			
			

			
			 $.ajax({
						type: 'GET',
						url: 'payrollperiodformprocess.php',
						data:{action:action, actmode:actionmode, PayId:PayId, PayFromDate:PayFromDate, PayEndDate:PayEndDate, PayDate:PayDate},
						//data:'bkno='+BNo+'&bkdesc='+BDesc+'&bktit='+BTit+'&bkqty='+BQ,
						beforeSend:function(){
						
							$("#result").html('<img src="img/loading.gif" width="300" height="300">');
			
						},
						success: function(data){
							$('#result').html(data);
							var firstval = $('#hide3').val();
							document.getElementById("hide").value = firstval;
							so = document.getElementById("hide").value;
				            //$("#myUpdateBtn").prop("disabled", false);
				             var pos = $("#"+so+"").attr("tabindex");
							    $("tr[tabindex="+pos+"]").focus();
							    $("tr[tabindex="+pos+"]").css("color","red");
							    $("tr[tabindex="+pos+"]").addClass("info");

							    $(document).ready(function(){
								$('#datatbl tbody tr').click(function(){
									$('table tbody tr').css("color","black");
									$(this).css("color","red");
									$('table tbody tr').removeClass("info");
									$(this).addClass("info");
									var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
									locPayPer = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
									locPayFromDate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(8)").text();
									locPayEndDate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(9)").text();
									locPayDate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(10)").text();
									locPayGroup = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(7)").text();
									so = usernum.toString();
									document.getElementById("hide").value = so;
									//alert(document.getElementById("hide").value);
									//alert(locPayFromDate);	
										  
								});
							});
				}
			}); 
			 
		  }
		});
		//-----end search-----//

		function Clear()
		{
			if(so != '')
			{
				document.getElementById("add-period").value = '';
				//document.getElementById("add-payrollperiod").value = so;
				document.getElementById("add-fromdate").value = '';
				document.getElementById("add-todate").value = '';
				document.getElementById("add-payrolldate").value = '';
				document.getElementById("add-group").value = '';
			}
			else
			{
				document.getElementById("add-period").value = '';
				//document.getElementById("add-payrollperiod").value = '';
				document.getElementById("add-fromdate").value = '';
				document.getElementById("add-todate").value = '';
				document.getElementById("add-payrolldate").value = '';
				document.getElementById("add-group").value = '';
			}
			
		}

		function Save()
		{
			
			modal.style.display = "none";
			/*var UId = document.getElementById("add-UserId");
			var UPass = document.getElementById("add-pass");
			var NM = document.getElementById("add-name");
			var DT = document.getElementById("add-dataareaid");*/
			var PriveId = $('#add-privilege').val();
			var PrivModule = $('#add-module').val();
			var PrivSub = $('#add-submodule').val();
			var PrivName = $('#add-name').val();
			var action = "savexx";
			var actionmode = "userform";
			$.ajax({	
					type: 'GET',
					url: 'payrollperiodformprocess.php',
					//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
					data:{action:action, actmode:actionmode, PriveId:PriveId, PrivModule:PrivModule, PrivSub:PrivSub, PrivName:PrivName},
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
			var PriveId = $('#add-privilege').val();
			var PrivModule = $('#add-module').val();
			var PrivSub = $('#add-submodule').val();
			var PrivName = $('#add-name').val();
			var action = "updatexx";
			var actionmode = "userform";
			if(so != '') {
				if(confirm("Are you sure you want to update this record?")) {
					$.ajax({	
							type: 'GET',
							url: 'payrollperiodformprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action, actmode:actionmode, PriveId:PriveId, PrivModule:PrivModule, PrivSub:PrivSub, PrivName:PrivName},
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
							url: 'payrollperiodformprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action, actmode:actionmode, PayId:so},
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
		function Cancel()
		{
			window.location.href='menu.php?list='+ActiveMode;
		}

	</script>
<script type="text/javascript" src="js/custom.js"></script>
<!-- end [JAVASCRIPT] -->

</body>
</html>
