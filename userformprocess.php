<?php
session_id("payso");
session_start();
$userlogin = $_SESSION["user"];
#$dataareaid = $_SESSION["defaultdataareaid"];
include("dbconn.php");

if(isset($_GET["save"])) {
	 
	 $uno=$_GET["userno"];
	 $upass=$_GET["pass"];
	 $ul=$_GET["lname"];
	 $dtarea=$_GET["darea"];
	 
	 if($uno != ""){
	 $sql = "INSERT INTO userfile (userid,name,defaultdataareaid,password,createdby,createddatetime)
			values 
			('$uno', '$ul', '$dtarea', aes_encrypt('$upass','password'), '$userlogin', now())";
		if(mysqli_query($conn,$sql))
		{
			echo "New Rec Created";
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}

	 }
	 
header('location: userform.php');
	
}
else if(isset($_GET["update"])) {
	 
	 $uno=$_GET["userno"];
	 $upass=$_GET["pass"];
	 $ul=$_GET["lname"];
	 $dtarea=$_GET["darea"];
	 
	 if($uno != ""){
	 $sql = "UPDATE userfile SET
				userid = '$uno',
				name = '$ul',
				defaultdataareaid = '$dtarea',
				modifiedby = '$userlogin',
				modifieddatetime = now()
				WHERE userid = '$uno'";
		if(mysqli_query($conn,$sql))
		{
			echo "Rec Updated";
		}
		else
		{
			echo "error".$sql."<br>".$conn->error;
		}

	 }
	
	header('location: userform.php');
	
}
else if($_GET["action"]=="delete"){
	 
	if($_GET["actmode"]=="userform"){	
		$uno=$_GET["userno"];

		if($uno != ""){
			$sql = "DELETE from userfile where userid = '$uno'";
			if(mysqli_query($conn,$sql))
			{
				echo "Rec Deleted";
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}

		}
		header('location: userform.php');
	
	}
	if($_GET["actmode"]=="company"){	
		$dt=$_GET["locDataarea"];
		$uno=$_GET["userno"];

		if($uno != ""){
			$sql = "DELETE from userfiledataarea where userid = '$uno' and dataareaid = '$dt'";
			if(mysqli_query($conn,$sql))
			{
				echo "Rec Deleted";
			}
			else
			{
				echo "error".$sql."<br>".$conn->error;
			}

		}
		header('location: userform.php');
	
	}
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
			
			$output .= '
			<tr id="'.$row["userid"].'" class="'.$rowclass.'" tabindex="'.$rowcnt2.'" >
				<td style="width:20px;" class="text-center"><span class="fa fa-angle-right"></span></td>
				<td style="width:25%;">'.$row["userid"].'</td>
				<td style="width:25%;">'.$row["name"].'</td>
				<td style="width:25%;">'.$row["defaultdataareaid"].'</td>
				<td style="width:25%;">'.$row["password"].'</td>
			</tr>';
		}
		//$output .= '</tbody>';
		echo $output;
		//header('location: process.php');
		$result2 = $conn->query($query);
		$row2 = $result2->fetch_assoc();
		$firstresult2 = $row2["userid"];
		echo $output2 = '<tr class="rowA">
							<td hidden><input type="input" id="hide3" value="'.$firstresult2.'"></td>
						</tr>';
	}
}
else if($_GET["action"]=="dtarea"){
	 	
	$id=$_GET["UsrId"];
	$_SESSION['UsrNum'] = $id;
	//unset($_SESSION['paynum']);
	header('location: userform.php');
	
}
else if($_GET["action"]=="unload"){
	 	
	unset($_SESSION['UsrNum']);
	//unset($_SESSION['paynum']);
	header('location: userform.php');
	
}
?>

<script  type="text/javascript">
		var so='';
		var locUPass = '';
		var locNM = '';
		var locDT = '';
		var usernum = '';
		if(usernum == '')
		{
			so = document.getElementById("hide").value;
		}
  		$(document).ready(function(){
			$('#datatbl tbody tr').click(function(){
				$('table tbody tr').css("color","black");
				$(this).css("color","red");
				$('table tbody tr').removeClass("info");
				$(this).addClass("info");
				usernum = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(1)").text();
				locNM = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(2)").text();
				locDT = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(3)").text();
				locUPass = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(4)").text();
				//locIndex = $("#datatbl tr:eq("+ ($(this).index()+2) +") td:eq(5)").text();
				so = usernum.toString();
				document.getElementById("hide").value = so;
				//document.getElementById("hidefocus").value = locIndex.toString();
				//alert(document.getElementById("hide").value);
				//alert(so);

				//-----------get line--------------//
				var action = "getline";
				var actionmode = "userform";
				$.ajax({
					type: 'POST',
					url: 'userformline.php',
					data:{action:action, actmode:actionmode, userId:so},
					beforeSend:function(){
					
						$("#lineresult").html('<center><img src="img/loading.gif" width="300" height="300"></center>');
					},
					success: function(data){
						//payline='';
						document.getElementById("hide2").value = "";
						$('#lineresult').html(data);
					}
				}); 
				//-----------get line--------------//
				flaglocation = true;
				//alert(flaglocation);
		        $("#myUpdateBtn").prop("disabled", false);	
					  
			});
		});

</script>