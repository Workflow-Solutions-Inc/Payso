<?php 

//require_once('tcpdf_min\tcpdf.php');
include(__DIR__ . '../../tcpdf_min/tcpdf.php');
include('../../dbconn.php');

$payrollperiod = $_GET['payroll'];
$dataareaid = $_GET['soc'];
$output = "";

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        include('../../dbconn.php');
        $payrollperiod = $_GET['payroll'];
        $dataareaid = $_GET['soc'];
 
  
$query_ph = "SELECT pp.payrollperiod,date(pp.startdate) as fromdate,date(pp.enddate) as todate,da.name 
            FROM payrollperiod pp 
            left join dataarea da on pp.dataareaid = da.dataareaid
            where  pp.payrollperiod = '$payrollperiod' and pp.dataareaid = '$dataareaid' ";

        $result_ph = $conn->query($query_ph);
        $row_ph = $result_ph->fetch_assoc();

        

        $ph_date = $row_ph['fromdate']; 
        $ph_todate = $row_ph['todate']; 
      
        $comp = $row_ph['name'];
        //$comp = "Demo";
        // Logo
        $this->SetY(7);
        // Set font
        $this->SetFont('helvetica', 'B', 13); 
        $this->SetTextColor(0,0,0);
        // Title
        $this->Cell(18, 15, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(21, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(25, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(140, 5, $comp, 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $this->SetFont('helvetica', '', 8);
        $this->SetTextColor(0,0,0);
        $currentDateTime = date('Y-m-d H:i:s'); 
        $this->Cell(60, 15, 'Printed Date/Time: '.$currentDateTime, 0, false, 'C', 0, '', 0, false, 'M', 'M');
         


      
        


        $this->SetY(12);
        // Set font
        $this->SetFont('helvetica', 'B', 12);
        $this->SetTextColor(0,0,0);
        // Title
        $this->Cell(18, 15, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(21, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(25, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(140, 5, 'Daily Time Record Summary', 0, false, 'C', 0, '', 0, false, 'M', 'M');


        $this->SetY(17);
        // Set font
        $this->SetFont('helvetica', 'B', 12); 
        $this->SetTextColor(0,0,0);
        // Title
        $this->Cell(18, 15, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(21, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(25, 5, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(140, 10, 'Payroll Covered: '.$ph_date.' to '.$ph_todate , 0, false, 'C', 0, '', 0, false, 'M', 'M');



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
     
$pdf = new MYPDF('L', 'mm', 'LETTER', true, 'UTF-8', false);

// set document information

$pdf->SetTitle('DTR Summary Report');


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
$pdf->SetAutoPageBreak(false);
$pdf->AddPage();

$header = '';
$output = '';
$outputTotal = '';
$finaloutput= '';



$startoutput = '
                    <table table width="100%"  cellpadding="1" border="1">
        
                        <tr>    
                            <td rowspan="2"  width="20"   style="vertical-align:bottom;text-align:center;"> IC</td>
                            <td rowspan="2"  width="150" style="vertical-align:middle;text-align:middle;"><b> Name</b></td>
               
                           
                            <td  width="80" height="20"  style="text-align:left" bgcolor="#d5dadb"> Days Worked</td>
                            <td  width="80" height="20"  style="text-align:left" bgcolor="#d5dadb"> Hrs Worked</td>
                            <td  width="80" height="20"  style="text-align:left" bgcolor="#d5dadb"> Overtime</td>
                            <td  width="80" height="20"  style="text-align:left" bgcolor="#d5dadb"> Night Differential</td>
                            <td  width="80" height="20"  style="text-align:left" bgcolor="#d5dadb"> Absent</td>
                            <td  width="80" height="20"  style="text-align:left" bgcolor="#d5dadb"> Late</td>
                            <td  width="80" height="20"  style="text-align:left" bgcolor="#d5dadb"> Leaves</td>
                            <td  width="80" height="20"  style="text-align:left" bgcolor="#d5dadb"> Undertime</td>
                            <td  width="80" height="20"  style="text-align:left" bgcolor="#d5dadb"> Over Break</td>

                        </tr> 
                        <tr>
                        
                            <td  width="80" height="20"  style="text-align:left"> Rest Days</td>
                            <td  width="80" height="20"  style="text-align:left"> Rest Days OT</td>
                            <td  width="80" height="20"  style="text-align:left"> Rest Days ND</td>
                            <td  width="80" height="20"  style="text-align:left"> Holiday</td>
                            <td  width="80" height="20"  style="text-align:left"> Holiday OT</td>
                            <td  width="80" height="20"  style="text-align:left"> Holiday ND</td>
                            <td  width="80" height="20"  style="text-align:left"> Spl Holiday</td>
                            <td  width="80" height="20"  style="text-align:left"> Spl Holiday OT</td>
                            <td  width="80" height="20"  style="text-align:left"> Spl Holiday ND</td>
                           
                           
                        </tr> 
                    </table>
                       ';
$pdf->WriteHtml($startoutput, '', 0, 'C',  false, 0, false, false, 0);

$output="";
 $cnt= 0;
 $ic=1;
$query = "SELECT w.name,dtrh.payrollperiod,dtrh.workerid,
            format(daysworked,2) as daysworked,format(hoursworked,2) as hoursworked,format(overtimehours,2) as overtimehours,format(nightdifhours,2) as nightdifhours,
            format(leaves,2) as leaves,format(absent,2) as absent,format(late,2) as late,format(undertime,2) as undertime,format(specialholiday,2) as specialholiday,
            format(specialholidayot,2) as specialholidayot,format(specialholidaynd,2) as specialholidaynd ,format(ifnull(sunday,'0.00'),2) as  sunday,format(sundayot,2) as sundayot,
            format(sundaynd,2) as sundaynd,format(ifnull(holiday,'0.00'),2) as holiday,format(holidayot,2) as holidayot,format(holidaynd,2) as holidaynd,format(ifnull(break,'0.00'),2) as 'brk'


            from dailytimerecordheader dtrh

            left join worker w on
            w.workerid = dtrh.workerid and w.dataareaid = dtrh.dataareaid
            where dtrh.payrollperiod = '$payrollperiod' and dtrh.dataareaid = '$dataareaid'
            and w.inactive = '0'       
            #group by dtrh.workerid;
            ";

        $result = $conn->query($query);
       // $row = $result->fetch_assoc();

                        while ($row = $result->fetch_assoc())
                        {
                           
                            if($cnt == 14)
                            {
                                
                                $cnt= 0;
                                $pdf->AddPage();
                                $startoutput = '
                                <table table width="100%"  cellpadding="1" border="1">
        
                                    <tr>    
                                        <td rowspan="2"  width="20"   style="vertical-align:bottom;text-align:center;"> IC</td>
                                        <td rowspan="2"  width="150" style="vertical-align:middle;text-align:middle;"><b> Name</<b>></td>
                           
                                       
                                        <td  width="80" height="20"  style="text-align:left" bgcolor="#d5dadb"> Days Worked</td>
                                        <td  width="80" height="20"  style="text-align:left" bgcolor="#d5dadb"> Hrs Worked</td>
                                        <td  width="80" height="20"  style="text-align:left" bgcolor="#d5dadb"> Overtime</td>
                                        <td  width="80" height="20"  style="text-align:left" bgcolor="#d5dadb"> Night Differential</td>
                                        <td  width="80" height="20"  style="text-align:left" bgcolor="#d5dadb"> Absent</td>
                                        <td  width="80" height="20"  style="text-align:left" bgcolor="#d5dadb"> Late</td>
                                        <td  width="80" height="20"  style="text-align:left" bgcolor="#d5dadb"> Leaves</td>
                                        <td  width="80" height="20"  style="text-align:left" bgcolor="#d5dadb"> Undertime</td>
                                        <td  width="80" height="20"  style="text-align:left" bgcolor="#d5dadb"> Over Break</td>

                                    </tr> 
                                    <tr>
                                    
                                        <td  width="80" height="20"  style="text-align:left"> Rest Days</td>
                                        <td  width="80" height="20"  style="text-align:left"> Rest Days OT</td>
                                        <td  width="80" height="20"  style="text-align:left"> Rest Days ND</td>
                                        <td  width="80" height="20"  style="text-align:left"> Holiday</td>
                                        <td  width="80" height="20"  style="text-align:left"> Holiday OT</td>
                                        <td  width="80" height="20"  style="text-align:left"> Holiday ND</td>
                                        <td  width="80" height="20"  style="text-align:left"> Spl Holiday</td>
                                        <td  width="80" height="20"  style="text-align:left"> Spl Holiday OT</td>
                                        <td  width="80" height="20"  style="text-align:left"> Spl Holiday ND</td>
                                       
                                       
                                    </tr> 
                                </table>
                                   ';
                                $pdf->WriteHtml($startoutput, '', 0, 'C',  false, 0, false, false, 0);

                            }
                            $output='<table width="100%"  cellpadding="1" border="1">
                      
                        
                   
                         
                      
                        <tr>    
                            <td rowspan="2"  width="20"  style="vertical-align:bottom;text-align:center;">'.$ic.'</td>
                            <td rowspan="2"  width="150"  style="vertical-align:middle;text-align:middle;" ><b> '.ucwords(strtolower($row["name"])).'</b></td>
               
                           
                            <td  width="80" height="20"  style="text-align:right" bgcolor="#d5dadb">'.$row["daysworked"].'</td>
                            <td  width="80" height="20"  style="text-align:right" bgcolor="#d5dadb">'.$row["hoursworked"].'</td>
                            <td  width="80" height="20"  style="text-align:right" bgcolor="#d5dadb">'.$row["overtimehours"].'</td>
                            <td  width="80" height="20"  style="text-align:right" bgcolor="#d5dadb">'.$row["nightdifhours"].'</td>
                            <td  width="80" height="20"  style="text-align:right" bgcolor="#d5dadb">'.$row["absent"].'</td>
                            <td  width="80" height="20"  style="text-align:right" bgcolor="#d5dadb">'.$row["late"].'</td>
                            <td  width="80" height="20"  style="text-align:right" bgcolor="#d5dadb">'.$row["leaves"].'</td>
                            <td  width="80" height="20"  style="text-align:right" bgcolor="#d5dadb">'.$row["undertime"].'</td>
                            <td  width="80" height="20"  style="text-align:right" bgcolor="#d5dadb">'.$row["brk"].'</td>

                        </tr> 
                        <tr>
                        
                            <td  width="80" height="20"  style="text-align:right">'.$row["sunday"].'</td>
                            <td  width="80" height="20"  style="text-align:right">'.$row["sundayot"].'</td>
                            <td  width="80" height="20"  style="text-align:right">'.$row["sundaynd"].'</td>
                            <td  width="80" height="20"  style="text-align:right">'.$row["holiday"].'</td>
                            <td  width="80" height="20"  style="text-align:right">'.$row["holidayot"].'</td>
                            <td  width="80" height="20"  style="text-align:right">'.$row["holidaynd"].'</td>
                            <td  width="80" height="20"  style="text-align:right">'.$row["specialholiday"].'</td>
                            <td  width="80" height="20"  style="text-align:right">'.$row["specialholidayot"].'</td>
                            <td  width="80" height="20"  style="text-align:right">'.$row["specialholidaynd"].'</td>
                           
                           
                        </tr> 


                        </table>';
                        $cnt++;
                        $ic++;
                        $pdf->WriteHtml($output, '', 0, 'C',  false, 0, false, false, 0);
                        }


ob_end_clean();
//Close and output PDF document
$pdf->Output('DTR Summary Report - '.$payrollperiod.'.pdf', 'I');

?>