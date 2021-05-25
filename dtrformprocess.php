<?php
session_start();
session_regenerate_id();
$userlogin = $_SESSION["user"];
//$payrollperiod = $_SESSION['DTRPeriod'];

if(isset($_SESSION['DTRPeriod']))
{
	$payrollperiod = $_SESSION['DTRPeriod'];
}

if(isset($_SESSION['DTRWorker']))
{
	$wkid = $_SESSION['DTRWorker'];
}
//$wkid = $_SESSION['DTRWorker'];
$dataareaid = $_SESSION["defaultdataareaid"];
include("dbconn.php");

function ComputeAll($PayPer,$PayCut,$dtID,$conPAR,$usr)
{
	$LocPayrollPeriod = $PayPer;
	$conn = $conPAR;
	$dataareaid = $dtID;
	$LocCutoff = $PayCut;

	$PayQuery = "SELECT * from payrollheader where payrollperiod = '$LocPayrollPeriod' and dataareaid = '$dataareaid' and payrollstatus = 0";
		$Payresult = $conn->query($PayQuery);
		while ($Payrow = $Payresult->fetch_assoc())
		{
			$VarPayId = $Payrow["payrollid"];

			$sqlloan = "call SP_LoanTrans('','$dataareaid','$VarPayId','$usr' ,'$LocPayrollPeriod','2')";
			
			if(mysqli_query($conn,$sqlloan))
					{
						echo $sqlloan."<br>".$conn->error;
					}
					else
					{
						echo "error".$sqlloan."<br>".$conn->error;
					}

			$queryCom = "SELECT * from payrolldetails where payrollid = '$VarPayId' and dataareaid = '$dataareaid' order by linenum desc";
					$resultCom = $conn->query($queryCom);
					
					while ($rowCom = $resultCom->fetch_assoc())
					{
						//sleep(15);
						$id = $rowCom["linenum"];
						$contract = $rowCom["contractid"];
						$wrkId = $rowCom["workerid"];

						$queryRate = "SELECT ifnull(format(mrate/2,2),0) mrate,ifnull(activemrate,0) activemrate FROM ratehistory where dataareaid = '$dataareaid' and contractid = '$contract' and status = 1";
							$resultRate = $conn->query($queryRate);
							$rowRate = $resultRate->fetch_assoc();
							$ActRate = $rowRate["activemrate"];
							$Mrate = $rowRate["mrate"];



						//$Mrate = 20000;
						//$ActRate = 0;
						getaccountsHeader($VarPayId,$LocPayrollPeriod,$id,$LocCutoff,$dataareaid,$conn);

						//Recompute($id,$VarPayId,$dataareaid,$conn,$Mrate,$ActRate,$LocCutoff,$LocPayrollPeriod,$wrkId);


					}

			/*$sqlinsert = "call sp_computationPayroll('$VarPayId' ,'$dataareaid')";
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

			RecomputeHeader($VarPayId,$dataareaid,$conn,$usr);*/

		}
		//inser loop per branch
		$PerBranchQuery = "SELECT * from payrollheader where payrollperiod = '$LocPayrollPeriod' and dataareaid = '$dataareaid' and payrollstatus = 0";
		$PerBranchresult = $conn->query($PerBranchQuery);
		while ($PerBranchrow = $PerBranchresult->fetch_assoc())
		{
			$PerBranchPayId = $PerBranchrow["payrollid"];
			$sqlinsert = "call sp_computationPayroll('$PerBranchPayId' ,'$dataareaid')";
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

			RecomputeHeader($PerBranchPayId,$dataareaid,$conn,$usr);
		}
		//end

		//exit(0);
		/*echo "<BR>";
		echo $LocCutoff;
		echo "<BR>";
		echo $LocPayrollPeriod;
		echo "<BR>";
		echo $VarPayId;
		echo "<BR>";*/
}

