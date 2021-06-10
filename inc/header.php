<?php 

include("dbconn.php");

if(!isset($_SESSION['user']) || !isset($_SESSION['defaultdataareaid']))
{
	header('location: index.php');
}
else
{
	$user = $_SESSION["user"];
	$dataareaid = $_SESSION["defaultdataareaid"];
	$userpasshd = $_SESSION['userpass'];
}

/*else
{
	header('location: userform.php');
}*/
?>


	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="css/fontawesome.min.css" />
	<link rel="stylesheet" type="text/css" href="css/typography.css" />
	<link rel="stylesheet" type="text/css" href="css/custom.css" />
	<link rel="stylesheet" type="text/css" href="css/form.css" />
	<link rel="stylesheet" type="text/css" href="css/modal.css" />
	<link rel="stylesheet" type="text/css" href="css/bootstrap-timepicker.min.css" />
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/bootstrap-timepicker.min.js"></script>
</head>
<body oncontextmenu="return false">


<style type="text/css" media="screen">
	.dropdown:hover>.dropdown-menu { display: block !important; }
</style>
<!-- begin HEADER -->
<div class="header">
	<div class="header-content">

		<!--
		<div class="mobile-header-nav visible-xs">
			<button id="mobile-show-nav" class="fas fa-bars btn-primary"></button>
		</div>
		-->

		<div class="header-nav">
			<ul>
				<li id="pr" class="Human Resource" onClick="reply_click(this.id)"><a href="menu.php?list=pr"><span class="fas fa-money-bill-wave"></span> Payroll</a></li>
				<li id="hr" onClick="reply_click(this.id)"><a href="menu.php?list=hr"><span class="fas fa-users"></span> Human Resource</a></li>
				<li id="sa" onClick="reply_click(this.id)"><a href="menu.php?list=sa"><span class="fas fa-user-cog"></span> System Administration</a></li>
			</ul>
		</div>

		<div class="header-signout hidden-xs hidden-sm">
			<a href="loginprocess.php?out"><span class="fas fa-sign-out-alt"></span></a>
		</div>

		
		
		<div class="header-admin">
			<div class="dropdown">
				<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
					<span class="far fa-user fa-lg"></span>
					<span class="fas fa-angle-down"></span>
				</button>
				<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
					<div><?php echo $user;?></div>
					<div><?php echo $currentDateTime;?></div>
					<hr>
					<ul>
						<li class="ChangeCompany" style="display: none;"><div><a id="modaltableBtnHead"><span class="fas fa-cog"></span> Change Company</a></div></li>
						<li><div><a id="modalChangePassBtn"><span class="fas fa-key"></span> Change Password</a></div></li>
						<li><div><a href="loginprocess.php?out"><span class="fas fa-sign-out-alt"></span> Sign Out</a></div></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="header-about hidden-xs hidden-sm">
			<!-- <a href="#"><span class="fas fa-question-circle"></span></a> -->
			<div class="dropdown">
				<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="About us">
					<span class="far fa-question-circle"></span>
					<span class="fas fa-angle-down"></span>
				</button>
				<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
					
					<h3>About Us</h3>
					<p>
							&nbsp;	Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo 
							consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
							Irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt.

							Velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa.

							Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.
					</p>
					<hr>
					Visit Us On:
					<ul>
						
						<li hidden><div><a id="modalAboutUsBtn"><span class="fas fa-info"></span> About Us</a></div></li>
						<li><div><a href="https://payso.com.ph/" target="_blank"><span class="fas fa-globe"></span> https://payso.com.ph/ </a></div></li>
					</ul>
					Payso Version 3.15
				</div>
			</div>
		</div>
		<div class="header-details">
			<?php
				$querycomp = "SELECT *
                                
                                FROM dataarea 
                                
                              
                                where dataareaid = '$dataareaid'";
					$resultcomp = $conn->query($querycomp);
					$rowcomp = $resultcomp->fetch_assoc();
					$compname = $rowcomp["name"];

			?>
			<div>Company:</div>
			<div><b><?php echo $compname;?></b></div>
		</div>
		<div class="header-details">
			<?php
				$queryuname = "SELECT distinct uf.name,ug.name as ugassigned,uf.userid,uga.usergroupid
                                
                                FROM userfile uf
                                
                                left join usergroupsassignment uga on uga.userid = uf.userid

                                left join usergroups ug on ug.usergroupid = uga.usergroupid
                                
                                where uf.userid = '$user'";
					$resultunme = $conn->query($queryuname);
					$rowuname = $resultunme->fetch_assoc();
					$uname = $rowuname["name"];
					$usergrouppriv = $rowuname["usergroupid"];
					$ugassigned = $rowuname["ugassigned"];

			?>
			<div><?php echo $uname;?></div>
			<div><b><?php echo $ugassigned;?></b></div>
			<?php
				$VarAccessLevel = '';
				$Accessquery = "SELECT distinct pri.privilegesid


								from usergroupsassignment uga 

								left join usergroupsprivileges ugp on ugp.usergroupid = uga.usergroupid
								left join privileges pri on pri.privilegesid = ugp.privilegesid
								where uga.userid = '$user' #and uga.usergroupid = '$usergrouppriv' and ugp.privilegesid not in ('','')
								";
				$Accessresult = $conn->query($Accessquery);
				while ($Accessrow = $Accessresult->fetch_assoc())
				{
					//$Accessrow = $Accessresult->fetch_assoc();
					//$VarAccessLevel = $Accessrow["privilegesid"];
					$VarAccessLevel = $VarAccessLevel.','.$Accessrow['privilegesid'];
				}
				/*$Accessquery = "SELECT distinct privilegesid from privileges where privilegesid not in 
									(select ugp.privilegesid

									from usergroupsassignment uga 

									left join usergroupsprivileges ugp on ugp.usergroupid = uga.usergroupid
									left join privileges pri on pri.privilegesid = ugp.privilegesid
									where uga.userid = 'admin' and uga.usergroupid = 'SysAd' and ugp.privilegesid != 'BranchMaintain')";
				$Accessresult = $conn->query($Accessquery);
				while ($Accessrow = $Accessresult->fetch_assoc())
				{
					//$Accessrow = $Accessresult->fetch_assoc();
					//$VarAccessLevel = $Accessrow["privilegesid"];
					$VarAccessLevel = $VarAccessLevel.','.$Accessrow['privilegesid'];
				}*/
			?>
			<div style="display:none;"><textarea id="accesslevel"><?php echo substr($VarAccessLevel,1);?></textarea></div>
			<div style="display:none;"><input type="hidden" id="hidepasshd" value="<?php echo $userpasshd;?>"></textarea></div>
		</div>
	</div>
