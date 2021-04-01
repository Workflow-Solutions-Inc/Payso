<?php
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
			$query = "SELECT accountcode,format(amount,2) amount,paymentdate FROM excludedpayment where refpayrollid = '$AEpaynum' and workerid = '$id' and dataareaid = '$dataareaid'; ";
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
						<td style="width:8%;"><input type='checkbox' id="chkbox-inc" name="chkbox-inc" class="checkbox" 
						value="<?php echo $row['accountcode'];?>"></td>
						<td style="width:30%;"><?php echo $row['accountcode'];?></td>
						<td style="width:31%;"><?php echo $row['amount'];?></td>
						<td style="width:31%;"><?php echo $row['paymentdate'];?></td>
						<!--<td style="width:50%;"><input type='password' value='" . $row["password"]."'readonly='readonly'></td>-->
						
					</tr>

			<?php }

		}
	?>
<!-- end TABLE AREA -->
<script  type="text/javascript">
		$(document).ready(function(){
			$('#dataexln tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","green");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				var exemptedline = $("#dataexln tr:eq("+ ($(this).index()+1) +") td:eq(2)").text();
				exline = exemptedline.toString();
				document.getElementById("HDincAcc-EX").value = exline;
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

		//--------------------Include Checkmark-------------------------//

		function INCremoveA(arr) 
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

		var INCallVals = [];
		var INCuniqueNames = [];
		var INCremVals = [];
		var INCremValsEx = [];
		$('[name=chkbox-inc]').change(function(){
			
		    if($(this).attr('checked'))
		    {
	      		//document.getElementById("IncAccId").value = $(this).val();
	      		INCAdd();
		    }
		    else
		    {
					         
		         //document.getElementById("IncAccId").value=$(this).val();
		         INCremVals.push("'"+$(this).val()+"'");
		         $('#ExAccId-EX').val(INCremVals);

		         $.each(INCremVals, function(i, el2){

		    		INCremoveA(INCallVals, el2);
		    		INCremoveA(INCuniqueNames, el2);
			    	//$("input[value="+el+"]").prop("checked", true);
			    	//alert(el);
				});
		        INCAdd();

		    }
		 });

		/*$("#selectAll").change(function(){  //"select all" change 
   			 

   			 if(false == $(this).prop("checked")){ //if this item is unchecked
			        $('[name=chkbox-inc]').prop('checked', false); //change "select all" checked status to false
			         INCallVals = [];
					 INCuniqueNames = [];
					 INCremVals = [];
					 INCremValsEx = [];
			        document.getElementById('IncAccId-EX').value = '';
			        document.getElementById('ExAccId-EX').value = '';
			        //alert('sample');

			    }
			    else
			    {
			    	$(".checkbox").prop('checked', $(this).prop("checked")); //change all ".checkbox" checked status
			    	INCAdd();
			    }

			});*/


		
		function INCAdd() 
		{  

			
			$('#IncAccId-EX').val('');
			 $('[name=chkbox-inc]:checked').each(function() {
			   INCallVals.push("'"+$(this).val()+"'");
			 });

			  //remove existing rec start-----------------------
			 $('[name=chkbox-inc]:disabled').each(function() {
			   
			   INCremValsEx.push("'"+$(this).val()+"'");
		         //$('#ExAccId').val(remValsEx);

		         $.each(INCremValsEx, function(i, el2){
		         		
		    		INCremoveA(INCallVals, el2);
		    		INCremoveA(INCuniqueNames, el2);
			    	//"'"+"PCC"+"'"
				});
			   
			 });
			 //remove existing rec end-

			 
				$.each(INCallVals, function(i, el){
				    if($.inArray(el, INCuniqueNames) === -1) INCuniqueNames.push(el);
				});
			
			 $('#IncAccId-EX').val(INCuniqueNames);
			 

		} 
		function INCCheckedVal()
		{ 
			$.each(INCuniqueNames, function(i, el){
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

		
</script>