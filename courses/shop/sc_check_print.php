<?php
$user='k1Ng';
$password='ThE0dEN@#';
$server="172.31.32.203";
$database="newtap";
$con=odbc_connect("Driver={SQL Server Native Client 10.0};Server=$server;Database=$database;", $user, $password);

		
session_start();

$newusername = $_SESSION["newusername"] ;
$newpassword = $_SESSION["newpassword"] ;
$existingusername = $_SESSION["existingusername"] ;
$existingpassword = $_SESSION["existingpassword"] ;

if($newusername)
{
	$checkUsername = $newusername;
	$checkPassword = $newpassword;
}
else
{
	$checkUsername = $existingusername;
	$checkPassword = $existingpassword;
}


	 $realTotal = $_SESSION["realTotal"];
	 $realTotalQTY = $_SESSION["realTotalQTY"];
	 $ONUMsess = $_SESSION["ONUM"] ;
	 $TAPONUMsess = $_SESSION["TAPONUM"] ;

	 
$checkfn = $_SESSION["checkfn"];
$checkln = $_SESSION["checkln"];
$checkcn = $_SESSION["checkcn"];
$checkadd1 = $_SESSION["checkadd1"];
$checkadd2 = $_SESSION["checkadd2"];
$checkci = $_SESSION["checkci"];
$checkst = $_SESSION["checkst"];
$checkzip = $_SESSION["checkzip"];
$checkcou = $_SESSION["checkcou"];
$checkphone = $_SESSION["checkphone"];
$checkem = $_SESSION["checkem"];
	 
	 $date = date("m/d/Y");


echo "
<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Open+Sans' />
<meta name='viewport' content='width=device-width, initial-scale=1.0'>

<h3 style='text-align:center'>ORDER INFORMATION</h3>

<div id='tapinfo' style='border:1px solid black;width:390px;padding-top:10px;padding-bottom:10px'>
<span style='margin-left:10px'>TAP Series </span>
<br>
<span style='margin-left:10px'>5655 Lindero Canyon Road, Suite 501</span>
<br>
<span style='margin-left:10px'>Westlake Village, CA 91362 </span>
<br>
<span style='margin-left:10px'>(888) 826-5222</span>
</div>

<br>

		<table style='border: 1px solid black; height: 119px; width: 311px;border-radius:3px'>

<tbody>
<tr style='height: 12px;'>
<td style='color: white; font-family: sans-serif; border: 1px solid black; width: 464px; height: 12px; background-color: #0c7bab;' colspan='3'>Order number</td>
</tr>
<tr style='height: 12px;'>
<td style='font-family: sans-serif; border: 1px solid black; width: 464px; height: 12px;' colspan='3'>$ONUMsess</td>
</tr>
<tr style='height: 12px;'>
<td style='color: white; font-family: sans-serif; border: 1px solid black; width: 464px; height: 12px; background-color: #0c7bab;' colspan='3'>Order date</td>
</tr>
<tr style='height: 12px;'>
<td style='font-family: sans-serif; border: 1px solid black; width: 464px; height: 12px;' colspan='3'>$date</td>
</tr>
<tr style='height: 12px;'>
<td style='color: white; font-family: sans-serif; border: 1px solid black; width: 464px; height: 12px; background-color: #0c7bab;' colspan='3'>Billing information</td>
</tr>
<tr style='height: 62px;'>
<td style='font-family: sans-serif; border: 1px solid black; width: 464px; height: 62px;' colspan='3'>$checkfn $checkln<br>
				  $checkcn<br>
				   $checkadd1<br>				  
				   $checkadd2<br>				  
				   $checkci $checkst, $checkzip<br>
				   $checkcou<br>				   
				   $checkem<br>
				   $checkphone<br>
				   </td>
</tr>
<tr style='height: 34px;'>
<td style='color: white; font-family: sans-serif; border: 1px solid black; width: 464px; height: 34px; background-color: #0c7bab;' colspan='3'>
<p>Order details</p>
</td>
</tr>";
													
	$SQL="SELECT * FROM [07O4] WHERE OID = '$TAPONUMsess' ";
		$resultset=odbc_exec($con,$SQL); 
		while (odbc_fetch_row($resultset)) 
			{
				$OID= odbc_result($resultset, OID);
				$PC= odbc_result($resultset, PC);
				$PN= odbc_result($resultset, PN);
				$PRI= odbc_result($resultset, PRI);
				$NO= odbc_result($resultset, NO);
				//echo $OID;
				//echo $PC;
				//echo $PN;
				//echo $PRI;
				//echo $NO;
				//echo "<br>";
				$PRI = number_format($PRI,2);
	
echo "													
<tr style='height: 34px;'>												
<td style='font-family: sans-serif; border: 1px solid black; width: 345.667px; height: 34px;'>$PN</td>
<td style='font-family: sans-serif; border: 1px solid black; width: 38.3333px; height: 34px;text-align:center'>$NO</td>
<td style='font-family: sans-serif; border: 1px solid black; width: 80px; height: 34px;'><span>$</span>$PRI</td>
</tr>

	
";
	}												

echo  "
<tr style='height: 12.3333px;'>
<td style='font-family: sans-serif; border: 1px solid black; width: 345.667px; height: 12.3333px;'>&nbsp;</td>
<td style='font-family: sans-serif; border: 1px solid black; width: 38.3333px; height: 12.3333px;'>Total:</td>
<td style='font-family: sans-serif; border: 1px solid black; width: 80px; height: 12.3333px;'><span>$</span>$realTotal</td>
</tr>
</tbody>

</table>
<br>

<div id='acctinfo' style='border:1px solid black;width:400px;padding-top:10px;padding-bottom:10px'>
<span style='margin-left:10px'><span style='font-weight:bold'>Account Username:</span> $checkUsername</span>
<br>
<span style='margin-left:10px'><span style='font-weight:bold'>Account Password:</span> $checkPassword</span>
</div>


<p style='text-align:center'>**Please be sure to enclose a copy of this page with your check.**</p>


";



?>

<style>
body{
	font-family: 'Open Sans', sans-serif;  
	font-size:20px;
}
</style>

<script type="text/javascript">

window.print();

</script>


