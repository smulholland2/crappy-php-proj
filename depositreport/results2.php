<?php

$response = array();
$posts = array();
$ME = array();
$coursetitle = array();


// Connect to the database (host, username, password)
$user=$_SERVER['DB_USERNAME'];
$password=$_SERVER['DB_PASSWORD'];
$server=$_SERVER['DB_HOSTNAME'];
$database='newtap';
 
$con = mssql_connect($server,$user,$password) or die('Could not connect to the server!');
mssql_select_db($database, $con) or die('Could not select a database.');


$startD=$_POST['startDate'];
$startD = date('Y-m-d', strtotime($startD));
//echo "<br>";
$endD=$_POST['endDate'];
$endD = date('Y-m-d', strtotime($endD));

//echo "<br>";
$startH=$_POST['startHour'];
//echo "<br>";
$endH=$_POST['endHour'];
//echo "<br>";
$startinv=$_POST['startinv'];
//echo "<br>";
$endinv=$_POST['endinv'];
//echo "<br>";


//get purchase data
$SQL4u = " SELECT OID, AN, DO, VC, TC, PAY 
		   FROM [07O2]  
		   WHERE DO >= '$startD $startH' 
		   AND DO <= '$endD $endH' 
		   AND ONUM >= $startinv 
		   AND ONUM <= $endinv 
		   AND PAY<>'incomplete' 
		   AND PAY<>'check'
		   AND TC>0
		";
