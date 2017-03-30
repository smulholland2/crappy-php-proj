<?php
error_reporting(0); 




$user=$_SERVER['DB_USERNAME'];
$password=$_SERVER['DB_PASSWORD'];
$server=$_SERVER['DB_HOSTNAME'];
$database='newtap';
$con = mssql_connect($server,$user,$password);
mssql_select_db($database, $con); 

		//gets all ProID values and stores it in an array
	$SQL0 = "SELECT ProID FROM [07DS2] ";		
	$resultset0=mssql_query($SQL0, $con); 
	
		while ($row = mssql_fetch_array($resultset0)) 
		{
		     $ProIDDB[] = $row['ProID'];
		}  	



session_start();



$PRO_4u=$_SESSION["PRO_4u"];

$productsname = $_SESSION["productsname"] ;
$discode = $_SESSION["discode"] ;
$ONUMsess = $_SESSION["ONUM"] ;
$TAPONUMsess = $_SESSION["TAPONUM"] ;
$addSudentToCourse = $_SESSION["addSudentToCourse"] ;
$courseLanguage = $_SESSION["courseLanguage"];

$floridaLicense = $_SESSION["floridaLicense"];

$previousun = $_SESSION["previousun"] ;
$previouspw = $_SESSION["previouspw"] ;

$cardfn = $_SESSION["cardfn"];
$cardln = $_SESSION["cardln"];
$last4 = $_SESSION["last4"];
$cardcn = $_SESSION["cardcn"];
$cardadd1 = $_SESSION["cardadd1"];
$cardadd2 = $_SESSION["cardadd2"];
$cardci = $_SESSION["cardci"];
$cardst = $_SESSION["cardst"];
$cardzip = $_SESSION["cardzip"];
$cardcou = $_SESSION["cardcou"];
$cardphone = $_SESSION["cardphone"];
$cardem = $_SESSION["cardem"];

$month = $_SESSION["month"];
$day = $_SESSION["day"];
$year = $_SESSION["year"];
$bdate=$month."/".$day."/".$year;
$bdate2=date_create($bdate);
$bdate3=date_format($bdate2,"Y-m-d H:i:s");

$userfn = $_SESSION["userfn"];
$userln = $_SESSION["userln"];
$usercn = $_SESSION["usercn"];
$useradd1 = $_SESSION["useradd1"];
$useradd2 = $_SESSION["useradd2"];
$userci = $_SESSION["userci"];
$userst = $_SESSION["userst"];
$userzip = $_SESSION["userzip"];
$usercou = $_SESSION["usercou"];
$userphone = $_SESSION["userphone"];
$userem = $_SESSION["userem"];

$totaltobecharged = $_POST["totaltobecharged"];
$newusername = $_SESSION["newusername"] ;
$newpassword = $_SESSION["newpassword"] ;

$existingusername = $_SESSION["existingusername"] ;
$existingpassword = $_SESSION["existingpassword"] ;

$CorporateSubAccountID = $_SESSION["CorporateSubAccountID"];

$corporate_username=$_SESSION["corporate_username"];
$corpVC=$_SESSION["corpVC"];

$Utah_Region=$_SESSION["Utah_Region"];
$Utah_gender=$_SESSION["Utah_gender"];
$Utah_County=$_SESSION["Utah_County"];
$Utah_work_phone=$_SESSION["Utah_work_phone"];

$oh2_id=$_SESSION["oh2_id"];

