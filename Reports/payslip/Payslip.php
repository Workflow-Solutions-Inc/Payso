
<?php 

/*require('fpdf/fpdf.php');

$pdf = new FPDF();
$pdf = new FPDF('P','mm','A4');
$pdf->AddPage();




$pdf->SetFont('Arial','B',15);
$pdf->Cell(10,10,'',0);
$pdf->Cell(10,10,'',0);
$pdf->Cell(40,10,'',0);
$pdf->Cell(10,10,'Company Name',0);
$pdf->Cell(60,10,'',0,0);
$pdf->Cell(60,10,'',0,0);



$pdf->Cell(60,10,'',0,1);


$pdf->SetFont('Arial','B',12);
$pdf->Cell(10,10,'',0);
$pdf->Cell(10,10,'',0);
$pdf->Cell(45,10,'',0);
$pdf->Cell(10,10,'Payslip Details',0);
$pdf->Cell(60,10,'',0,0);
$pdf->Cell(60,10,'',0,0);

$pdf->Cell(60,10,'',0,1);


$pdf->SetFont('Arial','B',9);
$pdf->Cell(15,10,'',0);
$pdf->Cell(8,10,'Name:',0);
$pdf->Cell(8,10,'',0);
$pdf->Cell(10,10,'John David Bachao',0);
$pdf->Cell(60,10,'',0,0);
$pdf->Cell(20,10,'Worker No:',0,0);
$pdf->Cell(10,10,'NEW000028',0,0);
$pdf->Cell(10,10,'',0,0);
$pdf->Cell(10,10,'',0,0);


$pdf->Output('','payslip.pdf', false);*/

$payrollid = $_GET['payroll'];
$dataareaid = $_GET['soc'];
$breakL = '-';
include('../../dbconn.php');

require('fpdf/htmlpdf.php');

$cnt = 0;

