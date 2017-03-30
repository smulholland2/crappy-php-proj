<?php 
// Connect to the database (host, username, password)
$user=$_SERVER['DB_USERNAME'];
$password=$_SERVER['DB_PASSWORD'];
$server=$_SERVER['DB_HOSTNAME'];
$database='newtap';

$con = mssql_connect($server,$user,$password) or die('Could not connect to the server!');
mssql_select_db($database, $con) or die('Could not select a database.');



$invoice = $_GET["invoice"];
$total = $_GET["total"];
$email = $_GET["email"];
$date = date("m/d/Y");
$total = number_format($total,2);
//echo $email;

		//first get the AN 
	$SQL2="SELECT * FROM [07O2] WHERE ONUM ='$invoice' ";
	
		$resultset2=mssql_query($SQL2, $con); 
		
		
while ($row = mssql_fetch_array($resultset2)) 
	{
	     $AN = $row['AN'];
	}    
		

		//get the AN information ex. address etc
	$SQL3="SELECT * FROM [07O1] WHERE AN ='$AN' ";
		$resultset3=mssql_query($SQL3, $con); 
		
		while ($row = mssql_fetch_array($resultset3)) 
	{
	     $NCON = $row['NCON'];
	     $NCPY = $row['NCPY'];
	     $AA1 = $row['AA1'];
	     $AA2 = $row['AA2'];
	     $ACI = $row['ACI'];
	     $AST = $row['AST'];
	     $AZ = $row['AZ'];
	     $ACO = $row['ACO'];
	     $AP = $row['AP'];
	     $AM = $row['AM'];
	} 
		

			//**********************  EMAIL SENDER *************************
			
		$to = $email;
        $subject = "TAP Series Order Information";
         
        $message = "When your payment is received, your account will be activated and you will be notified by email.";
        $message .= "
		
		<table style='border: 1px solid black; height: 119px; width: 311px;'>
<tbody>
<tr style='height: 12px;'>
<td style='color: white; font-family: sans-serif; border: 1px solid black; width: 464px; height: 12px; background-color: #0c7bab;' colspan='3'>Order number</td>
</tr>
<tr style='height: 12px;'>
<td style='font-family: sans-serif; border: 1px solid black; width: 464px; height: 12px;' colspan='3'>$invoice</td>
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
<td style='font-family: sans-serif; border: 1px solid black; width: 464px; height: 62px;' colspan='3'>$NCON <br>
				  $NCPY<br>
				   $AA1<br>				  
				   $AA2<br>				  
				   $ACI $AST, $AZ<br>
				   $ACO<br>				   
				   $AM<br>
				   $AP<br>
				   </td>
</tr>
<tr style='height: 34px;'>
<td style='color: white; font-family: sans-serif; border: 1px solid black; width: 464px; height: 34px; background-color: #0c7bab;' colspan='3'>
<p>Order details</p>
</td>
</tr>";
													
	$SQL="SELECT * FROM [07O4] WHERE OID LIKE '%$invoice' ";
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
<td style='font-family: sans-serif; border: 1px solid black; width: 38.3333px; height: 34px;'>$NO</td>
<td style='font-family: sans-serif; border: 1px solid black; width: 80px; height: 34px;'><span>$</span>$PRI</td>
</tr>
	
";
	}												
$message .= "
<tr style='height: 12.3333px;'>
<td style='font-family: sans-serif; border: 1px solid black; width: 345.667px; height: 12.3333px;'>&nbsp;</td>
<td style='font-family: sans-serif; border: 1px solid black; width: 38.3333px; height: 12.3333px;'>Total:</td>
<td style='font-family: sans-serif; border: 1px solid black; width: 80px; height: 12.3333px;'><span>$</span>$total</td>
</tr>
</tbody>
</table>
		
		
		";
         
        $header = "From:techsupport@tapseries.com \r\n";
        $header .= "Cc:sk@tapseries.com \r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-type: text/html\r\n";
         
        $retval = mail ($to,$subject,$message,$header);	
	
//******************************************** email ends here ************************************************
echo "<p style='text-align:center;margin-top:80px'>The invoice was sent to the email you entered in the previous page.</p>";
echo "<p style='text-align:center'><button onclick='goBack()'>Go Back</button></p>";
			
		
?>

<script>
function goBack() {
    window.history.back();
}
</script>
