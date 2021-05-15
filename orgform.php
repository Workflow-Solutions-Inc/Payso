<?php 
session_start();
session_regenerate_id();
include("dbconn.php");
#$user = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];

if(isset($_SESSION['orgnum']))
{
	$usrid = $_SESSION['orgnum'];
}
/*else
{
	header('location: menu.php');
}*/

?>

<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Organizational Chart</title>

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
			<!--<li class="OrganizationalChart OrganizationalChartMaintain" style="display: none;"><button id="myAddBtn"><span class="fa fa-plus"></span> Create User</button></li>
			<li class="OrganizationalChart OrganizationalChartMaintain" style="display: none;"><button onClick="Delete();"><span class="fa fa-trash-alt"></span> Delete User</button></li>
			<li class="OrganizationalChart OrganizationalChartMaintain" style="display: none;"><button id="myUpdateBtn"><span class="fa fa-edit"></span> Update User</button></li>-->
			<li><button onClick="Cancel();"><span class="fa fa-arrow-circle-left fa-lg"></span> Back</button></li>
		</ul>
		
		<!-- extra buttons -->
		<ul class="extrabuttons OrganizationalChartMaintain" style="display: none;">
			<div class="leftpanel-title"><b>SET</b></div>
			<li  class="OrganizationalChartMaintain" style="display: none;"><button onClick="SetSub();"><span class="fas fa-cog fa"></span> Set Subordinate</button></li>
			<li  class= "OrganizationalChartMaintain" style="display: none;"><button onClick="DeleteCompany();"><span class="fa fa-trash-alt"></span> Remove Subordinate</button></li>
			<!--<li><button><span class="fas fa-arrow-down fa"></span> Move Down</button></li>-->
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
							<span class="fa fa-archive"></span> Organizational Chart
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
						<div id="container1" class="half">
							<table width="100%" style="border: 1px solid #d9d9d9;" id="datatbl" class="table table-striped mainpanel-table">
								<thead>
									<tr class="rowtitle">
										<td style="width:20px;" class="text-center"><span class="fa fa-asterisk fa-xs"></span></td>
										<td style="width:20%;">Worker ID</td>
										<td style="width:20%;">Name</td>
										<td style="width:20%;">Position</td>
										<td style="width:20%;">Department</td>
										<td style="width:20%;">Branch</td>
										<td style="width: 17px;" class="text-center"><span class="fas fa-arrows-alt-v"></span></td>										
									</tr>
								
								
									<tr class="rowsearch">
												  <td class="text-center"><span class="fas fa-search fa-xs"></span></td>
												  
												  
												  <td><input style="width:100%;height: 20px;" list="SearchWorker" class="search">
													<?php
														$query = "SELECT distinct workerid FROM worker where dataareaid = '$dataareaid'";
														$result = $conn->query($query);	
															
												  ?>
												  <datalist id="SearchWorker">
													
													<?php 
													
														while ($row = $result->fetch_assoc()) {
													?>
														<option value="<?php echo $row["workerid"];?>"></option>
														
													<?php } ?>
													</datalist>
												  </td>
												  <td><input style="width:100%;height: 20px;" list="SearchName" class="search">
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
												  <td><input style="width:100%;height: 20px;" list="SearchPosition" class="search" >
													<?php
														$query = "SELECT distinct pos.name as 'position'

																FROM worker wk
																left join position pos on pos.positionid = wk.position and pos.dataareaid = wk.dataareaid 
																where wk.dataareaid = '$dataareaid'";
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
												  <td><input style="width:100%;height: 20px;" list="SearchDepartment" class="search" >
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
												  <td><input style="width:100%;height: 20px;" list="SearchBranch" class="search" disabled>
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
												  
												</tr>
								</thead>
								
								<tbody id="result">
									<?php
									$query = "SELECT distinct wk.workerid,wk.Name,pos.name as 'position',dep.name as 'department',bra.name	as 'branch'

																FROM worker wk
																left join position pos on pos.positionid = wk.position and pos.dataareaid = wk.dataareaid 
																left join contract con on con.workerid = wk.workerid and con.dataareaid = wk.dataareaid
																left join department dep on dep.departmentid = con.departmentid and dep.dataareaid = wk.dataareaid
																left join branch bra on bra.branchcode = wk.branch and bra.dataareaid = wk.dataareaid
																
						
																where wk.dataareaid = '$dataareaid' 

																order by wk.workerid";
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
											<tr id="<?php echo $row['workerid'];?>" class="<?php echo $rowclass; ?>" tabindex="<?php echo $rowcnt2; ?>">
											<!--<td style="width:10px;"><input type='checkbox' name="chkbox" value="" id="myCheck"></td>-->
											<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
											<td style="width:20%;"><?php echo $row['workerid'];?></td>
											<td style="width:20%;"><?php echo $row['Name'];?></td>
											<td style="width:20%;"><?php echo $row['position'];?></td>
											<td style="width:20%;"><?php echo $row['department'];?></td>
											<td style="width:20%;"><?php echo $row['branch'];?></td>
											<!--<td style="width:50%;"><input type='password' value='" . $row["password"]."'readonly='readonly' style="width:100%;"></td>-->
										</tr>

									<?php 
									//$firstresult = $row["userid"];
									}
										$result2 = $conn->query($query);
										$row2 = $result2->fetch_assoc();
										$firstresult = $row2["workerid"];
									?>
								
								</tbody>
								<span class="temporary-container-input">
									<input type="hidden" id="hide" value="<?php if(isset($_SESSION['orgnum'])){ echo $usrid; } else { echo $firstresult; } ?>">
									
									<div style="display:none;width:1%;"><textarea id="t2" value = "<?php echo substr($collection,1);?>"><?php echo substr($collection,1);?></textarea></div>
								</span>
							</table>
						</div>
					</div>
					<br>
				</div>
				<!-- end TABLE AREA -->

				<!-- start TABLE AREA -->
				<div id="tablearea2" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mainpanel-area">
					<div class="mainpanel-content">
						<!-- title & search -->
						<div class="mainpanel-title">
							<span class="fa fa-archive"></span> 
							Subordinate
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

						<!-- table -->
						<div id="container1" class="half">
							<table width="100%" style="border: 1px solid #d9d9d9;" id="dataln" class="table table-striped mainpanel-table">
								<thead>
									<tr class="rowtitle">
										<td style="width:20px;" class="text-center"><span class="fa fa-asterisk fa-xs"></span></td>
										<td style="width:20%;">Worker ID</td>
										<td style="width:20%;">Name</td>
										<td style="width:20%;">Position</td>
										<td style="width:20%;">Department</td>
										<td style="width:20%;">Branch</td>
										<td style="width: 17px;" class="text-center"><span class="fas fa-arrows-alt-v"></span></td>	
									</tr>
								
								</thead>

								<tbody id="lineresult">
										<?php
										if(isset($_SESSION['orgnum']))
										{ 
											$VarUserid = $usrid; 
										}
										else
										{
											$VarUserid = $firstresult; 
										}

										$query = "SELECT distinct wk.workerid,wk.Name,pos.name as 'position',dep.name as 'department',bra.name	as 'branch'

															FROM worker wk
															left join position pos on pos.positionid = wk.position and pos.dataareaid = wk.dataareaid 
															left join contract con on con.workerid = wk.workerid and con.dataareaid = wk.dataareaid
															left join department dep on dep.departmentid = con.departmentid and dep.dataareaid = wk.dataareaid
															left join branch bra on bra.branchcode = wk.branch and bra.dataareaid = wk.dataareaid
															left join organizationalchart org on org.workerid = wk.workerid and org.dataareaid = wk.dataareaid
															where wk.dataareaid = '$dataareaid' and org.repotingid = '$VarUserid'
															
															order by wk.workerid";
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
												<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
												<td style="width:20%;"><?php echo $row['workerid'];?></td>
												<td style="width:20%;"><?php echo $row['Name'];?></td>
												<td style="width:20%;"><?php echo $row['position'];?></td>
												<td style="width:20%;"><?php echo $row['department'];?></td>
												<td style="width:20%;"><?php echo $row['branch'];?></td>
												
											</tr>

										<?php }?>
								</tbody>
								<input type="hidden" id="hide2">	
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
	 	var flaglocation=true;
		var so='';
		var locUPass = '';
		var locNM = '';
		var locDT = '';
		var usernum = '';
		var myId = [];
		if(usernum == '')
		{
			so = document.getElementById("hide").value;
		}
		//var locIndex = '';
  		$(document).ready(function(){
			$('#datatbl tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","red");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
				locNM = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
				locDT = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();
				locUPass = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(4)").text();
				//locIndex = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(5)").text();
				so = usernum.toString();
				document.getElementById("hide").value = so;
				//document.getElementById("hidefocus").value = locIndex.toString();
				//alert(document.getElementById("hide").value);
				//alert(so);

				//-----------get line--------------//
				var action = "getline";
				var actionmode = "userform";
				$.ajax({
					type: 'POST',
					url: 'orgformline .php',
					data:{action:action, actmode:actionmode, userId:so},
					beforeSend:function(){
					
						$("#lineresult").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
					},
					success: function(data){
						//payline='';
						document.getElementById("hide2").value = "";
						$('#lineresult').html(data);
						$(document).ready(function(){
							$('#dataln tbody tr').click(function(){
								$('table tbody tr').css("color","black");
								$(this).css("color","orange");
								$('table tbody tr').removeClass("info");
								$(this).addClass("info");
								var orgnumline = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(1)").text();
								
								locworker = orgnumline.toString();
								document.getElementById("hide2").value = locworker;
								//alert(document.getElementById("hide").value);
									
								flaglocation = false;
						        $("#myUpdateBtn").prop("disabled", true);
						        //alert(flaglocation);		
								//flaglocation = false;
								//alert(payline);
								loc = document.getElementById("hide").value;
					            //$("#myUpdateBtn").prop("disabled", false);
					             var pos = $("#"+loc+"").attr("tabindex");
								    $("tr[tabindex="+pos+"]").focus();
								    $("tr[tabindex="+pos+"]").css("color","red");
								    $("tr[tabindex="+pos+"]").addClass("info");
								//document.getElementById("myUpdateBtn").style.disabled = disabled;
									  
							});
						});
					}
				}); 
				//-----------get line--------------//
				flaglocation = true;
				//alert(flaglocation);

		       
					  
			});
		});
  		var locworker='';
  		
		$(document).ready(function(){
			$('#dataln tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","orange");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				var orgnumline = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(1)").text();
				
				locworker = orgnumline.toString();
				document.getElementById("hide2").value = locworker;
				//alert(document.getElementById("hide").value);
					
				flaglocation = false;
		        $("#myUpdateBtn").prop("disabled", true);
		        //alert(flaglocation);		
				//flaglocation = false;
				//alert(payline);
				loc = document.getElementById("hide").value;
	            //$("#myUpdateBtn").prop("disabled", false);
	             var pos = $("#"+loc+"").attr("tabindex");
				    $("tr[tabindex="+pos+"]").focus();
				    $("tr[tabindex="+pos+"]").css("color","red");
				    $("tr[tabindex="+pos+"]").addClass("info");
				//document.getElementById("myUpdateBtn").style.disabled = disabled;
					  
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

		
				
		//-----search-----//
		$( ".search" ).on( "keydown", function(event) {
		  if(event.which == 13){
			var search = document.getElementsByClassName('search');
			var sLocId;
			var slocName;
			var slocPosition;
			var sLocDepartment;
			var slocbranch;
			var action = "searchdata";
			var actionmode = "userform";
			var data=[];
			 for(i=0;i<search.length;i++){
				 data[i]=search[i].value;
				 //search[i].value = "";
			 }
			 
			 sLocId = data[0];
			 slocName = data[1];
			 slocPosition = data[2];
			 sLocDepartment = data[3];
			 slocbranch = data[4];
			
			

			
			 $.ajax({
						type: 'GET',
						url: 'orgformprocess.php',
						data:{action:action, actmode:actionmode, sLocId:sLocId, slocName:slocName, slocPosition:slocPosition, sLocDepartment:sLocDepartment, slocbranch:slocbranch},
						//data:'bkno='+BNo+'&bkdesc='+BDesc+'&bktit='+BTit+'&bkqty='+BQ,
						beforeSend:function(){
						
							$('#result').html('<center><img src="img/loading.gif" width="300" height="300"></center>');
			
						},
						success: function(data){
							$('#result').html(data);
							//-----------get line--------------//
							var action = "getline";
							var actionmode = "userform";
							var firstval = $('#hide3').val();
							document.getElementById("hide").value = firstval;
							so = document.getElementById("hide").value;
				            //$("#myUpdateBtn").prop("disabled", false);
				             var pos = $("#"+so+"").attr("tabindex");
							    $("tr[tabindex="+pos+"]").focus();
							    $("tr[tabindex="+pos+"]").css("color","red");
							    $("tr[tabindex="+pos+"]").addClass("info");
							$.ajax({
								type: 'POST',
								url: 'orgformline .php',
								data:{action:action, actmode:actionmode, userId:firstval},
								beforeSend:function(){
								
									$("#lineresult").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
								},
								success: function(data){
									//payline='';
									document.getElementById("hide2").value = "";
									$('#lineresult').html(data);
								}
							}); 
							//-----------get line--------------//	

							$(document).ready(function(){
								$('#datatbl tbody tr').click(function(){
									$('table tbody tr').css("color","black");
									$(this).css("color","red");
									$('table tbody tr').removeClass("info");
									$(this).addClass("info");
									usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
									locNM = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
									locDT = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();
									locUPass = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(4)").text();
									//locIndex = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(5)").text();
									so = usernum.toString();
									document.getElementById("hide").value = so;
									//document.getElementById("hidefocus").value = locIndex.toString();
									//alert(document.getElementById("hide").value);
									//alert(so);

									//-----------get line--------------//
									var action = "getline";
									var actionmode = "userform";
									$.ajax({
										type: 'POST',
										url: 'orgformline .php',
										data:{action:action, actmode:actionmode, userId:so},
										beforeSend:function(){
										
											$("#lineresult").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
										},
										success: function(data){
											//payline='';
											document.getElementById("hide2").value = "";
											$('#lineresult').html(data);
											$(document).ready(function(){
												$('#dataln tbody tr').click(function(){
													$('table tbody tr').css("color","black");
													$(this).css("color","orange");
													$('table tbody tr').removeClass("info");
													$(this).addClass("info");
													var orgnumline = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(1)").text();
													
													locworker = orgnumline.toString();
													document.getElementById("hide2").value = locworker;
													//alert(document.getElementById("hide").value);
														
													flaglocation = false;
											        $("#myUpdateBtn").prop("disabled", true);
											        //alert(flaglocation);		
													//flaglocation = false;
													//alert(payline);
													loc = document.getElementById("hide").value;
										            //$("#myUpdateBtn").prop("disabled", false);
										             var pos = $("#"+loc+"").attr("tabindex");
													    $("tr[tabindex="+pos+"]").focus();
													    $("tr[tabindex="+pos+"]").css("color","red");
													    $("tr[tabindex="+pos+"]").addClass("info");
													//document.getElementById("myUpdateBtn").style.disabled = disabled;
														  
												});
											});
										}
									}); 
									//-----------get line--------------//
									flaglocation = true;
									//alert(flaglocation);

							       
										  
								});
							});
				}
			}); 
			 
		  }
		});
		//-----end search-----//
		
		function DeleteCompany()
		{
			
			var action = "delete";
			var actionmode = "subline";
			//alert(so);
			//alert(locworker);
			if(locworker != '') {
				if(confirm("Are you sure you want to remove this record?")) {
					$.ajax({	
							type: 'GET',
							url: 'orgformprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action, actmode:actionmode, locworker:locworker, userno:so},
							beforeSend:function(){
									
							$("#lineresult").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
								
							},
							success: function(data){
							//$('#lineresult').html(data);
							//location.reload();
							//-----------get line--------------//
							var action = "getline";
							var actionmode = "userform";
							$.ajax({
								type: 'POST',
								url: 'orgformline .php',
								data:{action:action, actmode:actionmode, userId:so},
								beforeSend:function(){
								
									$("#lineresult").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
								},
								success: function(data){
									//payline='';
									document.getElementById("hide2").value = "";
									$('#lineresult').html(data);
								}
							}); 
							//-----------get line--------------//					
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
				alert("Please Select Company you want to remove.");
			}		
		}

		function SetSub()
		{
			var action = "sublist";
			$.ajax({
				type: 'GET',
				url: 'orgformprocess.php',
				data:{action:action, UsrId:so},
				success: function(data) {
				    window.location.href='orgselection.php';
			    }
			});
			
		}
		function Cancel()
		{
			//alert(so);
			//window.location.href='workerform.php';
			var action = "unload";
			$.ajax({
				type: 'GET',
				url: 'orgformprocess.php',
				data:{action:action},
				success: function(data) {
				    window.location.href='menu.php?list='+ActiveMode;
			    }
			});  
		}

	</script>
	
	<script type="text/javascript" src="js/custom.js">
	</script>
	<!-- end [JAVASCRIPT] -->

</body>
</html>