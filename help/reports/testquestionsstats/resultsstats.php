<?php
	
	// Attempt connection to database.
	$user = $_SERVER['DB_USERNAME'];
	$password = $_SERVER['DB_PASSWORD'];
	$server = $_SERVER['DB_HOSTNAME'];
	$database = 'newtap';
	$con = mssql_connect($server,$user,$password) or die('Could not connect to the server!');
	mssql_select_db($database, $con) or die('Could not select a database.'); 

	// Once connection has been established, instantiate variables.	 
	$startD = $_POST['startDate'];
	$endD = $_POST['endDate'];
	$lang = $_POST['strLang'];

	// Create the array to store table data.
	$response["posts"] = [];

	/*
	 * BEGIN RESULT REPORT PROCESSING 
	 */

	// Create an OUTER JOIN on 01A and 01D by the UU field.
	$sql = "SELECT [01A].[Q] AS QNUM, [01A].[C] AS Correct FROM [01A] ";
	$sql .= "LEFT OUTER JOIN [01D] ";
	$sql .= "ON [01A].[UU] = [01D].[UU] ";
	$sql .= "WHERE ([01D].[ME]=3 OR [01D].[ME]=20 OR [01D].[ME]=21 OR [01D].[ME]=4 OR [01D].[ME]=7) AND [01D].[ES]='".$lang."' AND [01D].[DE]>='".$startD."' AND [01D].[DE]<= '".$endD."' AND [01A].NUM=11 ";

	// Run the query.
	$stmt = mssql_query($sql, $con);
	if( $stmt === false) {
		die( print_r( mssql_get_last_message(), true) );
	}

	// Store each table row in an array.
	while( $row = mssql_fetch_assoc($stmt) ) {
		$response["posts"]["Correct"] > 2 ? $response["posts"]["Correct"] = "No" : $response["posts"]["Correct"] = "Yes";
		array_push($response["posts"], $row);
	}

	// Clean up MSSQL connection.
	mssql_free_result($stmt);
	mssql_close($con); 

	// Write the table data array to a json file.
	$fp = fopen('resultsstats.json', 'w');
	fwrite($fp, json_encode($response));
	fclose($fp);

	// Clear stats session variables before setting new ones.
	session_start(); 
	unset($_SESSION["stats"]);

	// Set the session variables.
	$_SESSION["stats"] = [];
	$_SESSION["stats"]["start"] = $startD;
	$_SESSION["stats"]["end"] = $endD;
	$_SESSION["stats"]["lang"] = $lang;
	$_SESSION["stats"]["students"] = count($response["posts"]);
	header("Location:statsresults.php");	

?>
	
