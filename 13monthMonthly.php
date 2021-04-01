<?php
session_start();
// Include the main TCPDF library (search for installation path).
include(__DIR__ . '/tcpdf_min/tcpdf.php');
include('dbconn2.php');

$dataareaid = $_SESSION["defaultdataareaid"];
$userlogin = $_GET["usr"];
$soc = $dataareaid;
$yr = $_GET["yr"];

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
        $this->Cell(140, 5, '13th Month Report (Monthly)', 0, false, 'C', 0, '', 0, false, 'M', 'M');


        $this->SetFont('helvetica', 'B', 8);
        $this->Cell(175, 15, 'Printed By: '.$_GET["usr"].'', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $currentDateTime = date('Y-m-d H:i:s');
   
         $yrInt = (int)$_GET["yr"] - 1;


        $this->SetY(15);
        $this->Cell(50, 15, 'From December '.$yrInt.' to November '.$_GET["yr"] .'', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->Cell(20, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(20, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(130, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->Cell(170, 15, 'Printed Date/Time: '.$currentDateTime, 0, false, 'C', 0, '', 0, false, 'M', 'M');


        $this->SetFont('helvetica', 'B', 9);
        $this->SetY(23);
        $this->Cell(8, 5, 'IC', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(10, 5, 'Name', 0, false, 'C', 0, '', 0, false, 'M', 'M');


        $this->Cell(7, 2, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(7, 2, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(7, 2, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(7, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');


        $this->Cell(7, 1, 'Dec. C-Off', 0, false, 'C', 0, '', 0, false, 'M', 'M');


        $this->Cell(2, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(2, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(3, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->Cell(12, 5, 'January', 0, false, 'C', 0, '', 0, false, 'M', 'M');


        $this->Cell(3, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(3, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(6, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->Cell(8, 5, 'February', 0, false, 'C', 0, '', 0, false, 'M', 'M');


        $this->Cell(2, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(2, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(5, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->Cell(10, 5, 'March', 0, false, 'C', 0, '', 0, false, 'M', 'M');


        $this->Cell(2, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(3, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(5, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->Cell(10, 5, 'April', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->Cell(2, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(2, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(5, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');


        $this->Cell(10, 5, 'May', 0, false, 'C', 0, '', 0, false, 'M', 'M');


        $this->Cell(2, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(2, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(6, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->Cell(10, 5, 'June', 0, false, 'C', 0, '', 0, false, 'M', 'M');


        $this->Cell(2, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(2, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(5, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->Cell(10, 5, 'July', 0, false, 'C', 0, '', 0, false, 'M', 'M');


        $this->Cell(2, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(2, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(6, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->Cell(10, 5, 'August', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->Cell(2, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(2, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(5, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->Cell(10, 5, 'September', 0, false, 'C', 0, '', 0, false, 'M', 'M');


        $this->Cell(2, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(2, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(6, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->Cell(10, 5, 'Ocotber', 0, false, 'C', 0, '', 0, false, 'M', 'M');


        $this->Cell(2, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(2, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(6, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->Cell(10, 5, 'Novemeber', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->Cell(3, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(3, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(8, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(10, 5, 'Total', 0, false, 'C', 0, '', 0, false, 'M', 'M');

       

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
$pdf = new MYPDF('L', PDF_UNIT, 'LEGAL', true, 'UTF-8', false);

// set document information

$pdf->SetTitle('13TH Month Report Monthly');


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
$pdf->SetFont('helvetica', '', 8);
$pdf->SetTextColor(128,128,128);
// add a page
$pdf->AddPage();

// set some text to print

$output = '';
$outputTotal = '';
$finaloutput= '';



$startoutput = '<table cellspacing="0" cellpadding="1" border="0">';

$query = "CALL `13thMonthReportPerMonthweb`('$dataareaid',$yr)";
        $result = $conn->query($query);
        while ($row = $result->fetch_assoc())
        {
         
            $output .= ' <table width="100%" cellspacing="0" cellpadding="1" border="1">
                        <tr>
                            <td  width="2%"   style="text-align:right">'.$row["num"].'</td>
                            <td  width="10%"  style="text-align:left">'.$row["name"].'</td>
                            <td  width="6%"  style="text-align:right">'.$row["decco"].'</td>
                            <td  width="6%"  style="text-align:right">'.$row["m1"].'</td>
                            <td  width="6%"  style="text-align:right">'.$row["m2"].'</td>
                            <td  width="6%"  style="text-align:right">'.$row["m3"].'</td>
                            <td  width="6%"  style="text-align:right">'.$row["m4"].'</td>
                            <td  width="6%"  style="text-align:right">'.$row["m5"].'</td>
                            <td  width="6%"  style="text-align:right">'.$row["m6"].'</td>
                            <td  width="6%"  style="text-align:right">'.$row["m7"].'</td>
                            <td  width="6%"  style="text-align:right">'.$row["m8"].'</td>
                            <td  width="6%"  style="text-align:right">'.$row["m9"].'</td>
                            <td  width="6%"  style="text-align:right">'.$row["m10"].'</td>
                            <td  width="6%"  style="text-align:right">'.$row["m11"].'</td>
                            <td  width="6%"  style="text-align:right">'.$row["Total"].'</td>
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
         /*  $outputTotal = '<tr>
                        <th></th>
                        <th></th>
                        <th style="text-align:right" >Total Dec Cut Off</th>
                        <th style="text-align:right" >Total M1</th>
                        <th style="text-align:right" >Total M2</th>
                        <th style="text-align:right" >Total M3</th>
                        <th style="text-align:right" >Total M4</th>
                        <th style="text-align:right" >Total M5</th>
                        <th style="text-align:right" >Total M6</th>
                        <th style="text-align:right" >Total M7</th>
                        <th style="text-align:right" >Total M8</th>
                        <th style="text-align:right" >Total M9</th>
                        <th style="text-align:right" >Total M10</th>
                        <th style="text-align:right" >Total M11</th>
                        <th style="text-align:right" >Total</th>
                        <th style="text-align:right" >Total 13th Month</th>
                        <th style="text-align:right" >Total E-Loan</th>
                </tr></table>';*/$outputTotal = "";
       
    

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