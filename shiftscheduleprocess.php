<?php
session_id("payso");
session_start();
#$userlogin = $_SESSION["user"];

include("dbconn.php");
$dataareaid = $_SESSION["defaultdataareaid"];
$user = $_SESSION["user"];

if($_GET["action"]=="filtersched"){
//----------Schedule
	if($_GET["actmode"]=="filter"){
		$output='';
		$sched = '';
		$schedparam = '';
		$frdate=$_GET["locFromdate"];
		$todate=$_GET["locTodate"];
		//$schedtype=$_GET["locType"];
		$id=$_GET["SelectedVal"];

		$query = "SELECT *
					from shiftschedule 	
					where dataareaid = '$dataareaid' and workerid in ($id) and date between cast('$frdate' as date) and cast('$todate' as date) ";
		$result = $conn->query($query);
		
		while ($row = $result->fetch_assoc())
		{
			$sched = $row["workerid"];
			
		}
		if($sched == '')
		{
			$schedparam = "False";
		}
		else
		{
			$schedparam = "True";
		}
		$output .= '
				 <input type="hidden" value="'.$schedparam.'" id="filterSched">
				 ';

		echo $output;

	}
}

else if($_GET["action"]=="savesched"){
//----------Schedule
	if($_GET["actmode"]=="schedule"){

		$frdate =$_GET["locFromdate"];
		$todate = $_GET["locTodate"];
		$schedtype = $_GET["locType"];
		$id = $_GET["SelectedVal"];

		$rd = $_GET["restdays"];

		//echo "<h2>" . $rd . "</h2>";

		$starttime = '';
		$endtime = '';
		$stat = '';
		$breakout = '';
		$breakin = '';
		$query = "SELECT *
					from shifttype 
								
					where dataareaid = '$dataareaid' and shifttype = '$schedtype' ";
		$result = $conn->query($query);
		
		while ($row = $result->fetch_assoc())
		{
			$starttime = $row["starttime"];
			$endtime = $row["endtime"];
			$breakout = $row["breakout"];
			$breakin = $row["breakin"];
		}
	  		$wkquery = "SELECT * FROM worker where workerid in ($id)";
				$wkresult = $conn->query($wkquery);
				while ($wkrow = $wkresult->fetch_assoc())
				{
					$userid=$wkrow["workerid"];

					/*$query = "INSERT Into shiftschedule (date,weekday,shifttype,starttime,endtime,daytype,dataareaid,workerid)  
	                               
	                            SELECT date, Weekday, '$schedtype', concat(date,' ',STR_TO_DATE('$starttime', '%l:%i %p')),
		                       
		                        case when STR_TO_DATE('$endtime', '%l:%i %p') <= CONVERT('06:00:00', TIME) and STR_TO_DATE('06:00 PM', '%l:%i %p') >= CONVERT('00:00:00', TIME)  
		                        
		                        then concat(DATE_ADD(date, INTERVAL 1 day),' ',STR_TO_DATE('$endtime', '%l:%i %p')) else concat(date,' ',STR_TO_DATE('$endtime', '%l:%i %p')) end, 
		                        
		                        case when DayType = 'Weekend' then 'Regular' else daytype end as DayType, '$dataareaid','$userid'  
		                        FROM calendartable  ct 
                                
                                left join worker wk on wk.branch = ct.branchcode and ct.dataareaid = wk.dataareaid

		                        WHERE date between cast('$frdate' as date) and cast('$todate' as date)  
		                        and date not in (select date FROM shiftschedule  
		                        where date between cast('$frdate' as date) and cast('$todate' as date) and  
		                        workerid = '$userid')  
		                        and ct.dataareaid = '$dataareaid' and wk.workerid = '$userid';";*/

		            $query = "INSERT Into shiftschedule (date,weekday,shifttype,starttime,endtime,daytype,dataareaid,workerid,breakout,breakin)  
	                               
	                            SELECT date, Weekday, '$schedtype', concat(date,' ','$starttime'),
		                       
		                        case when '$endtime' <= CONVERT('06:00:00', TIME) and '18:00:00' >= CONVERT('00:00:00', TIME)  
		                        
		                        then concat(DATE_ADD(date, INTERVAL 1 day),' ','$endtime') else concat(date,' ','$endtime') end, 
		                        
		                        case when DayType = 'Weekend' then 'Regular' else daytype end as DayType, '$dataareaid','$userid',

		                        concat(date,' ','$breakout'),
                                
                                case when '$breakin' <= CONVERT('06:00:00', TIME) and '18:00:00' >= CONVERT('00:00:00', TIME)  
		                        
		                        then concat(DATE_ADD(date, INTERVAL 1 day),' ','$breakin') else concat(date,' ','$breakin') end  

		                        FROM calendartable  ct 
                                
                                left join worker wk on wk.branch = ct.branchcode and ct.dataareaid = wk.dataareaid

		                        WHERE date between cast('$frdate' as date) and cast('$todate' as date)  
		                        and date not in (select date FROM shiftschedule  
		                        where date between cast('$frdate' as date) and cast('$todate' as date) and  
		                        workerid = '$userid')  
		                        and ct.dataareaid = '$dataareaid' and wk.workerid = '$userid';";



		            if(mysqli_query($conn,$query))
					{
						echo "New Rec Created";
					}
					else
					{
						echo "error ".$query."<br>".$conn->error;
					}
				}
				if($rd != ''){
					$wkquery = "SELECT * FROM worker where workerid in ($id)";
					$wkresult = $conn->query($wkquery);

					while ($wkrow = $wkresult->fetch_assoc())
					{
						$userid=$wkrow["workerid"];

							$rdquery = "UPDATE shiftschedule a 
								set 
								a.daytype = 'Restday'

								where a.workerid =  '$userid' and a.weekday in ($rd) 
								and a.date between cast('$frdate' as date) and cast('$todate' as date)
								and a.dataareaid = '$dataareaid'
								and a.daytype in ('Regular','Weekend')
								
								";

								if(mysqli_query($conn,$rdquery))
									{
										echo "with restday";
									}
									else
									{
										echo "error ".$rdquery."<br>".$conn->error;
									}
						
					}			  
				}

					
	}

	header('location: shiftschedule.php');
}

