<?php 
session_start();
session_regenerate_id();
include("dbconn.php");
$user = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];

$firstresult='';
if(isset($_SESSION['paynum']))
{
	$paynum = $_SESSION['paynum'];
	$paydate = $_SESSION['paydate'];
	$paytype = $_SESSION['paytype'];
	$period = $_SESSION['payper'];

}
else
{
	header('location: payrolltransaction.php');
}


?>

<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Payroll Transaction Worker Selection</title>

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
				<!-- TOGGLE POSITION 
				
				<div class="hidden-sm hidden-xs">
					<button id="changeposition-6-button" class=""><span class="fas fa-window-restore"></span> Change Position</button>
					<button id="changeposition-12-button" class="hide"><span class="fas fa-window-restore fa-rotate-270"></span> Change Position</button>
				</div>
			
			</li>
			<li><button onClick="Add();"><span class="fa fa-plus fa-lg"></span> Create Record</button></li>
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
									<tr class="rowtitle">
										<td style="width:20px;" class="text-center"><span class="fa fa-asterisk fa-xs"></span></td>
										<td style="width:4%;">INC</td>
										<td style="width:12%;">Contact</td>
										<td style="width:12%;">Worker</td>
										<td style="width:12%;">Rate</td>
										<td style="width:12%;">Ecola</td>
										<td style="width:12%;">Transportation</td>
										<td style="width:12%;">Meal</td>
										<td style="width:12%;">Type</td>
										<td style="width:12%;">Date</td>
										<td style="width: 17px;"><span class="fas fa-arrows-alt-v"></span></td>
									</tr>
									<tr class="rowsearch">
									  <td><span class="fas fa-search fa-xs"></span></td>
									  <td><center><input id="selectAll" type="checkbox"></span></center></td>
									  	<td style="width:14%;"><input style="width:100%;height: 20px;" list="SearchContract" class="search">
										<?php
											$query = "SELECT 
														wk.name,
														ct.contractid
														FROM contract ct
														left join worker wk on wk.workerid = ct.workerid
														and wk.dataareaid = ct.dataareaid

												where ct.dataareaid = '$dataareaid' 
														order by ct.contractid asc";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchContract">
										
										<?php 
											while ($row = $result->fetch_assoc()) {												
										?>
											<option value="<?php echo $row["contractid"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>

										<td style="width:14%;"><input style="width:100%;height: 20px;" list="SearchWorker" class="search">
										<?php
											$query = "SELECT 
														wk.name,
														wk.workerid
														FROM contract ct
														left join worker wk on wk.workerid = ct.workerid
														and wk.dataareaid = ct.dataareaid

												where ct.dataareaid = '$dataareaid' 
														order by wk.workerid asc";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchWorker">
										
										<?php 
											
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["name"];?>"><?php echo $row["workerid"];?></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td style="width:14%;"><select style="width:100%;height: 20px;" id="SPayment" list="SearchPayment" class="search" disabled>
										
											<option value=""></option>
											<option value="0">Cash</option>	
											<option value="1">ATM</option>			
										
									  </td>
									  <td style="width:14%;"><input style="width:100%;height: 20px;" list="SearchId" class="search" disabled>
										<?php
											$query = "SELECT distinct distinct ph.payrollid from payrollheader ph where ph.dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchId">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["payrollid"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td style="width:14%;"><input style="width:100%;height: 20px;" list="SearchPeriod" class="search" disabled>
										<?php
											$query = "SELECT distinct ph.payrollperiod from payrollheader ph where ph.dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchPeriod">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["payrollperiod"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td style="width:14%;"><input style="width:100%;height: 20px;" list="SearchFromDate" class="search" disabled>
										<?php
											$query = "SELECT distinct ph.fromdate from payrollheader ph where ph.dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchFromDate">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["fromdate"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td style="width:14%;"><input style="width:100%;height: 20px;" list="SearchToDate" class="search" disabled>
										<?php
											$query = "SELECT distinct ph.todate from payrollheader ph where ph.dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchToDate">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["todate"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td style="width:14%;"><input style="width:100%;height: 20px;" list="SearchStatus" class="search" disabled>
										<?php
											$query = "SELECT distinct case when payrollstatus = 0 then 'Created' 
														when payrollstatus = 1 then 'Submitted' 
														when payrollstatus = 2 then 'Canceled' 
														when payrollstatus = 3 then 'Approved' 
														when payrollstatus = 4 then 'Disapproved' 
													else '' end as 'status' from payrollheader ph where ph.dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchStatus">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["status"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><span></span></td>
									</tr>
								
								</thead>
								<tbody id="result">
										<?php	
										$PayPerquery = "SELECT 
															payrollgroup
															FROM payrollperiod where dataareaid = '$dataareaid' 
															and payrollperiod = '$period'";

															//and (module like '%$module%') and (submodule like '%$sub%') and (name like '%$name%')";
												$PayPerresult = $conn->query($PayPerquery);
												$PayPerrow = $PayPerresult->fetch_assoc();
												$payrollgroup=$PayPerrow["payrollgroup"];
												
										$query = "SELECT ct.contractid,
													wk.name,
													format(ct.rate,2) as rate
													,format(ct.ecola,2) as ecola,
													format(ct.transpo,2) transpo,
													format(ct.meal,2) as meal,
													case when ct.contracttype = 0 then 'Regular' 
														when ct.contracttype = 1 then 'Reliever'
														when ct.contracttype = 2 then 'Probationary'
														when ct.contracttype = 3 then 'Contractual' 
														when ct.contracttype = 4 then 'Trainee'
														when ct.contracttype = 5 then 'Project-Based' else '' end as workertype,

													ct.fromdate as transdate
													FROM contract ct
													left join worker wk on wk.workerid = ct.workerid
													and wk.dataareaid = ct.dataareaid
													left join ratehistory rh  on 
													rh.contractid = ct.contractid and rh.dataareaid = ct.dataareaid

												where ct.dataareaid = '$dataareaid' 
												and date_format(ct.fromdate, '%m-%m-%Y') <= date_format(str_to_date('$paydate','%m-%d-%Y'), '%Y-%m-%d')
												and ct.paymenttype = '$paytype' and wk.inactive = 0 and wk.payrollgroup = '$payrollgroup'
												and rh.status = 1
												order by ct.contractid asc
												";
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

												$accExist = $row['contractid'];

												$query2 = "SELECT * FROM payrolldetails where dataareaid = '$dataareaid' and payrollid = '$paynum'  and contractid = '$accExist'";
													$result2 = $conn->query($query2);
													$row2 = $result2->fetch_assoc();

													$dtexist = $row2["contractid"];
													//$dtexist = 'rdays';

													if(isset($dtexist)) { $tag=1;}
													else {$tag=0;}

												
											?>
											<tr class="<?php echo $rowclass; ?>" tabindex="<?php echo $rowcnt2; ?>">
												<!--<td style="width:10px;"><input type='checkbox' name="chkbox" value="" id="myCheck"></td>-->
												<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
												<td style="width:4%;"><input type='checkbox' id="chkbox" name="chkbox" class="checkbox" 
												value="<?php echo $row['contractid'];?>" <?php echo ($tag==1 ? 'checked' : '');?> <?php echo ($tag==1 ? 'disabled' : '');?> ></td>
												<td style="width:12%;"><?php echo $row['contractid'];?></td>
												<td style="width:12%;"><?php echo $row['name'];?></td>
												<td style="width:12%;"><?php echo $row['rate'];?></td>
												<td style="width:12%;"><?php echo $row['ecola'];?></td>
												<td style="width:12%;"><?php echo $row['transpo'];?></td>
												<td style="width:12%;"><?php echo $row['meal'];?></td>
												<td style="width:12%;"><?php echo $row['workertype'];?></td>
												<td style="width:12%;"><?php echo $row['transdate'];?></td>
												<!--<td style="width:50%;"><input type='password' value='" . $row["password"]."'readonly='readonly'></td>-->
												
											</tr>

										<?php 
										}
										/*$result2 = $conn->query($query);
											$row2 = $result2->fetch_assoc();
											$firstresult = $row2["payrollid"];*/
										?>
											
								</tbody>
								<span class="temporary-container-input">
									<input type="hidden" id="hide" value="<?php echo $firstresult;?>">
									<input type="hidden" id="hidefocus" value="<?php echo $rowcnt2;?>">	
									<input type="hidden" id="inchide">
									<input type="hidden" id="inchide2">
									<!--<textarea id="inchide2"></textarea>
									<textarea id="t2"></textarea>-->
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
	  	var flaglocation=true;
	  	var so='';
	  	var payline='';
	  	var locValue='';
	  	var locType='';
  		$(document).ready(function(){
			$('#datatbl tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","red");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
				so = usernum.toString();
				document.getElementById("hide").value = so;
				//alert(document.getElementById("hide").value);
				
			});
		});

	  		

		$(document).ready(function() {
			var pos = document.getElementById("hidefocus").value;
		    //$("tr[tabindex="+pos+"]").focus();
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
			var PTContract;

			var action = "searchdata";
			var actionmode = "userform";
			var data=[];
			 for(i=0;i<search.length;i++){
				 data[i]=search[i].value;
				 //search[i].value = "";
			 }
			 
			 PTContract = data[0];

			
			 $.ajax({
				type: 'GET',
				url: 'ptworkerprocess.php',
				data:{action:action, actmode:actionmode, PTContract:PTContract},
				//data:'bkno='+BNo+'&bkdesc='+BDesc+'&bktit='+BTit+'&bkqty='+BQ,
				beforeSend:function(){
				
					$("#result").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
	
				},
				success: function(data){
					$('#result').html(data);
					CheckedVal();
					$('#selectAll').prop('checked', false);
					
				}
			}); 
			 
		  }
		});
		//-----end search-----//
	
	var allVals = [];
	var uniqueNames = [];
	var remVals = [];
	var remValsEx = [];
	$('[name=chkbox]').change(function(){
	    if($(this).attr('checked'))
	    {
      		//document.getElementById("inchide").value = $(this).val();
      		Add();
	    }
	    else
	    {
			         
	         //document.getElementById("inchide").value=$(this).val();
	         remVals.push("'"+$(this).val()+"'");
	         $('#inchide2').val(remVals);

	         $.each(remVals, function(i, el2){
	         	//alert(el2);	
	    		removeA(allVals, el2);
	    		removeA(uniqueNames, el2);
		    	//$("input[value="+el+"]").prop("checked", true);
		    	//alert(el);
			});
	        Add();

	    }
	 });

	function removeA(arr) 
	{
	    var what, a = arguments, L = a.length, ax;
	    while (L > 1 && arr.length) {
	        what = a[--L];
	        while ((ax= arr.indexOf(what)) !== -1) {
	            arr.splice(ax, 1);
	        }
	    }
	    return arr;
	}

	$("#selectAll").change(function(){  //"select all" change 
   			 

   			 if(false == $(this).prop("checked")){ //if this item is unchecked
			        $('[name=chkbox]').prop('checked', false); //change "select all" checked status to false
			         allVals = [];
					 uniqueNames = [];
					 remVals = [];
					 remValsEx = [];
			        document.getElementById('inchide').value = '';
			        document.getElementById('inchide2').value = '';
			        //alert('sample');

			    }
			    else
			    {
			    	$(".checkbox").prop('checked', $(this).prop("checked")); //change all ".checkbox" checked status
			    	Add();
			    }

			});
	
	function Add() 
	{  

		
		$('#inchide').val('');
		 $('[name=chkbox]:checked').each(function() {
		   allVals.push("'"+$(this).val()+"'");

		   /*if( $("input[value="+$(this).val()+"]") == 'PCC')
		   {
		   		alert($(this).val());
		   }*/
		   
		 });

		 //remove existing rec start-----------------------
		 $('[name=chkbox]:disabled').each(function() {
		   
		   remValsEx.push("'"+$(this).val()+"'");
	         //$('#inchide2').val(remValsEx);

	         $.each(remValsEx, function(i, el2){
	         		
	    		removeA(allVals, el2);
	    		removeA(uniqueNames, el2);
		    	//"'"+"PCC"+"'"
			});
		   
		 });
		 //remove existing rec end-------------------------

		 

		 
			$.each(allVals, function(i, el){
			    if($.inArray(el, uniqueNames) === -1) uniqueNames.push(el);
			});
		
		 $('#inchide').val(uniqueNames);

	} 
	function CheckedVal()
	{ 
		$.each(uniqueNames, function(i, el){
			    $("input[value="+el+"]").prop("checked", true);
			    //alert(el);
			});
	}
	
	function Save()
	{

		var SelectedVal = $('#inchide').val();
		var action = "save";
		var actionmode = "userform";
		//alert(document.getElementById("add-include").value);
		$.ajax({	
				type: 'GET',
				url: 'ptworkerprocess.php',
				//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
				data:{action:action, SelectedVal:SelectedVal},
				beforeSend:function(){
						
				$("#result").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
					
				},
				success: function(data){
					window.location.href='payrolltransactiondetail.php';
				//$('#result').html(data);
				//location.reload();					
				}
		});
						
	}

	function Cancel()
	{

		window.location.href='payrolltransactiondetail.php';		   
	}


</script>
	<!-- begin [JAVASCRIPT] -->
	<script type="text/javascript" src="js/custom.js">
		


	</script>
	<!-- end [JAVASCRIPT] -->

	

</body>
</html>