<?php
session_start();
// Include the main TCPDF library (search for installation path).
require_once('tcpdf_min\tcpdf.php');
include('../dbconn.php');

$dataareaid = $_SESSION["defaultdataareaid"];
$userlogin = $_GET["usr"];
$soc = $dataareaid;
$yr = $_GET["yr"];
$monthcal = $_GET["monthcal"];
$usrname =  $_GET["usrname"];


if($_GET["runrpt"] == "PDF")
    {
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
                        $this->Cell(30, 15,  $_GET["comp"], 0, false, 'C', 0, '', 0, false, 'M', 'M');


                        $this->SetFont('helvetica', 'B', 12);
                        $this->SetTextColor(128,128,128);
                        $this->SetY(10);

                        $this->Cell(18, 15, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');

                        $this->Cell(30, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                        $this->Cell(30, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                        $this->Cell(60, 5, 'Pag-Ibig Loan Report', 0, false, 'C', 0, '', 0, false, 'M', 'M');


                        $this->SetFont('helvetica', 'B', 8);
                        $this->Cell(153, 15, 'Printed By: '.$_GET["usr"].'', 0, false, 'C', 0, '', 0, false, 'M', 'M');

                        $currentDateTime2 = date('Y-m-d H:i:s');
                   


                        $this->SetY(15);
                        $this->SetFont('helvetica', 'B', 10);
                        $this->Cell(15, 15, 'For the year: '.$_GET["yr"], 0, false, 'C', 0, '', 0, false, 'M', 'M');

                        $this->SetFont('helvetica', 'B', 8);
                        $this->Cell(50, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                        $this->Cell(50, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                        $this->Cell(108, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');

                        $this->Cell(10, 15, 'Printed Date/Time: '.$currentDateTime2, 0, false, 'C', 0, '', 0, false, 'M', 'M');


                        $this->SetFont('helvetica', 'B', 9);
                        $this->SetY(23);

                        
                        $this->Cell(4, 5, 'IC', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                        $this->Cell(25, 5, 'P.Ibig No.',0, false, 'C', 0, '', 0, false, 'M', 'M');


                        $this->Cell(2, 2, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');

                        $this->Cell(2, 2, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                        $this->Cell(2, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                        $this->Cell(8, 1, 'Name', 0, false, 'C', 0, '', 0, false, 'M', 'M');


                        $this->Cell(10, 2, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                        $this->Cell(5, 2, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                        $this->Cell(2, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                        $this->Cell(2, 1, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');

                        $this->Cell(6, 2, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                        $this->Cell(5, 2, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                        $this->Cell(8, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                        $this->Cell(7, 1, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');

                        $this->Cell(10, 2, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                        $this->Cell(10, 2, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                        $this->Cell(10, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                        $this->Cell(5, 1, '1st Half', 0, false, 'C', 0, '', 0, false, 'M', 'M');

                        $this->Cell(7, 2, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                        $this->Cell(7, 2, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                        $this->Cell(6, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                        $this->Cell(5, 1, '2nd Half', 0, false, 'C', 0, '', 0, false, 'M', 'M');

                        $this->Cell(7, 2, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                        $this->Cell(6, 2, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                        $this->Cell(4, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                        $this->Cell(5, 1, 'Amount Paid', 0, false, 'C', 0, '', 0, false, 'M', 'M');

                        $this->Cell(8, 2, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                        $this->Cell(7, 2, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                        $this->Cell(7, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                        $this->Cell(7, 1, 'Balance', 0, false, 'C', 0, '', 0, false, 'M', 'M');

                        $this->Cell(8, 2, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                        $this->Cell(8, 2, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                        $this->Cell(7, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                        $this->Cell(7, 1, 'Tin No.', 0, false, 'C', 0, '', 0, false, 'M', 'M');


                        $this->Cell(5, 2, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                        $this->Cell(5, 2, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                        $this->Cell(5, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                        $this->Cell(6, 1, 'Birth Date', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                /*
                        $this->Cell(8, 2, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                        $this->Cell(8, 2, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                        $this->Cell(6, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                        $this->Cell(6, 1, 'Balance', 0, false, 'C', 0, '', 0, false, 'M', 'M');*/


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
                $pdf = new MYPDF('L', PDF_UNIT, 'LETTER', true, 'UTF-8', false);

                // set document information

                $pdf->SetTitle('PAG-IBIG Loan Report');


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


                $t1sth = 0;
                $t2ndh = 0;
                $tamount = 0;
                $tbal = 0;
                   
                 
                // set some text to print

                $output = '';
                $outputTotal = '';
                $finaloutput= '';

                $qryTotal = "SELECT format(sum(firsthalf),2) t1st,format(sum(secondhalf),2) t2nd,format(sum(amountpaid),2) tamount, format(sum(balance),2) tbal  FROM pgibigtotal";
                                $totalRes = $conn->query($qryTotal);
                                    while ($row = $totalRes->fetch_assoc())
                                        {
                                            $t1sth = $row["t1st"];
                                            $t2ndh = $row["t2nd"];
                                            $tamount = $row["tamount"];
                                            $tbal = $row["tbal"];
                                        }

                $startoutput = '<table cellspacing="0" width="100%" cellpadding="1" border="0"><tr></tr>';

                $query = "CALL pibigloanreportweb('$dataareaid',$monthcal, $yr);";
                        $result = $conn->query($query);
                        if ($result->num_rows > 0)
                        {
                            while ($row = $result->fetch_assoc())
                            {
                               
                                $output .= '
                                            <table width="100%" cellspacing="0" cellpadding="1" border="1">
                                           
                                            <tr>
                                                
                                                <td  width="3%"   style="text-align:left">'.$row["num"].'</td>
                                                <td  width="11%"  style="text-align:left">'.$row["pagibignum"].'</td>
                                                <td  width="27%"   style="text-align:left">'.$row["lastname"].', '.$row["firstname"].' '.substr($row["middlename"],0,1).'.'.'</td>
                                                
                                                <td  width="10%"  style="text-align:right">'.$row["firsthalf"].'</td>
                                                <td  width="10%"  style="text-align:right">'.$row["secondhalf"].'</td>
                                                <td  width="10%"  style="text-align:right">'.$row["amountpaid"].'</td>
                                                <td  width="10%"  style="text-align:right">'.$row["balance"].'</td>
                                                <td  width="12%"  style="text-align:right">'.$row["tinnum"].'</td>
                                                <td  width="9%"   style="text-align:right">'.$row["birthdate"].'</td>
                                            </tr>

                                            </table>
                                            ';

                            }
                               $outputTotal = '<tr>
                                            <th></th>
                                            <th></th>
                                            <th style="text-align:right;color:#FF0000;" >Total/s:</th>
                                            
                                            <th style="text-align:right;color:#FF0000;" >'.$t1sth.'</th>
                                            <th style="text-align:right;color:#FF0000;" >'.$t2ndh.'</th>
                                            <th style="text-align:right;color:#FF0000;" >'.$tamount.'</th>
                                            <th style="text-align:right;color:#FF0000;" >'.$tbal.'</th>
                                            <th></th>
                                            <th></th>
                                             
                                             <br>
                                             </br>
                                             <br>
                                             </br>
                                             <br>
                                                <td width="42%" style="font-weight:bold"> '.strtoupper($usrname).'</td>
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
                        }
                        
                       
                    

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
                $pdf->Output('PAGIBIG LOAN REPORT.pdf', 'I');
    }
else
    {
                $t1sth = 0;
                $t2ndh = 0;
                $tamount = 0;
                $tbal = 0;
                   
                $output = '';
                $qryTotal = "SELECT format(sum(firsthalf),2) t1st,format(sum(secondhalf),2) t2nd,format(sum(amountpaid),2) tamount, format(sum(balance),2) tbal  FROM pgibigtotal;";
                        $totalRes = $conn->query($qryTotal);
                            while ($row = $totalRes->fetch_assoc())
                                {
                                    $t1sth = $row["t1st"];
                                    $t2ndh = $row["t2nd"];
                                    $tamount = $row["tamount"];
                                    $tbal = $row["tbal"];
                                }

                    $startoutput = '<table cellspacing="0" width="100%" cellpadding="1" border="0">
                                    <tr>
                                        <th width="12%"  style="text-align:left; font-size: 100%;" colspan="2">'.$_GET["comp"].'</th>
                                        <th width="19%"  style="text-align:left"></th>  
                                        <th width="12%"  style="text-align:left"></th>
                                        <th width="19%"  style="text-align:left"></th>  
                                        <th width="12%"  style="text-align:left"></th>
                                        <th width="19%"  style="text-align:left"></th>  
                                        <th width="12%"  style="text-align:left"></th>
                                        <th width="19%"  style="text-align:left" colspan="2">Printed By: '.$userlogin .'</th>  
                                       
                                    </tr>
                                    <tr>
                                            <th  width="15%"  style="text-align:left" colspan="2">For the year: '.$yr.'</th>  
                                            <th></th>  
                                            <th></th>
                                            <th></th>  
                                            <th></th>
                                            <th></th>  
                                            <th></th>
                                            <th width="15%"  style="text-align:left" colspan="2">Printed Date: '.date('Y-m-d H:i a').'</th>
                                        </tr>
                                    <tr>
                                        <th></th>
                                        <th width="5%"   style="text-align:left"></th>
                                        <th width="14%"  style="text-align:left"></th>
                                        <th width="19%"  style="text-align:left"></th>  
                                        <th width="12%"  style="text-align:left"></th>
                                        <th width="28%"  style="text-align:left; font-size: 150%;" colspan="2">PAG IBIG LOAN REPORT</th>
                                        <th width="19%"  style="text-align:left"></th>  
                                        <th width="12%"  style="text-align:left"></th>
                                    </tr>
                                    <tr>
                                        <th width="12%"  style="text-align:left"></th>
                                    </tr>
                                    <tr></tr>
                                    <tr> 
                                        <th width="1%"   style="text-align:left">IC</th>
                                        <th width="11%"  style="text-align:left">Pag-Ibig No.</th>
                                        <th width="9%"   style="text-align:left">L.Name</th>
                                        <th width="9%"   style="text-align:left">F.Name</th>  
                                        <th width="9%"   style="text-align:left">M.Name</th>
                                        <th width="10%"  style="text-align:left">1st Half</th>
                                        <th width="10%"  style="text-align:left">2nd Half</th>  
                                        <th width="10%"  style="text-align:left">Amount Paid</th>
                                        <th width="10%"  style="text-align:left">Balance</th>
                                        <th width="12%"  style="text-align:left">Tin No.</th>
                                        <th width="9%"   style="text-align:left">Birth Date</th>
                                    </tr><tr></tr>
                                    ';

                $query = "CALL pibigloanreportweb('$dataareaid',$monthcal, $yr);";
                        $result = $conn->query($query);
                        while ($row = $result->fetch_assoc())
                        {
                           
                            $output .= '
                                        <table width="100%" cellspacing="0" cellpadding="1" border="1">
                                       
                                        <tr>
                                            
                                            <td  width="3%"   style="text-align:left">'.$row["num"].'</td>
                                            <td  width="11%"  style="text-align:left">'.$row["pagibignum"].'</td>
                                            <td  width="9%"   style="text-align:left">'.$row["lastname"].'</td>
                                            <td  width="9%"   style="text-align:left">'.$row["firstname"].'</td>
                                            <td  width="9%"   style="text-align:left">'.$row["middlename"].'</td>
                                            <td  width="10%"  style="text-align:right">'.$row["firsthalf"].'</td>
                                            <td  width="10%"  style="text-align:right">'.$row["secondhalf"].'</td>
                                            <td  width="10%"  style="text-align:right">'.$row["amountpaid"].'</td>
                                            <td  width="10%"  style="text-align:right">'.$row["balance"].'</td>
                                            <td  width="12%"  style="text-align:right">'.$row["tinnum"].'</td>
                                            <td  width="9%"   style="text-align:right">'.$row["birthdate"].'</td>
                                        </tr>

                                        </table>
                                        ';

                        }
                           $outputTotal = '<tr>
                                            <br>
                                                <table width="100%" cellspacing="0" cellpadding="1" border="0">
                                                   <tr>
                                                        <td widtd="1%"   style="text-align:left" colspan="2">Totals: </td>
                                                        <td widtd="11%"  style="text-align:left"></td>
                                                        <td widtd="9%"   style="text-align:left"></td>
                                                        <td widtd="9%"   style="text-align:left"></td>  
                                                        <td widtd="30%"  style="text-align:right">'.$t1sth.'</td>
                                                        <td widtd="30%"  style="text-align:right">'.$t2ndh.'</td>  
                                                        <td widtd="10%"  style="text-align:right">'.$tamount.'</td>
                                                        <td widtd="10%"  style="text-align:right">'.$tbal.'</td>
                                                        <td widtd="12%"  style="text-align:left"></td>
                                                        <td widtd="9%"   style="text-align:left"></td>
                                                    </tr>
                                                 </table>
                                            </br>
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
                                                 <table width="100%" cellspacing="0" cellpadding="1" border="0">
                                                   <tr>
                                                        <td widtd="1%"   style="text-align:left"></td>
                                                        <td widtd="11%"  style="text-align:left"></td>
                                                        <td widtd="9%"   style="text-align:left"></td>
                                                        <td widtd="9%"   style="text-align:left">'.strtoupper($usrname).'</td>  
                                                        <td widtd="9%"   style="text-align:left"></td>
                                                        <td widtd="30%"  style="text-align:left"></td>
                                                        <td widtd="30%"  style="text-align:left"></td>  
                                                        <td widtd="10%"  style="text-align:left"></td>
                                                        <td widtd="10%"  style="text-align:left"></td>
                                                        <td widtd="12%"  style="text-align:left"></td>
                                                        <td widtd="9%"   style="text-align:left"></td>
                                                    </tr>
                                                 </table>
                                            
                                                <table width="100%" cellspacing="0" cellpadding="1" border="0">
                                                       
                                                            <td widtd="1%"   style="text-align:left"></td>
                                                            <td widtd="11%"  style="text-align:left"></td>
                                                            <td widtd="9%"   style="text-align:left"></td>
                                                            <td widtd="9%"   style="text-align:left">______________</td>  
                                                            <td widtd="9%"   style="text-align:left"></td>
                                                            <td widtd="30%"  style="text-align:left"></td>
                                                            <td widtd="30%"  style="text-align:left"></td>  
                                                            <td widtd="10%"  style="text-align:left">______________</td>
                                                            <td widtd="10%"  style="text-align:left"></td>
                                                            <td widtd="12%"  style="text-align:left"></td>
                                                            <td widtd="9%"   style="text-align:left"></td>
                                                       
                                                </table>
                                            
                                            
                                               <table width="100%" cellspacing="0" cellpadding="1" border="0">
                                                   <tr>
                                                        <td widtd="1%"   style="text-align:left"></td>
                                                        <td widtd="11%"  style="text-align:left"></td>
                                                        <td widtd="9%"   style="text-align:left"></td>
                                                        <td widtd="15%"   style="text-align:left">Prepared By</td>  
                                                        <td widtd="9%"   style="text-align:left"></td>
                                                        <td widtd="10%"  style="text-align:left"></td>
                                                        <td widtd="30%"  style="text-align:left"></td>  
                                                        <td widtd="10%"  style="text-align:left">Approved By</td>
                                                        <td widtd="10%"  style="text-align:left"></td>
                                                        <td widtd="12%"  style="text-align:left"></td>
                                                        <td widtd="9%"   style="text-align:left"></td>
                                                    </tr>
                                                 </table>
                                            </br>
                                        </br>
                                </table>';
                       
                    

                    $finaloutput =  $startoutput.$output.$outputTotal;    

                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment; filename=ATM_as_of_'.date('Y-m-d H:i a').'.xls');
                    echo $finaloutput;
    }

?>