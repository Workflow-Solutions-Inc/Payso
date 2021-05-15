<?php 
session_start();
session_regenerate_id();
include("dbconn.php");
#$user = $_SESSION["user"];
?>

<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>S : Company</title>

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
			<li class="DataAreaMaintain" style="display: none;"><button id="myAddBtn"><span class="fa fa-plus"></span> Create Record</button></li>
			<li class="DataAreaMaintain" style="display: none;"><button onClick="Delete();"><span class="fa fa-trash-alt"></span> Delete Record</button></li>
			<li class="DataAreaMaintain" style="display: none;"><button id="myUpdateBtn"><span class="fa fa-edit"></span> Update Record</button></li>
			<li><button onClick="Cancel();"><span class="fa fa-arrow-circle-left fa-lg"></span> Back</button></li>
		</ul>

		<!-- extra buttons -->
		<ul class="extrabuttons">
			<li class="DataAreaMaintain" style="display: none;"><button id="viewlogo"><span class="fa fa-plus"></span> View Logo</button></li>
			<li class="DataAreaMaintain" style="display: none;"><button id="logo"><span class="fa fa-edit"></span> Change Logo</button></li>
			
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
							<span class="fa fa-archive"></span> Company
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
							<table width="100%" style="border: 1px solid #d9d9d9;" id="datatbl" class="table mainpanel-table">
								<thead>
									<tr class="rowtitle">
										<td style="width:20px;" class="text-center"><span class="fa fa-asterisk fa-xs"></span></td>
										<td style="width:25%;">Company id</td>
										<td style="width:25%;">Name</td>
										<td style="width:25%;">Address</td>
										<td style="width:25%;">TIN Number</td>
										<td style="width: 17px;" class="text-center"><span class="fas fa-arrows-alt-v"></span></td>
									</tr>
									<tr class="rowsearch">
										<td class="text-center"><span class="fas fa-search fa-xs"></span></td>
										<td><input list="SearchDataareaid" class="search">
										<?php
											$query = "SELECT distinct dataareaid FROM dataarea";
											$result = $conn->query($query);
									  	?>
									  <datalist id="SearchDataareaid">
										<?php 
											while ($row = $result->fetch_assoc()) {
										?>
											<option value="<?php echo $row["dataareaid"];?>"></option>
										<?php } ?>
										</datalist>
									  </td>
									  <td><input list="SearchName" class="search">
										<?php
											$query = "SELECT distinct name FROM dataarea";
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
									  <td></td>
									  <td></td>
									  <td><span></span></td>
									</tr>
								</thead>
								<tbody id="result">
									<?php
									$query = "SELECT * FROM dataarea";
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
											$collection = $collection.','.$row['dataareaid'];
										?>
										<tr id="<?php echo $row['dataareaid'];?>" class="<?php echo $rowclass; ?>" tabindex="<?php echo $rowcnt2; ?>">
											<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
											<!--<td style="width:10px;"><input type='checkbox' name="chkbox" value="" id="myCheck"></td>-->
											<td style="width:25%;"><?php echo $row['dataareaid'];?></td>
											<td style="width:25%;"><?php echo $row['name'];?></td>
											<td style="width:25%;"><?php echo $row['address'];?></td>
											<td style="width:25%;"><?php echo $row['companytin'];?></td>
										</tr>
									<?php }?>
								</tbody>
								<span class="temporary-container-input">
									<input type="hidden" id="hide">
									<div style="display:none;width:1%;"><textarea id="t2" value = "<?php echo substr($collection,1);?>"><?php echo substr($collection,1);?></textarea></div>

									<input type="hidden" id="hide">
								</span>
							</table>
						</div>
					</div>
				</div>
				<!-- end TABLE HERE -->
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
				<div class="col-lg-6">Company</div>
				<div class="col-lg-6"><span class="fas fa-times modal-close"></span></div>
			</div>
			
			<div id="container" class="modal-content-container">
				<form name="myForm" accept-charset="utf-8" action="dataareaprocess.php" method="get">
					<div class="row">

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>Dataarea ID:</label>
							<input type="text" value="" placeholder="Dataarea ID" name ="DataId" id="add-dataareaid" class="modal-textarea" required="required">

							<label>Name:</label>
							<input type="text" value="" placeholder="Name" name ="name" id="add-name" class="modal-textarea" required="required">
						</div>


						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label>Address:</label>
							<input type="text" value="" placeholder="Address" name ="DataAddress" id="add-dataaddress" class="modal-textarea" required="required">

							<label>TIN Number:</label>
							<input type="text" value="" placeholder="TIN Number" name ="tin" id="add-tin" class="modal-textarea" required="required">
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

