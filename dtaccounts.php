<?php 
session_start();
session_regenerate_id();
include("dbconn.php");
$user = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
$refnum = $_SESSION['linenum'];

$firstresult='';
if(isset($_SESSION['recnum']))
{
	$recnum = $_SESSION['recnum'];
}
else
{
	header('location: deductionform.php');
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
			<li><button onClick="Save();"><span class="fa fa-plus fa-lg"></span> Add Record</button></li>
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
							<span class="fa fa-archive"></span> Overview
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
									<tr class="rowB rowtitle">
										<td style="width:20px;" class="text-center"><span class="fa fa-asterisk fa-xs"></span></td>
										<td style="width:23%;">Account Code</td>
										<td style="width:28%;">Name</td>
										<td style="width:20%;">UM</td>
										<td style="width:24%;">Account Type</td>
										<td style="width: 17px;" class="text-center"><span class="fas fa-arrows-alt-v"></span></td>
									</tr>
									<tr class="rowsearch">
									  <td class="text-center"><span class="fas fa-search fa-xs"></span></td>
									  
									  <td><input list="SearchCode" class="search">
										<?php
											$query = "SELECT distinct accountcode FROM accounts where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchCode">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["accountcode"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input style="width:100%;height: 20px;" list="SearchName" class="search">
										<?php
											$query = "SELECT distinct name FROM accounts where dataareaid = '$dataareaid'";
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
									  <td><input list="SearchUm" class="search">
										<?php
											$query = "SELECT distinct um FROM accounts where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchUm">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["um"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchType" class="search" disabled>
										<?php
											$query = "SELECT distinct case when accounttype = 0 then 'Entry'
														when accounttype = 1 then 'Computed'
														when accounttype = 2 then 'Condition'
														else 'Total'
														end as accounttype FROM accounts where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchType">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["accounttype"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><span></span></td>
									</tr>
								</thead>
								<tbody id="result">
									<?php					
									$query = "SELECT autoinclude,
														accountcode,
														name,
														label,
														um,
														case when accounttype = 0 then 'Entry'
															when accounttype = 1 then 'Computed'
															when accounttype = 2 then 'Condition'
														else 'Total'
														end as accounttype,
														case when category = 0 then 'Lines'
														else 'Header' 
														end as category,
														formula,
														format(defaultvalue,2) defaultvalue,
														priority
														FROM accounts
														where dataareaid = '$dataareaid' and category = 0
														order by priority asc";
									$result = $conn->query($query);
									$rowclass = "rowA";
									$rowcnt = 0;
									$rowcnt2 = 0;
									$lastrec ='';
									while ($row = $result->fetch_assoc())
									{ ?>
										<?php
											$rowcnt++;
											$rowcnt2++;
											if($rowcnt > 1) { $rowcnt = 0; $rowclass = "rowB"; }
											else { $rowclass = "rowA"; }

											
										?>
										<tr id="<?php echo $row['accountcode'];?>" class="<?php echo $rowclass; ?>" tabindex="<?php echo $rowcnt2; ?>">
											<!--<td style="width:10px;"><input type='checkbox' name="chkbox" value="" id="myCheck"></td>-->
											<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
											
											<td style="width:23%;"><?php echo $row['accountcode'];?></td>
											<td style="width:28%;"><?php echo $row['name'];?></td>
											<td style="width:20%;"><?php echo $row['um'];?></td>
											<td style="width:24%;"><?php echo $row['accounttype'];?></td>
											
											<!--<td style="width:50%;"><input type='password' value='" . $row["password"]."'readonly='readonly'></td>-->
										</tr>
									<?php }?>
								</tbody>
								<span class="temporary-container-input">
									<input type="hidden" id="hide" value="<?php echo $firstresult;?>">
									<input type="hidden" id="hidefocus" value="<?php echo $recnum;?>">	
									

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
		var locAccName;
		var locAccUm;
		var locAccType;

  		$(document).ready(function(){
			$('#datatbl tbody tr').click(function(){
				//$('table tbody tr').css('background-color','');
				//$(this).css('background-color','#ffe6cb');
				$('table tbody tr').css("color","black");
				$(this).css("color","red");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
				locAccName = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
				locAccUm = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();
				locAccType = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(4)").text();

				
				so = usernum.toString();
				document.getElementById("hide").value = so;				  
			});
		});

		//-----search-----//
		$( ".search" ).on( "keydown", function(event) {
		  if(event.which == 13){
			var search = document.getElementsByClassName('search');
			var AccInc;
			var AccCode;
			var AccName;
			var AccUm;
			var AccType;

			var action = "searchdata";
			var actionmode = "userform";
			var data=[];
			 for(i=0;i<search.length;i++){
				 data[i]=search[i].value;
				 //search[i].value = "";
			 }
			 
			 //AccInc = data[0];
			 AccCode = data[0];
			 AccName = data[1];
			 AccUm = data[2];
			 AccType = data[3];

			
			 $.ajax({
						type: 'GET',
						url: 'dtaccountsprocess.php',
						data:{action:action, actmode:actionmode, AccCode:AccCode, AccName:AccName, AccUm:AccUm, AccType:AccType},
						//data:'bkno='+BNo+'&bkdesc='+BDesc+'&bktit='+BTit+'&bkqty='+BQ,
						beforeSend:function(){
						
							$("#result").html('<center><img src="img/loading.gif" width="300" height="300"></center>');

						},
						success: function(data){
							$('#result').html(data);
							CheckedVal();
							//document.getElementById("hide").value = '';
							//$("#"+HL+"").removeClass("info");
							//alert(so);
				}
			}); 
			 
		  }
		});
		//-----end search-----//
	
	
	function Save()
	{

		
		var action = "save";
		var actionmode = "userform";
		//alert(document.getElementById("add-include").value);
		$.ajax({	
				type: 'GET',
				url: 'dtaccountsprocess.php',
				//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
				data:{action:action, SelectedVal:so},
				beforeSend:function(){
						
				$("#datatbl").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
					
				},
				success: function(data){
				//window.location.href='payrolltransactiondetail.php';
				//$('#datatbl').html(data);
				//location.reload();
				window.location.href='deductionform.php';					
				}
		});
						
	}
	function Cancel()
	{

		window.location.href='deductionform.php';		   
	}


</script>
	<!-- begin [JAVASCRIPT] -->
	<script type="text/javascript" src="js/custom.js">
		


	</script>
	<!-- end [JAVASCRIPT] -->

	

</body>
</html>