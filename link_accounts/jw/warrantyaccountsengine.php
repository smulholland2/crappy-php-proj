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

if($OldUA == "" or $NewUA == "" or $month == "" or $day == "" or $year == "" or $UU == "" or $NewPW == "" ){
	echo "Please go back and fill up the form completely";
}

	else{
		
		$NewSD = $month ."/".$day ."/".$year;
		$NewSD = date("m/d/Y", strtotime($NewSD));
		
		$NewExpDate = strtotime(date("m/d/Y", strtotime($NewSD)) . " +6 month");
		$NewExpDate = date("m/d/Y",$NewExpDate);
					
		$today = date("m/d/Y");
						 
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


		$SQL1="INSERT INTO JWReactivation (FN, LN, UU, OldUA, OldPW, OldSD, NewUA, NewPW, NewSD, ChangeDate, ExpDate, NewExpDate, Amount, Trans)
		VALUES ('$NF','$NL','$UU','$OldUA','$UC','$DA','$NewUA','$NewPW','$NewSD','$today','$DATE_EXPIRE','$NewExpDate','0', 'completed')";
		$resultset1=mssql_query($SQL1, $con); 
		
		
		
		// updates account name, date added and password
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
		
						
		header( "Location: warrantydone.php?NF=$NF&NL=$NL&NewUA=$NewUA&UU=$UU&NewPW=$NewPW&NewSD=$NewSD&NewExpDateStr=$NewExpDate" ) ;
		
		
	}
	?>
