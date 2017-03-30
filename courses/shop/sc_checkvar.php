<?php
error_reporting(0); 

$user=$_SERVER['DB_USERNAME'];
$password=$_SERVER['DB_PASSWORD'];
$server=$_SERVER['DB_HOSTNAME'];
$database='newtap';
$con = mssql_connect($server,$user,$password) or die('Could not connect to the server!');
mssql_select_db($database, $con) or die('Could not select a database.'); 


	//gets all ProID values and stores it in an array
	$SQL0 = "SELECT ProID FROM [07DS2] ";		
	$resultset0=mssql_query($SQL0, $con); 
	
		while ($row = mssql_fetch_array($resultset0)) 
		{			
			 $ProIDDB[] = $row['ProID'];					
		}	



session_start();
$checkfn = $_SESSION["checkfn"];
$checkln = $_SESSION["checkln"];
$checkcn = $_SESSION["checkcn"];
$checkadd1 = $_SESSION["checkadd1"];
$checkadd2 = $_SESSION["checkadd2"];
$checkci = $_SESSION["checkci"];
$checkst = $_SESSION["checkst"];
$checkzip = $_SESSION["checkzip"];
$checkcou = $_SESSION["checkcou"];
$checkphone = $_SESSION["checkphone"];
$checkem = $_SESSION["checkem"];


$productsname = $_SESSION["productsname"] ;
$discode = $_SESSION["discode"] ;
$ONUMsess = $_SESSION["ONUM"] ;
$TAPONUMsess = $_SESSION["TAPONUM"] ;

$previousun = $_SESSION["previousun"] ;
$previouspw = $_SESSION["previouspw"] ;

$totaltobecharged = $_POST["totaltobecharged"];
$newusername = $_SESSION["newusername"] ;
$newpassword = $_SESSION["newpassword"] ;

$existingusername = $_SESSION["existingusername"] ;
$existingpassword = $_SESSION["existingpassword"] ;

$corporate_username=$_SESSION["corporate_username"];
$corpVC=$_SESSION["corpVC"];

if($corporate_username && $corpVC)
	{
		
			if($ONUMsess=='')
			{

				echo "corp ONUMsess==''";
				
				//************ 07O2 Invoice info  ******************************************
				
				$SQL1 = "INSERT INTO [07O2] (AN) VALUES ('$corporate_username') ";
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

				$SQL3 = "UPDATE [07O2] SET OID='$TAPONUM', DO='$todaytime', PAY='check', TC='$totaltobecharged', VC='$corpVC' WHERE ONUM=$ONUM ";	
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
					
					$SQL4 = "INSERT INTO [07O4] (OID, PC, PN, PRI, NO) 
					VALUES ('$TAPONUM', '$session[2]', '$session[0]', '$session[3]', '$session[1]') ";
					$resultset4=mssql_query($SQL4, $con);
				}			

			}
						
			else
			{
				$ONUM = $ONUMsess;
				
				//************ 07O2 information  ******************************************
				
				$SQL6 = "UPDATE [07O2] SET AN='$corporate_username', PAY='check',  TC='$totaltobecharged' WHERE OID='$TAPONUMsess' ";	
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
					
					$SQL8 = "INSERT INTO [07O4] (OID, PC, PN, PRI, NO) 
					VALUES ('$TAPONUMsess', '$session[2]', '$session[0]', '$session[3]', '$session[1]') ";
					$resultset8=mssql_query($SQL8, $con);
				}
				
			}

			
			//******************** 07L2 corporate info table (updates every time user visits page)  **************************************

				$SQL33 = "UPDATE [07L2] SET NF='$cardfn', NL='$cardln', UA='$cardcn', AA1='$cardadd1', AA2='$cardadd2', ACI='$cardci', AST='$cardst', AZ='$cardzip', ACO='$cardcou', AP='$cardphone', UM='$cardem' WHERE UU='$corporate_username' ";	
				$resultset98=mssql_query($SQL33, $con);
		
	}

