<?php
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
session_start();
include("dbconn.php");
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
$paynum = $_SESSION['paynum'];
$period = $_SESSION['payper'];
$cutoff = $_SESSION['paycut'];



function Recompute($refnum,$payID,$dtID,$conPAR,$Mrate,$ActRate,$PayCut,$PayPer,$wrkId) 
{
	$id = $refnum;
	$paynum = $payID;
	$dataareaid = $dtID;
	$conn = $conPAR;
	$MonRate = $Mrate;
	$RateMode = $ActRate;
	$varPayCut = $PayCut;
	$varPayPer = $PayPer;
	include("dbconn.php");
	if($RateMode == 1)
	{
		$sqlinsert = "call PT_PayrollComputation('$paynum','$dataareaid','$id','ins_2','','$MonRate')";
			//mysqli_query($conn,$sqlinsert);
			//echo $sqlinsert."<br>".$conn->error;
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
		$sqlinsert = "call PT_PayrollComputation('$paynum','$dataareaid','$id','ins','','')";
			//mysqli_query($conn,$sqlinsert);
			//echo $sqlinsert."<br>".$conn->error;
			if(mysqli_query($conn,$sqlinsert))
			{
				echo $sqlinsert."<br>".$conn->error;
			}
			else
			{
				echo "error".$sqlinsert."<br>".$conn->error;
			}
	}
	
	$sqlinsertcon = "call PT_PayrollComputation('$paynum','$dataareaid','$id','ins_con','','')";
			mysqli_query($conn,$sqlinsertcon);
			//echo $sqlinsertcon."<br>".$conn->error;

			/* entry start */
			$query2 = "SELECT accountcode,
								format(value,2) value
								FROM payrolldetailsaccounts

							where payrollid = '$paynum'
							and reflinenum = '$id'
							and dataareaid = '$dataareaid'
							and accounttype = 0
							order by priority";
			$result2 = $conn->query($query2);
			while ($row2 = $result2->fetch_assoc())
				{
					//select here then update
					$acccode = $row2["accountcode"];
					$accvalue = $row2["value"];

					if($accvalue != 0)
					{
						$sql2 = "call PT_PayrollComputation('$paynum','$dataareaid','$id','Compute_0','$acccode','$accvalue')";
						mysqli_query($conn,$sql2);
						//echo $sql2."<br>".$conn->error;
					}
					

				}
			/* entry end */
			//Ben_deduct($id,$paynum,$dataareaid,$conn);
			
			
			/* computed start */
			$param = '';
			$query3 = "SELECT a.accountcode,a.value,b.formula,a.accounttype
						
						FROM payrolldetailsaccounts a
	                    left join payrolldetailcomputation b
	                    on b.accountcode = a.accountcode and
								b.payrollid = a.payrollid and
								b.reflinenum = a.reflinenum and
								b.dataareaid = a.dataareaid

							where a.payrollid = '$paynum'
							and a.reflinenum = '$id'
							and a.dataareaid = '$dataareaid'
							and a.accounttype in (1,2)
							order by a.priority";
			$result3 = $conn->query($query3);
			while ($row3 = $result3->fetch_assoc())
				{
					//select here then update
					$acccode2 = $row3["accountcode"];
					$accounttype2 = $row3["accounttype"];
					if($accounttype2 == 1)
					{

						$query4 = "SELECT b.accountcode,b.formula
						
						FROM  payrolldetailcomputation b

							where b.payrollid = '$paynum'
							and b.reflinenum = '$id'
							and b.dataareaid = '$dataareaid'
							and b.accountcode = '$acccode2'";

							$result4 = $conn->query($query4);
							$row4 = $result4->fetch_assoc();
							$acccode3 = $row4["accountcode"];
							$accformula3 = $row4["formula"];

							if($accformula3 == '')
								{
									
									$accformula3 = 0;

								}

							

							$res = preg_replace("/[^0-9\+\-*\/\.,() ]/", "0", $accformula3); 
										
							$res =  preg_replace("/[^0-9\+\-*\/\.() ]/", "", $res);
							eval('$comresult = '.$res.';');
							if($comresult != 0){

								$sql3 = "call PT_PayrollComputation('$paynum','$dataareaid','$id','Compute_0','$acccode3','$comresult')";
								mysqli_query($conn,$sql3);
								//echo $sql3."<br>".$conn->error;
								
							}
						

					}
					else
					{
						//echo "<script type='text/javascript'>alert('$acccode2');</script>";
						//$refformula = '';
						//$resformula = '';
						
						$query5 = "SELECT * from accountconditioncomputation a

							where a.payrollid = '$paynum'
							and a.reflinenum = '$id'
							and a.dataareaid = '$dataareaid'
							and a.accountcode = '$acccode2'
							";

							$result5 = $conn->query($query5);
							$row5 = $result5->fetch_assoc();
								
							$refformula = $row5["referenceformula"];
							//$resformula = $row5["resultformula"];
							//$ConCode = $row5["accountconditioncode"];

							if($refformula == '')
							{
								$refformula = 0;
							}

						$res = preg_replace("/[^0-9\+\-*\/\.,() ]/", "0", $refformula); 
										
						$res =  preg_replace("/[^0-9\+\-*\/\.() ]/", "", $res);

						eval('$comresult = '.$res.';');

						$sql5 = "UPDATE accountconditioncomputation SET referenceformula = $comresult
										WHERE payrollid = '$paynum'
										and reflinenum = '$id'
										and dataareaid = '$dataareaid'
										and accountcode = '$acccode2'
										";
							if(mysqli_query($conn,$sql5))
								{
									//echo "sql3=".$sql3."<br>";
									//echo "Rec Updated";
									//echo $sql5."<br>".$conn->error;
								}
								else
								{
									echo "error".$sql5."<br>".$conn->error;
								}

						if($varPayCut == 1)
						{
							$query6 = "call SP_getWorkerRateforDeductions ('$dataareaid','$wrkId','$paynum','BPAY');
										";
										
							$result6 = $conn->query($query6);
							$row6 = $result6->fetch_assoc();
								
							
							$resformula = $row6["ActiveRate"];

							if($resformula == '')
							{
								$resformula = 0.00;
							}
							//	$resformula = 18000;
							$conn->close();
							include("dbconn.php");
							
						}
						else
						{
							$query6 = "SELECT * from accountconditioncomputation a

										where a.payrollid = '$paynum'
										and a.reflinenum = '$id'
										and a.dataareaid = '$dataareaid'
										and a.accountcode = '$acccode2'
										
										
										limit 1
										";
							$result6 = $conn->query($query6);
							$row6 = $result6->fetch_assoc();
								
							//$resultformula = $row6["resultformula"];
							//$resultcode = $row6["accountcode"];
							$resformula = $row6["referenceformula"];
							/*$resultformula = $row6["resultformula"];
							$resultcode = $row6["accountcode"];*/
						}
						
						

						if($acccode2 == 'TAX')
						{
							//echo $resformula;
							$resultformula = 214;
							
							$query11 = "call SP_computeTax('$dataareaid','$resformula');";
								
							$result11 = $conn->query($query11);
							$row11 = $result11->fetch_assoc();
							$resultformula = $row11["resultn"];

							if($resultformula == '')
							{
								$resultformula = 0.00;
							}
							//echo $resultformula.'-'.$acccode2;
							//echo "<br>";
							$result11->close();
							$conn->close();
							include("dbconn.php");

							

						}
						else //if($acccode2 == 'SSS' || $acccode2 == 'PH')
						{
							
							
							$deduct = 100;

							$query6A = "call SP_getWorkerRateforDeductions ('$dataareaid','$wrkId','$paynum','$acccode2');
										";
										
							$result6A = $conn->query($query6A);
							$row6A = $result6A->fetch_assoc();
								
							
							$deduct = $row6A["ActiveRate"];

							if($deduct == '')
							{
								$deduct = 0.00;
							}
							echo "<br>";
							echo $paynum;
							echo "<br>";
							echo $varPayCut;
							echo "<br>";
							echo $wrkId;
							echo "<br>";
							echo $acccode2;
							echo "<br>";
							echo $resformula;
							echo "<br>";
							echo $deduct;
							echo "<br>";
							//	$resformula = 18000;
							$conn->close();
							include("dbconn.php");
							
							/*$sql11 = "call PT_PayrollComputation('$paynum','$dataareaid','$id','Compute_4','$acccode3','$comresult')";
								mysqli_query($conn,$sql11);*/
								//call PT_SSScontribution('ADMO',6600)
							//$query11 = "call PT_SSScontribution('ADMO',20000)";
							//echo "<script type='text/javascript'>alert('$resformula'".'-'."'$acccode2');</script>";
							//echo $resformula.'-'.$acccode2;
							//echo "<br>";
								
							$query11 = "call PT_Contribution('$dataareaid','$resformula','$acccode2','$deduct')";
								
							$result11 = $conn->query($query11);
							$row11 = $result11->fetch_assoc();
							$resultformula = $row11["Resultn"];

							//$result11->close();
							$conn->close();
							include("dbconn.php");
							//$accSSS = $rowSSS["accountconditioncode"];
							//$resultformula = $row11["deduction"];


						}
						
						$sql6 = "call PT_PayrollComputation('$paynum','$dataareaid','$id','Compute_1','$acccode2','$resultformula')";
								mysqli_query($conn,$sql6);

						$query4 = "SELECT b.accountcode,b.formula
						
						FROM  payrolldetailcomputation b

							where b.payrollid = '$paynum'
							and b.reflinenum = '$id'
							and b.dataareaid = '$dataareaid'
							and b.accountcode = '$acccode2'";

							$result4 = $conn->query($query4);
							$row4 = $result4->fetch_assoc();
							$acccode3 = $row4["accountcode"];
							$accformula3 = $row4["formula"];

							if($accformula3 == '')
								{
									//echo "<script type='text/javascript'>alert('$acccode3');</script>";
									$accformula3 = 0;

								}

							

							$res = preg_replace("/[^0-9\+\-*\/\.,() ]/", "0", $accformula3); 
										
							$res =  preg_replace("/[^0-9\+\-*\/\.() ]/", "", $res);
							eval('$comresult = '.$res.';');
							if($comresult != 0){

								$sql3 = "call PT_PayrollComputation('$paynum','$dataareaid','$id','Compute_0','$acccode3','$comresult')";
								mysqli_query($conn,$sql3);
								//echo $sql3."<br>".$conn->error;
								
							}
					}
					
					
							
				}
			/* Computed End */
			
			
			/*update values*/
			$query4 = "SELECT a.accountcode,a.value,b.formula
						
						FROM payrolldetailsaccounts a
	                    left join payrolldetailcomputation b
	                    on b.accountcode = a.accountcode and
								b.payrollid = a.payrollid and
								b.reflinenum = a.reflinenum and
								b.dataareaid = a.dataareaid

							where a.payrollid = '$paynum'
							and a.reflinenum = '$id'
							and a.dataareaid = '$dataareaid'
							and a.accounttype = 1
							order by a.priority";
			$result4 = $conn->query($query4);
			while ($row4 = $result4->fetch_assoc())
				{
					//select here then update
					$acccode4 = $row4["accountcode"];
					$accformula4 = $row4["formula"];
					/*$query5 = "SELECT b.accountcode,b.formula
						
						FROM  payrolldetailcomputation b

							where b.payrollid = '$paynum'
							and b.reflinenum = '$id'
							and b.dataareaid = '$dataareaid'
							and b.accountcode = '$acccode2'";

							$result5 = $conn->query($query5);
							$row5 = $result5->fetch_assoc();
							$acccode4 = $row5["accountcode"];
							$accformula4 = $row5["formula"];*/
							$res = preg_replace("/[^0-9\+\-*\/\.,() ]/", "0", $accformula4); 
										
							$res =  preg_replace("/[^0-9\+\-*\/\.() ]/", "", $res);
							eval('$comresult = '.$res.';');

							//if($comresult != 0){

								$sql3 = "UPDATE payrolldetailsaccounts SET value = $comresult
								WHERE payrollid = '$paynum'
								and reflinenum = '$id'
								and dataareaid = '$dataareaid'
								and accountcode = '$acccode4'";
							if(mysqli_query($conn,$sql3))
								{
									//echo "sql3=".$sql3."<br>";
									//echo "Rec Updated";
								}
								else
								{
									echo "error".$sql3."<br>".$conn->error;
								}
							//}
							
				}

}




