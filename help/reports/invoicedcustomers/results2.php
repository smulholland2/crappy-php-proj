<?php
error_reporting(0); 

$response = array();
$posts = array();



$user=$_SERVER['DB_USERNAME'];
$password=$_SERVER['DB_PASSWORD'];
$server=$_SERVER['DB_HOSTNAME'];
$database='newtap';
$con = mssql_connect($server,$user,$password);
mssql_select_db($database, $con);


$startD=$_POST['startDate'];
$endD=$_POST['endDate'];
$companyT=$_POST['companyType']; //csub = corporate enrollment, sub = not corporate enrollment,  4u = purchase
$companyN=$_POST['companyNumber'];
$courseN=$_POST['courseNumber'];
$accountN=$_POST['accountName'];


//4u section
$SQL4u = "SELECT * FROM Invoice  WITH (NOLOCK) WHERE TPNumber IS NOT NULL AND TPNumber >0";
$ME = array();
$coursetitle = array();
	// Execute query:
	$resultset=mssql_query($SQL4u, $con); 

	// Fetch rows:
	while ($row = mssql_fetch_array($resultset)) 
	{
		$companyname = $row['CompanyName'];
		$contactname = $row['ContactName'];
		$link = $row['Link'];
		$userName = $row['UserName'];
		$password = $row['Password'];
		$revshare = $row['RevShare'];
		$rep = $row['REP'];
		$TPNumber = $row['TPNumber'];
		$ilfsh = $row['ilfsh'];
		$califsh = $row['califsh'];
		$sandfsh = $row['sandfsh'];
		$azfsh = $row['azfsh'];
		$mofsh = $row['mofsh'];
		$txfsh = $row['txfsh'];
		$fsm = $row['fsm'];
		$fse = $row['fse'];
		$flfsh = $row['flfsh'];
		$haccp = $row['haccp'];
		$fsre = $row['fsre'];
		

	
	if ($ilfsh==1) {
		$ME[]=20;
		$coursetitle[]="Illinois";
	}
	
	if ($califsh==1) {
		$ME[]=3;
		$coursetitle[]="California";
	}
	
	if ($sandfsh==1) {
		$ME[]=33;
		$coursetitle[]="San Diego";
	}
	
	if ($azfsh==1) {
		$ME[]=21;
		$coursetitle[]="Arizona";
	}
	
	if ($mofsh==1) {
		$ME[]=22;
		$coursetitle[]="Jackson County";
	}
	
	if ($txfsh==1) {
		$ME[]=7;
		$coursetitle[]="Texas";
	}
	
	if ($fsm==1) {
		$ME[]=1;
		$coursetitle[]="Food Manager";
	}
	
	if ($fse==1) {
		$ME[]=2;
		$coursetitle[]="Food Handler (Other States)";
	}
	
	if ($flfsh==1) {
		$ME[]=17;
		$coursetitle[]="Florida";
	}
	if ($haccp==1) {
		$ME[]=99;
		$coursetitle[]="HACCP";
	}
	if ($fsre==1) {
		$ME[]=98;
		$coursetitle[]="Re-certification";
	}
	
	foreach ($ME as $v) {
	//print ($v . "<br>");
	if ($v==3) {
	$SQL = "SELECT [01D].* FROM [07SL4], [07SL1], [07L3], [01D]  WITH (NOLOCK) WHERE [07SL4].VC=[07SL1].VC AND [07L3].PRO = [07SL4].id AND [01D].UA = [07L3].AN AND [01D].DA >= '$startD'   AND [07SL4].id=$TPNumber  AND [01D].DA <= '$endD' AND [01D].ME=$v AND [01D].REGION='CAGEN'"; 
	
	} else if ($v==33) {
	$SQL = "SELECT [01D].* FROM [07SL4], [07SL1], [07L3], [01D]  WITH (NOLOCK) WHERE [07SL4].VC=[07SL1].VC AND [07L3].PRO = [07SL4].id AND [01D].UA = [07L3].AN AND [01D].DA >= '$startD'   AND [07SL4].id=$TPNumber  AND [01D].DA <= '$endD' AND [01D].ME=3 AND [01D].REGION='CASD'"; 
	} else if ($v==99) {  //haccp
	$SQL = "SELECT [04D].* FROM [07SL4], [07SL1], [07L3], [04D]  WITH (NOLOCK) WHERE [07SL4].VC=[07SL1].VC AND [07L3].PRO = [07SL4].id AND [04D].UA = [07L3].AN AND [04D].DA >= '$startD'   AND [07SL4].id=$TPNumber  AND [04D].DA <= '$endD'"; 
	} else if ($v==98) { //recert
	$SQL = "SELECT [02D].* FROM [07SL4], [07SL1], [07L3], [02D]  WITH (NOLOCK) WHERE [07SL4].VC=[07SL1].VC AND [07L3].PRO = [07SL4].id AND [02D].UA = [07L3].AN AND [02D].DA >= '$startD'   AND [07SL4].id=$TPNumber  AND [02D].DA <= '$endD' "; 
	} else {
	$SQL = "SELECT [01D].* FROM [07SL4], [07SL1], [07L3], [01D]  WITH (NOLOCK) WHERE [07SL4].VC=[07SL1].VC AND [07L3].PRO = [07SL4].id AND [01D].UA = [07L3].AN AND [01D].DA >= '$startD'   AND [07SL4].id=$TPNumber  AND [01D].DA <= '$endD' AND [01D].ME=$v"; 
	}
	//print ($SQL . "<br>");
	// Execute query:
	$resultset2=mssql_query($SQL, $con); 

	// Fetch rows:
	while ($row = mssql_fetch_array($resultset2))  
	{
		$uu = $row['UU'];	
		//$uu= odbc_result($resultset2, "uu");
	
	if ($userName=="fssifh") {
		$userName="fssifh (link)";
	}

	if ($v==33) {
		$v=3;
	}
	$posts[] = array('StartDate'=> $startD,'EndDate'=> $endD,'StudentUserName'=> $uu,'CourseNum'=> $v,'CompanyName'=> $companyname,'ContactName'=> $contactname,'Link'=> $link,'TPUserName'=> $userName,'Password'=> $password,'RevenueShare'=> $revshare,'Rep'=> $rep,'TPNumber'=> $TPNumber,'type'=> "4u",'Data'=>1);
	

	}
	
	if (mssql_fetch_array($resultset2)==false) {
					$posts[] = array('StartDate'=> $startD,'EndDate'=> $endD,'StudentUserName'=>'no data','CourseNum'=> $v,'CompanyName'=> $companyname,'ContactName'=> $contactname,'Link'=> $link,'TPUserName'=> $userName,'Password'=> $password,'RevenueShare'=> $revshare,'Rep'=> $rep,'TPNumber'=> $TPNumber,'type'=> "4u",'Data'=>0);
				}

unset($ME);
unset($coursetitle);
	}
}
//sub section
$SQLsub = "SELECT * FROM Invoice  WHERE Corporate=0 AND TPNumber =0";
$ME = array();
$coursetitle = array();
	// Execute query:
	$resultset=mssql_query($SQLsub, $con); 

	// Fetch rows:
	while ($row = mssql_fetch_array($resultset)) 
	{
		$companyname = $row['CompanyName'];
		$contactname = $row['ContactName'];
		$link = $row['Link'];
		$userName = $row['UserName'];
		$password = $row['Password'];
		$revshare = $row['RevShare'];
		$rep = $row['REP'];
		$TPNumber = $row['TPNumber'];
		$ilfsh = $row['ilfsh'];
		$califsh = $row['califsh'];
		$sandfsh = $row['sandfsh'];
		$azfsh = $row['azfsh'];
		$mofsh = $row['mofsh'];
		$txfsh = $row['txfsh'];
		$fsm = $row['fsm'];
		$fse = $row['fse'];
		$flfsh = $row['flfsh'];
		$haccp = $row['haccp'];
		$fsre = $row['fsre'];
		
		
	//$companyname=odbc_result($resultset, "CompanyName");
	//$contactname=odbc_result($resultset, "ContactName");
	//$link=odbc_result($resultset, "Link");
	//$userName=odbc_result($resultset, "UserName");
	//$password=odbc_result($resultset, "Password");
	//$revshare=odbc_result($resultset, "revshare");
	//$rep=odbc_result($resultset, "REP");
	//$TPNumber= odbc_result($resultset, "TPNumber");
	
	//$ilfsh = odbc_result($resultset, "ilfsh");
	//$califsh = odbc_result($resultset, "califsh");
	//$sandfsh = odbc_result($resultset, "sandfsh");
	//$azfsh = odbc_result($resultset, "azfsh");
	//$mofsh = odbc_result($resultset, "mofsh");
	//$txfsh = odbc_result($resultset, "txfsh");
	//$fsm = odbc_result($resultset, "fsm");
	//$fse = odbc_result($resultset, "fse");
	//$flfsh = odbc_result($resultset, "flfsh");
	//$haccp = odbc_result($resultset, "haccp");
	//$fsre = odbc_result($resultset, "fsre");
	
	
	if ($ilfsh==1) {
		$ME[]=20;
		$coursetitle[]="Illinois";
	}
	
	if ($califsh==1) {
		$ME[]=3;
		$coursetitle[]="California";
	}
	
	if ($sandfsh==1) {
		$ME[]=3;
		$coursetitle[]="San Diego";
	}
	
	if ($azfsh==1) {
		$ME[]=21;
		$coursetitle[]="Arizona";
	}
	
	if ($mofsh==1) {
		$ME[]=22;
		$coursetitle[]="Jackson County";
	}
	
	if ($txfsh==1) {
		$ME[]=7;
		$coursetitle[]="Texas";
	}
	
	if ($fsm==1) {
		$ME[]=1;
		$coursetitle[]="Food Manager";
	}
	
	if ($fse==1) {
		$ME[]=2;
		$coursetitle[]="Food Handler (Other States)";
	}
	
	if ($flfsh==1) {
		$ME[]=17;
		$coursetitle[]="Florida";
	}
	if ($haccp==1) {
		$ME[]=99;
		$coursetitle[]="HACCP";
	}
	if ($fsre==1) {
		$ME[]=98;
		$coursetitle[]="Re-certification";
	}

	
	foreach ($ME as $v) {
	//print ($v . "<br>");

			
		
	$SQL="SELECT UU,UA,NF,NL,DA,VER,UC,UM FROM [01D] WITH (NOLOCK) WHERE UA='$userName' AND DA>='$startD' AND DA<='$endD' AND ME=$v";
	//print ($SQL . "<br>");
	// Execute query:
	$resultset2=mssql_query($SQL, $con); 
	

	// Fetch rows:
	while ($row = mssql_fetch_array($resultset2))  
	{
		$uu = $row['UU'];
		$ua = $row['UA'];
		
	//$uu= odbc_result($resultset2, "uu");
	//$ua= odbc_result($resultset2, "UA");
		
				$region="";

				if($v == 1){
							$CourseName="FSM";
						}
						elseif($v == 2){
							$CourseName="NFON";
						}
						elseif($v == 3){
							$CourseName="CAFH";
						}
						elseif($v == 5){
							$CourseName="IDFH";
						}
						elseif($v == 7){
							$CourseName="TXFH";
						}
						elseif($v == 10){
							$CourseName="OHLO";
						}
						elseif($v == 12){
							$CourseName="OKFH";
						}
						elseif($v == 13){
							$CourseName="WVFH";
						}
						elseif($v == 17){
							$CourseName="FLFH";
						}
						elseif($v == 18){
							$CourseName="KSFH";
						}
						elseif($v == 19){
							$CourseName="UTFH";
						}
						elseif($v == 20){
							$CourseName="ILFH";
						}
						elseif($v == 21){
							$CourseName="MOFH";
						}
						elseif($v == 22){
							$CourseName="AZFH";
						}
						elseif($v == 23){
							$CourseName="RETFSM";
						}
						elseif($v == 98){
							$CourseName="FSRE";
						}						
						else{
							$CourseName="NA";
						}

	$posts[] = array('StartDate'=> $startD,'EndDate'=> $endD,'StudentUserName'=> $uu,'Region'=>$region, 'Account'=>$ua,'CourseNum'=> $v,'CompanyName'=> $companyname,'ContactName'=> $contactname,'Link'=> $link,'TPUserName'=> $userName,'Password'=> $password,'RevenueShare'=> $revshare,'Rep'=> $rep,'TPNumber'=> $TPNumber,'type'=> "SUB",'Data'=>1,'CourseName'=> $CourseName);
	

	}
	
		if (mssql_fetch_array($resultset2)==false) {
					$posts[] = array('StartDate'=> $startD,'EndDate'=> $endD,'StudentUserName'=>'no data','Region'=>$region, 'Account'=>$ua,'CourseNum'=> $v,'CompanyName'=> $companyname,'ContactName'=> $contactname,'Link'=> $link,'TPUserName'=> $userName,'Password'=> $password,'RevenueShare'=> $revshare,'Rep'=> $rep,'TPNumber'=> $TPNumber,'type'=> "SUB",'Data'=>0,'CourseName'=> $CourseName);
				}

unset($ME);
unset($coursetitle);
	}
	}







