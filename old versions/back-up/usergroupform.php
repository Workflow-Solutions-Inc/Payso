<?php 
session_start();
include("dbconn.php");
#$user = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
?>

<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>User Group</title>

	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="css/fontawesome.min.css" />
	<link rel="stylesheet" type="text/css" href="css/typography.css" />
	<link rel="stylesheet" type="text/css" href="css/custom.css" />
	<script src="js/jquery.min.js"></script>

</head>
<body>


	<!-- begin LEFTPANEL -->
	<div id="leftpanel" class="leftpanel hidden-sm hidden-xs">
		<div class="leftpanel-admin">
			<div class="admin-icon"><img src="images/admin-icon.png"></div>
			<div class="admin-text">
				<div><b>Admin Name</b></div>
				<div>Current Login / Date Time</div>
			</div>
		</div>
		<ul class="leftpanel-nav">
			<li><button id="myAddBtn"><span class="fa fa-home fa-wrench fa-lg"></span> Create Record</button></li>
			<li><button onClick="Delete();"><span class="fa fa-home fa-wrench fa-lg"></span> Delete Record</button></li>
			<li><button id="myUpdateBtn"><span class="fa fa-home fa-wrench fa-lg"></span> Update Record</button></li>
		</ul>
		<ul class="leftpanel-nav leftpanel-dark">
			<li><a href="#"><span class="fa fa-cog fa-lg"></span> hyperlink 1</a></li>
			<li><a href="#"><span class="fa fa-home fa-lg"></span> hyperlink 2</a></li>
			<li><a href="#"><span class="fa fa-home fa-lg"></span> hyperlink 3</a></li>
		</ul>
		<ul class="leftpanel-nav leftpanel-darker">
			<li><button><span class="fa fa-home fa-lg"></span> button 1</button></li>
			<li><button><span class="fa fa-home fa-lg"></span> button 2</button></li>
			<li><button><span class="fa fa-home fa-lg"></span> button 3</button></li>
		</ul>
		<div class="leftpanel-min">
			<span id="leftpanel-minimize-button" class="minimize fa fa-chevron-circle-left"></span>
		</div>
	</div>
	<!-- end LEFTPANEL -->


	<!-- begin LEFTPANEL BAR (MINI) -->
	<div id="leftpanel-bar" class="leftpanel-bar">
		<div class="leftpanel-max">
			<span id="leftpanel-maximize-button" class="maximize fa fa-chevron-circle-right"></span>
		</div>
	</div>
	<!-- end LEFTPANEL BAR (MINI) -->



	<!-- begin MAINPANEL -->
	<div id="mainpanel" class="mainpanel">

		<!-- HEADER -->
		<div class="header">
			<div class="togglepos hidden-sm hidden-xs">
				<button id="changeposition-6-button" class="btn"><span class="fa fa-columns fa-lg"></span></button>
				<button id="changeposition-12-button" class="btn hide"><span class="fa fa-columns fa-lg fa-rotate-270"></span></button>
			</div>

			<div class="header-container">
				<div class="container-fluid">
					<div class="row">
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 item active"><a href="menu.php">
							<span class="fa fa-list"></span> <span class="hidden-xs hidden-sm">Common Forms</span></a></div>
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 item"><a href="#">
							<span class="fa fa-cog"></span> <span class="hidden-xs hidden-sm">Setup</span></a></div>
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 item"><a href="#">
							<span class="fa fa-edit"></span> <span class="hidden-xs hidden-sm">Reports</span></a></div>
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 item"><a href="#">
							<span class="fa fa-info"></span> <span class="hidden-xs hidden-sm">Inquiry</a></div>
					</div>
				</div>
			</div>
		</div>



		<div class="container-fluid">
			<div class="row">
				<!-- start TABLE AREA -->
				<div id="tablearea1" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mainpanel-area">
					<div class="mainpanel-table">
						<!-- title & search -->
						<div class="mainpanel-title">
							
							<form action="dosomething.php" target="_self">
								<div class="mainpanel-sub-search">Search: <input type="text"> <input type="submit" value="Find"></div>
							</form>

							<div class="mainpanel-title-text"><span class="fa fa-archive"></span> Overview</div>
						</div>
						<div class="mainpanel-sub">
							<!-- cmd -->
							<div class="mainpanel-sub-cmd">
								<a href=""><span class="fa fa-cog"></a>
								<a href=""><span class="fa fa-cog"></a>
								<a href=""><span class="fa fa-cog"></a>
									|
								<a href=""><span class="fa fa-cog"></a>
								<a href=""><span class="fa fa-cog"></a>
							</div>
							<!-- nav -->
							<div class="mainpanel-sub-nav">
								<a href="#"><span class="fa fa-angle-double-left"></a>
								<a href="#"><span class="fa fa-angle-left"></a>
								<span> [ 1 of 10 ] </span>
								<a href="#"><span class="fa fa-angle-right"></a>
								<a href="#"><span class="fa fa-angle-double-right"></a>
							</div>
						</div>
						<!-- tableheader -->
						<table width="100%" border="0" id="datatbl">
							<thead>
								<tr class="rowB rowactive">
									<td><span class="fa fa-adjust"></span></td>
									<td style="width:50%;">User Group id</td>
									<td style="width:50%;">Name</td>
								</tr>
								<tr class="rowA">
								  <td><span class="fa fa-adjust"></span></td>
								  

									<td style="width:25%;"><input style="width:100%;height: 20px;" list="SearchUserGroupid" class="search">
									<?php
										$query = "SELECT distinct usergroupid FROM usergroups";
										$result = $conn->query($query);	
											
								  ?>
								  <datalist id="SearchUserGroupid">
									
									<?php 
									
										while ($row = $result->fetch_assoc()) {
									?>
										<option value="<?php echo $row["usergroupid"];?>"></option>
										
									<?php } ?>
									</datalist>
								  </td>
								  <td style="width:width:25%;"><input style="width:100%;height: 20px;" list="SearchName" class="search">
									<?php
										$query = "SELECT distinct name FROM usergroups";
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
								  
								  
								</tr>
							</thead>
							
							<tbody id="result">
								<?php
								$query = "SELECT * FROM usergroups";
								$result = $conn->query($query);
								while ($row = $result->fetch_assoc())
								{ ?>
									<tr class="rowA">
										<!--<td style="width:10px;"><input type='checkbox' name="chkbox" value="" id="myCheck"></td>-->
										<td><span class="fa fa-adjust"></span></td>
										<td style="width:50%;"><?php echo $row['usergroupid'];?></td>
										<td style="width:50%;"><?php echo $row['name'];?></td>
										
									</tr>
								<?php }?>
							</tbody>
							<input type="input" id="hide">	
						</table>
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
				<div class="col-lg-6">add info</div>
				<div class="col-lg-6"><span class="fas fa-times modal-close"></span></div>
			</div>
			
			<div id="container" class="modal-content-container">
				<div class="row">

					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
						<label>User ID:</label>
						<input type="text" value="" placeholder="User Id" id="add-UserId" class="modal-textarea">

						<label>Name:</label>
						<input type="text" value="" placeholder="Name" id="add-name" class="modal-textarea">
					</div>

					</div>

				</div>

				<div class="button-container">
					<button id="addbt" onClick="Save();" class="btn btn-primary btn-action">Save</button>
					<button id="upbt" onClick="Update();" class="btn btn-success btn-action">Update</button>
					<button onClick="Clear();" class="btn btn-danger">Clear</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- end modal-->