</div>
<!-- end HEADER -->



<div class="spacer">&nbsp;</div>

<!-- begin modal table 1 -->
	<div id="myModalHead" class="modal">
		<!-- Modal content -->
		<div class="modal-container modal-continer-table">
			<div class="modal-content">
				<div class="modal-header">
					<div class="col-lg-6">Change Company</div>
					<div class="col-lg-6"><span class="fas fa-times modal-close-2"></span></div>
				</div>
				
				<div id="container" class="modal-content-container">
					<!-- begin MAINPANEL -->
					<div class="row">
						<!-- begin MAINPANEL -->
						<div id="mainpanel" class="mainpanel" style="padding: 0px 0px !important;">
							<div class="container-fluid" style="padding: 0px 15px !important; margin-top: 5px !important; background-color: #FBFBFB;">
								<div class="row">

									<!-- start TABLE AREA -->
									<div id="tablearea2" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mainpanel-area" style="padding: 0px !important;">
										<div class="mainpanel-content" style="padding: 0px 15px !important; margin-top: 5px !important; background-color: #FBFBFB;">
											<!-- title & search -->
											<div class="mainpanel-title">
												<span class="fa fa-archive"></span> 
												List Of Company
											</div>
											

											<!-- table -->
											<div id="containerHead" class="half">
												<table width="100%" style="border: 1px solid #d9d9d9;" id="dataMenu" class="table table-striped mainpanel-table">
													<thead>
														<tr class="rowtitle">
															<td style="width:20px;" class="text-center"><span class="fa fa-asterisk fa-xs"></span></td>
															<td style="width:50%;">Dataarea Id</td>
															<td style="width:50%;">Name</td>
															<td style="width: 17px;" class="text-center"><span class="fas fa-arrows-alt-v"></span></td>	
														</tr>
													
													</thead>

													<tbody id="Menulineresult">
															<?php
															
															$queryCC = "SELECT UD.userid,UD.dataareaid,DA.name
																		FROM userfiledataarea UD
																		left join dataarea DA on DA.dataareaid = UD.dataareaid
																		where userid = '$user'";
															$CCresult = $conn->query($queryCC);
															$rowclass = "rowA";
															$rowcnt = 0;
															while ($CCrow = $CCresult->fetch_assoc())
															{ 
																$rowcnt++;
																	if($rowcnt > 1) { $rowcnt = 0; $rowclass = "rowB"; }
																	else { $rowclass = "rowA";}
																?>
																<tr class="<?php echo $rowclass; ?>">
																	<!--<td style="width:10px;"><input type='checkbox' name="chkbox" value="" id="myCheck"></td>-->
																	<td style="width:20px;"><span class="fa fa-angle-right"></span></td>
																	<td style="width:50%;"><?php echo $CCrow['dataareaid'];?></td>
																	<td style="width:50%;"><?php echo $CCrow['name'];?></td>
																	<!--<td style="width:50%;"><input type='password' value='" . $row["password"]."'readonly='readonly'></td>-->
																	
																</tr>

															<?php }?>
													</tbody>
													<input type="hidden" id="hideCC">	
												</table>
											</div>
										</div>
									</div>
									<!-- end TABLE AREA -->
								</div>
							</div>
						</div>
						<!-- end MAINPANEL -->
						
					</div>
					
					<!-- end MAINPANEL -->
				</div>
				<br>
				
				<div class="text-center" class="button-container">
					<!--<input type="reset" class="btn btn-danger" value="Reset">
					<input type="button" class="btn btn-primary" value="Save Changes">-->
					<button onClick="ChangeCom();" type="button"  value="ok" class="btn btn-primary">OK</button>
					
					<button onClick="CloseModal();" type="button" value="cancel" class="btn btn-danger">Cancel</button>
				</div>

			</div>
		</div>
	</div>
	<!-- end modal table 1-->

