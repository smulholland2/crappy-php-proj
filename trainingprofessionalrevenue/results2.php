<?php
error_reporting(0);

$user=$_SERVER['DB_USERNAME'];
$password=$_SERVER['DB_PASSWORD'];
$server=$_SERVER['DB_HOSTNAME'];
$database='newtap';
$con = mssql_connect($server,$user,$password);
mssql_select_db($database, $con);
 
$response = array();
$posts = array();

$startD=$_POST['startDate'];
$endD=$_POST['endDate'];
$share=$_POST['share'];
$companyT=$_POST['companyType']; //csub = corporate enrollment, sub = not corporate enrollment,  4u = purchase
$companyN=$_POST['companyNumber'];
$courseN=$_POST['courseNumber'];
$accountN=$_POST['accountName'];

//4u section

if($share == 1){
	$SQL4u = "SELECT * FROM RevShareNew  WHERE TPNumber IS NOT NULL AND TPNumber > 0 AND share=1 ";
}
elseif($share == 2){
	$SQL4u = "SELECT * FROM RevShareNew  WHERE TPNumber IS NOT NULL AND TPNumber > 0 AND share=0 ";
}
if($share == 3){
	$SQL4u = "SELECT * FROM RevShareNew  WHERE TPNumber IS NOT NULL AND TPNumber > 0";
}

