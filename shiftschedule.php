<?php 

session_start();
include("dbconn.php");
$user = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
?>

<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Shift Schedule</title>

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
			<li class="ShiftscheduleMaintain" style="display: none;"><button Onclick="generatedSched();"><span class="fa fa-plus"></span> Generate Schedule</button></li>
			<li class="ShiftscheduleMaintain" style="display: none;"><button OnClick="linedetails();"><span class="fas fa-eye"></span> View Schedule</button></li>
			<!--<li><button Onclick="sample();"><span class="fa fa-edit"></span> Generate Report</button></li>-->
			<li><button onClick="Cancel();"><span class="fa fa-arrow-circle-left fa-lg"></span> Back</button></li>
			<!-- <li><button onClick="Delete();"><span class="fa fa-trash-alt"></span> Delete Record</button></li>
			 -->
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
	<div id="mainpanel dashboard" class="mainpanel">
		<div class="container-fluid">
			<div class="row">

				<!-- start TABLE AREA -->
				<div id="tablearea1" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mainpanel-area">
					<div class="mainpanel-content">
						<!-- title & search -->
						<div class="mainpanel-title">
							<span class="fa fa-archive"></span> Shift Schedule
						</div>
						<div class="mainpanel-sub">
							<!-- cmd -
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
						<!-- tableheader -->
						<div id="container1" class="half">
							<table width="100%" style="border: 1px solid #d9d9d9;" id="datatbl" class="table table-striped mainpanel-table">
								<thead>	
									<tr class="rowtitle">
										<td style="width:20px;" class="text-center"><span class="fa fa-asterisk fa-xs"></span></td>
										<td style="width:5%;">Include</td>
										<td style="width:33%;">Worker Id</td>
										<td style="width:33%;">Name</td>
										<td style="width:33%;">Position</td>
										<td style="width:17px;" class="text-center"><span class="fas fa-arrows-alt-v"></span></td>
									</tr>
									<tr class="rowsearch">
										<td class="text-center"><span class="fas fa-search fa-xs"></span></td>
										<td><center><input id="selectAll" type="checkbox"></span></center></td>


									  <td><input list="SearchShiftWorkerid" class="search">
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
									  

									  <td><input list="SearchName" class="search">
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


									  <td><input list="SearchPosition" class="search">
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
									$query =
									"SELECT * from worker where dataareaid = '$dataareaid'";

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
												value="<?php echo $row['workerid'];?>"></td>
											<td style="width:33%;"><?php echo $row['workerid'];?></td>
											<td style="width:33%;"><?php echo $row['name'];?></td>
											<td style="width:33%;"><?php echo $row['position'];?></td>

											
										</tr>
										

									<?php }?>
								</tbody>
								<span class="temporary-container-input">
									<input type="hidden" id="hide">
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
						<div class="mainpanel-title" style="width:100%;">
							<br>
							<span class="fa fa-archive"></span> Generate Schedule
						</div>
						<!-- tableheader -->
						<div id="container1" class="half">
							<div class="row">

								<form name="myForm" id="myForm" accept-charset="utf-8" action="shiftscheduleprocess.php" method="get">
									<!-- L -->
									<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
										<p>
											<label style="width: 90px;">From Date:</label>
											<span><input type="date" value="" placeholder="" id="add-frdate" name="Scheddate" class="modal-textarea" style="width:30%;height: 28px;"
												onchange="filtersched()"></span>
										</p>
										<p>
											<label style="width: 90px;">To Date:</label>
											<span><input type="date" value="" placeholder="" id="add-todate" name="Scheddate" class="modal-textarea" style="width:30%;height: 28px;"
												onchange="filtersched()"></span>
										</p>
										<p>
											<label style="width: 90px;">Shift Type:</label>

											<select class="modal-textarea" name ="ShedType" id="add-type" style="margin-left: 0px;width: 300px;height: 25px;">
												<option value="" selected="selected"></option>
												<?php
													$query = "SELECT distinct shifttype,TIME_FORMAT(starttime, '%h:%i %p') starttime,TIME_FORMAT(endtime, '%h:%i %p') endtime FROM shifttype where dataareaid = '$dataareaid'";
													$result = $conn->query($query);			
													  	
														while ($row = $result->fetch_assoc()) {
														?>
															<option value="<?php echo $row["shifttype"];?>"><?php echo $row["shifttype"].' ('.$row["starttime"].' - '.$row["endtime"].')';?></option>
													<?php } ?>
											</select>

										</p>

										<div id="SchedCont">
											<input type="hidden" value="" id="filterSched">
										</div>
									</div>

									<!-- R -->
									<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
										<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"  style="width: 250px;;">
										<p>
											<label style="width: 90px;">Rest Days:</label>
										</p>
											<p>
												<input type="checkbox" id="mon" name="rday" value="Monday">
	  											<label for="mon"> Monday</label><br>
	  										</p>
	  										<p>
												<input type="checkbox" id="tue" name="rday" value="Tuesday">
	  											<label for="tue"> Tuesday</label><br>
	  										</p>
	  										<p>
												<input type="checkbox" id="wed" name="rday" value="Wednesday">
	  											<label for="wed"> Wednesday</label><br>
	  										</p>
	  									</div>
	  									<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
	  										<p>
												<input type="checkbox" id="thur" name="rday" value="Thursday">
	  											<label for="thur"> Thursday</label><br>
	  										</p>
  										
  										
	  										<p>
												<input type="checkbox" id="fri" name="rday" value="Friday">
	  											<label for="fri"> Friday</label><br>
	  										</p>
	  										<p>
												<input type="checkbox" id="sat" name="rday" value="Saturday">
	  											<label for="sat"> Saturday</label><br>
	  										</p>
	  										<p>
												<input type="checkbox" id="sun" name="rday" value="Sunday">
	  											<label for="sun"> Sunday</label><br>
	  										</p>
										</div>
									
									</div>

								</form>

							</div>
						</div>
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
			var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
			// var stimer = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(10)").text();
			// var etimer = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(9)").text();
			//locname = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
			so = usernum.toString();
			//gl_stimer = stimer;
			//gl_etimer = etimer.toString();
			document.getElementById("hide").value = so;
			//alert(document.getElementById("hide").value);
			//alert(so);	
						  
				});
			});




		//-----search-----//
		$( ".search" ).on( "keydown", function(event) {
		  if(event.which == 13){
			var search = document.getElementsByClassName('search');
			var workerid;
			var name;
			var position;
			var action = "searchdata";
			var actionmode = "userform";
			var data=[];
			 for(i=0;i<search.length;i++){
				 data[i]=search[i].value;
				 //search[i].value = "";
			 }
			 
			 workerid = data[0];
			 name = data[1];
			 position = data[2];

			 $.ajax({
						type: 'GET',
						url: 'shiftscheduleprocess.php',
						data:{action:action, actmode:actionmode, workerid:workerid, name:name, position:position},
						//data:'bkno='+BNo+'&bkdesc='+BDesc+'&bktit='+BTit+'&bkqty='+BQ,
						beforeSend:function(){
						
							$("#result").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
			
						},
						success: function(data){
							$('#result').html(data);
							CheckedVal();
				}
			}); 
			 
		  }
		});
		//-----end search-----//

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
			 //remove existing rec end-

			 
				$.each(allVals, function(i, el){
				    if($.inArray(el, uniqueNames) === -1) uniqueNames.push(el);
				});
			
			 $('#inchide').val(uniqueNames);
			 filtersched();

		} 
		function CheckedVal()
		{ 
			$.each(uniqueNames, function(i, el){
				    $("input[value="+el+"]").prop("checked", true);
				    //alert(el);
				});
		}

		//START OF REST DAYS-----------------------------------------------------------------
