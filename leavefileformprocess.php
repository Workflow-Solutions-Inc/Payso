<?php
session_start();
session_regenerate_id();
include("dbconn.php");
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
if(isset($_SESSION['WKNumLeave']))
{
	$wkid = $_SESSION['WKNumLeave'];
}
else
{
	header('location: workerform.php');
}


if(isset($_GET["save"])) {
	 
	$id=$_GET["wkid"];
	$leavetype = $_GET["leavetype"];
	$credit=$_GET["credit"];
	$balance=$_GET["balance"];
	$paid=$_GET["paid"];
	$convert=$_GET["convert"];
	$year=$_GET["yrSelection"];
	$fromdate=$_GET["FromDate"];
	$todate=$_GET["EndDate"];
	 
	 if($id != ""){
	 $sql = "INSERT INTO leavefile (workerid,leavetype,leavecredits,balance,ispaid,isconvertible,year,fromdate,todate,dataareaid,createdby,createddatetime)
			values 
			('$id', '$leavetype', '$credit', '$balance', '$paid', '$convert', '$year', '$fromdate', '$todate', '$dataareaid', '$userlogin', now())";
		if(mysqli_query($conn,$sql))
		{
			echo "New Rec Created";
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}

	 }
	 
	header('location: leavefileform.php');

}
else if(isset($_GET["update"])) {
	
	$id=$_GET["wkid"];
	$leavetype = $_GET["leavetype"];
	$credit=$_GET["credit"];
	$balance=$_GET["balance"];
	$paid=$_GET["paid"];
	$convert=$_GET["convert"];
	$year=$_GET["yrSelection"];
	$fromdate=$_GET["FromDate"];
	$todate=$_GET["EndDate"];
	$recid=$_GET["recid"];
	 
	 if($id != ""){
	 $sql = "UPDATE leavefile SET
				
				leavecredits = '$credit',
				balance = '$balance',
				ispaid = '$paid',
				year = '$year',
				isconvertible = '$convert',
				fromdate = '$fromdate',
				todate = '$todate',
				modifiedby = '$userlogin',
				modifieddatetime = now()
				WHERE workerid = '$id'
				and leavetype = '$leavetype'
				and dataareaid = '$dataareaid'
				and recid = '$recid'
				";
		if(mysqli_query($conn,$sql))
		{
			echo "Rec Updated";
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}

	 }
	 
	header('location: leavefileform.php');
		
}
else if($_GET["action"]=="delete"){
	 
	if($_GET["actmode"]=="userform"){	
		
		$leavetype = $_GET["leavetype"];
		$id=$_GET["wkid"];
		$recid = $_GET["locrecid"];
		

		if($id != ""){
			$sql = "DELETE from leavefile where workerid = '$id'
				and leavetype = '$leavetype'
				and recid = '$recid'
				and dataareaid = '$dataareaid'";
			if(mysqli_query($conn,$sql))
			{
				echo "Rec Deleted";
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}

		}
		header('location: leavefileform.php');
	
	}
}
else if($_GET["action"]=="searchdata"){
	if($_GET["actmode"]=="userform"){
		$id=$_GET["loctype"];
		$desc=$_GET["locname"];
		
		
		$output='';
		//$output .= '<tbody>';
		$query = "SELECT lf.leavetype,lt.description,format(lf.leavecredits,2) leavecredits,format(lf.balance,2) balance,lf.ispaid,lf.isconvertible
							,lf.year,lf.fromdate,lf.todate ,lf.recid
					FROM leavefile lf
					left join leavetype lt on lt.leavetypeid = lf.leavetype 
 				where (lf.leavetype like '%$id%') and (lt.description like '%$desc%') and lf.dataareaid = '$dataareaid' and lf.workerid = '$wkid'";
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
			<tr id="'.$row["leavetype"].'" class="'.$rowclass.'" tabindex="'.$rowcnt2.'" >
				<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
				<td style="width:14%;">'.$row["leavetype"].'</td>
				<td style="width:14%;">'.$row["description"].'</td>
				<td style="width:14%;">'.$row["leavecredits"].'</td>
				<td style="width:14%;">'.$row["year"].'</td>
				<td style="width:14%;">'.$row["fromdate"].'</td>
				<td style="width:14%;">'.$row["todate"].'</td>
				<td style="width:14%;">'.$row["balance"].'</td>
				<td style="width:5%;"><input type="checkbox" name="chkbox" class="checkbox" value="true"'.($row["ispaid"]==1 ? "checked" : "").' onclick="return false;"><div style="visibility:hidden;height: 1px;">'.$row["ispaid"].'</div></td>
				<td style="width:5%;"><input type="checkbox" name="chkbox" class="checkbox" value="true"'.($row["isconvertible"]==1 ? "checked" : "").' onclick="return false;"><div style="visibility:hidden;height: 1px;">'.$row["isconvertible"].'</div></td>
				<td style="display:none;width:1%;">'.$row['recid'].'</td>
			</tr>';
		}
		//$output .= '</tbody>';
		echo $output;
		//header('location: process.php');
	}
}
else if($_GET["action"]=="unload"){
	 	
	unset($_SESSION['WKNumLeave']);
	//unset($_SESSION['paynum']);
	header('location: leavefileform.php');
	
}
?>

<script  type="text/javascript">
		var so='';
	  	var loctype;
		var locdesc;
		var loccredit;
		var locbal;
		var locpaid;
		var locyear;
		var locfromdate;
		var loctodate;
		var locrecid;
		var locconv;
  		$(document).ready(function(){
			$('#datatbl tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","red");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
				locdesc = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
				loccredit = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();
				locyear = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(4)").text();
				locfromdate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(5)").text();
				loctodate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(6)").text();
				locbal = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(7)").text();
				locpaid = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(8)").text();
				locconv = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(9)").text();
				locrecid = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(10)").text();
				so = usernum.toString();
				document.getElementById("hide").value = so;
				//alert(document.getElementById("hide").value);
				//alert(so);	
					  
			});
		});

</script>