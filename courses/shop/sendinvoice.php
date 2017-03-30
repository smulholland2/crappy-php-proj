<?php 

if(isset($_POST['email']) && strlen($_POST['email']) > 5){

$user=$_SERVER['DB_USERNAME'];
$password=$_SERVER['DB_PASSWORD'];
$server=$_SERVER['DB_HOSTNAME'];
$database='newtap';
$con = mssql_connect($server,$user,$password) or die('Could not connect to the server!');
mssql_select_db($database, $con) or die('Could not select a database.'); 


session_start();

$realTotal = $_SESSION["realTotal"];
$realTotalQTY = $_SESSION["realTotalQTY"];
$ONUMsess = $_SESSION["ONUM"];
$TAPONUMsess = $_SESSION["TAPONUM"];
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

//**********************  EMAIL SENDER *************************
$to = $_POST['email'];
$subject = "TAP Series Order Information";
$message = "<p>TAP Series Order Information</p>";
$message .= "
<table style='border: 1px solid black; height: 119px; width: 311px;'>
<tbody>
<tr style='height: 12px;'>
<td style='color: white; font-family: sans-serif; border: 1px solid black; width: 464px; height: 12px; background-color: #0c7bab;' colspan='3'>Order number</td>
</tr>
<tr style='height: 12px;'>
<td style='font-family: sans-serif; border: 1px solid black; width: 464px; height: 12px;' colspan='3'>$TAPONUMsess</td>
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
<td style='font-family: sans-serif; border: 1px solid black; width: 464px; height: 62px;' colspan='3'>
$checkfn $checkln<br>
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
$resultset=mssql_query($SQL, $con); 

while ($row = mssql_fetch_array($resultset)) 
{
    $OID = $row['OID'];
    $PC = $row['PC'];
    $PN = $row['PN'];
    $PRI = $row['PRI'];
    $NO = $row['NO'];
    $PRI = number_format($PRI,2);
	
$message .= "													
<tr style='height: 34px;'>												
<td style='font-family: sans-serif; border: 1px solid black; width: 345.667px; height: 34px;'>$PN</td>
<td style='font-family: sans-serif; border: 1px solid black; width: 38.3333px; height: 34px;text-align:center'>$NO</td>
<td style='font-family: sans-serif; border: 1px solid black; width: 80px; height: 34px;'><span>$</span>$PRI</td>
</tr>

	
";
	}												

$message .=  "
<tr style='height: 12.3333px;'>
<td style='font-family: sans-serif; border: 1px solid black; width: 345.667px; height: 12.3333px;'>&nbsp;</td>
<td style='font-family: sans-serif; border: 1px solid black; width: 38.3333px; height: 12.3333px;'>Total:</td>
<td style='font-family: sans-serif; border: 1px solid black; width: 80px; height: 12.3333px;'><span>$</span>$realTotal</td>
</tr>
</tbody>
</table>

";
$header = "From:orders@tapseries.com \r\n";
$header .= "MIME-Version: 1.0\r\n";
$header .= "Content-type: text/html\r\n";
$retval = mail ($to,$subject,$message,$header);	
//*********************** EMAIL ENDS HERE	


}
else{
     header("Location: /500.php");
}

?>