<?php 
session_start();
session_regenerate_id();
include("dbconn.php");
$user = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
?>

<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Branch</title>

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
			<li class="BranchMaintain" style="display: none;"><button id="myAddBtn"><span class="fa fa-plus"></span> Create Record</button></li>
			<li class="BranchMaintain" style="display: none;"><button onClick="Delete();"><span class="fa fa-trash-alt"></span> Delete Record</button></li>
			<li class="BranchMaintain" style="display: none;"><button id="myUpdateBtn"><span class="fa fa-edit"></span> Update Record</button></li>
			<li><button onClick="Cancel();"><span class="fa fa-arrow-circle-left fa-lg"></span> Back</button></li>
			
		</ul>

		<!-- extra buttons -->
		<ul class="mainbuttons">
			

			<li>
				<div class="btn-group dropright mainbuttons-dropdown-group">
					<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span class="far fa-file-alt fa"></span> Upload/Template <span class="fas fa-angle-right right"></span>
					</button>
					<div class="dropdown-menu mainbuttons-dropdown-menu">
						<!-- sub link -->
						<ul>
							
							<li><button onClick="Export();"><span class="fa fa-plus fa-lg"></span> Generate Template</button></li>
							<li class="BranchMaintain" style="display: none;"><button id="myUploadBtn"><span class="fa fa-plus"></span> Upload Record</button></li>

						</ul>
					</div>
				</div>
			</li>
		</ul>
		
		<!-- extra buttons -->
		<!--
		<ul class="extrabuttons">
			<li><button><span class="fas fa-arrow-up fa"></span> Move Up</button></li>
			<li><button><span class="fas fa-arrow-down fa"></span> Move Down</button></li>
		</ul>
		-->

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
							<span class="fa fa-archive"></span> Branch
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
									<tr class="rowtitle">
										<td style="width:20px;" class="text-center"><span class="fa fa-asterisk fa-xs"></span></td>
										<td style="width:50%;">Branch Code</td>
										<td style="width:50%;">Name</td>
										<td style="width: 17px;" class="text-center"><span class="fas fa-arrows-alt-v"></span></td>
									</tr>
									<tr class="rowsearch">
									  <td class="text-center"><span class="fas fa-search fa-xs"></span></td>
									  

									   <td><input list="SearchBranch" class="search">
										<?php
											$query = "SELECT distinct branchcode FROM branch where dataareaid = '$dataareaid'";
											$result = $conn->query($query);	
												
									  ?>
									  <datalist id="SearchBranch">
										
										<?php 
										
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["branchcode"];?>"></option>
											
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchName" class="search">
										<?php
											$query = "SELECT distinct name FROM branch where dataareaid = '$dataareaid'";
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
									$query = "SELECT * FROM branch where dataareaid = '$dataareaid'";
									$result = $conn->query($query);
									$rowclass = "rowA";
									$rowcnt = 0;
									$rowcnt2 = 0;
									$collection = '';
									while ($row = $result->fetch_assoc())
									{ 
										$rowcnt++;
										$rowcnt2++;
											if($rowcnt > 1) { $rowcnt = 0; $rowclass = "rowB"; }
											else { $rowclass = "rowA";}
											$collection = $collection.','.$row['branchcode'];
										?>
										<tr id="<?php echo $row['branchcode'];?>" class="<?php echo $rowclass; ?>" tabindex="<?php echo $rowcnt2; ?>">
											<!--<td style="width:10px;"><input type='checkbox' name="chkbox" value="" id="myCheck"></td>-->
											<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
											<td style="width:50%;"><?php echo $row['branchcode'];?></td>
											<td style="width:50%;"><?php echo $row['name'];?></td>
											
										</tr>
									<?php }?>
								</tbody>
								<span class="temporary-container-input">
									<input type="hidden" id="hide">
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



<!-- The Modal -->
<div id="myModal" class="modal">
	<!-- Modal content -->
	<div class="modal-container">
		<div class="modal-content">
			<div class="modal-header">
				<div class="col-lg-6">Branch</div>
				<div class="col-lg-6"><span class="fas fa-times modal-close"></span></div>
			</div>
			
			<div id="container" class="modal-content-container">
				<form name="myForm" accept-charset="utf-8" action="branchformprocess.php" method="get">
					<div class="row">

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>Branch Code:</label>
							<input type="text" value="" placeholder="Branch Code" name ="BranchId" id="add-branch" class="modal-textarea" required="required">

							<label>Name:</label>
							<input type="text" value="" placeholder="Name" name ="name" id="add-name" class="modal-textarea" required="required">
						</div>

						

					</div>

					<div class="button-container">
						<button id="addbt" name="save" value="save" class="btn btn-primary btn-action" onclick="return checkExistForm()">Save</button>
						<button id="upbt" name="update" value="update" class="btn btn-success btn-action" onclick="return validateForm()">Update</button>
						<button onClick="Clear();" type="button" value="Reset" class="btn btn-danger">Clear</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- end modal-->