else if($_GET["action"]=="updatesched"){
//----------Schedule
	if($_GET["actmode"]=="schedule"){

		$frdate=$_GET["locFromdate"];
		$todate=$_GET["locTodate"];
		$schedtype=$_GET["locType"];
		$id=$_GET["SelectedVal"];
		$rd = $_GET["restdays"];
		//$restdays = $_GET["restdays"];
		$starttime = '';
		$endtime = '';
		$stat = '';
		$breakout = '';
		$breakin = '';
		$query = "SELECT *
					from shifttype 
								
					where dataareaid = '$dataareaid' and shifttype = '$schedtype' ";
		$result = $conn->query($query);
		
		while ($row = $result->fetch_assoc())
		{
			$starttime = $row["starttime"];
			$endtime = $row["endtime"];
			$breakout = $row["breakout"];
			$breakin = $row["breakin"];
		}
					
		  	$wksquery = "SELECT * FROM worker where workerid in ($id)";
				$wksresult = $conn->query($wksquery);

				while ($wksrow = $wksresult->fetch_assoc())
				{
					$userid=$wksrow["workerid"];
					$query = "UPDATE shiftschedule a 
                        left join  calendartable b 
                        on a.Date = b.date and a.dataareaid = b.dataareaid 
                        set a.shifttype = '$schedtype',
                        
                        a.starttime = concat(b.date,' ','$starttime'), 
                        a.endtime = case when '$endtime' <= CONVERT('06:00:00', TIME) and '$endtime' >= CONVERT('00:00:00', TIME) 
                        then concat(DATE_ADD(b.date, INTERVAL 1 day),' ','$endtime') else concat(b.date,' ','$endtime') end, 
                        a.daytype = case when b.DayType = 'Weekend' then 'Regular' else b.daytype end,
                        a.breakout = concat(b.date,' ','$breakout'),
                        a.breakin = case when '$breakin' <= CONVERT('06:00:00', TIME) and '18:00:00' >= CONVERT('00:00:00', TIME)  
		                then concat(DATE_ADD(b.date, INTERVAL 1 day),' ','$breakin') else concat(b.date,' ','$breakin') end 

                        where a.workerid =  '$userid' and a.date between cast('$frdate' as date) and cast('$todate' as date)";

		            if(mysqli_query($conn,$query))
					{
						echo "Rec Updated";
					}
					else
					{
						echo "error ".$query."<br>".$conn->error;
					}
				}
				echo $query;
				/*$wkquery = "SELECT * FROM worker where workerid in ($id)";
				$wkresult = $conn->query($wkquery);

				while ($wkrow = $wkresult->fetch_assoc())
				{
					$userid=$wkrow["workerid"];

					$query = "INSERT Into shiftschedule (date,weekday,shifttype,starttime,endtime,daytype,dataareaid,workerid,breakout,breakin)  
	                               
	                            SELECT date, Weekday, '$schedtype', concat(date,' ','$starttime'),
		                       
		                        case when '$endtime' <= CONVERT('06:00:00', TIME) and '18:00:00' >= CONVERT('00:00:00', TIME)  
		                        
		                        then concat(DATE_ADD(date, INTERVAL 1 day),' ','$endtime') else concat(date,' ','$endtime') end, 
		                        
		                        case when DayType = 'Weekend' then 'Regular' else daytype end as DayType, '$dataareaid','$userid',

		                        concat(date,' ','$breakout'),
                                
                                case when '$breakin' <= CONVERT('06:00:00', TIME) and '18:00:00' >= CONVERT('00:00:00', TIME)  
		                        
		                        then concat(DATE_ADD(date, INTERVAL 1 day),' ','$breakin') else concat(date,' ','$breakin') end 

		                        FROM calendartable ct 
                                
                                left join worker wk on wk.branch = ct.branchcode and ct.dataareaid = wk.dataareaid

		                        WHERE date between cast('$frdate' as date) and cast('$todate' as date)  
		                        and date not in (select date FROM shiftschedule  
		                        where date between cast('$frdate' as date) and cast('$todate' as date) and  
		                        workerid = '$userid')  
		                        and ct.dataareaid = '$dataareaid' and wk.workerid = '$userid';";

		            if(mysqli_query($conn,$query))
					{
						echo "New Rec Created";
					}
					else
					{
						echo "error ".$query."<br>".$conn->error;
					}
				}
				if($rd != ''){
					$wkquery = "SELECT * FROM worker where workerid in ($id)";
					$wkresult = $conn->query($wkquery);

					while ($wkrow = $wkresult->fetch_assoc())
					{
						$userid=$wkrow["workerid"];

							$rdquery = "UPDATE shiftschedule a 
								set a.daytype = 'Restday'

								where a.workerid =  '$userid' and a.weekday in ($rd) 
								and a.date between cast('$frdate' as date) and cast('$todate' as date)
								and a.dataareaid = '$dataareaid'
								and a.daytype in ('Regular','Weekend')
								";

								if(mysqli_query($conn,$rdquery))
									{
										echo "with restday";
									}
									else
									{
										echo "error ".$rdquery."<br>".$conn->error;
									}
							
						}		
				}*/		  			  	
				
					  
	}
	//header('location: shiftschedule.php');

}

