<?php

session_start();
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
$conid = $_SESSION['contract'];
$wkid = $_SESSION['ConNum'];
include("dbconn.php");

if(isset($_GET["save"])) {
	 

	$rate=$_GET["RFrate"];
	$mrate=$_GET["RFmrate"];
	$actmrate=$_GET["actrate"];
	$transpo=$_GET["RFtranspo"];
	$meal=$_GET["RFmeal"];
	$fromdate=$_GET["RFfromdate"];
	$todate=$_GET["RFtodate"];
	
	if($todate == '')
	 {
	 	$todate = '1900-01-01';
	 }
	 
	 if($conid != ""){
	 $query2 = "SELECT 
				max(ct.linenum) as linenum
				FROM ratehistory ct
				where ct.dataareaid = '$dataareaid' and ct.contractid = '$conid'";
	$result2 = $conn->query($query2);
	$row2 = $result2->fetch_assoc();
	$lastval = $row2["linenum"];
	$maxval = $lastval + 1; 

	 $sql = "INSERT INTO ratehistory (contractid,rate,ecola,mrate,activemrate,transpo,meal,fromdate,todate,status,linenum,dataareaid,createdby,createddatetime)
			values 
			('$conid','$rate','0.00','$mrate','$actmrate','$transpo','$meal','$fromdate','$todate','0','$maxval', '$dataareaid', '$userlogin', now())";
		if(mysqli_query($conn,$sql))
		{
			echo "New Rec Created";
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}

	 }
	 
	header('location: rateform.php');
	
}
else if(isset($_GET["update"])) {
	 
	$rate=$_GET["RFrate"];
	$mrate=$_GET["RFmrate"];
	$actmrate=$_GET["actrate"];
	$transpo=$_GET["RFtranspo"];
	$meal=$_GET["RFmeal"];
	$fromdate=$_GET["RFfromdate"];
	$todate=$_GET["RFtodate"];
	$linenum=$_GET["RFline"];
	 
	 if($conid != ""){
	 $sql = "UPDATE ratehistory SET
				rate = '$rate',
				mrate = '$mrate',
				activemrate = '$actmrate',
				transpo = '$transpo',
				meal = '$meal',
				fromdate = '$fromdate',
				todate = '$todate',
				modifiedby = '$userlogin',
				modifieddatetime = now()
				WHERE contractid = '$conid'
				and linenum = '$linenum'
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
	 
	header('location: rateform.php');
	
}
else if($_GET["action"]=="delete"){
	 
	if($_GET["actmode"]=="userform"){	
		$id=$_GET["RFline"];

		if($id != ""){
			$sql = "DELETE from ratehistory where contractid = '$conid'
				and linenum = '$id' and dataareaid = '$dataareaid'";
			if(mysqli_query($conn,$sql))
			{
				echo "Rec Deleted";
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}

		}
		header('location: rateform.php');
	
	}
}
else if($_GET["action"]=="activate"){
	 
	if($_GET["actmode"]=="userform"){	
		//$id=$_GET["RFline"];

		if($conid != ""){
			$sql = "call rateactivation('$conid','$dataareaid','$userlogin','$wkid')";
			if(mysqli_query($conn,$sql))
			{
				echo "Rec Activated";
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}

		}
		header('location: rateform.php');
	
	}
}
else if($_GET["action"]=="searchdata"){
	if($_GET["actmode"]=="userform"){
		$id=$_GET["slocWorkerId"];
		$name=$_GET["slocName"];
		$voucher=$_GET["slocVoucher"];
		$output='';
		//$output .= '<tbody>';
		$query = "SELECT 
					lf.workerid,wk.name,lf.voucher,lf.subtype,lf.loantype,STR_TO_DATE(lf.loandate, '%Y-%m-%d') loandate,format(lf.loanamount,2) as loanamount,
					format(lf.amortization,2) as amortization,format(lf.balance,2) as balance,STR_TO_DATE(lf.fromdate, '%Y-%m-%d') as fromdate
					,STR_TO_DATE(lf.todate, '%Y-%m-%d') as todate,lf.accountid,acc.name as accname,lf.accountid
					FROM 
					loanfile lf
					left join worker wk on wk.workerid	= lf.workerid and wk.dataareaid = lf.dataareaid
					left join accounts acc on acc.accountcode = lf.accountid and acc.dataareaid = lf.dataareaid

					where lf.dataareaid = '$dataareaid' and wk.inactive = 0 and (lf.workerid like '%$id%') and (wk.name like '%$name%') and (lf.voucher like '%$voucher%')

					order by lf.workerid";
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
				<td style="width:8%;">'.$row["workerid"].'</td>
				<td style="width:12%;">'.$row["name"].'</td>
				<td style="width:9%;">'.$row["voucher"].'</td>
				<td style="width:8%;">'.$row["subtype"].'</td>
				<td style="width:7%;">'.$row["loantype"].'</td>
				<td style="width:8%;">'.$row["accname"].'</td>
				<td style="width:8%;">'.$row["loandate"].'</td>
				<td style="width:8%;">'.$row["loanamount"].'</td>
				<td style="width:8%;">'.$row["amortization"].'</td>
				<td style="width:8%;">'.$row["balance"].'</td>
				<td style="width:8%;">'.$row["fromdate"].'</td>
				<td style="width:8%;">'.$row["todate"].'</td>
				<td style="display:none;width:1%;">'.$row["accountid"].'</td>
			</tr>';
		}
		//$output .= '</tbody>';
		echo $output;
		//header('location: process.php');
	}
}
else if($_GET["action"]=="contract"){
	 	
	//$id=$_GET["WorkId"];
	//$_SESSION['paynum'] = $id;
	//unset($_SESSION['paynum']);
	header('location: contractform.php');
	
}
else if($_GET["action"]=="rate"){
	 	
	$id=$_GET["WorkId"];
	$_SESSION['contract'] = $id;
	//unset($_SESSION['paynum']);
	header('location: contractform.php');
	
}
?>

<script  type="text/javascript">
		var so='';
	  	//var locWorkerId = "";
		var locName = "";
		var locVoucher = "";
		var locSubtype = "";
		var locLoantype = "";
		var locAccount = "";
		var locLoandate = "";
		var locLoanamount = "";
		var locAmortization = "";
		var locBalance = "";
		var locFromdate = "";
		var locTodate = "";
  		$(document).ready(function(){
			$('#datatbl tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","red");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
				locVoucher = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();
				locSubtype = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(4)").text();
				locLoantype = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(5)").text();
				locAccount = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(13)").text();
				locLoandate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(7)").text();
				locLoanamount = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(8)").text();
				locAmortization = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(9)").text();
				locBalance = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(10)").text();
				locFromdate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(11)").text();
				locTodate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(12)").text();
				so = usernum.toString();
				document.getElementById("hide").value = so;
				//alert(document.getElementById("hide").value);
				//alert(so);	
					  
			});
		});
</script>