<!-- The Modal -->
<div id="myModalUpload" class="modal">
	<!-- Modal content -->
	<div class="modal-container">
		<div class="modal-content">
			<div class="modal-header">
				<div class="col-lg-6">File Uploader</div>
				<div class="col-lg-6"><span class="fas fa-times modal-close-i"></span></div>
			</div>
			
			<div id="container" class="modal-content-container">
				<form name="myForm"  action="branchupload.php" method="post" enctype="multipart/form-data">
					<div class="row">

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<!-- <label>File Type:</label>
							<input type="text" value="" placeholder="File Type" name ="filetype" id="add-filetype" class="modal-textarea" required="required"> -->

							<label>Chose CSV File:</label><br>
							<input type="file" name="myfile" id="myfile">

							<p class="help-block">Only CSV File is accepted to Import.</p>
						</div>
						
						

					</div>

					<div class="button-container">
						<button type="submit" id="addbtUpload" name="saveUpload" value="saveUpload" class="btn btn-primary btn-action">Upload</button>
						
						<button onClick="test()" type="button" value="Reset" class="btn btn-danger" >Clear</button>
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

		var locname='';
	  	var so='';
		$(document).ready(function(){
		$('#datatbl tbody tr').click(function(){
			$('table tbody tr').css("color","black");
			$(this).css("color","red");
			$('table tbody tr').removeClass("info");
			$(this).addClass("info");
			var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
			locname = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
			so = usernum.toString();
			document.getElementById("hide").value = so;
			//alert(document.getElementById("hide").value);
			//alert(so);	
						  
				});
			});
		$(document).ready(function() {

			loc = document.getElementById("hide").value;
	            //$("#myUpdateBtn").prop("disabled", false);
	        if(loc != '')
	        {
	        	//var pos = $("#"+loc+"").attr("tabindex");
	        	var pos = 1;
	        }
	        else
	        {
	        	var pos = 1;
	        }
		    $("tr[tabindex="+pos+"]").focus();
		    $("tr[tabindex="+pos+"]").css("color","red");
		    $("tr[tabindex="+pos+"]").addClass("info");

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
		    $("#add-branch").prop('readonly', false);
		    document.getElementById("add-branch").value = '';
		    document.getElementById("upbt").style.visibility = "hidden";
		    document.getElementById("addbt").style.visibility = "visible";
		}
		UpdateBtn.onclick = function() {
			if(so != '') {
			    //modal.style.display = "block";
			    $("#myModal").stop().fadeTo(500,1);
			    $("#add-branch").prop('readonly', true);
				document.getElementById("add-branch").value = so;
				document.getElementById("add-name").value = locname.toString();
			    document.getElementById("addbt").style.visibility = "hidden";
			    document.getElementById("upbt").style.visibility = "visible";
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
		var myId = [];
		function checkExistForm()
		{
			var cont = document.getElementById("t2").value;
			myId = cont.toLowerCase().split(",");
			//myId.push("Kiwi","Lemon","Pineapple",'asd');
			/*$.each(myId, function(i, el2){
		    	alert(el2);
			});*/
			//alert(myId.length);
			var n = myId.includes(document.getElementById("add-branch").value.toLowerCase());
			//alert(n);
			if(n == true){
				alert("Branch Code already Exist!");
				return false;
			}
			else
			{
				//alert("Continue Saving...");
				return true;
			}
			
		}

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
		}

		//-----search-----//
		$( ".search" ).on( "keydown", function(event) {
		  if(event.which == 13){
			var search = document.getElementsByClassName('search');
			var BranchId;
			var name;
			var action = "searchdata";
			var actionmode = "userform";
			var data=[];
			 for(i=0;i<search.length;i++){
				 data[i]=search[i].value;
				 //search[i].value = "";
			 }
			 
			 BranchId = data[0];
			 name = data[1];

			 $.ajax({
						type: 'GET',
						url: 'branchformprocess.php',
						data:{action:action, actmode:actionmode, BranchId:BranchId, name:name},
						//data:'bkno='+BNo+'&bkdesc='+BDesc+'&bktit='+BTit+'&bkqty='+BQ,
						beforeSend:function(){
						
							$("#result").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
			
						},
						success: function(data){
							$('#result').html(data);
							var pos = 1;
						    $("tr[tabindex="+pos+"]").focus();
						    $("tr[tabindex="+pos+"]").css("color","red");
						    $("tr[tabindex="+pos+"]").addClass("info");

		
							$(document).ready(function(){
							$('#datatbl tbody tr').click(function(){
								$('table tbody tr').css("color","black");
								$(this).css("color","red");
								$('table tbody tr').removeClass("info");
								$(this).addClass("info");
								var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
								locname = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
								so = usernum.toString();
								document.getElementById("hide").value = so;
								//alert(document.getElementById("hide").value);
								//alert(so);	
											  
									});
								});

				}
			}); 
			 
		  }
		});
		//-----end search-----//

		function Clear()
		{
			if(so != '')
			{
				//document.getElementById("add-branch").value = "";
				document.getElementById("add-name").value = "";
			}
			else
			{
				document.getElementById("add-branch").value = "";
				document.getElementById("add-name").value = "";
			}
			
		}
		
		function Save()
		{
			
			modal.style.display = "none";
			/*var UId = document.getElementById("add-UserId");
			var UPass = document.getElementById("add-pass");
			var NM = document.getElementById("add-name");
			var DT = document.getElementById("add-dataareaid");*/
			var BranchId = $('#add-branch').val();
			var name = $('#add-name').val();
			var action = "save";
			var actionmode = "userform";
			$.ajax({	
					type: 'GET',
					url: 'branchformprocess.php',
					//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
					data:{action:action, actmode:actionmode, BranchId:BranchId, name:name},
					beforeSend:function(){
							
					$("#datatbl").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
						
					},
					success: function(data){
					//$('#datatbl').html(data);
					location.reload();					
					}
			}); 
						
		}

		function Update()
		{
			
			modal.style.display = "none";
			/*var UId = document.getElementById("add-UserId");
			var UPass = document.getElementById("add-pass");
			var NM = document.getElementById("add-name");
			var DT = document.getElementById("add-dataareaid");*/
			var BranchId = $('#add-branch').val();
			var name = $('#add-name').val();
			var action = "update";
			var actionmode = "userform";
			if(so != '') {
				if(confirm("Are you sure you want to update this record?")) {
					$.ajax({	
							type: 'GET',
							url: 'branchformprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action, actmode:actionmode, BranchId:BranchId, name:name},
							beforeSend:function(){
									
							$("#datatbl").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
								
							},
							success: function(data){
							//$('#datatbl').html(data);
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
				alert("Please Select a record you want to update.");
			}			
		}

		function Delete()
		{
			
			var action = "delete";
			var actionmode = "userform";
			if(so != '') {
				if(confirm("Are you sure you want to remove this record?")) {
					$.ajax({	
							type: 'GET',
							url: 'branchformprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action, actmode:actionmode, BranchId:so},
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
			
			window.location.href='menu.php?list='+ActiveMode;
			    
		}

		function test()
	 	{
	 		document.getElementById("add-filetype").value = '';
		    document.getElementById("myfile").value = '';
	 	}

	 	// Get the modal -------------------
		var modalUpload = document.getElementById('myModalUpload');
		// Get the button that opens the modal
		var UploadBtn = document.getElementById("myUploadBtn");
		// Get the <span> element that closes the modal
		var Uploadspan = document.getElementsByClassName("modal-close-i")[0];
		// When the user clicks the button, open the modal 
		UploadBtn.onclick = function() {
		    //modal.style.display = "block";
		    $("#myModalUpload").stop().fadeTo(500,1);
		   
		    document.getElementById("add-filetype").value = '';
		    document.getElementById("myfile").value = '';
		    
		    document.getElementById("addbtUpload").style.visibility = "visible";
		}
		
		// When the user clicks on <span> (x), close the modal
		Uploadspan.onclick = function() {
		    modalUpload.style.display = "none";
		   // Clear();
		}
		
		//end modal --------------------------- 

		function Export()
		{
			alert("Template has beed generated. Please check 'Payso_Branch.csv' on your download folder.");

			const rows = [
			    ["Branch Code", "Branch Name", "Company Code"]
			];

			let csvContent = "data:text/csv;charset=utf-8,";

			rows.forEach(function(rowArray) {
			    let row = rowArray.join(",");
			    csvContent += row + "\r\n";
			});

			var encodedUri = encodeURI(csvContent);
			var link = document.createElement("a");
			link.setAttribute("href", encodedUri);
			link.setAttribute("download", "Payso_Branch.csv");
			document.body.appendChild(link); // Required for FF

			link.click(); // This will download the data file named "my_data.csv".

		}
</script>
<script type="text/javascript" src="js/custom.js"></script>
	<!-- end [JAVASCRIPT] -->

</body>
</html>