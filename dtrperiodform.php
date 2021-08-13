<?php 
session_start();
include("dbconn.php");
$user = $_SESSION["user"];
//$dataareaid = $_SESSION["defaultdataareaid"];
//$refnum = $_SESSION['linenum'];

/*$firstresult='';*/
if(isset($_SESSION['PeriodAction']))
{
	$PeriodAction = $_SESSION['PeriodAction'];
	if($PeriodAction == 'LoadDtr')
	{
		$LabelAction = 'Load Daily Time Record';
	}
	else
	{
		$LabelAction = 'Import Daily Time Record';
	}
	
}
else
{
	//header('location: dtrform.php');
}


?>

<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Payroll Transaction Accounts Selection</title>

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
			<li><button onClick="Save();"><span class="fa fa-plus fa-lg"></span> Select Record</button></li>
			<li><button onClick="Cancel();"><span class="fa fa-edit fa-lg"></span> Cancel</button></li>
		</ul>
		
		<!-- extra buttons -->
		<ul class="extrabuttons">
			<!--<li><button><span class="fas fa-arrow-up fa"></span> Move Up</button></li>
			<li><button><span class="fas fa-arrow-down fa"></span> Move Down</button></li>-->
			<li>
				<!-- TOGGLE POSITION -->
				
				<!--<div class="hidden-sm hidden-xs">
					<button id="changeposition-6-button" class=""><span class="fas fa-window-restore"></span> Change Position</button>
					<button id="changeposition-12-button" class="hide"><span class="fas fa-window-restore fa-rotate-270"></span> Change Position</button>
				</div>-->
			
			</li>
			<!--<li><button onClick="Add();"><span class="fa fa-plus fa-lg"></span> Create Record</button></li>
			<li><button onClick="RemoveVal();"><span class="fa fa-plus fa-lg"></span> Sample</button></li>-->
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
							<span class="fa fa-archive"></span> <?php echo $LabelAction;?>
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
						</div>
						<!-- tableheader -->
						<div id="container1" class="full">
							<table width="100%" style="border: 1px solid #d9d9d9;" id="datatbl" class="table table-striped mainpanel-table">
								<thead>	
									<tr class="rowB rowtitle">
										<td style="width:20px;" class="text-center"><span class="fa fa-asterisk fa-xs"></span></td>
										<td style="width:16%;">Period</td>
										<td style="width:16%;">Payroll Period</td>
										<td style="width:16%;">From Date</td>
										<td style="width:16%;">To Date</td>
										<td style="width:16%;">Payroll Date</td>
										<td style="width:16%;">Payroll Group</td>
										<td style="width: 17px;" class="text-center"><span class="fas fa-arrows-alt-v"></span></td>
									</tr>
									<tr class="rowsearch">
									  <td class="text-center"><span class="fas fa-search fa-xs"></span></td>
									  

										<td><input list="SearchPeriod" class="search" disabled>
										<?php
											$query = "SELECT distinct case when period = 0 then 'First Half' else 'Second Half' end as period FROM payrollperiod 
											where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchPeriod">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["period"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchPayroll" class="search">
										<?php
											$query = "SELECT distinct payrollperiod FROM payrollperiod where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchPayroll">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["payrollperiod"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchStartDate" class="search">
										<?php
											$query = "SELECT distinct date_format(startdate, '%Y-%m-%d') startdate FROM payrollperiod where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchStartDate">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["startdate"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchEndDate" class="search">
										<?php
											$query = "SELECT distinct date_format(enddate, '%Y-%m-%d') enddate FROM payrollperiod where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchEndDate">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["enddate"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchPayrollDate" class="search">
										<?php
											$query = "SELECT distinct date_format(payrolldate, '%Y-%m-%d') payrolldate FROM payrollperiod where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchPayrollDate">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["payrolldate"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchGroup" class="search" disabled>
										<?php
											$query = "SELECT distinct case when payrollgroup = 0 then 'Weekly' else 'Semi-Monthly' end as payrollgroup FROM payrollperiod 
											where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchGroup">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["payrollgroup"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><span></span></td>
									</tr>
								</thead>
								<tbody id="result">
									<?php					
									$query = "SELECT case when period = 0 then 'First Half' 
													when period = 1 then 'Second Half'
													when period = 2 then 'First Week'
													when period = 3 then 'Second Week'
													when period = 4 then 'Third Week'
													when period = 5 then 'Fourth Week'

													else 'Last Week' end as period,
													payrollperiod,
													date_format(startdate, '%Y-%m-%d') startdate,
													date_format(enddate, '%Y-%m-%d') enddate,
													date_format(payrolldate, '%Y-%m-%d') payrolldate,
													case when payrollgroup = 0 
													then 'Weekly' 
													else 'Semi-Monthly' end as payrollgroup,
													payrollgroup as payrollgroupid
													FROM payrollperiod where dataareaid = '$dataareaid'
													order by payrollperiod";
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
										<tr id="<?php echo $row['payrollperiod'];?>" class="<?php echo $rowclass; ?>" tabindex="<?php echo $rowcnt2; ?>">
											<!--<td style="width:10px;"><input type='checkbox' name="chkbox" value="" id="myCheck"></td>-->
											<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
											<td style="width:16%;"><?php echo $row['period'];?></td>
											<td style="width:16%;"><?php echo $row['payrollperiod'];?></td>
											<td style="width:16%;"><?php echo $row['startdate'];?></td>
											<td style="width:16%;"><?php echo $row['enddate'];?></td>
											<td style="width:16%;"><?php echo $row['payrolldate'];?></td>
											<td style="width:16%;"><?php echo $row['payrollgroup'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['payrollgroupid'];?></td>
											<!--<td style="width:50%;"><input type='password' value='" . $row["password"]."'readonly='readonly'></td>-->
											
										</tr>
									<?php 
									$firstresult = $row["payrollperiod"];
									}
										$result2 = $conn->query($query);
										$row2 = $result2->fetch_assoc();
										
										$collection = '';
										$ptquery = "SELECT distinct payrollperiod FROM dailytimerecorddetail where dataareaid = '$dataareaid'";
										$ptresult = $conn->query($ptquery);
										
										
										while ($ptrow = $ptresult->fetch_assoc())
										{ 
											$collection = $collection.','.$ptrow['payrollperiod'];
										}
										
									?>
								</tbody>
								<span class="temporary-container-input">
									<input type="hidden" id="hide" value="<?php echo $firstresult;?>">
									<input type="hidden" id="hideAction" value="<?php echo $PeriodAction;?>">
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


<script src="js/ajax.js"></script>
	  	<script  type="text/javascript">

	  	var so='';
	  	var locPayPer;
		var locPayFromDate;
		var locPayEndDate;
		var locPayDate;
		var locPayGroup;
  		$(document).ready(function(){
			$('#datatbl tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","red");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
				locPayPer = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
				locPayFromDate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();
				locPayEndDate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(4)").text();
				locPayDate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(5)").text();
				locPayGroup = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(7)").text();
				so = usernum.toString();
				document.getElementById("hide").value = so;
				//alert(document.getElementById("hide").value);
				//alert(locPayGroup);	
					  
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
		  if(event.which == 13)
		  {
			var search = document.getElementsByClassName('search');
			var PayPer;
			var PayId;
			var PayFromDate;
			var PayEndDate;
			var PayDate;
			var action = "searchdata";
			var actionmode = "userform";
			var data=[];
			 for(i=0;i<search.length;i++)
			 {
				 data[i]=search[i].value;
				 //search[i].value = "";
			 }
			 
			 PayPer = data[0];
			 PayId = data[1];
			 PayFromDate = data[2];
			 PayEndDate = data[3];
			 PayDate = data[4];
			
			

			
			 $.ajax({
						type: 'GET',
						url: 'dtrperiodprocess.php',
						data:{action:action, actmode:actionmode, PayId:PayId, PayFromDate:PayFromDate, PayEndDate:PayEndDate, PayDate:PayDate},
						//data:'bkno='+BNo+'&bkdesc='+BDesc+'&bktit='+BTit+'&bkqty='+BQ,
						beforeSend:function(){
						
							$("#result").html('<img src="img/loading.gif" width="300" height="300">');
			
						},
						success: function(data){
							$('#result').html(data);
							var firstval = $('#hide3').val();
							document.getElementById("hide").value = firstval;
							so = document.getElementById("hide").value;
				            //$("#myUpdateBtn").prop("disabled", false);
				             var pos = $("#"+so+"").attr("tabindex");
							    $("tr[tabindex="+pos+"]").focus();
							    $("tr[tabindex="+pos+"]").css("color","red");
							    $("tr[tabindex="+pos+"]").addClass("info");
				}
			}); 
			 
		  }
		});
		//-----end search-----//
	
	var myId = [];
	function Save()
	{
		if(so != '')
		{
			if(document.getElementById("hideAction").value == 'LoadDtr')
			{
				var action = "save";
				var actionmode = "userform";
				//alert(document.getElementById("add-include").value);
				$.ajax({	
						type: 'GET',
						url: 'dtrperiodprocess.php',
						//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
						data:{action:action, SelectedVal:so},
						beforeSend:function()
						{
								
							$("#datatbl").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
							
						},
						success: function(data)
						{
							//window.location.href='payrolltransactiondetail.php';
							//$('#datatbl').html(data);
							//location.reload();
							window.location.href='dtrform.php';					
						}
				});
			}
			else
			{
				var cont = document.getElementById("t2").value;
				myId = cont.toLowerCase().split(",");
				var n = myId.includes(so.toLowerCase());
				//alert(n);
				if(n == true)
				{
					if(confirm("Are you sure you want to overwrite existing record?")) 
					{
						//alert("Payroll already Exist!");
						var action = "Import";
						var actionmode = "ALL";
						//alert(document.getElementById("add-include").value);
						$.ajax({	
								type: 'GET',
								url: 'dtrperiodprocess.php',
								//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
								data:{action:action, actionmode:actionmode, SelectedVal:so, locPayFromDate:locPayFromDate, locPayEndDate:locPayEndDate},
								beforeSend:function()
								{
										
									$("#datatbl").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
									
								},
								success: function(data)
								{
									//window.location.href='payrolltransactiondetail.php';
									//$('#datatbl').html(data);
									//location.reload();
									window.location.href='dtrform.php';					
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
					//alert("Import");
					
					//alert(so);
					//alert(locPayFromDate);
					//alert(locPayEndDate);
					var action = "Import";
					var actionmode = "RO";
					//alert(document.getElementById("add-include").value);
					$.ajax({	
							type: 'GET',
							url: 'dtrperiodprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action, actionmode:actionmode, SelectedVal:so, locPayFromDate:locPayFromDate, locPayEndDate:locPayEndDate},
							beforeSend:function(){
									
							$("#datatbl").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
								
							},
							success: function(data){
							//window.location.href='payrolltransactiondetail.php';
							//$('#datatbl').html(data);
							//location.reload();
							window.location.href='dtrform.php';					
							}
					});
					
				}

				
			}
		}
		else
		{
			alert("Please Select Payroll Period.");
		}
		
						
	}
	function Cancel()
	{

		//window.location.href='dtrform.php';
		var action = "unload";
			$.ajax({
				type: 'GET',
				url: 'dtrperiodprocess.php',
				data:{action:action, PayId:so},
				success: function(data) {
				    window.location.href='dtrform.php';
			    }
			});		   
	}


</script>
	<!-- begin [JAVASCRIPT] -->
	<script type="text/javascript" src="js/custom.js">
		


	</script>
	<!-- end [JAVASCRIPT] -->

	

</body>
</html>