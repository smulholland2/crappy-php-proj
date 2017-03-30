<?php
$user=$_SERVER['DB_USERNAME'];
$password=$_SERVER['DB_PASSWORD'];
$server=$_SERVER['DB_HOSTNAME'];
$database='newtap';
$con = mssql_connect($server,$user,$password);
mssql_select_db($database, $con);

/*hello*/

$acct = $_GET["acct"];
$month = $_GET["month"];
$year = $_GET["year"];
$invoicenum = $_GET["invoicenum"];

echo $acct;
echo "<br>";
echo $month;
echo "<br>";
echo $year;
echo "<br>";


		$SQL = "DELETE FROM Invoice2
				WHERE UA='$acct' AND Month='$month' AND Year='$year' ";				

		$resultset=mssql_query($SQL, $con); 
		
		
		echo "<p style='text-align:center'>The invoice $invoicenum has been deleted</p>";
		echo "<p style='text-align:center'><a href='results.html'><button>Go Back</button></a></p>";

?>