$purchase_license_keys=$_SESSION["purchase_license_keys"];
if($purchase_license_keys=="yes")
{
	//check if account only charges for state fee and the rest of the courses are free, we bill them at the end of the month
	$SQL2 = "SELECT state_fee_only FROM [07SL1] WHERE VC='$discode' ";
	$resultset2=mssql_query($SQL2, $con); 					
	while ($row = mssql_fetch_array($resultset2)) 
	{
		$state_fee_only = $row['state_fee_only'];
	}
}



	// Corporate Place Orders Page Purchase !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

	if($corporate_username && $corpVC)
	{
			if($ONUMsess=='')
			{
				//************ 07O2 Invoice info  ******************************************
				
				$SQL1 = "INSERT INTO [07O2] (AN) VALUES (".mssql_escape($corporate_username).") ";
				$resultset1=mssql_query($SQL1, $con); 	

				$SQL2 = "SELECT ONUM FROM [07O2] WHERE AN='$corporate_username' ORDER BY ONUM ASC";		
				$resultset2=mssql_query($SQL2, $con);
				
				while ($row = mssql_fetch_array($resultset2)) 
				{
					$ONUM = $row['ONUM'];
				}
				
				$_SESSION["ONUM"] = $ONUM;
				
				$TAP='TAP0';
				$TAPONUM=$TAP.$ONUM;
				
				$_SESSION["TAPONUM"] = $TAPONUM;
							
				$todaytime = date("Y-m-d h:i:s");

				$SQL3 = "UPDATE [07O2] SET OID='$TAPONUM', DO='$todaytime', PAY='incomplete', TC='$totaltobecharged', VC='$corpVC' WHERE ONUM=$ONUM ";	
				$resultset3=mssql_query($SQL3, $con);					

				
				//***************** 07O4 Purchase QTY info ***************************************
		
				//checks if SESSION array name is in $ProIDDB, if not it won't add it to $sessionm array
				foreach ($_SESSION as $key=>$val)
				{
					if(in_array($key, $ProIDDB))
					{
						$sessionm[] = $key;
					}

				}						

				//for every array that made it to $sessionm array, run the following code
				foreach($sessionm as $valm)
				{

					$session=$_SESSION[$valm];

					/*
					if($session[2]=="oh2"){
						$session[2]="fs";
					}
					if($session[2]=="oh2rt"){
						$session[2]="fsrt";
					}
					if($session[2]=="remn" || $session[2]=="reri" || $session[2]=="rewi"){
						$session[2]="refs";
					}
					*/
					
					$session[0] = str_replace("'", "", $session[0]);

					//inset to DB if course QTY > 0
					if($session[1]>0){
						$SQL4 = "INSERT INTO [07O4] (OID, PC, PN, PRI, NO) 
						VALUES ('$TAPONUM', '$session[2]', '$session[0]', '$session[3]', '$session[1]') ";
						$resultset4=mssql_query($SQL4, $con);
					}
				}			

			}
						
			else
			{
				$ONUM = $ONUMsess;
				
				//************ 07O2 information  ******************************************
				
				$SQL6 = "UPDATE [07O2] SET AN=".mssql_escape($corporate_username).", PAY='incomplete',  TC='$totaltobecharged' WHERE OID='$TAPONUMsess' ";	
				$resultset6=mssql_query($SQL6, $con);		
							
				//************ 07O4 information  ******************************************
				
				$SQL7 = "DELETE FROM [07O4]	WHERE OID='$TAPONUMsess' ";
				$resultset7=mssql_query($SQL7, $con);
				
				//checks if SESSION array name is in $ProIDDB, if not it won't add it to $sessionm array
				foreach ($_SESSION as $key=>$val)
				{
					if(in_array($key, $ProIDDB))
					{
						$sessionm[] = $key;
					}

				}
					
				//for every array that made it to $sessionm array, run the following code
				foreach($sessionm as $valm)
				{

					$session=$_SESSION[$valm];

					/*
					if($session[2]=="oh2"){
						$session[2]="fs";
					}
					if($session[2]=="oh2rt"){
						$session[2]="fsrt";
					}
					if($session[2]=="remn" || $session[2]=="reri" || $session[2]=="rewi"){
						$session[2]="refs";
					}
					*/

					$session[0] = str_replace("'", "", $session[0]);

					//inset to DB if course QTY > 0
					if($session[1]>0){
						$SQL8 = "INSERT INTO [07O4] (OID, PC, PN, PRI, NO) 
						VALUES ('$TAPONUMsess', '$session[2]', '$session[0]', '$session[3]', '$session[1]') ";
						$resultset8=mssql_query($SQL8, $con);
					}
				}
				
			}

			
			//******************** 07L2 corporate info table (updates every time user visits page)  **************************************

				$SQL33 = "UPDATE [07L2] SET NF=".mssql_escape($cardfn).", NL=".mssql_escape($cardln).", UA=".mssql_escape($cardcn).", AA1=".mssql_escape($cardadd1).", AA2=".mssql_escape($cardadd2).", ACI=".mssql_escape($cardci).", AST='$cardst', AZ='$cardzip', ACO='$cardcou', AP='$cardphone', UM=".mssql_escape($cardem)." WHERE UU='$corporate_username' ";	
				$resultset98=mssql_query($SQL33, $con);
		
	}


	// regular, 4u & corp 4u purchases
	else 
	{

		// NEW CUSTOMERS !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

		if($newusername && $existingusername=="")
		{
			if($ONUMsess=='')
			{
				//************ 07O2 information  ******************************************
							
				$SQL1 = "INSERT INTO [07O2] (AN) VALUES (".mssql_escape($newusername).") ";
				$resultset1=mssql_query($SQL1, $con); 	

				$SQL2 = "SELECT ONUM FROM [07O2] WHERE AN='$newusername' ";		
				$resultset2=mssql_query($SQL2, $con);
				
				while ($row = mssql_fetch_array($resultset2)) 
				{
					$ONUM = $row['ONUM'];
				}  
				
				$_SESSION["ONUM"] = $ONUM;
				
				$TAP='TAP0';
				$TAPONUM=$TAP.$ONUM;
				
				$_SESSION["TAPONUM"] = $TAPONUM;
							
				$todaytime = date("Y-m-d h:i:s");
				
				if($discode)
				{
					$discode_receipt = $discode;
					if($_SESSION["price_discode"]){
						$discode_receipt = $_SESSION["price_discode"];
					}
				$SQL3 = "UPDATE [07O2] SET OID='$TAPONUM', DO='$todaytime', PAY='incomplete', TC='$totaltobecharged', VC='$discode_receipt' WHERE ONUM=$ONUM ";	
				$resultset3=mssql_query($SQL3, $con);		
				}
				else
				{
					$SQL3 = "UPDATE [07O2] SET OID='$TAPONUM', DO='$todaytime', PAY='incomplete', TC='$totaltobecharged' WHERE ONUM=$ONUM ";
					$resultset3=mssql_query($SQL3, $con);			
				}
				
							
				//***************** 07O4 information ***************************************
							
				//checks if SESSION array name is in $ProIDDB, if not it won't add it to $sessionm array
				foreach ($_SESSION as $key=>$val)
				{
					if(in_array($key, $ProIDDB))
					{
						$sessionm[] = $key;
					}

				}
							

				//for every array that made it to $sessionm array, run the following code
				foreach($sessionm as $valm)
				{

					$session=$_SESSION[$valm];

					/*
					if($session[2]=="oh2"){
						$session[2]="fs";
					}
					if($session[2]=="oh2rt"){
						$session[2]="fsrt";
					}
					if($session[2]=="remn" || $session[2]=="reri" || $session[2]=="rewi"){
						$session[2]="refs";
					}
					*/

					$session[0] = str_replace("'", "", $session[0]);
					
					//inset to DB if course QTY > 0
					if($session[1]>0){
						$SQL4 = "INSERT INTO [07O4] (OID, PC, PN, PRI, NO) 
						VALUES ('$TAPONUM', '$session[2]', '$session[0]', '$session[3]', '$session[1]') ";
						$resultset4=mssql_query($SQL4, $con);
					}
				}
							
				
				//***************** 07L3 Account Username and Password  *****************************	

				// if purchasing from 4u corp page
				if($CorporateSubAccountID)
				{			
				$SQL5 = "INSERT INTO [07L3] (AN, AC, CTRLEXAM, VC, TRAIN_PERIOD, FORCECOR, CA) 
				VALUES (".mssql_escape($newusername).", ".mssql_escape($newpassword).", '1', '$discode', '180', '1', ".mssql_escape($CorporateSubAccountID).") ";
				$resultset5=mssql_query($SQL5, $con);
				}
				// if purchasing from tap web, regular 4u page
				else{

				if($PRO_4u){	
				$SQL5 = "INSERT INTO [07L3] (AN, AC, PRO, CTRLEXAM, VC, TRAIN_PERIOD, FORCECOR) 
				VALUES (".mssql_escape($newusername).", ".mssql_escape($newpassword).", '$PRO_4u', '1', '$discode', '180', '1') ";
				}
				else{
				$SQL5 = "INSERT INTO [07L3] (AN, AC, CTRLEXAM, VC, TRAIN_PERIOD, FORCECOR) 
				VALUES (".mssql_escape($newusername).", ".mssql_escape($newpassword).", '1', '$discode', '180', '1') ";	
				}
				$resultset5=mssql_query($SQL5, $con);
				}
				
				$_SESSION["previousun"] = $newusername;
				$_SESSION["previouspw"] = $newpassword;						
				
			}
						
			else
			{
				$ONUM = $ONUMsess;
				
				//************ 07O2 information  ******************************************
				
				$SQL6 = "UPDATE [07O2] SET AN=".mssql_escape($newusername).", PAY='incomplete',  TC='$totaltobecharged' WHERE OID='$TAPONUMsess' ";	
				$resultset6=mssql_query($SQL6, $con);		
				
				
				//************ 07O4 information  ******************************************
				
				$SQL7 = "DELETE FROM [07O4]	WHERE OID='$TAPONUMsess' ";
				$resultset7=mssql_query($SQL7, $con);						
				
				//checks if SESSION array name is in $ProIDDB, if not it won't add it to $sessionm array
				foreach ($_SESSION as $key=>$val)
				{
					if(in_array($key, $ProIDDB))
					{
						$sessionm[] = $key;
					}

				}
					

					//for every array that made it to $sessionm array, run the following code
				foreach($sessionm as $valm)
				{

					$session=$_SESSION[$valm];

					/*
					if($session[2]=="oh2"){
						$session[2]="fs";
					}
					if($session[2]=="oh2rt"){
						$session[2]="fsrt";
					}
					if($session[2]=="remn" || $session[2]=="reri" || $session[2]=="rewi"){
						$session[2]="refs";
					}
					*/

					$session[0] = str_replace("'", "", $session[0]);
					
					//inset to DB if course QTY > 0
					if($session[1]>0){
						$SQL8 = "INSERT INTO [07O4] (OID, PC, PN, PRI, NO) 
						VALUES ('$TAPONUMsess', '$session[2]', '$session[0]', '$session[3]', '$session[1]') ";
						$resultset8=mssql_query($SQL8, $con);
					}
				}

				
				
				//***************** 07L3 information ***************************************	

				
				if($newusername != $previousun || $newpassword != $previouspw)
				{
					
					$SQL9 = "UPDATE [07L3] SET AN=".mssql_escape($newusername).", AC=".mssql_escape($newpassword)." WHERE AN='$previousun' ";	
					$resultset9=mssql_query($SQL9, $con);
						
						$_SESSION["previousun"] = $newusername;
						$_SESSION["previouspw"] = $newpassword;
				}

				// update CA every time if youre coming from a corp 4u page
				if($CorporateSubAccountID)
				{
					$SQL5 = "UPDATE [07L3] SET CA='$CorporateSubAccountID' WHERE AN='$newusername' ";	
					$resultset5=mssql_query($SQL5, $con);
				}	
			}
			
			//******************** 07O1 billing information, INSERT if not found, UPDATE if found   **************************************

			$SQL99 = "SELECT AN FROM [07O1] WHERE AN='$newusername' ";
			$resultset99=mssql_query($SQL99, $con);
			
			while ($row = mssql_fetch_array($resultset99)) 
			{
				$t07O1AN = $row['AN'];
			}   
			
			$NCON07O1 = $cardfn . " " . $cardln;
			$DIV_NAME07O1 = $cardfn . "_" . $cardln;
			
			if($t07O1AN)
			{
				$SQL98 = "UPDATE [07O1] SET NCON=".mssql_escape($NCON07O1).", NCPY=".mssql_escape($cardcn).", AA1=".mssql_escape($cardadd1).", AA2=".mssql_escape($cardadd2).", ACI=".mssql_escape($cardci).", AST='$cardst', AZ='$cardzip', ACO='$cardcou', AP='$cardphone', AM=".mssql_escape($cardem).", DIV_NAME=".mssql_escape($DIV_NAME07O1)." WHERE AN='$newusername' ";	
				$resultset98=mssql_query($SQL98, $con);
			}
			else
			{		
				$SQL97 = "INSERT INTO [07O1] (AN, NCON, NCPY, AA1, AA2, ACI, AST, AZ, ACO, AP, AM, DIV_NAME) 
				VALUES (".mssql_escape($newusername).", ".mssql_escape($NCON07O1).", ".mssql_escape($cardcn).", ".mssql_escape($cardadd1).", ".mssql_escape($cardadd2).", ".mssql_escape($cardci).", '$cardst', '$cardzip', '$cardcou', '$cardphone', ".mssql_escape($cardem).", ".mssql_escape($DIV_NAME07O1).") ";
				$resultset97=mssql_query($SQL97, $con);

			}
			
			//******************** 07O6 user information, INSERT if not found, UPDATE if found   **************************************
			
			$SQL96 = "SELECT AN FROM [07O6] WHERE AN='$newusername' ";
			$resultset96=mssql_query($SQL96, $con);
			
			while ($row = mssql_fetch_array($resultset96)) 
			{
				$t07O6AN = $row['AN'];
			} 
			
			$NCON07O6 = $userfn . " " . $userln;
			$DIV_NAME07O6 = $userfn . "_" . $userln;
			
			if($t07O6AN)
			{
				$SQL95 = "UPDATE [07O6] SET NCON=".mssql_escape($NCON07O6).", NCPY=".mssql_escape($usercn).", AA1=".mssql_escape($useradd1).", AA2=".mssql_escape($useradd2).", ACI=".mssql_escape($userci).", AST='$userst', AZ='$userzip', ACO='$usercou', AP='$userphone', AM=".mssql_escape($userem).", NF=".mssql_escape($userfn).", NL=".mssql_escape($userln).", DIV_NAME=".mssql_escape($DIV_NAME07O6).", DOB='$bdate3' WHERE AN='$newusername' ";	
				$resultset95=mssql_query($SQL95, $con);
			}
			else
			{
				$SQL94 = "INSERT INTO [07O6] (AN, NCON, NCPY, AA1, AA2, ACI, AST, AZ, ACO, AP, AM, NF, NL, DIV_NAME, DOB) 
				VALUES (".mssql_escape($newusername).", ".mssql_escape($NCON07O6).", ".mssql_escape($usercn).", ".mssql_escape($useradd1).", ".mssql_escape($useradd2).", ".mssql_escape($userci).", '$userst', '$userzip', '$usercou', '$userphone', ".mssql_escape($userem).", ".mssql_escape($userfn).", ".mssql_escape($userln).", ".mssql_escape($DIV_NAME07O6).", '$bdate3') ";
				$resultset94=mssql_query($SQL94, $con);
			}
		
		}
		


		
		// EXISTING CUSTOMERS !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

		if($existingusername && $newusername=="")
		{
			//echo "ONUMsess=";
			//echo $ONUMsess;
			if($ONUMsess=='')
			{
				//************ 07O2 information  ******************************************
				
				
				 $SQL111 = "INSERT INTO [07O2] (AN) VALUES (".mssql_escape($existingusername).") ";
				$resultset11=mssql_query($SQL111, $con); 
				/*
				if($resultset11){
					echo "A new ONUM was created";
				}
				*/	

				//  order by ONUM so you will always get the highes number  !!!!!!!!!!!!!!!!!!!!!!!!!!!
				$SQL2 = "SELECT ONUM FROM [07O2] WHERE AN='$existingusername' ORDER BY ONUM ASC";		
				$resultset2=mssql_query($SQL2, $con);
				
				while ($row = mssql_fetch_array($resultset2)) 
				{
					 $ONUM = $row['ONUM'];
				}
				
				$_SESSION["ONUM"] = $ONUM;
				
				$TAP='TAP0';
				$TAPONUM=$TAP.$ONUM;
				
				$_SESSION["TAPONUM"] = $TAPONUM;
							
				$todaytime = date("Y-m-d h:i:s");
				
				if($discode)
				{
					$discode_receipt = $discode;
					if($_SESSION["price_discode"]){
						$discode_receipt = $_SESSION["price_discode"];
					}
				$SQL3 = "UPDATE [07O2] SET OID='$TAPONUM', DO='$todaytime', PAY='incomplete', TC='$totaltobecharged', VC='$discode_receipt' WHERE ONUM=$ONUM ";	
				$resultset3=mssql_query($SQL3, $con);		
				}
				else
				{
					$SQL3 = "UPDATE [07O2] SET OID='$TAPONUM', DO='$todaytime', PAY='incomplete', TC='$totaltobecharged' WHERE ONUM=$ONUM ";
					$resultset3=mssql_query($SQL3, $con);			
				}
				
				
				
				//***************** 07O4 information ***************************************
				
				
				
				//checks if SESSION array name is in $ProIDDB, if not it won't add it to $sessionm array
				foreach ($_SESSION as $key=>$val)
				{
					if(in_array($key, $ProIDDB))
					{
						$sessionm[] = $key;
					}

				}			

				//for every array that made it to $sessionm array, run the following code
				foreach($sessionm as $valm)
				{

					$session=$_SESSION[$valm];

					/*
					if($session[2]=="oh2"){
						$session[2]="fs";
					}
					if($session[2]=="oh2rt"){
						$session[2]="fsrt";
					}
					if($session[2]=="remn" || $session[2]=="reri" || $session[2]=="rewi"){
						$session[2]="refs";
					}
					*/

					$session[0] = str_replace("'", "", $session[0]);
					
					//inset to DB if course QTY > 0
					if($session[1]>0){
						$SQL4 = "INSERT INTO [07O4] (OID, PC, PN, PRI, NO) 
						VALUES ('$TAPONUM', '$session[2]', '$session[0]', '$session[3]', '$session[1]') ";
						$resultset4=mssql_query($SQL4, $con);
					}
				}

				
				//***************** 07L3 Account Username and Password  *****************************	
						

			}
						
			else
			{
				$ONUM = $ONUMsess;
				
				//************ 07O2 information  ******************************************
				
				$SQL6 = "UPDATE [07O2] SET AN='$existingusername', PAY='incomplete',  TC='$totaltobecharged' WHERE OID='$TAPONUMsess' ";	
				$resultset6=mssql_query($SQL6, $con);		
				
				
				//************ 07O4 information  ******************************************
				
				$SQL7 = "DELETE FROM [07O4]	WHERE OID='$TAPONUMsess' ";
				$resultset7=mssql_query($SQL7, $con);
				
				
				
				//checks if SESSION array name is in $ProIDDB, if not it won't add it to $sessionm array
				foreach ($_SESSION as $key=>$val)
				{
					if(in_array($key, $ProIDDB))
					{
						$sessionm[] = $key;
					}

				}
					

					//for every array that made it to $sessionm array, run the following code
				foreach($sessionm as $valm)
				{

					$session=$_SESSION[$valm];

					/*
					if($session[2]=="oh2"){
						$session[2]="fs";
					}
					if($session[2]=="oh2rt"){
						$session[2]="fsrt";
					}
					if($session[2]=="remn" || $session[2]=="reri" || $session[2]=="rewi"){
						$session[2]="refs";
					}
					*/

					$session[0] = str_replace("'", "", $session[0]);
					
					//inset to DB if course QTY > 0
					if($session[1]>0){
						$SQL8 = "INSERT INTO [07O4] (OID, PC, PN, PRI, NO) 
						VALUES ('$TAPONUMsess', '$session[2]', '$session[0]', '$session[3]', '$session[1]') ";
						$resultset8=mssql_query($SQL8, $con);
					}
				}

				
				
				//***************** 07L3 information ***************************************	
				
			}
			
			//******************** 07O1 billing information, INSERT if not found, UPDATE if found   **************************************

			$SQL99 = "SELECT AN FROM [07O1] WHERE AN='$existingusername' ";
			$resultset99=mssql_query($SQL99, $con);
			
			while ($row = mssql_fetch_array($resultset99)) 
			{
				$t07O1AN = $row['AN'];
			}
			
			
			$NCON07O1 = $cardfn . " " . $cardln;
			$DIV_NAME07O1 = $cardfn . "_" . $cardln;
			
			
			// if card info exists
			if($t07O1AN)
			{
				$SQL98 = "UPDATE [07O1] SET NCON=".mssql_escape($NCON07O1).", NCPY=".mssql_escape($cardcn).", AA1=".mssql_escape($cardadd1).", AA2=".mssql_escape($cardadd2).", ACI=".mssql_escape($cardci).", AST='$cardst', AZ='$cardzip', ACO='$cardcou', AP='$cardphone', AM=".mssql_escape($cardem).", DIV_NAME=".mssql_escape($DIV_NAME07O1)." WHERE AN='$existingusername' ";	
				$resultset98=mssql_query($SQL98, $con);
			}
			
			//if card info doesn't exist
			else
			{		
				$SQL97 = "INSERT INTO [07O1] (AN, NCON, NCPY, AA1, AA2, ACI, AST, AZ, ACO, AP, AM, DIV_NAME) 
				VALUES (".mssql_escape($existingusername).", ".mssql_escape($NCON07O1).", ".mssql_escape($cardcn).", ".mssql_escape($cardadd1).", ".mssql_escape($cardadd2).", ".mssql_escape($cardci).", '$cardst', '$cardzip', '$cardcou', '$cardphone', ".mssql_escape($cardem).", ".mssql_escape($DIV_NAME07O1).") ";
				$resultset97=mssql_query($SQL97, $con);

			}
			
			//******************** 07O6 user information, INSERT if not found, UPDATE if found   **************************************
			
			$SQL96 = "SELECT AN FROM [07O6] WHERE AN='$existingusername' ";
			$resultset96=mssql_query($SQL96, $con);

			while ($row = mssql_fetch_array($resultset96)) 
			{
				$t07O6AN = $row['AN'];
			}		
			

			$NCON07O6 = $userfn . " " . $userln;
			$DIV_NAME07O6 = $userfn . "_" . $userln;
						
			//if user info exists
			if($t07O6AN)
			{
				$SQL95 = "UPDATE [07O6] SET NCON=".mssql_escape($NCON07O6).", NCPY=".mssql_escape($usercn).", AA1=".mssql_escape($useradd1).", AA2=".mssql_escape($useradd2).", ACI=".mssql_escape($userci).", AST='$userst', AZ='$userzip', ACO='$usercou', AP='$userphone', AM=".mssql_escape($userem).", NF=".mssql_escape($userfn).", NL=".mssql_escape($userln).", DIV_NAME=".mssql_escape($DIV_NAME07O6)." WHERE AN='$existingusername' ";	
				$resultset95=mssql_query($SQL95, $con);
			}
			//if user info doesn't exist
			else
			{
				$SQL94 = "INSERT INTO [07O6] (AN, NCON, NCPY, AA1, AA2, ACI, AST, AZ, ACO, AP, AM, NF, NL, DIV_NAME) 
				VALUES (".mssql_escape($existingusername).", ".mssql_escape($NCON07O6).",".mssql_escape($usercn).", ".mssql_escape($useradd1).",".mssql_escape($useradd2).", ".mssql_escape($userci).", '$userst', '$userzip', '$usercou', '$userphone', ".mssql_escape($userem).", ".mssql_escape($userfn).", ".mssql_escape($userln).", ".mssql_escape($DIV_NAME07O6).") ";
				$resultset94=mssql_query($SQL94, $con);
			}
		}
		
	}	

		
		
