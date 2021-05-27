<?php 
session_start();
session_regenerate_id();
include("dbconn.php");
$user = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
$wknum = $_SESSION["wknum"];
?>

<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>View Schedule</title>

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
			<!--<li><button id="myAddBtn"><span class="fa fa-plus"></span> Create Record</button></li>-->
			<li class="ShiftscheduleMaintain" style="display: none;"><button id="myUpdateBtn"><span class="fa fa-edit"></span> Update Record</button></li>
			<li class="ShiftscheduleMaintain" style="display: none;"><button onClick="Delete();"><span class="fa fa-trash-alt"></span> Delete Record</button></li>
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
							<span class="fa fa-archive"></span> View Schedule for <?php echo $wknum; ?>
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
										<td style="width:5%;">Include</td>
										<td style="width:12%;">Daytype</td>
										<td style="width:12%;">Date</td>
										<td style="width:12%;">Weekday</td>
										<td style="width:12%;">Shift Type</td>
										<td style="width:12%;">Start Time</td>
										<td style="width:12%;">End Time</td>
										<td style="width:12%;">Break Out</td>
										<td style="width:12%;">Break In</td>
										<td style="width:17px;" class="text-center"><span class="fas fa-arrows-alt-v"></span></td>
									</tr>
									<tr class="rowsearch">
										<td class="text-center"><span class="fas fa-search fa-xs"></span></td>
										<td><center><input id="selectAll" type="checkbox"></span></center></td>

										<td><input list="SearchDaytype" class="search">
										<?php
											$query = "SELECT distinct daytype FROM shiftschedule where dataareaid = '$dataareaid' and workerid = '$wknum' ";
											$result = $conn->query($query);
									  	?>
									  <datalist id="SearchDaytype">
										<?php 
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["daytype"];?>"></option>
										<?php } ?>
										</datalist>
									  </td>

									  <td><input type="date"  class="search">
										
									  </td>
									  <td><input list="SearchWeekday" class="search">
										<?php
											$query = "SELECT distinct weekday FROM shiftschedule where dataareaid = '$dataareaid' and workerid = '$wknum' ";
											$result = $conn->query($query);		
									  	?>
									  <datalist id="SearchWeekday">
										<?php 
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["weekday"];?>"></option>
										<?php } ?>
										</datalist>
									  </td>

									  <td><input list="SearchShifttype" class="search">
										<?php
											$query = "SELECT distinct shifttype FROM shiftschedule where dataareaid = '$dataareaid' and workerid = '$wknum' ";
											$result = $conn->query($query);		
									  	?>
									  <datalist id="SearchShifttype">
										<?php 
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["shifttype"];?>"></option>
										<?php } ?>
										</datalist>
									  </td>

									  <td><span></span></td>
									  <td><span></span></td>
									  <td><span></span></td>
									  <td><span></span></td>
									  <td><span></span></td>

									</tr>	
									
								</thead>
								
								<tbody id="result">
									<?php
									$query = "SELECT date as Date,weekday as 'Weekday',shifttype ,
												TIME_FORMAT(starttime, '%h:%i %p') as 'StartTime',
												TIME_FORMAT(endtime, '%h:%i %p') as 'EndTime',daytype as 'Daytype',
												DATE_FORMAT(starttime,'%H:%i:%s') as stime,
												DATE_FORMAT(endtime,'%H:%i:%s') as etime,

												TIME_FORMAT(breakout, '%h:%i %p') as 'BreakOut',
												TIME_FORMAT(breakin, '%h:%i %p') as 'BreakIn',
												DATE_FORMAT(breakout,'%H:%i:%s') as bkout,
												DATE_FORMAT(breakin,'%H:%i:%s') as bkin
												 from shiftschedule
										where dataareaid = '$dataareaid' and workerid = '$wknum' order by date asc";

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
											<td style="width:5%;"><input type='checkbox' id="chkbox" name="chkbox" class="checkbox" 
												value="<?php echo $row['Date'];?>"></td>
											<td style="width:12%;"><?php echo $row['Daytype'];?></td>
											<td style="width:12%;"><?php echo $row['Date'];?></td>
											<td style="width:12%;"><?php echo $row['Weekday'];?></td>
											<td style="width:12%;"><?php echo $row['shifttype'];?></td>
											<td style="width:12%;"><?php echo $row['StartTime'];?></td>
											<td style="width:12%;"><?php echo $row['EndTime'];?></td>
											<td style="width:12%;"><?php echo $row['BreakOut'];?></td>
											<td style="width:12%;"><?php echo $row['BreakIn'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['stime'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['etime'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['bkout'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['bkin'];?></td>
										</tr>
										

									<?php }?>

								</tbody>
								<span class="temporary-container-input">
									<input class="hide" type="input" id="hide">
									<input class="hide" type="input" id="wkhide" value = '<?php echo $wknum; ?>'>
									<input class="hide" type="input" id="inchide">
									<input class="hide" type="input" id="inchide2">
									
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
				<div class="col-lg-6">Update Shift Type</div>
				<div class="col-lg-6"><span class="fas fa-times modal-close"></span></div>
			</div>
			
			<div id="container" class="modal-content-container">
				<form name="myForm" accept-charset="utf-8" action="viewscheduleprocess.php" method="get">
					<div class="row">

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>Day Type:</label>
							<select class="formitem width-lg" class="textbox" name ="daytype" id="add-daytype" style="width:100%;height: 28px;"  required="required">
								<option value="" selected="selected"></option>
								<option value="Restday">Restday</option>
								<option value="Regular Holiday">Regular Holiday</option>
								<option value="Regular">Regular</option>
								<option value="Weekend">Weekend</option>
								<option value="Special Holiday">Special Holiday</option>
							</select>

							<label>Date:</label>
							<input type="text" value="" placeholder="Date" name ="SelectedVal" id="add-date" class="modal-textarea" required="required">

							<label>Week Day:</label>
							<input type="text" value="" placeholder="WeekDay" id="add-weekday" class="modal-textarea" required="required">

							<input type="hidden" value="<?php echo $wknum; ?>" placeholder="sweekday" name ="wkid" id="add-id" required="required">


						</div>
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>Shift Type:</label>
								<select class="formitem width-lg" class="textbox" name ="shifttype" id="add-shifttype" style="width:100%;height: 28px;"  required="required" onchange="filtertype()">
									<option value="" selected="selected"></option>
									<?php
										$query = "SELECT distinct * FROM shifttype";
										$result = $conn->query($query);			
										  	
											while ($row = $result->fetch_assoc()) {
											?>
												<option value="<?php echo $row["shifttype"];?>"><?php echo $row["shifttype"];?></option>
										<?php } ?>s
								</select>
									
							<div id="shiftCount">
								<label>Start Time:</label>
								<input type="time" value="09:00" placeholder="start time" name ="starttime" id="add-starttime" class="modal-textarea" required="required">
								<label>End Time:</label>
								<input type="time" value="18:00" placeholder="end time" name ="endtime" id="add-endtime" class="modal-textarea" required="required">

								<label>Break Out:</label>
								<input type="time" value="12:00" placeholder="bout" name ="breakout" id="add-breakout" class="modal-textarea" required="required">

								<label>Break In:</label>
								<input type="time" value="13:00" placeholder="bin" name ="breakin" id="add-breakin" class="modal-textarea" required="required">	
							</div>
						</div>
						

					</div>

					<div class="button-container">
						<button id="addbt" name="save" value="save" class="btn btn-primary btn-action">Save</button>
						<button id="upbt" name="update" value="update" class="btn btn-success btn-action" onclick="return validateForm()">Update</button>
						<button onClick="Clear();" type="button" value="Reset" class="btn btn-danger">Cancel</button>
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
	  	var so = '';
	  	var gl_stimer= '';
	  	var gl_etimer= '';
		$(document).ready(function(){
			$('#datatbl tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","red");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
			var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();
			var dtypenum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
			var stypenum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(5)").text();
			var weeknum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(4)").text();
			var stimer = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(10)").text();
			var etimer = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(11)").text();
			var bkout = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(12)").text();
			var bkin = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(13)").text();
			//locname = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
			so = usernum.toString();
			gl_stimer = stimer;
			gl_etimer = etimer.toString();

			gl_weeknum = weeknum.toString();
			gl_dtypenum = dtypenum.toString();
			gl_stypenum = stypenum.toString();

			gl_etimer = etimer.toString();

			document.getElementById("hide").value = so;
			//alert(document.getElementById("hide").value);
			//alert(dtypenum);	
						  
				});
			});

		// Get the modal -------------------
		var modal = document.getElementById('myModal');
		// Get the button that opens the modal
		/*var CreateBtn = document.getElementById("myAddBtn");*/
		var UpdateBtn = document.getElementById("myUpdateBtn");
		// Get the <span> element that closes the modal
		var span = document.getElementsByClassName("modal-close")[0];
		
		// When the user clicks the button, open the modal 
		/*CreateBtn.onclick = function() {
		    modal.style.display = "block";
		    $("#add-branch").prop('readonly', false);
		    document.getElementById("add-shifttype").value = '';
		    document.getElementById("upbt").style.visibility = "hidden";
		    document.getElementById("addbt").style.visibility = "visible";
		}*/
		UpdateBtn.onclick = function() {
			if(so != '') {
			    modal.style.display = "block";
			    $("#add-branch").prop('readonly', true);
			    $("#add-date").prop('readonly', true);
			    $("#add-starttime").prop('readonly', true);
			    $("#add-endtime").prop('readonly', true);
			    $("#add-breakout").prop('readonly', true);
			    $("#add-breakin").prop('readonly', true);
			    
			    document.getElementById("add-weekday").value = gl_weeknum ;
				document.getElementById("add-daytype").value = gl_dtypenum ;
				document.getElementById("add-shifttype").value = gl_stypenum;
				document.getElementById("add-date").value = so;
				document.getElementById("add-starttime").value = gl_stimer;
				document.getElementById("add-endtime").value = gl_etimer;
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
			var daytype;
			var date;
			var weekday;
			var shifttype;
			var action = "searchdata";
			var actionmode = "userform";
			var wkid = document.getElementById("wkhide").value;
			var data=[];
			 for(i=0;i<search.length;i++){
				 data[i]=search[i].value;
				 search[i].value = "";
			 }
			 
			 daytype = data[0];
			 date = data[1];
			 weekday = data[2];
			 shifttype = data[3];
			 //alert(shifttype);

			 $.ajax({
						type: 'GET',
						url: 'viewscheduleprocess.php',
						data:{action:action, actmode:actionmode, daytype:daytype, name:name, date:date, weekday:weekday, shifttype:shifttype, wkid:wkid},
						//data:'bkno='+BNo+'&bkdesc='+BDesc+'&bktit='+BTit+'&bkqty='+BQ,
						beforeSend:function(){
						
							$("#result").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
			
						},
						success: function(data){
							$('#result').html(data);
							CheckedVal();
							$('[name=chkbox]').change(function(){
						    if($(this).attr('checked'))
						    {
					      		//document.getElementById("inchide").value = $(this).val();
					      		Add();
						    }
						    else
						    {
									         
						         //document.getElementById("inchide").value=$(this).val();
						         remVals.push("'"+$(this).val()+"'");
						         $('#inchide2').val(remVals);

						         $.each(remVals, function(i, el2){

						    		removeA(allVals, el2);
						    		removeA(uniqueNames, el2);
							    	//$("input[value="+el+"]").prop("checked", true);
							    	//alert(el);
								});
						        Add();

						    }
						 });

						$("#selectAll").change(function(){  //"select all" change 
				   			 

				   			 if(false == $(this).prop("checked")){ //if this item is unchecked
							        $('[name=chkbox]').prop('checked', false); //change "select all" checked status to false
							         allVals = [];
									 uniqueNames = [];
									 remVals = [];
									 remValsEx = [];
							        document.getElementById('inchide').value = '';
							        document.getElementById('inchide2').value = '';
							        //alert('sample');

							    }
							    else
							    {
							    	$(".checkbox").prop('checked', $(this).prop("checked")); //change all ".checkbox" checked status
							    	Add();
							    }

							});

						function removeA(arr) 
						{
						    var what, a = arguments, L = a.length, ax;
						    while (L > 1 && arr.length) {
						        what = a[--L];
						        while ((ax= arr.indexOf(what)) !== -1) {
						            arr.splice(ax, 1);
						        }
						    }
						    return arr;
						}
						
						function Add() 
						{  

							
							$('#inchide').val('');
							 $('[name=chkbox]:checked').each(function() {
							   allVals.push("'"+$(this).val()+"'");
							 });

							  //remove existing rec start-----------------------
							 $('[name=chkbox]:disabled').each(function() {
							   
							   remValsEx.push("'"+$(this).val()+"'");
						         //$('#inchide2').val(remValsEx);

						         $.each(remValsEx, function(i, el2){
						         		
						    		removeA(allVals, el2);
						    		removeA(uniqueNames, el2);
							    	//"'"+"PCC"+"'"
								});
							   
							 });
							 //remove existing rec end-------------------------

							 
								$.each(allVals, function(i, el){
								    if($.inArray(el, uniqueNames) === -1) uniqueNames.push(el);
								});
							
							 $('#inchide').val(uniqueNames);

						} 
							$(document).ready(function(){
							$('#datatbl tbody tr').click(function(){
								$('table tbody tr').css("color","black");
								$(this).css("color","red");
								$('table tbody tr').removeClass("info");
								$(this).addClass("info");
							var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();
							var dtypenum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
							var stypenum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(5)").text();
							var weeknum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(4)").text();
							var stimer = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(10)").text();
							var etimer = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(11)").text();
							var bkout = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(12)").text();
							var bkin = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(13)").text();
							//locname = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
							so = usernum.toString();
							gl_stimer = stimer;
							gl_etimer = etimer.toString();

							gl_weeknum = weeknum.toString();
							gl_dtypenum = dtypenum.toString();
							gl_stypenum = stypenum.toString();

							gl_etimer = etimer.toString();

							document.getElementById("hide").value = so;
							//alert(document.getElementById("hide").value);
							//alert(dtypenum);	
										  
								});
							});
				}
			}); 
			 
		  }
		});
		//-----end search-----//

		var allVals = [];
		var uniqueNames = [];
		var remVals = [];
		var remValsEx = [];
		$('[name=chkbox]').change(function(){
		    if($(this).attr('checked'))
		    {
	      		//document.getElementById("inchide").value = $(this).val();
	      		Add();
		    }
		    else
		    {
					         
		         //document.getElementById("inchide").value=$(this).val();
		         remVals.push("'"+$(this).val()+"'");
		         $('#inchide2').val(remVals);

		         $.each(remVals, function(i, el2){

		    		removeA(allVals, el2);
		    		removeA(uniqueNames, el2);
			    	//$("input[value="+el+"]").prop("checked", true);
			    	//alert(el);
				});
		        Add();

		    }
		 });

		$("#selectAll").change(function(){  //"select all" change 
   			 

   			 if(false == $(this).prop("checked")){ //if this item is unchecked
			        $('[name=chkbox]').prop('checked', false); //change "select all" checked status to false
			         allVals = [];
					 uniqueNames = [];
					 remVals = [];
					 remValsEx = [];
			        document.getElementById('inchide').value = '';
			        document.getElementById('inchide2').value = '';
			        //alert('sample');

			    }
			    else
			    {
			    	$(".checkbox").prop('checked', $(this).prop("checked")); //change all ".checkbox" checked status
			    	Add();
			    }

			});

		function removeA(arr) 
		{
		    var what, a = arguments, L = a.length, ax;
		    while (L > 1 && arr.length) {
		        what = a[--L];
		        while ((ax= arr.indexOf(what)) !== -1) {
		            arr.splice(ax, 1);
		        }
		    }
		    return arr;
		}
		
		function Add() 
		{  

			
			$('#inchide').val('');
			 $('[name=chkbox]:checked').each(function() {
			   allVals.push("'"+$(this).val()+"'");
			 });

			  //remove existing rec start-----------------------
			 $('[name=chkbox]:disabled').each(function() {
			   
			   remValsEx.push("'"+$(this).val()+"'");
		         //$('#inchide2').val(remValsEx);

		         $.each(remValsEx, function(i, el2){
		         		
		    		removeA(allVals, el2);
		    		removeA(uniqueNames, el2);
			    	//"'"+"PCC"+"'"
				});
			   
			 });
			 //remove existing rec end-------------------------

			 
				$.each(allVals, function(i, el){
				    if($.inArray(el, uniqueNames) === -1) uniqueNames.push(el);
				});
			
			 $('#inchide').val(uniqueNames);

		} 
		function CheckedVal()
		{ 
			$.each(uniqueNames, function(i, el){
				    $("input[value="+el+"]").prop("checked", true);
				    //alert(el);
				});
		}


		function Clear()
		{
			modal.style.display = "none";
			
		}

		function filtertype()
		{
			var action = "changeTime";
			var actmode = "time";
			var stype = document.getElementById("add-shifttype").value;

			//alert(SelectedVal);
			//var locOvertimedate = document.getElementById("add-otid").value;

			//document.getElementById("datesched").value = '1';
			//alert(stype);

				if(stype != '')
				{
					$.ajax({	
							type: 'GET',
							url: 'viewscheduleprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action, actmode:actmode, stype:stype},
							beforeSend:function(){
									
							//$("#shiftCount").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
							//alert("test");
								
							},
							success: function(data){
							//window.location.href='shiftscheduleprocess.php';	
							$('#shiftCount').html(data);
							//location.reload();
							
											
							}
					}); 
	        	}
	
		}

		function Delete()
		{
			var action = "delete";
			var actmode = "schedule";
			var SelectedVal = $('#inchide').val();
			var wkid = document.getElementById("wkhide").value;
			//var date = $('#inchide').val();
			if(SelectedVal != '') {
				if(confirm("Are you sure you want to remove this record?")) {
					//alert(so);
					$.ajax({	
							type: 'GET',
							url: 'viewscheduleprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action, actmode:actmode, SelectedVal:SelectedVal, wkid:wkid},
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

			window.location.href='shiftschedule.php';		   
		}

</script>
<script type="text/javascript" src="js/custom.js"></script>
	<!-- end [JAVASCRIPT] -->

</body>
</html>