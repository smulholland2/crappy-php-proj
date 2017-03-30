<?php
error_reporting(0); 

 $user=$_SERVER['DB_USERNAME'];
 $password=$_SERVER['DB_PASSWORD'];
 $server=$_SERVER['DB_HOSTNAME'];
 $database='newtap';

$UU = $_POST["UUX"];
$course = $_POST["courseX"];
$UA = $_POST["UAX"];
$ME = $_POST["MEX"];

echo $UU;
echo "<br>";
echo $course;
echo "<br>";




$con = mssql_connect($server,$user,$password) or die('Could not connect to the server!');
mssql_select_db($database, $con) or die('Could not select a database.');

// *** THESE ARE THE TABLES WHERE THE STUDENT'S INFORMATION WILL BE DELETED

// FSM AND HANDLERS
if ($course == "FSCourses"){
	$tables = array( "01S", "01A", "01P", "01D");
}

// RE-CERTIFICATION
if($course == "FSMRC"){
	$tables = array( "02S", "02A", "02P", "02D");
}

//COOKING BASICS
if($course == "CB"){
	$tables = array( "03S", "03A01", "03A02", "03A03", "03A04", "03A05", "03A06", "03A07", "03A08", "03A09", "03A10", "03A11", "03A12", "03A13", "03A14", "03A15", "03A16", "03A17", "03A18", "03A19", "03P", "03D");	
}

// HACCP
if($course == "HACCP"){
	$tables = array( "04S","04P","04A","04D");	
}

// STRATEGIES FOR INCREASING SALES
if($course == "SFIS"){
	$tables = array("05F01","05S","05F02","05F03","05A01","05A02","05A03","05A04","05A05","05A06","05A07","05A08","05A09","05A10","05A11","05A12","05A13","05A14","05A15","05A16","05A17","05A18","05P","05F04","05F05","05F06","05F07","05F08","05F09","05F10","05F11","05F12","05F13","05F14","05F15","05F16","05F17","05F18","05F19","05F20","05F21","05F22","05F23","05F24","05F25","05F26","05F27","05F28","05F29","05F30","05F31","05F32","05F33","05F34","05F35","05F36","05F37","05F38","05F39","05F40","05F41","05D","05F42");	
}

// EARN MORE WITH SERVICE
if($course == "EMWS"){
	$tables = array( "06P","06D");	
}

// ALLERGEN AWARENESS
if($course == "AA"){
	$tables = array( "09S","09A","09P","09D");	
}

// ALLERGEN DEVELOPMENT
if($course == "AD"){
	$tables = array("10S","10A","10P","10D");	
}

// ALLERGEN SPECIALIST
if($course == "AS"){
	$tables = array("11S","11A","11P","11D");	
}



// ****** SELECTS THE COURSE WHERE THE LICENSE WILL BE ADDED
//food safety manager
if($ME == 1){
	$column = 'FSNum';	
	$tableLicense = '07DS1';
}
//illinois FH
if($ME == 20){
	$column = 'FSILHNum';	
	$tableLicense = '07DS1';
}
//jackson county FH
if($ME == 22){
	$column = 'FSMONum';
	$tableLicense = '07DS1';	
}
//california FH
if($ME == 3){
	$column = 'FSCANum';
	$tableLicense = '07DS1';	
}
//arizona FH
if($ME == 21){
	$column = 'FSAZNum';
	$tableLicense = '07DS1';	
}
//florida FH
if($ME == 17){
	$column = 'FSFLNum';
	$tableLicense = '07DS1';	
}

// texas FH ******** USES DIFFERENT $tableLicense
if($ME == 7){
	$column = 'FSTXGENNum';
	$tableLicense = '07DS1TX';
}
// idaho FH
if($ME == 5){
	$column = 'FSIDNum';
	$tableLicense = '07DS1';
}
// Norfolk VA FH
if($ME == 16){
	$column = 'FSVACCNum';
	$tableLicense = '07DS1';
}
//  tulsa FH
if($ME == 12){
	$column = 'FSTUNum';
	$tableLicense = '07DS1';
}
//  utah FH
if($ME == 19){
	$column = 'FSUTNum';
	$tableLicense = '07DS1';
}
//  wichita FH
if($ME == 18){
	$column = 'FSKSNum';
	$tableLicense = '07DS1';
}
//  fh all other states
if($ME == 2){
	$column = 'FSNONNum';
	$tableLicense = '07DS1';
}
//  retail FSM
if($ME == 23){
	$column = 'FSRTNum';
	$tableLicense = '07DS1';
}
//  ohio level one certification
if($ME == 10){
	$column = 'FSOHNum';
	$tableLicense = '07DS1';
}



//************ SPECIAL COURSES *********************
// re-certification
if($course == "FSMRC"){
	$column = 'FSRENum';	
	$tableLicense = '07DS1';
}
// cooking basics
if($course == "CB"){
	$column = 'CBNum';	
	$tableLicense = '07DS1';
}
// HACCP
if($course == "HACCP"){
	$column = 'HACCPNum';	
	$tableLicense = '07DS1';
}
// strategies for increasing sales
if($course == "SFIS"){
	$column = 'SFISNum';	
	$tableLicense = '07DS1';
}
// earn more with service
if($course == "EMWS"){
	$column = 'EMWSNum';	
	$tableLicense = '07DS1';
}
// allergen awareness
if($course == "AA"){
	$column = 'AANum';	
	$tableLicense = '07DS1';
}
// allergen development
if($course == "AD"){
	$column = 'ADNum';	
	$tableLicense = '07DS1';
}
// allergen specialist
if($course == "AS"){
	$column = 'ASNum';	
	$tableLicense = '07DS1';
}



// ******* THIS CODE DELETES THE STUDENT'S INFORMATION FROM ALL THE TABLES (DATABASE)	

	foreach ($tables as $table) {
		
		$SQL = "DELETE  
				FROM [$table]
				WHERE UU= '$UU'";
				
			
				
		$resultset=mssql_query($SQL, $con);
				
	}
	
//******** THE CODE BELOW CHECKS HOW MANY LICENSES THE ACCOUNT HAD BEFORE AND INCREASES IT BY ONE

		$SQL2 = "SELECT $column  
				FROM [$tableLicense]
				WHERE UA= '$UA'";

//				echo $SQL2;
//				echo "<br>";
				
		$resultset=mssql_query($SQL2, $con);
		
		
		while ($row = mssql_fetch_array($resultset)) 
		    {
		       echo $oldNumLicense = $row[$column];
		    }
		
	/*	
		while ($Row = odbc_fetch_row($resultset)) {
			
		$oldNumLicense= odbc_result($resultset, $column);	
//		echo "before";
//		echo $oldNumLicense;
//		echo "<br>";
		
		}
	*/	
		
		if($oldNumLicense >= 0){
			
					
		$newNumLic = $oldNumLicense +1;
//		echo "now";
//		echo $newNumLic;
//		echo "<br>";
		
		
// ******	THE CODE BELOW ADDS THE NEW NUMBER OF LICENSES TO THE ACCOUNT FROM WHERE WE DELETED THE STUDENT 		
		
		
		$SQL3 = "UPDATE [$tableLicense] 
		SET $column ='$newNumLic'
		WHERE UA='$UA' ";

 
		// Execute query:
		$resultset=mssql_query($SQL3, $con);


		
		header("Location: done.php?UA=$UA&message=NORMALmessage"); 
	
			
		}
		
		else{
			header("Location: done.php?UA=$UA&message=SUBmessage"); 
		}
		


?>

