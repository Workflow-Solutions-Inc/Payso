<?php 
session_start();
session_regenerate_id();
include("dbconn.php");
$user = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
$formula='';

if(isset($_SESSION['CalcMode']))
{
	
	if($_SESSION['CalcMode'] == 'CalcFormula')
	{
		$CalcAccId = $_SESSION["AccID"];
		$CalcAccLine = 'Accounts';
		$calctitle = 'Accounts Formula';
		
			$formulaquery = "SELECT 
						formula
						FROM accounts where dataareaid = '$dataareaid' 
						and accountcode = '$CalcAccId'";

						//and (module like '%$module%') and (submodule like '%$sub%') and (name like '%$name%')";
			$formularesult = $conn->query($formulaquery);
			$formularow = $formularesult->fetch_assoc();
			$formula=$formularow["formula"];
			
			
	}
	else if($_SESSION['CalcMode'] == 'CalcReference')
	{
		$CalcAccId = $_SESSION["AccID"];
		$CalcAccLine = $_SESSION['AccLine'];
		$calctitle = 'Reference Formula';
		
			$formulaquery = "SELECT 
						referenceformula
						FROM accountconditiondetail where dataareaid = '$dataareaid' 
						and accountconditioncode = '$CalcAccId' and linenum = '$CalcAccLine'";

						//and (module like '%$module%') and (submodule like '%$sub%') and (name like '%$name%')";
			$formularesult = $conn->query($formulaquery);
			$formularow = $formularesult->fetch_assoc();
			$formula=$formularow["referenceformula"];
			
			
	}
	else if($_SESSION['CalcMode'] == 'CalcCondition')
	{
		$CalcAccId = $_SESSION["AccID"];
		$CalcAccLine = $_SESSION['AccLine'];
		$calctitle = 'Condition Formula';
		
			$formulaquery = "SELECT 
						conditionformula
						FROM accountconditiondetail where dataareaid = '$dataareaid' 
						and accountconditioncode = '$CalcAccId' and linenum = '$CalcAccLine'";

						//and (module like '%$module%') and (submodule like '%$sub%') and (name like '%$name%')";
			$formularesult = $conn->query($formulaquery);
			$formularow = $formularesult->fetch_assoc();
			$formula=$formularow["conditionformula"];
			
			
	}
	else if($_SESSION['CalcMode'] == 'CalcResult')
	{
		$CalcAccId = $_SESSION["AccID"];
		$CalcAccLine = 'ConditionHeader';
		$calctitle = 'Result Formula';
		
			$formulaquery = "SELECT 
						resultformula
						FROM accountconditionheader where dataareaid = '$dataareaid' 
						and accountconditioncode = '$CalcAccId'";

						//and (module like '%$module%') and (submodule like '%$sub%') and (name like '%$name%')";
			$formularesult = $conn->query($formulaquery);
			$formularow = $formularesult->fetch_assoc();
			$formula=$formularow["resultformula"];
			
			
	}
	
}
else
{
	header('location: accountform.php');
}
?>

