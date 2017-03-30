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


if($x_response_code == 1 ){
	
	
	$SQL="SELECT FN, LN, UU, NewUA, OldUA, NewSD, NewPW, NewExpDate, CCfn, CCln, CCaddress, CCcity, CCstate, CCzip, CCcountry, CCemail, CCcn, Amount FROM JWReactivation WHERE Id= '$ID' ";
	$resultset=mssql_query($SQL, $con); 
	
	while ($row = mssql_fetch_array($resultset)) 
	{
		$FN = $row['FN'];
		$LN = $row['LN'];
		$UU = $row['UU'];
		$NewUA = $row['NewUA'];
		$OldUA = $row['OldUA'];
		$NewSD = $row['NewSD'];
		$NewPW = $row['NewPW'];
		$NewExpDate = $row['NewExpDate'];
		
		$CCfn = $row['CCfn'];
		$CCln = $row['CCln'];
		$CCaddress = $row['CCaddress'];
		$CCcity = $row['CCcity'];
		$CCstate = $row['CCstate'];
		$CCzip = $row['CCzip'];
		$CCcountry = $row['CCcountry'];
		$CCemail = $row['CCemail'];
		$CCcn = $row['CCcn'];
		$Amount = $row['Amount'];
	}
	

	

		$SQL2="UPDATE [01D]
		SET UA='$NewUA', DA='$NewSD', UC='$NewPW', FIN=0, DS=null, DE=null, DATE_EXPIRE='$NewExpDate'
		WHERE UU='$UU' ";		
		$resultset2=mssql_query($SQL2, $con); 	

		$SQL3="DELETE FROM [01A]
		WHERE UU='$UU' ";
		$resultset3=mssql_query($SQL3, $con);

		$SQL4="DELETE FROM [01P]
		WHERE UU='$UU' ";
		$resultset4=mssql_query($SQL4, $con);

		$SQL5="UPDATE [01S]
		SET NUM=0, Q=0, SEC=0, E=0
		WHERE UU='$UU' ";		
		$resultset5=mssql_query($SQL5, $con); 

		$SQL6="UPDATE JWReactivation
		SET Trans='completed', ChangeDate='$date'
		WHERE Id='$ID' ";		
		$resultset6=mssql_query($SQL6, $con); 

	
				//**********************  EMAIL SENDER *************************
			
		$to = $CCemail;
        $subject = "TAP Series Receipt";
         
        $message = "<p>TAP Series Receipt</p>";
        $message .= "<p>Congratulations you've been reactivated.</p>";
        $message .= "<p>Username: $UU </p>";
        $message .= "<p>Password: $NewPW </p>";
        $message .= "<p>To start the training please go to <a href='http://www.tapseries.com'>www.tapseries.com</a> and click on 'LOGIN to course' <a href='http://www.tapseries.com/onlinetraining.htm'><img src='http://www.tapseries.com/images/login11.png' width='150'></a> </p>";
        $message .= "Paid in full";
        $message .= "
		
		<table style='border: 1px solid black; height: 119px; width: 311px;'>

<tbody>
<tr style='height: 12px;'>
<td style='color: white; font-family: sans-serif; border: 1px solid black; width: 464px; height: 12px; background-color: #0c7bab;' colspan='3'>Invoice number</td>
</tr>
<tr style='height: 12px;'>
<td style='font-family: sans-serif; border: 1px solid black; width: 464px; height: 12px;' colspan='3'>$ID</td>
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
													
	
$message .= "													
<tr style='height: 34px;'>												
<td style='font-family: sans-serif; border: 1px solid black; width: 345.667px; height: 34px;'>Food Safety Manager Reactivation</td>
<td style='font-family: sans-serif; border: 1px solid black; width: 38.3333px; height: 34px;'>1</td>
<td style='font-family: sans-serif; border: 1px solid black; width: 80px; height: 34px;'><span>$</span>$Amount</td>
</tr>

	
";
											

$message .= "
<tr style='height: 12.3333px;'>
<td style='font-family: sans-serif; border: 1px solid black; width: 345.667px; height: 12.3333px;'>&nbsp;</td>
<td style='font-family: sans-serif; border: 1px solid black; width: 38.3333px; height: 12.3333px;'>Total:</td>
<td style='font-family: sans-serif; border: 1px solid black; width: 80px; height: 12.3333px;'><span>$</span>$Amount</td>
</tr>
</tbody>

</table>
		
		
		";
         
        $header = "From:techsupport@tapseries.com \r\n";
        $header .= "Cc:sk@tapseries.com \r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-type: text/html\r\n";
         
        $retval = mail ($to,$subject,$message,$header);	
		
	//*********************** EMAIL ENDS HERE
		
		
		
		
	
	
	header( "Location: reactivationdone.php?NF=$FN&NL=$LN&NewUA=$NewUA&UU=$UU&NewPW=$NewPW&NewSD=$NewSD&NewExpDate=$NewExpDate&id=$ID" ) ;
	
	
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
