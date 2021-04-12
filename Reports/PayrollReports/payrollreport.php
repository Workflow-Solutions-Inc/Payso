<?php 

//require_once('tcpdf_min\tcpdf.php');
include(__DIR__ . '/tcpdf_min/tcpdf.php');
include('dbconn2.php');

$payrollid_ = $_GET['payroll'];
$dataarea = $_GET['soc'];


// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    //Page header
    public function Header() {

    include('dbconn2.php');

    $payrollid_ = $_GET['payroll'];
    $dataarea = $_GET['soc'];
  
$query_ph = " select concat('Payroll Cover: ' ,date_format(fromdate,'%m/%d/%Y'), ' - ' ,date_format(todate,'%m/%d/%Y')) as 'ph_date',da.name as 'Company',br.name as 'Branch'  from payrollheader ph
                            left join branch br on 
                            ph.branchcode = br.branchcode and
                            ph.dataareaid = br.dataareaid

                            left join dataarea da on
                            ph.dataareaid = da.dataareaid
                            where ph.payrollid = '".$payrollid_."' and ph.dataareaid = '".$dataarea."' ";

        $result_ph = $conn->query($query_ph);
        $row_ph = $result_ph->fetch_assoc();

        $ph_date = $row_ph['ph_date']; 
        $brn_ = $row_ph['Branch'];
        $comp = $row_ph['Company'];
        //$comp = "Demo";
        // Logo
         $this->SetY(5);
      
        // Set font
        $this->SetFont('helvetica', 'B', 13); 
        $this->SetTextColor(0,0,0);
        // Title
        $this->Cell(40, 10, $comp, 0, false, 'C', 0, '', 0, false, 'M', 'M');


         $this->SetY(11);
      
        // Set font
        $this->SetFont('helvetica', 'B', 8); 
        $this->SetTextColor(0,0,0);
        // Title
        $this->Cell(40, 10, $ph_date , 0, false, 'C', 0, '', 0, false, 'M', 'M');


        $this->SetY(17);
      
        // Set font
        $this->SetFont('helvetica', 'B', 8); 
        $this->SetTextColor(0,0,0);
        // Title
        $this->Cell(17, 10, 'Branch: '.$brn_.'', 0, false, 'C', 0, '', 0, false, 'M', 'M');


        $this->SetFont('helvetica', 'B', 12);
        $this->SetTextColor(0,0,0);
        $this->SetY(10);

        $this->Cell(18, 15, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->Cell(21, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(25, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(140, 5, 'Payroll Report', 0, false, 'C', 0, '', 0, false, 'M', 'M');


        $this->SetFont('helvetica', '', 8);
        $this->SetTextColor(0,0,0);
        $currentDateTime = date('Y-m-d H:i:s'); 
        $this->Cell(100, 15, 'Printed Date/Time: '.$currentDateTime, 0, false, 'C', 0, '', 0, false, 'M', 'M');



    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}
     
$pdf = new MYPDF('L', PDF_UNIT, 'Legal', true, 'UTF-8', false);

// set document information

$pdf->SetTitle('Payroll Report');


// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(10, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '',7.35);
$pdf->SetTextColor(0,0,0);
// add a page
$pdf->AddPage();

$header = '';
$output = '';
$outputTotal = '';
$finaloutput= '';



$startoutput = '
                        <table table width="100%"  cellpadding="1" border="0">
        
                        <tr>    
                            <td rowspan="2"  width="2%"  style="vertical-align:bottom;text-align:center;">IC</td>
                            <td rowspan="2"  width="10%"  style="vertical-align:middle;text-align:middle;" >Name</td>
               
                           
                            <td  width="5%"  style="text-align:left" bgcolor="#d5dadb">Work Days</td>
                            <td  width="5%"  style="text-align:left" bgcolor="#d5dadb">Basic Pay</td>
                            <td  width="5%"  style="text-align:left" bgcolor="#d5dadb">Overtime</td>
                            <td  width="5%"  style="text-align:left" bgcolor="#d5dadb">Overtime Amount</td>
                            <td  width="5%"  style="text-align:left" bgcolor="#d5dadb">Night Differential</td>
                            <td  width="5%"  style="text-align:left" bgcolor="#d5dadb">Night Diff. Amount</td>
                            <td  width="5%"  style="text-align:left" bgcolor="#d5dadb">Special Holiday</td>
                            <td  width="5%"  style="text-align:left" bgcolor="#d5dadb">Spcl Hol. Amount</td>
                            <td  width="5%"  style="text-align:left" bgcolor="#d5dadb">Rest Day</td>
                            <td  width="5%"  style="text-align:left" bgcolor="#d5dadb">Rest Day Amount</td>
                            <td  width="5%"  style="text-align:left" bgcolor="#d5dadb">Legal Holiday</td>
                            <td  width="5%"  style="text-align:left" bgcolor="#d5dadb">L.Hol Amount</td>
                            <td  width="5%"  style="text-align:left" bgcolor="#d5dadb">Trans. Allowance</td>
                            <td  width="5%"  style="text-align:left" bgcolor="#d5dadb">Meal Allowance</td>
                            <td  width="5%"  style="text-align:left" bgcolor="#d5dadb">Incentive</td>
                            <td  width="5%"  style="text-align:left" bgcolor="#d5dadb">Gross Pay</td>

                        </tr> 
                        <tr>
                        
                            <td  width="5%"  style="text-align:left">Late</td>
                            <td  width="5%"  style="text-align:left">Late Amount</td>
                            <td  width="5%"  style="text-align:left">SSS</td>
                            <td  width="5%"  style="text-align:left">PHIC</td>
                            <td  width="5%"  style="text-align:left">HDMF</td>
                            <td  width="5%"  style="text-align:left">SSS Loan</td>
                            <td  width="5%"  style="text-align:left">HDMF Loan</td>
                            <td  width="5%"  style="text-align:left">Company Charge</td>
                            <td  width="5%"  style="text-align:left">Cash Bond</td>
                            <td  width="5%"  style="text-align:left">Cash Advance</td>
                            <td  width="5%"  style="text-align:left">E-Loan</td>
                            <td  width="5%"  style="text-align:left">Over Payment</td>
                            <td  width="5%"  style="text-align:left">Uniform</td>
                           
                            <td  width="5%"  style="text-align:left">W/Tax</td>
                            <td  width="5%"  style="text-align:left">Total Deductions</td>
                            <td  width="5%"  style="text-align:left">Net Pay</td>

                        </tr> ';

$output="";
$tTax = 0;
$tRdays = 0;
$tBpay = 0;
$tOT= 0;
$tOTA = 0;
$tND = 0;
$tNDA = 0;
$tSPCL = 0;
$tSPCLA = 0;
$tSun = 0;
$tSuna = 0;
$tLhol = 0;
$tLhola = 0;
$tTallow = 0;
$tMallow = 0;
$tInc = 0;
$tGpay = 0;


$tLate = 0;
$tLateA = 0;
$tSSS = 0;
$tPHIC= 0;
$tHMDF = 0;
$tSSSL = 0;
$tHDMFL = 0;
$tCCHRG = 0;
$tCBOND = 0;
$tCADV = 0;
$tELOAN = 0;
$tOP = 0;
$tUF = 0;
$tCN = 0;
$tAP = 0;
$tDED = 0;
$tNPAY = 0;
//$query = " CALL SP_payrollreportWebApp('TWL0000151','TWL')";
$query = " CALL SP_payrollreportWebApp('".$payrollid_."','".$dataarea."')";
//$query = "CALL payslipRPT('WFSIPY0000005', 'WFSI', 'WFSIWR000002')";
        $result = $conn->query($query);
       // $row = $result->fetch_assoc();

                        while ($row = $result->fetch_assoc())
                        {
                            $name = $row["name"];
                            $tTax +=  $row['WTAX'];
                            $tRdays +=  $row['RDAYS'];
                            $tBpay += $row['BPAY'];
                            $tOT+= $row['OT'];
                            $tOTA += $row['OTA'];
                            $tND += $row['ND'];
                            $tNDA += $row['NDA'];
                            $tSPCL +=  $row['SHOL'];
                            $tSPCLA += $row['SHOLA'];
                            $tSun += $row['SUN'];
                            $tSuna += $row['SUNA'];
                            $tLhol +=  $row['LHOL'];
                            $tLhola += $row['LHOLA'];
                            $tTallow +=  $row['TALLOW'];
                            $tMallow += $row['MALLOW'];
                            $tInc +=  $row['INC'];
                            $tGpay += $row['GPAY'];

                            $tLate += $row['LTE'];
                            $tLateA += $row['LTEA'];
                            $tSSS += $row['SSS'];
                            $tPHIC+= $row['PH'];
                            $tHMDF += $row['PIBIG'];
                            $tSSSL += $row['SSSL'];
                            $tHDMFL += $row['PIBIGL'];
                            $tCCHRG += $row['CCHRG'];
                            $tCBOND += $row['CBOND'];
                            $tCADV += $row['CADV'];
                            $tELOAN += $row['ELOAN'];
                            $tOP += $row['OPAY'];
                            $tUF += $row['UFM'];
                            $tCN += $row['CTN'];
                            $tAP += $row['APT'];
                            $tDED += $row['TDED'];
                            $tNPAY += $row['NPAY'];



                            $output.='<table width="100%"  cellpadding="1" border="1">
                      
                        
                   
                         
                      
                        <tr>
                           <td rowspan="2"  width="2%" style="vertical-align:bottom;text-align:center;">'.$row["ic"].'</td>
                            <td rowspan="2"  width="10%"   style="vertical-align:middle;text-align:middle;" >'.$row["name"].'</td>
                           
                            <td  width="5%"  style="text-align:right" bgcolor="#d5dadb">'.number_format($row['RDAYS'],2).'</td>
                            <td  width="5%"  style="text-align:right" bgcolor="#d5dadb">'.number_format($row['BPAY'],2).'</td>
                            <td  width="5%"  style="text-align:right" bgcolor="#d5dadb">'.number_format($row['OT'],2).'</td>
                            <td  width="5%"  style="text-align:right" bgcolor="#d5dadb">'.number_format($row['OTA'],2).'</td>
                            <td  width="5%"  style="text-align:right" bgcolor="#d5dadb">'.number_format($row['ND'],2).'</td>
                            <td  width="5%"  style="text-align:right" bgcolor="#d5dadb">'.number_format($row['NDA'],2).'</td>
                            <td  width="5%"  style="text-align:right" bgcolor="#d5dadb">'.number_format($row['SHOL'],2).'</td>
                            <td  width="5%"  style="text-align:right" bgcolor="#d5dadb">'.number_format($row['SHOLA'],2).'</td>
                            <td  width="5%"  style="text-align:right" bgcolor="#d5dadb">'.number_format($row['SUN'],2).'</td>
                            <td  width="5%"  style="text-align:right" bgcolor="#d5dadb">'.number_format($row['SUNA'],2).'</td>
                            <td  width="5%"  style="text-align:right" bgcolor="#d5dadb">'.number_format($row['LHOL'],2).'</td>
                            <td  width="5%"  style="text-align:right" bgcolor="#d5dadb">'.number_format($row['LHOLA'],2).'</td>
                            <td  width="5%"  style="text-align:right" bgcolor="#d5dadb">'.number_format($row['TALLOW'],2).'</td>
                            <td  width="5%"  style="text-align:right" bgcolor="#d5dadb">'.number_format($row['MALLOW'],2).'</td>
                            <td  width="5%"  style="text-align:right" bgcolor="#d5dadb">'.number_format($row['INC'],2).'</td>
                            <td  width="5%"  style="text-align:right" >'.number_format($row['GPAY'],2).'</td>
  
                        </tr>
                        <tr>
                            <td  width="5%"  style="text-align:right">'.number_format($row['LTE'],2).'</td>
                            <td  width="5%"  style="text-align:right">'.number_format($row['LTEA'],2).'</td>
                            <td  width="5%"  style="text-align:right">'.number_format($row['SSS'],2).'</td>
                            <td  width="5%"  style="text-align:right">'.number_format($row['PH'],2).'</td>
                            <td  width="5%"  style="text-align:right">'.number_format($row['PIBIG'],2).'</td>
                            <td  width="5%"  style="text-align:right">'.number_format($row['SSSL'],2).'</td>
                            <td  width="5%"  style="text-align:right">'.number_format($row['PIBIGL'],2).'</td>
                            <td  width="5%"  style="text-align:right">'.number_format($row['CCHRG'],2).'</td>
                            <td  width="5%"  style="text-align:right">'.number_format($row['CBOND'],2).'</td>
                            <td  width="5%"  style="text-align:right">'.number_format($row['CADV'],2).'</td>
                            <td  width="5%"  style="text-align:right">'.number_format($row['ELOAN'],2).'</td>
                            <td  width="5%"  style="text-align:right">'.number_format($row['OPAY'],2).'</td>
                            <td  width="5%"  style="text-align:right">'.number_format($row['UFM'],2).'</td>
                          
                             <td  width="5%"  style="text-align:right" >'.number_format($row['WTAX'],2).'</td>
                            <td  width="5%"  style="text-align:right">'.number_format($row['TDED'],2).'</td>
                            <td  width="5%"  style="text-align:right;color: red;"><b>'.number_format($row['NPAY'],2).'</b></td>
                          
                        </tr>
                        </table>';
                  
                        }
 $output.='<table width="100%"  cellpadding="1" border="1">
                      
                        
                   
                         
                      
                        <tr>
                        
                            <td rowspan="2" colspan = "2"  width="12%"   style="vertical-align:middle;text-align:middle;" >Totals :</td>
                            
                            <td  width="5%"  style="text-align:right" bgcolor="#d5dadb"><b>'.number_format($tRdays,2).'</b></td>
                            <td  width="5%"  style="text-align:right" bgcolor="#d5dadb"><b>'.number_format($tBpay,2).'</b></td>
                            <td  width="5%"  style="text-align:right" bgcolor="#d5dadb"><b>'.number_format($tOT,2).'</b></td>
                            <td  width="5%"  style="text-align:right" bgcolor="#d5dadb"><b>'.number_format($tOTA,2).'</b></td>
                            <td  width="5%"  style="text-align:right" bgcolor="#d5dadb"><b>'.number_format($tND,2).'</b></td>
                            <td  width="5%"  style="text-align:right" bgcolor="#d5dadb"><b>'.number_format($tNDA,2).'</b></td>
                            <td  width="5%"  style="text-align:right" bgcolor="#d5dadb"><b>'.number_format($tSPCL,2).'</b></td>
                            <td  width="5%"  style="text-align:right" bgcolor="#d5dadb"><b>'.number_format($tSPCLA,2).'</b></td>
                            <td  width="5%"  style="text-align:right" bgcolor="#d5dadb"><b>'.number_format($tSun,2).'</b></td>
                            <td  width="5%"  style="text-align:right" bgcolor="#d5dadb"><b>'.number_format($tSuna,2).'</b></td>
                            <td  width="5%"  style="text-align:right" bgcolor="#d5dadb"><b>'.number_format($tLhol,2).'</b></td>
                            <td  width="5%"  style="text-align:right" bgcolor="#d5dadb"><b>'.number_format($tLhola,2).'</b></td>
                            <td  width="5%"  style="text-align:right" bgcolor="#d5dadb"><b>'.number_format($tTallow,2).'</b></td>
                            <td  width="5%"  style="text-align:right" bgcolor="#d5dadb"><b>'.number_format($tMallow,2).'</b></td>
                            <td  width="5%"  style="text-align:right" bgcolor="#d5dadb"><b>'.number_format($tInc,2).'</b></td>
                            <td  width="5%"  style="text-align:right" ><b>'.number_format($tGpay,2).'</b></td>
  
                        </tr>
                        <tr>
                            <td  width="5%"  style="text-align:right"><b>'.number_format($tLate,2).'</b></td>
                            <td  width="5%"  style="text-align:right"><b>'.number_format($tLateA,2).'</b></td>
                            <td  width="5%"  style="text-align:right"><b>'.number_format($tSSS,2).'</b></td>
                            <td  width="5%"  style="text-align:right"><b>'.number_format($tPHIC,2).'</b></td>
                            <td  width="5%"  style="text-align:right"><b>'.number_format($tHMDF,2).'</b></td>
                            <td  width="5%"  style="text-align:right"><b>'.number_format($tSSSL,2).'</b></td>
                            <td  width="5%"  style="text-align:right"><b>'.number_format($tHDMFL,2).'</b></td>
                            <td  width="5%"  style="text-align:right"><b>'.number_format($tCCHRG,2).'</b></td>
                            <td  width="5%"  style="text-align:right"><b>'.number_format($tCBOND,2).'</b></td>
                            <td  width="5%"  style="text-align:right"><b>'.number_format($tCADV,2).'</b></td>
                            <td  width="5%"  style="text-align:right"><b>'.number_format($tELOAN,2).'</b></td>
                            <td  width="5%"  style="text-align:right"><b>'.number_format($tOP,2).'</b></td>
                            <td  width="5%"  style="text-align:right"><b>'.number_format($tUF,2).'</b></td>
                            <td  width="5%"  style="text-align:right"><b>'.number_format($tTax,2).'</b></td>
                            <td  width="5%"  style="text-align:right"><b>'.number_format($tDED,2).'</b></td>
                            <td  width="5%"  style="text-align:right;color: red;"><b>'.number_format($tNPAY,2).'</b></td>
                          
                        </tr>

                         
                        </table>
                        <tr>
                                <td width="50%">
                                
                                    <p>Prepared By:</p>
                                    <p>________________________</p>
                                
                                </td>

                                <td width="50%">
                                
                                    <p>Approved By:</p>
                                    <p>________________________</p>
                                
                                </td>
                            </tr>
                            </table>
                        ';

$finaloutput =  $startoutput.$output;    

// print a block of text using Write()
$pdf->WriteHtml($finaloutput, '', 0, 'C',  false, 0, false, false, 0);
ob_end_clean();
//Close and output PDF document
$pdf->Output('Payroll Report - '.$payrollid_.'.pdf', 'I');

?>