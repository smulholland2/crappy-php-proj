


	<?php


/*
** Connect to database:
*/
 
$response = array();
$posts = array();



// Connect to the database (host, username, password)
$user='k1Ng';
$password='ThE0dEN@#';
$server="172.31.32.203";
$database="newtap";



$startD=$_POST['startDate'];
$endD=$_POST['endDate'];
$companyT=$_POST['companyType']; //csub = corporate enrollment, sub = not corporate enrollment,  4u = purchase
$companyN=$_POST['companyNumber'];
$courseN=$_POST['courseNumber'];
$accountN=$_POST['accountName'];



//echo $_POST["startDate"];
//echo $_POST["endDate"];
//echo $_POST["companyType"];
//echo $_POST["companyNumber"];
//echo $_POST["courseNumber"];
//echo $_POST["accountName"];



$con=odbc_connect("Driver={SQL Server Native Client 10.0};Server=$server;Database=$database;", $user, $password);

//4u section
$SQL4u = "SELECT * FROM RevShareNew  WITH (NOLOCK) WHERE TPNumber IS NOT NULL AND TPNumber >0";
$ME = array();
$coursetitle = array();
	// Execute query:
	$resultset=odbc_exec($con,$SQL4u); 

	// Fetch rows:
	while (odbc_fetch_row($resultset)) {
	$companyname=odbc_result($resultset, "CompanyName");
	$contactname=odbc_result($resultset, "ContactName");
	$PayTo=odbc_result($resultset, "PayTo");
	//print ($companyname . "<br>");
	$link=odbc_result($resultset, "Link");
	$userName=odbc_result($resultset, "UserName");
	$password=odbc_result($resultset, "Password");
	$revshare=odbc_result($resultset, "revshare");
	$rep=odbc_result($resultset, "REP");
	$TPNumber= odbc_result($resultset, "TPNumber");
	
	//print(odbc_result($resultset, "Link"));
	$ilfsh = odbc_result($resultset, "ilfsh");
	$califsh = odbc_result($resultset, "califsh");
	$sandfsh = odbc_result($resultset, "sandfsh");
	$azfsh = odbc_result($resultset, "azfsh");
	$mofsh = odbc_result($resultset, "mofsh");
	$txfsh = odbc_result($resultset, "txfsh");
	$fsm = odbc_result($resultset, "fsm");
	$fse = odbc_result($resultset, "fse");
	$flfsh = odbc_result($resultset, "flfsh");
	$haccp = odbc_result($resultset, "haccp");
	$fsre = odbc_result($resultset, "fsre");
	$aa = odbc_result($resultset, "aa");
	
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
	if ($aa==1) {
		$ME[]=97;
		$coursetitle[]="Allergen Awareness";
	}
	
	foreach ($ME as $v) {
	//print ($v . "<br>");
	if ($v==3) {
	$SQL = "SELECT [01D].* FROM [07SL4], [07SL1], [07L3], [01D]  WITH (NOLOCK) WHERE [07SL4].VC=[07SL1].VC AND [07L3].PRO = [07SL4].id AND [01D].UA = [07L3].AN AND [01D].DA >= '$startD'   AND [07SL4].id=$TPNumber  AND [01D].DA <= '$endD' AND [01D].ME=$v AND [01D].REGION='CAGEN' AND [07L3].AN <> 'fidelity'"; 
	
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
	$resultset2=odbc_exec($con,$SQL); 

	// Fetch rows:
	while ($Row = odbc_fetch_row($resultset2)) {
	$uu= odbc_result($resultset2, "uu");
	
	if ($userName=="fssifh") {
		$userName="fssifh (link)";
	}

	if ($v==33) {
		$v=3;
	}
	$posts[] = array('StartDate'=> $startD,'EndDate'=> $endD,'StudentUserName'=> $uu,'CourseNum'=> $v,'CompanyName'=> $companyname,'ContactName'=> $contactname,'PayTo'=> $PayTo,'Link'=> $link,'TPUserName'=> $userName,'Password'=> $password,'RevenueShare'=> $revshare,'Rep'=> $rep,'TPNumber'=> $TPNumber,'type'=> "4u",'Data'=>1);
	}
	
	if (odbc_fetch_row($resultset2)==false) {
					$posts[] = array('StartDate'=> $startD,'EndDate'=> $endD,'StudentUserName'=>'no data','CourseNum'=> $v,'CompanyName'=> $companyname,'ContactName'=> $contactname,'PayTo'=> $PayTo,'Link'=> $link,'TPUserName'=> $userName,'Password'=> $password,'RevenueShare'=> $revshare,'Rep'=> $rep,'TPNumber'=> $TPNumber,'type'=> "4u",'Data'=>0);
	}

unset($ME);
unset($coursetitle);
	}
}
//sub section
$SQLsub = "SELECT * FROM RevShareNew  WITH (NOLOCK) WHERE Corporate=0 AND TPNumber =0";
$ME = array();
$coursetitle = array();
	// Execute query:
	$resultset=odbc_exec($con,$SQLsub); 

	// Fetch rows:
	while (odbc_fetch_row($resultset)) {
	$companyname=odbc_result($resultset, "CompanyName");
	$contactname=odbc_result($resultset, "ContactName");
	$PayTo=odbc_result($resultset, "PayTo");
	//print ($companyname . "<br>");
	$link=odbc_result($resultset, "Link");
	$userName=odbc_result($resultset, "UserName");
	$password=odbc_result($resultset, "Password");
	$revshare=odbc_result($resultset, "revshare");
	$rep=odbc_result($resultset, "REP");
	$TPNumber= odbc_result($resultset, "TPNumber");
	
	//print(odbc_result($resultset, "Link"));
	$ilfsh = odbc_result($resultset, "ilfsh");
	$califsh = odbc_result($resultset, "califsh");
	$sandfsh = odbc_result($resultset, "sandfsh");
	$azfsh = odbc_result($resultset, "azfsh");
	$mofsh = odbc_result($resultset, "mofsh");
	$txfsh = odbc_result($resultset, "txfsh");
	$fsm = odbc_result($resultset, "fsm");
	$fse = odbc_result($resultset, "fse");
	$flfsh = odbc_result($resultset, "flfsh");
	$haccp = odbc_result($resultset, "haccp");
	$aa = odbc_result($resultset, "aa");
	
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
	if ($aa==1) {
		$ME[]=97;
		$coursetitle[]="Allergen Awareness";
	}
	
	
	foreach ($ME as $v) {
	//print ($v . "<br>");

	
	if($haccp==1) {
		
		$SQL="SELECT * FROM [04D]  WHERE UA='$userName' AND DA>='$startD' AND DA<='$endD' ";
			$resultset2=odbc_exec($con,$SQL); 
		
	}
	elseif ($aa==1) {
		$SQL="SELECT * FROM [09D]  WHERE UA='$userName' AND DA>='$startD' AND DA<='$endD' ";
			$resultset2=odbc_exec($con,$SQL);
		
	}
	
	
	else{
	$SQL="SELECT UU,NF,NL,DA,VER,UC,UM FROM [01D] WITH (NOLOCK) WHERE UA='$userName' AND DA>='$startD' AND DA<='$endD' AND ME=$v";
	//print ($SQL . "<br>");
	// Execute query:
	$resultset2=odbc_exec($con,$SQL); 
	}
			
	// Fetch rows:
	while ($Row = odbc_fetch_row($resultset2)) {
	$uu= odbc_result($resultset2, "uu");

	$posts[] = array('StartDate'=> $startD,'EndDate'=> $endD,'StudentUserName'=> $uu,'CourseNum'=> $v,'CompanyName'=> $companyname,'ContactName'=> $contactname,'PayTo'=> $PayTo,'Link'=> $link,'TPUserName'=> $userName,'Password'=> $password,'RevenueShare'=> $revshare,'Rep'=> $rep,'TPNumber'=> $TPNumber,'type'=> "SUB",'Data'=>1);
	}
	if (odbc_fetch_row($resultset2)==false) {
					$posts[] = array('StartDate'=> $startD,'EndDate'=> $endD,'StudentUserName'=>'no data','CourseNum'=> $v,'CompanyName'=> $companyname,'ContactName'=> $contactname,'PayTo'=> $PayTo,'Link'=> $link,'TPUserName'=> $userName,'Password'=> $password,'RevenueShare'=> $revshare,'Rep'=> $rep,'TPNumber'=> $TPNumber,'type'=> "SUB",'Data'=>0);
	}

unset($ME);
unset($coursetitle);
	}
	}
//csub section

$SQLcsub = "SELECT * FROM RevShareNew  WITH (NOLOCK) WHERE Corporate=1 AND TPNumber =0";
$ME = array();
$coursetitle = array();
	// Execute query:
	$resultset=odbc_exec($con,$SQLcsub); 

	// Fetch rows:
	while (odbc_fetch_row($resultset)) {
	$companyname=odbc_result($resultset, "CompanyName");
	$contactname=odbc_result($resultset, "ContactName");
	$PayTo=odbc_result($resultset, "PayTo");
	//print ($companyname . "<br>");
	$link=odbc_result($resultset, "Link");
	$userName=odbc_result($resultset, "UserName");
	$password=odbc_result($resultset, "Password");
	$revshare=odbc_result($resultset, "revshare");
	$rep=odbc_result($resultset, "REP");
	$TPNumber= odbc_result($resultset, "TPNumber");
	
	//print(odbc_result($resultset, "Link"));
	$ilfsh = odbc_result($resultset, "ilfsh");
	$califsh = odbc_result($resultset, "califsh");
	$sandfsh = odbc_result($resultset, "sandfsh");
	$azfsh = odbc_result($resultset, "azfsh");
	$mofsh = odbc_result($resultset, "mofsh");
	$txfsh = odbc_result($resultset, "txfsh");
	$fsm = odbc_result($resultset, "fsm");
	$fse = odbc_result($resultset, "fse");
	$flfsh = odbc_result($resultset, "flfsh");
	
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
	
	
	foreach ($ME as $v) {
	//print ($v . "<br>");
		$SQL="SELECT * FROM [07L2] WHERE SUB='$userName'";  //an value goes here
//print ($SQL . "<br>");
		// Execute query:
		$resultset2=odbc_exec($con,$SQL); 
		while ($Row = odbc_fetch_row($resultset2)) {
			$id= odbc_result($resultset2, "id");
//print ($id . "<br>");


			$SQL2="SELECT [07L3].AN,NCPY FROM [07L3],[07o6] WHERE CA=$id AND [07L3].AN=[07o6].AN";
			//print ($SQL2 . "<br>");
			$resultset3=odbc_exec($con,$SQL2); 

			while ($Row2 = odbc_fetch_row($resultset3)) {
				$an=odbc_result($resultset3, "an");

				$SQL3="SELECT UU,NF,NL,DA,VER,UC,UM FROM [01D] WITH (NOLOCK) WHERE UA='$an' AND DA>='$startD' AND DA<='$endD' AND ME=$v"; //course number, california, illinois...
				//print ($SQL3 . "<br>");
				$resultset4=odbc_exec($con,$SQL3); 
				while ($Row3 = odbc_fetch_row($resultset4)) {
					$uu= odbc_result($resultset4, "uu");
					
						if ($userName=="fssifh") {
							$userName="fssifh (corp)";
						}
						
					$posts[] = array('StartDate'=> $startD,'EndDate'=> $endD,'StudentUserName'=> $uu,'CourseNum'=> $v,'CompanyName'=> $companyname,'ContactName'=> $contactname,'PayTo'=> $PayTo,'Link'=> $link,'TPUserName'=> $userName,'Password'=> $password,'RevenueShare'=> $revshare,'Rep'=> $rep,'TPNumber'=> $TPNumber,'type'=> "CSUB",'Data'=>1);
				}
			}
			if (odbc_fetch_row($resultset3)==false) {
					$posts[] = array('StartDate'=> $startD,'EndDate'=> $endD,'StudentUserName'=>'no data','CourseNum'=> $v,'CompanyName'=> $companyname,'ContactName'=> $contactname,'PayTo'=> $PayTo,'Link'=> $link,'TPUserName'=> $userName,'Password'=> $password,'RevenueShare'=> $revshare,'Rep'=> $rep,'TPNumber'=> $TPNumber,'type'=> "CSUB",'Data'=>0);
				}
		}
	

	
	
	}
unset($ME);
unset($coursetitle);
	
	}

/*if ($companyT=="csub") {
$SQL="SELECT * FROM [07L2] WHERE SUB='$accountN'";  //an value goes here
//echo $SQL;
// Execute query:
$resultset=odbc_exec($con,$SQL); 
while ($Row = odbc_fetch_row($resultset)) {
	$id= odbc_result($resultset, "id");

	$SQL2="SELECT [07L3].AN,NCPY FROM [07L3],[07o6] WHERE CA=$id AND [07L3].AN=[07o6].AN";
	//echo $SQL2;
	$resultset2=odbc_exec($con,$SQL2); 

	while ($Row2 = odbc_fetch_row($resultset2)) {
		$an=odbc_result($resultset2, "an");

		$SQL3="SELECT UU,NF,NL,DA,VER,UC,UM FROM [01D] WITH (NOLOCK) WHERE UA='$an' AND DA>='$startD' AND DA<='$endD' AND ME=$courseN"; //course number, california, illinois...
		//echo $SQL3;
		$resultset3=odbc_exec($con,$SQL3); 
		while ($Row3 = odbc_fetch_row($resultset3)) {
			$uu=odbc_result($resultset3, "uu");
			$posts[] = array('uu'=> $uu);
			$posts[] = array('type'=> "csub");
		}
    }
}
}

if ($companyT=="sub") {

		$SQL3="SELECT UU,NF,NL,DA,VER,UC,UM FROM [01D] WITH (NOLOCK) WHERE UA='$accountN' AND DA>='$startD' AND DA<='$endD' AND ME=$courseN"; //course number, california, illinois...
		//echo $SQL3;
		$resultset3=odbc_exec($con,$SQL3); 
		while ($Row3 = odbc_fetch_row($resultset3)) {
			$uu=odbc_result($resultset3, "uu");
			$posts[] = array('uu'=> $uu);
			$posts[] = array('type'=> "sub");
		}
    }


}*/	
	 odbc_free_result($resultset);
	 odbc_free_result($resultset2);
	odbc_close($con); 
$response['posts'] = $posts;

$fp = fopen('D:\Inetpub\TAP_Series_Web_Current\help\TPReport\results2.json', 'w');
fwrite($fp, json_encode($response));
fclose($fp);
 
 
 //echo $password;
// echo $companyname;
 
//mssql_close($con);

header('Location: http://www.tapseries.com/help/TPReport/results.html');


?>
	