if($_GET["action"]=="update"){
	 
	 $PTcode=$_GET["PTcode"];
	 $value=$_GET["PTvalue"];
	 $contract=$_GET["PTcontract"];
	 $id=$_GET["PTline"];
	 
	if($id != ""){
	 $sqlupdate = "UPDATE payrolldetailsaccounts SET
				value = '$value',
				modifiedby = '$userlogin',
				modifieddatetime = now()
				WHERE accountcode = '$PTcode'
				and payrollid = '$paynum'
				and reflinenum = '$id'
				and dataareaid = '$dataareaid'";
		if(mysqli_query($conn,$sqlupdate))
		{
			
			//Recompute($id,$paynum,$dataareaid,$conn);
			$query = "SELECT ifnull(format(mrate/2,2),0) mrate,ifnull(activemrate,0) activemrate FROM ratehistory where dataareaid = '$dataareaid' and contractid = '$contract' and status = 1";
			$result = $conn->query($query);
			$row = $result->fetch_assoc();
			$ActRate = $row["activemrate"];
			$Mrate = $row["mrate"];
			
			$query2 = "SELECT * FROM payrolldetails where payrollid = '$paynum' and linenum = '$id' and dataareaid = '$dataareaid'";
			$result2 = $conn->query($query2);
			$row2 = $result2->fetch_assoc();
			$wrkId = $row2["workerid"];

		//$Mrate = 20000;
		//$ActRate = 0;
			//echo $ActRate;
			Recompute($id,$paynum,$dataareaid,$conn,$Mrate,$ActRate,$cutoff,$period,$wrkId);
			
		}
		else
		{
			echo "error".$sqlupdate."<br>".$conn->error;
		}
		$_SESSION['paylinenum'] = $id;
		header('location: payrolltransactiondetailline.php');

	}
	 	//$_SESSION['paylinenum'] = $line;
	//	header('location: payrolltransactiondetailline.php');
	//header('location: payrolltransactiondetail.php'); 
			
}
else if($_GET["action"]=="recompute"){
	 

	$id=$_GET["PTline"];
	$contract=$_GET["locContract"];

	if($id != ""){

		$query = "SELECT ifnull(format(mrate/2,2),0) mrate,ifnull(activemrate,0) activemrate FROM ratehistory where dataareaid = '$dataareaid' and contractid = '$contract' and status = 1";
			$result = $conn->query($query);
			$row = $result->fetch_assoc();
			$ActRate = $row["activemrate"];
			$Mrate = $row["mrate"];
			
		$query2 = "SELECT * FROM payrolldetails where payrollid = '$paynum' and linenum = '$id' and dataareaid = '$dataareaid'";
			$result2 = $conn->query($query2);
			$row2 = $result2->fetch_assoc();
			$wrkId = $row2["workerid"];
			

		//$Mrate = 20000;
		//$ActRate = 0;
		Recompute($id,$paynum,$dataareaid,$conn,$Mrate,$ActRate,$cutoff,$period,$wrkId);
		
		
	$_SESSION['paylinenum'] = $id;
	//Comment
	header('location: payrolltransactiondetailline.php');
	}
	//$_SESSION['paylinenum'] = $id;
	//header('location: payrolltransactiondetailline.php');
	//header('location: payrolltransactiondetail.php'); 

}

