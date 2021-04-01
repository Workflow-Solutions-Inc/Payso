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
	<title>Leave Payout</title>

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
			<li><button id="myAddBtn"><span class="fa fa-plus"></span> Create Record</button></li>
			<li><button id="myUpdateBtn"><span class="fa fa-edit"></span> Update Record</button></li>
			<li><button onClick="Delete();"><span class="fa fa-trash-alt"></span> Delete Record</button></li>
			<li><button onClick="Cancel();"><span class="fa fa-arrow-circle-left fa-lg"></span> Back</button></li>
		</ul>
		
		<!-- extra buttons -->
		 <ul class="extrabuttons">
			<div class="leftpanel-title"><b>LINE</b></div>
			<li><button onClick="linedetails()"><span class="fas fa-info-circle"></span> Details</button></li>
		</ul> 
		
		<ul class="extrabuttons">
			<div class="leftpanel-title"><b>POST</b></div>
			<li><button onClick="Posted()"><span class="fas fa-plus-square"></span> Post</button></li>
		</ul> 

		<!-- Code addred by jonald 2020-07-06 -->
		<ul class="extrabuttons">
			<div class="leftpanel-title"><b>Generate Report</b></div>
			<li><button onClick="GenerateReport()"><span class="fas fa-plus-square"></span> Generate</button></li>
		</ul> 
		<!-- end code -->

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
							<span class="fa fa-archive"></span> Leave Payout Details
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
							<table width="100%" style="border: 1px solid #d9d9d9;" id="datatbl" class="table mainpanel-table">
								<thead>
									<tr class="rowtitle">
										<td style="width:20px;" class="text-center"><span class="fa fa-asterisk fa-xs"></span></td>
										<td style="width:33%;">Payout Id</td>
										<td style="width:33%;">Year</td>
										<td style="width:33%;">Status</td>
										<td style="width: 17px;" class="text-center"><span class="fas fa-arrows-alt-v"></span></td>
									</tr>
									<tr class="rowsearch">
									  <td class="text-center"><span class="fas fa-search fa-xs"></span></td>

										<td><input list="SearchLeavePayoutid" class="search" disabled>
										<?php
											$query = "SELECT distinct leavepayoutid FROM leavepayoutheader where dataareaid = '$dataareaid'";
											$result = $conn->query($query);
									  	?>
									  <datalist id="SearchLeavePayoutid">
										<?php 
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["leavepayoutid"];?>"></option>
										<?php } ?>
										</datalist>
									  </td>

									   <td><input list="SearchYear" class="search" disabled>
										<?php
											$query = "SELECT distinct year FROM leavepayoutheader where dataareaid = '$dataareaid'";
											$result = $conn->query($query);		
									  	?>
									  <datalist id="SearchYear">
										<?php 
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["year"];?>"></option>
										<?php } ?>
										</datalist>
									  </td>

									  


									  <td><input list="SearchStatus" class="search" disabled>
										<?php
											$query = "SELECT distinct status FROM leavepayoutheader where dataareaid = '$dataareaid'";
											$result = $conn->query($query);		
									  	?>
									  <datalist id="SearchStatus">
										<?php 
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php if ($row['status'] == 1) {
												echo "Posted";
											} else {
												echo "Created";
											}?>"></option>
										<?php } ?>
										</datalist>
									  </td>
									  <td><span></span></td>

									</tr>


								</thead>
								<tbody id="result">
									<?php
									$query = "SELECT leavepayoutid,year,fromdate,todate,case when status = 1 then 'Posted' else 'Created' end as statustxt,status from leavepayoutheader
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
											<td style="width:33%;"><?php echo $row['leavepayoutid'];?></td>
											<td style="width:33%;"><?php echo $row['year'];?></td>
											<td style="width:33%;"><?php echo $row['statustxt'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['status'];?></td>
										</tr>
									<?php 
									$firstresult = $row["leavepayoutid"];
									}
										$result2 = $conn->query($query);
										$row2 = $result2->fetch_assoc();
										
									?>
								</tbody>
								<span class="temporary-container-input">
									<input type="hidden" id="hide" value="<?php echo $firstresult; ?>">
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
				<div class="col-lg-6">Payout Details</div>
				<div class="col-lg-6"><span class="fas fa-times modal-close"></span></div>
			</div>
			
			<div id="container" class="modal-content-container">
				<form name="myForm" accept-charset="utf-8" action="leavepayoutprocess.php" method="get">
					<div class="row">
						
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>Payout ID:</label>
							<div id="resultid">
								<input type="text" value="" placeholder="Leave Payout ID" name ="leaveid" id="add-leavepayout" class="modal-textarea" required="required">
							</div>

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
							
						</div>

						<!--<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

							<label>From Date:</label>
							<input type="date" id="add-fromdate" name ="FromDate" class="modal-textarea" required="required">

							<label>To Date:</label>
							<input type="date" id="add-todate" name ="EndDate" class="modal-textarea" required="required">

						</div>-->

						

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

	  	var so='';
		var locYear;
		var locfromdate;
		var loctodate;
		var locStatus;
  		$(document).ready(function(){
			$('#datatbl tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","red");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
				locYear = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
				//locfromdate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();
				//loctodate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(4)").text();
				locStatus = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();
				//stats = locStatus.toString();
				so = usernum.toString();
				document.getElementById("hide").value = so;
				//alert(document.getElementById("hide").value);
				//alert(locStatus);	
					  
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
		    //modal.style.display = "block";
		    $("#myModal").stop().fadeTo(500,1);
		    //$("#add-payrollperiod").prop('readonly', false);
		    //document.getElementById("add-payrollperiod").value = '';
		    document.getElementById("upbt").style.visibility = "hidden";
		    document.getElementById("addbt").style.visibility = "visible";
		    var action = "add";
		    $.ajax({
						type: 'GET',
						url: 'leavepayoutprocess.php',
						data:{action:action},
						//data:'bkno='+BNo+'&bkdesc='+BDesc+'&bktit='+BTit+'&bkqty='+BQ,
						beforeSend:function(){
						
							//$("#result").html('<img src="img/loading.gif" width="300" height="300">');
			
						},
						success: function(data){
							$('#resultid').html(data);
							$("#add-leavepayout").prop('readonly', true); 
				}
			});

		}
		UpdateBtn.onclick = function() {
			if(so != '') {
				if (locStatus != '1') {
				    //modal.style.display = "block";
				    $("#myModal").stop().fadeTo(500,1);
				    $("#add-leavepayout").prop('readonly', true);
				    
				    document.getElementById("add-leavepayout").value = so;
					document.getElementById("add-yrselection").value = locYear.toString();
					//document.getElementById("add-fromdate").value = locfromdate.toString();
					//document.getElementById("add-todate").value = loctodate.toString();

				    document.getElementById("addbt").style.visibility = "hidden";
				    document.getElementById("upbt").style.visibility = "visible";
				}
				else{
					alert("Leave Payout has already Posted.");
				}
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
		  //alert($('#add-fromdate').val());
		}

		//-----search-----//
		$( ".search" ).on( "keydown", function(event) {
		  if(event.which == 13){
			var search = document.getElementsByClassName('search');
			//var PayPer;
			var PayId;

			//var PayDate;
			//var PayYear;
			//var PayStatus;
			var action = "searchdata";
			var actionmode = "userform";
			var data=[];
			 for(i=0;i<search.length;i++){
				 data[i]=search[i].value;
				 search[i].value = "";
			 }
			 
			 PayId = data[0];
			 PayYear = data[1];
			 PayPer = data[2];
			 PayDate = data[3];
			 PayStatus = data[4];

			
			

			
			 $.ajax({
						type: 'GET',
						url: 'leavepayoutprocess.php',
						data:{action:action, actmode:actionmode, PayId:PayId, PayYear:PayYear, PayPer:PayPer, PayDate:PayDate, PayStatus:PayStatus},
						//data:'bkno='+BNo+'&bkdesc='+BDesc+'&bktit='+BTit+'&bkqty='+BQ,
						beforeSend:function(){
						
							$("#result").html('<img src="img/loading.gif" width="300" height="300">');
			
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
				document.getElementById("add-yrselection").value = '';
				//document.getElementById("add-payrollperiod").value = so;
				document.getElementById("add-fromdate").value = '';
				document.getElementById("add-todate").value = '';
			}
			else
			{
				document.getElementById("add-yrselection").value = '';
				//document.getElementById("add-payrollperiod").value = '';
				document.getElementById("add-fromdate").value = '';
				document.getElementById("add-todate").value = '';
			}
			
		}

		function Delete()
		{
	
			
			var action = "delete";
			var actionmode = "userform";
			if (locStatus != '1') {
				if(so != '') {
					if(confirm("Are you sure you want to remove this record?")) {
						$.ajax({	
								type: 'GET',
								url: 'leavepayoutprocess.php',
								//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
								data:{action:action, actmode:actionmode, leaveid:so, yrSelection:locYear, FromDate:locfromdate, EndDate:loctodate},
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
			else 
			{
				alert("Leave Payout has already Posted.");
			}	
		}

		function linedetails()
		{
			if(so != ''){
				var action = "leavepayout";
				$.ajax({
					type: 'GET',
					url: 'leavepayoutprocess.php',
					data:{action:action, leavepayoutid:so, locfromdate:locfromdate, loctodate:loctodate, locYear:locYear, locStatus:locStatus},
					success: function(data) {
						so='';
					    window.location.href='leavepayoutline.php';
				    }
				});
			}
			else {
				alert("Please Select Leave Payout.");
			}
		}

		function Posted()
		{
			
			var action = "poststatus";
			//alert(stats);
			if (locStatus != '1') {
				if(so != '') {
					if(confirm("Are you sure you want to post this transaction?")) {
						$.ajax({	
								type: 'GET',
								url: 'leavepayoutprocess.php',
								//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
								data:{action:action, SelectedVal:so},
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
					alert("Please Select a record you want to post.");
				}	
			}
			else 
			{
				alert("Leave Payout has already Posted.");
			}	
		
						
		}
		function Update(){
			alert(stats);
		}
		function Cancel()
		{
			
			window.location.href='menu.php?list='+ActiveMode;
			    
		}

		//code added by jonald 2020-07-06
		function GenerateReport(){
			//alert(so);
			if(so != ''){
				var action = "getuserlogin";
				var usr =  "<?php echo $user; ?>";
				//alert(usr);
				//document.write(usr);
				window.open('Reports/leavepayoutreport.php?id='+so+'&yr='+locYear+'&user='+usr, "_blank");
			}
			else {
				alert("Please Select Leave Payout.");
			}
		}
		//end of code

	</script>
<script type="text/javascript" src="js/custom.js"></script>
<!-- end [JAVASCRIPT] -->

</body>
</html>