<!-- The Modal -->
<div id="ChangePassModal" class="modal">
	<!-- Modal content -->
	<div class="modal-container">
		<div class="modal-content">
			<div class="modal-header">
				<div class="col-lg-6">Change Password</div>
				<div class="col-lg-6"><span class="fas fa-times modal-close-l"></span></div>
			</div>
			
			<div id="container" class="modal-content-container">
				<form name="myForm2" accept-charset="utf-8" action="changepass.php" method="get">
					<div class="row">

						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<label>Old Password:</label>
							<input type="text" value="" placeholder="Old Password" name ="oldpass" id="add-oldpass" class="modal-textarea" required="required">
							
							<label>New Password:</label>
							<input type="text" value="" placeholder="New Password" id="add-newpass" name="newpass" class="modal-textarea" minlength="2" required="required">

							<label>Re-Type New Password:</label>
							<input type="text" value="" placeholder="Re-Type New Password" id="add-renewpass" name="renewpass" class="modal-textarea" minlength="2" required="required">
						</div>


					</div>

					<div class="button-container">
						<!--<button id="csaddbt" name="save" value="save" class="btn btn-primary btn-action" onclick="return checkExistForm()">Save</button>-->
						<button id="csupbt" name="changepass" value="changepass" class="btn btn-success btn-action" onclick="return validateForm1()">Change</button>
						<button onClick="ClearPass();" type="button" value="Reset" class="btn btn-danger">Clear</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- end modal-->

<!-- The Modal -->
<div id="AboutModal" class="modal">
	<!-- Modal content -->
	<div class="modal-container">
		<div class="modal-content">
			<div class="modal-header">
				<div class="col-lg-6">About Us</div>
				<div class="col-lg-6"><span class="fas fa-times modal-close-m"></span></div>
			</div>
			
			<div id="container" class="modal-content-container">

				<h1> Payso </h1>
				<b>World's most popular and advanced on set, online payroll solution.</b>
				
			</div>
		</div>
	</div>
</div>
<!-- end modal-->



<script  type="text/javascript">

