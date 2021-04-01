<?php

session_start();
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
include("dbconn.php");

if(isset($_GET["save"])) {
	 

	$payoutid=$_GET["leaveid"];
	$year=$_GET["yrSelection"];
	//$fromdate=$_GET["FromDate"];
	//$todate=$_GET["EndDate"];

	$fromdate="1990-01-01";
	$todate="1990-01-01";
	 
	 if($payoutid != ""){
	 $sql = "INSERT Into leavepayoutheader (leavepayoutid,year,fromDate,todate,status,dataareaid,createdby,createddatetime) 
		 			values ('$payoutid','$year','$fromdate','$todate','0','$dataareaid','$userlogin',now())";
		if(mysqli_query($conn,$sql))
		{
			echo "New Rec Created";
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}

	 }
	header('location: leavepayout.php');
	
}
else if(isset($_GET["update"])) {
	 
	$id=$_GET["leaveid"];
	$year=$_GET["yrSelection"];
	//$fromdate=$_GET["FromDate"];
	//$todate=$_GET["EndDate"];
	 
	 if($id != ""){
	 $sql = "UPDATE leavepayoutheader SET 

	 		year = '$year',
			modifiedby = '$userlogin',
			modifieddatetime = now()
			WHERE leavepayoutid = '$id' and dataareaid = '$dataareaid'";
		if(mysqli_query($conn,$sql))
		{
			echo "Rec Updated";
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}

	 }
	 
	header('location: leavepayout.php');

}
else if($_GET["action"]=="delete"){
	 
	if($_GET["actmode"]=="userform"){	

		$payoutid=$_GET["leaveid"];
		$year=$_GET["yrSelection"];
		//$fromdate=$_GET["FromDate"];
		//$todate=$_GET["EndDate"];

		if($payoutid != ""){

			$sql = "UPDATE
				leavefile  lf


				left join leavepayoutdetail lp on lf.workerid = lp.workerid and lf.dataareaid = lp.dataareaid
				and lp.leavetype = lf.leavetype and lp.refrecid = lf.recid

				set lf.balance = lp.leavecredits

				where
				
				lf.year = '$year'
				and lp.leavecredits IS NOT NULL
				";
			if(mysqli_query($conn,$sql))
			{
				$sqldelete = "DELETE from leavepayoutdetail where leavepayoutid = '$payoutid' and dataareaid = '$dataareaid'";

				if(mysqli_query($conn,$sqldelete))
				{
					echo "Rec Deleted";
				}
				else
				{
					echo "error".$sqldelete."<br>".$conn->error;
				}

				$sqldelete = "DELETE from leavepayoutheader where leavepayoutid = '$payoutid' and dataareaid = '$dataareaid'";

				if(mysqli_query($conn,$sqldelete))
				{
					echo "Rec Deleted";
				}
				else
				{
					echo "error".$sqldelete."<br>".$conn->error;
				}
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}




			/*$sql = "DELETE from leavepayoutheader where leavepayoutid = '$id' and dataareaid = '$dataareaid'";
			if(mysqli_query($conn,$sql))
			{
				echo "Rec Deleted";
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}*/

		}
		header('location: leavepayout.php');
	
	}
}
else if($_GET["action"]=="searchdata"){
	if($_GET["actmode"]=="userform"){

		$id=$_GET["PayId"];
		$year=$_GET["PayYear"];
		$date=$_GET["PayDate"];
		$period=$_GET["PayPer"];
		$stauts=$_GET["PayStatus"];
		//$name=$_GET["PrivName"];
		
		$output='';
		//$output .= '<tbody>';
		$query = "SELECT  case when period = 0 then 'First Half' else 'Second Half' end as period, leavepayoutid, year, payoutdate, case when status = 0 then 'Created' else 'Posted' end as status

		 from leavepayoutheader where dataareaid = '$dataareaid' and  leavepayoutid like '%$id%' and year like '%$year%' and payoutdate like '%$date%'

					";
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
			<tr id="'.$row["leavepayoutid"].'" class="'.$rowclass.'" tabindex="'.$rowcnt2.'" >
				<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
				<td style="width:20%;">'.$row["leavepayoutid"].'</td>
				<td style="width:20%;">'.$row["year"].'</td>
				<td style="width:20%;">'.$row["period"].'</td>
				<td style="width:20%;">'.$row["payoutdate"].'</td>
				<td style="width:20%;">'.$row["status"].'</td>
				<td style="display:none;width:1%;">'.$row['leavepayoutid'].'</td>
			</tr>';
			$firstresult2 = $row["leavepayoutid"];
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
	 $query = "SELECT * FROM numbersequence where dataareaid = '$dataareaid' and id='leavepayout'";
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
				WHERE id = 'leavepayout'
				and dataareaid = '$dataareaid'";
	 //mysqli_query($conn,$sql);	
		if(mysqli_query($conn,$sql))
		{
			$output .= '
				 <input type="text" value="'.$sequence.'" placeholder="Leave Payout ID" name ="leaveid" id="add-leavepayout" class="modal-textarea" required="required">
				 ';
		}
		else
		{
			$output .= "error".$sql."<br>".$conn->error;
		}
	
	 /*$output .= '
				 <input type="text" value="'.$sequence.'" placeholder="Leave Payout ID" name ="leaveid" id="add-leavepayout" class="modal-textarea" required="required">
				 ';*/
	 echo $output;
	
}
else if($_GET["action"]=="leavepayout"){
	 
	
		$leavepayoutid = $_GET["leavepayoutid"];
		$fromdate=$_GET["locfromdate"];
		$todate=$_GET["loctodate"];
		$year=$_GET["locYear"];
		$status=$_GET["locStatus"];

		$_SESSION['leavepayoutid'] = $leavepayoutid;
		$_SESSION['leavepayoutfromdate'] = $fromdate;
		$_SESSION['leavepayouttodate'] = $todate;
		$_SESSION['leavepayoutyear'] = $year;
		$_SESSION['leavepayoutstatus'] = $status;
		//header('location: viewschedule.php');
	//	header('location: shiftype.php');
	
}
else if($_GET["action"]=="poststatus"){


		$id = $_GET["SelectedVal"];

		if($id != ""){
			$sql = "UPDATE leavepayoutheader SET status = '1' where leavepayoutid = '$id' and dataareaid = '$dataareaid'";
			if(mysqli_query($conn,$sql))
			{
				echo "Rec Deleted";
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}

		}
		header('location: leavepayout.php');

}
?>

<script  type="text/javascript">
	  	var so='';
	  	var locPayPer;
		var locYear;
		var locDate;
  		$(document).ready(function(){
			$('#datatbl tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","red");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
				locPayPer = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();
				locYear = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
				locDate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(4)").text();
				so = usernum.toString();
				document.getElementById("hide").value = so;
				//alert(document.getElementById("hide").value);
				//alert(locPayGroup);	
					  
			});
		});
</script>