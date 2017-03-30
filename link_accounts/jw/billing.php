<?php
error_reporting(0); 

$user=$_SERVER['DB_USERNAME'];
$password=$_SERVER['DB_PASSWORD'];
$server=$_SERVER['DB_HOSTNAME'];
$database='newtap';
$con = mssql_connect($server,$user,$password);
mssql_select_db($database, $con);

$OldUA = $_GET["OldUA"];
$NewUA = $_GET["NewUA"];
$month = $_GET["month"];
$day = $_GET["day"];
$year = $_GET["year"];
$UU = $_GET["UU"];
$NewPW = $_GET["NewPW"];
$truetotal = $_GET["Amount"];
$DaysExtend = $_GET["DaysExtend"];
$NewSD = $month ."/".$day ."/".$year;
$NewSD = date("m/d/Y", strtotime($NewSD));
$today = date("m/d/Y");



if($OldUA == "" or $NewUA == "" or $month == "" or $day == "" or $year == "" or $UU == "" or $NewPW == "" )
{
	echo "Please go back and fill up the form completely";
}

else{
	
		$SQL="SELECT UC, NF, NL, DA, DATE_EXPIRE FROM [01D] WHERE UA='$OldUA' AND UU='$UU' ";
		$resultset=mssql_query($SQL, $con); 
	
		while ($row = mssql_fetch_array($resultset)) 
		{
			$UC = $row['UC'];
			$NF = $row['NF'];
			$NL = $row['NL'];
			$DA = $row['DA'];
			$DATE_EXPIRE = $row['DATE_EXPIRE'];
		}

	
		//THIS IS THE CODING TO ADD 6 MONTHS TO NEW SEMESTER DATE BUT HERE WE CANT USE IT BECAUSE WE ARE NOT MODIFYING THE EXPIRATION DATE BECAUSE STUDENT DIDNT PAY 
	
		$NewExpDate=date_create($NewSD);
		date_add($NewExpDate,date_interval_create_from_date_string("$DaysExtend days"));
		$NewExpDate= date_format($NewExpDate,"m/d/Y");
	
		$SQL1="INSERT INTO JWReactivation (FN, LN, UU, OldUA, OldPW, OldSD, NewUA, NewPW, NewSD, ExpDate, NewExpDate, Amount)
		VALUES ('$NF','$NL','$UU','$OldUA','$UC','$DA','$NewUA','$NewPW','$NewSD','$DATE_EXPIRE','$NewExpDate','$truetotal')";
		$resultset1=mssql_query($SQL1, $con); 
		
		$SQL2="SELECT Id FROM JWReactivation WHERE UU='$UU' ORDER BY Id ASC";
		$resultset2=mssql_query($SQL2, $con); 
	
		while ($row = mssql_fetch_array($resultset2)) 
		{
			$invoicenum = $row['Id'];

		}
	
	
	
		echo "<div id='formwrapper' style='margin:auto;background-color:#e8f1f5;width:600px;border-radius:15px'>";	
		echo "	<form action='payreactivation.php' method='post' style='margin-top:100px'>";

		echo "<br>";
		echo "<input type='text' name='x_amount' value='$truetotal' style='display:none'>";
		echo "<input type='text'   name='x_invoice_num' value='$invoicenum' style='display:none'>";
		echo "<input type='text' name='ID' value='$invoicenum' style='display:none'>";
		echo "<p style='text-align:center'><b>Billing Information</b></p>";
		echo "<p style='text-align:center'>Billing address is the same as your credit card statements are mail to.</p>";
		echo "<table style='margin:auto'>";
		echo "  <tr>";
		echo "    <td style='text-align:right'>School Name: </td><td><input  type='text'  name='x_description'></td> ";
		echo "  </tr>";
		echo "  <tr>";
		echo "    <td style='text-align:right'>First Name on the Card: </td><td><input type='text'  name='x_first_name' value='$NF'></td> ";
		echo "  </tr>";
		echo "  <tr>";
		echo "   <td style='text-align:right'>Last Name on the Card: </td><td><input type='text'  name='x_last_name' value='$NL'></td> ";
		echo "  </tr>";
		echo "  <tr>";
		echo "    <td style='text-align:right'>Address: </td><td><input type='text'  name='x_address' ></td> ";
		echo "  </tr>";
		echo "  <tr>";
		echo "    <td style='text-align:right'>City: </td><td><input type='text'  name='x_city' ></td> ";
		echo "  </tr>";
		echo "  <tr>";
		echo "    <td style='text-align:right'>State: </td><td><input type='text'  name='x_state' ></td> ";
		echo "  </tr>";
		echo "  <tr>";
		echo "    <td style='text-align:right'>Zip Code: </td><td><input type='text'  name='x_zip' ></td> ";
		echo "  </tr>";
		echo "  <tr>";
		echo "  <td style='text-align:right'>Email where you will receive the receipt: </td><td><input type='text'  name='x_email' ></td> ";
		echo "  </tr>";
		echo "</table>";

		echo "<p style='text-align:center'><button type='submit' style='background-color:#004a91;color:white;border:none;width:100px;height:35px'>Submit</button></p>";

		echo "</form>";
		echo "<br>";
		echo "</div>";

	
}



?>
<style>
body *{
	font-family: 'Open Sans', sans-serif;	
	}
body{
	background-color:#004a91;
}	
</style>
