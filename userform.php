<?php 
session_start();
session_regenerate_id();
include("dbconn.php");
#$user = $_SESSION["user"];
$sessioncurtab = '';
$curtab = 'company';
if(isset($_SESSION['curtab']))
{ 
	 $sessioncurtab = $_SESSION['curtab'];
}

$dataareaid = $_SESSION["defaultdataareaid"];

if(isset($_SESSION['UsrNum']))
{
	$usrid = $_SESSION['UsrNum'];
}
/*else
{
	header('location: userform.php');
}*/

?>

<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>User</title>

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
  border: 1px solid #ccc;
  border-top: none;
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
			<li class="UsersMaintain" style="display: none;"><button id="myAddBtn"><span class="fa fa-plus"></span> Create User</button></li>
			<li class="UsersMaintain" style="display: none;"><button onClick="Delete();"><span class="fa fa-trash-alt"></span> Delete User</button></li>
			<li class="UsersMaintain" style="display: none;"><button id="myUpdateBtn"><span class="fa fa-edit"></span> Update User</button></li>
			<li><button onClick="Cancel();"><span class="fa fa-arrow-circle-left fa-lg"></span> Back</button></li>
		</ul>
		
		<!-- extra buttons -->
		<ul class="extrabuttons UsersMaintain" style="display: none;">
			<div class="leftpanel-title"><b>SET</b></div>
			<div id ="CompCtr">
				<li><button onClick="SetDt();"><span class="fas fa-cog fa"></span> Set Dataarea</button></li>
				<li><button onClick="DeleteCompany();"><span class="fa fa-trash-alt"></span> Remove Company</button></li>
			</div>
			<div id = "UsrCtr" style="display: none">
				<li><button onClick="SetUg();"><span class="fas fa-cog fa"></span> Set User Group</button></li>
				<li><button onClick="DeleteUsrgroup();"><span class="fa fa-trash-alt"></span> Remove User Group</button></li>
			</div>
			
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
							<span class="fa fa-archive"></span> Users
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
										<td style="width:25%;">User Id</td>
										<td style="width:25%;">Name</td>
										<td style="width:25%;">Default Dataarea Id</td>
										<td style="width:25%;">Password</td>
										<td style="width: 17px;" class="text-center"><span class="fas fa-arrows-alt-v"></span></td>										
									</tr>
								
								
									<tr class="rowsearch">
									  <td class="text-center"><span class="fas fa-search fa-xs"></span></td>
									  

										<td><input list="SearchUserid" class="search">
										<?php
											$query = "SELECT distinct userid FROM userfile";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchUserid">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["userid"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchName" class="search">
										<?php
											$query = "SELECT distinct name FROM userfile";
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
									  <td><input list="SearchDataarea" class="search">
										<?php
											$query = "SELECT distinct defaultdataareaid FROM userfile";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchDataarea">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["defaultdataareaid"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchPass" class="search" disabled>
										<?php
											$query = "SELECT distinct password FROM userfile";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchPass">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["password"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><span></span></td>
									</tr>
								</thead>
								
								<tbody id="result">
									<?php
									$query = "SELECT * FROM userfile";
									$result = $conn->query($query);
									$rowclass = "rowA";
									$rowcnt = 0;
									$rowcnt2 = 0;
									$collection = '';
										while ($row = $result->fetch_assoc())
										{ 
											$rowcnt++;
											$rowcnt2++;
												if($rowcnt > 1) { $rowcnt = 0; $rowclass = "rowB"; }
												else { $rowclass = "rowA";}
												$collection = $collection.','.$row['userid'];
											?>
											<tr id="<?php echo $row['userid'];?>" class="<?php echo $rowclass; ?>" tabindex="<?php echo $rowcnt2; ?>">
											<!--<td style="width:10px;"><input type='checkbox' name="chkbox" value="" id="myCheck"></td>-->
											<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
											<td style="width:25%;"><?php echo $row['userid'];?></td>
											<td style="width:25%;"><?php echo $row['name'];?></td>
											<td style="width:25%;"><?php echo $row['defaultdataareaid'];?></td>
											<td style="width:25%;"><?php echo str_repeat ('*', strlen ($row['password']));?></td>
											<td style="display:none;width:1%;"><?php echo $rowcnt2;?></td>
											<!--<td style="width:50%;"><input type='password' value='" . $row["password"]."'readonly='readonly' style="width:100%;"></td>-->
										</tr>

									<?php 
									//$firstresult = $row["userid"];
									}
										$result2 = $conn->query($query);
										$row2 = $result2->fetch_assoc();
										$firstresult = $row2["userid"];
									?>
								
								</tbody>
								<span class="temporary-container-input">
									<input type="hidden" id="hide" value="<?php if(isset($_SESSION['UsrNum'])){ echo $usrid; } else { echo $firstresult; } ?>">
									<input type="hidden" id="hidecurtab" value="<?php if(isset($_SESSION['curtab'])){ echo $sessioncurtab; } else { echo $curtab; } ?>">
									<input type="hidden" id="hidefocus" value="<?php echo $rowcnt2;?>">
									<div style="display:none;width:1%;"><textarea id="t2" value = "<?php echo substr($collection,1);?>"><?php echo substr($collection,1);?></textarea></div>
								</span>
							</table>
						</div>
					</div>
					<br><br>
				</div>
				<!-- end TABLE AREA -->

				<hr><hr>
				<div class="tab">
				  <button class="tablinks" id="Company" value="0" onclick="Activate(this.value);"><span class="fas fa-briefcase">&nbsp;</span> Company</button>
				  <button class="tablinks" id="Group" value="1" onclick="Activate(this.value);"><span class="fas fa-calendar-alt">&nbsp;</span> User Group</button>
				 
				</div>

				<!-- start TABLE AREA -->
				<div id='dtrContent'>
				<div id="tablearea2" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mainpanel-area">
					<div class="mainpanel-content">
						<!-- title & search -->
						<div class="mainpanel-title">
							<span class="fa fa-archive"></span> 
							List Of Company
						</div>
						<div class="mainpanel-sub">
							
						</div>

						<!-- table -->
						<div id="container1" class="half">
							<table width="100%" style="border: 1px solid #d9d9d9;" id="dataln" class="table table-striped mainpanel-table">
								<thead>
									<tr class="rowtitle">
										<td style="width:20px;" class="text-center"><span class="fa fa-asterisk fa-xs"></span></td>
										<td style="width:50%;">Dataarea Id</td>
										<td style="width:50%;">Name</td>
										<td style="width: 17px;" class="text-center"><span class="fas fa-arrows-alt-v"></span></td>	
									</tr>
								
								</thead>

								<tbody id="lineresult">
										<?php
										if(isset($_SESSION['UsrNum']))
										{ 
											$VarUserid = $usrid; 
										}
										else
										{
											$VarUserid = $firstresult; 
										}

										$query = "SELECT UD.userid,UD.dataareaid,DA.name
													FROM userfiledataarea UD
													left join dataarea DA on DA.dataareaid = UD.dataareaid
													where userid = '$VarUserid'";
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
												<td style="width:20px;"><span class="fa fa-angle-right"></span></td>
												<td style="width:50%;"><?php echo $row['dataareaid'];?></td>
												<td style="width:50%;"><?php echo $row['name'];?></td>
												<!--<td style="width:50%;"><input type='password' value='" . $row["password"]."'readonly='readonly'></td>-->
												
											</tr>

										<?php }?>
								</tbody>
								<input type="hidden" id="hide2">	
							</table>
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
				<div class="col-lg-6">User</div>
				<div class="col-lg-6"><span class="fas fa-times modal-close"></span></div>
			</div>
			
			<div id="container" class="modal-content-container">
				<form name="myForm" accept-charset="utf-8" action="userformprocess.php" method="get">
					<div class="row">

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>User ID:</label>
							<input type="text" value="" placeholder="User Id" name ="userno" id="add-UserId" class="modal-textarea" required="required">

							<label>Name:</label>
							<input type="text" value="" placeholder="Name" name ="lname" id="add-name" class="modal-textarea" required="required">
						</div>

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>Dataarea ID:</label>
							

							<select value="" value="" placeholder="Default Dataarea Id" name ="darea" id="add-dataareaid" class="modal-textarea" style="width:100%;height: 28px;"  required="required">
								<option value="" selected="selected"></option>
								<?php
									$query = "SELECT distinct dataareaid FROM dataarea";
									$result = $conn->query($query);			
									  	
										while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["dataareaid"];?>"><?php echo $row["dataareaid"];?></option>
									<?php } ?>
							</select>
							<!--<input type="text" value="" placeholder="Default Dataarea Id" id="add-dataareaid" class="modal-textarea">-->

							<label id="label-pass">Password:</label>
							<input type="text" value="" placeholder="Password" name ="pass" id="add-pass" class="modal-textarea" required="required">
						</div>

					</div>

					<div class="button-container">
						<button id="addbt" name="save" value="save" class="btn btn-primary btn-action" onclick="return checkExistForm()">Save</button>
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
	 	var tablocation='';
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
				tablocation = document.getElementById("hidecurtab").value;
				//alert(tablocation);
				if(tablocation == 'company')
				{
					companyline();
				}
				else if(tablocation == 'usrgrp')
				{
					usergroupline();
				}
				flaglocation = true;
				//alert(flaglocation);
		        $("#myUpdateBtn").prop("disabled", false);	
					
			});
		});
  		var locDataarea='';
  		var locDTName='';
		$(document).ready(function(){
			$('#dataln tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","orange");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				var transnumline = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(1)").text();
				locDTName = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(2)").text();
				locDataarea = transnumline.toString();
				document.getElementById("hide2").value = locDataarea;
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


		function companyline()
		{
			//-----------get line--------------//
			tablocation = 'company';
			$('#UsrCtr').css("display", "None");
			$('#CompCtr').css("display", "Block");
			$('#Company').addClass("active");
			$('#Group').removeClass("active");
			var action = "getline";
			var actionmode = "userform";
			$.ajax({
				type: 'POST',
				url: 'userformline.php',
				data:{action:action, actmode:actionmode, userId:so, tablocation:tablocation },
				beforeSend:function(){
				
					$("#dtrContent").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
				},
				success: function(data){
					//payline='';
					//document.getElementById("hide2").value = "";
					$('#dtrContent').html(data);
					document.getElementById("hidecurtab").value = tablocation;
				}
			}); 
			//-----------get line--------------//
		}

		function usergroupline()
		{
			//-----------get line--------------//
			tablocation = 'usrgrp';
			$('#UsrCtr').css("display", "Block");
			$('#CompCtr').css("display", "None");
			$('#Group').addClass("active");
			$('#Company').removeClass("active");
			var action = "getline";
			var actionmode = "userform";
			$.ajax({
				type: 'POST',
				url: 'usergroupformline.php',
				data:{action:action, actmode:actionmode, userId:so, tablocation:tablocation },
				beforeSend:function(){
				
					$("#dtrContent").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
				},
				success: function(data){
					//payline='';
					//document.getElementById("hide2").value = "";
					$('#dtrContent').html(data);
					document.getElementById("hidecurtab").value = tablocation;
				}
			}); 
			//-----------get line--------------//
		}


		$(document).ready(function() {
			
			tablocation = document.getElementById("hidecurtab").value;
			if(tablocation == 'company')
				{
					companyline();
				}
				else if(tablocation == 'usrgrp')
				{
					usergroupline();
				}
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

		function Activate(val)
		{
			
			if(val == "0")
			{
				so = document.getElementById("hide").value;
				companyline();
				
			}

			else
			{
				so = document.getElementById("hide").value;
				usergroupline();

			}
			
		}

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
		    $("#add-UserId").prop('readonly', false);
		    $("#add-pass").show();
			$("#label-pass").show();
			document.getElementById("add-UserId").value = '';
		    document.getElementById("upbt").style.visibility = "hidden";
		    document.getElementById("addbt").style.visibility = "visible";
		}
		UpdateBtn.onclick = function() {
			if(so != '' && locNM != '') {
			    modal.style.display = "block";
			    $("#add-UserId").prop('readonly', true);
			    // $("#add-pass").hide();
			    // $("#label-pass").hide();
				document.getElementById("add-UserId").value = so;
				document.getElementById("add-pass").value = locUPass.toString();
				document.getElementById("add-name").value = locNM.toString();
				document.getElementById("add-dataareaid").value = locDT.toString();
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
		function checkExistForm()
		{
			var cont = document.getElementById("t2").value;
			myId = cont.toLowerCase().split(",");
			//myId.push("Kiwi","Lemon","Pineapple",'asd');
			/*$.each(myId, function(i, el2){
		    	alert(el2);
			});*/
			//alert(myId.length);
			var n = myId.includes(document.getElementById("add-UserId").value.toLowerCase());
			//alert(n);
			if(n == true){
				alert("User ID already Exist!");
				return false;
			}
			else
			{
				//alert("Continue Saving...");
				return true;
			}
			
		}

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
			var UId;
			var UPass;
			var NM;
			var DT;
			var action = "searchdata";
			var actionmode = "userform";
			var data=[];
			 for(i=0;i<search.length;i++){
				 data[i]=search[i].value;
				 //search[i].value = "";
			 }
			 
			 UId = data[0];
			 NM = data[1];
			 DT = data[2];
			 UPass = data[3];
			
			

			
			 $.ajax({
						type: 'GET',
						url: 'userformprocess.php',
						data:{action:action, actmode:actionmode, userno:UId, pass:UPass, lname:NM, darea:DT},
						//data:'bkno='+BNo+'&bkdesc='+BDesc+'&bktit='+BTit+'&bkqty='+BQ,
						beforeSend:function(){
						
							$('#result').html('<center><img src="img/loading.gif" width="300" height="300"></center>');
			
						},
						success: function(data){
							$('#result').html(data);
					
							tablocation = document.getElementById("hidecurtab").value;

							if(tablocation == 'company')
								{
									companyline();
								}
								else if(tablocation == 'usrgrp')
								{
									usergroupline();
								}	
				}
			}); 
			 
		  }
		});
		//-----end search-----//
		function Clear()
		{
			if(so != '')
			{				
				//document.getElementById("add-UserId").value = "";
				//document.getElementById("add-pass").value = "";
				document.getElementById("add-name").value = "";
				document.getElementById("add-dataareaid").value = "";
			}
			else
			{
				document.getElementById("add-UserId").value = "";
				document.getElementById("add-pass").value = "";
				document.getElementById("add-name").value = "";
				document.getElementById("add-dataareaid").value = "";
			}
		}

		function Save()
		{
			
			modal.style.display = "none";
			/*var UId = document.getElementById("add-UserId");
			var UPass = document.getElementById("add-pass");
			var NM = document.getElementById("add-name");
			var DT = document.getElementById("add-dataareaid");*/
			var UId = $('#add-UserId').val();
			var UPass = $('#add-pass').val();
			var NM = $('#add-name').val();
			var DT = $('#add-dataareaid').val();
			var action = "save";
			var actionmode = "userform";
			$.ajax({	
					type: 'GET',
					url: 'userformprocess.php',
					//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
					data:{action:action, actmode:actionmode, userno:UId, pass:UPass, lname:NM, darea:DT},
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
			var UId = $('#add-UserId').val();
			var UPass = $('#add-pass').val();
			var NM = $('#add-name').val();
			var DT = $('#add-dataareaid').val();
			var action = "update";
			var actionmode = "userform";
			if(so != '') {
				if(confirm("Are you sure you want to update this record?")) {
					$.ajax({	
							type: 'GET',
							url: 'userformprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action, actmode:actionmode, userno:UId, pass:UPass, lname:NM, darea:DT},
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
							url: 'userformprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action, actmode:actionmode, userno:so},
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
		function DeleteCompany()
		{
			
			var action = "delete";
			var actionmode = "company";
			if(locDataarea != '') {
				if(confirm("Are you sure you want to remove this record?")) {
					$.ajax({	
							type: 'GET',
							url: 'userformprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action, actmode:actionmode, locDataarea:locDataarea, userno:so},
							beforeSend:function(){
									
							$("#dtrContent").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
								
							},
							success: function(data){
							//$('#conttables').html(data);
							//location.reload();
							companyline();					
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

		function DeleteUsrgroup()
		{
			
			var action = "delete";
			var actionmode = "usrgroup";
			if(locgroupid != '') {
				if(confirm("Are you sure you want to remove this record?")) {
					$.ajax({	
							type: 'GET',
							url: 'userformprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action, actmode:actionmode, locgroupid:locgroupid, userno:so},
							beforeSend:function(){
									
							$("#dtrContent").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
								
							},
							success: function(data){
							//$('#conttables').html(data);
							//location.reload();
							usergroupline();				
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

		function SetDt()
		{
			var action = "dtarea";
			$.ajax({
				type: 'GET',
				url: 'userformprocess.php',
				data:{action:action, UsrId:so},
				success: function(data) {
				    window.location.href='daselection.php';
			    }
			});
		}
		function SetUg()
		{
			var action = "Ugroup";
			$.ajax({
				type: 'GET',
				url: 'userformprocess.php',
				data:{action:action, UsrId:so},
				success: function(data) {
				    window.location.href='usergroupselectionform.php';
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
				url: 'userformprocess.php',
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