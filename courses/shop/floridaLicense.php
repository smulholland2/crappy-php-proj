<?php
$user=$_SERVER['DB_USERNAME'];
$password=$_SERVER['DB_PASSWORD'];
$server=$_SERVER['DB_HOSTNAME'];
$database='newtap';
$con = mssql_connect($server,$user,$password) or die('Could not connect to the server!');
mssql_select_db($database, $con) or die('Could not select a database.'); 

	// catches value typed in #floridaCompany input box
	$searchTerm = $_GET['term'];

	// looks for all the values that matches with the word typed in #floridaCompany
	$SQL="SELECT * FROM floridaLicenseLookup WHERE CompanyName LIKE '%$searchTerm%'";
		$resultset=mssql_query($SQL, $con); 

			while ($row = mssql_fetch_array($resultset))  
			{
				$data[] = $row['CompanyName'];
			}

				 echo json_encode($data);
?>