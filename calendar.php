<?php 
session_start();
session_regenerate_id();
include("dbconn.php");
$user = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];

if(isset($_SESSION['CalDateFoc']))
{
	$caldate = $_SESSION['CalDateFoc'];
}

$firstbranch = '';
?>

<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Calendar</title>

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
	<div class="leftpanel">

		<?php require("inc/leftpanel.php"); ?>

		<!-- sub buttons -->
		<ul class="subbuttons">
			<div class="leftpanel-title"><b>Command</b></div>
			<li class="CalendarMaintain" style="display: none;"><button onClick="createCalendar()"><span class="fa fa-plus"></span> Generate Calendar</button></li>
			<li><button onClick="filteredCalendar()"><span class="fas fa-layer-group"></span> Filter Calendar</button></li>
			<li class="CalendarMaintain" style="display: none;"><button id="myUpdateBtn"><span class="fa fa-edit"></span> Update Calendar</button></li>
			<li><button onClick="Cancel();"><span class="fa fa-arrow-circle-left fa-lg"></span> Back</button></li>
		</ul>

		

	</div>
	<!-- end LEFT PANEL -->


	<!-- begin MAINPANEL -->
	<div id="mainpanel dashboard" class="mainpanel">
		<div class="container-fluid">
			<div class="row">

				<!-- start TABLE AREA -->
				<div id="tablearea1" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mainpanel-area">
					<div class="mainpanel-content">
						<!-- title & search -->
						<div class="mainpanel-title">
							<span class="fa fa-archive"></span> Calendar Table
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
							<div class="mainpanel-sub-cmd">
								<b><label style="width: 90px;color:red;font-size:20px;">Branch:</label></b>
								<select class="modal-textarea" name ="BranchType" id="add-branch" style="width: 200px;height: 30px; color:black;font-size:18px;">
									<?php
										$querys = "SELECT branchcode,name from branch where dataareaid = '$dataareaid'";
										$results = $conn->query($querys);			
										  	
											while ($rows = $results->fetch_assoc()) {
											?>
												<option value="<?php echo $rows["branchcode"];?>"><?php echo $rows["name"];?></option>
										<?php } 

										$branchresult = $conn->query($querys);
										$branchrow = $branchresult->fetch_assoc();
										$firstbranch = $branchrow["branchcode"];

										?>
								</select>
								&nbsp;
								<button onClick="Load();" style="width: 90px;color:red;"><span class="fas fa-sync"></span> Load</button>
							</div>
						</div>
						<!-- tableheader -->
						<!-- tableheader -->
						<div id="container1" class="half">
							<table width="100%" style="border: 1px solid #d9d9d9;" id="datatbl" class="table table-striped mainpanel-table">
								<thead>	
									<tr class="rowtitle">
										<td style="width:20px;" class="text-center"><span class="fa fa-asterisk fa-xs"></span></td>
										<td style="width:32%;">Date</td>
										<td style="width:32%;">Type</td>
										<td style="width:32%;">Week Day</td>
										<td style="width:17px;" class="text-center"><span class="fas fa-arrows-alt-v"></span></td>
									</tr>
									<tr class="rowsearch">
										<td class="text-center"><span class="fas fa-search fa-xs"></span></td>


									  <td><input list="SearchShiftWorkerid" class="search" disabled>
										<?php
											$query = "SELECT distinct * FROM worker where dataareaid = '$dataareaid'";
											$result = $conn->query($query);
									  	?>
									  <datalist id="SearchShiftWorkerid">
										<?php 
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["workerid"];?>"></option>
										<?php } ?>
										</datalist>
									  </td>
									  

									  <td><input list="SearchName" class="search" disabled>
										<?php
											$query = "SELECT distinct name FROM worker where dataareaid = '$dataareaid'";

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


									  <td><input list="SearchPosition" class="search" disabled>
										<?php
											$query = "SELECT distinct position FROM worker where dataareaid = '$dataareaid'";
											$result = $conn->query($query);		
									  	?>
									  <datalist id="SearchPosition">
										<?php 
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["position"];?>"></option>
										<?php } ?>
										</datalist>



									  </td>

									  <td><span></span></td>
									</tr>	
									
								</thead>
								
								<tbody id="result">
									<?php
									$query = "SELECT * from calendartable where dataareaid = '$dataareaid' and branchcode = '$firstbranch'
										#and year(date) = year(curdate())
									order by Date";

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
										<tr id="<?php echo $row['Date'];?>"  class="<?php echo $rowclass; ?>" tabindex="<?php echo $rowcnt2; ?>">
											<!--<td style="width:10px;"><input type='checkbox' name="chkbox" value="" id="myCheck"></td>-->
											<td style="width:20px;" class="text-center" ><span class="fa fa-angle-right"></span></td>
											<td style="width:32%;"><?php echo $row['Date'];?></td>
											<td style="width:32%;"><?php echo $row['DayType'];?></td>
											<td style="width:32%;"><?php echo $row['Weekday'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['branchcode'];?></td>
										</tr>
										

									<?php }?>

								</tbody>
								<span class="temporary-container-input">
									<input type="hidden" id="hide" value="<?php if(isset($_SESSION['CalDateFoc'])){ echo $caldate; } ?>">
									<input type="hidden" id="inchide">
									<input type="hidden" id="inchide2">

									<input type="hidden" id="inchide3">
									<input type="hidden" id="inchide4">
									
								</span>
							</table>
						</div>	
					</div>
					<br><br>
				</div>
				<!-- end TABLE AREA -->

				<!-- start TABLE AREA -->
				<div id="tablearea2" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mainpanel-area" style=" padding-right: 60px; margin: 0px 20px;">
					<div class="mainpanel-content" style="padding: 0px 15px !important; margin-top: 5px !important; background-color: #FBFBFB; border: solid 1px #EAEAEA;">
						<!-- title & search -->
						
						<!-- tableheader -->
						<div id="container1" class="half">
							<div class="row">
								<!-- L -->
								<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
									<div class="mainpanel-title" style="width:100%;">
										<br>
										<span class="fa fa-archive"></span> Filter Calendar
									</div>
									<p>
										<label style="width: 90px;">From Date:</label>
										<span><input type="date" value="" placeholder="" id="add-frdate" name="Scheddate" class="modal-textarea" style="width:30%;height: 28px;"></span>
									</p>
									<p>
										<label style="width: 90px;">To Date:</label>
										<span><input type="date" value="" placeholder="" id="add-todate" name="Scheddate" class="modal-textarea" style="width:30%;height: 28px;"></span>
									</p>
									
								</div>

								<!-- R -->
							 	 <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							 	 	<div class="mainpanel-title" style="width:100%;">
										<br>
										<span class="fa fa-archive"></span> Generate Calendar
									</div>
							 	 	<p>

										<label style="width: 90px;">Year:</label>
										<span><input type="number" min="1900" max="2099" step="1" value="" placeholder="" id="add-year" name="Year" class="modal-textarea" style="width:30%;height: 28px;"></span>
									</p>
									
								
								</div> 

							</div>
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
					<div class="col-lg-6">Update Calendar</div>
					<div class="col-lg-6"><span class="fas fa-times modal-close"></span></div>
				</div>
				
				<div id="container" class="modal-content-container">
					<!--<form name="myForm" accept-charset="utf-8" action="calendarprocess.php" method="get">-->
						<div class="row">

							<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<label>Date:</label>
								<input type="date" value=""  name="CalDate" id="add-caldate" class="modal-textarea" required readonly>

								<label>Branch:</label>
								<input type="text" value="" placeholder="branch" name="CalBRanch" id="add-calbranch" class="modal-textarea" required readonly>
							</div>

							<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<label style="width: 90px;">Day Type:</label>
								<select class="modal-textarea" name ="DayType" id="add-type" style="width:100%;height: 28px;" required>
									<option value=""></option>
									<option value="Regular Holiday">Regular Holiday</option>
									<option value="Regular">Regular</option>
									<option value="Weekend">Weekend</option>
									<option value="Special Holiday">Special Holiday</option>
								</select>	
							</div>
							

						</div>

						<div class="button-container">
							<button id="upbt" name="update" value="update" class="btn btn-success btn-action" onclick="validateForm()">Update</button>
							<button onClick="Clear();" type="button" value="Reset" class="btn btn-danger">Clear</button>
						</div>
					<!--</form>-->
				</div>
			</div>
		</div>
	</div>