function getaccountsHeader($payID,$PayPer,$PayLineNum,$PayCut,$dtID,$conPAR)
{	
	$conn = $conPAR;
	$dataareaid = $dtID;
	$varPayCut = $PayCut;

	$sqlinsert = "call SP_DTRtoPDA('$dataareaid','$PayPer','$payID','$PayLineNum')";
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

	/*$DHquery = "SELECT prdtls.workerid,prdtls.payrollid,prdtls.linenum,dtrheader.daysworked,dtrheader.hoursworked,dtrheader.overtimehours,dtrheader.nightdifhours,
						dtrheader.late,dtrheader.specialholiday,dtrheader.specialholidaynd,dtrheader.specialholidayot,dtrheader.sunday,dtrheader.sundaynd,dtrheader.sundayot,
						dtrheader.holiday,dtrheader.holidaynd,dtrheader.holidayot,prdtls.contractid,dtrheader.absent,dtrheader.undertime,dtrheader.break,dtrheader.leaves from dailytimerecordheader dtrheader 
					left join  payrolldetails prdtls on 
					dtrheader.workerid = prdtls.workerid and 
					dtrheader.dataareaid = prdtls.dataareaid 
					where 
					prdtls.payrollid = '$payID'  and dtrheader.payrollperiod = '$PayPer'
					and prdtls.linenum = '$PayLineNum'";
			$DHresult = $conn->query($DHquery);
			while ($DHrow = $DHresult->fetch_assoc())
			{
				$wkIdno = $DHrow["workerid"];
                $payrollid = $DHrow["payrollid"];
                $contract = $DHrow["contractid"];
                $linenum = $DHrow["linenum"];

                $daysworked = $DHrow["daysworked"];
                $OT = $DHrow["overtimehours"];
                $ND = $DHrow["nightdifhours"];
                $LTE = $DHrow["late"];
                $UT = $DHrow["undertime"];
                $OB = $DHrow["break"];
                $LF = $DHrow["leaves"];

                $SHOL = $DHrow["specialholiday"];
                $SHOLND = $DHrow["specialholidaynd"];
                $SHOLOT = $DHrow["specialholidayot"];
                $absent = $DHrow["absent"];

                $SUND = $DHrow["sunday"];
                $SUNND = $DHrow["sundaynd"];
                $SUNOT = $DHrow["sundayot"];

                $REGHOL = $DHrow["holiday"];
                $REGHOLND = $DHrow["holidaynd"];
                $REGHOLOT = $DHrow["holidayot"];

                UpdateDetailAccounts($payrollid, $linenum, $daysworked, "RDAYS",$conn);
                UpdateDetailAccounts($payrollid, $linenum, $LTE, "LTE",$conn);
                UpdateDetailAccounts($payrollid, $linenum, $UT, "UT",$conn);
                UpdateDetailAccounts($payrollid, $linenum, $OT, "OT",$conn);
                UpdateDetailAccounts($payrollid, $linenum, $ND, "ND",$conn);
                UpdateDetailAccounts($payrollid, $linenum, $absent, "ABS",$conn);
                UpdateDetailAccounts($payrollid, $linenum, $OB, "OB",$conn);
                UpdateDetailAccounts($payrollid, $linenum, $LF, "LF",$conn);
                UpdateDetailAccounts($payrollid, $linenum, $SHOL, "SPL",$conn);
                UpdateDetailAccounts($payrollid, $linenum, $SHOLND, "SPLND",$conn);
                UpdateDetailAccounts($payrollid, $linenum, $SHOLOT, "SPLOT",$conn);
                UpdateDetailAccounts($payrollid, $linenum, $SUND, "SUN",$conn);
                UpdateDetailAccounts($payrollid, $linenum, $SUNOT, "SUNOT",$conn);
                UpdateDetailAccounts($payrollid, $linenum, $SUNND, "SUNND",$conn);
                UpdateDetailAccounts($payrollid, $linenum, $REGHOL, "HOL",$conn);
                UpdateDetailAccounts($payrollid, $linenum, $REGHOLND, "HOLOT",$conn);
                UpdateDetailAccounts($payrollid, $linenum, $REGHOLOT, "HOLND",$conn);

                //$id = $row["linenum"];
				//$contract = $row["contractid"];
				//$wrkId = $row["workerid"];

				



				//$Mrate = 20000;
				//$ActRate = 0;
				//Recompute($linenum,$payID,$dataareaid,$conn,$Mrate,$ActRate,$varPayCut,$PayPer,$wkIdno);

			}*/

}
function UpdateDetailAccounts($payID,$lineno,$value,$Accnt,$conPAR) 
{
		$conn = $conPAR;
		$UDAsql = "UPDATE payrolldetailsaccounts set value = '$value'
				where payrollid = '$payID' and reflinenum = '$lineno'  and accountcode = '$Accnt' order by priority asc";
		if(mysqli_query($conn,$UDAsql))
		{
			//echo "<BR>";
			echo "Rec Updated: ".$Accnt;
			//echo "<BR>";
		}
		else
		{
			echo "error".$UDAsql."<br>".$conn->error;
		}
}
function Compute($payID,$PayPer,$PayCut,$dtID,$conPAR)
{
	$conn = $conPAR;
	$dataareaid = $dtID;
	$varPayCut = $PayCut;

	$queryCom = "SELECT * from payrolldetails where payrollid = '$payID' order by linenum desc";
		$resultCom = $conn->query($queryCom);
		
		while ($rowCom = $resultCom->fetch_assoc())
		{
			//sleep(15);
			$id = $rowCom["linenum"];
			$contract = $rowCom["contractid"];
			$wrkId = $rowCom["workerid"];

			$queryRate = "SELECT ifnull(format(mrate/2,2),0) mrate,ifnull(activemrate,0) activemrate FROM ratehistory where dataareaid = '$dataareaid' and contractid = '$contract' and status = 1";
				$resultRate = $conn->query($queryRate);
				$rowRate = $resultRate->fetch_assoc();
				$ActRate = $rowRate["activemrate"];
				$Mrate = $rowRate["mrate"];

			Recompute($id,$payID,$dataareaid,$conn,$Mrate,$ActRate,$varPayCut,$PayPer,$wrkId);


		}
}
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
							and a.accounttype = '1'
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

					
					
							
				}
			/* Computed End */

			/* Condition start*/
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
								and a.accountcode = 'BPAY'
								order by a.priority";
				$result4 = $conn->query($query4);
				while ($row4 = $result4->fetch_assoc())
					{
						//select here then update
						$acccode4 = $row4["accountcode"];
						$accformula4 = $row4["formula"];
						
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
								and a.accounttype = 2
								order by a.priority";
				$result3 = $conn->query($query3);
				while ($row3 = $result3->fetch_assoc())
				{
					$acccode2 = $row3["accountcode"];
					$accounttype2 = $row3["accounttype"];
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
							$bpay = 0;
							$query6A = "call SP_getWorkerRateforDeductions ('$dataareaid','$wrkId','$paynum','$acccode2');
										";
										
							$result6A = $conn->query($query6A);
							$row6A = $result6A->fetch_assoc();
								
							
							$deduct = $row6A["ActiveRate"];

							$conn->close();
							include("dbconn.php");

							$query9 = "SELECT format(pa.value,2) as amm from
				                                payrolldetails pd
				                                
				                                left join payrolldetailsaccounts pa on
												pd.payrollid = pa.payrollid and
												pd.linenum = pa.reflinenum and
												pd.dataareaid = pa.dataareaid
				                                
				                                where pa.accountcode = 'BPAY'
				                                and pa.payrollid = '$paynum'
												and pd.workerid = '$wrkId'
												and pa.dataareaid = '$dataareaid'
												
												order by pa.priority;
										";
							//echo "<br>";
							//echo $query9;	
							$result9 = $conn->query($query9);
							$row9 = $result9->fetch_assoc();
								
							
							$bpay = $row9["amm"];
							

							if($deduct == '')
							{
								$deduct = 0.00;
							}
							/*echo "<br>";
							echo $paynum;
							echo "<br>";
							echo $bpay;
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
							echo "<br>";*/
							//	$resformula = 18000;
							
							
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

			/* Condition End */
			
			
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
function RecomputeHeader($payID,$dtID,$conPAR,$usrlog)
{
	$conn = $conPAR;
	$dataareaid = $dtID;

	
		$query = "SELECT a.accountcode,b.formula
					FROM payrollheaderaccounts a
                    left join accounts b on 
					a.accountcode = b.accountcode and
					a.accounttype = b.accounttype and
					a.dataareaid  = b.dataareaid
					where a.payrollid = '$payID'
					and a.dataareaid = '$dataareaid'";

		$result = $conn->query($query);
		$rowclass = "rowA";
		$rowcnt = 0;
		while ($row = $result->fetch_assoc())
		{
			$acc = $row["accountcode"];
			$formula = $row["formula"];

			$query2 = "SELECT sum(value) sumVal from payrolldetailsaccounts 

						WHERE payrollid = '$payID'
						and dataareaid = '$dataareaid' 
						and CONCAT('[',accountcode,']')  = '$formula'";
			$result2 = $conn->query($query2);
			$row2 = $result2->fetch_assoc();

			$SumVal = $row2["sumVal"];



			$sql = "UPDATE payrollheaderaccounts SET
					value = '$SumVal',
					modifiedby = '$usrlog',
					modifieddatetime = now()
					WHERE payrollid = '$payID'
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
		
}

if(isset($_GET["save"])) {
	 
	 $uno=$_GET["userno"];
	 $upass=$_GET["pass"];
	 $ul=$_GET["lname"];
	 $dtarea=$_GET["darea"];
	 
	 if($uno != ""){
	 $sql = "INSERT INTO userfile (userid,name,defaultdataareaid,password,createdby,createddatetime)
			values 
			('$uno', '$ul', '$dtarea', aes_encrypt('$upass','password'), '$userlogin', now())";
		if(mysqli_query($conn,$sql))
		{
			echo "New Rec Created";
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}

	 }
	 
header('location: dtrform.php');
	
}
else if(isset($_GET["updatews"])) {
	 $workerid = $_GET["add-workerid"];
	 $hourwork=$_GET["add-hourWork"];
	
	$hourWork= $_GET["add-hourWork"];
	$daysWork= $_GET["add-daysWork"];
	$OTHours= $_GET["add-OTHours"];
	$NDhour= $_GET["add-NDhour"];
	$leaves= $_GET["add-leaves"];
	$absent= $_GET["add-absent"];
	$late= $_GET["add-late"];
	$undertime= $_GET["add-undertime"];
	$break= $_GET["add-break"];

	$sphol= $_GET["add-sphol"];
	$spholOT= $_GET["add-spholOT"];
	$spholND= $_GET["add-spholND"];
	$sunday= $_GET["add-sunday"];
	$sundayOT= $_GET["add-sundayOT"];
	$sundayND= $_GET["add-sundayND"];
	$hol= $_GET["add-hol"];
	$holOT= $_GET["add-holOT"];
	$holND= $_GET["add-holND"];

	 
	 if($hourwork != ""){
	 $sql = "UPDATE dailytimerecordheader SET
				hoursworked = '$hourWork',
				daysworked = '$daysWork',
				overtimehours = '$OTHours',
				nightdifhours = '$NDhour',
				leaves = '$leaves',
				absent = '$absent',
				late = '$late',
				undertime = '$undertime',
				break = '$break',
				
				specialholiday = '$sphol',
				specialholidayot = '$spholOT',
				specialholidaynd = '$spholND',
				sunday = '$sunday',
				sundayot = '$sundayOT',
				sundaynd = '$sundayND',
				holiday = '$hol',
				holidayot = '$holOT',
				holidaynd = '$holND'

				where dataareaid = '$dataareaid' and workerid = '$workerid'  and payrollperiod = '$payrollperiod'";
		if(mysqli_query($conn,$sql))
		{
			echo "Rec Updated";
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}

	 }
	
	header('location: dtrform.php');
	
}

else if($_GET["action"]=="update") {
	 
	 $timein=$_GET["starttime"];
	 $timeout=$_GET["endtime"];
	 $date=$_GET["locDate"];
	 $breakout=$_GET["breakout"];
	 $breakin=$_GET["breakin"];
	 
	 
	 if($timein != ""){
	 $sql = "UPDATE dailytimerecorddetail SET
				timein = concat(date_format(date, '%Y-%m-%d'),' ',TIME_FORMAT('$timein', '%H:%i')),
				timeout = concat(date_format(date, '%Y-%m-%d'),' ',TIME_FORMAT('$timeout', '%H:%i')),
				breakout = concat(date_format(date, '%Y-%m-%d'),' ',TIME_FORMAT('$breakout', '%H:%i')),
				breakin = concat(date_format(date, '%Y-%m-%d'),' ',TIME_FORMAT('$breakin', '%H:%i')),
				modifiedby = '$userlogin',
				modifieddatetime = now()
				where dataareaid = '$dataareaid' and workerid = '$wkid' and date = '$date' and payrollperiod = '$payrollperiod'";
		if(mysqli_query($conn,$sql))
		{
			echo $sql;
		
			$PayPerquery = "SELECT 
						date_format(startdate, '%Y-%m-%d') startdate,
						date_format(enddate, '%Y-%m-%d') enddate,
						period
						FROM payrollperiod where dataareaid = '$dataareaid' 
						and payrollperiod = '$payrollperiod'";

						//and (module like '%$module%') and (submodule like '%$sub%') and (name like '%$name%')";
			$PayPerresult = $conn->query($PayPerquery);
			$PayPerrow = $PayPerresult->fetch_assoc();
			$startdate=$PayPerrow["startdate"];
			$enddate=$PayPerrow["enddate"];

			$sqlgenerate = "call generateDTRperworker('$dataareaid','$startdate','$enddate','$payrollperiod','$wkid')";
				if(mysqli_query($conn,$sqlgenerate))
				{
					//echo $sqlgenerate."<br>";
					echo "done";
				}
				else
				{
					echo "error".$sqlgenerate."<br>".$conn->error;
				}



		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}

	 }
	
	//header('location: dtrsummary.php');
	
}

else if($_GET["action"]=="searchdata"){
	if($_GET["actmode"]=="userform"){
		$uno=$_GET["userno"];
		$ul=$_GET["lname"];
		$dtarea=$_GET["darea"];
		$output='';
		//$output .= '<tbody>';
		$query = "SELECT * FROM userfile where (userid like '%$uno%') and (name like '%$ul%') and (defaultdataareaid like '%$dtarea%')";
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
			<tr id="'.$row["userid"].'" class="'.$rowclass.'" tabindex="'.$rowcnt2.'" >
				<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
				<td style="width:25%;">'.$row["userid"].'</td>
				<td style="width:25%;">'.$row["name"].'</td>
				<td style="width:25%;">'.$row["defaultdataareaid"].'</td>
				<td style="width:25%;">'.$row["password"].'</td>
			</tr>';
		}
		//$output .= '</tbody>';
		echo $output;
		//header('location: process.php');
		$result2 = $conn->query($query);
		$row2 = $result2->fetch_assoc();
		$firstresult2 = $row2["userid"];
		echo $output2 = '<tr class="rowA">
							<td hidden><input type="input" id="hide3" value="'.$firstresult2.'"></td>
						</tr>';
	}
}
else if($_GET["action"]=="load"){
	 	
	$_SESSION['PeriodAction'] = 'LoadDtr';

	header('location: dtrform.php');
	
}
else if($_GET["action"]=="import"){
	 	
	$_SESSION['PeriodAction'] = 'ImportDtr';

	header('location: dtrform.php');
	
}
else if($_GET["action"]=="proceedX"){
	 	
	
	$period=$_GET["PayPeriod"];
	$maxval = 1;

	$sequence='';
	
	
	$PayPerquery = "SELECT 
				date_format(startdate, '%Y-%m-%d') startdate,
				date_format(enddate, '%Y-%m-%d') enddate,
				period
				FROM payrollperiod where dataareaid = '$dataareaid' 
				and payrollperiod = '$period'";
				//and (module like '%$module%') and (submodule like '%$sub%') and (name like '%$name%')";
	$PayPerresult = $conn->query($PayPerquery);
	$PayPerrow = $PayPerresult->fetch_assoc();
	$startdate=$PayPerrow["startdate"];
	$enddate=$PayPerrow["enddate"];
	$cutoff = $PayPerrow["period"];
	 

	 
	$Brnquery = "SELECT b.branch from dailytimerecorddetail a 
					left join worker b on a.workerid = b.workerid and a.dataareaid = b.dataareaid 
					where a.payrollperiod = '$period' 
					and a.dataareaid = '$dataareaid'
					group by b.branch";
	$Brnresult = $conn->query($Brnquery);
		
		while ($Brnrow = $Brnresult->fetch_assoc())
		{ 
			$branch=$Brnrow["branch"];

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
					echo "Rec Updated";
				}
				else
				{
					echo "error".$sql."<br>".$conn->error;
				}

			$sqlHeader = "INSERT INTO payrollheader (payrollid,branchcode,payrollperiod,payrollstatus,fromdate,todate,paymenttype,dataareaid,createdby,createddatetime)
				values 
				('$sequence', '$branch', '$period', '0', '$startdate', '$enddate', '1', '$dataareaid', '$userlogin', now())";
			if(mysqli_query($conn,$sqlHeader))
			{
				echo "New Rec Created";
			}
			else
			{
				echo "error".$sqlHeader."<br>".$conn->error;
			}
			//with 
			$WKquery = "SELECT rhist.contractid,
					    wk.workerid,
					    truncate(rhist.rate,2) as rate,
					    rhist.ecola,
					    rhist.transpo,
					    rhist.meal,
						wk.employmentstatus as workertype
					     
					     FROM  dailytimerecorddetail dtrdtl  left join worker wk on
							dtrdtl.workerid = wk.workerid and dtrdtl.dataareaid = wk.dataareaid 
							left join position pos on pos.positionid = wk.position and pos.dataareaid = wk.dataareaid 
							left join contract con on wk.workerid = con.workerid and wk.dataareaid = con.dataareaid
							left join ratehistory rhist on con.contractid = rhist.contractid and con.dataareaid = rhist.dataareaid 
							where wk.dataareaid = '$dataareaid' 
							and wk.branch = '$branch'
							and dtrdtl.payrollperiod = '$period'
						  
							and rhist.status = 1 group by wk.workerid ,wk.name,pos.name,rhist.rate,rhist.ecola,rhist.transpo,rhist.meal,rhist.contractid,wk.employmentstatus";
			$WKresult = $conn->query($WKquery);
			while ($WKrow = $WKresult->fetch_assoc())
			{
				$contract=$WKrow["contractid"];
				$workerid=$WKrow["workerid"];
				$rate=$WKrow["rate"];
				$ecola=$WKrow["ecola"];
				$transpo=$WKrow["transpo"];
				$meal=$WKrow["meal"];
				$type=$WKrow["workertype"];
				//$trans=$WKrow["transdate"];

				/*$query2 = "SELECT 
							max(pd.linenum) as linenum
							FROM payrolldetails pd
							where pd.dataareaid = '$dataareaid' and pd.payrollid = '$paynum'";
				$result2 = $conn->query($query2);
				$row2 = $result2->fetch_assoc();
				$lastval = $row2["linenum"];
				$maxval = $lastval + 1;*/
				

				//echo $maxval;

				$sqlHeaderDetails = "INSERT INTO payrolldetails (payrollid,linenum,contractid,workerid,rate,ecola,transpo,meal,workertype,dataareaid,createdby,createddatetime)
				values 
				('$sequence', '$maxval', '$contract', '$workerid', '$rate', '$ecola', '$transpo', '$meal', '$type', '$dataareaid', '$userlogin', now())";
				if(mysqli_query($conn,$sqlHeaderDetails))
				{
					echo $sqlHeaderDetails;
					$maxval = $maxval + 1;
				}
				else
				{
					echo "error".$sqlHeaderDetails."<br>".$conn->error;
				}



			}

			$sqlinsert = "call SP_PayrollDetailsAccountsCreation('$dataareaid','$sequence','$userlogin','$period')";
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

			$sqlupdateDTR = "UPDATE dailytimerecordheader dtr left join worker wk on dtr.workerid = wk.workerid 
							 and dtr.dataareaid = wk.dataareaid 
							set dtr.payrollid = '$sequence'
							where dtr.payrollperiod = '$period' and dtr.dataareaid = '$dataareaid' and wk.branch = '$branch'";
				//mysqli_query($conn,$sqlinsert);
				//echo $sqlinsert."<br>".$conn->error;
				if(mysqli_query($conn,$sqlupdateDTR))
				{
					echo $sqlupdateDTR."<br>".$conn->error;
				}
				else
				{
					echo "error".$sqlupdateDTR."<br>".$conn->error;
				}



				//getaccountsHeader($sequence,$period,$maxval,$dataareaid,$cutoff,$conn);
				//Compute($sequence,$period,$cutoff,$dataareaid,$conn);

				/*$queryCom = "SELECT * from payrolldetails where payrollid = '$sequence' and dataareaid = '$dataareaid' order by linenum desc";
					$resultCom = $conn->query($queryCom);
					
					while ($rowCom = $resultCom->fetch_assoc())
					{
						//sleep(15);
						$id = $rowCom["linenum"];
						$contract = $rowCom["contractid"];
						$wrkId = $rowCom["workerid"];

						$queryRate = "SELECT ifnull(format(mrate/2,2),0) mrate,ifnull(activemrate,0) activemrate FROM ratehistory where dataareaid = '$dataareaid' and contractid = '$contract' and status = 1";
							$resultRate = $conn->query($queryRate);
							$rowRate = $resultRate->fetch_assoc();
							$ActRate = $rowRate["activemrate"];
							$Mrate = $rowRate["mrate"];



						//$Mrate = 20000;
						//$ActRate = 0;
						getaccountsHeader($sequence,$period,$id,$dataareaid,$cutoff,$conn);
						Recompute($id,$sequence,$dataareaid,$conn,$Mrate,$ActRate,$cutoff,$period,$wrkId);

					}*/


				//Recompute($id,$payID,$dataareaid,$conn,$Mrate,$ActRate,$varPayCut,$PayPer,$wrkId);
				//RecomputeHeader($sequence,$dataareaid,$conn,$userlogin);
		}
	
	

	ComputeAll($period,$cutoff,$dataareaid,$conn,$userlogin);

	//$_SESSION['PeriodAction'] = 'ImportDtr';
	//echo "sample id";
	//header('location: dtrform.php');
	
}

else if($_GET["action"]=="proceed"){

	$period=$_GET["PayPeriod"];
	$maxval = 1;

	$sequence='';
	
	
	$PayPerquery = "SELECT 
				date_format(startdate, '%Y-%m-%d') startdate,
				date_format(enddate, '%Y-%m-%d') enddate,
				period
				FROM payrollperiod where dataareaid = '$dataareaid' 
				and payrollperiod = '$period'";
				//and (module like '%$module%') and (submodule like '%$sub%') and (name like '%$name%')";
	$PayPerresult = $conn->query($PayPerquery);
	$PayPerrow = $PayPerresult->fetch_assoc();
	$startdate=$PayPerrow["startdate"];
	$enddate=$PayPerrow["enddate"];
	$cutoff = $PayPerrow["period"];

	// $workerquery = 'select * from payrollheader where dataareaid = 'def' and payrollperiod = 'DEFPP00007'';
	// $workerResult = $conn->query($workerquery);
	// while () {
	// 	# code...
	// }

	$CreatePayroll = "call sp_createPayroll('$dataareaid','$period','$userlogin')";
			//mysqli_query($conn,$sqlinsert);
			//echo $sqlinsert."<br>".$conn->error;
			if(mysqli_query($conn,$CreatePayroll))
			{
				echo $CreatePayroll."<br>".$conn->error;
			}
			else
			{
				echo "error".$CreatePayroll."<br>".$conn->error;
			}

							//$result11->close();
			$conn->close();
			include("dbconn.php");


	ComputeAll($period,$cutoff,$dataareaid,$conn,$userlogin);
	//header('location: dtrform.php');
}


else if($_GET["action"]=="unload"){
	 	
	unset($_SESSION['DTRPeriod']);
	unset($_SESSION['DTRWorker']);
	header('location: dtrform.php');
	
}
?>

<script  type="text/javascript">
		var flaglocation='workSummary';
		var so='';
		var usernum = '';
		var myId = [];
		if(usernum == '')
		{
			so = document.getElementById("hide").value;
		}
		//var locIndex = '';
  		$(document).ready(function(){
			$('#datatbl tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","red");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();
				
				
				so = usernum.toString();
				document.getElementById("hide").value = so;
				
				if(flaglocation == 'workSummary')
				{
					//-----------get line--------------//
					var action = "getline";
					var actionmode = "userform";
					$.ajax({
						type: 'POST',
						url: 'dtrwork.php',
						data:{action:action, actmode:actionmode, transval:so},
						beforeSend:function(){
						
							$("#dtrContent").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
						},
						success: function(data){
							//payline='';
							//document.getElementById("hide2").value = "";
							$('#dtrContent').html(data);
						}
					}); 
					//-----------get line--------------//
				}
				else if(flaglocation == 'schedSummary')
				{
					//-----------get line--------------//
					var action = "getline";
					var actionmode = "userform";
					$.ajax({
						type: 'POST',
						url: 'dtrsummary.php',
						data:{action:action, actmode:actionmode, transval:so},
						beforeSend:function(){
						
							$("#dtrContent").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
						},
						success: function(data){
							//payline='';
							//document.getElementById("hide2").value = "";
							$('#dtrContent').html(data);
						}
					}); 
					//-----------get line--------------//
				}
				//flaglocation = true;
				//alert(flaglocation);
		        $("#myUpdateBtn").prop("disabled", false);	
					  
			});
		});

</script>
