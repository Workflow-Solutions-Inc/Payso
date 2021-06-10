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
include('../../dbconn.php');
include(__DIR__ . '/FPDI/src/autoload.php');
//$selectedYear = $_GET['selectedyear'];
//$selectedWorker = $_GET['selectedworker'];
//$query = "select * from worker";
$memoid = $_GET['memoid'];

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


        
$query = "SELECT wk.name,mw.subjects,mw.body,mw.memofrom FROM memoworker mw 
left join worker wk on mw.workerid = wk.workerid and mw.dataareaid = wk.dataareaid
 where mw.memoid = '$memoid';";
     $result = $conn->query($query);
        $row = $result->fetch_assoc();

        //$cc = $row["Memocc"];
        //$to = $row["Memoto"];
        $altname = $row["name"];
        $sub = $row["subjects"];
        $body = $row["body"];
        $from = $row["memofrom"];
        //$datasx = $row["dataareaid"];



   $query4 = "SELECT * from dataarea where dataareaid = 'WFSI';";
     $result4 = $conn->query($query4);
        $row4 = $result4->fetch_assoc();


  $pdf = new \setasign\Fpdi\Fpdi();
    require_once "FPDI/src/autoload.php";
  $pdf = new FPDI('P','mm','A4');

  /* <Virtual loop> */
  $pdf->AddPage();
  $pdf->setSourceFile('Memorandum.pdf');
  $tplIdx = $pdf->importPage(1);

  $pdf->useTemplate($tplIdx, -1,1, 230);
  const TEMPIMGLOC = 'tempimg.png';
  const TEMPIMGLOC2 = 'tempimg.jpg';
  $dataURI = $row4["dataarealogo"];
 // $address = $row4["dataareaaddress"];
  $address = 'Unit 502 F&L Building, Commonwealth Ave., Brgy. Holy Spirit, Q.C.';
  $name = $row4["name"];

  $dataPieces = explode(',',$dataURI);
  $encodedImg = $dataPieces[1];
  $decodedImg = base64_decode($encodedImg);

//  Check if image was properly decoded
  if($dataPieces[0]=="data:image/png;base64"){
    if( $decodedImg!==false )
    {
        //  Save image to a temporary location
        if( file_put_contents(TEMPIMGLOC,$decodedImg)!==false )
        {
            $pdf->Image(TEMPIMGLOC,29,17,35,25);
            
            //  Delete image from server
            unlink(TEMPIMGLOC);
        }
    }
  }else if($dataPieces[0]=="data:image/jpg;base64"){
    if( $decodedImg!==false )
    {
        //  Save image to a temporary location
        if( file_put_contents(TEMPIMGLOC2,$decodedImg)!==false )
        {
            $pdf->Image(TEMPIMGLOC2);

            //  Delete image from server
            unlink(TEMPIMGLOC2);
        }
    }
  }


  $pdf->SetFont('Times','',24);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(95, 32);

   $pdf->Write(0, $name );



  $pdf->SetFont('Times','',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(75, 40);
  $pdf->Write(0,  $address);

  

  $pdf->SetFont('Times','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(50, 73);
  $pdf->Write(0,  $altname);

   //$pdf->Write(0, $row2["receiver"].'.    ' );




  $pdf->SetFont('Times','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(50, 87);
  $pdf->Write(0,  $from);


//   $pdf->SetFont('Times','',10);
//   $pdf->SetTextColor(0, 0, 0);
//   $pdf->SetXY(50,73.9);
// $row3 = $result3->fetch_assoc();
  
   // $pdf->Write(0, $row3["cc"].'.    ' );
  

  $pdf->SetFont('Times','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(50,101);
  $date = date("Y/m/d");
  $pdf->Write(0,  date('F d, Y', strtotime($date)));
/*
  $pdf->SetFont('Times','B',9);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(35,95);
  $pdf->Write(0,  substr($body , 0, 120));

  $pdf->SetFont('Times','B',9);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(30,100);
  $pdf->Write(0,  substr($body ,121, 120));


  $pdf->SetFont('Times','B',9);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(30,105);
  $pdf->Write(0,  substr($body ,261, 120));


  $pdf->SetFont('Times','B',9);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(30,110);
  $pdf->Write(0,  substr($body ,382, 120));*/

  $pdf->SetXY(20,130);
$pdf->MultiCell(170, 5, $body, 0);


  
  $pdf->Output('newpdf1.pdf', 'I');

?>