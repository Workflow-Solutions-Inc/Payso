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

$selectedYear = $_GET['selectedyear'];
$selectedWorker = $_GET['selectedworker'];


$query = "call SP_generate2316Form('DC','".$selectedWorker."','".$selectedYear."','".$selectedYear."-01-01','".$selectedYear."-01-31');";

// $query = "call SP_generate2316Form('DC','DCWR000003','2020','2020-01-01','2020-01-31')";
//$query = "CALL payslipRPT('WFSIPY0000005', 'WFSI', 'WFSIWR000002')";
        $result = $conn->query($query);
        $row = $result->fetch_assoc();

        $name = $row["name"];

        $curMonth = "03";
        $myMonth = implode(" ", str_split($curMonth, 1));
        $arr_Month = explode(" ", $myMonth);

        $mon_1 = $arr_Month[0];
        $mon_2 = $arr_Month[1];
        
        $curYear = $selectedYear;
        $myYear = implode(" ", str_split($curYear, 1));
        $arr_Year = explode(" ", $myYear);

        $yr_1 = $arr_Year[0];
        $yr_2 = $arr_Year[1];
        $yr_3 = $arr_Year[2];
        $yr_4 = $arr_Year[3];

        $tinnum = str_replace("-","",$row["tinnum"]);
        $tinnumCompressedwithSpaces = implode(" ", str_split($tinnum, 1));
        $arr_Tinnum = explode(" ", $tinnumCompressedwithSpaces);

        $tinelineno0 =  $arr_Tinnum[0];
        $tinelineno1 =  $arr_Tinnum[1];
		$tinelineno2 =  $arr_Tinnum[2];
		$tinelineno3 =  $arr_Tinnum[3];
		$tinelineno4 =  $arr_Tinnum[4];
		$tinelineno5 =  $arr_Tinnum[5];
		$tinelineno6 =  $arr_Tinnum[6];
		$tinelineno7 =  $arr_Tinnum[7];
		$tinelineno8 =  $arr_Tinnum[8];
		$tinelineno9 =  $arr_Tinnum[9];
		$tinelineno10 =  $arr_Tinnum[10];
		$tinelineno11 =  $arr_Tinnum[11];
		//$tinelineno12 =  $arr_Tinnum[12];


        $myRdo = implode(" ", str_split($row['rdo_code'], 1));
        $arr_Rdo = explode(" ", $myRdo);

        $rdo1 = $arr_Rdo[0];
        $rdo2 = $arr_Rdo[1];
        $rdo3 = $arr_Rdo[2];

        $myZip1 = implode(" ", str_split($row['zip1'], 1));
        $arr_Zip1 = explode(" ", $myZip1);

        $Zip1_1 = $arr_Zip1[0];
        $Zip1_2 = $arr_Zip1[1];
        $Zip1_3 = $arr_Zip1[2];
        $Zip1_4 = $arr_Zip1[3];


        $myZip2 = implode(" ", str_split($row['zip2'], 1));
        $arr_Zip2 = explode(" ", $myZip2);

        $Zip2_1 = $arr_Zip2[0];
        $Zip2_2 = $arr_Zip2[1];
        $Zip2_3 = $arr_Zip2[2];
        $Zip2_4 = $arr_Zip2[3];



        $myBdate = implode(" ", str_split(str_replace("-","",$row['bdate']), 1));
        $arr_Bdate = explode(" ", $myBdate);

        $bdateyr1 = $arr_Bdate[0];
        $bdateyr2 = $arr_Bdate[1];
        $bdateyr3 = $arr_Bdate[2];
        $bdateyr4 = $arr_Bdate[3];
        $bdateMO1 = $arr_Bdate[4];
        $bdateMO2 = $arr_Bdate[5];
        $bdateD1  = $arr_Bdate[6];
        $bdateD2  = $arr_Bdate[7];

        $company = $row['employername'];
        $contactnum = $row['contactnum'];

        $minperday = $row['minperday'];
        $minpermonth = $row['minpermonth'];
        $mwe = $row['mwe'];


        $bpay_ =  (float)$row['basicpay'];
        $holpay_ = (float)$row['holidaypay'];
        $otPay_	= (float)$row['otpay'];
        $ndpay_	= (float)$row['ndpay'];
        $tmth_	= (float)$row['TMTH'];
        $dmnms_	= (float)$row['DMNMS'];
        $benefits_	= (float)$row['Benefits'];
        $oslry_	= (float)$row['OSLRY'];
        $exbpay_ = (float)$row['excessbasicpay'];
        $exTMTH_ = (float)$row['excessTMTH'];

        $bpay =   number_format($bpay_,2)== 0 ? "":number_format($bpay_,2);
        $holpay =  number_format($holpay_,2)== 0 ? "":number_format($holpay_,2);
        $otPay	=  number_format($otPay_,2)== 0 ? "":number_format($otPay_,2);
        $ndpay	=  number_format($ndpay_,2)== 0 ? "":number_format($ndpay_,2);
        $tmth	=  number_format($tmth_,2)== 0 ? "":number_format($tmth_,2);
        $dmnms	=  number_format($dmnms_,2) == 0 ? "":number_format($dmnms_,2);
        $benefits	=  number_format($benefits_,2)== 0 ? "":number_format($benefits_,2);
        $oslry	=  number_format($oslry_,2)== 0 ? "":number_format($oslry_,2);
        $exbpay =  number_format($exbpay_,2)== 0 ? "":number_format($exbpay_,2);
        $exTMTH =  number_format($exTMTH_,2)== 0 ? "":number_format($exTMTH_,2);

       $totalNT = number_format($bpay_ + $holpay_ + $otPay_ + $ndpay_ + $tmth_ + $benefits_,2) == 0 ? "":number_format($bpay_ + $holpay_ + $otPay_ + $ndpay_ + $tmth_ + $benefits_,2);

  // initiate FPDI

  $pdf = new \setasign\Fpdi\Fpdi();
    require_once "FPDI/src/autoload.php";
  $pdf = new FPDI('P','mm','Legal');

  /* <Virtual loop> */
  $pdf->AddPage();
  $pdf->setSourceFile('BIR Form 1601-FQ.pdf');
  $tplIdx = $pdf->importPage(1);
  

  $pdf->useTemplate($tplIdx, 2, -1, 210, 350);

  //Month
  // $pdf->SetFont('Arial','B',10);
  // $pdf->SetTextColor(0, 0, 0);
  // $pdf->SetXY(18.5, 44);
  // $pdf->Write(0,  $mon_1);

  // $pdf->SetFont('Arial','B',10);
  // $pdf->SetTextColor(0, 0, 0);
  // $pdf->SetXY(23.5, 44);
  // $pdf->Write(0,  $mon_2);

  //year
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(13.5, 46.5);
  $pdf->Write(0,  $yr_1);


  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(18.5, 46.5);
  $pdf->Write(0,  $yr_2);

  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(23.5, 46.5);
  $pdf->Write(0,  $yr_3);

  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(28.5, 46.5);
  $pdf->Write(0,  $yr_4);



  //tin
  #column 1
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(82.5, 59);
  $pdf->Write(0, $tinelineno0);

  #column 2
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(87.5, 59);
  $pdf->Write(0, $tinelineno1);

  #column 3
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(92.5, 59);
  $pdf->Write(0, $tinelineno2);

  #column 4
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(102, 59);
  $pdf->Write(0, $tinelineno3);

  #column 5
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(107, 59);
  $pdf->Write(0, $tinelineno4);

  #column 6
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(112, 59);
  $pdf->Write(0, $tinelineno5);


  #column 7
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(122, 59);
  $pdf->Write(0, $tinelineno6);

    #column 8
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(127, 59);
  $pdf->Write(0, $tinelineno7);


    #column 9
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(132, 59);
  $pdf->Write(0, $tinelineno8);




    #column 10
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(141.5, 59);
  $pdf->Write(0, $tinelineno9);


  #column 11
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(146.5, 59);
  $pdf->Write(0, $tinelineno10);

    #column 12
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(151.5, 59);
  $pdf->Write(0, $tinelineno11);


  // #column 13
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(127.4, 59);
  $pdf->Write(0, '');


  #Employee Name
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(9 , 68);
  $pdf->Write(0,$name);



  #RDO Code 1
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(191.5, 59);
  $pdf->Write(0, $rdo1);
  #RDO Code 2
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(196.5, 59);
  $pdf->Write(0, $rdo2);
  #RDO Code 3
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(201.5, 59);
  $pdf->Write(0, $rdo3);