$ME = array();
$coursetitle = array();
	// Execute query:
	$resultset=mssql_query($SQL4u, $con); 

	// Fetch rows:
	while ($row = mssql_fetch_array($resultset))
	{	
			$email="";

			$companyname = $row['CompanyName'];
			$contactname = $row['ContactName'];
			$PayTo = $row['PayTo'];
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
			$alc = $row['alc'];
			$ohfsh = $row['ohfsh'];
			$ad = $row['ad'];
			$as = $row['as'];


			$SQL5 = " SELECT IM FROM [07SL4] WHERE IU='$userName' ";
			$resultset5=mssql_query($SQL5, $con);
			while ($row = mssql_fetch_array($resultset5))
			{	
				$email = $row['IM'];
			}

			
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
			if ($alc==1) {
				$ME[]=96;
				$coursetitle[]="Alcohol Training";
			}
			if ($ohfsh==1) {
				$ME[]=10;
				$coursetitle[]="Ohio";
			}
			if ($ad==1) {
				$ME[]=167;
				$coursetitle[]="Allergen Plan Development";
			}
			if ($as==1) {
				$ME[]=168;
				$coursetitle[]="Allergen Plan Specialist";
			}
			
			foreach ($ME as $v) 
			{

					if ($v==3) {
					$SQL = "SELECT [01D].* FROM [07SL4], [07SL1], [07L3], [01D]  WHERE [07SL4].VC=[07SL1].VC AND [07L3].PRO = [07SL4].id AND [01D].UA = [07L3].AN AND [01D].DA >= '$startD'   AND [07SL4].id=$TPNumber  AND [01D].DA <= '$endD' AND [01D].ME=$v AND [01D].REGION='CAGEN' AND [07L3].AN <> 'fidelity'"; 
					
					} 
					else if ($v==33) {
					$SQL = "SELECT [01D].* FROM [07SL4], [07SL1], [07L3], [01D]  WHERE [07SL4].VC=[07SL1].VC AND [07L3].PRO = [07SL4].id AND [01D].UA = [07L3].AN AND [01D].DA >= '$startD'   AND [07SL4].id=$TPNumber  AND [01D].DA <= '$endD' AND [01D].ME=3 AND [01D].REGION='CASD'"; 
					} 
					else if ($v==99) {  //haccp
					$SQL = "SELECT [04D].* FROM [07SL4], [07SL1], [07L3], [04D]  WHERE [07SL4].VC=[07SL1].VC AND [07L3].PRO = [07SL4].id AND [04D].UA = [07L3].AN AND [04D].DA >= '$startD'   AND [07SL4].id=$TPNumber  AND [04D].DA <= '$endD'"; 
					} 
					else if ($v==98) { //recert
					$SQL = "SELECT [02D].* FROM [07SL4], [07SL1], [07L3], [02D]  WHERE [07SL4].VC=[07SL1].VC AND [07L3].PRO = [07SL4].id AND [02D].UA = [07L3].AN AND [02D].DA >= '$startD'   AND [07SL4].id=$TPNumber  AND [02D].DA <= '$endD' "; 
					} 
					else if ($v==97) { //Allergen Awareness
					$SQL = "SELECT [09D].* FROM [07SL4], [07SL1], [07L3], [09D]  WHERE [07SL4].VC=[07SL1].VC AND [07L3].PRO = [07SL4].id AND [09D].UA = [07L3].AN AND [09D].DA >= '$startD'   AND [07SL4].id=$TPNumber  AND [09D].DA <= '$endD' "; 
					} 
					else if ($v==96) { //Alcohol Training
					$SQL = "SELECT [12D].* FROM [07SL4], [07SL1], [07L3], [12D]  WHERE [07SL4].VC=[07SL1].VC AND [07L3].PRO = [07SL4].id AND [12D].UA = [07L3].AN AND [12D].DA >= '$startD'   AND [07SL4].id=$TPNumber  AND [12D].DA <= '$endD' "; 
					} 
					else if ($v==167) { //Allergen Plan Development
					$SQL = "SELECT [10D].* FROM [07SL4], [07SL1], [07L3], [10D]  WHERE [07SL4].VC=[07SL1].VC AND [07L3].PRO = [07SL4].id AND [10D].UA = [07L3].AN AND [10D].DA >= '$startD'   AND [07SL4].id=$TPNumber  AND [10D].DA <= '$endD' "; 
					} 
					else if ($v==168) { //Allergen Plan Specialist
					$SQL = "SELECT [11D].* FROM [07SL4], [07SL1], [07L3], [11D]  WHERE [07SL4].VC=[07SL1].VC AND [07L3].PRO = [07SL4].id AND [11D].UA = [07L3].AN AND [11D].DA >= '$startD'   AND [07SL4].id=$TPNumber  AND [11D].DA <= '$endD' "; 
					} 
					else {
					$SQL = "SELECT [01D].* FROM [07SL4], [07SL1], [07L3], [01D]  WHERE [07SL4].VC=[07SL1].VC AND [07L3].PRO = [07SL4].id AND [01D].UA = [07L3].AN AND [01D].DA >= '$startD'   AND [07SL4].id=$TPNumber  AND [01D].DA <= '$endD' AND [01D].ME=$v"; 
					}



				
				$resultset2=mssql_query($SQL, $con); 
				while ($row = mssql_fetch_array($resultset2))
				{		
					$uu = $row['UU'];
					
					if ($userName=="fssifh") {
						$userName="fssifh (link)";
					}

					if ($v==33) {
						$v=3;
					}
					$posts[] = array('StartDate'=> $startD,'EndDate'=> $endD,'StudentUserName'=> $uu,'CourseNum'=> $v,'CompanyName'=> $companyname,'ContactName'=> $contactname,'PayTo'=> $PayTo,'Link'=> $link,'TPUserName'=> $userName,'Password'=> $password,'RevenueShare'=> $revshare,'Rep'=> $rep,'TPNumber'=> $TPNumber,'type'=> "4u",'Data'=>1,'email'=> $email);
				}
					
					if (mssql_fetch_array($resultset2)==false) 
					{
						$posts[] = array('StartDate'=> $startD,'EndDate'=> $endD,'StudentUserName'=>'no data','CourseNum'=> $v,'CompanyName'=> $companyname,'ContactName'=> $contactname,'PayTo'=> $PayTo,'Link'=> $link,'TPUserName'=> $userName,'Password'=> $password,'RevenueShare'=> $revshare,'Rep'=> $rep,'TPNumber'=> $TPNumber,'type'=> "4u",'Data'=>0,'email'=> $email);
					}

				unset($ME);
				unset($coursetitle);
			}
	}














