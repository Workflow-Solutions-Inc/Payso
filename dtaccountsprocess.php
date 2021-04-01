<?php

session_start();
include("dbconn.php");
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
$recnum = $_SESSION['recnum'];

if($_GET["action"]=="searchdata"){
	if($_GET["actmode"]=="userform"){
		$id=$_GET["AccCode"];
		$accname=$_GET["AccName"];

		$accum=$_GET["AccUm"];
		$acctype=$_GET["AccType"];


		$output='';
		//$output .= '<tbody>';
		$query = "SELECT autoinclude,
					accountcode,
					name,
					label,
					um,
					case when accounttype = 0 then 'Entry'
						when accounttype = 1 then 'Computed'
						when accounttype = 2 then 'Condition'
					else 'Total'
					end as accounttype,
					case when category = 0 then 'Lines'
					else 'Header' 
					end as category,
					formula,
					format(defaultvalue,2) defaultvalue,
					priority
			FROM accounts where (accountcode like '%$id%') and (name like '%$accname%') 
			and (um like '%$accum%') and dataareaid = '$dataareaid' and category = 0
			order by priority asc";
		$result = $conn->query($query);
		$rowclass = "rowA";
		$rowcnt = 0;
		$rowcnt2 = 0;
		$lastrec ='';
		while ($row = $result->fetch_assoc())
		{
			$rowcnt++;
			$rowcnt2++;
				if($rowcnt > 1) { $rowcnt = 0; $rowclass = "rowB"; }
				else { $rowclass = "rowA";}

			$output .= '
			<tr id="'.$row["accountcode"].'" class="'.$rowclass.'" tabindex="'.$rowcnt2.'">
				<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
				<td style="width:23%;">'.$row["accountcode"].'</td>
				<td style="width:28%;">'.$row["name"].'</td>
				<td style="width:20%;">'.$row["um"].'</td>
				<td style="width:24%;">'.$row["accounttype"].'</td>
				'.$lastrec = $row["priority"].'
			</tr>';
		}
		//$output .= '</tbody>';
		echo $output;
		//header('location: process.php');
	}
}
else if($_GET["action"]=="save"){
	 
	 
	$id=$_GET["SelectedVal"];
	
	 if($id != ""){
	 $sql = "UPDATE excempteddeductions SET
				accountid = '$id',
				modifiedby = '$userlogin',
				modifieddatetime = now()
				WHERE recid = '$recnum'
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
	 
	header('location: deductionform.php');
	
}

?>

<script  type="text/javascript">
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
				var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
				locAccName = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
				locAccUm = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();
				locAccType = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(4)").text();

				
				so = usernum.toString();
				document.getElementById("hide").value = so;				  
			});
		});

</script>