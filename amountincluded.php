<?php
session_id("payso");
session_start();
include("dbconn.php");
$dataareaid = $_SESSION["defaultdataareaid"];
$id=$_POST["WorkID"];

if(isset($_POST["AEpayId"])) {

$AEpaynum= $_POST['AEpayId'];

}
?>



	<?php	
		if($id !='')
		{
			$query = "SELECT pa.accountcode,pa.accountname,um as 'UM',format(value,2) value,'0.00' as 'ExcludedValue',0 as 'Exclude All Values','1900-01-01' as 'PaymentDate' 
					 from payrolldetails pd 
					 left join payrolldetailsaccounts pa on pd.payrollid = pa.payrollid and pd.linenum = pa.reflinenum and pd.dataareaid = pa.dataareaid
					 where pd.payrollid = '$AEpaynum' and pd.dataareaid = '$dataareaid' and pd.workerid = '$id' 
					 #and pa.accountcode not in (select accountcode from excludedpayment where refpayrollid = pd.payrollid and workerid = pd.workerid and dataareaid = pd.dataareaid)
					 order by pa.priority asc";
			$result = $conn->query($query);
			$rowclass = "rowA";
			$rowcnt = 0;
			while ($row = $result->fetch_assoc())
			{ 
				$rowcnt++;
					if($rowcnt > 1) { $rowcnt = 0; $rowclass = "rowB"; }
					else { $rowclass = "rowA";}
				?>
				<tr class="<?php echo $rowclass; ?>">
					<!-- <td style="width:10px;"><input type='checkbox' name="chkbox" value="" id="myCheck"></td> -->
					<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
					
					<td style="width:8%;"><input type='checkbox' id="chkbox" name="chkbox" class="checkbox" 
					value="<?php echo $row['accountcode'];?>"></td>
					<td style="width:15%;"><?php echo $row['accountcode'];?></td>
					<td style="width:15%;"><?php echo $row['accountname'];?></td>
					<td style="width:15%;"><?php echo $row['UM'];?></td>
					<td style="width:16%;"><?php echo $row['value'];?></td>
					<td style="width:16%;"><?php echo $row['ExcludedValue'];?></td>
					<td style="width:16%;"><?php echo $row['PaymentDate'];?></td>
					<!--<td style="width:50%;"><input type='password' value='" . $row["password"]."'readonly='readonly'></td>-->
					
				</tr>

			<?php }

		}
	?>


<!-- end TABLE AREA -->
<script  type="text/javascript">
		var payline='';
	  	var locName='';
	  	var locUM='';
	  	var locValue='';
	  	var locExcluded='';
	  	var locDate='';
		$(document).ready(function(){
				$('#dataln tbody tr').click(function(){
					$('table tbody tr').css("color","black");
					$(this).css("color","orange");
					$('table tbody tr').removeClass("info");
					$(this).addClass("info");
					var transnumline = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(2)").text();
					locName = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(3)").text();
					locUM = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(4)").text();
					locValue = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(5)").text();
					locExcluded = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(6)").text();
					locDate = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(7)").text();
					payline = transnumline.toString();
					document.getElementById("HDincAcc").value = payline;
					//alert(document.getElementById("hide").value);
						
					flaglocation = false;
					//alert(payline);
					loc = document.getElementById("hide").value;
		            $("#myUpdateBtn").prop("disabled", false);
		             var pos = $("#"+loc+"").attr("tabindex");
					    $("tr[tabindex="+pos+"]").focus();
					    $("tr[tabindex="+pos+"]").css("color","red");
					    $("tr[tabindex="+pos+"]").addClass("info");
					//document.getElementById("myUpdateBtn").style.disabled = disabled;
						  
				});
			});

		//--------------------Exclude Checkmark-------------------------//

	function removeA(arr) 
		{
		    var what, a = arguments, L = a.length, ax;
		    while (L > 1 && arr.length) {
		        what = a[--L];
		        while ((ax= arr.indexOf(what)) !== -1) {
		            arr.splice(ax, 1);
		        }
		    }
		    return arr;
		}

		allVals = [];
		uniqueNames = [];
		remVals = [];
		remValsEx = [];
		$('[name=chkbox]').change(function(){
			//alert(2);
		    if($(this).attr('checked'))
		    {
	      		//document.getElementById("IncAccId").value = $(this).val();
	      		Add();
		    }
		    else
		    {
					         
		         //document.getElementById("IncAccId").value=$(this).val();
		         remVals.push("'"+$(this).val()+"'");
		         $('#ExAccId').val(remVals);

		         $.each(remVals, function(i, el2){

		    		removeA(allVals, el2);
		    		removeA(uniqueNames, el2);
			    	//$("input[value="+el+"]").prop("checked", true);
			    	//alert(el);
				});
		        Add();

		    }
		 });

		/*$("#selectAll").change(function(){  //"select all" change 
   			 

   			 if(false == $(this).prop("checked")){ //if this item is unchecked
			        $('[name=chkbox]').prop('checked', false); //change "select all" checked status to false
			         allVals = [];
					 uniqueNames = [];
					 remVals = [];
					 remValsEx = [];
			        document.getElementById('IncAccId').value = '';
			        document.getElementById('ExAccId').value = '';
			        //alert('sample');

			    }
			    else
			    {
			    	$(".checkbox").prop('checked', $(this).prop("checked")); //change all ".checkbox" checked status
			    	Add();
			    }

			});*/


		
		function Add() 
		{  

			//alert(1);
			$('#IncAccId').val('');
			 $('[name=chkbox]:checked').each(function() {
			   allVals.push("'"+$(this).val()+"'");
			 });

			  //remove existing rec start-----------------------
			 $('[name=chkbox]:disabled').each(function() {
			   
			   remValsEx.push("'"+$(this).val()+"'");
		         //$('#ExAccId').val(remValsEx);

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
			
			 $('#IncAccId').val(uniqueNames);
			 
		} 
		function CheckedVal()
		{ 
			$.each(uniqueNames, function(i, el){
				    $("input[value="+el+"]").prop("checked", true);
				    //alert(el);
				});
		}

		function Cancel()
		{
			//alert(so);
			//window.location.href='workerform.php';
			var action = "unload";
			$.ajax({
				type: 'GET',
				url: 'amountexemptionprocess.php',
				data:{action:action},
				success: function(data) {
				    window.location.href='payrolltransaction.php';
			    }
			});  
		}
		//--------------------Exclude Checkmark end-------------------------//
		
</script>