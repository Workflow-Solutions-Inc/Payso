<?php 

include("dbconn.php");
$user = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
if(!isset($_SESSION['user']) || !isset($_SESSION['defaultdataareaid']))
{
	header('location: index.php');
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
				<li id="pr" onClick="reply_click(this.id)"><a href="menu.php?list=pr"><span class="fas fa-money-bill-wave"></span> Payroll</a></li>
				<li id="hr" onClick="reply_click(this.id)"><a href="menu.php?list=hr"><span class="fas fa-users"></span> Human Resource</a></li>
				<li id="sa" onClick="reply_click(this.id)"><a href="menu.php?list=sa"><span class="fas fa-user-cog"></span> System Administration</a></li>
			</ul>
		</div>

		<div class="header-signout hidden-xs hidden-sm">
			<a href="loginprocess.php?out"><span class="fas fa-sign-out-alt"></span></a>
		</div>
		
		<div class="header-admin">
			<div class="dropdown">
				<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<span class="far fa-user fa-lg"></span>
					<span class="fas fa-angle-down"></span>
				</button>
				<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
					<div><?php echo $user;?></div>
					<div><?php echo $currentDateTime;?></div>
					<hr>
					<div><a id="modaltableBtnHead"><span class="fas fa-cog"></span> Change Company</a></div>
					<div><a href="loginprocess.php?out"><span class="fas fa-key"></span> Change Password</a></div>
					<div><a href="loginprocess.php?out"><span class="fas fa-sign-out-alt"></span> Sign Out</a></div>
				</div>
			</div>
		</div>

		<div class="header-details">
			<?php
				$query2 = "SELECT * FROM userfile where userid = '$user'";
					$result2 = $conn->query($query2);
					$row2 = $result2->fetch_assoc();
					$uname = $row2["name"];

			?>
			<div><?php echo $uname;?></div>
			<div><b>HR Manager</b></div>
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
											<div id="container" class="half">
												<table width="100%" border="0" id="dataMenu" class="table table-striped mainpanel-table">
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
															
															$query = "SELECT UD.userid,UD.dataareaid,DA.name
																		FROM userfiledataarea UD
																		left join dataarea DA on DA.dataareaid = UD.dataareaid
																		where userid = '$user'";
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
																	<td style="width:20px;"><span class="fa fa-angle-right"></span></td>
																	<td style="width:50%;"><?php echo $row['dataareaid'];?></td>
																	<td style="width:50%;"><?php echo $row['name'];?></td>
																	<!--<td style="width:50%;"><input type='password' value='" . $row["password"]."'readonly='readonly'></td>-->
																	
																</tr>

															<?php }?>
													</tbody>
													<input type="input" id="hideCC">	
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
		    //$("#myModalHead").stop().fadeTo(500,1);
		    
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