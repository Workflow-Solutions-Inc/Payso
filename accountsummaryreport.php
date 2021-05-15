<?php
session_start();
session_regenerate_id();
// Include the main TCPDF library (search for installation path).
include(__DIR__ . '/tcpdf_min/tcpdf.php');
include('dbconn2.php');
$dataareaid = $_SESSION["defaultdataareaid"];
$userlogin = $_GET["usr"];
$soc = $dataareaid;
$workernum = $_GET["workernum"];
$accnum = $_GET["accnum"];
$fromdate = $_GET["fromdate"];
$todate = $_GET["todate"];
$usrname =  $_GET["usrname"];
echo $accnum;

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        // Logo
         $this->SetY(5);
      
        // Set font
        $this->SetFont('helvetica', 'B', 13);
        $this->SetTextColor(0,0,0);
        // Title
        $this->Cell(30, 15, $_GET["comp"], 0, false, 'C', 0, '', 0, false, 'M', 'M');


        $this->SetFont('helvetica', 'B', 12);
        $this->SetTextColor(128,128,128);
        $this->SetY(10);

        $this->Cell(18, 15, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->Cell(21, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(25, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(60, 5, 'Accounts Summary Report', 0, false, 'C', 0, '', 0, false, 'M', 'M');


        $this->SetFont('helvetica', 'B', 8);
        $this->Cell(61, 15, 'Printed By: Admin', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $currentDateTime = date('Y-m-d H:i:s');
   


        $this->SetY(15);
        $this->SetFont('helvetica', 'B', 15);
        $this->Cell(15, 15, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->SetFont('helvetica', 'B', 8);
        $this->Cell(20, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(20, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(108, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->Cell(10, 15, 'Printed Date/Time: '.$currentDateTime, 0, false, 'C', 0, '', 0, false, 'M', 'M');


        $this->SetFont('helvetica', 'B', 9);
        $this->SetY(23);
        $this->Cell(7, 2, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(8, 2, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(10, 5, 'IC', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(23, 5, 'Worker ID',0, false, 'C', 0, '', 0, false, 'M', 'M');


        $this->Cell(3, 2, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->Cell(2, 2, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(5, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');


        $this->Cell(3, 1, 'Name', 0, false, 'C', 0, '', 0, false, 'M', 'M');


        $this->Cell(20, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(20, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(20, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->Cell(20, 5, 'Contract ID', 0, false, 'C', 0, '', 0, false, 'M', 'M');


        $this->Cell(3, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(5, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(5, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->Cell(6, 5, 'Amount', 0, false, 'C', 0, '', 0, false, 'M', 'M');






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

// create new PDF document
$pdf = new MYPDF('P', PDF_UNIT, 'LETTER', true, 'UTF-8', false);

// set document information

$pdf->SetTitle('Accounts Summary Report');


// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
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
$pdf->SetFont('helvetica', '', 9);
$pdf->SetTextColor(128,128,128);
// add a page
$pdf->AddPage();

// set some text to print

$output = '';
$outputTotal = '';
$finaloutput= '';



$startoutput = '<table cellspacing="0" width="100%" cellpadding="1" border="0"><tr></tr>';

$query = "CALL `accountssummaryreportweb`('$soc', '".$fromdate."', '".$todate."', '$accnum');";
        $result = $conn->query($query);
        while ($row = $result->fetch_assoc())
        {
         
            $output .= '
                        <table width="100%" cellspacing="0" cellpadding="1" border="0">
                       
                        <tr>
                            <td  width="10%"  style="text-align:left"></td>
                            <td  width="5%"  style="text-align:left">'.$row["num"].'</td>
                            <td  width="14%"  style="text-align:left">'.$row["workerid"].'</td>
                            <td  width="35%"  style="text-align:left">'.$row["workername"].'</td>
                            <td  width="13%"  style="text-align:right">'.$row["contractid"].'</td>
                            <td  width="12%"  style="text-align:right">'.$row["accountvalue"].'</td>
                        </tr>

                        </table>
                        ';
        }
  /*  $queryTotal = "CALL `paysys2019_dev`.`13thMonthTotals`";
    $totalresult = $conn->query($queryTotal);
       
           $rowtotal = $totalresult->fetch_assoc();
         
           $outputTotal = '<tr>
                        <th></th>
                        <th></th>
                        <th style="text-align:right" >'.$rowtotal["TDecco"].'</th>
                        <th style="text-align:right" >'.$rowtotal["Tq1"].'</th>
                        <th style="text-align:right" >'.$rowtotal["Tq2"].'</th>
                        <th style="text-align:right" >'.$rowtotal["Tq3"].'</th>
                        <th style="text-align:right" >'.$rowtotal["Tq4"].'</th>
                        <th style="text-align:right" >'.$rowtotal["OOT"].'</th>
                        <th style="text-align:right" >'.$rowtotal["TTM"].'</th>
                        <th style="text-align:right" >'.$rowtotal["Tel"].'</th>
                </tr></table>';*/
           $outputTotal = '<tr>
                        <th></th>
                        <th></th>
                          <th></th>
                          <tr>
                           
                         </tr>
                         <br>
                         </br>
                         <br>
                         </br>
                         <br>
                         </br>
                         <br>
                         </br>
                         <br>
                         </br>
                         <br>
                         </br>
                         <br>
                         </br>
                         <br>
                         </br>
                         <br>
                         </br>
                         <br>
                         </br>
                         <br>
                           <td width="42%" style="font-weight:bold">  __________________________</td>
                           <td width="32%" style="font-weight:bold">  __________________________</td>
                         </br>
                         <br>
                           
                         </br>
                         <tr>
                              <td  width="40%" style="font-weight:bold">Prepared By</td>
                              <td  width="30%" style="font-weight:bold">Approved By</td>
                         </tr>
                </tr></table>';
       
    

$finaloutput =  $startoutput.$output.$outputTotal;    

// print a block of text using Write()
$pdf->WriteHtml($finaloutput, '', 0, 'C',  false, 0, false, false, 0);

#$pdf->SetY(-20);
        // Set font
#$pdf->WriteHtml('AAAAAAAAA', '', 0, 'C',  false, 0, false, false, 0);

//$pdf->WriteHtml( $startoutput.$outputTotal, '', 0, 'C',  false, 0, false, false, 0);
// ---------------------------------------------------------
ob_end_clean();
//Close and output PDF document
$pdf->Output('13th Month Report Monthly.pdf', 'I');

?>