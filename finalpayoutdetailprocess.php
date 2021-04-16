<?php
session_id("payso");
session_start();
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
$finalpayoutid = $_SESSION['finalpayoutid'];
$locworker = $_SESSION['finalpayoutworker'];
$status = $_SESSION['finalpayoutstatus'];

include("dbconn.php");


if($_GET["action"]=="generate"){

		#$sql = "call generateLeavePayout('$dataareaid','$leavepayoutid', '$userlogin' )";
		#$sql = "call generatethpayout('$dataareaid','$thpayoutid', '$userlogin', '$thpayoutfromdate', '$thpayouttodate', '$thpayoutyear' )";
	$sql = "call generatefinalpayaccounts ('$dataareaid', '$locworker', '$finalpayoutid');";
		if(mysqli_query($conn,$sql))
		{
			echo "Rec Generated";
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}

	//header('location: finalpayoutdetail.php');

}
else if($_GET["action"]=="generateleave"){

	$leavepayoutfromdate = '1990-01-01';
	$leavepayouttodate = '1990-01-01';
	$leavepayoutyear = '';

		#$sql = "call generateLeavePayout('$dataareaid','$leavepayoutid', '$userlogin' )";

		$sql = "call generateleavepayout_V2('$dataareaid','$finalpayoutid', '$userlogin', '$leavepayoutfromdate', '$leavepayouttodate', '$leavepayoutyear', '$locworker', '2' )";
		if(mysqli_query($conn,$sql))
		{
			echo "Rec Generated";
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}

	//header('location: finalpayoutdetail.php');

}

if($_GET["action"]=="generateth"){

	$thpayoutfromdate = '1990-01-01';
	$thpayouttodate = '1990-01-01';
	$thpayoutyear = '';

		#$sql = "call generateLeavePayout('$dataareaid','$leavepayoutid', '$userlogin' )";
		$sql = "call generatethpayout('$dataareaid','$finalpayoutid', '$userlogin', '$thpayoutfromdate', '$thpayouttodate', '$thpayoutyear', '$locworker', '2' )";
		if(mysqli_query($conn,$sql))
		{
			echo "Rec Generated";
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}

	//header('location: finalpayoutdetail.php');

}
else if($_GET["action"]=="generateloan"){

	$leavepayoutfromdate = '1990-01-01';
	$leavepayouttodate = '1990-01-01';
	$leavepayoutyear = '';


		$id=$_GET["SelectedVal"];
	
		 if($id != ""){
		 
				

				$sql = "INSERT into finalloandetails (loanpayoutid,workerid,voucher,loantype,subtype,loandate,loanamount,amortization,balance,cutoffs,interest,fromdate,todate,accountid,dataareaid)
							select '$finalpayoutid',workerid,voucher,loantype,subtype,loandate,loanamount,amortization,balance,cutoffs,interest,fromdate,todate,accountid,dataareaid 
						FROM loanfile where workerid = '$locworker' and voucher in ($id) and dataareaid='$dataareaid'";
				if(mysqli_query($conn,$sql))
				{
					echo $sql;
				}
				else
				{
					echo "error".$sql."<br>".$conn->error;
				}

				$sql2 = "INSERT INTO finalpaydetails
						(finalpayoutid,finalpaytype,workerid,amount,dataareaid)
						select loanpayoutid,'3',workerid,sum(balance)*-1 rate,dataareaid 
			            from finalloandetails 
			            where loanpayoutid = '$finalpayoutid' and workerid = '$locworker' and dataareaid = '$dataareaid'";
				if(mysqli_query($conn,$sql2))
				{
					echo $sql2;
				}
				else
				{
					echo "error".$sql2."<br>".$conn->error;
				}

				$sql3 = "UPDATE finalpayoutheader fh 
						set fh.amount = (select sum(amount) from finalpaydetails where dataareaid = '$dataareaid'
							and finalpayoutid = '$finalpayoutid'
							and workerid = '$locworker')

						where
						fh.dataareaid = '$dataareaid'
			            and fh.finalpayoutid = '$finalpayoutid'
			            and fh.workerid = '$locworker'";
				if(mysqli_query($conn,$sql3))
				{
					echo $sql3;
				}
				else
				{
					echo "error".$sql3."<br>".$conn->error;
				}

				
			

		 }
		 
		header('location: finalpayoutdetail.php');


	//header('location: finalpayoutdetail.php');

}

