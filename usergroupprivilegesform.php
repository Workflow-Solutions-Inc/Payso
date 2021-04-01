<?php 
session_start();
include("dbconn.php");
$user = $_SESSION["user"];

if(isset($_SESSION['groupid']))
{
	$grpid = $_SESSION['groupid'];
}
else
{
	header('location: usergroupform.php');
}
?>

<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Priviledges</title>

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
			<li><button onClick="AddPriv();"><span class="fa fa-plus"></span> Add Priviledges</button></li>
			<li><button onClick="Delete();"><span class="fa fa-trash-alt"></span> Remove Priviledges</button></li>
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
							$query2 = "SELECT * FROM usergroups where usergroupid = '$grpid'";
								$result2 = $conn->query($query2);
								$row2 = $result2->fetch_assoc();
								$grpname = $row2["name"];

							?>
							<span class="fa fa-archive"></span> List of Priviledges for <?php echo $grpname;?> 
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
										<td style="width:25%;">Privileges Id</td>
										<td style="width:25%;">Name</td>
										<td style="width:25%;">Module</td>
										<td style="width:25%;">Sub Module</td>
										<td style="width: 17px;" class="text-center"><span class="fas fa-arrows-alt-v"></span></td>
									</tr>
									<tr class="rowsearch">
									  <td class="text-center"><span class="fas fa-search fa-xs"></span></td>
									  

										<td><input list="SearchPrivilegesid" class="search">
										<?php
											$query = "SELECT distinct up.privilegesid FROM 

												usergroupsprivileges up
												left join privileges priv on priv.privilegesid = up.privilegesid

												where usergroupid = '$grpid'
												order by up.privilegesid";
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
											$query = "SELECT distinct priv.name FROM 

												usergroupsprivileges up
												left join privileges priv on priv.privilegesid = up.privilegesid

												where usergroupid = '$grpid'
												order by priv.name";
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
											$query = "SELECT distinct priv.module FROM 

												usergroupsprivileges up
												left join privileges priv on priv.privilegesid = up.privilegesid

												where usergroupid = '$grpid'
												order by priv.module";
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
											$query = "SELECT distinct priv.submodule FROM 

												usergroupsprivileges up
												left join privileges priv on priv.privilegesid = up.privilegesid

												where usergroupid = '$grpid'
												order by priv.submodule";
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
									$query = "SELECT up.privilegesid,priv.name,priv.module,priv.submodule FROM 

												usergroupsprivileges up
												left join privileges priv on priv.privilegesid = up.privilegesid

												where usergroupid = '$grpid'
												order by priv.module,priv.submodule,up.privilegesid";
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
											<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
											<td style="width:25%;"><?php echo $row['privilegesid'];?></td>
											<td style="width:25%;"><?php echo $row['name'];?></td>
											<td style="width:25%;"><?php echo $row['module'];?></td>
											<td style="width:25%;"><?php echo $row['submodule'];?></td>
											<!--<td style="width:50%;"><input type='password' value='" . $row["password"]."'readonly='readonly'></td>-->
											
										</tr>
									<?php }?>
								</tbody>
								<span class="temporary-container-input">
									<input type="hidden" id="hide">
									<input type="hidden" id="hideid" value="<?php echo $grpid;?>">
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

  	var so='';
  	var locPriveId;
	var locPrivModule;
	var locPrivSub;
	var locPrivName;
		$(document).ready(function(){
		$('#datatbl tbody tr').click(function(){
			$('table tbody tr').css("color","black");
			$(this).css("color","red");
			$('table tbody tr').removeClass("info");
			$(this).addClass("info");
			var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
			locPrivName = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
			locPrivModule = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();
			locPrivSub = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(4)").text();
			
			so = usernum.toString();
			document.getElementById("hide").value = so;
			//alert(document.getElementById("hide").value);
			//alert(so);	
				  
		});
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
		 
		 PriveId = data[0];
		 PrivName = data[1];
		 PrivModule = data[2];
		 PrivSub = data[3];
		 
		
		

		
		 $.ajax({
					type: 'GET',
					url: 'usergroupprivilegesformprocess.php',
					data:{action:action, actmode:actionmode, PriveId:PriveId, PrivModule:PrivModule, PrivSub:PrivSub, PrivName:PrivName},
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

	function Delete()
	{
		
		var action = "delete";
		var actionmode = "userform";
		if(so != '') {
			if(confirm("Are you sure you want to remove this record?")) {
				$.ajax({	
						type: 'GET',
						url: 'usergroupprivilegesformprocess.php',
						//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
						data:{action:action, actmode:actionmode, PriveId:so},
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

		window.location.href='usergroupform.php';		   
	}
	function AddPriv()
	{
		var action = "addpriv";
		var UserGroup = document.getElementById("hideid").value;
		$.ajax({
			type: 'GET',
			url: 'usergroupprivilegesformprocess.php',
			data:{action:action, UserGroup:so},
			success: function(data) {
			    window.location.href='privselection.php';
		    }
		});
	}
	</script>
<script type="text/javascript" src="js/custom.js"></script>
<!-- end [JAVASCRIPT] -->

</body>
</html>