else{
	// NEW CUSTOMERS !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

	if($newusername && $existingusername=="")
	{
		if($ONUMsess=='')
		{
			//************ 07O2 Invoice info  ******************************************
			
			
			$SQL1 = "INSERT INTO [07O2] (AN) VALUES ('$newusername') ";
			$resultset1=mssql_query($SQL1, $con); 	

			$SQL2 = "SELECT * FROM [07O2] WHERE AN='$newusername' ";		
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
				$SQL3 = "UPDATE [07O2] SET OID='$TAPONUM', DO='$todaytime', PAY='check', TC='$totaltobecharged', VC='$discode' WHERE ONUM=$ONUM ";	
				$resultset3=mssql_query($SQL3, $con);		
			}
			else
			{
				$SQL3 = "UPDATE [07O2] SET OID='$TAPONUM', DO='$todaytime', PAY='check', TC='$totaltobecharged' WHERE ONUM=$ONUM ";
				$resultset3=mssql_query($SQL3, $con);			
			}
			
			
			
			//***************** 07O4 Purchase info QTY ***************************************
			
			
			
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
				
				$SQL4 = "INSERT INTO [07O4] (OID, PC, PN, PRI, NO) 
				VALUES ('$TAPONUM', '$session[2]', '$session[0]', '$session[3]', '$session[1]') ";
				$resultset4=mssql_query($SQL4, $con);
			 }

			
			
			
			//***************** 07L3 Account Username and Password  *****************************	

			
			$SQL5 = "INSERT INTO [07L3] (AN, AC, CTRLEXAM, VC, TRAIN_PERIOD, FORCECOR) 
			VALUES ('$newusername', '$newpassword', '1', '$discode', '180', '1') ";
			$resultset5=mssql_query($SQL5, $con);
			
			$_SESSION["previousun"] = $newusername;
			$_SESSION["previouspw"] = $newpassword;

			
		}
					
		else
		{
			$ONUM = $ONUMsess;
			
			//************ 07O2 information  ******************************************
			
			$SQL6 = "UPDATE [07O2] SET AN='$newusername', PAY='check', TC='$totaltobecharged' WHERE OID='$TAPONUMsess' ";	
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
				
				$SQL8 = "INSERT INTO [07O4] (OID, PC, PN, PRI, NO) 
				VALUES ('$TAPONUMsess', '$session[2]', '$session[0]', '$session[3]', '$session[1]') ";
				$resultset8=mssql_query($SQL8, $con);
			 }

			
			
			//***************** 07L3 information ***************************************	

			
			if($newusername != $previousun || $newpassword != $previouspw)
			{
				
				$SQL9 = "UPDATE [07L3] SET AN='$newusername', AC='$newpassword' WHERE AN='$previousun' ";	
				$resultset9=mssql_query($SQL9, $con);
					
					$_SESSION["previousun"] = $newusername;
					$_SESSION["previouspw"] = $newpassword;
			}
			
		}

	



		
		//******************** 07O1 billing information, INSERT if not found, UPDATE if found   **************************************

		$SQL99 = "SELECT * FROM [07O1] WHERE AN='$newusername' ";
		$resultset99=mssql_query($SQL99, $con);

		while ($row = mssql_fetch_array($resultset99)) 
			{
				$t07O1AN = $row['AN'];
			}  

		
		$NCON07O1 = $checkfn . " " . $checkln;
		$DIV_NAME07O1 = $checkfn . "_" . $checkln;
		
		if($t07O1AN)
		{
			$SQL98 = "UPDATE [07O1] SET NCON='$NCON07O1', NCPY='$checkcn', AA1='$checkadd1', AA2='$checkadd2', ACI='$checkci', AST='$checkst', AZ='$checkzip', ACO='$checkcou', AP='$checkphone', AM='$checkem', DIV_NAME='$DIV_NAME07O1' WHERE AN='$newusername' ";	
			$resultset98=mssql_query($SQL98, $con);
		}
		else
		{		
			$SQL97 = "INSERT INTO [07O1] (AN, NCON, NCPY, AA1, AA2, ACI, AST, AZ, ACO, AP, AM, DIV_NAME) 
			VALUES ('$newusername', '$NCON07O1', '$checkcn', '$checkadd1', '$checkadd2', '$checkci', '$checkst', '$checkzip', '$checkcou', '$checkphone', '$checkem', '$DIV_NAME07O1') ";
			$resultset97=mssql_query($SQL97, $con);

		}
		
		//******************** 07O6 user information, INSERT if not found, UPDATE if found   **************************************
		
		$SQL96 = "SELECT * FROM [07O6] WHERE AN='$newusername' ";
		$resultset96=mssql_query($SQL96, $con);

		while ($row = mssql_fetch_array($resultset96)) 
			{
				$t07O6AN = $row['AN'];
			}  
		//$t07O6AN= odbc_result($resultset96, AN);
		
		$NCON07O6 = $checkfn . " " . $checkln;
		$DIV_NAME07O6 = $checkfn . "_" . $checkln;
		
		if($t07O6AN)
		{
			$SQL95 = "UPDATE [07O6] SET NCON='$NCON07O6', NCPY='$checkcn', AA1='$checkadd1', AA2='$checkadd2', ACI='$checkci', AST='$checkst', AZ='$checkzip', ACO='$checkcou', AP='$checkphone', AM='$checkem', NF='$checkfn', NL='$checkln', DIV_NAME='$DIV_NAME07O6' WHERE AN='$newusername' ";	
			$resultset95=mssql_query($SQL95, $con);
		}
		else
		{
			$SQL94 = "INSERT INTO [07O6] (AN, NCON, NCPY, AA1, AA2, ACI, AST, AZ, ACO, AP, AM, NF, NL, DIV_NAME) 
			VALUES ('$newusername', '$NCON07O6', '$checkcn', '$checkadd1', '$checkadd2', '$checkci', '$checkst', '$checkzip', '$checkcou', '$checkphone', '$checkem', '$checkfn', '$checkln', '$DIV_NAME07O6') ";
			$resultset94=mssql_query($SQL94, $con);
		}


		// Check if Account Name was Inserted on 07DS1 (license table) previously, if not Insert it, once we receive check we will add license to this table
		$SQL44 = "SELECT UA FROM [07DS1] WHERE UA='$newusername' ";
		$resultset44=mssql_query($SQL44, $con);

		while ($row = mssql_fetch_array($resultset44)) 
			{
				$t07DS1 = $row['UA'];
			}  

		if($t07DS1=="")
		{	
		$SQL45 = "INSERT INTO [07DS1] (UA) 
			VALUES ('$newusername') ";
			$resultset45=mssql_query($SQL45, $con);
		}	

	
	}
	

	
	// EXISTING CUSTOMERS !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

	if($existingusername && $newusername=="")
	{
		if($ONUMsess=='')
		{
			//************ 07O2 information  ******************************************
			
			
			$SQL1 = "INSERT INTO [07O2] (AN) VALUES ('$existingusername') ";
			$resultset1=mssql_query($SQL1, $con); 	

			$SQL2 = "SELECT ONUM FROM [07O2] WHERE AN='$existingusername' ORDER BY ONUM ASC";		
			$resultset2=mssql_query($SQL2, $con);

			while ($row = mssql_fetch_array($resultset2)) 
			{
				$ONUM = $row['ONUM'];
			} 
			//$ONUM= odbc_result($resultset2, ONUM);
			
			$_SESSION["ONUM"] = $ONUM;
			
			//echo $ONUM;
			//echo "<br>";
			
			$TAP='TAP0';
			$TAPONUM=$TAP.$ONUM;
			
			$_SESSION["TAPONUM"] = $TAPONUM;
			
			//echo $TAPONUM;
			
			//echo date("Y-m-d h:i:s");
			$todaytime = date("Y-m-d h:i:s");
			//echo $todaytime;
			
			if($discode)
			{
			$SQL3 = "UPDATE [07O2] SET OID='$TAPONUM', DO='$todaytime', PAY='check', TC='$totaltobecharged', VC='$discode' WHERE ONUM=$ONUM ";	
			$resultset3=mssql_query($SQL3, $con);		
			}
			else
			{
				$SQL3 = "UPDATE [07O2] SET OID='$TAPONUM', DO='$todaytime', PAY='check', TC='$totaltobecharged' WHERE ONUM=$ONUM ";
				$resultset3=mssql_query($SQL3, $con);			
			}
			
			
			
			//***************** 07O4 information total price per course  ***************************************
			
			
			
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
				
				$SQL4 = "INSERT INTO [07O4] (OID, PC, PN, PRI, NO) 
				VALUES ('$TAPONUM', '$session[2]', '$session[0]', '$session[3]', '$session[1]') ";
				$resultset4=mssql_query($SQL4, $con);
			 }

			
			
			
			//***************** 07L3 Account Username and Password  *****************************	
			// NO INSERTING OR UPDATING 07L3 BECAUSE THE ACCOUNT EXISTS ALREADY


		}
					
		else
		{
			$ONUM = $ONUMsess;
			
			//************ 07O2 information  ******************************************
			
			$SQL6 = "UPDATE [07O2] SET AN='$existingusername', PAY='check', TC='$totaltobecharged' WHERE OID='$TAPONUMsess' ";	
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
				
				$SQL8 = "INSERT INTO [07O4] (OID, PC, PN, PRI, NO) 
				VALUES ('$TAPONUMsess', '$session[2]', '$session[0]', '$session[3]', '$session[1]') ";
				$resultset8=mssql_query($SQL8, $con);
			 }

			
			
			//***************** 07L3 information ***************************************	
			// WE WON'T use this table because the account exists already

			
		
			
		}

	



		
		//******************** 07O1 billing information, INSERT if not found, UPDATE if found   **************************************

		$SQL99 = "SELECT * FROM [07O1] WHERE AN='$existingusername' ";
		$resultset99=mssql_query($SQL99, $con);

		while ($row = mssql_fetch_array($resultset99)) 
			{
				$t07O1AN = $row['AN'];
			} 
		//$t07O1AN= odbc_result($resultset99, AN);
		
		$NCON07O1 = $checkfn . " " . $checkln;
		$DIV_NAME07O1 = $checkfn . "_" . $checkln;
		
		
		// if card info exists
		if($t07O1AN)
		{

			$SQL98 = "UPDATE [07O1] SET NCON='$NCON07O1', NCPY='$checkcn', AA1='$checkadd1', AA2='$checkadd2', ACI='$checkci', AST='$checkst', AZ='$checkzip', ACO='$checkcou', AP='$checkphone', AM='$checkem', DIV_NAME='$DIV_NAME07O1' WHERE AN='$existingusername' ";	
			$resultset98=mssql_query($SQL98, $con);
		}
		
		//if card info doesn't exist
		else
		{		
			$SQL97 = "INSERT INTO [07O1] (AN, NCON, NCPY, AA1, AA2, ACI, AST, AZ, ACO, AP, AM, DIV_NAME) 
			VALUES ('$existingusername', '$NCON07O1', '$checkcn', '$checkadd1', '$checkadd2', '$checkci', '$checkst', '$checkzip', '$checkcou', '$checkphone', '$checkem', '$DIV_NAME07O1') ";
			$resultset97=mssql_query($SQL97, $con);

		}
		
		//******************** 07O6 user information, INSERT if not found, UPDATE if found   **************************************
		
		$SQL96 = "SELECT * FROM [07O6] WHERE AN='$existingusername' ";
		$resultset96=mssql_query($SQL96, $con);

		while ($row = mssql_fetch_array($resultset96)) 
			{
				$t07O6AN = $row['AN'];
			}
		
		$NCON07O6 = $checkfn . " " . $checkln;
		$DIV_NAME07O6 = $checkfn . "_" . $checkln;
					
		//if user info exists
		if($t07O6AN)
		{
			
			$SQL95 = "UPDATE [07O6] SET NCON='$NCON07O6', NCPY='$checkcn', AA1='$checkadd1', AA2='$checkadd2', ACI='$checkci', AST='$checkst', AZ='$checkzip', ACO='$checkcou', AP='$checkphone', AM='$checkem', NF='$checkfn', NL='$checkln', DIV_NAME='$DIV_NAME07O6' WHERE AN='$existingusername' ";	
			$resultset95=mssql_query($SQL95, $con);
		}
		//if user info doesn't exist
		else
		{
			$SQL94 = "INSERT INTO [07O6] (AN, NCON, NCPY, AA1, AA2, ACI, AST, AZ, ACO, AP, AM, NF, NL, DIV_NAME) 
			VALUES ('$existingusername', '$NCON07O6', '$checkcn', '$checkadd1', '$checkadd2', '$checkci', '$checkst', '$checkzip', '$checkcou', '$checkphone', '$checkem', '$checkfn', '$checkln', '$DIV_NAME07O6') ";
			$resultset94=mssql_query($SQL94, $con);
		}
	
	}
	
	

}			
		
	
	

//print_r($_SESSION);

header('Location: sc_check.php');
?>