else if($_GET["action"]=="recomputeAll"){
	 

	//$id=$_GET["PTline"];
	$arrayId = array();
	if($paynum != ""){

		

		$query = "SELECT * from payrolldetails where payrollid = '$paynum' order by linenum desc";
		$result = $conn->query($query);
		$rowclass = "rowA";
		$rowcnt = 0;
		while ($row = $result->fetch_assoc())
		{
			//sleep(15);
			$id = $row["linenum"];
			$contract = $row["contractid"];
			$wrkId = $row["workerid"];

			$query2 = "SELECT ifnull(format(mrate/2,2),0) mrate,ifnull(activemrate,0) activemrate FROM ratehistory where dataareaid = '$dataareaid' and contractid = '$contract' and status = 1";
			$result2 = $conn->query($query2);
			$row2 = $result2->fetch_assoc();
			$ActRate = $row2["activemrate"];
			$Mrate = $row2["mrate"];



			//$Mrate = 20000;
			//$ActRate = 0;
			Recompute($id,$paynum,$dataareaid,$conn,$Mrate,$ActRate,$cutoff,$period,$wrkId);



			//array_push($arrayId, $id);
			//Recompute($id,$paynum,$dataareaid,$conn);
			//Recompute($id,$paynum,$dataareaid,$conn);
			//echo $id;
			//sleep(15);

		}
		
		
		//Recompute($id,$paynum,$dataareaid,$conn);
		
		
	}
	/*foreach ($arrayId as $value) 
	{
		  echo "$value <br>";
		  //sleep(15);
		  Recompute($value,$paynum,$dataareaid,$conn);
	}*/

	//header('location: payrolltransactiondetail.php'); 

}

