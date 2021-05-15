<?php 
session_start();
session_regenerate_id();
include("dbconn.php");
#$user = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];

?>

<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Memo Reports</title>

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
			<li><button id="myAddBtn"><span class="fa fa-plus"></span> Create Memo</button></li>
			<li><button id="myUpdateBtn"><span class="fa fa-edit"></span> Update Memo</button></li>
			<li><button onClick="Delete();"><span class="fa fa-trash-alt"></span> Delete Memo</button></li>
			<li><button onClick="Cancel();"><span class="fa fa-arrow-circle-left fa-lg"></span> Back</button></li>
			
		</ul>
		
		<!-- extra buttons -->
		<ul class="extrabuttons">
			<div class="leftpanel-title"><b>Lines</b></div>
			<li><button onClick="SetSub();"><span class="fas fa-cog fa"></span> Set Memo</button></li>
			<li><button onClick="DeleteCompany();"><span class="fa fa-trash-alt"></span> Remove</button></li>
			<!--<li><button><span class="fas fa-arrow-down fa"></span> Move Down</button></li>-->
		</ul>
		<ul class="extrabuttons">
			<li><button onClick="generateMemo();"><span class="fa fa-print fa-lg"></span> Generate Memo</button></li>
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
							<span class="fa fa-archive"></span> Memo
						</div>
						<div class="mainpanel-sub">
						</div>
						<!-- tableheader -->
						<div id="container1" class="half">
							<table width="100%" style="border: 1px solid #d9d9d9;" id="datatbl" class="table table-striped mainpanel-table">
								<thead>
									<tr class="rowtitle">
										<td style="width:20px;" class="text-center"><span class="fa fa-asterisk fa-xs"></span></td>
										<td style="width:10%;">Memo ID</td>
										<td style="width:25%;">Subject</td>
										<td style="width:40%;">Body</td>
										<td style="width:15%;">Sender</td>
										<td style="width:10%;">Created Date</td>
										<td style="width: 17px;" class="text-center"><span class="fas fa-arrows-alt-v"></span></td>										
									</tr>
								
								
									<tr class="rowsearch">
												  <td class="text-center"><span class="fas fa-search fa-xs"></span></td>
												  
												  <td><span></span></td>
												  <td><span></span></td>
												  <td><span></span></td>
												  <td><span></span></td>
												  <td><span></span></td>
												  <td><span></span></td>
												  
												</tr>
								</thead>
								
								<tbody id="result">
									<?php
									$query = "SELECT memoid,subject,memofrom,CONCAT(LEFT(body,100),IF(length(body) > 100, '...', '')) as cutBody,body,DATE(createddatetime) as date
									from memoheader where dataareaid = '$dataareaid'";
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
											<tr id="<?php echo $row['memoid'];?>" class="<?php echo $rowclass; ?>" tabindex="<?php echo $rowcnt2; ?>">
											<!--<td style="width:10px;"><input type='checkbox' name="chkbox" value="" id="myCheck"></td>-->
											<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
											<td style="width:10%;"><?php echo $row['memoid'];?></td>
											<td style="width:25%;"><?php echo $row['subject'];?></td>
											<td style="width:40%;"><?php echo $row['cutBody'];?></td>
											<td style="width:15%;"><?php echo $row['memofrom'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['body'];?></td>
											<td style="width:10%;"><?php echo $row['date'];?></td>
											<!--<td style="width:50%;"><input type='password' value='" . $row["password"]."'readonly='readonly' style="width:100%;"></td>-->
										</tr>

									<?php 
									//$firstresult = $row["userid"];
									}
										$result2 = $conn->query($query);
										$row2 = $result2->fetch_assoc();
										$firstresult = $row2["memoid"];
									?>
								
								</tbody>
								<span class="temporary-container-input">
									<input type="hidden" id="hide" value="<?php echo $firstresult; ?>">
									
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
							Memo Details
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
										<td style="width:20%;">Status</td>
										<td style="width: 17px;" class="text-center"><span class="fas fa-arrows-alt-v"></span></td>	
									</tr>
								
								</thead>

								<tbody id="lineresult">
										<?php
										
											$VarUserid = $firstresult; 

										$query = "SELECT wk.workerid,wk.Name,pos.name as 'position',dep.name as 'department',md.status	as 'status'
															FROM worker wk
															left join position pos on pos.positionid = wk.position and pos.dataareaid = wk.dataareaid 
															left join contract con on con.workerid = wk.workerid and con.dataareaid = wk.dataareaid
															left join department dep on dep.departmentid = con.departmentid and dep.dataareaid = wk.dataareaid
															left join branch bra on bra.branchcode = wk.branch and bra.dataareaid = wk.dataareaid
                                                            left join memodetail md on wk.workerid = md.workerid and wk.dataareaid = md.dataareaid

															where wk.dataareaid = '$dataareaid' and md.memoid = '$VarUserid'

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
												<td style="width:20%;"><?php echo $row['status'];?></td>
												
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
<!-- The Modal -->
<div id="myModal" class="modal">
	<!-- Modal content -->
	<div class="modal-container">
		<div class="modal-content">
			<div class="modal-header">
				<div class="col-lg-6">Memo</div>
				<div class="col-lg-6"><span class="fas fa-times modal-close"></span></div>
			</div>
			
			<div id="container" class="modal-content-container">
				<form name="myForm" accept-charset="utf-8" action="memoprocess.php" method="get">
					<div class="row">

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>Memo ID:</label>
							<div id="resultid">
								<input type="text" value="" placeholder="Memo Id" name ="memoid" id="add-MemoId" class="modal-textarea" required="required">
							</div>
						</div>

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<!--<input type="text" value="" placeholder="Default Dataarea Id" id="add-dataareaid" class="modal-textarea">-->

							<label id="label-pass">From:</label>
							<input type="text" value="" placeholder="From" name ="from" id="add-from" class="modal-textarea" required="required">
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<label>Subject:</label>
								<input type="text" value="" placeholder="Subject" name ="subject" id="add-subject" class="modal-textarea" required="required">
							<label>Body:</label>
							
								<textarea type="textarea" value="" placeholder="Body" name ="body" id="add-body" class="modal-textarea" required="required"></textarea>
							
							
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
				locSub = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
				locBody = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(5)").text();
				locFrom = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(4)").text();
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
					url: 'memoline.php',
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
				flaglocation = true;
				//alert(flaglocation);
		        $("#myUpdateBtn").prop("disabled", false);	
					  
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
		    //$("#add-MemoId").prop('readonly', false);

			//document.getElementById("add-MemoId").value = '';
		    document.getElementById("upbt").style.visibility = "hidden";
		    document.getElementById("addbt").style.visibility = "visible";
		    var action = "add";
			    $.ajax({
							type: 'GET',
							url: 'memoprocess.php',
							data:{action:action},
							//data:'bkno='+BNo+'&bkdesc='+BDesc+'&bktit='+BTit+'&bkqty='+BQ,
							beforeSend:function(){
							
								//$("#result").html('<img src="img/loading.gif" width="300" height="300">');
				
							},
							success: function(data){
								$('#resultid').html(data);
								$("#add-MemoId").prop('readonly', true); 
					}
				});
		}
		UpdateBtn.onclick = function() {
			if(so != '' && locSub != '') {
			    modal.style.display = "block";
			    $("#add-MemoId").prop('readonly', true);

				document.getElementById("add-MemoId").value = so;
				document.getElementById("add-subject").value = locSub.toString();
				document.getElementById("add-body").value = locBody.toString();
				document.getElementById("add-from").value = locFrom.toString();
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
				alert("Continue Saving...");
				return false;
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
				document.getElementById("add-MemoId").value = "";
				document.getElementById("add-form").value = "";
				document.getElementById("add-subject").value = "";
				document.getElementById("add-body").value = "";
			}
		}


		function Delete()
		{
			
			var action = "delete";
			var actionmode = "memoform";
			//alert(so);

			if(so != '') {
				if(confirm("Are you sure you want to remove this record?")) {
					$.ajax({	
							type: 'GET',
							url: 'memoprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action, actmode:actionmode, memoid:so},
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
			
			var action = "deleteline";
			var actionmode = "subline";
			//alert(so);
			//alert(locworker);
			if(locworker != '') {
				if(confirm("Are you sure you want to remove this record?")) {
					$.ajax({	
							type: 'GET',
							url: 'memoprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action, actmode:actionmode, locworker:locworker, memoid:so},
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
								url: 'memoline.php',
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
			//alert(so);
			$.ajax({
				type: 'GET',
				url: 'memoprocess.php',
				data:{action:action, UsrId:so},
				success: function(data) {
				    window.location.href='memoselection.php';
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
				url: 'memoprocess.php',
				data:{action:action},
				success: function(data) {
				    window.location.href='menu.php?list='+ActiveMode;
			    }
			});  
		}

		function generateMemo()
    	{
    		//window.open('Reports/Memo/Memo.php', "_blank");
    		//var selectedWorker = document.getElementById("myWorker").value;
			if(so != '')
			{
				window.open('Reports/Memo/Memo.php?memoid='+so, "_blank");
			}
			else
			{
				alert("Please a specific year and worker to proceed.");
			}
    	}

	</script>
	
	<script type="text/javascript" src="js/custom.js">
	</script>
	<!-- end [JAVASCRIPT] -->

</body>
</html>