//sub section
if($share == 1){
	$SQLsub = "SELECT * FROM RevShareNew WHERE Corporate=0 AND TPNumber = 0 AND share=1 ";
}
if($share == 2){
	$SQLsub = "SELECT * FROM RevShareNew WHERE Corporate=0 AND TPNumber = 0 AND share=0 ";
}
if($share == 3){
	$SQLsub = "SELECT * FROM RevShareNew WHERE Corporate=0 AND TPNumber = 0 ";
}

$ME = array();
$coursetitle = array();
	// Execute query:
	$resultset=mssql_query($SQLsub, $con); 

	// Fetch rows:
	while ($row = mssql_fetch_array($resultset))
	{	
			$email="";

			$companyname = $row['CompanyName'];
			$contactname = $row['ContactName'];
			$PayTo = $row['PayTo'];
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
			$alc = $row['alc'];
			$ohfsh = $row['ohfsh'];
			$ad = $row['ad'];
			$as = $row['as'];

			$SQL6 = " SELECT AM FROM [07O1] WHERE AN='$userName' ";
			$resultset6=mssql_query($SQL6, $con);
			while ($row = mssql_fetch_array($resultset6))
			{	
				$email = $row['AM'];
			}

			
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
			if ($aa==1) {
				$ME[]=97;
				$coursetitle[]="Allergen Awareness";
			}
			if ($alc==1) {
				$ME[]=96;
				$coursetitle[]="Alcohol Training";
			}
			if ($ohfsh==1) {
				$ME[]=10;
				$coursetitle[]="Ohio";
			}
			if ($ad==1) {
				$ME[]=167;
				$coursetitle[]="Allergen Plan Development";
			}
			if ($as==1) {
				$ME[]=168;
				$coursetitle[]="Allergen Plan Specialist";
			}
			
			
			foreach ($ME as $v) 
			{
			
				if($haccp==1) {
					$SQL="SELECT * FROM [04D]  WHERE UA='$userName' AND DA>='$startD' AND DA<='$endD' ";
					$resultset2=mssql_query($SQL, $con); 
				}
				elseif ($aa==1) {
					$SQL="SELECT * FROM [09D]  WHERE UA='$userName' AND DA>='$startD' AND DA<='$endD' ";
					$resultset2=mssql_query($SQL, $con);
				}
				elseif ($alc==1) {
					$SQL="SELECT * FROM [12D]  WHERE UA='$userName' AND DA>='$startD' AND DA<='$endD' ";
					$resultset2=mssql_query($SQL, $con);
				}
				elseif ($ad==1) {
					$SQL="SELECT * FROM [10D]  WHERE UA='$userName' AND DA>='$startD' AND DA<='$endD' ";
					$resultset2=mssql_query($SQL, $con);
				}
				elseif ($as==1) {
					$SQL="SELECT * FROM [11D]  WHERE UA='$userName' AND DA>='$startD' AND DA<='$endD' ";
					$resultset2=mssql_query($SQL, $con);
				}
				elseif ($fsre==1) {
					$SQL="SELECT * FROM [02D]  WHERE UA='$userName' AND DA>='$startD' AND DA<='$endD' ";
					$resultset2=mssql_query($SQL, $con);
				}
				
				else{
				$SQL="SELECT UU,NF,NL,DA,VER,UC,UM FROM [01D] WHERE UA='$userName' AND DA>='$startD' AND DA<='$endD' AND ME=$v";
					$resultset2=mssql_query($SQL, $con); 
				}
						
				// Fetch rows:
				while ($row = mssql_fetch_array($resultset2))
				{	
					//$uu= odbc_result($resultset2, "UU");
					$uu = $row['UU'];

					$posts[] = array('StartDate'=> $startD,'EndDate'=> $endD,'StudentUserName'=> $uu,'CourseNum'=> $v,'CompanyName'=> $companyname,'ContactName'=> $contactname,'PayTo'=> $PayTo,'Link'=> $link,'TPUserName'=> $userName,'Password'=> $password,'RevenueShare'=> $revshare,'Rep'=> $rep,'TPNumber'=> $TPNumber,'type'=> "SUB",'Data'=>1,'email'=> $email);
				}
				if (mssql_fetch_array($resultset2)==false) 
				{
								$posts[] = array('StartDate'=> $startD,'EndDate'=> $endD,'StudentUserName'=>'no data','CourseNum'=> $v,'CompanyName'=> $companyname,'ContactName'=> $contactname,'PayTo'=> $PayTo,'Link'=> $link,'TPUserName'=> $userName,'Password'=> $password,'RevenueShare'=> $revshare,'Rep'=> $rep,'TPNumber'=> $TPNumber,'type'=> "SUB",'Data'=>0,'email'=> $email);
				}

				unset($ME);
				unset($coursetitle);
			}
	}