<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Account Formula</title>

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
			<li><button onClick="Delete();"><span class="fa fa-trash-alt"></span> Delete Record</button></li>
			<li><button id="myUpdateBtn"><span class="fa fa-edit"></span> Update Record</button></li>
			<li><button onClick="Cancel();"><span class="fa fa-arrow-circle-left fa-lg"></span> Back</button></li>
		</ul>
		
		<!-- extra buttons 
		<ul class="extrabuttons">
			<div class="leftpanel-title"><b>MOVE</b></div>
			<li><button onClick="MoveUp();"><span class="fas fa-arrow-up fa"></span> Move Up</button></li>
			<li><button onClick="MoveDown();"><span class="fas fa-arrow-down fa"></span> Move Down</button></li>
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
							<span class="fa fa-archive"></span> <?php echo $calctitle; ?>
						</div>
						<div class="mainpanel-sub">
							<!-- cmd -->
							<!--<div class="mainpanel-sub-cmd">
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
						<div id="calculator-container" class="calculator-container">
							<div class="calculator card">
								<input type="hidden" id="inchide">
								<input type="hidden" id="AccHideId" value="<?php echo $CalcAccId; ?>">
								<input type="hidden" id="AccHideLine" value="<?php echo $CalcAccLine; ?>">
								<input type="hidden" id="CalcMode" value="<?php echo $_SESSION['CalcMode']; ?>">
								
								<textarea class="calculator-screen z-depth-1" value="2.0"  id="calc-result" readonly><?php echo $formula; ?></textarea>
								
								<div class="calculator-keys">
									<button type="button" class="operator btn btn-info calc-confirmation2 calc-confirmation" value="" title="Clear" onclick='Clear();'>C</button>
									<button type="button" class="operator btn btn-info" id="[meal]" name="Meal" value="[meal]" title="Meal" onclick='accval(this.value);'>M</button>
									<button type="button" class="operator btn btn-info" id="[transpo]" name="Transpo" value="[transpo]" title="Transpo" onclick='accval(this.value);'>T</button>
									<button type="button" class="operator btn btn-info" value="" title="Save" onclick='Compute();'>OK</button>
								</div>

								<div class="calculator-keys">
									<button type="button" class="operator btn btn-info" id="[rate]" name="Rate" value="[rate]" title="Rate" onclick='accval(this.value);'>R</button>
									<!--<button type="button" class="operator btn btn-info" id="[ecola]" name="Ecola" value="[ecola]" title="Ecola" onclick='accval(this.value);'>E</button>-->
									<button type="button" class="operator btn btn-info" value="(" onclick='numval(this.value);'>(</button>
									<button type="button" class="operator btn btn-info" value=")" onclick='numval(this.value);'>)</button>
								</div>

								<div class="calculator-keys">
									<button type="button" class="operator btn btn-info" value=" + " onclick='numval(this.value);'>+</button>
									<button type="button" class="operator btn btn-info" value=" - " onclick='numval(this.value);'>-</button>
									<button type="button" class="operator btn btn-info" value=" / " onclick='numval(this.value);'>/</button>
									<button type="button" class="operator btn btn-info" value=" * " onclick='numval(this.value);'>&times;</button>

									<button type="button" value="7" class="btn btn-light waves-effect" onclick='numval(this.value);'>7</button>
									<button type="button" value="8" class="btn btn-light waves-effect" onclick='numval(this.value);'>8</button>
									<button type="button" value="9" class="btn btn-light waves-effect" onclick='numval(this.value);'>9</button>


									<button type="button" value="4" class="btn btn-light waves-effect" onclick='numval(this.value);'>4</button>
									<button type="button" value="5" class="btn btn-light waves-effect" onclick='numval(this.value);'>5</button>
									<button type="button" value="6" class="btn btn-light waves-effect" onclick='numval(this.value);'>6</button>


									<button type="button" value="1" class="btn btn-light waves-effect" onclick='numval(this.value);'>1</button>
									<button type="button" value="2" class="btn btn-light waves-effect" onclick='numval(this.value);'>2</button>
									<button type="button" value="3" class="btn btn-light waves-effect" onclick='numval(this.value);'>3</button>


									<button type="button" value="0" class="btn btn-light waves-effect" onclick='numval(this.value);'>0</button>
									<button type="button" id="btnperiod" class="decimal function btn btn-secondary" value="." onclick='numval(this.value);'>.</button>
									<button id="calc-ac" type="button" class="all-clear function btn btn-danger btn-sm" value="all-clear">Account</button>

									<button id="calc-test" type="button" class="equal-sign operator btn btn-warning" value="=">Test Here</button>
								</div>
							</div>
						</div>
						<!--right pannel-->
						<div id="container1" class="full widthsplit">
							<table width="100%" border="0" id="datatbl" class="table table-striped mainpanel-table">
								<thead>	
									<tr class="rowB rowtitle">
										<td style="width:20px;" class="text-center"><span class="fa fa-asterisk fa-xs"></span></td>
										<td style="width:25%;">Include</td>
										<td style="width:25%;">Account Code</td>
										<td style="width:25%;">Name</td>
										<td style="width:25%;">Name</td>
										<td style="width: 17px;" class="text-center"><span class="fas fa-arrows-alt-v"></span></td>
									</tr>
									<tr class="rowsearch">
									  <td class="text-center"><span class="fas fa-search fa-xs"></span></td>
										
									  <td><input list="SearchCode" class="search" disabled>
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
									  <td><input list="SearchName" class="search" disabled>
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
									  <td><input list="SearchUm" class="search" disabled>
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
														where dataareaid = '$dataareaid'
														order by priority asc";
									$result = $conn->query($query);
									$rowclass = "rowA";
									$rowcnt = 0;
									$rowcnt2 = 0;
									$lastrec ='';
									$collection = '';
									while ($row = $result->fetch_assoc())
									{ ?>
										<?php
											$rowcnt++;
											$rowcnt2++;
											if($rowcnt > 1) { $rowcnt = 0; $rowclass = "rowB"; }
											else { $rowclass = "rowA"; }
											$collection = $collection.','.$row['accountcode'];
										?>
										<tr id="<?php echo $row['accountcode'];?>" class="<?php echo $rowclass; ?>" tabindex="<?php echo $rowcnt2; ?>">
											<!--<td style="width:10px;"><input type='checkbox' name="chkbox" value="" id="myCheck"></td>-->
											<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
											<td style="width:25%;"><?php echo $row['accountcode'];?></td>
											<td style="width:25%;"><?php echo $row['name'];?></td>
											<td style="width:25%;"><?php echo $row['um'];?></td>
											<td style="width:25%;"><?php echo $row['accounttype'];?></td>
											
											<?php $lastrec = $row['priority'];?>
											<!--<td style="width:50%;"><input type='password' value='" . $row["password"]."'readonly='readonly'></td>-->
										</tr>
									<?php 
									$firstresult = $row["accountcode"];
									}
										$result2 = $conn->query($query);
										$row2 = $result2->fetch_assoc();
										
									?>
								</tbody>
								<span class="temporary-container-input">
									<input type="hidden" id="hide" value="<?php echo $firstresult; ?>">
									<input type="hidden" id="hide2" value="<?php echo $lastrec+1;?>">
									<input type="hidden" id="hidefocus" value="<?php echo $rowcnt2;?>">
									<div style="display:none;width:1%;"><textarea id="t2" value = "<?php echo substr($collection,1);?>"><?php echo substr($collection,1);?></textarea></div>
								</span>
							</table>
							<div class="button-ok">
								<button class="btn btn-danger btn-lg calc-confirmation">Cancel</button>
								<button class="btn btn-primary btn-lg calc-confirmation" onclick="AccInput();">Accept</button>
							</div>
						</div>
						<!--right pannel-->
						<!--right pannel 2-->
						<div id="container2" class="full widthsplit">
							<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<div class="dashboard-content">
									<div class="dashboard-title"><i class="far fa-user-circle"></i> Test Result</div>
									<h1><div id="finalresult">
										
									</div></h1>
									<hr>
									<div>
										
										<div id="inputresult">
										</div>
										<div class="button-ok">
											<button class="btn btn-danger btn-lg calc-confirmation2">Cancel</button>
											<button class="btn btn-primary btn-lg" onclick="CalcInput();">Test</button>
											<!--<button onclick="SampleAlert();">Alert</button>-->
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--right pannel 2-->

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

	  	var so='';
	  	var inc='';
	  	var HL='';
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
				//alert(usernum);
				//alert(locAccName);	
			});
		});
  		/* ------------------- Array-----------------*/
		var allVals = [];
		var uniqueNames = [];
	


		
		
		function Add(incval) 
		{  
			
			$('#inchide').val('');
			
			 //alert(incval);
			  //allVals.push("'"+incval+"'");
			  allVals.push(incval);
			 
				$.each(allVals, function(i, el){
				    if($.inArray(el, uniqueNames) === -1) uniqueNames.push(el);
				});
			
			 $('#inchide').val(uniqueNames);

		}



		/* ------------------- Array-----------------*/

		function numval(val)
		{
			
			curVal = document.getElementById('calc-result').value;
			if(val == ".")
			{
				/*if(curVal == "0.00" || curVal == '')
				{
					curVal = '';
				}*/
				document.getElementById('calc-result').value = curVal+val; 
				document.getElementById("btnperiod").disabled = true;
			}

			else if(val == " + " || val == " - " || val == " * " || val == " / ")
			{
				//alert(x);
				
				document.getElementById('calc-result').value = curVal+val;
				document.getElementById("btnperiod").disabled = false;  
			}
			else
			{
				//alert(x);
				
				document.getElementById('calc-result').value = curVal+val;  
			}
			
			
			
			
		}

		function accval(Aval)
		{
			
			curVal = document.getElementById('calc-result').value;

			var x = document.getElementById(Aval).name;
			/*alert(curVal);
			alert(x);*/
			
			var myPattern = new RegExp('(\\w*'+x+'\\w*)','gi');
			
			var matches = curVal.match(myPattern);

  			//var n = curVal.search(Aval);

  			//alert(Aval);
  			
				document.getElementById('calc-result').value = curVal+Aval;  
				
		        Add(x);

  			if (matches === null)
		    {
		        
				
				//Add();
					$("#inputresult").append("<p>"+
			              "<span class='label-lg'>"+x+": </span>"+
			              "<input type='text' id='"+x+"' class='textbox' style='margin-left: 25px;width: 200px;'>"+
						  "<br></p>");
		    }
			
		}

		function AccInput()
		{
			
			if(so != '')
			{
				curVal = document.getElementById('calc-result').value;
				//alert(so);
				//alert(locAccName);
				//alert(1);
				var myPattern = new RegExp('(\\w*'+so+'\\w*)','gi');
				
				var matches = curVal.match(myPattern);

	  			//var n = curVal.search(Aval);

	  			//alert(Aval);
	  			
					//document.getElementById('calc-result').value = curVal+"["+so.toLowerCase()+"]";
					document.getElementById('calc-result').value = curVal+"["+so+"]";  

					
			        Add(so);


	  			if (matches === null)
			    {
			        
					
					//Add();
						$("#inputresult").append("<p>"+
				              "<span class='label-lg'>"+locAccName+": </span>"+
				              "<input type='text' id='"+so+"' class='textbox' style='margin-left: 25px;width: 200px;'>"+
							  "<br></p>");
			    }
			}


		}


		function Clear()
		{
			document.getElementById('calc-result').value = "";
			$( "p" ).remove();
			allVals = [];
			 uniqueNames = [];
			 
	        document.getElementById('inchide').value = '';
	        document.getElementById("btnperiod").disabled = false;
			
		}

		function Compute()
		{
			CalcMode = document.getElementById('CalcMode').value;
			//document.getElementById('calc-result').value = "0.00";
			//curVal = document.getElementById('calc-result').value;
			//document.getElementById('calc-result').value = eval(curVal);
			//alert(eval(curVal));
			AccFormula = document.getElementById('calc-result').value;
			AccIdCode = document.getElementById('AccHideId').value;
			AccLineCode = document.getElementById('AccHideLine').value;
			if(CalcMode == 'CalcFormula')
			{
				var action = "UpdateFormula";
				$.ajax({
					type: 'GET',
					url: 'accountformprocess.php',
					data:{action:action, AccFormula:AccFormula, AccIdCode:AccIdCode},
					success: function(data) {
					    window.location.href='accountform.php';
				    }
				});
			}
			else if(CalcMode == 'CalcResult')
			{
				var action = "UpdateResult";
				$.ajax({
					type: 'GET',
					url: 'accountconditionprocess.php',
					data:{action:action, AccFormula:AccFormula, AccIdCode:AccIdCode},
					success: function(data) {
					    window.location.href='accountcondition.php';
				    }
				});
			}
			else if(CalcMode == 'CalcReference')
			{
				var action = "UpdateReference";
				$.ajax({
					type: 'GET',
					url: 'accountconditionprocess.php',
					data:{action:action, AccFormula:AccFormula, AccIdCode:AccIdCode, AccLineCode:AccLineCode},
					success: function(data) {
					    window.location.href='accountcondition.php';
				    }
				});
			}
			else if(CalcMode == 'CalcCondition')
			{
				var action = "UpdateCondition";
				$.ajax({
					type: 'GET',
					url: 'accountconditionprocess.php',
					data:{action:action, AccFormula:AccFormula, AccIdCode:AccIdCode, AccLineCode:AccLineCode},
					success: function(data) {
					    window.location.href='accountcondition.php';
				    }
				});
			}
			
			
		}

		function CalcInput()
		{
			
			//
			
			//var valuex = '';
			//var res = '';
			curVal = document.getElementById('calc-result').value;
			tempVal = curVal.toLowerCase();
			$.each(allVals, function(i, el){
				    //alert(el.toLowerCase());
				    //tempVal = document.getElementById('calc-result').value;
				    valuex = $("#inputresult").find("#"+el+"").val()
				    
				     res = tempVal.replace("["+el.toLowerCase()+"]", valuex);
				     
				     tempVal = res;
				     //alert(tempVal);
				     //alert(tempVal);
				     //document.getElementById('calc-result').value = res;
				});

			/*valuex = $("#inputresult").find("#Meal").val()
			res = curVal.replace("meal", valuex);*/
			

			//var res = curVal.replace("meal", valuex);
			//alert(valuex);
			//curVal2 = document.getElementById('calc-result').value;
			//alert(eval(tempVal));

			
			ans=eval(tempVal);
			$( "p" ).remove(".answer");
			$("#finalresult").append("<p class='answer'>"+
			              "<span class='label-lg'>"+ans+"</span>"+
						  "</p>");
		}


		

		
		
  		//-----search-----//
		$( ".search" ).on( "keydown", function(event) {
		  if(event.which == 13){
			var search = document.getElementsByClassName('search');
			var AccInc;
			var AccCode;
			var AccName;
			var AccLabel;
			var AccUm;
			var AccType;
			var AccCat;
			var AccFormula;
			var AccVal;

			var action = "searchdata";
			var actionmode = "userform";
			var data=[];
			 for(i=0;i<search.length;i++){
				 data[i]=search[i].value;
				 //search[i].value = "";
			 }
			 
			 //AccInc = data[0];
			 AccCode = data[1];
			 AccName = data[2];
			 AccLabel = data[3];
			 AccUm = data[4];
			 AccType = data[5];
			 AccCat = data[6];
			 //AccFormula = data[7];
			 //AccVal = data[8];

			
			 $.ajax({
						type: 'GET',
						url: 'accountformprocess.php',
						data:{action:action, actmode:actionmode, AccInc:AccInc, AccCode:AccCode, AccName:AccName, AccLabel:AccLabel, AccUm:AccUm, AccType:AccType, AccCat:AccCat, AccFormula:AccFormula, AccVal:AccVal},
						//data:'bkno='+BNo+'&bkdesc='+BDesc+'&bktit='+BTit+'&bkqty='+BQ,
						beforeSend:function(){
						
							$("#result").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
							//HL='';
							//so='';
							//document.getElementById("hide").value = '';
					
						},
						success: function(data){
							$('#result').html(data);
							var firstval = $('#hide3').val();
							document.getElementById("hide").value = firstval;
							so = document.getElementById("hide").value;
				            //$("#myUpdateBtn").prop("disabled", false);
				            //$('table tbody tr').removeClass("info");
				             //$('table tbody tr').css("color","black");
				             var pos = $("#"+so+"").attr("tabindex");
							    $("tr[tabindex="+pos+"]").focus();
							    $("tr[tabindex="+pos+"]").css("color","red");
							    $("tr[tabindex="+pos+"]").addClass("info");
							//document.getElementById("hide").value = '';
							//$("#"+HL+"").removeClass("info");
							//alert(so);
				}
			}); 
			 
		  }
		});
		//-----end search-----//

		function Cancel()
		{
			if(document.getElementById('AccHideLine').value == 'Accounts')
			{
				window.location.href='accountform.php';	
			}
			else
			{
				window.location.href='accountcondition.php';	
			}
				   
		}

		function MoveUp()
		{
			var action = "moveup";
			var actionmode = "userform";
			var AccPrio = $('#hide').val();
			//var AccIndex = '';
			//alert(AccPrio);
			if(AccPrio != '') {
				//if(confirm("Are you sure you want to update this record?")) {
					$.ajax({	
							type: 'GET',
							url: 'accountformprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action, actmode:actionmode, AccCode:AccPrio},
							beforeSend:function(){
									
							//$("#datatbl").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
								
							},
							success: function(data){
							$('#result').html(data);					
							}
					}); 
				/*}
				else 
				{
					return false;
				}*/
			}
			else 
			{
				alert("Please Select a record.");
			}	
		}

		function MoveDown()
		{
			var action = "movedown";
			var actionmode = "userform";
			var AccPrio = $('#hide').val();
			//alert(AccPrio);
			if(AccPrio != '') {
				//if(confirm("Are you sure you want to update this record?")) {
					$.ajax({	
							type: 'GET',
							url: 'accountformprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action, actmode:actionmode, AccCode:AccPrio},
							beforeSend:function(){
									
							//$("#datatbl").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
								
							},
							success: function(data){
							$('#result').html(data);
							//$('#conttables').html(data);
							//location.reload();					
							}
					}); 
				/*}
				else 
				{
					return false;
				}*/
			}
			else 
			{
				alert("Please Select a record.");
			}
		}

	</script>