else if($_GET["action"]=="searchdata"){
	if($_GET["actmode"]=="userform"){
		$worker=$_GET["PTWorker"];
		$firstresult ='';
		$output='';
		//$output .= '<tbody>';
		$query = "SELECT pd.payrollid,
						wk.name,
						format(pd.rate,2) as rate
						,format(pd.ecola,2) as ecola,
						format(pd.transpo,2) transpo,
						format(pd.meal,2) as meal,
						case when pd.workertype = 0 then 'Regular' 
							when pd.workertype = 1 then 'Reliever'
							when pd.workertype = 2 then 'Probationary'
							when pd.workertype = 3 then 'Contractual' 
							when pd.workertype = 4 then 'Trainee' else '' end as workertype,

						pd.transdate,
						pd.linenum
						FROM payrolldetails pd
						left join worker wk on wk.workerid = pd.workerid
						and wk.dataareaid = pd.dataareaid

				where pd.dataareaid = '$dataareaid' 
				and pd.payrollid = '$paynum'
				and wk.name like '%$worker%'

				order by wk.workerid asc";
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
				<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
				<td style="width:18%;">'.$row["name"].'</td>
				<td style="width:10%;">'.$row["rate"].'</td>
				<td style="width:14%;">'.$row["ecola"].'</td>
				<td style="width:14%;">'.$row["transpo"].'</td>
				<td style="width:14%;">'.$row["meal"].'</td>
				<td style="width:14%;">'.$row["workertype"].'</td>
				<td style="width:14%;">'.$row["transdate"].'</td>
				<td style="display:none;width:14%;">'.$row["linenum"].'</td>
			</tr>';
		}
		//$output .= '</tbody>';
		echo $output;
		$result2 = $conn->query($query);
		$row2 = $result2->fetch_assoc();
		$firstresult = $row2["linenum"];
		echo $output2 = '<tr class="rowA">
							<td hidden><input type="input" id="hide3" value="'.$firstresult.'"></td>
						</tr>';
		//header('location: process.php');
	}
}
else if($_GET["action"]=="payhead"){
	 	
	$id=$_GET["PayId"];
	$_SESSION['paynum'] = $id;
	//unset($_SESSION['paynum']);
	header('location: payrolltransaction.php');
	
}
else if($_GET["action"]=="addworker"){
	 	
	//$id=$_GET["PayId"];
	//$_SESSION['paynum'] = $id;
	//unset($_SESSION['paynum']);
	header('location: ptworker.php');
	
}

