<?php

session_start();
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
include("dbconn.php");

if(isset($_GET["save"])) {
	 
	$id=$_GET["PayId"];
	$period=$_GET["PayPer"];
	$startdate=$_GET["PayFromDate"];
	$enddate=$_GET["PayEndDate"];
	$payrolldate=$_GET["PayDate"];
	$payrollgroup=$_GET["PayGroup"];
	 
	 if($id != ""){
	 $sql = "INSERT INTO payrollperiod (payrollperiod,startdate,enddate,payrolldate,period,payrollgroup,dataareaid,createdby,createddatetime)
			values 
			('$id', STR_TO_DATE('$startdate', '%Y-%m-%d'), STR_TO_DATE('$enddate', '%Y-%m-%d'), STR_TO_DATE('$payrolldate', '%Y-%m-%d'), '$period', '$payrollgroup', '$dataareaid', '$userlogin', now())";
		if(mysqli_query($conn,$sql))
		{
			echo "New Rec Created";
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}

	 }
	header('location: payrollperiodform.php');
	
}
else if(isset($_GET["update"])) {
	 
	$id=$_GET["PayId"];
	$period=$_GET["PayPer"];
	$startdate=$_GET["PayFromDate"];
	$enddate=$_GET["PayEndDate"];
	$payrolldate=$_GET["PayDate"];
	$payrollgroup=$_GET["PayGroup"];
	 
	 if($id != ""){
	 $sql = "UPDATE payrollperiod SET
				startdate = '$startdate',
				enddate = '$enddate',
				payrolldate = '$payrolldate',
				period = '$period',
				payrollgroup = '$payrollgroup',
				modifiedby = '$userlogin',
				modifieddatetime = now()
				WHERE payrollperiod = '$id'
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
	 
	header('location: payrollperiodform.php');

}
else if($_GET["action"]=="delete"){
	 
	if($_GET["actmode"]=="userform"){	
		$id=$_GET["PayId"];

		if($id != ""){
			$sql = "DELETE FROM payrollperiod where dataareaid = '$dataareaid' 
					and payrollperiod = '$id'";
			if(mysqli_query($conn,$sql))
			{
				echo "Rec Deleted";
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}

		}
		header('location: payrollperiodform.php');
	
	}
}
else if($_GET["action"]=="searchdata"){
	if($_GET["actmode"]=="userform"){
		$id=$_GET["PayId"];
		$paydate=$_GET["PayDate"];
		//$sub=$_GET["PrivSub"];
		//$name=$_GET["PrivName"];
		
		$output='';
		//$output .= '<tbody>';
		if($paydate != '')
		{
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
					and payrolldate = '$paydate'
					order by payrollperiod";
					//and (module like '%$module%') and (submodule like '%$sub%') and (name like '%$name%')";
		}
		else
		{
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
					#and payrolldate = '$paydate'
					order by payrollperiod";
					//and (module like '%$module%') and (submodule like '%$sub%') and (name like '%$name%')";
		}
		
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
else if($_GET["action"]=="add"){
	 $output='';
	 $sequence='';
	 $query = "SELECT * FROM numbersequence where dataareaid = '$dataareaid' and id='period'";
	 $result = $conn->query($query);
	 $row = $result->fetch_assoc();
	 $prefix = $row["prefix"];
	 $first = $row["first"];
	 $last = $row["last"];
	 $format = $row["format"];
	 $next = $row["next"];
	 $suffix = $row["suffix"];
	 if($last >= $next)
	 {
	 	$sequence = $prefix.substr($format,0,strlen($next)*-1).$next.$suffix;
	 }
	 else if ($last < $next)
	 {
	 	$sequence = $prefix.$next.$suffix;
	 }
	 $increment=$next+1;
	 $sql = "UPDATE numbersequence SET
				next = '$increment',
				modifiedby = '$userlogin',
				modifieddatetime = now()
				WHERE id = 'period'
				and dataareaid = '$dataareaid'";
	 //mysqli_query($conn,$sql);	
		if(mysqli_query($conn,$sql))
		{
			$output .= '
				 <input type="text" value="'.$sequence.'" placeholder="Payroll Period ID" name ="PayId" id="add-payrollperiod" class="modal-textarea" required="required">
				 ';
		}
		else
		{
			$output .= "error".$sql."<br>".$conn->error;
		}
	 
	 /*$output .= '
				 <input type="text" value="'.$sequence.'" placeholder="Payroll Period ID" name ="PayId" id="add-payrollperiod" class="modal-textarea" required="required">
				 ';*/
	 echo $output;
	
}
?>

<!-- <script  type="text/javascript">
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
</script> -->