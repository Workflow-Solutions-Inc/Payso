<?php 
session_start();
session_regenerate_id();
include("dbconn.php");
#$user = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
if(isset($_SESSION['UsrNum']))
{
	$usrid = $_SESSION['UsrNum'];
}
else
{
	header('location: userform.php');
}
?>

<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>User Group</title>

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
			<li class="UserGroupsMaintain" style="display: none;"><button onClick="Save();"><span class="fa fa-plus"></span> Set User group</button></li>
			<li><button onClick="Cancel();"><span class="fa fa-arrow-circle-left fa-lg"></span> Back</button></li>
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
							<span class="fa fa-archive"></span> User Groups
						</div>
						<div class="mainpanel-sub">
							
						</div>
						<!-- tableheader -->
						<div id="container1" class="full">
							<table width="100%" style="border: 1px solid #d9d9d9;" id="datatbl" class="table table-striped mainpanel-table">
								<thead>
									<tr class="rowtitle">
										<td style="width:20px;" class="text-center"><span class="fa fa-asterisk fa-xs"></span></td>
										<td style="width:5%;">Include</td>
										<td style="width:50%;">User Group id</td>
										<td style="width:50%;">Name</td>
										<td style="width: 17px;" class="text-center"><span class="fas fa-arrows-alt-v"></span></td>
									</tr>
									<tr class="rowsearch">
										<td class="text-center"><span class="fas fa-search fa-xs"></span></td>
										<td><center><span class="fa fa-check"></span></center></td>

										<td><input list="SearchUserGroupid" class="search">
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
									  <td><input style="width:100%;" list="SearchName" class="search">
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
									  <td><span></span></td>
									  
									</tr>
								</thead>
								
								<tbody id="result">
									<?php
									/*$collection = '';
									$groups = '';
									$checkquery = "SELECT * FROM usergroupsassignment where userid = '$usrid'";
									$checkresult = $conn->query($checkquery);
									while ($checkrow = $checkresult->fetch_assoc())
									{
										$collection = $collection.','."'".$checkrow['usergroupid']."'";
									}
									$groups = substr($collection,1);*/
									$query = "SELECT * FROM usergroups ";
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
											$ugroup = $row['usergroupid'];

											$query2 = "SELECT * FROM usergroupsassignment where usergroupid = '$ugroup' and userid = '$usrid'";
												$result2 = $conn->query($query2);
												$row2 = $result2->fetch_assoc();
												$ugexist = $row2["usergroupid"];

												if(isset($ugexist)) { $tag=1;}
												else {$tag=0;}
											
										?>
										<tr id="<?php echo $row['usergroupid'];?>" class="<?php echo $rowclass; ?>" tabindex="<?php echo $rowcnt2; ?>">
											<!--<td style="width:10px;"><input type='checkbox' name="chkbox" value="" id="myCheck"></td>-->
											<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
											<td style="width:5%;"><input type='checkbox' id="chkbox" name="chkbox" class="checkbox" 
												value="<?php echo $row['usergroupid'];?>" <?php echo ($tag==1 ? 'checked' : '');?> <?php echo ($tag==1 ? 'disabled' : '');?> ></td>
											<td style="width:50%;"><?php echo $row['usergroupid'];?></td>
											<td style="width:50%;"><?php echo $row['name'];?></td>
											
										</tr>
									<?php 

									}?>
								</tbody>
								<span class="temporary-container-input">
									<input type="hidden" id="hide" value="">
									<input type="hidden" id="hideuser" value="<?php echo $usrid; ?>">
									<input type="hidden" id="inchide">
									<input type="hidden" id="inchide2">
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



<!-- begin [JAVASCRIPT] -->
<script src="js/ajax.js"></script>
	 <script  type="text/javascript">

	  	var locname='';
	  	

	  	var usergrp = '';
		if(usergrp == '')
		{
			so = document.getElementById("hide").value;
		}
		$(document).ready(function(){
		$('#datatbl tbody tr').click(function(){
			$('table tbody tr').css("color","black");
			$(this).css("color","red");
			$('table tbody tr').removeClass("info");
			$(this).addClass("info");
			usergrp = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text().toString();
			locname = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
			
			document.getElementById("hide").value = usergrp;
			//alert(document.getElementById("hide").value);
			//alert(usergrp);
 	
						  
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
		    $("tr[tabindex="+pos+"]").focus();
		    $("tr[tabindex="+pos+"]").css("color","red");
		    $("tr[tabindex="+pos+"]").addClass("info");

		});

		

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
						url: 'usergroupselectionformprocess.php',
						data:{action:action, actmode:actionmode, userno:UId, name:NM},
						//data:'bkno='+BNo+'&bkdesc='+BDesc+'&bktit='+BTit+'&bkqty='+BQ,
						beforeSend:function(){
						
							$("#result").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
			
						},
						success: function(data){
							$('#result').html(data);
							CheckedVal();
							document.getElementById("hide").value = '';
							$(document).ready(function(){
							$('#datatbl tbody tr').click(function(){
								$('table tbody tr').css("color","black");
								$(this).css("color","red");
								$('table tbody tr').removeClass("info");
								$(this).addClass("info");
								usergrp = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text().toString();
								locname = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
								
								document.getElementById("hide").value = usergrp;
								//alert(document.getElementById("hide").value);
								//alert(usergrp);
					 	
											  
									});
								});
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
			
			
			
			var uname = document.getElementById("hideuser").value
			var SelectedVal = $('#inchide').val();
			if(SelectedVal != '')
			{
				var action = "saveUsergroup";
				var actionmode = "userform";
				$.ajax({	
						type: 'GET',
						url: 'usergroupselectionformprocess.php',
						data:{action:action, actmode:actionmode, usergrp:SelectedVal, uname:uname},
						beforeSend:function(){
								
						$("#datatbl").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
							
						},
						success: function(data){
						//$('#datatbl').html(data);
						//location.reload();	
						window.location.href='userform.php';				
						}
				}); 
			}
			else
			{
				alert("Please select user group");
			}
			
						
		}

		
	function Cancel()
	{

		window.location.href='userform.php';		   
	}
</script>
<script type="text/javascript" src="js/custom.js"></script>
	<!-- end [JAVASCRIPT] -->

</body>
</html>