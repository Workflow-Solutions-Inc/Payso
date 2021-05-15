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
	<title>Shift Type</title>

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
			<div class="leftpanel-title"><b>COMMANDS</b></div>
			<li class="ShifttypeMaintain" style="display: none;"><button id="myAddBtn"><span class="fa fa-plus"></span> Create Record</button></li>
			<li class="ShifttypeMaintain" style="display: none;"><button onClick="Delete();"><span class="fa fa-trash-alt"></span> Delete Record</button></li>
			<li class="ShifttypeMaintain" style="display: none;"><button id="myUpdateBtn"><span class="fa fa-edit"></span> Update Record</button></li>
			<li><button onClick="Cancel();"><span class="fa fa-arrow-circle-left fa-lg"></span> Back</button></li>
			<!-- <li><button id="myAssessBtn" onClick="Assess();"><span class="fa fa-edit"></span> Assess Application</button></li>
			<li><button id="myAssessBtn" onClick="sendSMS();"><span class="fa fa-edit"></span> Send Message</button></li>-->
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
										<td style="width:25%;">Shift Type</td>
										<td style="width:25%;">Start Time</td>
										<td style="width:25%;">End Time</td>
										<td style="width:25%;">Break Out</td>
										<td style="width:25%;">Break In</td>
										<td style="width:17px;" class="text-center"><span class="fas fa-arrows-alt-v"></span></td>
									</tr>
									<tr class="rowsearch">
										<td class="text-center"><span class="fas fa-search fa-xs"></span></td>

										<td><input list="SearchShiftTypeid" class="search" disabled>
										<?php
											$query = "SELECT distinct shifttype FROM shifttype where dataareaid = '$dataareaid'";
											$result = $conn->query($query);
									  	?>
									  <datalist id="SearchShiftTypeid">
										<?php 
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["shifttype"];?>"></option>
										<?php } ?>
										</datalist>
									  </td>

									  <td><input list="SearchStartTime" class="search" disabled>
										<?php
											$query = "SELECT distinct starttime FROM shifttype";
											$result = $conn->query($query);		
									  	?>
									  <datalist id="SearchStartTime">
										<?php 
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["starttime"];?>"></option>
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchEndTime" class="search" disabled>
										<?php
											$query = "SELECT distinct endtime FROM shifttype";
											$result = $conn->query($query);		
									  	?>
									  <datalist id="SearchEndTime">
										<?php 
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["endtime"];?>"></option>
										<?php } ?>
										</datalist>
									  </td>

									  <td><input list="SearchBreakout" class="search" disabled>
										<?php
											$query = "SELECT distinct breakout FROM shifttype";
											$result = $conn->query($query);		
									  	?>
									  <datalist id="SearchBreakout">
										<?php 
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["breakout"];?>"></option>
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchBreakin" class="search" disabled>
										<?php
											$query = "SELECT distinct breakin FROM shifttype";
											$result = $conn->query($query);		
									  	?>
									  <datalist id="SearchBreakin">
										<?php 
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["breakin"];?>"></option>
										<?php } ?>
										</datalist>
									  </td>
									  <td><span></span></td>
									</tr>	
									
								</thead>
								
								<tbody id="result">
									<?php
									$query = "SELECT shifttype as 'Shift Type',TIME_FORMAT(starttime,'%h:%i %p') as 'Start Time',TIME_FORMAT(endtime,'%h:%i %p') as 'End Time'
									,starttime as stime,endtime as etime,TIME_FORMAT(breakout,'%h:%i %p') as 'Break Out',TIME_FORMAT(breakin,'%h:%i %p') as 'Break In',
                                    breakout as bout,breakin as bin
									from shifttype
										where dataareaid = '$dataareaid' order by recid asc";
									$result = $conn->query($query);
									$rowclass = "rowA";
									$rowcnt = 0;
									while ($row = $result->fetch_assoc())
									{ 
										$rowcnt++;
											if($rowcnt > 1) { $rowcnt = 0; $rowclass = "rowB"; }
											else { $rowclass = "rowA";}
										?>
										<tr class="<?php echo $rowclass; ?>">
											<!--<td style="width:10px;"><input type='checkbox' name="chkbox" value="" id="myCheck"></td>-->
											<td style="width:20px;" class="text-center" ><span class="fa fa-angle-right"></span></td>
											<td style="width:25%;"><?php echo $row['Shift Type'];?></td>
											<td style="width:25%;"><?php echo $row['Start Time'];?></td>
											<td style="width:25%;"><?php echo $row['End Time'];?></td>
											<td style="width:25%;"><?php echo $row['Break Out'];?></td>
											<td style="width:25%;"><?php echo $row['Break In'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['stime'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['etime'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['bout'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['bin'];?></td>
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
				<div class="col-lg-6"> Create Shift Type</div>
				<div class="col-lg-6"><span class="fas fa-times modal-close"></span></div>
			</div>
			
			<div id="container" class="modal-content-container">
				<form name="myForm" accept-charset="utf-8" action="shifttypeprocess.php" method="get">
					<div class="row">

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>Shift Type:</label>
							<input type="text" value="" placeholder="Shift Type Description" name ="shifttypenew" id="add-shifttype" class="modal-textarea" required="required">
							<input type="text" value="" placeholder="Shift Type Description" name ="shifttypeold" id="add-shifttypeold" class="hide">

							<label>Start Time:</label>
							<input type="time" value="09:00" placeholder="stime" name ="starttime" id="add-starttime" class="modal-textarea" required="required">

							<label>End Time:</label>
							<input type="time" value="18:00" placeholder="etime" name ="endtime" id="add-endtime" class="modal-textarea" required="required">	

						</div>

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>Break Out:</label>
							<input type="time" value="12:00" placeholder="bout" name ="breakout" id="add-breakout" class="modal-textarea" >

							<label>Break In:</label>
							<input type="time" value="13:00" placeholder="bin" name ="breakin" id="add-breakin" class="modal-textarea" >	
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

		var locname='';
	  	var so='';
	  	var gl_stimer= '';
	  	var gl_etimer= '';
		$(document).ready(function(){
		$('#datatbl tbody tr').click(function(){
			$('table tbody tr').css("color","black");
			$(this).css("color","red");
			$('table tbody tr').removeClass("info");
			$(this).addClass("info");
			var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
			var stimer = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(6)").text();
			var etimer = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(7)").text();
			var bkout = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(8)").text();
			var bkin = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(9)").text();
			//locname = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
			so = usernum.toString();
			gl_stimer = stimer;
			gl_etimer = etimer.toString();
			document.getElementById("hide").value = so;
			//alert(document.getElementById("hide").value);
			//alert(so);	
						  
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
		    modal.style.display = "block";
		    $("#add-branch").prop('readonly', false);
		    document.getElementById("add-shifttype").value = '';
		     document.getElementById("add-shifttypeold").value = '';
		    document.getElementById("upbt").style.visibility = "hidden";
		    document.getElementById("addbt").style.visibility = "visible";
		}
		UpdateBtn.onclick = function() {
			if(so != '') {
			    modal.style.display = "block";
			    $("#add-branch").prop('readonly', true);
				document.getElementById("add-shifttype").value = so;
				document.getElementById("add-shifttypeold").value = so;
				document.getElementById("add-starttime").value = gl_stimer;
				document.getElementById("add-endtime").value = gl_etimer.toString();
				document.getElementById("add-breakout").value = bkout.toString();
				document.getElementById("add-breakin").value = bkin.toString();
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
			var slocshifttype;
			var name;
			var action = "searchdata";
			var actionmode = "userform";
			var data=[];
			 for(i=0;i<search.length;i++){
				 data[i]=search[i].value;
				 //search[i].value = "";
			 }
			 
			 slocshifttype = data[0];
			 name = data[1];

			 $.ajax({
						type: 'GET',
						url: 'shifttypeprocess.php',
						data:{action:action, actmode:actionmode, slocshifttype:slocshifttype, name:name},
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
			if(so != '')
			{
				//document.getElementById("add-branch").value = "";
				document.getElementById("add-name").value = "";
			}
			else
			{
				document.getElementById("add-shifttype").value = "";
				document.getElementById("add-starttime").value = "09:00";
				document.getElementById("add-endtime").value = "18:00";
			}
			
		}
		
		function Save()
		{
			
			modal.style.display = "none";
			/*var UId = document.getElementById("add-UserId");
			var UPass = document.getElementById("add-pass");
			var NM = document.getElementById("add-name");
			var DT = document.getElementById("add-dataareaid");*/
			var shifttype = $('#add-shifttype').val();
			var starttime = $('#add-starttime').val();
			var endtime = $('#add-endtime').val();
			var action = "save";
			var actionmode = "userform";
			$.ajax({	
					type: 'GET',
					url: 'shifttypeprocess.php',
					//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
					data:{action:action, shifttype:shifttype, starttime:starttime, endtime:endtime},
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
			var shifttype = $('#add-shifttype').val();
			var starttime = $('#add-starttime').val();
			var endtime = $('#add-endtime').val();
			var action = "update";
			var actionmode = "userform";
			if(so != '') {
				if(confirm("Are you sure you want to update this record?")) {
					$.ajax({	
							type: 'GET',
							url: 'shifttypeprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action, shifttype:shifttype, starttime:starttime, endtime:endtime},
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
				alert("Please Select a record you want to update.");
			}			
		}

		function Delete()
		{
			
			var action = "delete";
			var actmode = "schedule";
			var shifttype = $('#hide').val();

			if(so != '') {
				if(confirm("Are you sure you want to remove this record?")) {
					$.ajax({	
							type: 'GET',
							url: 'shifttypeprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action, actmode:actmode, shifttype:shifttype},
							beforeSend:function(){
									
							$("#datatbl").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
							//alert(so);
								
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