else if(isset($_GET["update"])){
	 

		 $shifttype=$_GET["shifttype"];
		 $starttime=$_GET["starttime"];
		 $endtime=$_GET["endtime"];
		 
		 if($shifttype != ""){
		 $sql = "UPDATE shifttype SET
					shifttype = '$shifttype',
					starttime = TIME_FORMAT('$starttime', '%h:%i %p'),
					endtime = TIME_FORMAT('$endtime', '%h:%i %p')
					
					WHERE shifttype = '$shifttype'
					and dataareaid = 'STA'";
					/*modifiedby = '$userlogin',
					modifieddatetime = now()*/
			if(mysqli_query($conn,$sql))
			{
				echo "Rec Updated";
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}

		 
		 
		header('location: shiftype.php');
	}
	
}
else if($_GET["action"]=="delete"){
	 
	
		$shifttype=$_GET["shifttype"];

		if($shifttype != ""){
			$sql = "DELETE from shifttype where shifttype = '$shifttype'";
			if(mysqli_query($conn,$sql))
			{
				echo "Rec Deleted";
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}

		}
	//	header('location: shiftype.php');
	
	
}
else if($_GET["action"]=="searchdata"){
	if($_GET["actmode"]=="userform"){
		$id=$_GET["workerid"];
		$name=$_GET["name"];
		$position = $_GET["position"];
		$paygroup = $_GET["paygroup"];
		$dept = $_GET["dept"];
		$output='';
		//$output .= '<tbody>';
		$query = "SELECT wk.workerid,wk.Name,pos.name as 'position',case when wk.payrollgroup = 0 then 'Weekly' else 'Semi-Montlhy' end as payrollgroup,dep.name as 'department'

					FROM worker wk 

				left join position pos on pos.positionid = wk.position and pos.dataareaid = wk.dataareaid 
				left join contract con on con.workerid = wk.workerid and con.dataareaid = wk.dataareaid
				left join department dep on dep.departmentid = con.departmentid and dep.dataareaid = wk.dataareaid

				where wk.dataareaid = '$dataareaid' and con.fromdate <= date(now()) and wk.workerid like '%$id%' and wk.Name like '%$name%' and pos.name like '%$position%'
				and (dep.name like '%$dept%')
				and (case              
							when wk.payrollgroup = 0 then 'Weekly' 
							
							else 'Semi-Montlhy' end) like '%$paygroup%'
					
					";
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
				<td style="width:5%;"><input type="checkbox" id="chkbox" name="chkbox" class="checkbox"
				 	value="'.$row['workerid'].'"></td>
				<td style="width:20%;">'.$row["workerid"].'</td>
				<td style="width:20%;">'.$row["Name"].'</td>
				<td style="width:20%;">'.$row["position"].'</td>
				<td style="width:20%;">'.$row["payrollgroup"].'</td>
				<td style="width:20%;">'.$row["department"].'</td>


				

			</tr>';
		}


		//$output .= '</tbody>';
		echo $output;
		//header('location: process.php');
	}
}


