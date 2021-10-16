<?php 


$payrollperiod = $_GET['payroll'];
$dataareaid = $_GET['soc'];
$output = "";

include('../../dbconn.php');
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

							,format(daysworked,2) as daysworked,format(hoursworked,2) as hoursworked,format(overtimehours,2) as overtimehours,format(nightdifhours,2) as nightdifhours,
                            format(leaves,2) as leaves,format(absent,2) as absent,format(late,2) as late,format(undertime,2) as undertime,format(specialholiday,2) as specialholiday,
                            format(specialholidayot,2) as specialholidayot,format(specialholidaynd,2) as specialholidaynd ,format(sunday,2) as  sunday,format(sundayot,2) as sundayot,
                            format(sundaynd,2) as sundaynd,format(holiday,2) as holiday,format(holidayot,2) as holidayot,format(holidaynd,2) as holidaynd,format(ifnull(break,'0.00'),2) as 'brk'


							from dailytimerecorddetail dtrd
							left join dailytimerecordheader dtrh on
							dtrd.workerid = dtrh.workerid and dtrd.dataareaid = dtrh.dataareaid and dtrd.payrollperiod = dtrh.payrollperiod
							left join worker w on
							w.workerid = dtrd.workerid and w.dataareaid = dtrd.dataareaid
							where dtrd.payrollperiod = '$payrollperiod' and dtrd.dataareaid = '$dataareaid'
                            and dtrd.weekday is not null
                            #group by workerid;
                            ";

     $result = $conn->query($query);
       // $row = $result->fetch_assoc();
	$pdf=new PDF('L','mm','letter');
					$pdf->SetAutoPageBreak(false);

				$wkid = ""; //Added by Mar, fix duplicate names in the report, September 8, 2021, PCC Payso
					
        while ($row = $result->fetch_assoc())
        {
        	//Added by Mar, fix duplicate names in the report, September 8, 2021, PCC Payso ->
        	if ($wkid != $row['workerid']) 
        	{
        	//Added by Mar, fix duplicate names in the report, September 8, 2021, PCC Payso <-

        			$wkid = $row['workerid'];
				
							$pdf->AddPage();
							$pdf->SetFont('Arial','B',15);
							/*$pdf->Cell(10,10,'',0);
							$pdf->Cell(10,10,'',0);
							$pdf->Cell(78,10,'',0);*/
							$pdf->Cell(0,10,''."$company".'',0,0, 'C');
							$pdf->Cell(0,0,'',0,1);
							$pdf->SetFont('Arial','B',12);
							$pdf->Cell(0,25,'Daily Time Record',0,0, 'C');

							$pdf->Cell(0,0,'',0,1);
							$pdf->Cell(0,35,'Payroll Covered: '."$frdate".' - '."$todate",0,0, 'C');

							/*$pdf->Cell(60,10,'',0,0);
							$pdf->Cell(60,10,'',0,0);

							$pdf->Cell(60,8,'',0,1);


							$pdf->SetFont('Arial','B',12);
							$pdf->Cell(10,10,'',0);
							$pdf->Cell(10,10,'',0);
							$pdf->Cell(92,10,'',0);
							$pdf->Cell(10,10,'DTR Reports',0,0, 'C');
							$pdf->Cell(60,10,'',0,0);
							$pdf->SetFont('Arial','B',8);
							$pdf->Cell(8,7,'',0,1);

							$pdf->Cell(90,10,'',0);
							$pdf->Cell(10,10,'',0);
							$pdf->Cell(60,10,'Payroll Covered: '."$frdate".' - '."$todate",0);*/

							$pdf->SetFont('Arial','B',9);
							$pdf->Cell(10,10,'',0,0);
							$pdf->Cell(10,10,'',0,0);
							$pdf->Cell(10,25,'',0,1);

							$html='

								<table border="0">

								<tr>
									<td width="200" height="30" bgcolor="#ffffff">Worker ID</td>
									<td width="90" height="30" bgcolor="#ffffff">Days</font></td>
									<td width="90" height="30" bgcolor="#ffffff">hrs Worked</font></td>
									<td width="90" height="30" bgcolor="#ffffff">OT</font></td>
									<td width="90" height="30" bgcolor="#ffffff">ND</font></td>
									<td width="90" height="30" bgcolor="#ffffff">Absent</font></td>
									<td width="90" height="30" bgcolor="#ffffff">Late</font></td>
									<td width="90" height="30" bgcolor="#ffffff">Leaves</font></td>
									<td width="90" height="30" bgcolor="#ffffff">Undertime</font></td>
									<td width="90" height="30" bgcolor="#ffffff">Over Break</font></td>
								</tr>
								<tr>
									<td width="200" height="30" bgcolor="#ffffff">Name</td>
									<td width="90" height="30" bgcolor="#ffffff">Rest Days</font></td>
									<td width="90" height="30" bgcolor="#ffffff">Rest Days OT</font></td>
									<td width="90" height="30" bgcolor="#ffffff">Rest Days ND</font></td>
									<td width="90" height="30" bgcolor="#ffffff">Holiday</font></td>
									<td width="90" height="30" bgcolor="#ffffff">Holiday OT</font></td>
									<td width="90" height="30" bgcolor="#ffffff">Holiday ND</font></td>
									<td width="90" height="30" bgcolor="#ffffff">Spl Holiday</font></td>
									<td width="95" height="30" bgcolor="#ffffff">Spl Holiday OT</font></td>
									<td width="90" height="30" bgcolor="#ffffff">Spl Holiday ND</font></td>
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
													<td width="1" height="25" bgcolor="#ffffff" ><font color="#ffffff"><b>       .</b></font></td>
													<td width="20" height="25" bgcolor="#73d0e6" ><font color="#73d0e6"><b>       .</b></font></td>
													<td width="125" height="25" bgcolor="#73d0e6"><font face="Verdana" color="#ffffff"><b>Date</b></font></td>
													<td width="170" height="25" bgcolor="#73d0e6" ><font color="#ffffff"><b>Time In</b></font></td>
													<td width="190" height="25" bgcolor="#73d0e6"><font color="#ffffff"><b>Break Out</b></font></td>
													<td width="180" height="25" bgcolor="#73d0e6" ><font color="#ffffff"><b>Break In</b></font></td>
													<td width="180" height="25" bgcolor="#73d0e6"><font color="#ffffff"><b>Time Out</b></font></td>
													<td width="180" height="25" bgcolor="#73d0e6"><font color="#ffffff"><b>Day Type</b></font></td>
												</tr>

											<td>
										
											';

							$query2 = "SELECT date as Date,weekday as 'WeekDay',ifnull(TIME_FORMAT(timein,'%h:%i %p'),'00:00') as 'TimeIn',
							ifnull(TIME_FORMAT(timeout,'%h:%i %p'),'00:00') as 'TimeOut',
							ifnull(TIME_FORMAT(breakout,'%h:%i %p'),'00:00') as 'BreakOut',
							ifnull(TIME_FORMAT(breakin,'%h:%i %p'),'00:00') as 'BreakIn',
							daytype as 'DayType',dtrd.recid,ifnull(dtrd.modifiedby,'') as modifiedby 


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
													
													<td width="150" height="25" bgcolor="#ffffff"><font color="#212324">'.$row2['Date'].'</font></td>
													<td width="180" height="25" bgcolor="#ffffff"><font color="#212324">'.$row2['TimeIn'].'</font></td>
													<td width="180" height="25" bgcolor="#ffffff"><font color="#212324">'.$row2['BreakOut'].'</font></td>
													<td width="180" height="25" bgcolor="#ffffff"><font color="#212324">'.$row2['BreakIn'].'</font></td>
													<td width="180" height="25" bgcolor="#ffffff"><font color="#212324">'.$row2['TimeOut'].'</font></td>
													<td width="180" height="25" bgcolor="#ffffff"><font color="#212324">'.$row2['DayType'].'</font></td>
												</tr>

												</table><td>';
									        }
									     
									   $output.='
										
											</table>
										
											';

					        	$final = $html.$output;
								$pdf->WriteHTML($final);
								$output='';
					} //Added by Mar, fix duplicate names in the report, September 8, 2021, PCC Payso

}

$pdf->Output('I','Daily Time Record Report.pdf');

?>