else if($_GET["action"]=="loan"){
	 	
	
	header('location: loanfileselection.php');
	
}

else if($_GET["action"]=="unloadloan"){
	 	
	
	header('location: finalpayoutdetail.php');
	
}

else if($_GET["action"]=="unload"){
	 	
	unset($_SESSION['finalpayoutid']);
	unset($_SESSION['finalpayoutworker']);
	unset($_SESSION['finalpayoutstatus']);
	unset($_SESSION['finalpayouttype']);
	header('location: finalpayoutdetail.php');
	
}

else if($_GET["action"]=="categ"){
	$act = $_GET["acttype"];
	$output = ''; 
	if($act == '0')
	{
		$output .= '
			<p>
								
				<br><br>
					
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					An employee is entitled to receive a separation pay equivalent to one -
					half (1/2) month pay for every year of service, a fraction of at least six (6)
					months being considered as one (1) whole year, if his/her separation from
					the service is due to any of the following authorized causes:
					<br>
					&nbsp;&nbsp;
					<p>
					1. Retrenchment to prevent losses (i.e., reduction of personnel effected by
					management to prevent losses);
					</p>

					&nbsp;&nbsp;
					<p>
					2. Closure or cessation of operation of an establishment not due to serious
					losses or financial reverses; and
					</p>

					&nbsp;&nbsp;
					<p>
					3. When the employee is suffering from a disease not curable
					within a period of six (6) months and his/her continued employment is
					prejudicial to his/her health or to the health of his/her co -employees.
					</p>

					&nbsp;&nbsp;
					<p>
					4. Lack of service assignment of security guard for a continuous period of six
					(6) months
					</p>
				
			</p>';
	}
	else
	{
		$output .= '
			<p>
								
				<br><br>
					
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					An employee is entitled to separation pay equivalent to his/her onemonth pay for every year of service, a fraction of at least six (6) months
					being considered as one whole year, if his/her separation from service is
					due to any of the following:
					<br>
					&nbsp;&nbsp;
					<p>
					1. Installation by employer of labor-saving devices;
					</p>

					&nbsp;&nbsp;
					<p>
					2.	Redundancy, as when the position of the employee has been found to
						be excessive or unnecessary in the operation of the enterprise; and
					</p>

					&nbsp;&nbsp;
					<p>
					3.	Impossible reinstatement of the employee to his or her former position
						or to a substantially equivalent position for reasons not attributable to
						the fault of the employer, as when the reinstatement ordered by a
						competent authority cannot be implemented due to closure or cessation
						of operations of the establishment/employer, or the position to which he
						or she is to be reinstated no longer exists and there is no substantially
						equivalent position in the establishment to which he or she can be
						assigned. 
					</p>

					&nbsp;&nbsp;
					<p>
					4. Lack of service assignment of security guard by reason of age
					</p>
				
			</p>';
	}
	
	echo $output;
	
}

