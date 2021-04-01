<?php
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
session_start();
include("dbconn.php");
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
$paynum = $_SESSION['paynum'];

/*if(isset($_GET["save"])) {
	 
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
	
}*/
if($_GET["action"]=="update"){
	 
	 $id=$_GET["PTcode"];
	 $value=$_GET["PTvalue"];
	 $line=$_GET["PTline"];
	 
	 
	if($id != ""){
	 $sql = "UPDATE payrolldetailsaccounts SET
				value = '$value',
				modifiedby = '$userlogin',
				modifieddatetime = now()
				WHERE accountcode = '$id'
				and payrollid = '$paynum'
				and reflinenum = '$line'
				and dataareaid = '$dataareaid'";
		if(mysqli_query($conn,$sql))
		{
			/*$query = "SELECT a.accountcode,format(a.value,2) as value,format(c.rate,2) as rate,format(c.transpo,2) as transpo,format(c.ecola,2) as ecola,format(c.meal,2) as meal
						from payrolldetailsaccounts a
						left join payrolldetails c  on
						a.payrollid = c.payrollid and 
						a.reflinenum = c.linenum and
						a.dataareaid = c.dataareaid

						where a.payrollid = '$paynum'
						and a.reflinenum = '$line'
						and a.dataareaid = '$dataareaid'
						and a.accounttype != 2
						order by a.priority";
			$result = $conn->query($query);

			while ($row = $result->fetch_assoc())
			{
				//select here then update

				$account = $row["accountcode"];
				$upval = $row["value"];
				$rate = $row["rate"];
				$transpo = $row["transpo"];
				$ecola = $row["ecola"];
				$meal = $row["meal"];

				$query2 = "SELECT a.accountcode as accountcode1,b.value
							FROM payrolldetailcomputation a
							left join payrolldetailsaccounts b
							on a.accountcode = b.accountcode and
							a.payrollid = b.payrollid and
							a.reflinenum = b.reflinenum and
							a.dataareaid = b.dataareaid

							where formula like '%$account%' 
							and a.payrollid = '$paynum'
							and a.reflinenum = '$line'
							and a.dataareaid = '$dataareaid'
							order by b.priority";
				$result2 = $conn->query($query2);

				while ($row2 = $result2->fetch_assoc())
				{
					$upaccount = $row2["accountcode1"];

					$query4 = "SELECT format(a.value,2) as value
							from payrolldetailsaccounts a
							where a.payrollid = '$paynum'
							and a.reflinenum = '$line'
							and a.dataareaid = '$dataareaid'
							and a.accounttype != 2
							and a.accountcode = '$account'
							order by a.priority";
							$result4 = $conn->query($query4);
							$row4 = $result4->fetch_assoc();
							$upval = $row4["value"];

					$sql2 = "UPDATE payrolldetailcomputation SET
								formula = REPLACE(replace(replace(replace(replace(formula,CONCAT('[','$account',']'),'$upval'),'[rate]','$rate'),'[ecola]','$ecola'),'[transpo]','$transpo'),'[meal]','$meal')
								WHERE 
								accountcode = '$upaccount'
								and payrollid = '$paynum'
								and reflinenum = '$line'
								and dataareaid = '$dataareaid'";
								if(mysqli_query($conn,$sql2))
								{
									$query3 = "SELECT a.accountcode,a.formula
											from payrolldetailcomputation a
											

											where a.accountcode = '$upaccount' and
											a.payrollid = '$paynum'
											and a.reflinenum = '$line'
											and a.dataareaid = '$dataareaid'
											and a.createdby = '$userlogin'";
											echo "sql2=".$sql2."<br>";
									$result3 = $conn->query($query3);

									while ($row3 = $result3->fetch_assoc())
									{
										$account3 = $row3["accountcode"];
										$formula = $row3["formula"];
										$res = preg_replace("/[^0-9\+\-*\/\.,() ]/", "0", $formula); */
										/*try
									    {
									        eval('$comresult = '.$res.';');
									        //echo $comresult;
									    }
									    catch (ParseError $err)
									    {
									        $comresult = 0;
									        //echo $comresult;
									    }*/
									  /* $res =  preg_replace("/[^0-9\+\-*\/\.() ]/", "", $res);

										//$upval = $row["value"];
										//$rate = $row["rate"];
										//$transpo = $row["transpo"];
										//$ecola = $row["ecola"];
										//$meal = $row["meal"];
										$sql3 = "UPDATE payrolldetailsaccounts SET
										value = $res
										WHERE accountcode = '$account3'
										and payrollid = '$paynum'
										and reflinenum = '$line'
										and dataareaid = '$dataareaid'
										and accounttype = 1";
										if(mysqli_query($conn,$sql3))
										{
											echo "sql3=".$sql3."<br>";
										}
										else
										{
											echo "error".$sql3."<br>".$conn->error;
										}
									}

								}
								else
								{
									echo "error".$sql2."<br>".$conn->error;
								}
				}
				
				
			}*/
			/*$query = "SELECT a.accountcode,a.formula
						from payrolldetailcomputation a
						

						where a.payrollid = '$paynum'
						and a.reflinenum = '$line'
						and a.dataareaid = '$dataareaid'
						and a.createdby = '$userlogin'";
			$result = $conn->query($query);

			while ($row = $result->fetch_assoc())
			{
				$account = $row["accountcode"];
				$formula = $row["formula"];
				$res = preg_replace("/[^0-9\+\-*\/\.,()]/", "0", $formula); */
				/*try
			    {
			        eval('$comresult = '.$res.';');
			        //echo $comresult;
			    }
			    catch (ParseError $err)
			    {
			        $comresult = 0;
			        //echo $comresult;
			    }
			   $comresult =  preg_replace("/[^0-9\+\-*\/\.,]/", "0", $comresult)*/

				//$upval = $row["value"];
				//$rate = $row["rate"];
				//$transpo = $row["transpo"];
				//$ecola = $row["ecola"];
				//$meal = $row["meal"];
				/*$sql2 = "UPDATE payrolldetailsaccounts SET
				value = $formula
				WHERE accountcode = '$account'
				and payrollid = '$paynum'
				and reflinenum = '$line'
				and dataareaid = '$dataareaid'
				and accounttype = 1";
				if(mysqli_query($conn,$sql2))
				{
					echo "Rec Updated";
				}
				else
				{
					echo "error".$sql."<br>".$conn->error;
				}
			}*/


			/*$output='';
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
						FROM payrolldetailsaccounts
						where payrollid = '$paynum'
						and reflinenum = '$line'
						and dataareaid = '$dataareaid'
						order by priority";

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
					<td style="width:20%;">'.$row["accountcode"].'</td>
					<td style="width:20%;">'.$row["accountname"].'</td>
					<td style="width:20%;">'.$row["um"].'</td>
					<td style="width:20%;">'.$row["accounttype"].'</td>
					<td style="width:20%;">'.$row["value"].'</td>
				</tr>';
			}
			//$output .= '</tbody>';
			echo $output;*/
			
			
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}
		$_SESSION['paylinenum'] = $line;
		header('location: payrolltransactiondetailline.php');

	}
	 	//$_SESSION['paylinenum'] = $line;
	//	header('location: payrolltransactiondetailline.php');
	//header('location: payrolltransactiondetail.php'); 
			
}
else if($_GET["action"]=="recompute"){
	 

	$id=$_GET["PTline"];

	if($id != ""){
		/*$sqldelete = "DELETE from payrolldetailcomputation


							where payrollid = '$paynum'
							and reflinenum = '$id'
							and dataareaid = '$dataareaid'";
							if(mysqli_query($conn,$sqldelete))
							{
								//echo "sql=".$sql."<br>";
								echo "Rec Deleted";
							}
							else
							{
								echo "error".$sqldelete."<br>".$conn->error;
							}
		$sqlinsert = "INSERT into payrolldetailcomputation
							SELECT
							a.payrollid,
							a.reflinenum,
							a.accountcode,
							b.formula,
							a.dataareaid,
							"."'".$userlogin."'".",
							0

							FROM payrolldetailsaccounts a 
							left join accounts b on 
							a.accountcode = b.accountcode and
							a.accounttype = b.accounttype and
							a.dataareaid  = b.dataareaid
							left join payrolldetails c on
							c.payrollid = a.payrollid and
							c.linenum = a.reflinenum
								
							    
							where a.payrollid = '$paynum'
							and a.reflinenum = '$id'
							and a.dataareaid = '$dataareaid'

							order by a.priority asc";
							if(mysqli_query($conn,$sqlinsert))
							{
								//echo "sql=".$sql."<br>";
								echo "Rec Inserted";
							}
							else
							{
								echo "error".$sqlinsert."<br>".$conn->error;
							}*/
		$sqlinsert = "call PT_PayrollComputation('$paynum','$dataareaid','$id','ins')";
			if(mysqli_query($conn,$sqlinsert))
			{
				echo "Rec Activated";
			}
			else
			{
				echo "error".$sqlinsert."<br>".$conn->error;
			}
							
		/*$query = "SELECT format(c.rate,2) as rate,format(c.transpo,2) as transpo,format(c.ecola,2) as ecola,format(c.meal,2) as meal
						from payrolldetailsaccounts a
						left join payrolldetails c  on
						a.payrollid = c.payrollid and 
						a.reflinenum = c.linenum and
						a.dataareaid = c.dataareaid

						where a.payrollid = '$paynum'
						and a.reflinenum = '$id'
						and a.dataareaid = '$dataareaid'
						group by c.rate,c.transpo,c.ecola,c.meal
						order by a.priority";
		$result = $conn->query($query);
		while ($row = $result->fetch_assoc())
			{
				//select here then update
				$rate = $row["rate"];
				$transpo = $row["transpo"];
				$ecola = $row["ecola"];
				$meal = $row["meal"];
			}
		$sql = "UPDATE payrolldetailcomputation SET
					formula = REPLACE(replace(replace(replace(formula,'[rate]','$rate'),'[ecola]','$ecola'),'[transpo]','$transpo'),'[meal]','$meal')
					WHERE 
					payrollid = '$paynum'
					and reflinenum = '$id'
					and dataareaid = '$dataareaid'";
				if(mysqli_query($conn,$sql))
					{
						//echo "sql=".$sql."<br>";
						echo "Rec Updated";
					}
					else
					{
						echo "error".$sql."<br>".$conn->error;
					}*/
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
					$sql2 = "UPDATE payrolldetailcomputation SET
					formula = replace(formula,CONCAT('[','$acccode',']'),'$accvalue')
					WHERE 
					payrollid = '$paynum'
					and reflinenum = '$id'
					and dataareaid = '$dataareaid'";
				if(mysqli_query($conn,$sql2))
					{
						//echo "sql2=".$sql2."<br>";
						echo "Rec Updated";
					}
					else
					{
						echo "error".$sql2."<br>".$conn->error;
					}
				}
				

			}
		$query3 = "SELECT a.accountcode,a.value,b.formula
					
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
		$result3 = $conn->query($query3);
		while ($row3 = $result3->fetch_assoc())
			{
				//select here then update
				$acccode2 = $row3["accountcode"];
				//$accformula = $row3["formula"];
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
						$res = preg_replace("/[^0-9\+\-*\/\.,() ]/", "0", $accformula3); 
									
						$res =  preg_replace("/[^0-9\+\-*\/\.() ]/", "", $res);
						eval('$comresult = '.$res.';');
						if($comresult != 0){

							$sql3 = "UPDATE payrolldetailcomputation SET
							formula = replace(formula,CONCAT('[','$acccode3',']'),$comresult)
							WHERE 
							payrollid = '$paynum'
							and reflinenum = '$id'
							and dataareaid = '$dataareaid'";
						if(mysqli_query($conn,$sql3))
							{
								//echo "sql3=".$sql3."<br>";
								echo "Rec Updated";
							}
							else
							{
								echo "error".$sql3."<br>".$conn->error;
							}
						}
						
			}
		/*select for condition*/
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

						if($comresult != 0){

							$sql3 = "UPDATE payrolldetailsaccounts SET
							value = $comresult
							WHERE 
							payrollid = '$paynum'
							and reflinenum = '$id'
							and dataareaid = '$dataareaid'
							and accountcode = '$acccode4'";
						if(mysqli_query($conn,$sql3))
							{
								//echo "sql3=".$sql3."<br>";
								echo "Rec Updated";
							}
							else
							{
								echo "error".$sql3."<br>".$conn->error;
							}
						}
						
			}
		

	$_SESSION['paylinenum'] = $id;
	header('location: payrolltransactiondetailline.php');
	}
	//$_SESSION['paylinenum'] = $id;
	//header('location: payrolltransactiondetailline.php');
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
				<td style="width:20px;"><span class="fa fa-adjust"></span></td>
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
		var so='';
	  	var payline='';
  		$(document).ready(function(){
			$('#datatbl tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","red");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(8)").text();
				so = usernum.toString();
				document.getElementById("hide").value = so;
				//alert(document.getElementById("hide").value);
				//alert(so);
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