var locMenuDataarea='';
  		var locMenuDTName='';
		$(document).ready(function(){
			$('#dataMenu tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","orange");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				var menuDataArea = $("#dataMenu tr:eq("+ ($(this).index()+1) +") td:eq(1)").text();
				locMenuDTName = $("#dataMenu tr:eq("+ ($(this).index()+1) +") td:eq(2)").text();
				locMenuDataarea = menuDataArea.toString();
				document.getElementById("hideCC").value = locMenuDataarea;
				//alert(document.getElementById("hide").value);
					  
			});
		});

	 	// modal table 1
		var modalHead = document.getElementById('myModalHead');
		// Get the button that opens the modal
		var openBtnHead = document.getElementById("modaltableBtnHead");
		
		// Get the <span> element that closes the modal
		var spanHead = document.getElementsByClassName("modal-close-2")[0];
		// When the user clicks the button, open the modal 
		openBtnHead.onclick = function() {
		    $("#myModalHead").stop().fadeTo(500,1);
		    
		}

		
		// When the user clicks on <span> (x), close the modal
		spanHead.onclick = function() {
		    modalHead.style.display = "none";
		    
		}
		function CloseModal()
		{
			modalHead.style.display = "none";
		}

		function ChangeCom()
		{
			
			if(locMenuDataarea != ''){
				
				var action = "ChangeCompany";
				$.ajax({
					type: 'GET',
					url: 'loginprocess.php',
					data:{action:action, locMenuDataarea:locMenuDataarea},
					success: function(data) {
					    //window.location.href='index.php';
					    location.reload();
				    }
				});
			}
			else {
				alert("Please Select Company.");
			}
			
		}
		//end modal --------------------------- 

		// modal Change pass
		var modalChange = document.getElementById('ChangePassModal');
		// Get the button that opens the modal
		var openBtnCP = document.getElementById("modalChangePassBtn");
		
		// Get the <span> element that closes the modal
		var spanCP = document.getElementsByClassName("modal-close-l")[0];
		// When the user clicks the button, open the modal 
		openBtnCP.onclick = function() {
		    $("#ChangePassModal").stop().fadeTo(500,1);
		    
		}

		
		// When the user clicks on <span> (x), close the modal
		spanCP.onclick = function() {
		    modalChange.style.display = "none";
		    
		}
		
		//end modal --------------------------- 

		// modal about us
		var modalAbout = document.getElementById('AboutModal');
		// Get the button that opens the modal
		var openBtnAU = document.getElementById("modalAboutUsBtn");
		
		// Get the <span> element that closes the modal
		var spanAU = document.getElementsByClassName("modal-close-m")[0];
		// When the user clicks the button, open the modal 
		openBtnAU.onclick = function() {
		    $("#AboutModal").stop().fadeTo(500,1);
		    
		}

		
		// When the user clicks on <span> (x), close the modal
		spanAU.onclick = function() {
		    modalAbout.style.display = "none";
		    
		}
		
		//end modal --------------------------- 


		function validateForm1() {
		  var x = document.forms["myForm2"]["changepass"].value;
		  var locOldPass = $('#add-oldpass').val();
		  var locNewPass = $('#add-newpass').val();
		  var locReNewPass = $('#add-renewpass').val();
		  var syspass = $('#hidepasshd').val();
		  //alert($userpassx);
		  if (x == "changepass") {
		  	if(confirm("Are you sure you want to change this password?")) {
		    	if(syspass == locOldPass){

		    		if(locNewPass == locReNewPass){
		    			return true;
		    		}
		    		else 
		    		{
		    			alert("Password Dont Match!");
		    			ClearPass();
		    			return false;
		    		}
		    		
		    	}
		    	else
		    	{
		    		alert("You Must Enter the Correct Old Password");
		    		ClearPass();
		    		return false;
		    	}
		   
		    	
		    }
		    else
		    {
		    	//modal.style.display = "none";
		    	ClearPass();
		    	return false;
		    }
		  }
		}

	function ClearPass()
	{
		document.getElementById("add-oldpass").value = '';
		document.getElementById("add-newpass").value = '';
		document.getElementById("add-renewpass").value = '';
	}


document.onkeydown = function(e) {
   if (e.ctrlKey && 
        (//e.keyCode === 67 || //C
         //e.keyCode === 86 || //v
         e.keyCode === 85 || //u
         e.keyCode === 117)) {
        return false;
    } 
    else {
        return true;
    }
};
$(document).keypress("u",function(e) {
	if(e.ctrlKey)
	{
		return false;
	}
	else
	{
		return true;
	}
});

var allAccess = [];
$(document).ready(function(){
	//$("#UserGroups").css("display", "block");
	//$(".OrganizationalChartView").css("display", "None");
	//$("li").css("display", "None");
	
	
});
$(document).ready(function(){
	//$("#UserGroups").css("display", "block");
	//$(".OrganizationalChartView").css("display", "None");
	
	var acclvl = document.getElementById("accesslevel").value;
	if(acclvl != '')
	{
	    var acclvlVal = acclvl.split(",");

		 $.each(acclvlVal,function (key,value) {
	            
	            allAccess.push(value);
	      });
		//allAccess.push(document.getElementById("accesslevel").value);

		$.each(allAccess, function(acs, al){
	     	//alert(al);
	     	$("li."+al+"").css("display", "block");
	     	$("ul."+al+"").css("display", "block");
			//$("button."+al+"").css("display", "block");
		});
		//$("li."+al+"").css("display", "block");
	}
	
});

 function reply_click(clicked_id)
  {
    if(clicked_id == 'pr')
    {
  		$('#hr').removeClass("active");
		$('#sa').removeClass("active");
		$('#pr').addClass("active");
	}
	else if(clicked_id == 'hr')
    {
  		$('#pr').removeClass("active");
		$('#sa').removeClass("active");
		$('#hr').addClass("active");
	}
	else
    {
  		$('#pr').removeClass("active");
		$('#hr').removeClass("active");
		$('#sa').addClass("active");
	}

    //  alert(clicked_id);
  }

</script>