<!-- end modal-->

<!-- begin [JAVASCRIPT] -->
<script src="js/ajax.js"></script>
	<script  type="text/javascript">

			var locdaytype='';
		  	var so='';
		  	var locbranch= '';
			$(document).ready(function(){
				$('#datatbl tbody tr').click(function(){
					$('table tbody tr').css("color","black");
					$(this).css("color","red");
					$('table tbody tr').removeClass("info");
					$(this).addClass("info");
				var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
				locbranch = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(4)").text();
				locdaytype = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
				//locname = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
				so = usernum.toString();
				//gl_stimer = stimer;
				//gl_etimer = etimer.toString();
				document.getElementById("hide").value = so;
				//alert(document.getElementById("hide").value);
				//alert(so);	
				//document.getElementById("add-type").value = wa;
				//alert(locbranch);  
					});
			});

			$(document).ready(function() {
				//-----------get Header--------------//
	  			/*var headerid='';
	  			headerid = document.getElementById("add-branch").value;
				var action = "getheader";
				$.ajax({
					type: 'POST',
					url: 'calendarload.php',
					data:{action:action, headerid:headerid},
					beforeSend:function(){
					
						$("#result").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
					},
					success: function(data){
						//payline='';
						//document.getElementById("hide").value = "1";
						$('#result').html(data);
					}
				});*/
				var d = new Date();
				document.getElementById('add-year').value = d.getFullYear();
			});

			$(document).ready(function() {
			loc = document.getElementById("hide").value;
	        if(loc != '')
	        {
	        	var pos = $("#"+loc+"").attr("tabindex");
	        }
	        else
	        {
	        	var pos = 1;
	        }
		
		    $("tr[tabindex="+pos+"]").focus();
		    $("tr[tabindex="+pos+"]").css("color","red");
		    $("tr[tabindex="+pos+"]").addClass("info");
		   
			});

			function Load(){
	  			//-----------get Header--------------//
	  			var headerid='';
	  			headerid = document.getElementById("add-branch").value;
				var action = "getheader";
				$.ajax({
					type: 'POST',
					url: 'calendarload.php',
					data:{action:action, headerid:headerid},
					beforeSend:function(){
					
						$("#result").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
					},
					success: function(data){
						//payline='';
						//document.getElementById("hide").value = "1";
						$('#result').html(data);
					}
				}); 	
				
	  		}

	  		// Get the modal -------------------
			var modal = document.getElementById('myModal');
			// Get the button that opens the modal
			
			var UpdateBtn = document.getElementById("myUpdateBtn");
			// Get the <span> element that closes the modal
			var span = document.getElementsByClassName("modal-close")[0];
			// When the user clicks the button, open the modal 
			
			UpdateBtn.onclick = function() {
				if(so != '') {
				    //modal.style.display = "block";
				    $("#myModal").stop().fadeTo(500,1);
				    
				    document.getElementById("add-caldate").value = so;
					document.getElementById("add-calbranch").value = locbranch;
					document.getElementById("add-type").value = locdaytype;
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
				modal.style.display = "none";
				var dayType = document.getElementById("add-type").value;
				//alert(dayType);
				if(dayType != '')
				{
					if(confirm("Are you sure you want to update this record?")) {
						var action = "update";
						$.ajax({
							type: 'GET',
							url: 'calendarprocess.php',
							data:{action:action, CalDate:so, CalBRanch:locbranch, DayType:dayType},
							beforeSend:function(){
								
									//$("#SchedCont").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
								$("#result").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
										
							},
							success: function(data) {
								//so='';
							    //window.location.href='viewschedule.php';
							    //$('#result').html(data);
							    location.reload();	
							    //document.getElementById("add-type").value
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
					alert("Please select Day Type");
				}
			  /*var x = document.forms["myForm"]["update"].value;
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
			  }*/

			  
			}
			function Clear()
			{
				
				document.getElementById("add-type").value = "";
					
			}
			
			
			function filteredCalendar()
			{	
				var frdate = $('#add-frdate').val();
				var todate = $('#add-todate').val();
				var dayType = document.getElementById("add-type").value;
				var branch = document.getElementById("add-branch").value; 

				//alert(frdate);
				if(frdate != '' || todate != '' || daytype != ''){
					var action = "filtered";
					$.ajax({
						type: 'GET',
						url: 'calendarprocess.php',
						data:{action:action, frdate:frdate, todate:todate, branch:branch, dayType:dayType},
						beforeSend:function(){
							
								//$("#SchedCont").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
							$("#result").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
									
						},
						success: function(data) {
							//so='';
						    //window.location.href='viewschedule.php';
						    $('#result').html(data);
						    loc = document.getElementById("hide").value;
	            
					        if(loc != '')
					        {
					        	var pos = $("#"+loc+"").attr("tabindex");
					        }
					        else
					        {
					        	var pos = 1;
					        }
						
						    $("tr[tabindex="+pos+"]").focus();
						    $("tr[tabindex="+pos+"]").css("color","red");
						    $("tr[tabindex="+pos+"]").addClass("info");
					    }
					});
				}
				else {
					alert("Please Select Date");
				}
			}

			function savedCalendar()
			{
				var action = "saved";
				var dayType = document.getElementById("add-type").value;
				var SelectedVal = document.getElementById("inchide").value;
				var branch = document.getElementById("add-branch").value; 
				//alert(SelectedVal);
				if(SelectedVal != '' && dayType != ''){
					
					$.ajax({
						type: 'GET',
						url: 'calendarprocess.php',
						data:{action:action, dayType:dayType, SelectedVal:SelectedVal, branch:branch},
						beforeSend:function(){
							//alert(dayType);
								//$("#SchedCont").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
							$("#datatbl").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
									
						},
						success: function(data) {
							//so='';
						    //window.location.href='viewschedule.php';
						    //$('#datatbl').html(data);
						    location.reload();
					    }
					});
				}
				else {
					alert("Please Select Calendar and Day Type");
				}

			}
			function createCalendar()
			{
				var dayYear = document.getElementById("add-year").value; 
				var branch = document.getElementById("add-branch").value; 
				//var inYear = document.getElementById("added-year").value;
				var action = 'createcal';

				//salert(dayYear);
				if(branch != '')
				{
					if(dayYear != '')
					{
						if(confirm("Do you want to copy previous holiday from previous year to current year?")){
							var overwrite = "true";
							
						}
						else
						{
							var overwrite = "false";
						}
							
							$.ajax({
								type: 'GET',
								url: 'calendarprocess.php',
								data:{action:action, dayYear:dayYear, overwrite:overwrite, branch:branch},
								beforeSend:function(){
									//alert(inYear);
										
									$("#result").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
											
								},
								success: function(data) {
									//so='';
								    //alert(dayYear + " Added For " + branch + " branch")
								   // location.reload();
								    //$('#datatbl').html(data);
								    //alert
								    Load();

							    }
							});
					}
					else
					{
						alert("There is already year existing!");
					}
				}
				else
				{
					alert("Select Branch Code");
				}
					
			}
			function Cancel()
			{
				var action = "unload";
				$.ajax({
					type: 'GET',
					url: 'calendarprocess.php',
					data:{action:action},
					success: function(data) {
					    window.location.href='menu.php?list='+ActiveMode;
				    }
				}); 
				//window.location.href='menu.php?list='+ActiveMode;
			}
	</script>
<script type="text/javascript" src="js/custom.js"></script>
	<!-- end [JAVASCRIPT] -->

</body>
</html>