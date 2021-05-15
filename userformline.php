<?php
session_start();
session_regenerate_id();
include("dbconn.php");
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];


if($_POST["action"]=="getline"){
	if($_POST["actmode"]=="userform"){
		$id=$_POST["userId"];
		$_SESSION['UsrNum'] = $id;
		$output='';
			//$output .= '<tbody>';
			$query = "SELECT UD.userid,UD.dataareaid,DA.name
					FROM userfiledataarea UD
					left join dataarea DA on DA.dataareaid = UD.dataareaid

					where userid = '$id'";

			$result = $conn->query($query);
			$rowclass = "rowA";
			$rowcnt = 0;
			while ($row = $result->fetch_assoc())
			{
				$rowcnt++;
					if($rowcnt > 1) { $rowcnt = 0; $rowclass = "rowB"; }
					else { $rowclass = "rowA";}
				$output .= '
				<tr class="'.$rowclass.'">
					<td style="width:20px;"><span class="fa fa-angle-right"></span></td>
					<td style="width:50%;">'.$row["dataareaid"].'</td>
					<td style="width:50%;">'.$row["name"].'</td>
				</tr>';
			}
			//$output .= '</tbody>';
			echo $output;
			//unset($_SESSION['paylinenum']);
			//header('location: process.php');
	}

}

else if($_POST["action"]=="clearline"){
	if($_POST["actmode"]=="userform"){

		$output='';
		$output .= '
			<tr class="rowA">
				<td><span class="fa fa-adjust"></span></td>
				<td>'.'</td>
				<td>'.'</td>
				<td>'.'</td>
				<td>'.'</td>
				<td>'.'</td>
			</tr>';
		echo $output;
	}
}





?>

<!-- <script  type="text/javascript">
		/*var so='';
	  	
  		$(document).ready(function(){
			$('#datatbl tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","red");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();
				so = usernum.toString();
				document.getElementById("hide").value = so;
				//alert(document.getElementById("hide").value);
				//alert(so);
				//-----------get line--------------//
				var action = "getline";
				var actionmode = "userform";
				$.ajax({
					type: 'GET',
					url: 'payrolltransactionprocess.php',
					data:{action:action, actmode:actionmode, PayId:so},
					beforeSend:function(){
					
						$("#lineresult").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
					},
					success: function(data){
						payline='';
						document.getElementById("hide2").value = "";
						$('#lineresult').html(data);
					}
				}); 	
				//-----------get line--------------//	  
			});
		});*/
		var locDataarea='';
  		var locDTName='';
		$(document).ready(function(){
			$('#dataln tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","orange");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				var transnumline = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(1)").text();
				locDTName = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(2)").text();
				locDataarea = transnumline.toString();
				document.getElementById("hide2").value = locDataarea;
				//alert(document.getElementById("hide").value);
					
				flaglocation = false;
		        $("#myUpdateBtn").prop("disabled", true);
		        //alert(flaglocation);		
				//flaglocation = false;
				//alert(payline);
				loc = document.getElementById("hide").value;
	            //$("#myUpdateBtn").prop("disabled", false);
	             var pos = $("#"+loc+"").attr("tabindex");
				    $("tr[tabindex="+pos+"]").focus();
				    $("tr[tabindex="+pos+"]").css("color","red");
				    $("tr[tabindex="+pos+"]").addClass("info");
				//document.getElementById("myUpdateBtn").style.disabled = disabled;
					  
			});
		});
</script> -->