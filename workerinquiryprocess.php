<?php
session_id("payso");
session_start();
#$userlogin = $_SESSION["user"];

include("dbconn.php");
$dataareaid = $_SESSION["defaultdataareaid"];
$user = $_SESSION["user"];

if($_GET["action"]=="searchdata"){
	if($_GET["actmode"]=="userform"){
		$id=$_GET["workerid"];
		$name=$_GET["name"];
		//$position = $_GET["position"];
		$output='';
		//$output .= '<tbody>';
		$query = "SELECT w.workerid as id, w.name as nme, p.name position,
		   (select case when c.rate is null then 0 else format(c.rate,2) end from contract c
			where c.workerid = w.workerid and c.dataareaid = w.dataareaid order by c.fromdate desc limit 1) rate,
		   (select case when c.ecola is null then 0 else format(c.ecola,2) end from contract c
			where c.workerid = w.workerid and c.dataareaid = w.dataareaid order by c.fromdate desc limit 1) ecola,
		   (select case when c.transpo is null then 0 else format(c.transpo,2) end from contract c
			where c.workerid = w.workerid and c.dataareaid = w.dataareaid order by c.fromdate desc limit 1) transpo,
		   (select case when c.meal is null then 0 else format(c.meal,2) end from contract c
			where c.workerid = w.workerid and c.dataareaid = w.dataareaid order by c.fromdate desc limit 1) meal,
		   (select rh.fromdate from ratehistory rh inner join contract c on  c.contractid = rh.contractid
																		 and c.dataareaid = rh.dataareaid
			where c.workerid = w.workerid and c.dataareaid = w.dataareaid and rh.status = 1 order by rh.fromdate desc limit 1) lastsalarymovement,
		   w.address, w.contactnum, date_format(w.birthdate, '%Y-%m-%d') birthdate,
		   case when month(now()) < month(birthdate) or (month(now()) = month(birthdate) and day(now()) < day(birthdate)) then
				year(now()) - year(birthdate) - 1
		   else
				year(now()) - year(birthdate)
		   end age,
		   date_format(w.datehired, '%Y-%m-%d') datehired,
		   case when month(now()) < month(datehired) or (month(now()) = month(datehired) and day(now()) < day(datehired)) then
				case when month(now()) = month(datehired) and day(now()) < day(datehired) then
					concat(year(now()) - year(datehired) - 1, 'y ', month(now()) - month(datehired) + 12 - 1, 'm')
				else
					concat(year(now()) - year(datehired) - 1, 'y ', month(now()) - month(datehired) + 12, 'm')
				end
		   else
				concat(year(now()) - year(datehired), 'y ', month(now()) - month(datehired), 'm')
		   end lengthofservice,
		   date_format(w.regularizationdate, '%Y-%m-%d') regularizationdate, w.sssnum, w.phnum, w.pagibignum, w.tinnum, w.bankaccountnum, d.name company
	from 	   worker   w
	inner join dataarea d on d.dataareaid = w.dataareaid
	left join  position p on  p.positionid = w.position
						  and p.dataareaid = w.dataareaid
	where w.dataareaid = '$dataareaid' 
		and w.inactive = 0
		and w.workerid like '%$id%' and w.name like '%$name%'";
		$result = $conn->query($query);
		$rowclass = "rowA";
		$rowcnt = 0;
		$rowcnt2 = 0;
		while ($row = $result->fetch_assoc())
		{ 
			$rowcnt++;
			$rowcnt2++;
				if($rowcnt > 1) { $rowcnt = 0; $rowclass = "rowB"; }
				else { $rowclass = "rowA";}
			$output .= '
			<tr class="'.$rowclass.'" tabindex="'.$rowcnt2.'" >
				<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
				<td style="width:210px;">'.$row["id"].'</td>
				<td style="width:400px;">'.$row["nme"].'</td>
				<td style="width:200px;">'.$row["position"].'</td>
				<td style="width:200px;">'.$row['rate'].'</td>
				<td style="width:200px;">'.$row['ecola'].'</td>
				<td style="width:200px;">'.$row['transpo'].'</td>
				<td style="width:200px;">'.$row['meal'].'</td>
				<td style="width:250px;">'.$row['lastsalarymovement'].'</td>
				<td style="width:600px;">'.$row['address'].'</td>

				<td style="width:200px;">'.$row['contactnum'].'</td>
				<td style="width:200px;">'.$row['birthdate'].'</td>
				<td style="width:200px;">'.$row['age'].'</td>
				<td style="width:200px;">'.$row['datehired'].'</td>
				<td style="width:200px;">'.$row['lengthofservice'].'</td>
				<td style="width:200px;">'.$row['regularizationdate'].'</td>

				<td style="width:200px;">'.$row['sssnum'].'</td>
				<td style="width:200px;">'.$row['phnum'].'</td>
				<td style="width:200px;">'.$row['pagibignum'].'</td>
				<td style="width:200px;">'.$row['tinnum'].'</td>
				<td style="width:200px;">'.$row['bankaccountnum'].'</td>
				<td style="width:200px;">'.$row['company'].'</td>
			</tr>';
		}


		//$output .= '</tbody>';
		echo $output;
		//header('location: process.php');
	}
}



