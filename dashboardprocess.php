<?php
session_start();
session_regenerate_id();
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
include("dbconn.php");


if($_POST["action"]=="getMonthlyPayroll"){
	$attbranch = $_POST['attbranch'];
	$WKquery = "SELECT sum(case when pda.accountcode = 'BPAY' then value else 0 end) BPAY,
				sum(case when pda.accountcode = 'GPAY' then value else 0 end) GPAY,
				sum(case when pda.accountcode = 'NPAY' then value else 0 end) NPAY,
                concat(DATE_FORMAT(pp.payrolldate, '%b'),' - ',DATE_FORMAT(pp.payrolldate, '%Y')) as month
				
				from payrollheader ph
				inner join payrolldetailsaccounts pda on pda.payrollid = ph.payrollid and
			
				pda.dataareaid = ph.dataareaid and
				pda.accountcode in ('BPAY', 'GPAY', 'NPAY')
				left join payrollperiod pp on pp.payrollperiod = ph.payrollperiod and pp.dataareaid = ph.dataareaid

				where pda.accountcode in ('BPAY', 'GPAY', 'NPAY')
				and DATE_FORMAT(pp.payrolldate,'%Y-%m') >= DATE_FORMAT(now() - INTERVAL 12 month,'%Y-%m')
				#and DATE_FORMAT(pp.payrolldate,'%Y-%m') != DATE_FORMAT(now(),'%Y-%m')
				#and DATE_FORMAT(pp.payrolldate,'%Y-%m') < DATE_FORMAT(now(),'%Y-%m')
				and ph.payrollstatus = '3' and ph.dataareaid = '$dataareaid'
				";
				if($attbranch != '')
					{
						$WKquery .= " and ph.branchcode = '$attbranch' ";
					}
			$WKquery .= "
				 group by concat(DATE_FORMAT(pp.payrolldate, '%b'),' - ',DATE_FORMAT(pp.payrolldate, '%Y'))
				,DATE_FORMAT(pp.payrolldate, '%m'),DATE_FORMAT(pp.payrolldate, '%Y')
				order by DATE_FORMAT(pp.payrolldate, '%Y'),DATE_FORMAT(pp.payrolldate, '%m') asc";

			$WKresult = $conn->query($WKquery);
			while ($WKrow = $WKresult->fetch_assoc())
			{
				
				$output[] = array(
			     'month'  => $WKrow["month"],
			     'BPAY' => floatval($WKrow["BPAY"]),
			     'GPAY' => floatval($WKrow["GPAY"]),
			     'NPAY' => floatval($WKrow["NPAY"])
			    );


			}
	echo json_encode($output);
	//header('location: dtrform.php');
}

elseif($_POST["action"]=="getMonthlyContribution"){
	$attbranch = $_POST['attbranch'];
	$WKquery = "SELECT sum(case when pda.accountcode = 'SSS' then value else 0 end) SSS,
				sum(case when pda.accountcode = 'PHIC' then value else 0 end) PHIC,
				sum(case when pda.accountcode = 'HDMF' then value else 0 end) HDMF,concat(DATE_FORMAT(pp.payrolldate, '%b'),' - ',DATE_FORMAT(pp.payrolldate, '%Y')) as month
				from payrollheader ph
				inner join payrolldetailsaccounts pda on pda.payrollid = ph.payrollid and
			
				pda.dataareaid = ph.dataareaid and
				pda.accountcode in ('SSS', 'HDMF', 'PHIC')
				left join payrollperiod pp on pp.payrollperiod = ph.payrollperiod and pp.dataareaid = ph.dataareaid

				where pda.accountcode in ('SSS', 'HDMF', 'PHIC')
				and DATE_FORMAT(pp.payrolldate,'%Y-%m') >= DATE_FORMAT(now() - INTERVAL 12 month,'%Y-%m')
				#and DATE_FORMAT(pp.payrolldate,'%Y-%m') != DATE_FORMAT(now(),'%Y-%m')
				and ph.payrollstatus = '3' and ph.dataareaid = '$dataareaid'
				";
				if($attbranch != '')
					{
						$WKquery .= " and ph.branchcode = '$attbranch' ";
					}
			$WKquery .= "
				group by concat(DATE_FORMAT(pp.payrolldate, '%b'),' - ',DATE_FORMAT(pp.payrolldate, '%Y'))
				,DATE_FORMAT(pp.payrolldate, '%m'),DATE_FORMAT(pp.payrolldate, '%Y')
				order by DATE_FORMAT(pp.payrolldate, '%Y'),DATE_FORMAT(pp.payrolldate, '%m') asc";

			$WKresult = $conn->query($WKquery);
			while ($WKrow = $WKresult->fetch_assoc())
			{
				
				$output[] = array(
			     'month'  => $WKrow["month"],
			     'SSS' => floatval($WKrow["SSS"]),
			     'PHIC' => floatval($WKrow["PHIC"]),
			     'HDMF' => floatval($WKrow["HDMF"])			     
			    );


			}
	echo json_encode($output);
	//header('location: dtrform.php');
}

elseif($_POST["action"]=="getMonthlyTax"){
	$attbranch = $_POST['attbranch'];
	$WKquery = "SELECT ifnull(sum(case when pda.accountcode = 'TAX' then value else 0 end),0) TAX
			,concat(DATE_FORMAT(pp.payrolldate, '%b'),' - ',DATE_FORMAT(pp.payrolldate, '%Y')) as month
				from payrollheader ph
				inner join payrolldetailsaccounts pda on pda.payrollid = ph.payrollid and
			
				pda.dataareaid = ph.dataareaid and
				pda.accountcode in ('TAX')
				left join payrollperiod pp on pp.payrollperiod = ph.payrollperiod and pp.dataareaid = ph.dataareaid

				where pda.accountcode in ('TAX')
				and DATE_FORMAT(pp.payrolldate,'%Y-%m') >= DATE_FORMAT(now() - INTERVAL 12 month,'%Y-%m')
				#and DATE_FORMAT(pp.payrolldate,'%Y-%m') != DATE_FORMAT(now(),'%Y-%m')
				and ph.payrollstatus = '3' and ph.dataareaid = '$dataareaid'
				";
				if($attbranch != '')
					{
						$WKquery .= " and ph.branchcode = '$attbranch' ";
					}
			$WKquery .= "
				group by concat(DATE_FORMAT(pp.payrolldate, '%b'),' - ',DATE_FORMAT(pp.payrolldate, '%Y'))
				,DATE_FORMAT(pp.payrolldate, '%m'),DATE_FORMAT(pp.payrolldate, '%Y')
				order by DATE_FORMAT(pp.payrolldate, '%Y'),DATE_FORMAT(pp.payrolldate, '%m') asc";

			$WKresult = $conn->query($WKquery);
			while ($WKrow = $WKresult->fetch_assoc())
			{
				
				$output[] = array(
			     'month'  => $WKrow["month"],
			     'TAX' => floatval($WKrow["TAX"])		     
			    );


			}
	echo json_encode($output);
	//header('location: dtrform.php');
}


?>
