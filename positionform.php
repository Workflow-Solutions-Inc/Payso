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
	<title>Position</title>

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
			<li class="PositionMaintain" style="display: none;"><button id="myAddBtn"><span class="fa fa-plus"></span> Create Record</button></li>
			<li class="PositionMaintain" style="display: none;"><button onClick="Delete();"><span class="fa fa-trash-alt"></span> Delete Record</button></li>
			<li class="PositionMaintain" style="display: none;"><button id="myUpdateBtn"><span class="fa fa-edit"></span> Update Record</button></li>
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
							<span class="fa fa-archive"></span> Position
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
										<td style="width:42%;">Position ID</td>
										<td style="width:42%;">Name</td>
										<td style="width:8%;">Grace Period</td>
										<td style="width:8%;">Approver</td>
										<!-- <td style="width:8%;">Filler</td> -->
										<td style="width: 17px;" class="text-center"><span class="fas fa-arrows-alt-v"></span></td>
									</tr>
									<tr class="rowsearch">
									  <td class="text-center"><span class="fas fa-search fa-xs"></span></td>
									  

										<td><input list="SearchPosition" class="search">
										<?php
											$query = "SELECT distinct positionid FROM position where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchPosition">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["positionid"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchName" class="search">
										<?php
											$query = "SELECT distinct name FROM position where dataareaid = '$dataareaid'";
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
									  <td><span></span></td>
									  <td><span></span></td>
									  <td><span></span></td>
									  <td><span></span></td>
									  
									</tr>
								</thead>
								
								<tbody id="result">
									<?php
									$query = "SELECT * FROM position where dataareaid = '$dataareaid'";
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
											$collection = $collection.','.$row['positionid'];
										?>
										<tr id="<?php echo $row['positionid'];?>" class="<?php echo $rowclass; ?>" tabindex="<?php echo $rowcnt2; ?>">
											<!--<td style="width:10px;"><input type='checkbox' name="chkbox" value="" id="myCheck"></td>-->
											<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
											<td style="width:42%;"><?php echo $row['positionid'];?></td>
											<td style="width:42%;"><?php echo $row['name'];?></td>
											<td style="width:8%;"><input type="checkbox" name="chkbox" class="checkbox"  value="true" <?php echo ($row['graceperiod']==1 ? 'checked' : '');?> onclick="return false;"><div style="visibility:hidden;height: 1px;"><?php echo $row['graceperiod'];?></div></td>
											<td style="width:8%;"><input type="checkbox" name="chkbox" class="checkbox"  value="true" <?php echo ($row['isapprover']==1 ? 'checked' : '');?> onclick="return false;"><div style="visibility:hidden;height: 1px;"><?php echo $row['isapprover'];?></div></td>
											
										</tr>
									<?php }?>
								</tbody>
								<span class="temporary-container-input">
									<input type="hidden" id="hide">
									<div style="display:none;width:1%;"><textarea id="t2" value = "<?php echo substr($collection,1);?>"><?php echo substr($collection,1);?></textarea></div>
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
				<div class="col-lg-6">Position</div>
				<div class="col-lg-6"><span class="fas fa-times modal-close"></span></div>
			</div>
			
			<div id="container" class="modal-content-container">
				<form name="myForm" accept-charset="utf-8" action="positionformprocess.php" method="get">
					<div class="row">

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>Position ID:</label>
							<input type="text" value="" placeholder="Position ID" name="PosCode" id="add-position" class="modal-textarea" required="required">

							<label>Name:</label>
							<input type="text" value="" placeholder="Name" name="name" id="add-name" class="modal-textarea" required="required">
						</div>

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>Grace Period:</label><br>
							<span><input type="checkbox" value="0" id="add-period" class="modal-textarea" style="width: 50px;height: 25px;margin-top: 1px;margin-left: 100px;"></span>
								
							
							<br>
							<label>Approver:</label><br>
							<span><input type="checkbox" value="0" id="add-approver" class="modal-textarea" style="width: 50px;height: 25px;margin-top: 1px;margin-left: 100px;"></span>
						</div>
						<input type="hidden" name="period" id="period" value="0" class="modal-textarea">
						<input type="hidden" name="approver" id="approver" value="0" class="modal-textarea">

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

	  	var so='';
	  	var locname='';
	  	var locperiod='';
	  	var locapprover='';
		$(document).ready(function(){
		$('#datatbl tbody tr').click(function(){
			$('table tbody tr').css("color","black");
			$(this).css("color","red");
			$('table tbody tr').removeClass("info");
			$(this).addClass("info");
			var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
			locname = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
			locperiod = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();
			locapprover = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(4)").text();
			so = usernum.toString();
			document.getElementById("hide").value = so;
			//alert(document.getElementById("hide").value);
			//alert(so);	
						  
				});
			});

		$(document).ready(function() {

			loc = document.getElementById("hide").value;
	            //$("#myUpdateBtn").prop("disabled", false);
	        if(loc != '')
	        {
	        	//var pos = $("#"+loc+"").attr("tabindex");
	        	var pos = 1;
	        }
	        else
	        {
	        	var pos = 1;
	        }
		    $("tr[tabindex="+pos+"]").focus();
		    $("tr[tabindex="+pos+"]").css("color","red");
		    $("tr[tabindex="+pos+"]").addClass("info");

		});

		$('#add-period').change(function(){
		    if($(this).attr('checked'))
		    {
          		$(this).val('1');
          		document.getElementById("period").value =1;
		    }
		    else
		    {
		         $(this).val('0');
		         document.getElementById("period").value=0;
		    }
		 });

		$('#add-approver').change(function(){
		    if($(this).attr('checked'))
		    {
          		$(this).val('1');
          		document.getElementById("approver").value =1;
		    }
		    else
		    {
		         $(this).val('0');
		         document.getElementById("approver").value=0;
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
		    //modal.style.display = "block";
		    $("#myModal").stop().fadeTo(500,1);
		    $("#add-position").prop('readonly', false);
		    document.getElementById("add-position").value = '';
		    document.getElementById("upbt").style.visibility = "hidden";
		    document.getElementById("addbt").style.visibility = "visible";
		}
		UpdateBtn.onclick = function() {
			if(so != '') {
			    //modal.style.display = "block";
			    $("#myModal").stop().fadeTo(500,1);
			    $("#add-position").prop('readonly', true);

			    if(locperiod == 1)
			    {
			    	document.getElementById("add-period").checked = true;
			    }
			    else
			    {
			    	document.getElementById("add-period").checked = false;
			    }

			    if(locapprover == 1)
			    {
			    	document.getElementById("add-approver").checked = true;
			    }
			    else
			    {
			    	document.getElementById("add-approver").checked = false;
			    }

				document.getElementById("add-position").value = so;
				document.getElementById("add-name").value = locname;
				document.getElementById("period").value = locperiod;
				document.getElementById("approver").value = locapprover;
				//document.getElementById("add-period").checked = locperiod;
				//document.getElementById("add-approver").checked = locapprover;
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
		var myId = [];
		function checkExistForm()
		{
			var cont = document.getElementById("t2").value;
			myId = cont.toLowerCase().split(",");
			//myId.push("Kiwi","Lemon","Pineapple",'asd');
			/*$.each(myId, function(i, el2){
		    	alert(el2);
			});*/
			//alert(myId.length);
			var n = myId.includes(document.getElementById("add-position").value.toLowerCase());
			//alert(n);
			if(n == true){
				alert("Position ID already Exist!");
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
			var PosCode;
			var name;
			var action = "searchdata";
			var actionmode = "userform";
			var data=[];
			 for(i=0;i<search.length;i++){
				 data[i]=search[i].value;
				 //search[i].value = "";
			 }
			 
			 PosCode = data[0];
			 name = data[1];

			 $.ajax({
						type: 'GET',
						url: 'positionformprocess.php',
						data:{action:action, actmode:actionmode, PosCode:PosCode, name:name},
						//data:'bkno='+BNo+'&bkdesc='+BDesc+'&bktit='+BTit+'&bkqty='+BQ,
						beforeSend:function(){
						
							$("#result").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
			
						},
						success: function(data){
							$('#result').html(data);
							var pos = 1;
						    $("tr[tabindex="+pos+"]").focus();
						    $("tr[tabindex="+pos+"]").css("color","red");
						    $("tr[tabindex="+pos+"]").addClass("info");
						    $(document).ready(function(){
							$('#datatbl tbody tr').click(function(){
								$('table tbody tr').css("color","black");
								$(this).css("color","red");
								$('table tbody tr').removeClass("info");
								$(this).addClass("info");
								var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
								locname = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
								locperiod = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();
								locapprover = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(4)").text();
								so = usernum.toString();
								document.getElementById("hide").value = so;
								//alert(document.getElementById("hide").value);
								//alert(so);	
											  
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
				//document.getElementById("add-position").value = "";
				document.getElementById("add-name").value = "";
				document.getElementById("period").value = 0;
				document.getElementById("approver").value = 0;
				document.getElementById("add-period").checked = false;
				document.getElementById("add-approver").checked = false;
			}
			else
			{
				document.getElementById("add-position").value = "";
				document.getElementById("add-name").value = "";
				document.getElementById("period").value = 0;
				document.getElementById("approver").value = 0;
				document.getElementById("add-period").checked = false;
				document.getElementById("add-approver").checked = false;
			}
		}

		function Save()
		{
			
			modal.style.display = "none";
			/*var UId = document.getElementById("add-UserId");
			var UPass = document.getElementById("add-pass");
			var NM = document.getElementById("add-name");
			var DT = document.getElementById("add-dataareaid");*/
			var PosCode = $('#add-position').val();
			var name = $('#add-name').val();
			var action = "save";
			var actionmode = "userform";
			$.ajax({	
					type: 'GET',
					url: 'positionformprocess.php',
					//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
					data:{action:action, actmode:actionmode, PosCode:PosCode, name:name},
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
			var PosCode = $('#add-position').val();
			var name = $('#add-name').val();
			var action = "update";
			var actionmode = "userform";
			if(so != '') {
				if(confirm("Are you sure you want to update this record?")) {
					$.ajax({	
							type: 'GET',
							url: 'positionformprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action, actmode:actionmode, PosCode:PosCode, name:name},
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
							url: 'positionformprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action, actmode:actionmode, PosCode:so},
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
			//alert(ActiveMode);
		}
</script>
<script type="text/javascript" src="js/custom.js"></script>
	<!-- end [JAVASCRIPT] -->

</body>
</html>