<?php 
session_id("payso");
session_start();
include("dbconn.php");
$user = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
if(isset($_SESSION['WKNumUpload']))
{
	$wkid = $_SESSION['WKNumUpload'];
}
else
{
	header('location: workerform.php');
}
?>

<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Forms</title>

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
			<li class="BranchMaintain" style="display: none;"><button id="myAddBtn"><span class="fa fa-plus"></span> Upload File</button></li>
			<!--<li class="BranchMaintain" style="display: none;"><button onClick="download();"><span class="fa fa-download"></span> Download File</button></li>-->
			<li style="display: none;"><button onClick="Delete();"><span class="fa fa-trash-alt"></span> Delete Record</button></li>
			<li style="display: none;"><button id="myUpdateBtn"><span class="fa fa-edit"></span> Update Record</button></li>
			<li><button onClick="Cancel();"><span class="fa fa-arrow-circle-left fa-lg"></span> Back</button></li>
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
							<span class="fa fa-archive"></span> Forms
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
										<td style="width:25%;">File Type</td>
										<td style="width:25%;">File Name</td>
										<td style="width:25%;">Uploaded Date</td>
										<td style="width:25%;">Download</td>
										<td style="width: 17px;" class="text-center"><span class="fas fa-arrows-alt-v"></span></td>
									</tr>
									<tr class="rowsearch">
									  <td class="text-center"><span class="fas fa-search fa-xs"></span></td>
									  <td><span></span></td>
									  <td><span></span></td>
									  <td><span></span></td>
									  <td><span></span></td>
									  <td><span></span></td>
									</tr>
								</thead>
								
								<tbody id="result">
									<?php
									$query = "SELECT filetype,name,date_format(createddatetime, '%Y-%m-%d') as datefiled,recid FROM filemanagement where dataareaid = '$dataareaid' and workerid ='$wkid'";
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
										?>
										<tr class="<?php echo $rowclass; ?>" tabindex="<?php echo $rowcnt2; ?>">
											<!--<td style="width:10px;"><input type='checkbox' name="chkbox" value="" id="myCheck"></td>-->
											<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
											<td style="width:25%;"><?php echo $row['filetype'];?></td>
											<td style="width:25%;"><?php echo $row['name'];?></td>
											<td style="width:25%;"><?php echo $row['datefiled'];?></td>
											<td style="display:none;width:1%;"><?php echo $row['recid'];?></td>
											<td style="width:25%;"><a href="uploaderformprocess.php?file_id=<?php echo $row['name'] ?>">Download</a></td>
										</tr>
									<?php }?>
								</tbody>
								<span class="temporary-container-input">
									<input type="hidden" id="hide">
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
				<div class="col-lg-6">File Uploader</div>
				<div class="col-lg-6"><span class="fas fa-times modal-close"></span></div>
			</div>
			
			<div id="container" class="modal-content-container">
				<form name="myForm"  action="uploaderformprocess.php" method="post" enctype="multipart/form-data">
					<div class="row">

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>File Type:</label>
							<input type="text" value="" placeholder="File Type" name ="filetype" id="add-filetype" class="modal-textarea" required="required">

							<label>File:</label>
							<input type="file" name="myfile" id="myfile">
						</div>
						<input type="hidden" name ="workid" id="add-workid" value="<?php echo $wkid;?>" class="modal-textarea" required="required">
						

					</div>

					<div class="button-container">
						<button type="submit" id="addbt" name="save" value="save" class="btn btn-primary btn-action">Upload</button>
						
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


	 	function test()
	 	{
	 		document.getElementById("add-filetype").value = '';
		    document.getElementById("myfile").value = '';
	 	}

		/*var locname='';
	  	var so='';
		$(document).ready(function(){
		$('#datatbl tbody tr').click(function(){
			$('table tbody tr').css("color","black");
			$(this).css("color","red");
			$('table tbody tr').removeClass("info");
			$(this).addClass("info");
			var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(4)").text();
			locname = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
			so = usernum.toString();
			document.getElementById("hide").value = so;
			//alert(document.getElementById("hide").value);
			//alert(so);	
						  
				});
			});*/
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
		    //$("tr[tabindex="+pos+"]").focus();
		    //$("tr[tabindex="+pos+"]").css("color","red");
		    //$("tr[tabindex="+pos+"]").addClass("info");

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
		   
		    document.getElementById("add-filetype").value = '';
		    document.getElementById("myfile").value = '';
		    
		    document.getElementById("addbt").style.visibility = "visible";
		}
		UpdateBtn.onclick = function() {
			if(so != '') {
			   
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
		function download()
		{
			
			//alert(so);
			if(so != ''){
				var action = "download";
				$.ajax({
					type: 'GET',
					url: 'uploaderformprocess.php',
					data:{action:action, file_id:so},
					beforeSend:function(){
									
							$("#datatbl").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
								
							},
					success: function(data) {
						//alert(1);
						$('#datatbl').html(data);
						//so='';
					    //window.location.href='uploaderformprocess.php';
				    }
				});
			}
			else {
				alert("Please Select File.");
			}
		}
		
		function Cancel()
		{
			
			window.location.href='workerform.php';
			    
		}
</script>
<script type="text/javascript" src="js/custom.js"></script>
	<!-- end [JAVASCRIPT] -->

</body>
</html>