else if($_GET["action"]=="addaccount"){
	 	
	$id=$_GET["PayId"];
	$_SESSION['linenum'] = $id;
	//unset($_SESSION['paynum']);
	header('location: ptaccounts.php');
	
}

else if($_GET["action"]=="remAccount"){
	 	
	
		$id=$_GET["delLinenum"];
		$acc=$_GET["delACC"];

		if($id != ""){
			$sql = "DELETE from payrolldetailsaccounts where payrollid = '$paynum' and reflinenum = '$id' and accountcode = '$acc' and dataareaid = '$dataareaid'";
			if(mysqli_query($conn,$sql))
			{
				echo $sql."<br>".$conn->error;
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}

		}
		//$_SESSION['paylinenum'] = $id;
		//header('location: payrolltransactiondetailline.php');
	
	
	
}

else if($_GET["action"]=="deleteWK"){
	 	
	
		$id=$_GET["delHeadnum"];
		//$acc=$_GET["delACC"];

		if($id != ""){

			$sql = "DELETE from payrolldetailsaccounts where payrollid = '$paynum' and reflinenum = '$id' and dataareaid = '$dataareaid'";
			if(mysqli_query($conn,$sql))
			{
				echo $sql."<br>".$conn->error;
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}



			$sql = "DELETE from payrolldetails where payrollid = '$paynum' and linenum = '$id' and dataareaid = '$dataareaid'";
			if(mysqli_query($conn,$sql))
			{
				echo $sql."<br>".$conn->error;
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}

			header('location: payrolltransactiondetail.php');
		}
		
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

?>

<script  type="text/javascript">
		var flaglocation=true;
	  	var so='';
	  	var payline='';
	  	var locValue='';
	  	var locType='';
	  	var locContract='';
  		$(document).ready(function(){
			$('#datatbl tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","red");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(8)").text();
				locContract = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(9)").text();
				so = usernum.toString();
				document.getElementById("hide").value = so;
				document.getElementById("hidecontract").value = locContract;
				//alert(document.getElementById("hide").value);
				//alert(locContract);
				//-----------get line--------------//
				var action = "getline";
				var actionmode = "userform";
				$.ajax({
					type: 'POST',
					url: 'payrolltransactiondetailline.php',
					data:{action:action, actmode:actionmode, PayId:so},
					beforeSend:function(){
					
						$("#lineresult").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
					},
					success: function(data){
						//payline='';
						document.getElementById("hide2").value = "";
						$('#lineresult').html(data);
					}
				}); 	
				//-----------get line--------------//
				flaglocation = true;
				//alert(flaglocation);
		        $("#myUpdateBtn").prop("disabled", true);
		            
				//document.getElementById("myUpdateBtn").style.visibility = "visible";
					  
			});
			//$("#myUpdateBtn").prop('disabled', false);
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