$query = "CALL payslipRPTAll('".$payrollid."', '".$dataareaid."')";
//$query = "CALL payslipRPT('WFSIPY0000005', 'WFSI', 'WFSIWR000002')";
     $result = $conn->query($query);
       // $row = $result->fetch_assoc();
	$pdf=new PDF('P','mm','letter');
	$pdf->SetAutoPageBreak(false);
		$pdf->AddPage();	

        while ($row = $result->fetch_assoc())
        {

					       $name = $row["name"];
					        $workerid = $row["workerid"];
					        $rate = $row["rate"];
					        $contractid = $row["contractid"];
					        $department = $row['department'];
					        $position = $row['position'];
					        $internalid = $row['internalid'];
					        $fromdate = $row['fromdate'];
					        $todate = $row['todate'];
					        $dataareaname = $row['dataareaname'];


					        $rdays = $row["RDAYS"];
					        $late = $row["LTE"];
					        $lateH = $row["LTEA"];
					        $overbreak = $row["OB"];
					        $overbreakH = $row["OBA"];
					        $undertime = $row["UT"];
					        $undertimeH = $row["UTA"];
					        $overtime = $row["OT"];
					        $overtimeH = $row["OTA"];
					        $nightdeferential = $row["ND"];
					        $nightdeferentialH = $row["NDA"];
					        $bpay = $row["BPAY"];
					        $abs =$row['ABS'];
					        $absa =$row['ABSA'];

					        $rdaysAmount = 0;
					        $rdayNum = (float)$rdays;
					        $rateNum = (float)$rate;

					        $tallow = $row['TALLOW'];
					        $mallow = $row['MALLOW'];

					        $rdaysAmount = number_format($rdayNum * $rateNum,2);

					        $sholiday = $row["SHOL"];
					        $sholidayH = $row["SHOLA"];
					        $sholidayot = $row["SHOLOT"];
					        $sholidayotH = $row["SHOLOTA"];
					        $lholiday = $row["LHOL"];
					        $lholidayH = $row["LHOLA"];
					        $lholidayot = $row["LHOLOT"];
					        $lholidayotH = $row["LHOLOTA"];
					        $restday = $row["SUN"];
					        $restdayH = $row["SUNA"];


					        $sss = number_format($row["SSS"],2);
					        $SSSMPFEE = number_format($row["SSSMPFEE"],2);
					        $philhealth = number_format($row["PH"],2);;
					        $pagibig = $row["PIBIG"];
					        $pagibigl = $row["PIBIGL"];
					        $ssloan  = number_format($row["SSSL"],2);
					        $overp 	 = number_format($row["OPAY"],2);

					        $ecola = $row["ecola"];
					        $prm = $row["PRM"];
					        $aback = $row["ABACK"];

					        $ufm = $row["UFM"];
					        $shuttle = $row["SHTTL"];
					        $ochrg = $row["OCHRG"];

					        $tax = $row["WTAX"];

					        $cbond = $row["CBOND"];
					        $cadvance = $row["CADV"];
					        $cchrg = $row["CCHRG"];

					        $apt = $row["APT"];
					       
					        $ctn = $row["CTN"];

					        $tded = $row["TDED"];
					        $npay = $row["NPAY"];
					        $gpay = $row['GPAY'];
					
					if($cnt == 3)
					{
						
						$cnt= 0;
						$pdf->AddPage();
					}
					
					

					$pdf->SetFont('Arial','',8);
					;
					$html='

					<table border="0" >

							<tr>
								
								<td width="187" height="30" bgcolor="#ffffff">Name:</td><td></td> <td></td> <td></td>
								<td width="120" height="30" bgcolor="#ffffff">Over Break:</td><td width="67" height="30" bgcolor="#ffffff" align="RIGHT">'.$overbreak.'</td><td></td> <td></td> <td></td>
								<td width="120" height="30" bgcolor="#ffffff">Restday:</td><td width="67" height="30" bgcolor="#ffffff" align="RIGHT">'.$restday.'</td><td></td> <td></td> <td></td>
								<td width="120" height="30" bgcolor="#ffffff">SSS:</td><td width="67" height="30" bgcolor="#ffffff" align="RIGHT">'.$sss.'</td><td></td> <td></td> <td></td>
								
							</tr>
							<tr>
								
								<td width="187" height="30" bgcolor="#ffffff" ><b>'.ucwords(strtolower($name)).'</b></td><td></td> <td></td> <td></td>
								<td width="120" height="30" bgcolor="#ffffff">Over Break Amt:</td><td width="67" height="30" bgcolor="#ffffff" align="RIGHT">'.$overbreakH.'</td><td></td> <td></td> <td></td>
								<td width="120" height="30" bgcolor="#ffffff">Restday Amt:</td><td width="67" height="30" bgcolor="#ffffff" align="RIGHT">'.$restdayH.'</td><td></td> <td></td> <td></td>
								<td width="120" height="30" bgcolor="#ffffff">SSSMPFEE:</td><td width="67" height="30" bgcolor="#ffffff" align="RIGHT">'.$SSSMPFEE.'</td><td></td> <td></td> <td></td>
								
							</tr>
							<tr>
								
								<td width="187" height="30" bgcolor="#ffffff">Employee ID: '.$internalid.'</td><td></td> <td></td> <td></td>
								<td width="120" height="30" bgcolor="#ffffff">Undertime:</td><td width="67" height="30" bgcolor="#ffffff" align="RIGHT">'.$undertime.'</td><td></td> <td></td> <td></td>
								<td width="120" height="30" bgcolor="#ffffff">Special Hol:</td><td width="67" height="30" bgcolor="#ffffff" align="RIGHT">'.$sholiday.'</td><td></td> <td></td> <td></td>
								<td width="120" height="30" bgcolor="#ffffff">PAG-IBIG:</td><td width="67" height="30" bgcolor="#ffffff" align="RIGHT">'.$pagibig.'</td><td></td> <td></td> <td></td>
								
							</tr>
							<tr>

								<td width="187" height="30" bgcolor="#ffffff">Company: '.$dataareaname.'</td><td></td> <td></td> <td></td>
								<td width="120" height="30" bgcolor="#ffffff">Undertime Amt:</td><td width="67" height="30" bgcolor="#ffffff" align="RIGHT">'.$undertimeH.'</td><td></td> <td></td> <td></td>
								<td width="120" height="30" bgcolor="#ffffff">S. Hol Amt:</td><td width="67" height="30" bgcolor="#ffffff" align="RIGHT">'.$sholidayH.'</td><td></td> <td></td> <td></td>
								<td width="120" height="30" bgcolor="#ffffff">PHIC:</td><td width="67" height="30" bgcolor="#ffffff" align="RIGHT">'.$philhealth.'</td><td></td> <td></td> <td></td>
								
							</tr>
							<tr>
					
								<td width="187" height="30" bgcolor="#ffffff">Position: '.ucwords(strtolower($position)).'</td><td></td> <td></td> <td></td>
								<td width="120" height="30" bgcolor="#ffffff">Absent:</td><td width="67" height="30" bgcolor="#ffffff" align="RIGHT">'.$abs.'</td><td></td> <td></td> <td></td>
								<td width="120" height="30" bgcolor="#ffffff">S. Hol OT:</td><td width="67" height="30" bgcolor="#ffffff" align="RIGHT">'.$sholidayot.'</td><td></td> <td></td> <td></td>
								<td width="120" height="30" bgcolor="#ffffff">TAX:</td><td width="67" height="30" bgcolor="#ffffff" align="RIGHT">'.$tax.'</td><td></td> <td></td> <td></td>
								
							</tr>
							<tr>
								
								<td width="187" height="30" bgcolor="#ffffff">Payroll Covered:</td><td></td> <td></td> <td></td>
								<td width="120" height="30" bgcolor="#ffffff">Absent Amt:</td><td width="67" height="30" bgcolor="#ffffff" align="RIGHT">'.$absa.'</td><td></td> <td></td> <td></td>
								<td width="120" height="30" bgcolor="#ffffff">S. Hol OT Amt:</td><td width="67" height="30" bgcolor="#ffffff" align="RIGHT">'.$sholidayotH.'</td><td></td> <td></td> <td></td>
								<td width="120" height="30" bgcolor="#ffffff">SSS Loan:</td><td width="67" height="30" bgcolor="#ffffff" align="RIGHT">'.$ssloan.'</td><td></td> <td></td> <td></td>
								
							</tr>
							<tr>
								
								<td width="187" height="30" bgcolor="#ffffff">'.$fromdate.' - '.$todate.'</td><td></td> <td></td> <td></td>
								<td width="120" height="30" bgcolor="#ffffff">&nbsp;</td><td width="67" height="30" bgcolor="#ffffff">&nbsp;</td><td></td> <td></td> <td></td>
								<td width="120" height="30" bgcolor="#ffffff">Legal Hol:</td><td width="67" height="30" bgcolor="#ffffff" align="RIGHT">'.$lholiday.'</td><td></td> <td></td> <td></td>
								<td width="120" height="30" bgcolor="#ffffff">PAG-IBIG Loan:</td><td width="67" height="30" bgcolor="#ffffff" align="RIGHT">'.$pagibigl.'</td><td></td> <td></td> <td></td>
								
							</tr>
							<tr>
								
								<td width="187" height="30" bgcolor="#ffffff">Recieved:</td><td></td> <td></td> <td></td>
								<td width="120" height="30" bgcolor="#ffffff">Overtime:</td><td width="67" height="30" bgcolor="#ffffff" align="RIGHT">'.$overtime.'</td><td></td> <td></td> <td></td>
								<td width="120" height="30" bgcolor="#ffffff">L. Hol Amt:</td><td width="67" height="30" bgcolor="#ffffff" align="RIGHT">'.$lholidayH.'</td><td></td> <td></td> <td></td>
								<td width="120" height="30" bgcolor="#ffffff">Cash Adv.:</td><td width="67" height="30" bgcolor="#ffffff" align="RIGHT">'.$cadvance.'</td><td></td> <td></td> <td></td>
								
							</tr>
							<tr>
								
								<td width="187" height="30" bgcolor="#ffffff">__________________________</td><td></td> <td></td> <td></td>
								<td width="120" height="30" bgcolor="#ffffff">Overtime Amt:</td><td width="67" height="30" bgcolor="#ffffff" align="RIGHT">'.$overtimeH.'</td><td></td> <td></td> <td></td>
								<td width="120" height="30" bgcolor="#ffffff">L. Hol OT:</td><td width="67" height="30" bgcolor="#ffffff" align="RIGHT">'.$lholidayot.'</td><td></td> <td></td> <td></td>
								<td width="120" height="30" bgcolor="#ffffff">&nbsp;</td><td width="67" height="30" bgcolor="#ffffff">&nbsp;</td><td></td> <td></td> <td></td>
								
							</tr>
							<tr>
								<td width="120" height="30" bgcolor="#ffffff">Daily Rate:</td><td width="67" height="30" bgcolor="#ffffff" align="RIGHT">'.$rate.'</td><td></td> <td></td> <td></td>
								<td width="120" height="30" bgcolor="#ffffff">Night Diff:</td><td width="67" height="30" bgcolor="#ffffff" align="RIGHT">'.$nightdeferential.'</td><td></td> <td></td> <td></td>
								<td width="120" height="30" bgcolor="#ffffff">L. Hol OT Amt:</td><td width="67" height="30" bgcolor="#ffffff" align="RIGHT">'.$lholidayotH.'</td><td></td> <td></td> <td></td>
								<td width="120" height="30" bgcolor="#ffffff">&nbsp;</td><td width="67" height="30" bgcolor="#ffffff">&nbsp;</td><td></td> <td></td> <td></td>
								
							</tr>

							<tr>
								<td width="120" height="30" bgcolor="#ffffff">Days:</td><td width="67" height="30" bgcolor="#ffffff" align="RIGHT">'.$rdays.'</td><td></td> <td></td> <td></td>
								<td width="120" height="30" bgcolor="#ffffff">Night Diff Amt:</td><td width="67" height="30" bgcolor="#ffffff" align="RIGHT">'.$nightdeferentialH.'</td><td></td> <td></td> <td></td>
								<td width="120" height="30" bgcolor="#ffffff">&nbsp;</td><td width="67" height="30" bgcolor="#ffffff">&nbsp;</td><td></td> <td></td> <td></td>
								<td width="120" height="30" bgcolor="#ffffff">&nbsp;</td><td width="67" height="30" bgcolor="#ffffff">&nbsp;</td>
							</tr>

							<tr>
								<td width="120" height="30" bgcolor="#ffffff">Basic Pay:</td><td width="67" height="30" bgcolor="#ffffff" align="RIGHT">'.$bpay.'</td><td></td> <td></td> <td></td>
								<td width="120" height="30" bgcolor="#ffffff">Transpo:</td><td width="67" height="30" bgcolor="#ffffff" align="RIGHT">'.$tallow.'</td><td></td> <td></td> <td></td>
								<td width="120" height="30" bgcolor="#ffffff">&nbsp;</td><td width="67" height="30" bgcolor="#ffffff">&nbsp;</td><td></td> <td></td> <td></td>
								<td width="120" height="30" bgcolor="#ffffff">&nbsp;</td><td width="67" height="30" bgcolor="#ffffff">&nbsp;</td>
							</tr>

							<tr>
								<td width="120" height="30" bgcolor="#ffffff">&nbsp;</td><td width="67" height="30" bgcolor="#ffffff">&nbsp;</td><td></td> <td></td> <td></td>
								<td width="120" height="30" bgcolor="#ffffff">Meal:</td><td width="67" height="30" bgcolor="#ffffff" align="RIGHT">'.$mallow.'</td><td></td> <td></td> <td></td>
								<td width="120" height="30" bgcolor="#ffffff">&nbsp;</td><td width="67" height="30" bgcolor="#ffffff">&nbsp;</td><td></td> <td></td> <td></td>
								<td width="120" height="30" bgcolor="#ffffff">&nbsp;</td><td width="67" height="30" bgcolor="#ffffff">&nbsp;</td>
							</tr>

							<tr>
								<td width="120" height="30" bgcolor="#ffffff">Late:</td><td width="67" height="30" bgcolor="#ffffff" align="RIGHT">'.$late.'</td><td></td> <td></td> <td></td>
								<td width="120" height="30" bgcolor="#ffffff">&nbsp;</td><td width="67" height="30" bgcolor="#ffffff">&nbsp;</td><td></td> <td></td> <td></td>
								<td width="120" height="30" bgcolor="#ffffff">&nbsp;</td><td width="67" height="30" bgcolor="#ffffff">&nbsp;</td><td></td> <td></td> <td></td>
								<td width="120" height="30" bgcolor="#ffffff">&nbsp;</td><td width="67" height="30" bgcolor="#ffffff">&nbsp;</td>
							</tr>

							<tr>
								<td width="120" height="30" bgcolor="#ffffff">Late Amt:</td><td width="67" height="30" bgcolor="#ffffff" align="RIGHT">'.$lateH.'</td><td></td> <td></td> <td></td>
								<td width="120" height="30" bgcolor="#ffffff">&nbsp;</td><td width="67" height="30" bgcolor="#ffffff">&nbsp;</td><td></td> <td></td> <td></td>
								<td width="120" height="30" bgcolor="#ffffff">&nbsp;</td><td width="67" height="30" bgcolor="#ffffff">&nbsp;</td><td></td> <td></td> <td></td>
								<td width="120" height="30" bgcolor="#ffffff">&nbsp;</td><td width="67" height="30" bgcolor="#ffffff">&nbsp;</td>
							</tr>

							<tr>
								<td width="120" height="30" bgcolor="#ffffff">&nbsp;</td><td width="67" height="30" bgcolor="#ffffff">&nbsp;</td><td></td> <td></td> <td></td>
								<td width="120" height="30" bgcolor="#ffffff">Gross Pay:</td><td width="67" height="30" bgcolor="#ffffff" align="RIGHT"><font color="black">'.$gpay.'</font></td><td></td> <td></td> <td></td>
								<td width="120" height="30" bgcolor="#ffffff">Total Ded:</td><td width="67" height="30" bgcolor="#ffffff" align="RIGHT"><font color="black">'.$tded.'</font></td><td></td> <td></td> <td></td>
								<td width="120" height="30" bgcolor="#ffffff">Net Pay:</td><td width="67" height="30" bgcolor="#ffffff" align="RIGHT"><font color="black">'.$npay.'</font></td>
							</tr>
							
							

					</table>
					<br>
					<hr>
					<br>

					';
					$cnt++;
					$pdf->WriteHTML($html);
				

}

$pdf->Output('I','Payslip.pdf');

?>