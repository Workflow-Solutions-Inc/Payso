<?php
session_id("payso");
session_start();
include("dbconn.php");
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];

if(isset($_GET["save"])) {
	 
	 $id=$_GET["NumId"];
	 $prefix=$_GET["NumPrefix"];
	 $first=$_GET["NumFirst"];
	 $last=$_GET["NumLast"];
	 $format=$_GET["NumFormat"];
	 $next=$_GET["NumNext"];
	 $suffix=$_GET["NumSuffix"];
	 
	 if($id != ""){
	 $sql = "INSERT INTO numbersequence (id,prefix,first,last,format,next,suffix,dataareaid,createdby,createddatetime)
			values 
			('$id', '$prefix', '$first', '$last', '$format', '$next', '$suffix', '$dataareaid', '$userlogin', now())";
		if(mysqli_query($conn,$sql))
		{
			echo "New Rec Created";
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}

	 }
	 
	header('location: numbersequence.php');
	
	
}
else if(isset($_GET["update"])) {

	 $id=$_GET["NumId"];
	 $prefix=$_GET["NumPrefix"];
	 $first=$_GET["NumFirst"];
	 $last=$_GET["NumLast"];
	 $format=$_GET["NumFormat"];
	 $next=$_GET["NumNext"];
	 $suffix=$_GET["NumSuffix"];
	 
	 if($id != ""){
	 $sql = "UPDATE numbersequence SET
				id = '$id',
				prefix = '$prefix',
				first = '$first',
				last = '$last',
				format = '$format',
				next = '$next',
				suffix = '$suffix',
				modifiedby = '$userlogin',
				modifieddatetime = now()
				WHERE id = '$id'
				and dataareaid = '$dataareaid'";
		if(mysqli_query($conn,$sql))
		{
			echo "Rec Updated";
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}

	 }
	 
	header('location: numbersequence.php');
	
	
}
else if($_GET["action"]=="delete"){
	 
	if($_GET["actmode"]=="userform"){	
		$id=$_GET["NumId"];

		if($id != ""){
			$sql = "DELETE from numbersequence where id = '$id' and dataareaid = '$dataareaid'";
			if(mysqli_query($conn,$sql))
			{
				echo "Rec Deleted";
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}

		}
		header('location: numbersequence.php');
	
	}
}
else if($_GET["action"]=="searchdata"){
	if($_GET["actmode"]=="userform"){
		$id=$_GET["NumId"];
		$numprefix=$_GET["NumPrefix"];

		$output='';
		//$output .= '<tbody>';
		$query = "SELECT * FROM numbersequence where (id like '%$id%') and (prefix like '%$numprefix%') and dataareaid = '$dataareaid'";
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
				<td style="width:14%;">'.$row["id"].'</td>
				<td style="width:14%;">'.$row["prefix"].'</td>
				<td style="width:14%;">'.$row["first"].'</td>
				<td style="width:14%;">'.$row["last"].'</td>
				<td style="width:14%;">'.$row["format"].'</td>
				<td style="width:14%;">'.$row["next"].'</td>
				<td style="width:14%;">'.$row["suffix"].'</td>
			</tr>';
		}
		//$output .= '</tbody>';
		echo $output;
		//header('location: process.php');
	}
}
?>

<script  type="text/javascript">
		var so='';
	  	var locNumId = "";
		var locNumPrefix = "";
		var locNumFirst = "";
		var locNumLast = "";
		var locNumFormat = "";
		var locNumNext = "";
		var locNumSuffix = "";
  		$(document).ready(function(){
			$('#datatbl tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","red");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
				locNumPrefix = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
				locNumFirst = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();
				locNumLast = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(4)").text();
				locNumFormat = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(5)").text();
				locNumNext = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(6)").text();
				locNumSuffix = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(7)").text();
				so = usernum.toString();
				document.getElementById("hide").value = so;
				//alert(document.getElementById("hide").value);
				//alert(so);	
					  
			});
		});
</script>