$resultset=mssql_query($SQL4u, $con); 
while ($row = mssql_fetch_array($resultset)) 
{
	$fix_repeated_totals = 1;

	$OID = $row['OID'];
	$AN = $row['AN'];
	$DO = $row['DO'];
	$DO = date('Y-m-d', strtotime($DO));
	$VC = $row['VC'];
	$TC = $row['TC'];
	$PAY = $row['PAY'];
		        
	if ($VC=="") {
		$VC="tapseries";
	}


	$SQL = "SELECT PC, PRI, NO FROM [07O4]
			WHERE OID='$OID' 
			"; 
	$resultset2=mssql_query($SQL, $con); 
	while ($row = mssql_fetch_array($resultset2)) 
	{
		
		$PC = $row['PC'];
		$PRI = $row['PRI'];
		$NO = $row['NO'];

		$fsm=0;
		$califsh=0;
		$sdfsh=0;
		$txfsh=0;
		$flfsh=0;
		$ilfsh=0;
		$mofsh=0;
		$azfsh=0;
		$fsre=0;
		$haccp=0;
		$utfsh=0;
		$ohfsh=0;
		$fse=0;
		$wvfsh=0;
		$ksfsh=0;
		$cb=0;
		$aa=0;
		$ad=0;
		$as=0;
		$emws=0;
		$sfis=0;
		$nmfsh=0;
		$fsrt=0;
		$ifl=0;
		$cf=0;
		$rewi=0;
		$vaccfsh=0;
		$tufsh=0;
		$alc=0;
		$idfsh=0;
		$remn=0;
		$akan=0;
		$oh2=0;
		$oh2rt=0;
		$reri=0;


			
		if ($PC=="fs") {
			$fsm=$PRI * $NO;
		}
		if  ($PC=="califsh") {
			if ($PRI==12.9500) {
				$sdfsh=$PRI * $NO;
			} else {
				$califsh=$PRI * $NO;
			}
		}
		if  ($PC=="casd") {
			$sdfsh=$PRI * $NO;
		}
		if  ($PC=="txfsh") {
			$txfsh=$PRI * $NO;
		}
		if  ($PC=="flfsh") {
			$flfsh=$PRI * $NO;
		}
		if  ($PC=="ilfsh") {
			$ilfsh=$PRI * $NO;
		}
		if  ($PC=="mofsh") {
			$mofsh=$PRI * $NO;
		}
		if  ($PC=="azfsh") {
			$azfsh=$PRI * $NO;
		}
		if  ($PC=="ohfsh") {
			$ohfsh=$PRI * $NO;
		}
		
		if  ($PC=="refs") {
			$fsre=$PRI * $NO;
		}
		if  ($PC=="nhaccp") {
			$haccp=$PRI * $NO;
		}
		if  ($PC=="utfsh") {
			$utfsh=$PRI * $NO;
		}
		
		if  ($PC=="nfon") {
			$fse=$PRI * $NO;
		}
		
		if  ($PC=="WVMV") {
			$wvfsh=$PRI * $NO;
		}//Mid-Ohio Valley, WV
		if  ($PC=="WVBA") {
			$wvfsh=$PRI * $NO;
		}//Barbour WV
		
		if  ($PC=="WVMN") {
			$wvfsh=$PRI * $NO;
		}//Monroe WV
		
		if  ($PC=="WVCH") {
			$wvfsh=$PRI * $NO;
		}//Cabell-Huntington WV
		
		if  ($PC=="WVPO") {
			$wvfsh=$PRI * $NO;
		}//Pocahontas WV
		
		if  ($PC=="WVUP") {
			$wvfsh=$PRI * $NO;
		}//Upshur WV
		
		if  ($PC=="WVWA") {
			$wvfsh=$PRI * $NO;
		}//Wayne WV
		
		if  ($PC=="WVPE") {
			$wvfsh=$PRI * $NO;
		}//Pendleton WV
		
		if  ($PC=="WVOH") {
			$wvfsh=$PRI * $NO;
		}//Wheeling WV

		if  ($PC=="WVRN") {
			$wvfsh=$PRI * $NO;
		}//Randolph County WV
		if  ($PC=="wvfsh") {
			$wvfsh=$PRI * $NO;
		}//WV (old)
		
		if  ($PC=="ksfsh") {
			$ksfsh=$PRI * $NO;
		}
		if  ($PC=="cb") {
			$cb=$PRI * $NO;
		}
		if  ($PC=="aa") {
			$aa=$PRI * $NO;
		}
		if  ($PC=="ad") {
			$ad=$PRI * $NO;
		}
		if  ($PC=="as") {
			$as=$PRI * $NO;
		}
		if  ($PC=="emws") {
			$emws=$PRI * $NO;
		}
		if  ($PC=="sfis") {
			$sfis=$PRI * $NO;
		}
		if  ($PC=="nmfsh") {
			$nmfsh=$PRI * $NO;
		}
		if  ($PC=="fsrt") {
			$fsrt=$PRI * $NO;
		}
		if  ($PC=="ifl") {
			$ifl=$PRI * $NO;
		}
		if  ($PC=="cf") {
			$cf=$PRI * $NO;
		}
		if  ($PC=="rewi") {
			$rewi=$PRI * $NO;
		}
		if  ($PC=="vaccfsh") {
			$vaccfsh=$PRI * $NO;
		}
		if  ($PC=="tufsh") {
			$tufsh=$PRI * $NO;
		}
		if  ($PC=="alc") {
			$alc=$PRI * $NO;
		}
		if  ($PC=="idfsh") {
			$idfsh=$PRI * $NO;
		}
		if  ($PC=="remn") {
			$remn=$PRI * $NO;
		}
		if  ($PC=="akan") {
			$akan=$PRI * $NO;
		}
		if  ($PC=="oh2") {
			$oh2=$PRI * $NO;
		}
		if  ($PC=="oh2rt") {
			$oh2rt=$PRI * $NO;
		}
		if  ($PC=="reri") {
			$reri=$PRI * $NO;
		}
						
	


	$SQL = "SELECT NCPY FROM [07O1] WHERE AN='$AN'"; 
	$resultset3=mssql_query($SQL, $con); 
	while ($row = mssql_fetch_array($resultset3)) 
	{
		$NCPY = $row['NCPY'];
	}



	//gets company name
	$SQL = "SELECT NC FROM [07SL1] WHERE VC='$VC'"; 
	$resultset4=mssql_query($SQL, $con); 
	while ($row = mssql_fetch_array($resultset4)) 
	{
		$NC = $row['NC'];
	}


	if($fix_repeated_totals == 2 || $fix_repeated_totals == 3 || $fix_repeated_totals == 4 || $fix_repeated_totals == 5 || $fix_repeated_totals == 6 || $fix_repeated_totals == 7 || $fix_repeated_totals == 8 ){
		$TC=0;
	}


$posts[] = array('Date'=> $DO,'Invoice'=> $OID,'Amount'=> (double)$TC,'VendorName'=> $VC,'CompanyName'=> $NCPY,'Payment'=> $PAY,'FSM'=> (double)$fsm,'CA'=> (double)$califsh,'CASD'=> (double)$sdfsh,'TX'=> (double)$txfsh,'FL'=> (double)$flfsh,'IL'=> (double)$ilfsh,'MO'=> (double)$mofsh,'AZ'=> (double)$azfsh,'FSRE'=> (double)$fsre,'UT'=> (double)$utfsh,'OH'=> (double)$ohfsh,'FSH'=> (double)$fse,'HACCP'=> (double)$haccp,'WVFSH'=> (double)$wvfsh,'ksfsh'=> (double)$ksfsh,'cb'=> (double)$cb,'aa'=> (double)$aa,'ad'=> (double)$ad,'as'=> (double)$as,'emws'=> (double)$emws,'sfis'=> (double)$sfis,'nmfsh'=> (double)$nmfsh,'fsrt'=> (double)$fsrt,'ifl'=> (double)$ifl,'cf'=> (double)$cf,'rewi'=> (double)$rewi,'vaccfsh'=> (double)$vaccfsh,'tufsh'=> (double)$tufsh,'alc'=> (double)$alc,'idfsh'=> (double)$idfsh,'remn'=> (double)$remn,'akan'=> (double)$akan,'oh2'=> (double)$oh2,'oh2rt'=> (double)$oh2rt,'reri'=> (double)$reri);

$fix_repeated_totals = $fix_repeated_totals +1 ;

}

}


	


	 mssql_free_result($resultset);
	 mssql_free_result($resultset2);
	 mssql_free_result($resultset3);
	 mssql_free_result($resultset4);
       	mssql_close($con); 
$response['posts'] = $posts;

$fp = fopen('results3.json', 'w');
fwrite($fp, json_encode($response));
fclose($fp);
 


header("Location: results.html");


?>
	
