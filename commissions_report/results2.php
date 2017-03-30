<?php

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
$companyT=$_POST['companyType']; //csub = corporate enrollment, sub = not corporate enrollment,  4u = purchase
$companyN=$_POST['companyNumber'];
$courseN=$_POST['courseNumber'];
$accountN=$_POST['accountName'];


//4u section
$SQL4u = "SELECT * FROM commissions_report  WHERE TPNumber >0 and active=1";
$ME = array();
$coursetitle = array();
	// Execute query:
	$resultset=mssql_query($SQL4u, $con); 

	// Fetch rows:
	while ($row = mssql_fetch_array($resultset))
	{	
			$companyname = $row['CompanyName'];
			$contactname = $row['ContactName'];
			$userName = $row['UserName'];
			$password = $row['Password'];
			$Email = $row['Email'];
			$TPNumber = $row['TPNumber'];

			$fsm = $row['fs'];
			$fse = $row['nfon'];
			$haccp = $row['nhaccp'];
			$aa = $row['aa'];
			$fsre = $row['remn'];


			
			if ($fsm==1) {
				$ME[]=1;
				$coursetitle[]="Food Manager";
			}
			
			if ($fse==1) {
				$ME[]=2;
				$coursetitle[]="Food Handler (Other States)";
			}
			
			if ($haccp==1) {
				$ME[]=99;
				$coursetitle[]="HACCP";
			}
			if ($aa==1) {
				$ME[]=97;
				$coursetitle[]="Allergen Awareness";
			}
			if ($fsre==1) {
				$ME[]=98;
				$coursetitle[]="Re-certification";
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
					 else {
					$SQL = "SELECT [01D].* FROM [07SL4], [07SL1], [07L3], [01D]  WHERE [07SL4].VC=[07SL1].VC AND [07L3].PRO = [07SL4].id AND [01D].UA = [07L3].AN AND [01D].DA >= '$startD'   AND [07SL4].id=$TPNumber  AND [01D].DA <= '$endD' AND [01D].ME=$v"; 
					}

					// Execute query:
					$resultset2=mssql_query($SQL, $con); 

				// Fetch rows:
				while ($row = mssql_fetch_array($resultset2))
				{		
  					 $uu = $row['UU'];

					if($v==1){
						$Price=55;
					}
					if($userName=="nfstilink"){
						$Price=25;
					}
					if($userName=="afstlink"){
						$Price=5;
					}
					 
					

					$posts[] = array('StartDate'=> $startD,'EndDate'=> $endD,'StudentUserName'=> $uu,'CourseNum'=> $v,'Email'=> $Email,'Price'=> $Price,'CompanyName'=> $companyname,'ContactName'=> $contactname,'TPUserName'=> $userName,'Password'=> $password,'TPNumber'=> $TPNumber,'type'=> "4u",'Data'=>1);
				}
					
					if (mssql_fetch_array($resultset2)==false) 
					{
						$posts[] = array('StartDate'=> $startD,'EndDate'=> $endD,'StudentUserName'=>'no data','CourseNum'=> $v,'Email'=> $Email,'Price'=> $Price,'CompanyName'=> $companyname,'ContactName'=> $contactname,'TPUserName'=> $userName,'Password'=> $password,'TPNumber'=> $TPNumber,'type'=> "4u",'Data'=>0);
					}

				unset($ME);
				unset($coursetitle);
			}
	}














//sub section
$SQLsub = "SELECT * FROM commissions_report WHERE TPNumber =0 AND active=1";
$ME = array();
$coursetitle = array();
	// Execute query:
	$resultset=mssql_query($SQLsub, $con); 

	// Fetch rows:
	while ($row = mssql_fetch_array($resultset))
	{		
			 $companyname = $row['CompanyName'];
			 $contactname = $row['ContactName'];
			 $userName = $row['UserName'];
			 $password = $row['Password'];
			 $Email = $row['Email'];
			 $TPNumber = $row['TPNumber'];

			 $fsm = $row['fs'];
			 $fse = $row['nfon'];
			 $haccp = $row['nhaccp'];
			 $aa = $row['aa'];
			 $fsre = $row['remn'];
			 $txfsh = $row['txfsh'];
			 $wvfsh = $row['wvfsh'];
			 $ilfsh = $row['ilfsh'];

			
		
			
			if ($fsm==1) {
				$ME[]=1;
				$coursetitle[]="Food Manager";
			}
			
			if ($fse==1) {
				$ME[]=2;
				$coursetitle[]="Food Handler (Other States)";
			}
			
			if ($haccp==1) {
				$ME[]=99;
				$coursetitle[]="HACCP";
			}
			if ($aa==1) {
				$ME[]=97;
				$coursetitle[]="Allergen Awareness";
			}
			if ($fsre==1) {
				$ME[]=98;
				$coursetitle[]="Re-certification";
			}
			if ($txfsh==1) {
				$ME[]=7;
				$coursetitle[]="Texas Food Handler";
			}
			if ($wvfsh==1) {
				$ME[]=13;
				$coursetitle[]="West Virginia Food Handler";
			}
			if ($ilfsh==1) {
				$ME[]=20;
				$coursetitle[]="Illinois Food Handler";
			}
			
			
			foreach ($ME as $v) 
			{
			
				if($haccp==1) {
					
					$SQL="SELECT * FROM [04D]  WHERE UA='$userName' AND DA>='$startD' AND DA<='$endD' ";
						$resultset2=mssql_query($SQL, $con); 
				}
				if($aa==1) {
					$SQL="SELECT * FROM [09D]  WHERE UA='$userName' AND DA>='$startD' AND DA<='$endD' ";
						$resultset2=mssql_query($SQL, $con);
				}
				if($fsre==1) {
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
					 $uu = $row['UU'];

					 // fsm
					if($v==1){
						$Price=55;
					}
					// fsm-recert
					if($v==98){
						$Price=25;
					}
					//fh all other
					if($v==2){
						$Price=5;
					}
					//wv fh
					if($v==13){
						$Price=9.95;
					}
					// tx hf
					if($v==7){
						if($userName=="ths"){
							$Price=7.95;
						}
						else{
							$Price=9.95;
						}
					}
					// il hf
					if($v==20){
						$Price=9.95;
					}

		
					//test

					$posts[] = array('StartDate'=> $startD,'EndDate'=> $endD,'StudentUserName'=> $uu,'CourseNum'=> $v,'Email'=> $Email,'Price'=> $Price,'CompanyName'=> $companyname,'ContactName'=> $contactname,'TPUserName'=> $userName,'Password'=> $password,'TPNumber'=> $TPNumber,'type'=> "SUB",'Data'=>1);
				}
				if (mssql_fetch_array($resultset2)==false) 
				{
								$posts[] = array('StartDate'=> $startD,'EndDate'=> $endD,'StudentUserName'=>'no data','CourseNum'=> $v,'Email'=> $Email,'Price'=> $Price,'CompanyName'=> $companyname,'ContactName'=> $contactname,'TPUserName'=> $userName,'Password'=> $password,'TPNumber'=> $TPNumber,'type'=> "SUB",'Data'=>0);
				}

				unset($ME);
				unset($coursetitle);
			}
	}





	 //mssql_free_result($resultset);
	 //mssql_free_result($resultset2);
	 //mssql_close($con); 
$response['posts'] = $posts;

//echo json_encode($response);

$fp = fopen('results2.json', 'w');
fwrite($fp, json_encode($response));
fclose($fp);
 


header('Location: results.html');


?>
	