<!-- Code Added By Jonald -->
<div id="myModal-logo" class="modal">
	<!-- Modal content -->
	<div class="modal-container">
		<div class="modal-content">
			<div class="modal-header">
				<div class="col-lg-6" id = "compname">Company</div>
				<div class="col-lg-6"><span class="fas fa-times modal-close-b"></span></div>
			</div>
			
			<div id="container" class="modal-content-container">
				<!-- <form name="myForm" accept-charset="utf-8" action="dataareaprocess.php" method="get"> -->
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"  align="center">
                          	<input type="file" name="images[]" accept="image/png, image/jpeg" id="add-logo" onchange="preview_image(event)" />
                          	
						</div>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" align="center" id="complogo">
							<img id="output_image"  height=250px width=250px />
						</div>

					</div>

					<div class="button-container">
						<button id="addlogo" name="logo" value="logo" class="btn btn-primary btn-action" onclick="putLogo()">Save</button>
						<button onClick="Clear();" type="button" value="Reset" class="btn btn-danger">Clear</button>
					</div>
				<!-- </form> -->
			</div>
		</div>
	</div>
</div>
<!-- end modal-->
<div id="myModal-viewlogo" class="modal">
	<!-- Modal content -->
	<div class="modal-container">
		<div class="modal-content">
			<div class="modal-header">
				<div class="col-lg-6" id = "compname2">Company</div>
				<div class="col-lg-6"><span class="fas fa-times modal-close-c"></span></div>
			</div>
			
			<div id="container" class="modal-content-container">
				<!-- <form name="myForm" accept-charset="utf-8" action="dataareaprocess.php" method="get"> -->
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"  align="center">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" align="center" id="complogo2">
							<img id="output_image2"  height=500px width=600px />
						</div>

					</div>
				<!-- </form> -->
			</div>
		</div>
	</div>
</div>

<!-- End of Code -->


