

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
const TEMPIMGLOC = "tempimg.jpg";
const TEMPIMGLOC2 = "tempimg.png";

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    //Page header
    public function Header() {
      include('../dbconn.php');
      $id = $_GET['id'];
      $logo = '';
      $dataareaid = '';
      $query = "SELECT (w.name)workername, FORMAT(rate, '2')rate, ecola, FORMAT(leavecredits, 'c')leavecredits, FORMAT(payoutamount, '2')payoutamount, dataarealogo, (d.name)companyname, leavetype
          FROM leavepayoutdetail lpd
          left join dataarea d on lpd.dataareaid = d.dataareaid
          left join worker w on lpd.workerid = w.workerid and w.dataareaid = d.dataareaid
          WHERE leavepayoutid = '$id'";
        $result = $conn->query($query);

       while($row = $result->fetch_assoc()) {
          $logo = $row["dataarealogo"];
          $dataareaid = $row["companyname"];
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
        $this->Cell(28, 15, $dataareaid, 0, false, 'C', 0, '', 0, false, 'M', 'M');


        $this->SetFont('helvetica', 'B', 12);
        $this->SetTextColor(128,128,128);
        $this->SetY(30);

        $this->Cell(180, 5, 'Leave Payout Report', 0, false, 'C', 0, '', 0, false, 'M', 'M');


        $this->SetFont('helvetica', 'B', 8);


        $currentDateTime = date('Y-m-d H:i:s');
       $yrInt  = $_GET["yr"];


        $this->SetY(45);
      //  $this->Cell(50, 15, $yr, 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(21, 15, 'Year: '.$_GET["yr"].'', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(275, 15, 'Printed Date/Time: '.$currentDateTime, 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->SetY(50);
        // $this->Cell(64, 15, 'Date: '.$_GET["fromdate"].' to '.$_GET["todate"].'', 0, false, 'C', 0, '', 0, false, 'M', 'M');
         $this->Cell(288, 15, 'Printed by: '.$_GET["user"].'', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->SetFont('helvetica', 'B', 9);
        $this->SetY(65);

        $this->Cell(11, 20, 'Name', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->Cell(59, 1, 'Type', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->Cell(30, 5, 'Rate', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->Cell(50, 5, 'Leave Credit', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->Cell(30, 5, 'Amount', 0, false, 'C', 0, '', 0, false, 'M', 'M');


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
$pdf = new MYPDF('P', PDF_UNIT, 'letter', true, 'UTF-8', false);

// set document information

$pdf->SetTitle('Overall Leave Payout Report)');


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
$query = "SELECT distinct w.workerid as workerid
          FROM leavepayoutdetail lpd
          left join dataarea d on lpd.dataareaid = d.dataareaid
          left join worker w on lpd.workerid = w.workerid and w.dataareaid = d.dataareaid
          WHERE leavepayoutid = '$id'";
        $result = $conn->query($query);

        while ($row = $result->fetch_assoc())
        { 


            $workerid = $row['workerid'];
            $logo = $row['dataarealogo'];
            $query2 = "SELECT w.workerid,
                      (w.name)workername, 
                      FORMAT(rate, '2')rate, 
                      ecola, 
                      FORMAT(leavecredits, 'c')leavecredits, 
                      FORMAT(payoutamount, '2')payoutamount, 
                      dataarealogo, 
                      (d.name)companyname, 
                      (case when leavetype = 'SL' then 'Sick Leave' when leavetype = 'VL' then 'Vacation Leave' else 'Retirement' end) leavetype
                                
                                FROM leavepayoutdetail lpd
                                left join dataarea d on lpd.dataareaid = d.dataareaid
                                left join worker w on lpd.workerid = w.workerid and w.dataareaid = d.dataareaid
                                WHERE leavepayoutid = '$id' and w.workerid = '$workerid'
                                
                      union

                      select w2.workerid,
                      '' workername, 
                      '' rate, 
                      ecola, 
                      '', 
                      concat('Subtotal: ',format(sum(payoutamount), '2'))payoutamount, 
                      dataarealogo, 
                      (d2.name)companyname, 
                      '' leavetype
                      from leavepayoutdetail lpd2 
                      left join dataarea d2 on lpd2.dataareaid = d2.dataareaid 
                      left join worker w2 on lpd2.workerid = w2.workerid and w2.dataareaid = d2.dataareaid 
                      where leavepayoutid = '$id' and w2.workerid = '$workerid'

                      union

                      select w2.workerid,
                      '' workername, 
                      '' rate, 
                      ecola, 
                      '', 
                      '', 
                      dataarealogo, 
                      (d2.name)companyname, 
                      '' leavetype
                      from leavepayoutdetail lpd2 
                      left join dataarea d2 on lpd2.dataareaid = d2.dataareaid 
                      left join worker w2 on lpd2.workerid = w2.workerid and w2.dataareaid = d2.dataareaid 
                      where leavepayoutid = '$id' and w2.workerid = '$workerid'";
            $result2 = $conn->query($query2);
            while ($row2 = $result2->fetch_assoc()){

                $output .= ' <table width="100%"  cellpadding="3" border="0">
                        
                         <tr>
                            <td rowspan="10"  width="20%"  style="vertical-align : middle;text-align:left;" >'.$row2["workername"].'</td>
                            <td  width="15%"  style="text-align:left">'.$row2["leavetype"].'</td>
                            <td  width="22%"  style="text-align:right">'.$row2["rate"].'</td>
                            <td  width="19%"  style="text-align:right">'.$row2["leavecredits"].'</td>
                            <td  width="27%"  style="text-align:right">'.$row2["payoutamount"].'</td>
                        </tr>

                        </table>
                        ';
            }
            
        }

$query2 = "select FORMAT(SUM(payoutamount), '2')totalpayoutamount from leavepayoutdetail where leavepayoutid = '$id'";
        $result2 = $conn->query($query2);

        while ($row2 = $result2->fetch_assoc())
        {
            $output2 .= ' <table width="100%"  cellpadding="20" border="0">
                        
                         <tr>
                            <td width="103%"  style="vertical-align : middle;text-align:right; font-weight:bold; font-size:10" >Total Amount: '.$row2["totalpayoutamount"].'</td>

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
$pdf->Output('Leave Payout Report.pdf', 'I');

?>