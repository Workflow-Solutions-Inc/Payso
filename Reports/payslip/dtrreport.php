<?php 


$payrollperiod = $_GET['payroll'];
$dataareaid = $_GET['soc'];
$output = "";

include('dbconn.php');
require('fpdf/htmlpdf.php');


$iquery = "SELECT pp.payrollperiod,date(pp.startdate) as fromdate,date(pp.enddate) as todate,da.name 
			FROM payrollperiod pp 
            left join dataarea da on pp.dataareaid = da.dataareaid
			where  pp.payrollperiod = '$payrollperiod' and pp.dataareaid = '$dataareaid'";

$iresult = $conn->query($iquery);
$irow = $iresult->fetch_assoc();

	$company = $irow['name'];
	$frdate = $irow['fromdate'];
	$todate = $irow['todate'];


$query = "SELECT w.name,dtrh.payrollperiod,dtrh.workerid,date as Date,weekday as 'WeekDay',ifnull(TIME_FORMAT(timein,'%h:%i %p'),'00:00') as 'TimeIn',ifnull(TIME_FORMAT(timeout,'%h:%i %p'),'00:00') as 'TimeOut',daytype as 'DayType',dtrd.recid,ifnull(dtrh.modifiedby,'') as modifiedby 

							,daysworked,hoursworked,overtimehours,nightdifhours,leaves,absent,late,undertime,specialholiday,specialholidayot,specialholidaynd 
							                ,sunday,sundayot,sundaynd,holiday,holidayot,holidaynd,ifnull(break,'0.00') as 'brk'


							from dailytimerecorddetail dtrd
							left join dailytimerecordheader dtrh on
							dtrd.workerid = dtrh.workerid and dtrd.dataareaid = dtrh.dataareaid and dtrd.payrollperiod = dtrh.payrollperiod
							left join worker w on
							w.workerid = dtrd.workerid and w.dataareaid = dtrd.dataareaid
							where dtrd.payrollperiod = '$payrollperiod' and dtrd.dataareaid = '$dataareaid'
                            
                            group by workerid";
     $result = $conn->query($query);
       // $row = $result->fetch_assoc();
	$pdf=new PDF('L','mm','letter');
					$pdf->SetAutoPageBreak(false);
					
        while ($row = $result->fetch_assoc())
        {

        			$wkid = $row['workerid'];
				
					$pdf->AddPage();
					$pdf->SetFont('Arial','B',15);
					$pdf->Cell(10,10,'',0);
					$pdf->Cell(10,10,'',0);
					$pdf->Cell(78,10,'',0);
					$pdf->Cell(10,10,''."$company".'',0);
					$pdf->Cell(60,10,'',0,0);
					$pdf->Cell(60,10,'',0,0);

					$pdf->Cell(60,8,'',0,1);


					$pdf->SetFont('Arial','B',12);
					$pdf->Cell(10,10,'',0);
					$pdf->Cell(10,10,'',0);
					$pdf->Cell(92,10,'',0);
					$pdf->Cell(10,10,'DTR Reports',0);
					$pdf->Cell(60,10,'',0,0);
					$pdf->SetFont('Arial','B',8);
					$pdf->Cell(8,7,'',0,1);

					$pdf->Cell(90,10,'',0);
					$pdf->Cell(10,10,'',0);
					$pdf->Cell(60,10,'Payroll Covered: '."$frdate".' - '."$todate",0);

					$pdf->SetFont('Arial','B',9);
					$pdf->Cell(10,10,'',0,0);
					$pdf->Cell(10,10,'',0,0);
					$pdf->Cell(10,10,'',0,1);

					$html='

						<table border="0">

						<tr>
							<td width="200" height="30" bgcolor="#ffffff">Worker ID</td>
							<td width="90" height="30" bgcolor="#ffffff">Days</font></td>
							<td width="90" height="30" bgcolor="#ffffff">Hrs Worked</font></td>
							<td width="90" height="30" bgcolor="#ffffff">OverTime</font></td>
							<td width="90" height="30" bgcolor="#ffffff">NightDiff</font></td>
							<td width="90" height="30" bgcolor="#ffffff">Absent</font></td>
							<td width="90" height="30" bgcolor="#ffffff">Late</font></td>
							<td width="90" height="30" bgcolor="#ffffff">Leaves</font></td>
							<td width="90" height="30" bgcolor="#ffffff">UnderTime</font></td>
							<td width="90" height="30" bgcolor="#ffffff">Break</font></td>
						</tr>
						<tr>
							<td width="200" height="30" bgcolor="#ffffff">Name</td>
							<td width="90" height="30" bgcolor="#ffffff">RestDay</font></td>
							<td width="90" height="30" bgcolor="#ffffff">RDayOT</font></td>
							<td width="90" height="30" bgcolor="#ffffff">RDayND</font></td>
							<td width="90" height="30" bgcolor="#ffffff">Holiday</font></td>
							<td width="90" height="30" bgcolor="#ffffff">HolOT</font></td>
							<td width="90" height="30" bgcolor="#ffffff">HolND</font></td>
							<td width="90" height="30" bgcolor="#ffffff">SpeHol</font></td>
							<td width="90" height="30" bgcolor="#ffffff">SpeHolOT</font></td>
							<td width="90" height="30" bgcolor="#ffffff">SpeHolND</font></td>
						</tr>
						<tr>
						</tr>

						<tr>
							<td width="200" height="30" bgcolor="#ffffff"><font face="Arial" color="#212324">'.$row["workerid"].'</font></td>
							<td width="90" height="30" bgcolor="#ffffff"><font face="courier new" color="#212324">'.$row["daysworked"].'</font></td>
							<td width="90" height="30" bgcolor="#ffffff"><font face="courier new" color="#212324">'.$row["hoursworked"].'</font></td>
							<td width="90" height="30" bgcolor="#ffffff"><font face="courier new" color="#212324">'.$row["overtimehours"].'</font></td>
							<td width="90" height="30" bgcolor="#ffffff"><font face="courier new" color="#212324">'.$row["nightdifhours"].'</font></td>
							<td width="90" height="30" bgcolor="#ffffff"><font face="courier new" color="#212324">'.$row["absent"].'</font></td>
							<td width="90" height="30" bgcolor="#ffffff"><font face="courier new" color="#212324">'.$row["late"].'</font></td>
							<td width="90" height="30" bgcolor="#ffffff"><font face="courier new" color="#212324">'.$row["leaves"].'</font></td>
							<td width="90" height="30" bgcolor="#ffffff"><font face="courier new" color="#212324">'.$row["undertime"].'</font></td>
							<td width="90" height="30" bgcolor="#ffffff"><font face="courier new" color="#212324">'.$row["brk"].'</font></td>
						</tr>
						<tr>
							<td width="200" height="30" bgcolor="#ffffff"><font face="Arial" color="#212324">'.$row["name"].'</font></td>
							<td width="90" height="30" bgcolor="#ffffff"><font face="courier new" color="#212324">'.$row["sunday"].'</font></td>
							<td width="90" height="30" bgcolor="#ffffff"><font face="courier new" color="#212324">'.$row["sundayot"].'</font></td>
							<td width="90" height="30" bgcolor="#ffffff"><font face="courier new" color="#212324">'.$row["sundaynd"].'</font></td>
							<td width="90" height="30" bgcolor="#ffffff"><font face="courier new" color="#212324">'.$row["holiday"].'</font></td>
							<td width="90" height="30" bgcolor="#ffffff"><font face="courier new" color="#212324">'.$row["holidayot"].'</font></td>
							<td width="90" height="30" bgcolor="#ffffff"><font face="courier new" color="#212324">'.$row["holidaynd"].'</font></td>
							<td width="90" height="30" bgcolor="#ffffff"><font face="courier new" color="#212324">'.$row["specialholiday"].'</font></td>
							<td width="90" height="30" bgcolor="#ffffff"><font face="courier new" color="#212324">'.$row["specialholidayot"].'</font></td>
							<td width="90" height="30" bgcolor="#ffffff"><font face="courier new" color="#212324">'.$row["specialholidaynd"].'</font></td>
						</tr>

						</table>
							

						</tr>
						</table>
							';
					//echo $row["name"];
							$output.='
								
									<table border="0">
									
										<tr>
											<td width="100" height="25" bgcolor="#ffffff" ><font color="#ffffff"><b>       .</b></font></td>
											<td width="100" height="25" bgcolor="#73d0e6" ><font color="#73d0e6"><b>       .</b></font></td>
											<td width="150" height="25" bgcolor="#73d0e6"><font face="Verdana" color="#ffffff"><b>Date</b></font></td>
											<td width="180" height="25" bgcolor="#73d0e6" ><font color="#ffffff"><b>Time In</b></font></td>
											<td width="200" height="25" bgcolor="#73d0e6"><font color="#ffffff"><b>Time Out</b></font></td>
											<td width="180" height="25" bgcolor="#73d0e6"><font color="#ffffff"><b>Day Type</b></font></td>
										</tr>

									<td>
								
									';
					$query2 = "SELECT date as Date,weekday as 'WeekDay',ifnull(TIME_FORMAT(timein,'%h:%i %p'),'00:00') as 'TimeIn',ifnull(TIME_FORMAT(timeout,'%h:%i %p'),'00:00') as 'TimeOut',daytype as 'DayType',dtrd.recid,ifnull(dtrd.modifiedby,'') as modifiedby 


						from dailytimerecorddetail dtrd
						where  dtrd.workerid = '$wkid' and dtrd.payrollperiod = '$payrollperiod' and dtrd.dataareaid = '$dataareaid';";
							     $result2 = $conn->query($query2);
							       // $row = $result->fetch_assoc();
								
							        while ($row2 = $result2->fetch_assoc())
							        {



							        	$output.='
							        	<td>

							        	<table border="0">
									
										<tr>
											<td width="190" height="25" bgcolor="#ffffff" ><font color="#ffffff"><b>       .</b></font></td>
											<td width="160" height="25" bgcolor="#ffffff"><font color="#212324">'.$row2['Date'].'</font></td>
											<td width="180" height="25" bgcolor="#ffffff"><font color="#212324">'.$row2['TimeIn'].'</font></td>
											<td width="200" height="25" bgcolor="#ffffff"><font color="#212324">'.$row2['TimeOut'].'</font></td>
											<td width="250" height="25" bgcolor="#ffffff"><font color="#212324">'.$row2['DayType'].'</font></td>
										</tr>

										</table><td>';
							        }
							     
							   $output.='
								
									</table>
								
									';

			        	$final = $html.$output;
						$pdf->WriteHTML($final);
						$output='';
				

}

$pdf->Output('I','Payslip.pdf');

?>