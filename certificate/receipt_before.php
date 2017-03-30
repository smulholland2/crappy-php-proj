<?php
$con = mssql_connect($_SERVER['DB_HOSTNAME'],$_SERVER['DB_USERNAME'],$_SERVER['DB_PASSWORD']);
mssql_select_db('newtap', $con);
error_reporting(0);

$ID = $_POST['ID'];
$TRANSID = $_POST['x_trans_id'];
$x_response_code = $_POST['x_response_code'];
$IDparts = explode("|", $ID);
$invoice = $IDparts[0];
$last4 = $IDparts[1];

//check if transaction was successfull
if($x_response_code == 1 ){

//update invoice after transaction was successfull
$SQL="UPDATE [anchorage_invoices]
	   SET PAY='credit', TRANSID='$TRANSID'
	   WHERE id='$invoice' ";
$resultset=mssql_query($SQL, $con);


//get invoice info to create receipt
$SQL2 = "SELECT * FROM anchorage_invoices WHERE id='$invoice' ";
$resultset2=mssql_query($SQL2, $con);
while ($row = mssql_fetch_array($resultset2)) 
{
    $FN = $row['FN'];
    $LN = $row['LN'];
    $AA1 = $row['AA1'];
    $AA2 = $row['AA2'];
    $ACI = $row['ACI'];
    $AST = $row['AST'];
    $AZ = $row['AZ'];
    $ACO = $row['ACO'];
    $AP = $row['AP'];
    $AM = $row['AM'];
    $NCPY = $row['NCPY'];
    $TOTAL = $row['TOTAL'];
    $CERT_FN = $row['CERT_FN'];
    $CERT_LN = $row['CERT_LN'];
    $CERT_EMAIL = $row['CERT_EMAIL'];
}

$date = date("m/d/Y");
$TOTAL = number_format($TOTAL,2);

//**********************  EMAIL SENDER *************************
$to = $AM;
$subject = "TAP Series Receipt";
$message = "<p>TAP Series Receipt</p>";
$message .= "Paid in full";
$message .= "<p>Credit/Debit Card: XXXX XXXX XXXX $last4</p>";
$message .= "
<table style='border: 1px solid black; height: 119px; width: 311px;'>
<tbody>
<tr style='height: 12px;'>
<td style='color: white; font-family: sans-serif; border: 1px solid black; width: 464px; height: 12px; background-color: #0c7bab;' colspan='3'>Invoice number</td>
</tr>
<tr style='height: 12px;'>
<td style='font-family: sans-serif; border: 1px solid black; width: 464px; height: 12px;' colspan='3'>$invoice</td>
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
<td style='font-family: sans-serif; border: 1px solid black; width: 464px; height: 62px;' colspan='3'>
$FN  $LN <br>
$NCPY<br>
$AA1 <br>				  
$AA2 <br>				  
$ACI $AST, $AZ<br>
$ACO<br>				   
$AM<br>
</td>
</tr>
<tr style='height: 34px;'>
<td style='color: white; font-family: sans-serif; border: 1px solid black; width: 464px; height: 34px; background-color: #0c7bab;' colspan='3'>
<p>Invoice details</p>
</td>
</tr>";										
$message .= "													
<tr style='height: 34px;'>												
<td style='font-family: sans-serif; border: 1px solid black; width: 345.667px; height: 34px;'>Anchorage, AK Food Handler Card</td>
<td style='font-family: sans-serif; border: 1px solid black; width: 38.3333px; height: 34px;'>1</td>
<td style='font-family: sans-serif; border: 1px solid black; width: 80px; height: 34px;'><span>$</span>$TOTAL</td>
</tr>
";
$message .= "
<tr style='height: 12.3333px;'>
<td style='font-family: sans-serif; border: 1px solid black; width: 345.667px; height: 12.3333px;'>&nbsp;</td>
<td style='font-family: sans-serif; border: 1px solid black; width: 38.3333px; height: 12.3333px;'>Total:</td>
<td style='font-family: sans-serif; border: 1px solid black; width: 80px; height: 12.3333px;'><span>$</span>$TOTAL</td>
</tr>
</tbody>
</table>
";
$header = "From:orders@tapseries.com \r\n";
$header .= "Cc:orders@tapseries.com \r\n";
$header .= "MIME-Version: 1.0\r\n";
$header .= "Content-type: text/html\r\n";
$retval = mail ($to,$subject,$message,$header);	
//*********************** EMAIL ENDS HERE	



//**********************  EMAIL SENDER *************************
$to = "dp@tapseries.com";
$subject = "Anchorage Reprint";
$message = "<p>Student paid the $5.00 fee to re-print the certificate.</p>";
$message .= "<p>Invoice #: $invoice</p>";
$message .= "<p>Student Name: $CERT_FN $CERT_LN</p>";
$message .= "<p>Student Email: $CERT_EMAIL</p>";
$message .= "<p>Click the following link to create the certificate <a href='http://www.tapseries.com/certificate/create_anchorage_cert.php?invoice=$invoice'>Create Certificate</a>, then send the certificate to the student.</p>";
$header = "From:orders@tapseries.com \r\n";
$header .= "Cc:orders@tapseries.com \r\n";
$header .= "Cc:mg@tapseries.com \r\n";
$header .= "MIME-Version: 1.0\r\n";
$header .= "Content-type: text/html\r\n";
$retval = mail ($to,$subject,$message,$header);	
//*********************** EMAIL ENDS HERE	


//redirect customer to our server
echo "<script>
        window.location.href = 'http://www.tapseries.com/certificate/congratulations_before.php?id=$invoice&last4=$last4';
    </script>";
    
}

// if tranasaction was declined do this
else{
    echo "<p style='text-align:center;margin-top:100px'>The transaction was declined.</p>";
	echo "<p style='text-align:center'>Confirm your billing address. Please check your information and try again.</p>";
	echo "<p style='text-align:center'><button onclick='goBack()'>Go Back</button></p>";
}

?>

<script>
function goBack() {
    window.history.back();
}
</script>