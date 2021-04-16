<?php
session_id("payso");
session_start();
include("dbconn.php");
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];


if(isset($_GET["save"])) {
	 
	 $id=$_GET["PTid"];
	 $branch=$_GET["PTBranch"];
	 $period=$_GET["PTPeriod"];
	 $type=$_GET["PTType"];

	 $query = "SELECT 
				date_format(startdate, '%Y-%m-%d') startdate,
				date_format(enddate, '%Y-%m-%d') enddate
				FROM payrollperiod where dataareaid = '$dataareaid' 
				and payrollperiod = '$period'";
				//and (module like '%$module%') and (submodule like '%$sub%') and (name like '%$name%')";
	$result = $conn->query($query);
	$row = $result->fetch_assoc();
	$startdate=$row["startdate"];
	$enddate=$row["enddate"];
	 
	 if($id != ""){
	 $sql = "INSERT INTO payrollheader (payrollid,branchcode,payrollperiod,payrollstatus,fromdate,todate,paymenttype,dataareaid,createdby,createddatetime)
			values 
			('$id', '$branch', '$period', '0', '$startdate', '$enddate', '$type', '$dataareaid', '$userlogin', now())";
		if(mysqli_query($conn,$sql))
		{
			echo "New Rec Created";
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}

	 }
	 
	header('location: payrolltransaction.php');
	
}
if($_GET["action"]=="update"){
	 
	if($_GET["actmode"]=="userform"){
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
		$branch=$_GET["PTBranch"];
		$id=$_GET["PTId"];
		$type=$_GET["PTPayment"];
		$period=$_GET["PTPeriod"];
		$fromdate=$_GET["PTFromDt"];
		$todate=$_GET["PTToDt"];
		$firstresult ='';
		$output='';
		//$output .= '<tbody>';
		if($fromdate != '' && $todate == '')
		{
			$query = "SELECT bh.name as branch,  
						case              
							when paymenttype = 0 then 'Cash' 
							when paymenttype = 1 then 'ATM' 
						else '' end as 'Payment',
						ph.payrollid, 
						ph.payrollperiod,
						fromdate, 
						todate,
						case when payrollstatus = 0 then 'Created' 
							when payrollstatus = 1 then 'Submitted' 
							when payrollstatus = 2 then 'Canceled' 
							when payrollstatus = 3 then 'Approved' 
							when payrollstatus = 4 then 'Disapproved' 
						else '' end as 'status',
						payrollstatus

						from payrollheader ph 
						left join branch bh on ph.branchcode = bh.branchcode and ph.dataareaid = bh.dataareaid
						 where (bh.name like '%$branch%') and (ph.payrollid like '%$id%') and (ph.payrollperiod like '%$period%') 
						 and fromdate = '$fromdate'
						 #and (todate like '%$todate%') 
						 and (case              
							when paymenttype = 0 then 'Cash' 
							when paymenttype = 1 then 'ATM' 
							else '' end) like '%$type%'
						 and ph.dataareaid = '$dataareaid'";
		}
		else if ($todate != '' && $fromdate == '')
		{
			$query = "SELECT bh.name as branch,  
						case              
							when paymenttype = 0 then 'Cash' 
							when paymenttype = 1 then 'ATM' 
						else '' end as 'Payment',
						ph.payrollid, 
						ph.payrollperiod,
						fromdate, 
						todate,
						case when payrollstatus = 0 then 'Created' 
							when payrollstatus = 1 then 'Submitted' 
							when payrollstatus = 2 then 'Canceled' 
							when payrollstatus = 3 then 'Approved' 
							when payrollstatus = 4 then 'Disapproved' 
						else '' end as 'status',
						payrollstatus

						from payrollheader ph 
						left join branch bh on ph.branchcode = bh.branchcode and ph.dataareaid = bh.dataareaid
						 where (bh.name like '%$branch%') and (ph.payrollid like '%$id%') and (ph.payrollperiod like '%$period%') 
						 #and fromdate = '$fromdate'
						 and todate = '$todate'
						 and (case              
							when paymenttype = 0 then 'Cash' 
							when paymenttype = 1 then 'ATM' 
							else '' end) like '%$type%'
						 and ph.dataareaid = '$dataareaid'";
		}
		else if($todate != '' && $fromdate != '')
		{
			$query = "SELECT bh.name as branch,  
						case              
							when paymenttype = 0 then 'Cash' 
							when paymenttype = 1 then 'ATM' 
						else '' end as 'Payment',
						ph.payrollid, 
						ph.payrollperiod,
						fromdate, 
						todate,
						case when payrollstatus = 0 then 'Created' 
							when payrollstatus = 1 then 'Submitted' 
							when payrollstatus = 2 then 'Canceled' 
							when payrollstatus = 3 then 'Approved' 
							when payrollstatus = 4 then 'Disapproved' 
						else '' end as 'status',
						payrollstatus

						from payrollheader ph 
						left join branch bh on ph.branchcode = bh.branchcode and ph.dataareaid = bh.dataareaid
						 where (bh.name like '%$branch%') and (ph.payrollid like '%$id%') and (ph.payrollperiod like '%$period%') 
						 and fromdate = '$fromdate'
						 and todate = '$todate'
						 and (case              
							when paymenttype = 0 then 'Cash' 
							when paymenttype = 1 then 'ATM' 
							else '' end) like '%$type%'
						 and ph.dataareaid = '$dataareaid'";
		}
		else
		{
			$query = "SELECT bh.name as branch,  
						case              
							when paymenttype = 0 then 'Cash' 
							when paymenttype = 1 then 'ATM' 
						else '' end as 'Payment',
						ph.payrollid, 
						ph.payrollperiod,
						date_format(fromdate, '%m-%d-%Y') fromdate, 
						date_format(todate, '%m-%d-%Y') todate,
						case when payrollstatus = 0 then 'Created' 
							when payrollstatus = 1 then 'Submitted' 
							when payrollstatus = 2 then 'Canceled' 
							when payrollstatus = 3 then 'Approved' 
							when payrollstatus = 4 then 'Disapproved' 
						else '' end as 'status',
						payrollstatus

						from payrollheader ph 
						left join branch bh on ph.branchcode = bh.branchcode and ph.dataareaid = bh.dataareaid
						 where (bh.name like '%$branch%') and (ph.payrollid like '%$id%') and (ph.payrollperiod like '%$period%') 
						 #and fromdate = '$fromdate'
						 #and todate = '$todate'
						 and (case              
							when paymenttype = 0 then 'Cash' 
							when paymenttype = 1 then 'ATM' 
							else '' end) like '%$type%'
						 and ph.dataareaid = '$dataareaid'";
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
			<tr id="'.$rowcnt2.'" class="'.$rowclass.'" tabindex="'.$rowcnt2.'">
				<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
				<td style="width:18%;">'.$row["branch"].'</td>
				<td style="width:10%;">'.$row["Payment"].'</td>
				<td style="width:14%;">'.$row["payrollid"].'</td>
				<td style="width:14%;">'.$row["payrollperiod"].'</td>
				<td style="width:14%;">'.$row["fromdate"].'</td>
				<td style="width:14%;">'.$row["todate"].'</td>
				<td style="width:14%;">'.$row["status"].'</td>
				<td style="display:none;width:1%;">'.$row["payrollstatus"].'</td>
			</tr>';
		}
		//$output .= '</tbody>';
		echo $output;
		$result2 = $conn->query($query);
		$row2 = $result2->fetch_assoc();
		$firstresult = $row2["payrollid"];
		echo $output2 = '<tr class="rowA">
							<td hidden><input type="input" id="hide3" value="'.$firstresult.'"></td>
							<td hidden><input type="input" id="hidecount" value="'.$rowcnt2.'"></td>
						</tr>';
		//header('location: process.php');
	}
}
else if($_GET["action"]=="add"){
	 $output='';
	 $sequence='';
	 $query = "SELECT * FROM numbersequence where dataareaid = '$dataareaid' and id='payroll'";
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
				WHERE id = 'payroll'
				and dataareaid = '$dataareaid'";
	 //mysqli_query($conn,$sql);	
		if(mysqli_query($conn,$sql))
		{
			$output .= '
				 <input type="text" value="'.$sequence.'" placeholder="Payroll ID" name ="PTid" id="add-id" class="modal-textarea" required="required">
				 ';
		}
		else
		{
			$output .= "error".$sql."<br>".$conn->error;
		}
	 
	 
	 echo $output;
	
}
else if($_GET["action"]=="recompute"){
	 

	$id=$_GET["PTid"];

	if($id != ""){
		$query = "SELECT a.accountcode,b.formula
					FROM payrollheaderaccounts a
                    left join accounts b on 
					a.accountcode = b.accountcode and
					a.accounttype = b.accounttype and
					a.dataareaid  = b.dataareaid
					where a.payrollid = '$id'
					and a.dataareaid = '$dataareaid'";

		$result = $conn->query($query);
		$rowclass = "rowA";
		$rowcnt = 0;
		while ($row = $result->fetch_assoc())
		{
			$acc = $row["accountcode"];
			$formula = $row["formula"];

			$query2 = "SELECT sum(value) sumVal from payrolldetailsaccounts 

						WHERE payrollid = '$id'
						and dataareaid = '$dataareaid' 
						and CONCAT('[',accountcode,']')  = '$formula'";
			$result2 = $conn->query($query2);
			$row2 = $result2->fetch_assoc();

			$SumVal = $row2["sumVal"];



			$sql = "UPDATE payrollheaderaccounts SET
					value = '$SumVal',
					modifiedby = '$userlogin',
					modifieddatetime = now()
					WHERE payrollid = '$id'
					and dataareaid = '$dataareaid'
					and accountcode = '$acc'";
			if(mysqli_query($conn,$sql))
			{
				echo $sql."<br>".$conn->error;
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}

		}
		//echo $SumVal;
	//Recompute($id,$paynum,$dataareaid,$conn);	
	//$_SESSION['paylinenum'] = $id;
	//Comment
	//header('location: payrolltransaction.php');
	}
	//$_SESSION['paylinenum'] = $id;
	//header('location: payrolltransactiondetailline.php');
	//header('location: payrolltransactiondetail.php'); 

}
else if($_GET["action"]=="submit"){
	 

	 $id=$_GET["PayId"];
	 
	 
	 if($id != ""){
	 $ValidateQuery = "SELECT payrollstatus FROM payrollheader where dataareaid = '$dataareaid' and payrollid = '$id'";
			$resultVal = $conn->query($ValidateQuery);
			$rowVal = $resultVal->fetch_assoc();
			$PayStatus = $rowVal["payrollstatus"];
			
			if($PayStatus == 0)
			{
				$sql = "UPDATE payrollheader SET
						payrollstatus = '1',
						modifiedby = '$userlogin',
						modifieddatetime = now()
						WHERE payrollid = '$id'
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
			else
			{
				echo "<script type='text/javascript'>alert('Payroll Status must be created only!');</script>";
				//header('location: payrolltransaction.php');
			}
	 

	}
	 
	//header('location: payrolltransaction.php');
	
	
}
else if($_GET["action"]=="approve"){
	 

	 $id=$_GET["PayId"];
	 $period=$_GET["PayPeriod"];
	 
	 if($id != ""){
	 $ValidateQuery = "SELECT payrollstatus FROM payrollheader where dataareaid = '$dataareaid' and payrollid = '$id'";
			$resultVal = $conn->query($ValidateQuery);
			$rowVal = $resultVal->fetch_assoc();
			$PayStatus = $rowVal["payrollstatus"];
			
			if($PayStatus == 1)
			{
				/* select here*/

				$sql = "UPDATE payrollheader SET
						payrollstatus = '3',
						modifiedby = '$userlogin',
						modifieddatetime = now()
						WHERE payrollid = '$id'
						and dataareaid = '$dataareaid'";
				if(mysqli_query($conn,$sql))
				{
					echo "Rec Updated";
					

					$query2 = "SELECT * from payrollperiod where dataareaid = '$dataareaid' and payrollperiod = '$period'";
						$result2 = $conn->query($query2);
						$row2 = $result2->fetch_assoc();
						$cutoff = $row2["period"];
						$payperiod = $row2["payrollperiod"];

						/*if($cutoff == 0)
						{
							$sqlinsert = "call SP_RepositoryTrans('$dataareaid','$id','$userlogin','$payperiod' ,1)";
							if(mysqli_query($conn,$sqlinsert))
							{
								echo $sqlinsert."<br>".$conn->error;
							}
							else
							{
								echo "error".$sqlinsert."<br>".$conn->error;
							}
						}
						else
						{
							$sqlinsert = "call SP_RepositoryTrans('$dataareaid','$id','$userlogin','$payperiod' ,0)";
							if(mysqli_query($conn,$sqlinsert))
							{
								echo $sqlinsert."<br>".$conn->error;
							}
							else
							{
								echo "error".$sqlinsert."<br>".$conn->error;
							}
						}*/

						if($cutoff == 1)
						{
							$sqlinsert = "call SP_RepositoryTrans('$dataareaid','$id','$userlogin','$payperiod' ,0)";
							if(mysqli_query($conn,$sqlinsert))
							{
								echo $sqlinsert."<br>".$conn->error;
							}
							else
							{
								echo "error".$sqlinsert."<br>".$conn->error;
							}
						}
						elseif($cutoff == 6)
						{
							$sqlinsert = "call SP_RepositoryTrans('$dataareaid','$id','$userlogin','$payperiod' ,0)";
							if(mysqli_query($conn,$sqlinsert))
							{
								echo $sqlinsert."<br>".$conn->error;
							}
							else
							{
								echo "error".$sqlinsert."<br>".$conn->error;
							}
						}
						else
						{
							$sqlinsert = "call SP_RepositoryTrans('$dataareaid','$id','$userlogin','$payperiod' ,1)";
							if(mysqli_query($conn,$sqlinsert))
							{
								echo $sqlinsert."<br>".$conn->error;
							}
							else
							{
								echo "error".$sqlinsert."<br>".$conn->error;
							}
						}

						

					//$sqlloan = "call SP_LoanTrans('$wkid','$dataareaid','$id','$userlogin' ,'$period','action')";

					$sqlloan = "call SP_LoanTrans('','$dataareaid','$id','$userlogin' ,'$period','3')";
			
					if(mysqli_query($conn,$sqlloan))
							{
								echo $sqlloan."<br>".$conn->error;
							}
							else
							{
								echo "error".$sqlloan."<br>".$conn->error;
							}


				}
				else
				{
					echo "error".$sql."<br>".$conn->error;
				}
			}
	 

	 }
	 
	header('location: payrolltransaction.php');
	
	
}
else if($_GET["action"]=="revert"){
	 

	 $id=$_GET["PayId"];
	 
	 
	 if($id != ""){
	 $sql = "UPDATE payrollheader SET
				payrollstatus = '0',
				modifiedby = '$userlogin',
				modifieddatetime = now()
				WHERE payrollid = '$id'
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
	 
	header('location: payrolltransaction.php');
	
	
}
else if($_GET["action"]=="cancel"){
	 

	 $id=$_GET["PayId"];
	 
	 
	 if($id != ""){
	 $sql = "UPDATE payrollheader SET
				payrollstatus = '2',
				modifiedby = '$userlogin',
				modifieddatetime = now()
				WHERE payrollid = '$id'
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
	 
	header('location: payrolltransaction.php');
	
	
}

/*else if($_GET["action"]=="getline"){
	if($_GET["actmode"]=="userform"){
		$id=$_GET["PayId"];

		$output='';
		//$output .= '<tbody>';
		$query = "SELECT accountcode,
					accountname,
					um,
					case when accounttype = 0 then 'Entry'
					when accounttype = 1 then 'Computed'
					when accounttype = 2 then 'Condition'
					else 'Total'
					end as accounttype,
					format(value,2) value
					FROM payrollheaderaccounts
					where payrollid = '$id'
					and dataareaid = '$dataareaid'
					order by um";

		$result = $conn->query($query);
		while ($row = $result->fetch_assoc())
		{
			$output .= '
			<tr class="rowA">
				<td><span class="fa fa-adjust"></span></td>
				<td>'.$row["accountcode"].'</td>
				<td>'.$row["accountname"].'</td>
				<td>'.$row["um"].'</td>
				<td>'.$row["accounttype"].'</td>
				<td>'.$row["value"].'</td>
			</tr>';
		}
		//$output .= '</tbody>';
		echo $output;
		//header('location: process.php');
	}
}*/
else if($_GET["action"]=="payline"){
	 	
	$id=$_GET["PayId"];
	$fromdate=$_GET["PayFrom"];
	$type=$_GET["PayType"];
	$period=$_GET["PayPeriod"];
	$status=$_GET["locStatus"];

	$query2 = "SELECT * from payrollperiod where dataareaid = '$dataareaid' and payrollperiod = '$period'";
			$result2 = $conn->query($query2);
			$row2 = $result2->fetch_assoc();
			$cutoff = $row2["period"];
			

	$_SESSION['paynum'] = $id;
	$_SESSION['payper'] = $period;
	$_SESSION['paycut'] = $cutoff;
	$_SESSION['paydate'] = $fromdate;
	$_SESSION['paytype'] = $type;
	$_SESSION['paystatus'] = $status;
	header('location: payrolltransaction.php');
	
}
else if($_GET["action"]=="exempt"){
	 	
	$id=$_GET["PayId"];
	$_SESSION['EXpaynum'] = $id;
	
	header('location: payrolltransaction.php');
	
}
?>

<!-- <script  type="text/javascript">
		var so='';
	  	var payline='';
  		$(document).ready(function(){
			$('#datatbl tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","red");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();
				so = usernum.toString();
				document.getElementById("hide").value = so;
				//alert(document.getElementById("hide3").value);
				//alert(document.getElementById("hide").value);
				//alert(so);
				//-----------get line--------------//
				var action = "getline";
				var actionmode = "userform";
				$.ajax({
					type: 'POST',
					url: 'payrolltransactionline2.php',
					data:{action:action, actmode:actionmode, PayId:so},
					beforeSend:function(){
					
						$("#dtrContent").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
					},
					success: function(data){
						//payline='';
						//document.getElementById("hide2").value = "";
						$('#dtrContent').html(data);
						//alert(1);

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
</script> -->