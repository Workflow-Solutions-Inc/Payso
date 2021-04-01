<?php
session_start();
// Include the main TCPDF library (search for installation path).
include(__DIR__ . '/tcpdf_min/tcpdf.php');
include('dbconn.php');
$dataareaid = $_SESSION["defaultdataareaid"];
$usrname = $_GET["usr"];
$soc = $dataareaid;
$yr = $_GET["yr"];
$wkType = $_GET["wkType"];
$monthcal = $_GET["monthcal"];


// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    //Page header
    public function Header() {
      // Logo
      include('dbconn.php');
      $dataareaid = $_SESSION["defaultdataareaid"];
      $soc = $dataareaid;
      $logo = '';
      $dataareaid = '';
      $yr = $_GET["yr"];
      $query = "SELECT * FROM dataarea WHERE dataareaid = '$soc'";
        $result = $conn->query($query);

       while($row = $result->fetch_assoc()) {
          $logo = $row["dataarealogo"];
        }
        $img_base64_encoded = $logo;
        $imageContent = file_get_contents($img_base64_encoded);
        $path = tempnam(sys_get_temp_dir(), 'prefix');

        file_put_contents ($path, $imageContent);

        $img = '<img src="' . $path . '" width="100" height="85">';
        $this->SetY(19);
        $this->writeHTML($img,true, false, true, false, '');

         $this->SetY(15);
      
        // Set font
        $this->SetFont('helvetica', 'B', 13);
        $this->SetTextColor(0,0,0);
        // Title
        $this->Cell(50, 15, $_GET["comp"], 0, false, 'C', 0, '', 0, false, 'M', 'M');


        $this->SetFont('helvetica', 'B', 12);
        $this->SetTextColor(128,128,128);
        $this->SetY(35);

        $this->Cell(18, 15, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->Cell(21, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(25, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        if ($_GET["wkType"] == "0"){$bir = "Non BIR Declared";}
        if ($_GET["wkType"] == "1"){$bir = "BIR Declared";}
        if ($_GET["wkType"] == "2"){$bir = "All Non and BIR Declared";}
        // $bir2 = "All Non and BIR Declared";



        if($_GET["wkType"] == "0"){$cell_1 = 40;$cell_2 = 102;}
        if($_GET["wkType"] == "1"){$cell_1 = 50; $cell_2 = 82;}
        if($_GET["wkType"] == "2"){$cell_1 = 30;$cell_2 = 121;}

        if ($_GET["monthcal"] == "1"){$monword = "January";}
        if ($_GET["monthcal"] == "2"){$monword = "February";}
        if ($_GET["monthcal"] == "3"){$monword = "March";}
        if ($_GET["monthcal"] == "4"){$monword = "April";}
        if ($_GET["monthcal"] == "5"){$monword = "May";}
        if ($_GET["monthcal"] == "6"){$monword = "June";}
        if ($_GET["monthcal"] == "7"){$monword = "July";}
        if ($_GET["monthcal"] == "8"){$monword = "August";}
        if ($_GET["monthcal"] == "9"){$monword = "September";}
        if ($_GET["monthcal"] == "10"){$monword = "October";}
        if ($_GET["monthcal"] == "11"){$monword = "November";}
        if ($_GET["monthcal"] == "12"){$monword = "December";}

        $this->Cell(60, 5, 'PhilHealth Contribution Report', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->SetFont('helvetica', 'B', 8);
        $this->SetY(40);
        $this->Cell(188, 15, 'For the Month of '.$monword.', '.$yr.'', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->SetFont('helvetica', 'B', 8);
        $this->SetY(45);
        $this->Cell(295, 15, 'Printed By: '.$_GET["usr"].'', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $currentDateTime = date('Y-m-d H:i:s');
   

        
        $this->SetY(48);
        $this->Cell(315, 15, 'Printed Date: '.$currentDateTime.'', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->SetY(55);
      //  $this->Cell(50, 15, $yr, 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(4, 5, 'IC', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(26, 5, 'Worker ID',0, false, 'C', 0, '', 0, false, 'M', 'M');


        $this->Cell(2, 2, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->Cell(2, 2, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(2, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');


        $this->Cell(2, 1, 'Name', 0, false, 'C', 0, '', 0, false, 'M', 'M');


        // $this->Cell(10, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        // $this->Cell(10, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        // $this->Cell(15, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        // $this->Cell(20, 5, 'First Half', 0, false, 'C', 0, '', 0, false, 'M', 'M');


        // $this->Cell(2, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        // $this->Cell(2, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        // $this->Cell(3, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        // $this->Cell(6, 5, 'Second Half', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        // $this->Cell(11, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        // $this->Cell(5, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        // $this->Cell(5, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        // $this->Cell(6, 5, 'EE P/H', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        // $this->Cell(6, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        // $this->Cell(5, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        // $this->Cell(5, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        // $this->Cell(6, 5, 'ER P/H', 0, false, 'C', 0, '', 0, false, 'M', 'M');


        // $this->Cell(4, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        // $this->Cell(5, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        // $this->Cell(5, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        // $this->Cell(6, 5, 'EE/ER P/H', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->Cell(28, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(5, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(5, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->Cell(10, 5, 'EE P/H', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->Cell(6, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(5, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(5, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->Cell(6, 5, 'ER P/H', 0, false, 'C', 0, '', 0, false, 'M', 'M');


        $this->Cell(4, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(5, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(5, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->Cell(6, 5, 'EE/ER P/H', 0, false, 'C', 0, '', 0, false, 'M', 'M');



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

$pdf->SetTitle('PHILHEALTH CONTRIBUTION REPORT)');


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

$query = "CALL phcontributionreportweb('$dataareaid',$monthcal, $yr, 2);";
        $result = $conn->query($query);
        while ($row = $result->fetch_assoc())
        {
         
            $output .= '
                        <table width="100%" cellspacing="0" cellpadding="1" border="0">
                       
                        <tr>
                            
                            <td  width="5%"  style="text-align:left">'.$row["num"].'</td>
                            <td  width="12%"  style="text-align:left">'.$row["workerid"].'</td>
                            <td  width="20%"  style="text-align:left">'.$row["name"].'</td>
                            <td  width="12%"  style="text-align:right">'.$row["PHEEC"].'</td>
                            <td  width="12%"  style="text-align:right">'.$row["PHER"].'</td>
                            <td  width="12%"  style="text-align:right">'.$row["PHEEM"].'</td>
                        </tr>

                        </table>
                        ';
        }
        mysqli_close($con);
        include("dbconn.php");
        $qryTotal = "select 
            
            format(sum(pheec),2) as 'Tpheec',
            format(sum(pheem),2) as 'Tpheem',
            format(sum(pher),2)  as 'Tpher'
            from phcontribtotal;";
    $totalRes = $conn->query($qryTotal);
    while ($row = $totalRes->fetch_assoc())
        {
            #$t1sth = $row["T1st"];
            #$t2ndh = $row["T2nd"];
            $Tpheec = $row["Tpheec"];
            $Tpheem = $row["Tpheem"];
            $Tpher = $row["Tpher"];

        }


           $outputTotal = '<tr>
                                        <th style="text-align:right;color:#FF0000;" colspan="2">Total/s:</th>
                                        <th style="text-align:right" ></th>
                                        <th style="text-align:right;color:#FF0000;" >'.$Tpheec.'</th>
                                        <th style="text-align:right;color:#FF0000;" >'.$Tpheem.'</th>
                                        <th style="text-align:right;color:#FF0000;" >'.$Tpher.'</th>
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
                                            <td width="50%" style="font-weight:bold"> '.strtoupper($usrname).'</td>
                                         </br>
                                         <br>
                                           <td width="50%" style="font-weight:bold">  __________________________</td>
                                           <td width="50%" style="font-weight:bold">  __________________________</td>
                                         </br>
                                         <br>
                                         </br>
                                         <tr>
                                              <td  width="50%" style="font-weight:bold">Prepared By</td>
                                              <td  width="50%" style="font-weight:bold">Approved By</td>
                                         </tr>
                                </tr></table>';
       
    

$finaloutput =  $startoutput.$output.$outputTotal;  

// print a block of text using Write()
$pdf->SetY(65);
$pdf->WriteHtml($finaloutput, '', 0, 'C',  false, 0, false, false, 0);

#$pdf->SetY(-20);
        // Set font
#$pdf->WriteHtml('AAAAAAAAA', '', 0, 'C',  false, 0, false, false, 0);

//$pdf->WriteHtml( $startoutput.$outputTotal, '', 0, 'C',  false, 0, false, false, 0);
// ---------------------------------------------------------
ob_end_clean();
//Close and output PDF document
$pdf->Output('PHILHEALTH CONTRIBUTION REPORT.pdf', 'I');

?>