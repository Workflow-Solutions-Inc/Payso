

<?php
session_start();
session_regenerate_id();
// Include the main TCPDF library (search for installation path).
include(__DIR__ . '/tcpdf_min/tcpdf.php');
include('../dbconn.php');
/*
$soc = $_GET["dataareaid"];
$yr = $_GET["year"];*/

$id = $_GET['id'];
$di = $_GET['dataareaid'];
const TEMPIMGLOC = "tempimg.jpg";
const TEMPIMGLOC2 = "tempimg.png";


// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    //Page header
    public function Header() {
      include('../dbconn.php');
      $id = $_GET['id'];
      $di = $_GET['dataareaid'];
      $pagetotal = 0;
      $pagecounter = 0;
      $logo = '';
      $dataareaid = '';
      $query = "SELECT w.workerid,w.name as name, format(l.rate,2)  as rate,
                                                    format(sum(IF(l.accountcode = 'BPAY', payoutamount, NULL)),2) AS bpay,
                                                    format(sum(IF(l.accountcode = 'TMTH', payoutamount, NULL)),2) AS thmonth,
                                                    d.dataarealogo as dataarealogo,
                                                    d.name as companyname

                                                    from thmonthpayoutdetails l
                                                    left join worker w on l.workerid = w.workerid and l.dataareaid = w.dataareaid 
                                                    left join dataarea d on l.dataareaid = d.dataareaid

                                                    
                                                    
                                                where l.thmonthpayoutid = '$id' and l.dataareaid = '$di'

                                                group by w.name";
        $result = $conn->query($query);

       while($row = $result->fetch_assoc()) {
          $logo = $row["dataarealogo"];
          $dataareaid = $row["companyname"];
          $pagetotal+= $row["thmonth"];

        }
        $img_base64_encoded = $logo;
        $imageContent = file_get_contents($img_base64_encoded);
        $path = tempnam(sys_get_temp_dir(), 'prefix');

        file_put_contents ($path, $imageContent);

        $img = '<img src="' . $path . '" width="100" height="85">';
        $this->SetY(10);
        $this->writeHTML($img,true, false, true, false, '');

         $this->SetY(5);
      
        // Set font
        $this->SetFont('helvetica', 'B', 10); 
        $this->SetTextColor(0,0,0);
        // Title
        $this->Cell(15, 15, $dataareaid, 0, false, 'C', 0, '', 0, false, 'M', 'M');


        $this->SetFont('helvetica', 'B', 12);
        $this->SetTextColor(128,128,128);
        $this->SetY(30);

        $this->Cell(180, 5, '13th Month Payout Report', 0, false, 'C', 0, '', 0, false, 'M', 'M');


        $this->SetFont('helvetica', 'B', 8);


        $currentDateTime = date('Y-m-d H:i:s');
       $yrInt  = $_GET["yr"];


        $this->SetY(45);
      //  $this->Cell(50, 15, $yr, 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(21, 15, 'Year: '.$_GET["yr"].'', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(275, 15, 'Printed Date/Time: '.$currentDateTime, 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->SetY(50);
         $this->Cell(48, 15, 'Date: '.$_GET["fromdate"].' to '.$_GET["todate"].'', 0, false, 'C', 0, '', 0, false, 'M', 'M');
         $this->Cell(193, 15, 'Printed by: '.'admin'.'', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->SetFont('helvetica', 'B', 9);
        $this->SetY(65);

        $this->Cell(10, 20, 'Name', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->Cell(75, 1, 'Position', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->Cell(9, 5, 'Rate', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->Cell(50, 5, 'Basic Pay', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->Cell(30, 5, '13th Month', 0, false, 'C', 0, '', 0, false, 'M', 'M');


    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        $pagetotal = 0;
    }
}

// create new PDF document
$pdf = new MYPDF('P', PDF_UNIT, 'letter', true, 'UTF-8', false);

// set document information

$pdf->SetTitle('13th Month Payput Report');


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
$header = '';
$output = '';
$output2 = '';
$outputTotal = '';
$finaloutput= '';



$totalamount = 0;
$logo = '';
$query = "SELECT w.workerid,w.name as name, format(l.rate,2)  as rate,
                                                    format(sum(IF(l.accountcode = 'BPAY', payoutamount, NULL)),2) AS bpay,
                                                    format(sum(IF(l.accountcode = 'TMTH', payoutamount, NULL)),2) AS thmonth,
                                                    d.dataarealogo as dataarealogo,
                                                     pos.name as position

                                                    from thmonthpayoutdetails l
                                                    left join worker w on l.workerid = w.workerid and l.dataareaid = w.dataareaid 
                                                    left join position pos on pos.positionid = w.position and pos.dataareaid = l.dataareaid
                                                    left join dataarea d on l.dataareaid = d.dataareaid

                                                    
                                                    
                                                where l.thmonthpayoutid = '$id' and l.dataareaid = '$di'

                                                group by w.name";
        $result = $conn->query($query);

        while ($row = $result->fetch_assoc())
        {
            $logo = $row['dataarealogo'];
            $output .= ' <table width="100%"  cellpadding="3" border="0">
                        
                         <tr>
                            <td rowspan="12"  width="22.5%"  style="vertical-align : middle;text-align:left;" >'.$row["name"].'</td>
                            <td  width="14%"  style="text-align:left">'.$row["position"].'</td>
                            <td  width="22%"  style="text-align:right">'.$row["rate"].'</td>
                            <td  width="20%"  style="text-align:right">'.$row["bpay"].'</td>
                            <td  width="20%"  style="text-align:right">'.$row["thmonth"].'</td>

                        </tr>


                        
                        </table>
                        ';
        }

$query2 = "select format(sum(IF(accountcode = 'TMTH', payoutamount, NULL)),2) AS thmonth from thmonthpayoutdetails where thmonthpayoutid = '$id' and dataareaid = '$di'";
        $result2 = $conn->query($query2);

        while ($row2 = $result2->fetch_assoc())
        {
            $output2 .= ' <table width="100%"  cellpadding="20" border="0">
                        
                         <tr>
                            <td width="103%"  style="vertical-align : middle;text-align:right; font-weight:bold; font-size:10" >Total Amount: '.$row2["thmonth"].'</td>

                        </tr>
                        </table>
                        ';
        }
       
    

$finaloutput = $output; 
        

// print a block of text using Write()
$pdf->SetY(73);
$pdf->WriteHtml($output, '', 0, 'C',  false, 0, false, false, 0);
$pdf->WriteHtml($output2, '', 0, 'C',  false, 0, false, false, 0);

#$pdf->SetY(-20);
        // Set font
#$pdf->WriteHtml('AAAAAAAAA', '', 0, 'C',  false, 0, false, false, 0);

//$pdf->WriteHtml( $startoutput.$outputTotal, '', 0, 'C',  false, 0, false, false, 0);
// ---------------------------------------------------------
ob_end_clean();
//Close and output PDF document
$pdf->Output('13th Month Payout Report.pdf', 'I');

?>