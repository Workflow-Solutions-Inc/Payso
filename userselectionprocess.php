<?php
session_start();
session_regenerate_id();
$userlogin = $_SESSION["user"];
#$dataareaid = $_SESSION["defaultdataareaid"];
$grpid = $_SESSION['groupid'];
include("dbconn.php");

if($_GET["action"]=="save"){
	 
	 $id=$_GET["SelectedVal"];
	
	 if($id != ""){
	 $query = "SELECT * FROM userfile

				where userid in ($id)";
		$result = $conn->query($query);
		while ($row = $result->fetch_assoc())
		{
			$userid=$row["userid"];

			$sql = "INSERT INTO usergroupsassignment (usergroupid,userid,createdby,createddatetime)
			values 
			('$grpid', '$userid', '$userlogin', now())";
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
	 
	//header('location: userselection.php');
	
}

else if($_GET["action"]=="searchdata"){
	if($_GET["actmode"]=="userform"){
		$uno=$_GET["userno"];
		$ul=$_GET["lname"];
		$dtarea=$_GET["darea"];
		$output='';
		//$output .= '<tbody>';
		$query = "SELECT * FROM userfile where (userid like '%$uno%') and (name like '%$ul%') and (defaultdataareaid like '%$dtarea%')";
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

				$dtarea = $row['userid'];

				$query2 = "SELECT * FROM usergroupsassignment where usergroupid = '$grpid' and userid = '$dtarea'";
					$result2 = $conn->query($query2);
					$row2 = $result2->fetch_assoc();
					$dtexist = $row2["userid"];

					if(isset($dtexist)) { $tag=1;}
					else {$tag=0;}
			
			$output .= '
			<tr id="'.$row["userid"].'" class="'.$rowclass.'" tabindex="'.$rowcnt2.'" >
				<td style="width:20px;"><span class="fa fa-adjust"></span></td>
				<td style="width:5%;"><input type="checkbox" id="chkbox" name="chkbox" class="checkbox"
				 	value="'.$row['userid'].'" '.($tag==1 ? 'checked' : '').' '.($tag==1 ? 'disabled' : '').'></td>
				<td style="width:33%;">'.$row["userid"].'</td>
				<td style="width:33%;">'.$row["name"].'</td>
				<td style="width:33%;">'.$row["defaultdataareaid"].'</td>
			</tr>';
		}
		//$output .= '</tbody>';
		echo $output;
		//header('location: process.php');
	}
}

?>

<script  type="text/javascript">
	var so='';
	var locAccName;

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

			so = usernum.toString();
			document.getElementById("hide").value = so;				  
		});
	});

	//var allVals = [];
	//var uniqueNames = [];
	//var remVals = [];
	//var remValsEx = [];
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