else if($_GET["action"]=="delete"){

	$payoutid=$_GET["payoutid"];
	$workerval=$_GET["workerval"];
	if($payoutid != ""){
		if($_GET["actmode"]=="deletefinalpay"){	

			$sqldelete = "DELETE from finalpaysaccounts where finalpayoutid = '$payoutid' and dataareaid = '$dataareaid' and workerid = '$workerval'";

				if(mysqli_query($conn,$sqldelete))
				{
					echo "Rec Deleted";
				}
				else
				{
					echo "error".$sqldelete."<br>".$conn->error;
				}

				$sqldelete = "DELETE from finalpaydetails where finalpaytype = '0' and finalpayoutid = '$payoutid' and dataareaid = '$dataareaid' and workerid = '$workerval' ";

				if(mysqli_query($conn,$sqldelete))
				{
					echo "Rec Deleted";
				}
				else
				{
					echo "error".$sqldelete."<br>".$conn->error;
				}

		}
		else if($_GET["actmode"]=="deleteleavepay"){	

					$sql = "UPDATE
						leavefile  lf


						left join leavepayoutdetail lp on lf.workerid = lp.workerid and lf.dataareaid = lp.dataareaid
						and lp.leavetype = lf.leavetype and lp.refrecid = lf.recid

						set lf.balance = lp.leavecredits

						where
						
						lp.leavepayoutid = '$payoutid' and lp.workerid = '$workerval' and lp.dataareaid = '$dataareaid'
						and lp.leavecredits IS NOT NULL
						";
					if(mysqli_query($conn,$sql))
					{
						$sqldelete = "DELETE from leavepayoutdetail where leavepayoutid = '$payoutid' and dataareaid = '$dataareaid' and workerid = '$workerval'";

						if(mysqli_query($conn,$sqldelete))
						{
							echo "Rec Deleted";
						}
						else
						{
							echo "error".$sqldelete."<br>".$conn->error;
						}

						$sqldelete = "DELETE from finalpaydetails where finalpaytype = '1' and finalpayoutid = '$payoutid' and dataareaid = '$dataareaid' and workerid = '$workerval' ";

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


		}
		else if($_GET["actmode"]=="deletethpay"){	

			$sqldelete = "DELETE from thmonthpayoutdetails where thmonthpayoutid = '$payoutid' and dataareaid = '$dataareaid' and workerid = '$workerval'";

				if(mysqli_query($conn,$sqldelete))
				{
					echo "Rec Deleted";
				}
				else
				{
					echo "error".$sqldelete."<br>".$conn->error;
				}

				$sqldelete = "DELETE from finalpaydetails where finalpaytype = '2' and finalpayoutid = '$payoutid' and dataareaid = '$dataareaid' and workerid = '$workerval' ";

				if(mysqli_query($conn,$sqldelete))
				{
					echo "Rec Deleted";
				}
				else
				{
					echo "error".$sqldelete."<br>".$conn->error;
				}

		}

		else if($_GET["actmode"]=="deleteloan"){	

			$sqldelete = "DELETE from finalloandetails where loanpayoutid = '$payoutid' and dataareaid = '$dataareaid' and workerid = '$workerval'";

				if(mysqli_query($conn,$sqldelete))
				{
					echo "Rec Deleted";
				}
				else
				{
					echo "error".$sqldelete."<br>".$conn->error;
				}

				$sqldelete = "DELETE from finalpaydetails where finalpaytype = '3' and finalpayoutid = '$payoutid' and dataareaid = '$dataareaid' and workerid = '$workerval' ";

				if(mysqli_query($conn,$sqldelete))
				{
					echo "Rec Deleted";
				}
				else
				{
					echo "error".$sqldelete."<br>".$conn->error;
				}

		}

		$sql3 = "UPDATE finalpayoutheader fh 
						set fh.amount = (select sum(amount) from finalpaydetails where dataareaid = '$dataareaid'
							and finalpayoutid = '$finalpayoutid'
							and workerid = '$locworker')

						where
						fh.dataareaid = '$dataareaid'
			            and fh.finalpayoutid = '$finalpayoutid'
			            and fh.workerid = '$locworker'";
				if(mysqli_query($conn,$sql3))
				{
					echo $sql3;
				}
				else
				{
					echo "error".$sql3."<br>".$conn->error;
				}
		
	
	}
	header('location: finalpayoutdetail.php');
}



?>

<!-- <script  type="text/javascript">
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
</script> -->