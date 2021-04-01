<?php 
session_start();
include("dbconn.php");
$user = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];

if(isset($_SESSION['WKNumLeave']))
{
	$wkid = $_SESSION['WKNumLeave'];
}
else
{
	header('location: workerform.php');
}
?>

<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Leave File</title>

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
			<li class="LeaveFileMaintain" style="display: none;"><button id="myAddBtn"><span class="fa fa-plus"></span> Create Record</button></li>
			<li class="LeaveFileMaintain" style="display: none;"><button onClick="Delete();"><span class="fa fa-trash-alt"></span> Delete Record</button></li>
			<li class="LeaveFileMaintain" style="display: none;"><button id="myUpdateBtn"><span class="fa fa-edit"></span> Update Record</button></li>
			<li><button onClick="Cancel();"><span class="fa fa-arrow-circle-left fa-lg"></span> Back</button></li>
		</ul>
		
		<!-- extra buttons -->
		<!--<ul class="extrabuttons">
			<li><button><span class="fas fa-arrow-up fa"></span> Move Up</button></li>
			<li><button><span class="fas fa-arrow-down fa"></span> Move Down</button></li>
		</ul>-->

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
							<?php
							$query2 = "SELECT * FROM worker where workerid = '$wkid' and dataareaid = '$dataareaid'";
								$result2 = $conn->query($query2);
								$row2 = $result2->fetch_assoc();
								$uname = $row2["name"];

							?>
							<span class="fa fa-archive"></span> Set Leave Credit for <?php echo $uname;?> 
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
										<td style="width:14%;">Leave Type</td>
										<td style="width:14%;">Description</td>
										<td style="width:14%;">Leave Credits</td>
										<td style="width:14%;">Year</td>
										<td style="width:14%;">From Date</td>
										<td style="width:14%;">To Date</td>
										<td style="width:14%;">Balance</td>
										<td style="width:5%;">Paid</td>
										<td style="width:5%;">CTC</td>
										<td style="width: 17px;" class="text-center"><span class="fas fa-arrows-alt-v"></span></td>
									</tr>
									<tr class="rowsearch">
									  <td class="text-center"><span class="fas fa-search fa-xs"></span></td>
									  

										<td><input list="SearchLeaveType" class="search">
										<?php
											$query = "SELECT distinct leavetype FROM leavefile where workerid = '$wkid' and dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchLeaveType">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["leavetype"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchDesc" class="search">
										<?php
											$query = "SELECT distinct lt.description

														FROM leavefile lf
														left join leavetype lt on lt.leavetypeid = lf.leavetype 

														where lf.dataareaid = '$dataareaid' and lf.workerid = '$wkid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchDesc">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["description"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchSubmodule" class="search" disabled>
										<?php
											$query = "SELECT distinct submodule FROM privileges";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchSubmodule">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["submodule"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchName" class="search" disabled>
										<?php
											$query = "SELECT distinct name FROM privileges";
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
									  <td><span></span></td>
									  <td><span></span></td>
									</tr>


								</thead>
								<tbody id="result">
									<?php					
									$query = "SELECT lf.leavetype,lt.description,format(lf.leavecredits,2) leavecredits,format(lf.balance,2) balance,lf.ispaid,lf.isconvertible
														,lf.year,lf.fromdate,lf.todate,lf.recid

												FROM leavefile lf
												left join leavetype lt on lt.leavetypeid = lf.leavetype 

												where lf.dataareaid = '$dataareaid' and lf.workerid = '$wkid'";
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
											$collection = $collection.','.$row['leavetype'].'-'.$row['year'];
										?>
										<tr id="<?php echo $row['leavetype'];?>" class="<?php echo $rowclass; ?>" tabindex="<?php echo $rowcnt2; ?>">
											<!--<td style="width:10px;"><input type='checkbox' name="chkbox" value="" id="myCheck"></td>-->
											<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
											<td style="width:14%;"><?php echo $row['leavetype'];?></td>
											<td style="width:14%;"><?php echo $row['description'];?></td>
											<td style="width:14%;"><?php echo $row['leavecredits'];?></td>
											<td style="width:14%;"><?php echo $row['year'];?></td>
											<td style="width:14%;"><?php echo $row['fromdate'];?></td>
											<td style="width:14%;"><?php echo $row['todate'];?></td>
											<td style="width:14%;"><?php echo $row['balance'];?></td>
											<td style="width:5%;"><input type="checkbox" name="chkbox" class="checkbox"  value="true" <?php echo ($row['ispaid']==1 ? 'checked' : '');?> onclick="return false;"><div style="visibility:hidden;height: 1px;"><?php echo $row['ispaid'];?></div></td>
											<td style="width:5%;"><input type="checkbox" name="chkbox" class="checkbox"  value="true" <?php echo ($row['isconvertible']==1 ? 'checked' : '');?> onclick="return false;"><div style="visibility:hidden;height: 1px;"><?php echo $row['isconvertible'];?></div></td>
											<td style="display:none;width:1%;"><?php echo $row['recid'];?></td>
											<!--<td style="width:50%;"><input type='password' value='" . $row["password"]."'readonly='readonly'></td>-->
											
										</tr>
									<?php }?>
								</tbody>
								<span class="temporary-container-input">
									<input type="hidden" id="hide">
									<input type="hidden" id="hidewk" value="<?php echo $wkid; ?>">
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
				<div class="col-lg-6">Set Leave Credits</div>
				<div class="col-lg-6"><span class="fas fa-times modal-close"></span></div>
			</div>
			
			<div id="container" class="modal-content-container">
				<form name="myForm" accept-charset="utf-8" action="leavefileformprocess.php" method="get">
					<div class="row">

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>Leave Type:</label>
							<select value="" value="" placeholder="Leave Type" name ="leavetype" id="add-leavetype" class="modal-textarea" style="width:100%;height: 28px;"  required="required">
								<option value="" selected="selected"></option>
								<?php
									$query = "SELECT distinct leavetypeid,description FROM leavetype";
									$result = $conn->query($query);			
									  	
										while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["leavetypeid"];?>"><?php echo $row["description"];?></option>
									<?php } ?>
							</select>


							<label>Year:</label>
							<select value="" value="" placeholder="Period" name ="yrSelection" id="add-yrselection" class="modal-textarea" style="width:100%;height: 28px;"  required="required">
									<option value=""></option>
									<?php
										foreach(range(date("Y")-5, (int)date("Y")) as $year) 
										{?>
										  <option value='<?php echo $year;?>'><?php echo $year;?></option>
										<?PHP }
									?>
							</select>

							<label>From Date:</label>
							<input type="date" id="add-fromdate" name ="FromDate" class="modal-textarea" required="required">

							<label>To Date:</label>
							<input type="date" id="add-todate" name ="EndDate" class="modal-textarea" required="required">
						</div>

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>Leave Credit:</label>
							<input type="number" step="1" min="0" value="0" placeholder="" id="add-credit" name="credit" class="modal-textarea" required="required" onkeypress="return !(event.charCode == 46)">

							<label>Balance:</label>
							<input type="number" step="1" min="0" value="0" placeholder="" id="add-balance" name="balance" class="modal-textarea" required="required" onkeypress="return !(event.charCode == 46)">

							<label>Paid:</label><br>
							<span><input type="checkbox" value="0" id="add-paid" class="modal-textarea" style="width: 50px;height: 25px;margin-top: 1px;margin-left: 100px;"></span>
							<br>
							<label>Convertible:</label><br>
							<span><input type="checkbox" value="0" id="add-convert" class="modal-textarea" style="width: 50px;height: 25px;margin-top: 1px;margin-left: 100px;"></span>
						</div>
						<input type="hidden" name="paid" id="paid" value="0" class="modal-textarea">
						<input type="hidden" name="convert" id="convert" value="0" class="modal-textarea">
						<input type="hidden" name="wkid" id="hide2" value="<?php echo $wkid; ?>">
						<input type="hidden" name="recid" id="hiderec" value="">

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
	  	var loctype;
		var locdesc;
		var loccredit;
		var locbal;
		var locpaid;
		var locyear;
		var locfromdate;
		var loctodate;
		var locrecid;
		var locconv;
  		$(document).ready(function(){
			$('#datatbl tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","red");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
				locdesc = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
				loccredit = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();
				locyear = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(4)").text();
				locfromdate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(5)").text();
				loctodate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(6)").text();
				locbal = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(7)").text();
				locpaid = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(8)").text();
				locconv = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(9)").text();
				locrecid = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(10)").text();
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

		$('#add-paid').change(function(){
		    if($(this).attr('checked'))
		    {
          		$(this).val('1');
          		document.getElementById("paid").value =1;
          		//alert(1);
		    }
		    else
		    {
		         $(this).val('0');
		         document.getElementById("paid").value=0;
		         //alert(0);
		    }
		 });

		$('#add-convert').change(function(){
		    if($(this).attr('checked'))
		    {
          		$(this).val('1');
          		document.getElementById("convert").value =1;
          		//alert(1);
		    }
		    else
		    {
		         $(this).val('0');
		         document.getElementById("convert").value=0;
		         //alert(0);
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
		    $("#add-leavetype").prop('readonly', false);
		    document.getElementById("add-leavetype").value = "";
		    document.getElementById("upbt").style.visibility = "hidden";
		    document.getElementById("addbt").style.visibility = "visible";
		}
		UpdateBtn.onclick = function() {
			if(so != '') {
			    //modal.style.display = "block";
			    $("#myModal").stop().fadeTo(500,1);
			    $("#add-leavetype").prop('readonly', true);
			    //alert(locpaid);

			    if(locpaid == 1)
			    {
			    	document.getElementById("add-paid").checked = true;
			    	document.getElementById("paid").value =1;
			    }
			    else
			    {
			    	document.getElementById("add-paid").checked = false;
			    	document.getElementById("paid").value=0;
			    }

			    if(locconv == 1)
			    {
			    	document.getElementById("add-convert").checked = true;
			    	document.getElementById("convert").value =1;
			    }
			    else
			    {
			    	document.getElementById("add-convert").checked = false;
			    	document.getElementById("convert").value=0;
			    }


				document.getElementById("add-leavetype").value = so;
				document.getElementById("add-credit").value = loccredit.toString();
				document.getElementById("add-balance").value = locbal.toString();
				document.getElementById("add-yrselection").value = locyear.toString();
				document.getElementById("add-fromdate").value = locfromdate.toString();
				document.getElementById("add-todate").value = loctodate.toString();
				document.getElementById("hiderec").value = locrecid.toString();
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
			//alert(document.getElementById("add-leavetype").value.toLowerCase()+'-'+document.getElementById("add-yrselection").value.toLowerCase());
			var n = myId.includes(document.getElementById("add-leavetype").value.toLowerCase()+'-'+document.getElementById("add-yrselection").value.toLowerCase());
			//alert(n);
			if(n == true){
				alert("Leave Type already Exist in selected year!");
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
			var loctype;
			var locname;
			
			var action = "searchdata";
			var actionmode = "userform";
			var data=[];
			 for(i=0;i<search.length;i++){
				 data[i]=search[i].value;
				 //search[i].value = "";
			 }
			 
			 loctype = data[0];
			 locname = data[1];
			 
			
			

			
			 $.ajax({
						type: 'GET',
						url: 'leavefileformprocess.php',
						data:{action:action, actmode:actionmode, loctype:loctype, locname:locname},
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
				}
			}); 
			 
		  }
		});
		//-----end search-----//

		function Clear()
		{
			if(so != '') {
				//document.getElementById("add-privilege").value = "";
				//document.getElementById("add-leavetype").value = "";
				document.getElementById("add-yrselection").value = locyear.toString();
				document.getElementById("add-fromdate").value = locfromdate.toString();
				document.getElementById("add-todate").value = loctodate.toString();
				document.getElementById("add-credit").value = 0;
				document.getElementById("add-balance").value = 0;
				document.getElementById("add-paid").checked = false;
				document.getElementById("paid").value = 0;
			}
			else
			{
				document.getElementById("add-leavetype").value = "";
				document.getElementById("add-yrselection").value = "";
				document.getElementById("add-fromdate").value = "";
				document.getElementById("add-todate").value = "";
				document.getElementById("add-credit").value = 0;
				document.getElementById("add-balance").value = 0;
				document.getElementById("add-paid").checked = false;
				document.getElementById("paid").value = 0;
			}
		}

		function Save()
		{
			
			modal.style.display = "none";
			/*var UId = document.getElementById("add-UserId");
			var UPass = document.getElementById("add-pass");
			var NM = document.getElementById("add-name");
			var DT = document.getElementById("add-dataareaid");*/
			var PriveId = $('#add-privilege').val();
			var PrivModule = $('#add-module').val();
			var PrivSub = $('#add-submodule').val();
			var PrivName = $('#add-name').val();
			var action = "save";
			var actionmode = "userform";
			$.ajax({	
					type: 'GET',
					url: 'leavefileformprocess.php',
					//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
					data:{action:action, actmode:actionmode, PriveId:PriveId, PrivModule:PrivModule, PrivSub:PrivSub, PrivName:PrivName},
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
			var PriveId = $('#add-privilege').val();
			var PrivModule = $('#add-module').val();
			var PrivSub = $('#add-submodule').val();
			var PrivName = $('#add-name').val();
			var action = "update";
			var actionmode = "userform";
			if(so != '') {
				if(confirm("Are you sure you want to update this record?")) {
					$.ajax({	
							type: 'GET',
							url: 'privilegesformprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action, actmode:actionmode, PriveId:PriveId, PrivModule:PrivModule, PrivSub:PrivSub, PrivName:PrivName},
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
			var wkid = $('#hidewk').val();
			var leavetype = so;
			if(so != '') {
				if(confirm("Are you sure you want to remove this record?")) {
					$.ajax({	
							type: 'GET',
							url: 'leavefileformprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action, actmode:actionmode, wkid:wkid, leavetype:leavetype, locrecid:locrecid},
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
			//alert(so);
			//window.location.href='workerform.php';
			var action = "unload";
			$.ajax({
				type: 'GET',
				url: 'leavefileformprocess.php',
				data:{action:action},
				success: function(data) {
				    window.location.href='workerform.php';
			    }
			});  
		}

	</script>
<script type="text/javascript" src="js/custom.js"></script>
<!-- end [JAVASCRIPT] -->

</body>
</html>