?>

<script src="js/ajax.js"></script>
	 <script  type="text/javascript">

		var locname='';
	  	var so='';
	  	var gl_stimer= '';
	  	var gl_etimer= '';
		$(document).ready(function(){
			$('#datatbl tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","red");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
			var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
			// var stimer = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(10)").text();
			// var etimer = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(9)").text();
			//locname = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
			so = usernum.toString();
			//gl_stimer = stimer;
			//gl_etimer = etimer.toString();
			document.getElementById("hide").value = so;
			//alert(document.getElementById("hide").value);
			//alert(so);	
			//document.getElementById("add-type").value = wa;
			//alert(wa);

			var position = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();
			var rate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(4)").text();
			var ecola = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(5)").text();
			var transpo = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(6)").text();
			var meal = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(7)").text();
			var LSM = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(8)").text();
			var address = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(9)").text();
			var cnum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(10)").text();
			var birthdate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(11)").text();
			var age = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(12)").text();
			var datehired = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(13)").text();
			var LOS = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(14)").text();
			var rdate = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(15)").text();
			var sssnum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(16)").text();
			var phnum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(17)").text();
			var pagibignum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(18)").text();
			var tinnum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(19)").text();
			var bankaccountnum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(20)").text();
			var company = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(21)").text();

			document.getElementById("view-workerid").value = so.toString();
			document.getElementById("view-position").value = position.toString();
			document.getElementById("view-rate").value = rate.toString();
			document.getElementById("view-ecola").value = ecola.toString();
			document.getElementById("view-transpo").value = transpo.toString();
			document.getElementById("view-meal").value = meal.toString();
			document.getElementById("view-LSM").value = LSM.toString();
			document.getElementById("view-address").value = address.toString();
			document.getElementById("view-cnum").value = cnum.toString();
			document.getElementById("view-birthdate").value = birthdate.toString();
			document.getElementById("view-age").value = age.toString();
			document.getElementById("view-datehired").value = datehired.toString();
			document.getElementById("view-LOS").value = LOS.toString();
			document.getElementById("view-rdate").value = rdate.toString();
			document.getElementById("view-sssnum").value = sssnum.toString();
			document.getElementById("view-phnum").value = phnum.toString();
			document.getElementById("view-pagibignum").value = pagibignum.toString();
			document.getElementById("view-tinnum").value = tinnum.toString();
			document.getElementById("view-bankaccountnum").value = bankaccountnum.toString();
			document.getElementById("view-company").value = company.toString();
						  
				});
			});
		$(document).ready(function(){
        	$("#container2 :input").prop("disabled", true);
    	});

		//-----search-----//
		$( ".search" ).on( "keydown", function(event) {
		  if(event.which == 13){
			var search = document.getElementsByClassName('search');
			var workerid;
			var name;
			var position;
			var action = "searchdata";
			var actionmode = "userform";
			var data=[];
			 for(i=0;i<search.length;i++){
				 data[i]=search[i].value;
				 //search[i].value = "";
			 }
			 
			 workerid = data[0];
			 name = data[1];
			 position = data[2];

			 $.ajax({
						type: 'GET',
						url: 'workerinquiryprocess.php',
						data:{action:action, actmode:actionmode, workerid:workerid, name:name, position:position},
						//data:'bkno='+BNo+'&bkdesc='+BDesc+'&bktit='+BTit+'&bkqty='+BQ,
						beforeSend:function(){
						
							//$("#result").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
			
						},
						success: function(data){
							$('#result').html(data);
				}
			}); 
			 
		  }
		});
		//-----end search-----//



</script>
<script type="text/javascript" src="js/custom.js"></script>