else if($_GET["action"]=="shiftline"){
	 
	
		$workernum=$_GET["workerid"];

		$_SESSION['wknum'] = $workernum;

		//header('location: viewschedule.php');
	//	header('location: shiftype.php');
	
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
			var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
			// var stimer = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(10)").text();
			// var etimer = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(9)").text();
			//locname = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
			so = usernum.toString();
			//gl_stimer = stimer;
			//gl_etimer = etimer.toString();
			document.getElementById("hide").value = so;
			//alert(document.getElementById("hide").value);
			//alert(so);	
						  
				});
			});


	$('[name=chkbox]').change(function(){
		
	    if($(this).attr('checked'))
	    {
      		//document.getElementById("inchide").value = $(this).val();
      		Add();
	    }
	    else
	    {
				         
	         //document.getElementById("inchide").value=$(this).val();
	         remVals.push("'"+$(this).val()+"'");
	         $('#inchide2').val(remVals);

	         $.each(remVals, function(i, el2){

	    		removeA(allVals, el2);
	    		removeA(uniqueNames, el2);
		    	//$("input[value="+el+"]").prop("checked", true);
		    	//alert(el);
			});
	        Add();

	    }
	 });

	$("#selectAll").change(function(){  //"select all" change 
			 

			 if(false == $(this).prop("checked")){ //if this item is unchecked
		        $('[name=chkbox]').prop('checked', false); //change "select all" checked status to false
		         allVals = [];
				 uniqueNames = [];
				 remVals = [];
				 remValsEx = [];
		        document.getElementById('inchide').value = '';
		        document.getElementById('inchide2').value = '';
		        //alert('sample');

		    }
		    else
		    {
		    	$(".checkbox").prop('checked', $(this).prop("checked")); //change all ".checkbox" checked status
		    	Add();
		    }

		});


	
	function Add() 
	{  

		
		$('#inchide').val('');
		 $('[name=chkbox]:checked').each(function() {
		   allVals.push("'"+$(this).val()+"'");
		 });

		  //remove existing rec start-----------------------
		 $('[name=chkbox]:disabled').each(function() {
		   
		   remValsEx.push("'"+$(this).val()+"'");
	         //$('#inchide2').val(remValsEx);

	         $.each(remValsEx, function(i, el2){
	         		
	    		removeA(allVals, el2);
	    		removeA(uniqueNames, el2);
		    	//"'"+"PCC"+"'"
			});
		   
		 });
		 //remove existing rec end-

		 
			$.each(allVals, function(i, el){
			    if($.inArray(el, uniqueNames) === -1) uniqueNames.push(el);
			});
		
		 $('#inchide').val(uniqueNames);
		 filtersched();

	} 
	function CheckedVal()
	{ 
		$.each(uniqueNames, function(i, el){
			    $("input[value="+el+"]").prop("checked", true);
			    //alert(el);
			});
	}


</script>