<?php
session_start();
session_regenerate_id();
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
include("dbconn.php");


if(isset($_GET["save"])) {
	 
	 $workerid=$_GET["WKId"];
	 $finalpayid=$_GET["finalpayid"];
	 
	 if($workerid != ""){
	 $sql = "INSERT INTO finalpayoutheader (finalpayoutid,workerid,rate,payouttype,status,amount,dataareaid,createdby,createddatetime)
	 		values ('$finalpayid','$workerid',0,0,0,0,'$dataareaid','$userlogin',now())
			";
		if(mysqli_query($conn,$sql))
		{
			echo $sql;
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}

	 }
	 /*
			SELECT '$finalpayid',ct.workerid,ct.rate,0,0,0,'$dataareaid','$userlogin',now()

									FROM contract ct
									left join worker wk on wk.workerid = ct.workerid
									and wk.dataareaid = ct.dataareaid
									left join ratehistory rh  on 
									rh.contractid = ct.contractid and rh.dataareaid = ct.dataareaid
								where ct.dataareaid = '$dataareaid' and ct.workerid = '$workerid'
									and rh.status = 1
								order by ct.contractid asc
	 */
header('location: finalpayout.php');
	
}
else if($_GET["action"]=="searchdata"){
	if($_GET["actmode"]=="userform"){

		$id=$_GET["PayId"];
		$PayWorker=$_GET["PayWorker"];
		$PayWorkername=$_GET["PayWorkername"];
		$PayType=$_GET["PayType"];
		//$name=$_GET["PrivName"];
		
		$output='';
		//$output .= '<tbody>';
		$query = "SELECT fp.finalpayoutid,fp.workerid,wk.name,fp.rate
					,case when payouttype = 0 then 'Final Pay' when payouttype = 1 then 'Separation Pay' else 'Retirement' end as paytype
					,case when status = 1 then 'Posted' else 'Created' end as statustxt,status,amount

					 FROM finalpayoutheader fp
					left join worker wk on wk.workerid = fp.workerid and wk.dataareaid = fp.dataareaid

					where fp.dataareaid = '$dataareaid'
						 and (case when payouttype = 0 then 'Final Pay' when payouttype = 1 then 'Separation Pay' else 'Retirement' end) like '%$PayType%'
						 and fp.workerid like '%$PayWorker%' and wk.name like '%$PayWorkername%'
						 and fp.finalpayoutid like '%$id%'
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
			<tr id="'.$row["finalpayoutid"].'" class="'.$rowclass.'" tabindex="'.$rowcnt2.'" >
				<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
				<td style="width:14%;">'.$row["finalpayoutid"].'</td>
				<td style="width:14%;">'.$row["workerid"].'</td>
				<td style="width:14%;">'.$row["name"].'</td>
				
				<td style="width:14%;">'.$row["paytype"].'</td>
				<td style="width:14%;">'.$row["statustxt"].'</td>
				<td style="width:14%;">'.$row["amount"].'</td>
				<td style="display:none;width:1%;">'.$row['status'].'</td>
			</tr>';
			$firstresult2 = $row["finalpayoutid"];
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
	 $query = "SELECT * FROM numbersequence where dataareaid = '$dataareaid' and id='finalpayout'";
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
				WHERE id = 'finalpayout'
				and dataareaid = '$dataareaid'";
	 //mysqli_query($conn,$sql);	
		if(mysqli_query($conn,$sql))
		{
			$output .= '
				 <input type="text" value="'.$sequence.'" placeholder="Final Payout ID" name ="finalpayid" id="add-finalpayout" class="modal-textarea" required="required">
				 ';
		}
		else
		{
			$output .= "error".$sql."<br>".$conn->error;
		}
	 
	 /*$output .= '
				 <input type="text" value="'.$sequence.'" placeholder="Final Payout ID" name ="finalpayid" id="add-finalpayout" class="modal-textarea" required="required">
				 ';*/
	 echo $output;
	
}
else if($_GET["action"]=="finalpayout"){
	 
	
		$finalpayoutid = $_GET["finalpayoutid"];
		$locworker=$_GET["locworker"];
		$status=$_GET["locStatus"];
		$loctype=$_GET["locType"];

		$_SESSION['finalpayoutid'] = $finalpayoutid;
		$_SESSION['finalpayoutworker'] = $locworker;
		$_SESSION['finalpayoutstatus'] = $status;
		$_SESSION['finalpayouttype'] = $loctype;
		//header('location: viewschedule.php');
	//	header('location: shiftype.php');
	
}
else if($_GET["action"]=="poststatus"){


		$id = $_GET["SelectedVal"];

		if($id != ""){
			$sql = "UPDATE finalpayoutheader SET status = '1' where finalpayoutid = '$id' and dataareaid = '$dataareaid'";
			if(mysqli_query($conn,$sql))
			{
				echo "Rec Deleted";
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}

		}
		header('location: finalpayout.php');

}
?>

<!-- <script  type="text/javascript">
	  	var so='';
		var locworker;
		var locStatus;
  		$(document).ready(function(){
			$('#datatbl tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","red");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
				locworker = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
				//locfromdate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();
				//loctodate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(4)").text();
				locStatus = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(8)").text();
				//stats = locStatus.toString();
				so = usernum.toString();
				document.getElementById("hide").value = so;
				//alert(document.getElementById("hide").value);
				//alert(locStatus);	
					  
			});
		});
</script> -->