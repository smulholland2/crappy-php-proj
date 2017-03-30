<?php

// Connect to the database (host, username, password)
$user='k1Ng';
$password='ThE0dEN@#';
$server="172.31.32.203";
$database="newtap";



$startDate=$_POST['startDate'];
$endDate=$_POST['endDate'];

$con=odbc_connect("Driver={SQL Server Native Client 10.0};Server=$server;Database=$database;", $user, $password);

$SQL = "SELECT * FROM ALCOHOL WHERE Date >= '$startDate'  AND Date <= '$endDate'"; 

//echo $SQL; 

$resultset=odbc_exec($con,$SQL);

echo "<table>";
	echo "<tr>";
	echo "<th>First Name</th>";
	echo "<th>Last Name</th> ";
	echo "<th>Date</th> ";
	echo "<th>Discode</th> ";
	echo "</tr>";
while ($Row = odbc_fetch_row($resultset)) {
		$FirstName= odbc_result($resultset, "FirstName");	
		$LastName= odbc_result($resultset, "LastName");	
		$Date= odbc_result($resultset, "Date");	
		$Discode= odbc_result($resultset, "Discode");	
		
		$Date = date("m/d/Y", strtotime($Date));
		
	echo "<tr>";	
	echo "<td>$FirstName</td>";
	echo "<td>$LastName</td>";
	echo "<td>$Date</td>";
	echo "<td>$Discode</td>";
	echo "</tr>";
	
	
	}
	
	echo "</table>";

	

?>

<style>
	body *{
	font-size:16px;
	}
	table{margin:auto;
	}
	
	table, th , td  {
  border: 1px solid grey;
  border-collapse: collapse;
  padding: 2px;
  max-width: 270px;
  overflow: auto;
}

table tr:nth-child(odd) {
  background-color: #E0FFFF;
}
table tr:nth-child(even) {
  background-color: #ffffff;
}


.table-hover>tbody>tr:hover>td, .table-hover>tbody>tr:hover>th {
    background-color: yellow;
}
	</style>