<script type="text/javascript" src="js/custom.js"></script>
<script type="text/javascript">
	$('#calc-ac').click(function() {
		document.getElementById("container2").style.display = "none";
		document.getElementById("container1").style.display = "block";
		/*$('#calculator-container').addClass('visibleall');
		$('#container1').addClass('visibleall');*/
		$('#calculator-container').addClass('visibleall').not('visibleall');
		$('#container1').addClass('visibleall').not('visibleall');
		
	});
	$('#calc-test').click(function() {
		document.getElementById("container1").style.display = "none";
		document.getElementById("container2").style.display = "block";
		/*$('#calculator-container').addClass('visibleall');
		$('#container2').addClass('visibleall');*/
		$('#calculator-container').addClass('visibleall').not('visibleall');
		$('#container2').addClass('visibleall').not('visibleall');
		
	});

	$('.calc-confirmation').click(function() {
		$('#calculator-container').removeClass('visibleall').hasClass("visibleall");
		$('#container1').removeClass('visibleall').hasClass("visibleall");
	});

	$('.calc-confirmation2').click(function() {
		$('#calculator-container').removeClass('visibleall').hasClass("visibleall");
		$('#container2').removeClass('visibleall').hasClass("visibleall");
	});
</script>
<!-- end [JAVASCRIPT] -->

</body>
</html>