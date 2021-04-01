<?php

session_start();
include("dbconn.php");
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
//$recnum = $_SESSION['recnum'];

if($_GET["action"]=="searchdata"){
	if($_GET["actmode"]=="userform"){
		$id=$_GET["PayId"];
		//$module=$_GET["PrivModule"];
		//$sub=$_GET["PrivSub"];
		//$name=$_GET["PrivName"];
		
		$output='';
		//$output .= '<tbody>';
		$query = "SELECT case when period = 0 then 'First Half' else 'Second Half' end as period,
					payrollperiod,
					date_format(startdate, '%Y-%m-%d') startdate,
					date_format(enddate, '%Y-%m-%d') enddate,
					date_format(payrolldate, '%Y-%m-%d') payrolldate,
					case when payrollgroup = 0 
					then 'Weekly' 
					else 'Semi-Monthly' end as payrollgroup,
					payrollgroup as payrollgroupid
					FROM payrollperiod where dataareaid = '$dataareaid' 
					and (payrollperiod like '%$id%')

					order by payrollperiod";
					//and (module like '%$module%') and (submodule like '%$sub%') and (name like '%$name%')";
		$result = $conn->query($query);
		$rowclass = "rowA";
		$rowcnt = 0;
		$rowcnt2 = 0;
		while ($row = $result->fetch_assoc())
		{ 
			$rowcnt++;
			$rowcnt2++;
				if($rowcnt > 1) { $rowcnt = 0; $rowclass = "rowB"; }
				else { $rowclass = "rowA";}
			
			$output .= '
			<tr id="'.$row["payrollperiod"].'" class="'.$rowclass.'" tabindex="'.$rowcnt2.'" >
				<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
				<td style="width:20%;">'.$row["period"].'</td>
				<td style="width:20%;">'.$row["payrollperiod"].'</td>
				<td style="width:20%;">'.$row["startdate"].'</td>
				<td style="width:20%;">'.$row["enddate"].'</td>
				<td style="width:20%;">'.$row["payrolldate"].'</td>
				<td style="width:20%;">'.$row["payrollgroup"].'</td>
				<td style="display:none;width:1%;">'.$row['payrollgroupid'].'</td>
			</tr>';
			$firstresult2 = $row["payrollperiod"];
		}
		//$output .= '</tbody>';
		echo $output;
		//header('location: process.php');
		$result2 = $conn->query($query);
		$row2 = $result2->fetch_assoc();
		//$firstresult2 = $row2["payrollperiod"];
		echo $output2 = '<tr class="rowA">
							<td hidden><input type="input" id="hide3" value="'.$firstresult2.'"></td>
						</tr>';
	}
}
else if($_GET["action"]=="save"){
	 
	 
	$id=$_GET["SelectedVal"];
	
	 if($id != ""){
		$_SESSION['DTRPeriod'] = $id;

	 }
	 
	header('location: dtrperiodform.php');
	
}
else if($_GET["action"]=="Import"){
	$id=$_GET["SelectedVal"];
	$fromdate = $_GET["locPayFromDate"];
	$todate = $_GET["locPayEndDate"];
	$actmode = $_GET["actionmode"];
	if($_GET["actionmode"]=="RO")
	{
		echo $id;
	 	echo "<br>";
	 	echo $fromdate;
	 	echo "<br>";
	 	echo $todate;
	 	echo "<br>";

	 	$sqlconsol = "call consolidateglobalDTR('$fromdate','$todate','$dataareaid')";
			if(mysqli_query($conn,$sqlconsol))
			{
				echo $sqlconsol."<br>".$conn->error;
			}
			else
			{
				echo "error".$sqlconsol."<br>".$conn->error;
			}

		$sqlprocess = "call SP_processdailytimerecord('$dataareaid','$fromdate','$todate','$id')";
			if(mysqli_query($conn,$sqlprocess))
			{
				echo $sqlprocess."<br>".$conn->error;
			}
			else
			{
				echo "error".$sqlprocess."<br>".$conn->error;
			}

		$sqloverwrite = "call overwriteall('$actmode','$fromdate','$todate','$dataareaid','$id')";
			if(mysqli_query($conn,$sqloverwrite))
			{
				echo $sqloverwrite."<br>".$conn->error;
			}
			else
			{
				echo "error".$sqloverwrite."<br>".$conn->error;
			}

		$sqlgenerate = "call SP_generateDTR('$dataareaid','$fromdate','$todate','$id')";
			if(mysqli_query($conn,$sqlgenerate))
			{
				echo $sqlgenerate."<br>".$conn->error;
			}
			else
			{
				echo "error".$sqlgenerate."<br>".$conn->error;
			}
	}
	else if($_GET["actionmode"]=="ALL")
	{
		echo $id;
	 	echo "<br>";
	 	echo $fromdate;
	 	echo "<br>";
	 	echo $todate;
	 	echo "<br>";

	 	$sqlconsol = "call consolidateglobalDTR('$fromdate','$todate','$dataareaid')";
			if(mysqli_query($conn,$sqlconsol))
			{
				echo $sqlconsol."<br>".$conn->error;
			}
			else
			{
				echo "error".$sqlconsol."<br>".$conn->error;
			}

		$sqlprocess = "call SP_processdailytimerecord('$dataareaid','$fromdate','$todate','$id')";
			if(mysqli_query($conn,$sqlprocess))
			{
				echo $sqlprocess."<br>".$conn->error;
			}
			else
			{
				echo "error".$sqlprocess."<br>".$conn->error;
			}

		$sqloverwrite = "call overwriteall('$actmode','$fromdate','$todate','$dataareaid','$id')";
			if(mysqli_query($conn,$sqloverwrite))
			{
				echo $sqloverwrite."<br>".$conn->error;
			}
			else
			{
				echo "error".$sqloverwrite."<br>".$conn->error;
			}

		$sqlgenerate = "call SP_generateDTR('$dataareaid','$fromdate','$todate','$id')";
			if(mysqli_query($conn,$sqlgenerate))
			{
				echo $sqlgenerate."<br>".$conn->error;
			}
			else
			{
				echo "error".$sqlgenerate."<br>".$conn->error;
			}
	}
	 
	
	
	 
	$_SESSION['DTRPeriod'] = $id;
	//header('location: dtrperiodform.php');
	
}
else if($_GET["action"]=="unload"){
	 	
	unset($_SESSION['PeriodAction']);
	//unset($_SESSION['paynum']);
	header('location: dtrperiodform.php');
	
}

?>

<script  type="text/javascript">
		var so='';
	  	var locPayPer;
		var locPayFromDate;
		var locPayEndDate;
		var locPayDate;
		var locPayGroup;
  		$(document).ready(function(){
			$('#datatbl tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","red");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
				locPayPer = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
				locPayFromDate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();
				locPayEndDate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(4)").text();
				locPayDate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(5)").text();
				locPayGroup = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(7)").text();
				so = usernum.toString();
				document.getElementById("hide").value = so;
				//alert(document.getElementById("hide").value);
				//alert(locPayGroup);	
					  
			});
		});

</script>