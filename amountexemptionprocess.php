<?php
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
session_start();
include("dbconn.php");
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];

$EXpaynum = $_SESSION['EXpaynum'];
//$EXpaynum = 'ADMOPY0000003';



if($_GET["action"]=="exclude"){
	 
	 $SelWkid = $_GET["SelworkId"];
	 $SelectedAcc = $_GET["SelectedAcc"];
	$PayDate = $_GET["PayDate"];

	 $accountcode2 = '';
	 $avalue2 = '';
	 
	 if($SelectedAcc != ""){
	 	$query2 = "SELECT * from payrolldetails pd 
			left join payrolldetailsaccounts pa on pd.payrollid = pa.payrollid and pd.linenum = pa.reflinenum and pd.dataareaid = pa.dataareaid
			where pd.payrollid = '$EXpaynum' and pd.dataareaid = '$dataareaid' and pd.workerid = '$SelWkid' 
			and pa.accountcode in ($SelectedAcc)
			order by pa.priority asc";

		$result2 = $conn->query($query2);
		
		while ($row2 = $result2->fetch_assoc())
		{
			$accountcode2 = $row2["accountcode"];
			$avalue2 = $row2["value"];

			$query3 = "INSERT into excludedpayment (refpayrollid,workerid,paymentdate,excludeddate,accountcode,amount,dataareaid) 
						values ('$EXpaynum','$SelWkid','$PayDate',curdate(),'$accountcode2','$avalue2','$dataareaid') ";
			if(mysqli_query($conn,$query3))
			{
				echo "New Rec Created";
			}
			else
			{
				echo "error ".$query3."<br>".$conn->error;
			}

			 $query = "call SP_ExcludedAmount('$EXpaynum','$userlogin','$dataareaid','$SelWkid','$accountcode2',1)";
				if(mysqli_query($conn,$query))
					{
						echo "New Rec Created";
					}
					else
					{
						echo "error ".$query."<br>".$conn->error;
					}
			
		}

	 }
	 header('location: amountexemption.php');
	/*else{
		$querys = "INSERT into excludedpayment (refpayrollid,workerid,paymentdate,excludeddate,accountcode,amount,dataareaid) 
				values ('$EXpaynum','$SelWkid',curdate(),curdate(),'$accountcode','$avalue','$dataareaid')";

		if(mysqli_query($conn,$querys))
		{
			echo "New Rec Created";
		}
		else
		{
			echo "error ".$querys."<br>".$conn->error;
		}

	
		$_SESSION['paylinenum'] = $SelWkid;
		header('location: amountexemptionline.php');

	}*/
	 	//$_SESSION['paylinenum'] = $line;
	//	header('location: payrolltransactiondetailline.php');
	//header('location: payrolltransactiondetail.php'); 
			
}
else if($_GET["action"]=="update"){
	 

	//$id = $_GET["SelectedVal"];
	//$accountcode = $_GET["accountcode"];


	
	$excludenum = $_GET["excludenum"];

	$evalue = $_GET["evalue"];

	//$newvalue = $evalue - $excludenum;

	
	$SelWkid = $_GET["SelworkId"];
	$SelectedAcc = $_GET["SelectedAcc"];
	$edate = $_GET["edate"];
	

	$reflinenum = '';

	if($SelWkid != ""){
		
		$query = "SELECT * from payrolldetails pd 
			left join payrolldetailsaccounts pa on pd.payrollid = pa.payrollid and pd.linenum = pa.reflinenum and pd.dataareaid = pa.dataareaid
			where pd.payrollid = '$EXpaynum' and pd.dataareaid = '$dataareaid' and pd.workerid = '$SelWkid' 
			and pa.accountcode = '$SelectedAcc'
			order by pa.priority asc";
		$result = $conn->query($query);
		//echo "error ".$query;
		while ($row = $result->fetch_assoc())
		{

			$reflinenum = $row["reflinenum"];

		}

		$sqlupdate = "UPDATE payrolldetailsaccounts SET
				value = value - $excludenum,
				modifiedby = '$userlogin',
				modifieddatetime = now()
				WHERE accountcode = '$SelectedAcc'
				and payrollid = '$EXpaynum'
				and reflinenum = '$reflinenum'
				and dataareaid = '$dataareaid'";

		if(mysqli_query($conn,$sqlupdate))
		 	{
		 		echo "Rec Updated";
		 	}
		 	else
		 	{
		 		echo "error ".$sqlupdate."<br>".$conn->error;
		 	}

		/* $sql = "UPDATE payrolldetailsaccounts pa
		 		left join payrolldetails pd on
		 		pd.payrollid = pa.payrollid and
		 		pd.linenum = pa.reflinenum and
		 		pd.dataareaid = pa.dataareaid
		 		SET pa.value = '$newvalue'
		 		where pd.workerid = '$SelWkid' and pa.payrollid = '$EXpaynum' and pa.accountcode = '$SelectedAcc' and pa.dataareaid = '$dataareaid'";*/

		 


	 $sql2 = "INSERT into excludedpayment (refpayrollid,workerid,paymentdate,excludeddate,accountcode,amount,dataareaid) 
				values ('$EXpaynum','$SelWkid','$edate',curdate(),'$SelectedAcc','$excludenum','$dataareaid')";

		if(mysqli_query($conn,$sql2))
			{
				echo "New Rec Created";
			}
			else
			{
				echo "error ".$sql2."<br>".$conn->error;
			}

	}
	header('location: amountexemption.php');

}
else if($_GET["action"]=="include"){
	 
	 $SelWkid = $_GET["SelworkId"];
	 $SelectedAcc = $_GET["SelectedAcc"];
	 //$line=$_GET["PTline"];
	 $accountcode = '';
	 $INCaccountcode = '';
	 $reflinenum = '';
	if($SelectedAcc != ""){

	$query = "SELECT * from payrolldetails pd 
			left join payrolldetailsaccounts pa on pd.payrollid = pa.payrollid and pd.linenum = pa.reflinenum and pd.dataareaid = pa.dataareaid
			where pd.payrollid = '$EXpaynum' and pd.dataareaid = '$dataareaid' and pd.workerid = '$SelWkid' 
			and pa.accountcode in ($SelectedAcc)
			order by pa.priority asc";

		$result = $conn->query($query);
		if($result->num_rows != 0){

			echo "Exist";
			while ($row = $result->fetch_assoc())
			{
				$accountcode = $row["accountcode"];
				$reflinenum = $row["reflinenum"];

				$INCquery = "SELECT * from excludedpayment
					where refpayrollid = '$EXpaynum' and dataareaid = '$dataareaid' and workerid = '$SelWkid' 
					and accountcode = '$accountcode'";

					$INCresult = $conn->query($INCquery);
					while ($INCrow = $INCresult->fetch_assoc())
					{
						$amount = $INCrow["amount"];
					}


				$sqlupdate = "UPDATE payrolldetailsaccounts SET
				value = value + $amount,
				modifiedby = '$userlogin',
				modifieddatetime = now()
				WHERE accountcode = '$accountcode'
				and payrollid = '$EXpaynum'
				and reflinenum = '$reflinenum'
				and dataareaid = '$dataareaid'";

				if(mysqli_query($conn,$sqlupdate))
				 	{
				 		echo "Rec Updated";
				 	}
				 	else
				 	{
				 		echo "error ".$sqlupdate."<br>".$conn->error;
				 	}

				$sqlDelete = "DELETE from excludedpayment
				WHERE accountcode = '$accountcode'
				and refpayrollid = '$EXpaynum'
				and workerid = '$SelWkid'
				and dataareaid = '$dataareaid'";

				if(mysqli_query($conn,$sqlDelete))
				 	{
				 		echo "Rec Updated";
				 	}
				 	else
				 	{
				 		echo "error ".$sqlDelete."<br>".$conn->error;
				 	}
			}

		}
		

			
			$INCquery = "SELECT * from excludedpayment where refpayrollid = '$EXpaynum' and workerid = '$SelWkid'
				and accountcode not in (SELECT pa.accountcode 
					from payrolldetails pd 
					left join payrolldetailsaccounts pa on pd.payrollid = pa.payrollid and pd.linenum = pa.reflinenum and pd.dataareaid = pa.dataareaid
					where pd.payrollid = '$EXpaynum' and pd.dataareaid = '$dataareaid' and pd.workerid = '$SelWkid' )";
			 
			 

			$INCresult = $conn->query($INCquery);
			while ($INCrow = $INCresult->fetch_assoc())
			{
				$INCaccountcode = $INCrow["accountcode"];

				$query2 = "call SP_ExcludedAmount('$EXpaynum','$userlogin','$dataareaid','$SelWkid','$INCaccountcode',0)";
				if(mysqli_query($conn,$query2))
					{
						echo "New Rec Created";
					}
					else
					{
						echo "error ".$query2."<br>".$conn->error;
					}

			

		}
	}
	header('location: amountexemption.php');

			
}

else if($_GET["action"]=="unload"){
	 	
	unset($_SESSION['EXpaynum']);
	//unset($_SESSION['paynum']);
	header('location: amountexemption.php');
	
}

?>

<script  type="text/javascript">
		var so='';
	  	var payline='';
  		$(document).ready(function(){
			$('#datatbl tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","red");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
				so = usernum.toString();
				document.getElementById("hide").value = so;
				//alert(document.getElementById("hide").value);
				//alert(so);
				//-----------get line--------------//
				var action = "getline";
				var actionmode = "userform";
				$.ajax({
					type: 'POST',
					url: 'amountexemptionline.php',
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
		});

	  		/*$(document).ready(function(){
				$('#dataln tbody tr').click(function(){
					$('table tbody tr').css("color","black");
					$(this).css("color","orange");
					$('table tbody tr').removeClass("info");
					$(this).addClass("info");
					var transnumline = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(1)").text();
					var payline = transnumline.toString();
					document.getElementById("hide2").value = payline;
					//alert(document.getElementById("hide").value);
						
						  
				});
			});*/
</script>