// Converts user $_POST data to hexidecimal values that MS SQL Server
// natively converts back to its original value. This is to prevent
// SQL injection and should be used on every $_POST variable in the system.
// Returns a hexidecimal number or int.
function mssql_escape($data)
{

                if(is_numeric($data))
                                return "'".$data."'";

                $unpacked = unpack('H*hex', $data);

                return '0x' . $unpacked['hex'];
}
	
	

if ($TAPONUMsess=='')
{
	$TAPONUMsess = $TAPONUM;
}





//print_r($_SESSION);
?>


<!DOCTYPE html>
<html>
<head>
<title>Page Title</title>
</head>
<body onload="load()">

<?php
if($purchase_license_keys == "yes" && $state_fee_only && $totaltobecharged == 0){
	echo "<form action='receipt2016.php' method='post' id='frm1' name='frm1'>";
	echo "<INPUT TYPE='hidden' NAME='x_response_code' VALUE='1'>";
	echo "<INPUT TYPE='hidden' NAME='x_trans_id' VALUE='state_fee_only'>";
}
else{
	echo "<form action='sc_auth_net_bridge2016.php' method='post' id='frm1' name='frm1'>";
}
?>



<INPUT TYPE="hidden" NAME="x_version" VALUE="3.1">
<INPUT TYPE="hidden" NAME="x_login" VALUE="1658573">
<INPUT TYPE="hidden" NAME="x_show_form" VALUE="PAYMENT_FORM">
<INPUT TYPE="hidden" NAME="x_method" VALUE="CC">
<INPUT TYPE="hidden" NAME="x_amount" VALUE="<?php echo $totaltobecharged;?>">
<INPUT TYPE="hidden" NAME="x_recurring_billing" VALUE="F">
<INPUT TYPE="hidden" NAME="ID" VALUE="<?php echo $TAPONUMsess. "|" .$totaltobecharged. "|" .$addSudentToCourse. "|" .$courseLanguage. "|" .$floridaLicense. "|" .$last4. "|" .$corporate_username. "|" .$Utah_Region. "|" .$Utah_gender. "|" .$Utah_County. "|" .$Utah_work_phone. "|" .$purchase_license_keys. "|" .$oh2_id;?>">

