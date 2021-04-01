<?php

session_start();
include("dbconn.php");
$userlogin = $_SESSION["user"];
$dataareaid = $_SESSION["defaultdataareaid"];
$grpid = $_SESSION['groupid'];

if($_GET["action"]=="searchdata"){
	if($_GET["actmode"]=="userform"){
		$id=$_GET["PriveId"];
		$module=$_GET["PrivModule"];
		$sub=$_GET["PrivSub"];
		$name=$_GET["PrivName"];



		$output='';
		//$output .= '<tbody>';
		$query = "SELECT priv.privilegesid,priv.name,priv.module,priv.submodule FROM 

					 privileges priv
					 where (priv.privilegesid like '%$id%') and (priv.module like '%$module%') and (priv.submodule like '%$sub%') and (priv.name like '%$name%')
					order by priv.privilegesid,priv.module,priv.submodule";
		$result = $conn->query($query);
		$rowclass = "rowA";
		$rowcnt = 0;
		$rowcnt2 = 0;
		$lastrec ='';
		while ($row = $result->fetch_assoc())
		{
			$rowcnt++;
			$rowcnt2++;
				if($rowcnt > 1) { $rowcnt = 0; $rowclass = "rowB"; }
				else { $rowclass = "rowA";}

				$dtarea = $row['privilegesid'];

				$query2 = "SELECT * FROM usergroupsprivileges where usergroupid = '$grpid' and privilegesid = '$dtarea'";
					$result2 = $conn->query($query2);
					$row2 = $result2->fetch_assoc();
					$dtexist = $row2["privilegesid"];

					if(isset($dtexist)) { $tag=1;}
					else {$tag=0;}
			$output .= '
			<tr id="'.$row["privilegesid"].'" class="'.$rowclass.'" tabindex="'.$rowcnt2.'">
				<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
				<td style="width:5%;"><input type="checkbox" id="chkbox" name="chkbox" class="checkbox"
				 	value="'.$row['privilegesid'].'" '.($tag==1 ? 'checked' : '').' '.($tag==1 ? 'disabled' : '').'></td>
				<td style="width:25%;">'.$row["privilegesid"].'</td>
				<td style="width:25%;">'.$row["name"].'</td>
				<td style="width:25%;">'.$row["module"].'</td>
				<td style="width:25%;">'.$row["submodule"].'</td>
			</tr>';
		}
		//$output .= '</tbody>';
		echo $output;
		//header('location: process.php');
	}
}
else if($_GET["action"]=="save"){
	 
	 
	$id=$_GET["SelectedVal"];
	
	 if($id != ""){
	 $query = "SELECT * FROM privileges

					where privilegesid in ($id)";
		$result = $conn->query($query);
		while ($row = $result->fetch_assoc())
		{
			$privilegesid=$row["privilegesid"];

			$sql = "INSERT INTO usergroupsprivileges (usergroupid,privilegesid,createdby,createddatetime)
			values 
			('$grpid', '$privilegesid', '$userlogin', now())";
			if(mysqli_query($conn,$sql))
			{
				echo $sql;
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}



		}

	 }
	 
	header('location: usergroupprivilegesform.php');
	
}

?>

<script  type="text/javascript">
		var so='';
	  	var payline='';
  		var locAccName;
		var locAccUm;
		var locAccType;

  		$(document).ready(function(){
			$('#datatbl tbody tr').click(function(){
				//$('table tbody tr').css('background-color','');
				//$(this).css('background-color','#ffe6cb');
				$('table tbody tr').css("color","black");
				$(this).css("color","red");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				var usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
				var AcInc = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
				locAccName = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();
				locAccUm = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(4)").text();
				locAccType = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(5)").text();

				so = usernum.toString();
				document.getElementById("hide").value = so;				  
			});
		});

	  		/*$(document).ready(function(){
				$('#dataln tbody tr').click(function(){
					$('table tbody tr').css("color","black");
					$(this).css("color","orange");
					$('table tbody tr').removeClass("info");
					$(this).addClass("info");
					var transnumline = $("#dataln tr:eq("+ ($(this).index()+1) +") td:eq(1)").text();
					var payline = transnumline.toString();
					document.getElementById("hide2").value = payline;
					//alert(document.getElementById("hide").value);
						
						  
				});
			});*/
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
		 //remove existing rec end-------------------------

		 
			$.each(allVals, function(i, el){
			    if($.inArray(el, uniqueNames) === -1) uniqueNames.push(el);
			});
		
		 $('#inchide').val(uniqueNames);

	} 
	function CheckedVal()
	{ 
		$.each(uniqueNames, function(i, el){
			    $("input[value="+el+"]").prop("checked", true);
			    //alert(el);
			});
	}
	
</script>