//csub section

if($share == 1){
	$SQLcsub = "SELECT * FROM RevShareNew  WHERE Corporate=1 AND TPNumber = 0 AND share=1 ";
}
if($share == 2){
	$SQLcsub = "SELECT * FROM RevShareNew  WHERE Corporate=1 AND TPNumber = 0 AND share=0 ";
}
if($share == 3){
	$SQLcsub = "SELECT * FROM RevShareNew  WHERE Corporate=1 AND TPNumber = 0 ";
}
$ME = array();
$coursetitle = array();
	// Execute query:
	$resultset=mssql_query($SQLcsub, $con); 

	// Fetch rows:
	while ($row = mssql_fetch_array($resultset))
	{	

				$email="";

				$companyname = $row['CompanyName'];
				$contactname = $row['ContactName'];
				$PayTo = $row['PayTo'];
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

				$SQL7 = " SELECT UM FROM [07L2] WHERE UU='$userName' ";
				$resultset7=mssql_query($SQL7, $con);
				while ($row = mssql_fetch_array($resultset7))
				{	
					$email = $row['UM'];
				}

	
				
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
				
				
				foreach ($ME as $v) 
				{
					$SQL="SELECT * FROM [07L2] WHERE SUB='$userName'";  //an value goes here
						$resultset2=mssql_query($SQL, $con); 

					while ($row = mssql_fetch_array($resultset2)) 
					{	

						$id = $row['id'];


						$SQL2="SELECT [07L3].AN,NCPY FROM [07L3],[07O6] WHERE CA=$id AND [07L3].AN=[07O6].AN";
							$resultset3=mssql_query($SQL2, $con); 


							while ($row = mssql_fetch_array($resultset3)) 
							{

								$an = $row['AN'];

								$SQL3="SELECT UU,NF,NL,DA,VER,UC,UM FROM [01D] WHERE UA='$an' AND DA>='$startD' AND DA<='$endD' AND ME=$v"; //course number, california, illinois...
									$resultset4=mssql_query($SQL3, $con); 

									while ($row = mssql_fetch_array($resultset4)) 
									{

										$uu = $row['UU'];
										
											if ($userName=="fssifh") 
											{
												$userName="fssifh (corp)";
											}
											
										$posts[] = array('StartDate'=> $startD,'EndDate'=> $endD,'StudentUserName'=> $uu,'CourseNum'=> $v,'CompanyName'=> $companyname,'ContactName'=> $contactname,'PayTo'=> $PayTo,'Link'=> $link,'TPUserName'=> $userName,'Password'=> $password,'RevenueShare'=> $revshare,'Rep'=> $rep,'TPNumber'=> $TPNumber,'type'=> "CSUB",'Data'=>1,'email'=> $email);
									}
							}

						if (mssql_fetch_array($resultset3)==false) 
						{
							$posts[] = array('StartDate'=> $startD,'EndDate'=> $endD,'StudentUserName'=>'no data','CourseNum'=> $v,'CompanyName'=> $companyname,'ContactName'=> $contactname,'PayTo'=> $PayTo,'Link'=> $link,'TPUserName'=> $userName,'Password'=> $password,'RevenueShare'=> $revshare,'Rep'=> $rep,'TPNumber'=> $TPNumber,'type'=> "CSUB",'Data'=>0,'email'=> $email);
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

$fp = fopen('results2.json', 'w');
fwrite($fp, json_encode($response));
fclose($fp);
 


header('Location: results.html');


?>
	
