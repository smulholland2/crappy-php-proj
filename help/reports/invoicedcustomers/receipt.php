<?php
error_reporting(0);

$user=$_SERVER['DB_USERNAME'];
$password=$_SERVER['DB_PASSWORD'];
$server=$_SERVER['DB_HOSTNAME'];
$database='newtap';
$con = mssql_connect($server,$user,$password);
mssql_select_db($database, $con);

$x_response_code = $_POST['x_response_code'];
$ID = $_POST['ID'];

$date = date("m/d/Y");

$IDparts = explode("|", $ID);
$IDparts[0];	//acct
$IDparts[1];	//month
$IDparts[2];	//year
$IDparts[3];	//email
$IDparts[4];	//invoice number


if($x_response_code == 1 ){
	
	
	$SQL = "UPDATE Invoice2	
			SET Paid = 'yes'
			WHERE UA = '$IDparts[0]' AND Month ='$IDparts[1]' AND Year = '$IDparts[2]' ";				
	$resultset=mssql_query($SQL, $con);
	
	
	
	$SQL2 = "UPDATE Invoice2	
			SET PaidDate = '$date'
			WHERE UA = '$IDparts[0]' AND Month ='$IDparts[1]' AND Year = '$IDparts[2]' ";		
	$resultset2=mssql_query($SQL2, $con); 
	
	
	$SQL3 = "SELECT * FROM Invoice2	
			WHERE UA = '$IDparts[0]' AND Month ='$IDparts[1]' AND Year = '$IDparts[2]' ";		
	$resultset3=mssql_query($SQL3, $con); 
	
	
	while ($row = mssql_fetch_array($resultset3)) 
		{
			$Price = $row['Price'];
			$Qty = $row['Qty'];
			$Total = $row['Total'];
			$Course = $row['Course'];
		}
	

	
	$SQL4 = "SELECT SUM(Total) AS FinalTotal FROM Invoice2 
			WHERE UA = '$IDparts[0]' AND Month ='$IDparts[1]' AND Year = '$IDparts[2]' ";	
	$resultset4=mssql_query($SQL4, $con); 
	
	while ($row = mssql_fetch_array($resultset4)) 
		{
			$FinalTotal = $row['FinalTotal'];
		}
	
	//$FinalTotal= odbc_result($resultset4, "FinalTotal");
	//echo $FinalTotal;
 

	$SQL7 = "SELECT * FROM Invoice2	
			WHERE InvoiceNum = '$IDparts[4]' ";		
	$resultset7=mssql_query($SQL7, $con); 
	
	while ($row = mssql_fetch_array($resultset7)) 
		{
			$CCfn = $row['CCfn'];
			$CCln = $row['CCln'];
			$CCaddress = $row['CCaddress'];
			$CCcity = $row['CCcity'];
			$CCstate = $row['CCstate'];
			$CCzip = $row['CCzip'];
			$CCcountry = $row['CCcountry'];
			$CCemail = $row['CCemail'];
			$CCcn = $row['CCcn'];
		}
	
	//$CCfn= odbc_result($resultset7, "CCfn");
	//$CCln= odbc_result($resultset7, "CCln");
	//$CCaddress= odbc_result($resultset7, "CCaddress");
	//$CCcity= odbc_result($resultset7, "CCcity");
	//$CCstate= odbc_result($resultset7, "CCstate");
	//$CCzip= odbc_result($resultset7, "CCzip");
	//$CCcountry= odbc_result($resultset7, "CCcountry");
	//$CCemail= odbc_result($resultset7, "CCemail");
	//$CCcn= odbc_result($resultset7, "CCcn");
	
 
 
			//**********************  EMAIL SENDER *************************
			
		$to = $CCemail;
        $subject = "TAP Series Receipt";
         
        $message = "<p>TAP Series Receipt</p>";
        $message .= "Paid in full";
        $message .= "
		
		<table style='border: 1px solid black; height: 119px; width: 311px;'>

<tbody>
<tr style='height: 12px;'>
<td style='color: white; font-family: sans-serif; border: 1px solid black; width: 464px; height: 12px; background-color: #0c7bab;' colspan='3'>Invoice number</td>
</tr>
<tr style='height: 12px;'>
<td style='font-family: sans-serif; border: 1px solid black; width: 464px; height: 12px;' colspan='3'>$IDparts[4]</td>
</tr>
<tr style='height: 12px;'>
<td style='color: white; font-family: sans-serif; border: 1px solid black; width: 464px; height: 12px; background-color: #0c7bab;' colspan='3'>Paid date</td>
</tr>
<tr style='height: 12px;'>
<td style='font-family: sans-serif; border: 1px solid black; width: 464px; height: 12px;' colspan='3'>$date</td>
</tr>
<tr style='height: 12px;'>
<td style='color: white; font-family: sans-serif; border: 1px solid black; width: 464px; height: 12px; background-color: #0c7bab;' colspan='3'>Billing information</td>
</tr>
<tr style='height: 62px;'>
<td style='font-family: sans-serif; border: 1px solid black; width: 464px; height: 62px;' colspan='3'>$CCfn  $CCln <br>
				  $CCcn<br>
				   $CCaddress<br>				  
				   $CCcity $CCstate, $CCzip<br>
				    $CCcountry<br>				   
				   $CCemail<br>
				   </td>
</tr>
<tr style='height: 34px;'>
<td style='color: white; font-family: sans-serif; border: 1px solid black; width: 464px; height: 34px; background-color: #0c7bab;' colspan='3'>
<p>Invoice details</p>
</td>
</tr>";
													
$SQL5 = "SELECT * FROM Invoice2	
			WHERE UA = '$IDparts[0]' AND Month ='$IDparts[1]' AND Year = '$IDparts[2]' ";		
	$resultset5=mssql_query($SQL5, $con);
	
	
	while ($row = mssql_fetch_array($resultset5)) 
	{
	
	$Price = $row['Price'];
	$Qty = $row['Qty'];	
	$Total = $row['Total'];
	$Course = $row['Course'];	
		
		
	//$Price= odbc_result($resultset5, "Price");
	//$Qty= odbc_result($resultset5, "Qty");
	//$Total= odbc_result($resultset5, "Total");
	//$Course= odbc_result($resultset5, "Course");		

	$SQL6 = "SELECT * FROM [07DS2]	
			WHERE ProId = '$Course' ";		
	$resultset6=mssql_query($SQL6, $con);
		
		while ($row = mssql_fetch_array($resultset6)) 
		{
			$ProductName = $row['ProductName'];
		}
		
	//$ProductName= odbc_result($resultset6, "ProductName");
	
	$Pricex = number_format($Price,2);
	$FinalTotalx = number_format($FinalTotal,2);
	
$message .= "													
<tr style='height: 34px;'>												
<td style='font-family: sans-serif; border: 1px solid black; width: 345.667px; height: 34px;'>$ProductName</td>
<td style='font-family: sans-serif; border: 1px solid black; width: 38.3333px; height: 34px;'>$Qty</td>
<td style='font-family: sans-serif; border: 1px solid black; width: 80px; height: 34px;'><span>$</span>$Pricex</td>
</tr>

	
";
	}												

$message .= "
<tr style='height: 12.3333px;'>
<td style='font-family: sans-serif; border: 1px solid black; width: 345.667px; height: 12.3333px;'>&nbsp;</td>
<td style='font-family: sans-serif; border: 1px solid black; width: 38.3333px; height: 12.3333px;'>Total:</td>
<td style='font-family: sans-serif; border: 1px solid black; width: 80px; height: 12.3333px;'><span>$</span>$FinalTotalx</td>
</tr>
</tbody>

</table>
		
		
		";
         
        $header = "From:techsupport@tapseries.com \r\n";
        $header .= "Cc:sk@tapseries.com \r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-type: text/html\r\n";
         
        $retval = mail ($to,$subject,$message,$header);	
		
		
		// after we updated the table and sent the receipt the user will be redirected to this page because if they reload current page they the transaction will show as decline on database
		header( "Location: successfultrans.php" );
	
}

else{
	
	
	echo "<p style='text-align:center;margin-top:100px'>The transaction was declined.</p>";
	echo "<p style='text-align:center'>Please go to the previous page and enter the correct information.</p>";
	echo "<p style='text-align:center'><button onclick='goBack()'>Go Back</button></p>";


}


?>

<script>
function goBack() {
    window.history.back();
}
</script>



