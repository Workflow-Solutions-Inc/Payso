<?php 
session_start();
session_regenerate_id();
include("dbconn.php");
$user = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];


$firstresult='';
if(isset($_SESSION['groupid']))
{
	$grpid = $_SESSION['groupid'];
}
else
{
	header('location: usergroupprivilegesform.php');
}


?>

<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Priviledge Selection</title>

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
							<?php
							$query2 = "SELECT * FROM usergroups where usergroupid = '$grpid'";
								$result2 = $conn->query($query2);
								$row2 = $result2->fetch_assoc();
								$grpname = $row2["name"];

							?>
							<span class="fa fa-archive"></span> Add Privileges for <?php echo $grpname;?> 
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
										<td style="width:5%;">Include</td>
										<td style="width:25%;">Privileges Id</td>
										<td style="width:25%;">Name</td>
										<td style="width:25%;">Module</td>
										<td style="width:25%;">Sub Module</td>
										<td style="width: 17px;" class="text-center"><span class="fas fa-arrows-alt-v"></span></td>
									</tr>
									<tr class="rowsearch">
									  <td class="text-center"><span class="fas fa-search fa-xs"></span></td>
									  

									  <td><center><span class="fa fa-check"></span></center></td>
									  <td><input list="SearchPrivilegesid" class="search">
										<?php
											$query = "SELECT distinct privilegesid FROM privileges";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchPrivilegesid">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["privilegesid"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									   <td><input list="SearchName" class="search">
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
									  <td><input list="SearchModule" class="search">
										<?php
											$query = "SELECT distinct module FROM privileges";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchModule">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["module"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchSubmodule" class="search">
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
									  <td><span></span></td>
									</tr>
								</thead>
								<tbody id="result">
									<?php					
									$query = "SELECT priv.privilegesid,priv.name,priv.module,priv.submodule FROM 

												 privileges priv

												order by priv.privilegesid,priv.module,priv.submodule";
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

											$dtarea = $row['privilegesid'];

											$query2 = "SELECT * FROM usergroupsprivileges where usergroupid = '$grpid' and privilegesid = '$dtarea'";
												$result2 = $conn->query($query2);
												$row2 = $result2->fetch_assoc();
												$dtexist = $row2["privilegesid"];

												if(isset($dtexist)) { $tag=1;}
												else {$tag=0;}
										?>
										<tr id="<?php echo $row['privilegesid'];?>" class="<?php echo $rowclass; ?>" tabindex="<?php echo $rowcnt2; ?>">
											<!--<td style="width:10px;"><input type='checkbox' name="chkbox" value="" id="myCheck"></td>-->
											<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
											<td style="width:5%;"><input type='checkbox' id="chkbox" name="chkbox" class="checkbox" 
												value="<?php echo $row['privilegesid'];?>" <?php echo ($tag==1 ? 'checked' : '');?> <?php echo ($tag==1 ? 'disabled' : '');?> ></td>
											<td style="width:25%;"><?php echo $row['privilegesid'];?></td>
											<td style="width:25%;"><?php echo $row['name'];?></td>
											<td style="width:25%;"><?php echo $row['module'];?></td>
											<td style="width:25%;"><?php echo $row['submodule'];?></td>
											
											<!--<td style="width:50%;"><input type='password' value='" . $row["password"]."'readonly='readonly'></td>-->
										</tr>
									<?php }?>
								</tbody>
								<span class="temporary-container-input">
									<input type="hidden" id="hide" value="<?php echo $firstresult;?>">
									<input type="hidden" id="hidefocus" value="<?php echo $rowcnt2;?>">	
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


<script src="js/ajax.js"></script>
	  	<script  type="text/javascript">
	  	var flaglocation=true;
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
				var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
				var AcInc = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
				locAccName = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();
				locAccUm = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(4)").text();
				locAccType = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(5)").text();

				so = usernum.toString();
				document.getElementById("hide").value = so;				  
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
			var PriveId;
			var PrivModule;
			var PrivSub;
			var PrivName;

			var action = "searchdata";
			var actionmode = "userform";
			var data=[];
			 for(i=0;i<search.length;i++){
				 data[i]=search[i].value;
				 //search[i].value = "";
			 }
			 
			 //AccInc = data[0];
			 PriveId = data[0];
			 PrivName = data[1];
			 PrivModule = data[2];
			 PrivSub = data[3];

			
			 $.ajax({
						type: 'GET',
						url: 'privselectionprocess.php',
						data:{action:action, actmode:actionmode, PriveId:PriveId, PrivModule:PrivModule, PrivSub:PrivSub, PrivName:PrivName},
						//data:'bkno='+BNo+'&bkdesc='+BDesc+'&bktit='+BTit+'&bkqty='+BQ,
						beforeSend:function(){
						
							$("#result").html('<center><img src="img/loading.gif" width="300" height="300"></center>');

						},
						success: function(data){
							$('#result').html(data);
							CheckedVal();

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
				url: 'privselectionprocess.php',
				//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
				data:{action:action, SelectedVal:SelectedVal},
				beforeSend:function(){
						
				$("#datatbl").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
					
				},
				success: function(data){
				window.location.href='usergroupprivilegesform.php';	
				//$('#datatbl').html(data);
				//location.reload();					
				}
		});
						
	}
	function Cancel()
	{

		window.location.href='usergroupprivilegesform.php';		   
	}


</script>
	<!-- begin [JAVASCRIPT] -->
	<script type="text/javascript" src="js/custom.js">
		


	</script>
	<!-- end [JAVASCRIPT] -->

	

</body>
</html>