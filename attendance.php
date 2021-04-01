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
	<title>Attendance Monitoring</title>

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
			<!--<li class="BranchMaintain" style="display: none;"><button id="myAddBtn"><span class="fa fa-plus"></span> Create Record</button></li>
			<li class="BranchMaintain" style="display: none;"><button onClick="Delete();"><span class="fa fa-trash-alt"></span> Delete Record</button></li>
			<li class="BranchMaintain" style="display: none;"><button id="myUpdateBtn"><span class="fa fa-edit"></span> Update Record</button></li>-->
			<li><button onClick="Refresh();"><span class="fas fa-redo-alt fa-lg"></span> Refresh</button></li>
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
							<span class="fa fa-archive"></span> Attendance
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
							</div> -->
							<div class="mainpanel-sub-cmd">
								
							</div>
							
							<div class="mainpanel-sub-cmd">
								<b><label style="width: 90px;color:red;font-size:20px;">Branch:</label></b>
								<select class="modal-textarea" name ="BranchType" id="add-branch" style="width: 200px;height: 30px; color:black;font-size:18px;">
									<option value="" selected="selected"></option>
									<?php
										$querys = "SELECT branchcode from branch where dataareaid = '$dataareaid'";
										$results = $conn->query($querys);			
										  	
											while ($rows = $results->fetch_assoc()) {
											?>
												<option value="<?php echo $rows["branchcode"];?>"><?php echo $rows["branchcode"];?></option>
										<?php } 

										$branchresult = $conn->query($querys);
										$branchrow = $branchresult->fetch_assoc();
										$firstbranch = $branchrow["branchcode"];

										?>
								</select>
								&nbsp;

								<b><label style="width: 90px;color:red;font-size:20px;">Department:</label></b>
								&nbsp;
								&nbsp;
								&nbsp;
								&nbsp;
								&nbsp;
								<select class="modal-textarea" name ="attdept" id="add-dept" style="width: 200px;height: 30px; color:black;font-size:18px;">
									<option value="" selected="selected"></option>
									<?php
										$querys = "SELECT departmentid,name from department where dataareaid = '$dataareaid'";
										$results = $conn->query($querys);			
										  	
											while ($rows = $results->fetch_assoc()) {
											?>
												<option value="<?php echo $rows["departmentid"];?>"><?php echo $rows["name"];?></option>
										<?php } 

										/*$branchresult = $conn->query($querys);
										$branchrow = $branchresult->fetch_assoc();
										$firstbranch = $branchrow["branchcode"];*/

										?>
								</select>
								&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;&nbsp;&nbsp;&nbsp;
								<b><label style="width: 130px;color: blue;font-size:20px;">Previous Date:</label></b>
								<input type="date" name ="prevdate" id="add-prevdate" class="textbox" style="width: 185px;"> 
								&nbsp;
								&nbsp;
								<button onClick="Load();" style="width: 90px;color:blue;"><span class="fas fa-sync"></span> Load</button>
								<!--<button onClick="notifyme();" style="width: 90px;color:red;"><span class="fas fa-sync fa-spin"></span> Load</button>-->
							</div>
						</div>
						<!-- tableheader -->
						<div id="container1" class="full">
							<table width="100%" style="border: 1px solid #d9d9d9;" id="datatbl" class="table table-striped mainpanel-table">
								<thead>
									
									<tr class="rowtitle">
										<td style="width:20px;" class="text-center"><span class="fa fa-asterisk fa-xs"></span></td>
										<td style="width:20%;">Name</td>
										<td style="width:20%;">Position</td>
										<td style="width:20%;">Department</td>
										<td style="width:20%;">Branch</td>
										<td style="width:20%;">Time In</td>
										<td style="width:20%;">Time Out</td>
										<td style="width: 17px;" class="text-center"><span class="fas fa-arrows-alt-v"></span></td>
									</tr>
									<tr class="rowsearch">
									  <td class="text-center"><span class="fas fa-search fa-xs"></span></td>
									  

									   <td><input list="SearchName" class="search" disabled>
										<?php
											$query = "SELECT distinct name FROM worker where dataareaid = '$dataareaid' and inactive = 0";
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
											$query = "SELECT distinct name FROM position where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchPosition">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["name"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchDepartment" class="search" disabled>
										<?php
											$query = "SELECT distinct name FROM department where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchDepartment">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["name"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchBranch" class="search" disabled>
										<?php
											$query = "SELECT distinct name FROM branch where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchBranch">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["name"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><span></span></td>
									  <td><span></span></td>
									  <td><span></span></td>
									  
									</tr>
								</thead>
								
								<tbody id="result">
									<?php
									$query = "SELECT wk.name as name, pos.name as position, dm.name as department,bra.name as branch, 
												MIN(case when mt.type = 0 then TIME_FORMAT(mt.Time,'%h:%i %p') else null end) as 'timein',
												MAX(case when mt.type = 1 then TIME_FORMAT(mt.Time,'%h:%i %p') else null end) as 'timeout' 

												from monitoringtable mt 
												LEFT JOIN worker wk ON mt.Name = wk.BioId left join branch brn on wk.branch = brn.branchcode and wk.dataareaid = brn.dataareaid 
												left join position pos on pos.positionid = wk.position and pos.dataareaid = wk.dataareaid
												LEFT JOIN contract con ON wk.workerid = con.workerid and con.dataareaid = wk.dataareaid 
												LEFT JOIN department dm ON con.departmentid = dm.departmentid and wk.dataareaid = dm.dataareaid 
												left join branch bra on bra.branchcode = wk.branch and bra.dataareaid = wk.dataareaid
												where 

												mt.Date = curdate() and 
												wk.dataareaid = '$dataareaid' 

												group by wk.name  


												order by MIN(case when mt.type = 0 then TIME_FORMAT(mt.Time,'%h:%i %p') else null end) asc";
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
										<tr  class="<?php echo $rowclass; ?>" tabindex="<?php echo $rowcnt2; ?>">
											<!--<td style="width:10px;"><input type='checkbox' name="chkbox" value="" id="myCheck"></td>-->
											<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
											<td style="width:20%;"><?php echo $row['name'];?></td>
											<td style="width:20%;"><?php echo $row['position'];?></td>
											<td style="width:20%;"><?php echo $row['department'];?></td>
											<td style="width:20%;"><?php echo $row['branch'];?></td>
											<td style="width:20%;"><?php echo $row['timein'];?></td>
											<td style="width:20%;"><?php echo $row['timeout'];?></td>
											
										</tr>
									<?php }

									$CURquery = "SELECT currentCount from notificationcountertable;";

										$CURresult = $conn->query($CURquery);
										
										$currentCount = 0;
										
										while ($CURrow = $CURresult->fetch_assoc())
										{ 
												$currentCount = $CURrow['currentCount'];
												

										}


										$REALquery = "SELECT realtimeCount from notificationcountertable;";

										$REALresult = $conn->query($REALquery);
										
										$realtimeCount = 0;
										
										while ($REALrow = $REALresult->fetch_assoc())
										{ 
												$realtimeCount = $REALrow['realtimeCount'];
												

										}


									?>
								</tbody>
								<span class="temporary-container-input">
									<input type="hidden" id="currentCount" value = "<?php echo $currentCount;?>">
									<input type="hidden" id="realtimeCount" value = "<?php echo $realtimeCount;?>">
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




<!-- begin [JAVASCRIPT] -->
<script src="js/ajax.js"></script>
	 <script  type="text/javascript">

		
		function notifyme()
		{
			//alert(1);
			if(!("Notification" in window))
			{
				alert("This browser does not support notifications.");
			}
			else if(Notification.permission == "granted")
			{
				var notification = new Notification("Hi there jet. \n asd");

			}
			else if (Notification.permission != "denied")
			{
				Notification.requestPermission(function(permission){

					if("permission" == "granted")
					{
						var notification = new Notification("Hi there jet. \n asd");
					}


				});

			}
		}
			
		setTimeout(function() {
			//location.reload();
			var attbranch='';
	  			attbranch = document.getElementById("add-branch").value;
	  		var attdept='';
	  			attdept = document.getElementById("add-dept").value;
			//-----------get line--------------//
				var action = "getline";
				var actionmode = "userform";
				$.ajax({
					type: 'POST',
					url: 'attendanceload.php',
					data:{action:action, actmode:actionmode, attbranch:attbranch, attdept:attdept},
					beforeSend:function(){
					
						//$("#result").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
					},
					success: function(data){
						//payline='';
						//document.getElementById("HDincAcc").value = "";
						$('#result').html(data);
					}
				}); 	
				//-----------get line--------------//
				

		}, 1000);

		function Load(){
  			//-----------get Header--------------//
  			var prevdate='';
	  			prevdate = document.getElementById("add-prevdate").value;
  			var attbranch='';
	  			attbranch = document.getElementById("add-branch").value;
	  		var attdept='';
	  			attdept = document.getElementById("add-dept").value;
			var action = "dept";
			var actionmode = "dept";

			if(prevdate != '')
			{
				$.ajax({
					type: 'POST',
					url: 'attendanceloadprev.php',
					data:{action:action, actmode:actionmode, attbranch:attbranch, attdept:attdept, prevdate:prevdate},
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
			else
			{
				alert('Please select date.');
			}
			
  		}

  		function Refresh()
		{
			location.reload();
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