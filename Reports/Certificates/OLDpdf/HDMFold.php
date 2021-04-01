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



use setasign\Fpdi\Fpdi;
require_once('fpdf/htmlpdf.php');
include('dbconn.php');
include(__DIR__ . '/FPDI/src/autoload.php');

//$selectedYear = $_GET['selectedyear'];
//$selectedWorker = $_GET['selectedworker'];
//$query = "select * from worker";
$tinelineno0 =  '';
$tinelineno1 =  '';
$tinelineno2 =  '';
$tinelineno3 =  '';
$tinelineno4 =  '';
$tinelineno5 =  '';
$tinelineno6 =  '';
$tinelineno7 =  '';
$tinelineno8 =  '';
$tinelineno9 =  '';
$tinelineno10 =  '';
$tinelineno11 =  '';
$wkid = $_GET['worker'];
$query = "select wk.firstname fname,wk.lastname,wk.middlename, date(wk.datehired) datefrom ,date(wk.inactivedate) dateto,ps.name psname,wk.sssnum from worker wk left join position ps on wk.position = ps.positionid and wk.dataareaid = ps.dataareaid where wk.workerid = '".$wkid."' ";
     $result = $conn->query($query);
        $row = $result->fetch_assoc();

        $fname = $row["fname"];
        $lastname = $row["lastname"];
        $middlename = $row["middlename"];
        $datefrom = $row["datefrom"];
        $dateto = $row["dateto"];
        $psname = $row["psname"];
        $sssnum = $row["sssnum"];

        //8th Avenue corner 35th Street, Bonifacio Global City, Taguig City, Manila, Philippines, 1634
        //address 1st line
        $roomNo = "3rd floor";
        $bldgName = "Grand Hyatt Manila";
        $blockNo = "8th Avenue corner";
        $stName = "35th St";

        //address 2nd line
        $subd = "Plantation";
        $bar = "BGC";
        $munCity = "Taguig City";
        $prov = "Manila, Philippines";
        $zipcode = "1634";

        //data table
        $piNo = "987654321";
        $accNo = "";
        $memProg = "none";
        $myName = "Cruz Jonald Arjon Peralta";
        $perCov = "Dec 2020";
        $monComp = "";
        $eeShare = "100";
        $erShare = "100";
        $totShare = "200";
        $remarks = "NONE";

        //bottom area
        $pos = "General Accountant";
        $datehdmf = "05/28/2020";

        
   

  $pdf = new \setasign\Fpdi\Fpdi();
    require_once "FPDI/src/autoload.php";
  $pdf = new FPDI('P','mm','Legal');

  /* <Virtual loop> */
  $pdf->AddPage();
  $pdf->setSourceFile('te.pdf');
  $tplIdx = $pdf->importPage(1);

  $pdf->useTemplate($tplIdx, 2, -1, 210, 350);

  $pdf->SetFont('Arial','B',9);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(70, 55);
  $pdf->Write(0,  $fname);

  $pdf->SetFont('Arial','B',9);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(115, 55);
  $pdf->Write(0,   $middlename );

  $pdf->SetFont('Arial','B',9);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(30, 55);
  $pdf->Write(0,   $lastname );


  $pdf->SetFont('Arial','B',17);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(153.5, 33);
  $pdf->Write(0, $sssnum );

  //address 1st line
  $pdf->SetFont('Arial','B',9);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(15, 71);
  $pdf->Write(0, $roomNo );

  //building
  $pdf->SetFont('Arial','B',9);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(60, 71);
  $pdf->Write(0, $bldgName );

  //blockNo
  $pdf->SetFont('Arial','B',9);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(110, 71);
  $pdf->Write(0, $blockNo );

  //street
  $pdf->SetFont('Arial','B',9);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(175, 71);
  $pdf->Write(0, $stName );

  //address 2nd line

  //subdivision
  $pdf->SetFont('Arial','B',9);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(11, 85);
  $pdf->Write(0, $subd );

  //barangay
  $pdf->SetFont('Arial','B',9);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(38, 85);
  $pdf->Write(0, $bar );

  //municipality
  $pdf->SetFont('Arial','B',9);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(66, 85);
  $pdf->Write(0, $munCity );

  //province
  $pdf->SetFont('Arial','B',9);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(110, 85);
  $pdf->Write(0, $prov );

  //zipcode
  $pdf->SetFont('Arial','B',9);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(175, 85);
  $pdf->Write(0, $zipcode );


  //data table

  //pagibig No
  $pdf->SetFont('Arial','B',7);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(10, 114);
  $pdf->Write(0, $piNo);

  //account no
  $pdf->SetFont('Arial','B',7);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(10, 114);
  $pdf->Write(0, $accNo);

  //membership
  $pdf->SetFont('Arial','B',7);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(28, 114);
  $pdf->Write(0, $memProg);

  //name
  $pdf->SetFont('Arial','B',9);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(60, 114);
  $pdf->Write(0, $myName);

  //period cover
  $pdf->SetFont('Arial','B',7);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(126.5, 114);
  $pdf->Write(0, $perCov);
  
  //monthly comp
  $pdf->SetFont('Arial','B',7);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(150, 114);
  $pdf->Write(0, $monComp);

  //ee share
  $pdf->SetFont('Arial','B',7);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(163, 114);
  $pdf->Write(0, $eeShare);

  //er share
  $pdf->SetFont('Arial','B',7);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(173, 114);
  $pdf->Write(0, $erShare);

  //er share
  $pdf->SetFont('Arial','B',7);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(183, 114);
  $pdf->Write(0, $totShare);

  //remark
  $pdf->SetFont('Arial','B',7);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(193, 114);
  $pdf->Write(0, $remarks);

  //bottom part

  //position
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(113, 315 );
  $pdf->Write(0, $pos);

  //date
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(173, 315);
  $pdf->Write(0, $datehdmf);


  $pdf->AddPage();
  $tplIdx = $pdf->importPage(2);
  $pdf->useTemplate($tplIdx, 2, -1, 210, 350);
 
  $pdf->Output('newpdf1.pdf', 'I');

?>