<!-- begin [JAVASCRIPT] -->
<script src="js/ajax.js"></script>
	 <script  type="text/javascript">

	  	var so='';
		$(document).ready(function(){
		$('#datatbl tbody tr').click(function(){
			$('table tbody tr').css("color","black");
			$(this).css("color","red");
			$('table tbody tr').removeClass("info");
			$(this).addClass("info");
			var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
			so = usernum.toString();
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
		    document.getElementById("upbt").style.visibility = "hidden";
		    document.getElementById("addbt").style.visibility = "visible";
		}
		UpdateBtn.onclick = function() {
			if(so != '') {
			    modal.style.display = "block";
			    $("#add-UserId").prop('readonly', true);
				document.getElementById("add-UserId").value = so;
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
		window.onclick = function(event) {
		    if (event.target == modal || event.target == modal2) {
		        modal.style.display = "none";
		        Clear()
		        
		    }
		}
		//end modal --------------------------- 

		//-----search-----//
		$( ".search" ).on( "keydown", function(event) {
		  if(event.which == 13){
			var search = document.getElementsByClassName('search');
			var UId;
			var NM;
			var action = "searchdata";
			var actionmode = "userform";
			var data=[];
			 for(i=0;i<search.length;i++){
				 data[i]=search[i].value;
				 search[i].value = "";
			 }
			 
			 UId = data[0];
			 NM = data[1];

			
			

			
			 $.ajax({
						type: 'GET',
						url: 'usergroupformprocess.php',
						data:{action:action, actmode:actionmode, userno:UId, name:NM},
						//data:'bkno='+BNo+'&bkdesc='+BDesc+'&bktit='+BTit+'&bkqty='+BQ,
						beforeSend:function(){
						
							//$("#datatbl").html('<img src="img/loading.gif" width="300" height="300">');
			
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
			document.getElementById("add-UserId").value = "";
			document.getElementById("add-name").value = "";
		}

		function Save()
		{
			
			modal.style.display = "none";
			/*var UId = document.getElementById("add-UserId");
			var UPass = document.getElementById("add-pass");
			var NM = document.getElementById("add-name");
			var DT = document.getElementById("add-dataareaid");*/
			var UId = $('#add-UserId').val();
			var NM = $('#add-name').val();
			var action = "save";
			var actionmode = "userform";
			$.ajax({	
					type: 'GET',
					url: 'usergroupformprocess.php',
					//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
					data:{action:action, actmode:actionmode, userno:UId, name:NM},
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
			var NM = $('#add-name').val();
			var action = "update";
			var actionmode = "userform";
			if(so != '') {
				if(confirm("Are you sure you want to update this record?")) {
					$.ajax({	
							type: 'GET',
							url: 'usergroupformprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action, actmode:actionmode, userno:UId, name:NM},
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
			var actionmode = "userform";
			if(so != '') {
				if(confirm("Are you sure you want to remove this record?")) {
					$.ajax({	
							type: 'GET',
							url: 'usergroupformprocess.php',
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
</script>
<script type="text/javascript" src="js/custom.js"></script>
	<!-- end [JAVASCRIPT] -->

</body>
</html>