<INPUT TYPE="hidden" NAME="x_first_name" VALUE="<?php echo $cardfn;?>">
<INPUT TYPE="hidden" NAME="x_last_name" VALUE="<?php echo $cardln;?>">
<INPUT TYPE="hidden" NAME="x_address" VALUE="<?php echo $cardadd1;?>">
<INPUT TYPE="hidden" NAME="x_city" VALUE="<?php echo $cardci;?>">
<INPUT TYPE="hidden" NAME="x_state" VALUE="<?php echo $cardst;?>">
<INPUT TYPE="hidden" NAME="x_zip" VALUE="<?php echo $cardzip;?>">
<INPUT TYPE="hidden" NAME="x_country" VALUE="<?php echo $cardcou;?>">
<INPUT TYPE="hidden" NAME="x_email" VALUE="<?php echo $cardem;?>">
<INPUT TYPE="hidden" NAME="x_company" VALUE="<?php echo $cardcn;?>">
<INPUT TYPE="hidden" NAME="x_phone" VALUE="<?php echo $cardphone;?>">
<INPUT TYPE="hidden" NAME="x_invoice_num" VALUE="<?php echo $ONUM;?>">
<INPUT TYPE="hidden" NAME="x_description" VALUE="<?php echo $productsname[0] ." ".$productsname[1]." ".$productsname[2];?>">




</form>


</body>


<script>

function load(){
	document.frm1.submit()
}

</script>

</html>