<!-- begin [JAVASCRIPT] -->
<script src="js/ajax.js"></script>
	<script  type="text/javascript">

		var so='';
		var locName='';
		var locAddress='';
		var locTin='';
		$(document).ready(function(){
		$('#datatbl tbody tr').click(function(){
			$('table tbody tr').css("color","black");
			$(this).css("color","red");
			$('table tbody tr').removeClass("info");
			$(this).addClass("info");
			var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
			locName = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
			locAddress = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();
			locTin = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(4)").text();
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
		    $("#add-dataareaid").prop('readonly', false);
		    document.getElementById("add-dataareaid").value = '';
		    document.getElementById("upbt").style.visibility = "hidden";
		    document.getElementById("addbt").style.visibility = "visible";
		}
		UpdateBtn.onclick = function() {
			if(so != '') {
			    //modal.style.display = "block";
			    $("#myModal").stop().fadeTo(500,1);
			    $("#add-dataareaid").prop('readonly', true);
				document.getElementById("add-dataareaid").value = so;
				document.getElementById("add-name").value = locName.toString();
				document.getElementById("add-dataaddress").value = locAddress.toString();
				document.getElementById("add-tin").value = locTin.toString();
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

		// Get the modal for logo -------------------
		var modallogo = document.getElementById('myModal-logo');
		// Get the button that opens the modal
		var logoBtn = document.getElementById("logo");
		// Get the <span> element that closes the modal
		var logospan = document.getElementsByClassName("modal-close-b")[0];
		// When the user clicks the button, open the modal 
		var viewlogo = document.getElementById('myModal-viewlogo');
		var viewlogoBtn = document.getElementById("viewlogo");
		var logospan2 = document.getElementsByClassName("modal-close-c")[0];
		logoBtn.onclick = function() {
		    
		    if(so==""){
		    	alert("no selected data");
		    }else{
		    	$("#myModal-logo").stop().fadeTo(500,1);
		    	getlogo();
		   		document.getElementById("genlogo").style.visibility = "visible";
		    }
		    
		}

		viewlogoBtn.onclick = function(){
				$("#myModal-viewlogo").stop().fadeTo(500,1);
		    	getlogo();
		   		document.getElementById("genlogo").style.visibility = "visible";
		}
		// When the user clicks on <span> (x), close the modal
		logospan.onclick = function() {
		    modallogo.style.display = "none";
		}

		logospan2.onclick = function() {
		    viewlogo.style.display = "none";
		}
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
			var n = myId.includes(document.getElementById("add-dataareaid").value.toLowerCase());
			//alert(n);
			if(n == true){
				alert("Company already Exist!");
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
		function Clear()
		{
			document.getElementById("add-dataareaid").value = "";
			document.getElementById("add-name").value = "";
			document.getElementById("add-dataaddress").value = "";
			document.getElementById("add-tin").value = "";
		}

		//-----search-----//
		$( ".search" ).on( "keydown", function(event) {
		  if(event.which == 13){
			var search = document.getElementsByClassName('search');
			var DataId;
			var name;
			var action = "searchdata";
			var actionmode = "userform";
			var data=[];
			 for(i=0;i<search.length;i++){
				 data[i]=search[i].value;
				 //search[i].value = "";
			 }
			 
			 DataId = data[0];
			 name = data[1];

			 $.ajax({
						type: 'GET',
						url: 'dataareaprocess.php',
						data:{action:action, actmode:actionmode, DataId:DataId, name:name},
						//data:'bkno='+BNo+'&bkdesc='+BDesc+'&bktit='+BTit+'&bkqty='+BQ,
						beforeSend:function(){
						
							$("#result").html('<center><br><img src="img/loading.gif" width="400" height="300"></center>');
			
						},
						success: function(data){
							$('#result').html(data);
							$(document).ready(function(){
							$('#datatbl tbody tr').click(function(){
								$('table tbody tr').css("color","black");
								$(this).css("color","red");
								$('table tbody tr').removeClass("info");
								$(this).addClass("info");
								var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
								locName = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
								so = usernum.toString();
								document.getElementById("hide").value = so;
								//alert(document.getElementById("hide").value);
								//alert(so);	
											  
									});
								});

							/*var pos = 1;
						    $("tr[tabindex="+pos+"]").focus();
						    $("tr[tabindex="+pos+"]").css("color","red");
						    $("tr[tabindex="+pos+"]").addClass("info");*/
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
							url: 'dataareaprocess.php',
							//data:'action=save&actmode=userform&userno='+UId.value+'&pass='+UPass.value+'&lname='+NM.value+'&darea='+DT.value,
							data:{action:action, actmode:actionmode, DataId:so},
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

		// Code Added by Jonald
		function preview_image(event) {
		     	var filesSelected = document.getElementById("add-logo").files;
			    if (filesSelected.length > 0) {
			      var fileToLoad = filesSelected[0];

			      var fileReader = new FileReader();

			      fileReader.onload = function(fileLoadedEvent) {
			        var srcData = fileLoadedEvent.target.result; // <--- data: base64

			        //var newImage = document.createElement('img');
			        //newImage.src = srcData;

			        myProof = srcData;
			        document.getElementById('complogo').innerHTML = '<img src="'+srcData+'" width="300" height="250">';
			      }
			      fileReader.readAsDataURL(fileToLoad);
    		}


  		}

  		function putLogo()
		{
			var logo = $('#add-logo').val(); 
			 modallogo.style.display = "none";
			//alert(logo);
                var extension = $('#add-logo').val().split('.').pop().toLowerCase();  
                if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)  
                {  
                     alert('Invalid Image File');  
                     $('#add-logo').val('');  
                     return false;  
                }  
                else
                {
                	var action = "uploadlogo";
                	var proof   = myProof;
                	
                	//alert(so);
                	$.ajax({	
							type: 'POST',
							url: 'logoprocess.php',
							data:{so:so, proof:proof},
							beforeSend:function(){
									
							$("#datatbl").html('<center><img src="img/loading.gif" width="300" height="300" black></center>');
							//alert(proof);
								
							},
							success: function(data){
							location.reload();				
							}
					});
                }
		}

		function getlogo(){
			if(so==""){
				alert("no selected data");
			}else{
				
	          var action = "getlogo";
                	$.ajax({	
							type: 'GET',
							url: 'dataareaprocess.php',
							data:{so:so, action:action},
							beforeSend:function(){
							//alert(1);
							$("#complogo").html('<center><img src="img/loading.gif" width="300" height="250"></center>');
							$("#complogo2").html('<center><img src="img/loading.gif" height=500px width=600px"></center>');
							//alert(proof);
								
							},
							success: function(data){
								var my_arr = data.split("|");
								var compname = my_arr[1];
								var complogo = my_arr[0];
								//document.write(compname);
								document.getElementById('compname').innerHTML = compname;
								document.getElementById('compname2').innerHTML = compname;
								document.getElementById('complogo').innerHTML = '<img src="'+complogo+'" width="300" height="250">';
								document.getElementById('complogo2').innerHTML = '<img src="'+complogo+'" height=500px width=600px">';
							}
					});
			}
			
		}
		// End of Code

		
	</script>
	
<script type="text/javascript" src="js/custom.js"></script>
	<!-- end [JAVASCRIPT] -->
</body>
</html>