/*
  #Registered Address
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(18,67);
  $pdf->Write(0, "Caloocan City");

  #Registered Address ZIP
  #Code 1
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(94.2, 67);
  $pdf->Write(0, "1");
  #Code 2
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(98.2, 67);
  $pdf->Write(0, "1");
  #Code 3
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(102.2, 67);
  $pdf->Write(0, "1");

  #Code 4
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(106.4, 67);
  $pdf->Write(0, "3");


  #Local Home Address
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(18,76.5);
  $pdf->Write(0, "Caloocan City");

  #Local Home Address ZIP
  #Code 1
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(94.2, 76.5);
  $pdf->Write(0, "1");
  #Code 2
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(98.2, 76.5);
  $pdf->Write(0, "1");
  #Code 3
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(102.2, 76.5);
  $pdf->Write(0, "1");

  #Code 4
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(106.4, 76.5);
  $pdf->Write(0, "3");



  #Local Home Address
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(18,85.5);
  $pdf->Write(0, "");

  #Birthdate DAY 1
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(17.5,95.2);
  $pdf->Write(0, $bdateD1);
  #Birthdate DAY 2
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(21.5,95.2);
  $pdf->Write(0, $bdateD2);
    #Birthdate m1
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(26.5,95.2);
  $pdf->Write(0, $bdateMO1);
     #Birthdate m2
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(30.5,95.2);
  $pdf->Write(0, $bdateMO2);

      #Birthdate y1
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(35.5,95.2);
  $pdf->Write(0, $bdateyr1);
     #Birthdate y2
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(40.5,95.2);
  $pdf->Write(0, $bdateyr2);
        #Birthdate y3
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(45.5,95.2);
  $pdf->Write(0, $bdateyr3);
     #Birthdate y4
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(50.5,95.2);
  $pdf->Write(0, $bdateyr4);


       #Contact No.
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(73,95.2);
  $pdf->Write(0, $contactnum);


       #Wage per day
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(76,138);
  $pdf->Write(0, "537.00");

         #Wage per month
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(76,144.5);
  $pdf->Write(0, $bpay);


 //tin
  #column 1
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(46.6, 161);
  $pdf->Write(0, "1");

  #column 2
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(50.7, 161);
  $pdf->Write(0, "2");

  #column 3
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(54.7, 161);
  $pdf->Write(0, "0");

  #column 4
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(62.9, 161);
  $pdf->Write(0, "0");

  #column 5
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(66.9,161);
  $pdf->Write(0, "0");

  #column 6
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(70.9, 161);
  $pdf->Write(0, "0");


  #column 7
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(79.8, 161);
  $pdf->Write(0, "0");

    #column 8
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(83.8, 161);
  $pdf->Write(0, "0");


    #column 9
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(87.4, 161);
  $pdf->Write(0, "0");




    #column 10
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(95.8, 161);
  $pdf->Write(0, "0");


  #column 11
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(99.8, 161);
  $pdf->Write(0, "0");

    #column 12
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(103.8, 161);
  $pdf->Write(0, "0");


  #column 13
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(107.4, 161);
  $pdf->Write(0, "0");



  #Employers Name
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(17, 170);
  $pdf->Write(0, $company);

  #Employers Address
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(17, 180);
  $pdf->Write(0, "Unit 502 F&L Building Quezon City");


  #Code 1
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(94.2, 180);
  $pdf->Write(0, "1");
  #Code 2
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(98.2, 180);
  $pdf->Write(0, "1");
  #Code 3
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(102.2, 180);
  $pdf->Write(0, "1");

  #Code 4
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(106.4, 180);
  $pdf->Write(0, "3");


    #21
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(66.4, 222.5);
  $pdf->Write(0,$totalNT);



  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(147.5, 36);
  $pdf->Write(0, "0");


  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(151.2, 36);
  $pdf->Write(0, "3");

  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(155.2, 36);
  $pdf->Write(0, "3");

  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(159, 36);
  $pdf->Write(0, "1");



  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(188.5, 36);
  $pdf->Write(0, "0");


  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(192.2, 36);
  $pdf->Write(0, "3");

  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(196.2, 36);
  $pdf->Write(0, "0");

  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(200, 36);
  $pdf->Write(0, "1");



#part IV 
  #basic salary
   $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(159, 57.5);
  $pdf->Write(0, $bpay);

      #holiday pay
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(159, 68.8);
  $pdf->Write(0, $holpay);

      #OT pay
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(159, 76.8);
  $pdf->Write(0, $otPay);

      #ND pay
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(159, 84.8);
  $pdf->Write(0, $ndpay);

      #HAZ pay
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(159, 92.8);
  $pdf->Write(0, "");
        #13th pay
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(159, 100.3);
  $pdf->Write(0, $tmth);

     #Deminimis
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(159,109.8);
  $pdf->Write(0, $dmnms);

       #SSS GSIS PHIC
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(159,120.2);
  $pdf->Write(0, $benefits);


       #Other Salary
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(159,134.2);
  $pdf->Write(0, $oslry);

       #Non Taxable
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(159,144.2);
  $pdf->Write(0, $bpay);

       #B
  #basic salary
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(159,163.2);
  $pdf->Write(0,"");

    #representation
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(159,171.2);
  $pdf->Write(0, "");

     #transportation
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(159,179.2);
  $pdf->Write(0, "");

       #COLA
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(159,186.2);
  $pdf->Write(0, "");

         #TOTAL
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(159,186.2);
  $pdf->Write(0, "");*/




  $pdf->AddPage();
  $tplIdx = $pdf->importPage(2);
  $pdf->useTemplate($tplIdx, 2, -1, 210, 350);

  //tin
  #column 1
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(8.5, 47);
  $pdf->Write(0, $tinelineno0);

  #column 2
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(13.5, 47);
  $pdf->Write(0, $tinelineno1);

  #column 3
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(18.5, 47);
  $pdf->Write(0, $tinelineno2);

  #column 4
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(23.5, 47);
  $pdf->Write(0, $tinelineno3);

  #column 5
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(28.5, 47);
  $pdf->Write(0, $tinelineno4);

  #column 6
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(33.5, 47);
  $pdf->Write(0, $tinelineno5);


  #column 7
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(38.5, 47);
  $pdf->Write(0, $tinelineno6);

    #column 8
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(43.5, 47);
  $pdf->Write(0, $tinelineno7);


    #column 9
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(48.5, 47);
  $pdf->Write(0, $tinelineno8);




    #column 10
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(53.5, 47);
  $pdf->Write(0, $tinelineno9);


  #column 11
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(58.5, 47);
  $pdf->Write(0, $tinelineno10);

    #column 12
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(63.5, 47);
  $pdf->Write(0, $tinelineno11);


  // #column 13
  // $pdf->SetFont('Arial','B',10);
  // $pdf->SetTextColor(0, 0, 0);
  // $pdf->SetXY(68.5, 37);
  // $pdf->Write(0, '');


  #Employee Name
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(77 , 47);
  $pdf->Write(0,$name);





























  
  $pdf->Output('newpdf1.pdf', 'I');

?>