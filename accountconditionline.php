<?php

session_start();
include("dbconn.php");
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
$accnt = $_SESSION["accnt"];

if(isset($_SESSION['selectAcct'])) {
	$line = $_SESSION['selectAcct'];
	$output='';
		//$output .= '<tbody>';
		$query = "SELECT * FROM accountconditionheader ah left join accountconditiondetail ad 
				on ah.accountconditioncode = ad.accountconditioncode and ah.dataareaid = ad.dataareaid
				where ah.accountconditioncode = '$line' and ah.accountcode = '$accnt' and ah.dataareaid = '$dataareaid'";

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
				<td style="width:20px;"><span class="fa fa-adjust"></span></td>
				<td style="width:34%;">'.$row["referenceformula"].'</td>
				<td style="width:34%;">'.$row["condition"].'</td>
				<td style="width:34%;">'.$row["conditionformula"].'</td>
				<td style="display:none;width:1%;">'.$row["linenum"].'</td>
			</tr>';
		}
		//$output .= '</tbody>';
		echo $output;
		unset($_SESSION['selectAcct']);
		//header('location: process.php');

}
else
{
if($_POST["action"]=="getline"){
	if($_POST["actmode"]=="userform"){
		$id = $_POST["accountcode"];
		$_SESSION['AccFocus'] = $id;
		$output='';
		//$output .= '<tbody>';
		$query = "SELECT * FROM accountconditionheader ah left join accountconditiondetail ad 
				on ah.accountconditioncode = ad.accountconditioncode and ah.dataareaid = ad.dataareaid
				where ah.accountconditioncode = '$id' and ah.accountcode = '$accnt' and ah.dataareaid = '$dataareaid'";

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
				<td style="width:20px;"><span class="fa fa-adjust"></span></td>
				<td style="width:34%;">'.$row["referenceformula"].'</td>
				<td style="width:34%;">'.$row["condition"].'</td>
				<td style="width:34%;">'.$row["conditionformula"].'</td>
				<td style="display:none;width:1%;">'.$row["linenum"].'</td>
			</tr>';
		}
		//$output .= '</tbody>';
		echo $output;
		//header('location: process.php');
	}
}



}


?>

<script  type="text/javascript">
	var lnnmline = '';
	var cndtntst = '';
	$(document).ready(function(){
		$('#dataln tbody tr').click(function(){
			$('table tbody tr').css("color","black");
			$(this).css("color","orange");
			$('table tbody tr').removeClass("info");
			$(this).addClass("info");
			var linenumline = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(4)").text();
			lnnmline = linenumline.toString();
			document.getElementById("inchides").value = linenumline.toString();
			//alert(document.getElementById("hide").value);
			var conditiontest = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(2)").text();
			cndtntst = conditiontest.toString();
			document.getElementById("inchides2").value = cndtntst.toString();


			var rformula = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(1)").text();
			document.getElementById("inchides3").value = rformula.toString();
			
			var cformula = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(3)").text();
			document.getElementById("inchides4").value = cformula.toString();
				loc = document.getElementById("hide").value;
	            $("#myUpdateBtn").prop("disabled", false);
	             var pos = $("#"+loc+"").attr("tabindex");
				    $("tr[tabindex="+pos+"]").focus();
				    $("tr[tabindex="+pos+"]").css("color","red");
				    $("tr[tabindex="+pos+"]").addClass("info");    
					  
		});
	});
</script>