/* 		
		$('[name=rday]:checked').each(function() {
		   restdays.push("'"+$(this).val()+"'");

		  //document.getElementById("hide").value = so;
		   alert(restdays);
		 });*/


		var allVals2 = [];

		var uniqueRest = [];
		var remVals2 = [];
		var remValsEx2 = [];

		$('[name=rday]').change(function(){
			
		    if($(this).attr('checked'))
		    {
	      		//document.getElementById("inchide").value = $(this).val();
	      		AddRest();
		    }
		    else
		    {
					         
		         //document.getElementById("inchide").value=$(this).val();
		         remVals2.push("'"+$(this).val()+"'");
		         $('#inchide4').val(remVals2);

		         $.each(remVals2, function(i, el4){

		    		removeA(allVals2, el4);
		    		removeA(uniqueRest, el4);
			    	//$("input[value="+el+"]").prop("checked", true);
			    	//alert(el);
				});
		        AddRest();

		    }
		 });


		
		function AddRest() 
		{  

			
			$('#inchide3').val('');
			 $('[name=rday]:checked').each(function() {
			   allVals2.push("'"+$(this).val()+"'");
			 });

			  //remove existing rec start-----------------------
			 $('[name=rday]:disabled').each(function() {
			   
			   remValsEx2.push("'"+$(this).val()+"'");
		         //$('#inchide2').val(remValsEx);

		         $.each(remValsEx2, function(i, el4){
		         		
		    		removeA(allVals2, el4);
		    		removeA(uniqueRest, el4);
			    	//"'"+"PCC"+"'"
				});
			   
			 });
			 //remove existing rec end

			 
				$.each(allVals2, function(i, el3){
				    if($.inArray(el3, uniqueRest) === -1) uniqueRest.push(el3);
				});
			
			 $('#inchide3').val(uniqueRest);
			 filtersched();

		} 
		function CheckedValRest()
		{ 
			$.each(uniqueRest, function(i, el3){
				    $("input[value="+el3+"]").prop("checked", true);
				    //alert(el);
				});
		}


		//END OF REST DAYS-------------------------------------------------------------



		
		function linedetails()
		{
			if(so != ''){
				var action = "shiftline";
				$.ajax({
					type: 'GET',
					url: 'shiftscheduleprocess.php',
					data:{action:action, workerid:so},
					success: function(data) {
						so='';
					    window.location.href='viewschedule.php';
				    }
				});
			}
			else {
				alert("Please Select Worker.");
			}
		}

		function filtersched()
		{
			var SelectedVal = $('#inchide').val();
			var action = "filtersched";
			var actmode = "filter";

			//alert(SelectedVal);
			//var locOvertimedate = document.getElementById("add-otid").value;
			var locFromdate = document.getElementById("add-frdate").value;
			var locTodate = document.getElementById("add-todate").value;
			var locType = document.getElementById("add-type").value;

			//document.getElementById("datesched").value = '1';
			//alert(SelectedVal);
			if(SelectedVal != '')
			{
				$.ajax({	
						type: 'GET',
						url: 'shiftscheduleprocess.php',
						//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
						data:{action:action, actmode:actmode, SelectedVal:SelectedVal, locFromdate:locFromdate, locTodate,locTodate},
						beforeSend:function(){
								
						//$("#SchedCont").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
						//alert("test");
							
						},
						success: function(data){
						//window.location.href='shiftscheduleprocess.php';	
						$('#SchedCont').html(data);
						//location.reload();
						
										
						}
				}); 
        	}
	
		}

		function generatedSched()
		{
			var SelectedVal = $('#inchide').val();
			var action = "";
			var actmode = "schedule";

			//alert(SelectedVal);
			//var locOvertimedate = document.getElementById("add-otid").value;
			var locFromdate = document.getElementById("add-frdate").value;
			var locTodate = document.getElementById("add-todate").value;
			var locType = document.getElementById("add-type").value;
			var filterSched = document.getElementById("filterSched").value;

			var FromDate = (new Date(locFromdate).getTime()) / 1000;
	        var ToDate = (new Date(locTodate).getTime()) / 1000;
			var restdays = $('#inchide3').val();
 		

			if(SelectedVal != '')
			{
				if (FromDate > ToDate) 
				{
	        		document.getElementById("add-frdate").value = document.getElementById("add-todate").value;
	            	alert("Check the date! To Date Should Be Greater Than From Date");
	        	}
				else 
				{
					if (filterSched == 'True')
					{
						if(locType == ''){
							alert("Please Select Shift Type");
						}
						else
						{
							if(confirm("Do you want to overwrite?")){
							action = 'updatesched';
							//alert(action);
								$.ajax({	
									type: 'GET',
									url: 'shiftscheduleprocess.php',
									//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
									data:{action:action, actmode:actmode, SelectedVal:SelectedVal, locFromdate:locFromdate, locTodate,locTodate, locType,locType, restdays:restdays},
									beforeSend:function(){
											
									$("#result").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
									//alert("test");
										
									},
									success: function(data){
									//window.location.href='shiftscheduleprocess.php';	
									//$('#result').html(data);
									location.reload();
										//alert(locFromdate);
										
													
									}
								});
							}
						}
						
						
					}
					else
					{
						if(locFromdate != '' && locTodate != '' && locType != '')
						{
							action = 'savesched';
							//alert(action);
							$.ajax({	
								type: 'GET',
								url: 'shiftscheduleprocess.php',
								//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
								data:{action:action, actmode:actmode, SelectedVal:SelectedVal, locFromdate:locFromdate, locTodate:locTodate, locType:locType, restdays:restdays},
								beforeSend:function(){
										
								$("#result").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
								//alert("test");
									
								},
								success: function(data){
								//window.location.href='shiftscheduleprocess.php';	
								//$('#result').html(data);
								location.reload();
								//alert(restdays);
									
												
								}
							});
						}
						else
						{
							alert("Please Complete the details");
						}
						
					}

				}	
			}
			else
			{
				alert("Please select Employee");
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