//csub section

$SQLcsub = "SELECT * FROM Invoice  WHERE Corporate=1 AND TPNumber =0";
$ME = array();
$coursetitle = array();
	// Execute query:
	$resultset=mssql_query($SQLcsub, $con); 

	// Fetch rows:
	while ($row = mssql_fetch_array($resultset))
	{
		$companyname = $row['CompanyName'];
		$contactname = $row['ContactName'];
		$link = $row['Link'];
		$userName = $row['UserName'];
		$password = $row['Password'];
		$revshare = $row['RevShare'];
		$rep = $row['REP'];
		$TPNumber = $row['TPNumber'];
		$ilfsh = $row['ilfsh'];
		$califsh = $row['califsh'];
		$sandfsh = $row['sandfsh'];
		$azfsh = $row['azfsh'];
		$mofsh = $row['mofsh'];
		$txfsh = $row['txfsh'];
		$fsm = $row['fsm'];
		$fse = $row['fse'];
		$flfsh = $row['flfsh'];
		$haccp = $row['haccp'];
		$fsre = $row['fsre'];
		$aa = $row['aa'];
		

	
	
	if ($ilfsh==1) {
		$ME[]=20;
		$coursetitle[]="Illinois";
		
	}
	
	if ($califsh==1) {
		$ME[]=3;
		$coursetitle[]="California";
		
	}
	
	if ($sandfsh==1) {
		$ME[]=97;
		$coursetitle[]="San Diego";
	}
	
	if ($azfsh==1) {
		$ME[]=21;
		$coursetitle[]="Arizona";
	}
	
	if ($mofsh==1) {
		$ME[]=22;
		$coursetitle[]="Jackson County";
	}
	
	if ($txfsh==1) {
		$ME[]=7;
		$coursetitle[]="Texas";
	}
	
	if ($fsm==1) {
		$ME[]=1;
		$coursetitle[]="Food Manager";
	}
	
	if ($fse==1) {
		$ME[]=2;
		$coursetitle[]="Food Handler (Other States)";
	}
	
	if ($flfsh==1) {
		$ME[]=17;
		$coursetitle[]="Florida";
	}
		if ($haccp==1) {
		$ME[]=99;
		$coursetitle[]="HACCP";
	}
	if ($fsre==1) {
		$ME[]=98;
		$coursetitle[]="Re-certification";
	}
	if ($idfsh==1) {
		$ME[]=5;
		$coursetitle[]="Idaho";
	}
	if ($ksfsh==1) {
		$ME[]=18;
		$coursetitle[]="Kansas";
	}
	if ($utfsh==1) {
		$ME[]=19;
		$coursetitle[]="Utah";
	}
	if ($ohfsh==1) {
		$ME[]=10;
		$coursetitle[]="Ohio";
	}
	if ($okfsh==1) {
		$ME[]=12;
		$coursetitle[]="Tulsa";
	}
	if ($wvfsh==1) {
		$ME[]=80;
		$coursetitle[]="WV Other Jurisdictions";
	}
	if ($wvfsh==1) {
		$ME[]=81;
		$coursetitle[]="WV Cabell-Huntington County";
	
		$ME[]=82;
		$coursetitle[]="WV Monroe County";
	
		$ME[]=83;
		$coursetitle[]="WV Pendleton County";
	
		$ME[]=84;
		$coursetitle[]="WV Pocahontas County";
	
		$ME[]=85;
		$coursetitle[]="WV Upshur County";
	
		$ME[]=86;
		$coursetitle[]="WV Wayne County";
	
		$ME[]=87;
		$coursetitle[]="WV Barbour County";
	
		$ME[]=88;
		$coursetitle[]="WV Wheeling-Ohio County";
	}
	
	
	
	foreach ($ME as $v) {
		  $SQL="SELECT * FROM [07L2] WHERE SUB='$userName'";  //an value goes here
		
		// Execute query:
		$resultset2=mssql_query($SQL, $con);
		
		while ($row = mssql_fetch_array($resultset2))
		{
			 $id = $row['id'];
			 $cregion = $row['UU'];


			$SQL2="SELECT [07L3].AN,NCPY FROM [07L3],[07O6] WHERE CA=$id AND [07L3].AN=[07O6].AN";
			$resultset3=mssql_query($SQL2, $con); 

			while ($row = mssql_fetch_array($resultset3)) 
			{
				$an = $row['AN'];
				

				if ($v==99) { //haccp
					$SQL3="SELECT * FROM [04D] WHERE UA='$an' AND DA>='$startD' AND DA<='$endD'"; 
				} else if ($v==98) { //recert
					$SQL3="SELECT * FROM [02D] WHERE UA='$an' AND DA>='$startD' AND DA<='$endD'"; 
				} else if ($v==97) { //San Diego
					$SQL3="SELECT UU,UA, NF,NL,DA,VER,UC,UM FROM [01D] WHERE UA='$an' AND DA>='$startD' AND DA<='$endD' AND ME=3 and Region='CASD'"; 
					} else if ($v==80) { //WV other jurisdictions
					$SQL3="SELECT UU,UA, NF,NL,DA,VER,UC,UM FROM [01D] WHERE UA='$an' AND DA>='$startD' AND DA<='$endD' AND ME=13 and Region='WVMV'"; 
					} else if ($v==81) { //WV Cabell-Huntington County
					$SQL3="SELECT UU,UA, NF,NL,DA,VER,UC,UM FROM [01D] WHERE UA='$an' AND DA>='$startD' AND DA<='$endD' AND ME=13 and Region='WVCH'"; 
					} else if ($v==82) { //WV Monroe County
					$SQL3="SELECT UU,UA, NF,NL,DA,VER,UC,UM FROM [01D] WHERE UA='$an' AND DA>='$startD' AND DA<='$endD' AND ME=13 and Region='WVMN'"; 
					} else if ($v==83) { //WV Pendleton County
					$SQL3="SELECT UU,UA, NF,NL,DA,VER,UC,UM FROM [01D] WHERE UA='$an' AND DA>='$startD' AND DA<='$endD' AND ME=13 and Region='WVPE'"; 
					} else if ($v==84) { //WV Pocahontas County
					$SQL3="SELECT UU,UA, NF,NL,DA,VER,UC,UM FROM [01D] WHERE UA='$an' AND DA>='$startD' AND DA<='$endD' AND ME=13 and Region='WVPO'"; 
					} else if ($v==85) { //WV Upshur County
					$SQL3="SELECT UU,UA, NF,NL,DA,VER,UC,UM FROM [01D] WHERE UA='$an' AND DA>='$startD' AND DA<='$endD' AND ME=13 and Region='WVUP'"; 
					} else if ($v==86) { //WV Wayne County
					$SQL3="SELECT UU,UA, NF,NL,DA,VER,UC,UM FROM [01D] WHERE UA='$an' AND DA>='$startD' AND DA<='$endD' AND ME=13 and Region='WVWA'"; 
					} else if ($v==87) { //WV Barbour County
					$SQL3="SELECT UU,UA, NF,NL,DA,VER,UC,UM FROM [01D] WHERE UA='$an' AND DA>='$startD' AND DA<='$endD' AND ME=13 and Region='WVBA'"; 
					} else if ($v==88) { //WV Wheeling-Ohio County
					$SQL3="SELECT UU,UA, NF,NL,DA,VER,UC,UM FROM [01D] WHERE UA='$an' AND DA>='$startD' AND DA<='$endD' AND ME=13 and Region='WVOH'"; 
				} else {
				$SQL3="SELECT UU,UA, NF,NL,DA,VER,UC,UM FROM [01D] WHERE UA='$an' AND DA>='$startD' AND DA<='$endD' AND ME=$v";
				//course number, california, illinois...
				}
				$resultset4=mssql_query($SQL3, $con); 
				
				while ($row = mssql_fetch_array($resultset4)) 
				{
					
					$uu = $row['UU'];
					$ua = $row['UA'];
					$region = $row['REGION'];

					
					
						if ($userName=="fssifh") {
							$userName="fssifh (corp)";
						}
						
						
						if ($userName=="krys" && $v==2) {
							$userName="krys (AOS)";
						}
						if ($userName=="krys" && $v==98) {
							$userName="krys (RECERT)";
						}
						
						
					
						
						
						
						if ($userName=="abpcorp" && $v==1) {
							$userName="abpcorp (FSM)";
						}if ($userName=="abpcorp" && $v==98) {
							$userName="abpcorp (RECERT)";
						}if ($userName=="abpcorp" && $v==2) {
							$userName="abpcorp (ALL OTHER)";
						}if ($userName=="abpcorp" && $v==99) {
							$userName="abpcorp (HACCP)";
						}
						
						
						//TCOA all courses
						if ($userName=="tcoa" && $v==3 && $region=="CAGEN") {
							$userName="tcoa (CA)";														
						}	
						if ($userName=="tcoa" && $v==97 && $region=="CASD") {
							$userName="tcoa (CASD)";
						}								
						if ($userName=="tcoa" && $v==20) {
							$userName="tcoa (IL)";
						}
						if ($userName=="tcoa" && $v==1) {
							$userName="tcoa (FSM)";
						}
						if ($userName=="tcoa" && $v==2) {
							$userName="tcoa (ALL)";
						}
						if ($userName=="tcoa" && $v==22) {
							$userName="tcoa (FHJCMO)";
						}
						if ($userName=="tcoa" && $v==17) {
							$userName="tcoa (FHFL)";
						}
						if ($userName=="tcoa" && $v==21) {
							$userName="tcoa (FHAZ)";
						}
						if ($userName=="tcoa" && $v==7) {
							$userName="tcoa (FHTX)";
						}
						if ($userName=="tcoa" && $v==98) {
							$userName="tcoa (RECERT)";
						}
						if ($userName=="tcoa" && $v==99) {
							$userName="tcoa (HACCP)";
						}
						if ($userName=="tcoa" && $v==5) {
							$userName="tcoa (FHID)";
						}
						if ($userName=="tcoa" && $v==18) {
							$userName="tcoa (FHKS)";
						}
						if ($userName=="tcoa" && $v==19) {
							$userName="tcoa (FHUT)";
						}
						if ($userName=="tcoa" && $v==10) {
							$userName="tcoa (FHOH)";
						}
						if ($userName=="tcoa" && $v==12) {
							$userName="tcoa (FHOK)";
						}
						if ($userName=="tcoa" && $v==80) {
							$userName="tcoa (WVOTHER)";
						}
						if ($userName=="tcoa" && $v==81) {
							$userName="tcoa (WVCabell)";
						}
						if ($userName=="tcoa" && $v==82) {
							$userName="tcoa (WVMONROE)";
						}
						if ($userName=="tcoa" && $v==83) {
							$userName="tcoa (WVPENDLETON)";
						}
						if ($userName=="tcoa" && $v==84) {
							$userName="tcoa (WVPOCAHONTAS)";
						}
						if ($userName=="tcoa" && $v==85) {
							$userName="tcoa (WVUPSHUR)";
						}
						if ($userName=="tcoa" && $v==86) {
							$userName="tcoa (WVWAYNE)";
						}
						if ($userName=="tcoa" && $v==87) {
							$userName="tcoa (WVBARBOUR)";
						}
						if ($userName=="tcoa" && $v==88) {
							$userName="tcoa (WVWHEELING)";
						}
						
						if($v == 1){
							$CourseName="FSM";
						}
						elseif($v == 2){
							$CourseName="NFON";
						}
							
						elseif ($v==97) {
							$CourseName="SDFH";
						}	
						elseif ( $v==3 ) {
							$CourseName="CAFH";														
						}
						
						elseif($v == 5){
							$CourseName="IDFH";
						}
						elseif($v == 7){
							$CourseName="TXFH";
						}
						elseif($v == 10){
							$CourseName="OHLO";
						}
						elseif($v == 12){
							$CourseName="OKFH";
						}
						elseif($v == 13){
							$CourseName="WVFH";
						}
						elseif($v == 17){
							$CourseName="FLFH";
						}
						elseif($v == 18){
							$CourseName="KSFH";
						}
						elseif($v == 19){
							$CourseName="UTFH";
						}
						elseif($v == 20){
							$CourseName="ILFH";
						}
						elseif($v == 21){
							$CourseName="MOFH";
						}
						elseif($v == 22){
							$CourseName="AZFH";
						}
						elseif($v == 23){
							$CourseName="RETFSM";
						}
						elseif($v == 98){
							$CourseName="FSRE";
						}						
						else{
							$CourseName="NA";
						}
						
					 $posts[] = array('StartDate'=> $startD,'EndDate'=> $endD,'StudentUserName'=>$uu,'Region'=>$cregion, 'Account'=>$ua,'CourseNum'=> $v,'CompanyName'=> $companyname,'ContactName'=> $contactname,'Link'=> $link,'TPUserName'=> $userName,'Password'=> $password,'RevenueShare'=> $revshare,'Rep'=> $rep,'TPNumber'=> $TPNumber,'type'=> "CSUB",'Data'=>1,'CourseName'=> $CourseName);
				}
				
			}
			if (mssql_fetch_array($resultset4)==false) {
					$posts[] = array('StartDate'=> $startD,'EndDate'=> $endD,'StudentUserName'=>'no data','Region'=>$cregion, 'Account'=>$ua,'CourseNum'=> $v,'CompanyName'=> $companyname,'ContactName'=> $contactname,'Link'=> $link,'TPUserName'=> $userName,'Password'=> $password,'RevenueShare'=> $revshare,'Rep'=> $rep,'TPNumber'=> $TPNumber,'type'=> "CSUB",'Data'=>0,'CourseName'=> $CourseName);
				}
		}
	

	
	
	}
unset($ME);
unset($coursetitle);
	
	}


	mssql_free_result($resultset);
	mssql_free_result($resultset2);
	mssql_close($con); 
$response['posts'] = $posts;

$fp = fopen('results3.json', 'w');
fwrite($fp, json_encode($response));
fclose($fp);
 


header('Location: results.html');


?>
	
