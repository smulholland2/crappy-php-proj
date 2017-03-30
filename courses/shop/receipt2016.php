<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/lib/Mailer.php';
include_once $_SERVER["DOCUMENT_ROOT"]."/config/connection.php";

error_reporting(0); 

$user=$_SERVER['DB_USERNAME'];
$password=$_SERVER['DB_PASSWORD'];
$server=$_SERVER['DB_HOSTNAME'];
$database='newtap';
$con = mssql_connect($server,$user,$password);
mssql_select_db($database, $con); 

$x_response_code = $_POST['x_response_code'];

$ID = $_POST['ID'];

$TRANSID = $_POST['x_trans_id'];

$IDparts = explode("|", $ID);
$IDparts[0];	//TAPONUM

$IDparts[1];	//totaltobecharged

$IDparts[2];	//addSudentToCourse

$IDparts[3];	//courseLanguage

if($IDparts[3] == ""){
$IDparts[3] = "ENGLISH";
}

$IDparts[4];	//floridaLicense

$IDparts[5];	//last4

$IDparts[6];	//corporate_username, if not empty it means theyre purchasing courses by going to corp admin place orders page

$IDparts[7];	//utah_Region

$IDparts[8];	//utah_gender

$IDparts[9];	//utah_County

$IDparts[10];	//Utah_work_phone

$IDparts[11];	//purchase_license_keys

$IDparts[12];	//oh2_id

$todaytime = date("Y-m-d");
$todaytime;

$todaydate = date("Y-m-d");

if($x_response_code == 1 )
{
	// Update Invoice info table
	$SQL0="UPDATE [07O2]
		SET PAY='credit', AREC='$IDparts[1]', VSTAT=1, TRANSID='$TRANSID'
		WHERE OID='$IDparts[0]' ";

	$resultset0=mssql_query($SQL0, $con);

	$SQL3="SELECT AN FROM [07O2] WHERE OID='$IDparts[0]' ";
	$resultset3=mssql_query($SQL3, $con);

	while ($row = mssql_fetch_array($resultset3)) 
	{
		$AN = $row['AN'];
	}

	// selects the courses and the QTY purchased from the invoice number
	$SQL1="SELECT PC, NO FROM [07O4] WHERE OID='$IDparts[0]' ";
	$resultset1=mssql_query($SQL1, $con); 

	while ($row = mssql_fetch_array($resultset1)) 
	{
		$PC = $row['PC'];

		$NO = $row['NO'];
			
		if($IDparts[11] == "yes")
		{
			$loopLK=1;
				while($loopLK <= $NO) 
				{
					$LKstr="LK";

					if($PC=="ilfsh")
					{
						$PC_abbrev="IL";
					}
					if($PC=="fs")
					{
						$PC_abbrev="FS";
					}
					if($PC=="aa")
					{
						$PC_abbrev="AA";
					}
					if($PC=="ad")
					{
						$PC_abbrev="AD";
					}
					if($PC=="as")
					{
						$PC_abbrev="AS";
					}
					if($PC=="alc")
					{
						$PC_abbrev="AL";
					}
					if($PC=="akan")
					{
						$PC_abbrev="AK";
					}
					if($PC=="califsh")
					{
						$PC_abbrev="CA";
					}
					if($PC=="casd")
					{
						$PC_abbrev="SD";
					}
					if($PC=="azfsh")
					{
						$PC_abbrev="AZ";
					}
					if($PC=="flfsh")
					{
						$PC_abbrev="FL";
					}
					// FH all other states
					if($PC=="nfon")
					{
						$PC_abbrev="FH";
					}
					if($PC=="idfsh")
					{
						$PC_abbrev="ID";
					}
					if($PC=="mofsh")
					{
						$PC_abbrev="JC";
					}
					if($PC=="nmfsh")
					{
						$PC_abbrev="NM";
					}
					// Norfolk VA FH
					if($PC=="vaccfsh")
					{
						$PC_abbrev="VA";
					}
					if($PC=="ohfsh")
					{
						$PC_abbrev="OH";
					}
					if($PC=="txfsh")
					{
						$PC_abbrev="TX";
					}
					// Wichita KA FH
					if($PC=="ksfsh")
					{
						$PC_abbrev="KS";
					}
					//Retail FSM
					if($PC=="fsrt")
					{
						$PC_abbrev="RE";
					}
					if($PC=="cb" || $PC=="cf")
					{
						$PC_abbrev="CB";
					}
					if($PC=="emws")
					{
						$PC_abbrev="EM";
					}
					if($PC=="nhaccp")
					{
						$PC_abbrev="HA";
					}
					if($PC=="sfis")
					{
						$PC_abbrev="ST";
					}
						
					do
					{	
						$length = 4;
						$randomString = substr(str_shuffle("0123456789ABCDEFGHJKMNPQRSTUVWXYZ0123456789ABCDEFGHJKMNPQRSTUVWXYZ0123456789ABCDEFGHJKMNPQRSTUVWXYZ0123456789ABCDEFGHJKMNPQRSTUVWXYZ"), 0, $length);

							$LK_SERIAL = $LKstr.$PC_abbrev.$randomString;

						$SQL63="SELECT SERIAL FROM SerialNumber WHERE SERIAL='$LK_SERIAL' ";
						$resultset63=mssql_query($SQL63, $con); 
						while ($row = mssql_fetch_array($resultset63)) 
							{
								$SERIAL_taken = $row['SERIAL'];
							}
					}
					while	($SERIAL_taken);


					$SQL44 = "INSERT INTO SerialNumber (SERIAL, ACTIVATED, ACCOUNT_NAME, DATE_CREATED) 
					VALUES ('$LK_SERIAL', '0', '$AN', '$todaydate') ";
					$resultset44=mssql_query($SQL44, $con);

					$LK_created[] = $LK_SERIAL;
					$LK_created_string = rtrim(implode('<br>', $LK_created), ',');
					$loopLK++;
				}

			}
			else
			{
				$context = new Db();

				$productIdQuery = "SELECT [id],[JobType],[TableCode] FROM [07DS2] WHERE ProID = '" . $PC . "'";				 

				$product = $context->RunQuery($productIdQuery);

				$addstudTable = $product['TableCode'];

				$licenseQuery = "SELECT * FROM [Licenses] WHERE [UserId] = '" .$AN. "' AND [ProductId] = ".$product['id'];

				//die($licenseQuery);

				$license = $context->RunQuery($licenseQuery);

				//die(var_dump($license));

				if(count($license) != 0)
				{
					if(count($license['LicensesRemaining']) > 0)
					{
						$newLicenseTotal = $NO + $license['LicensesRemaining'];
						$newLicenseQuery = "UPDATE [Licenses] SET [LicensesRemaining] = ".$newLicenseTotal. " WHERE [LicenseID] = ".$license['LicenseID'];
					}
				}
				else
				{
					$newLicenseTotal = $NO;
					$newLicenseQuery = "INSERT INTO [Licenses] VALUES ('" .$AN. "',".$product['id'].",".$newLicenseTotal.")";
				}

				$newLicenseResult = $context->RunInsert($newLicenseQuery);
				$ME = $product['JobType'];

			} // closes license key else
			
		}		
			
			
			// if single purchase, student is taking the course and courses purchased is one, add student automatically
			if($IDparts[2]=='yes')
			{
				$SQL95="SELECT AC, VC, TRAIN_PERIOD FROM [07L3] WHERE AN='$AN' ";
				$resultset95=mssql_query($SQL95, $con);
			
				while ($row = mssql_fetch_array($resultset95)) 
				{
						$UC = $row['AC'];
						$VC = $row['VC'];
						$TRAIN_PERIOD = $row['TRAIN_PERIOD'];
				}

				$expDate = date('Y-m-d h:i:s', strtotime($todaytime . " + $TRAIN_PERIOD day"));

				$SQL94="SELECT DIV_NAME, AM FROM [07O6] WHERE AN='$AN' ";
				$resultset94=mssql_query($SQL94, $con); 
			
				while ($row = mssql_fetch_array($resultset94)) 
				{
						$DIV_NAME = $row['DIV_NAME'];
						$AM = $row['AM'];
				}

				$StudName = explode("_", $DIV_NAME);
				$StudName[0];	//FirstName
				$StudName[1];	//LastName

				//-------------- BELOW THE STUDENT IS ADDED TO THE SPECIFIC COURSE ---------------- //

				// West Virginia 
				if ($PC=='WVMV' OR $PC == "WVBA" OR $PC == "WVCH" OR $PC == "WVMN" OR $PC == "WVPE" OR $PC == "WVPO" OR $PC == "WVUP" OR $PC == "WVWA" OR $PC == "WVOH" OR $PC == "WVRN")
				{
					$WV_region = $PC;

					if($PC=='WVMV' )
					{
						$WV_region = "WVMV";
					}

						if($PC=='WVMV' OR $PC=='WVPE')
						{
							$WV_version ="FS6H";
						}
						else
						{
							$WV_version ="FS6";
						}

					$SQL96 = "INSERT INTO [01D] (UU, UA, UC, NF, NL, ME, ES, FIN, DA, UM, REGION, VER) 
						VALUES (".mssql_escape($AN).", ".mssql_escape($AN).", ".mssql_escape($UC).", ".mssql_escape($StudName[0]).", ".mssql_escape($StudName[1]).", '$ME', '$IDparts[3]', '0', '$todaytime', '$AM', '$WV_region', '$WV_version') ";
					$resultset96=mssql_query($SQL96, $con);
					
					$SQL95 ="INSERT INTO [01S] (UU) VALUES (".mssql_escape($AN).") ";
					$resultset95=mssql_query($SQL95, $con);
					
					$SQL93="SELECT DOB FROM [07O6] WHERE AN='$AN' ";
					$resultset93=mssql_query($SQL93, $con);
					
					while ($row = mssql_fetch_array($resultset93)) 
					{
							$DOB = $row['DOB'];
					}
					
					$SQL92="INSERT INTO [01C] (UU, BD) VALUES (".mssql_escape($AN).", '$DOB') ";
					$resultset92=mssql_query($SQL92, $con);
				}
				
				// FSM
				elseif($PC=='fs' || $PC=='oh2')
				{
					
					if($IDparts[3]=='SPANISH')
					{
						$FSversion = 'FS8';
					}
					else
					{
						$FSversion = 'FS9';
					}

					$SQL96 = "INSERT INTO [01D] (UU, UA, UC, NF, NL, ME, ES, FIN, DA, UM, DATE_EXPIRE, VER) 
						VALUES (".mssql_escape($AN).", ".mssql_escape($AN).", ".mssql_escape($UC).", ".mssql_escape($StudName[0]).", ".mssql_escape($StudName[1]).", '$ME', '$IDparts[3]', '0', '$todaytime', '$AM', '$expDate', '$FSversion') ";
					$resultset96=mssql_query($SQL96, $con);
					
					$SQL95 ="INSERT INTO [01S] (UU) VALUES (".mssql_escape($AN).") ";
					$resultset95=mssql_query($SQL95, $con);
				}
				
				// RECERT
				elseif ($PC=='refs' || $PC=='remn' || $PC=='reri' || $PC=='ifl' || $PC=='rewi')
				{
					if($PC=='refs' || $PC=='remn' || $PC=='reri'){
						$IL_val = 22;
					}
					if($PC=='ifl'){
						$IL_val = 21;
					}
					if($PC=='rewi'){
						$IL_val = 23;
					}

					$SQL96 = "INSERT INTO [02D] (UU, UA, UC, NF, NL, ME, ES, FIN, DA, UM, IL, VER) 
						VALUES (".mssql_escape($AN).", ".mssql_escape($AN).", ".mssql_escape($UC).", ".mssql_escape($StudName[0]).", ".mssql_escape($StudName[1]).", '2', '$IDparts[3]', '0', '$todaytime', '$AM', '$IL_val', 'FS6') ";

					$resultset96=mssql_query($SQL96, $con);

					$SQL95 ="INSERT INTO [02S] (UU) VALUES (".mssql_escape($AN).") ";
					$resultset95=mssql_query($SQL95, $con);
				}

				// FH all other states
				elseif ($PC=='nfon')
				{
					$SQL96 = "INSERT INTO [01D] (UU, UA, UC, NF, NL, ME, ES, FIN, DA, UM, VER) 
						VALUES (".mssql_escape($AN).", ".mssql_escape($AN).", ".mssql_escape($UC).", ".mssql_escape($StudName[0]).", ".mssql_escape($StudName[1]).", '$ME', '$IDparts[3]', '0', '$todaytime', '$AM', 'FS9') ";

					$resultset96=mssql_query($SQL96, $con);

					$SQL95 ="INSERT INTO [01S] (UU) VALUES (".mssql_escape($AN).") ";
					$resultset95=mssql_query($SQL95, $con);

					$SQL93="SELECT DOB FROM [07O6] WHERE AN='$AN' ";
					$resultset93=mssql_query($SQL93, $con);
					while ($row = mssql_fetch_array($resultset93)) 
					{
						$DOB = $row['DOB'];
					}

					$SQL92="INSERT INTO [01C] (UU, BD) VALUES (".mssql_escape($AN).", '$DOB') ";
					$resultset92=mssql_query($SQL92, $con);
				}

				// California FH
				elseif ($PC=='califsh')
				{

					$SQL96 = "INSERT INTO [01D] (UU, UA, UC, NF, NL, ME, ES, FIN, DA, UM, REGION, VER) 
						VALUES (".mssql_escape($AN).", ".mssql_escape($AN).", ".mssql_escape($UC).", ".mssql_escape($StudName[0]).", ".mssql_escape($StudName[1]).", '$ME', '$IDparts[3]', '0', '$todaytime', '$AM', 'CAGEN', 'FS9') ";
						$resultset96=mssql_query($SQL96, $con);

					$SQL95 ="INSERT INTO [01S] (UU) VALUES (".mssql_escape($AN).") ";
					$resultset95=mssql_query($SQL95, $con);

					$SQL93="SELECT DOB FROM [07O6] WHERE AN='$AN' ";
					$resultset93=mssql_query($SQL93, $con);

					while ($row = mssql_fetch_array($resultset93)) 
					{
							$DOB = $row['DOB'];
					}

					$SQL92="INSERT INTO [01C] (UU, BD) VALUES (".mssql_escape($AN).", '$DOB') ";
					$resultset92=mssql_query($SQL92, $con);
				}

				// San Diego FH
				elseif ($PC=='casd')
				{		
					
					$SQL96 = "INSERT INTO [01D] (UU, UA, UC, NF, NL, ME, ES, FIN, DA, UM, REGION, VER) 
						VALUES (".mssql_escape($AN).", ".mssql_escape($AN).", ".mssql_escape($UC).", ".mssql_escape($StudName[0]).", ".mssql_escape($StudName[1]).", '$ME', '$IDparts[3]', '0', '$todaytime', '$AM', 'CASD', 'FS6H') ";
						$resultset96=mssql_query($SQL96, $con);
					
					$SQL95 ="INSERT INTO [01S] (UU) VALUES (".mssql_escape($AN).") ";
					$resultset95=mssql_query($SQL95, $con);
					
					$SQL93="SELECT DOB FROM [07O6] WHERE AN='$AN' ";
					$resultset93=mssql_query($SQL93, $con);
					
					while ($row = mssql_fetch_array($resultset93)) 
					{
							$DOB = $row['DOB'];
					}

					$SQL92="INSERT INTO [01C] (UU, BD) VALUES (".mssql_escape($AN).", '$DOB') ";
					$resultset92=mssql_query($SQL92, $con);

				}
				
				// Illinois FH
				elseif ($PC=='ilfsh')
				{
					 $SQL96 = "INSERT INTO [01D] (UU, UA, UC, NF, NL, ME, ES, FIN, DA, UM, REGION, VER) 
						VALUES (".mssql_escape($AN).", ".mssql_escape($AN).", ".mssql_escape($UC).", ".mssql_escape($StudName[0]).", ".mssql_escape($StudName[1]).", '$ME', '$IDparts[3]', '0', '$todaytime', '$AM', 'ILGEN', 'FS9') ";
						$resultset96=mssql_query($SQL96, $con);
					
					$SQL95 ="INSERT INTO [01S] (UU) VALUES (".mssql_escape($AN).") ";
					$resultset95=mssql_query($SQL95, $con);
					
					$SQL93="SELECT DOB FROM [07O6] WHERE AN='$AN' ";
					$resultset93=mssql_query($SQL93, $con);
					
						while ($row = mssql_fetch_array($resultset93)) 
						{
						     $DOB = $row['DOB'];
						}
					
					$SQL92="INSERT INTO [01C] (UU, BD) VALUES (".mssql_escape($AN).", '$DOB') ";
					$resultset92=mssql_query($SQL92, $con);
				}
				
				// Jackson County MO FH
				elseif ($PC=='mofsh')
				{
					$SQL96 = "INSERT INTO [01D] (UU, UA, UC, NF, NL, ME, ES, FIN, DA, UM, REGION, VER) 
						VALUES (".mssql_escape($AN).", ".mssql_escape($AN).", ".mssql_escape($UC).", ".mssql_escape($StudName[0]).", ".mssql_escape($StudName[1]).", '$ME', '$IDparts[3]', '0', '$todaytime', '$AM', 'MOGEN', 'FS9') ";
						$resultset96=mssql_query($SQL96, $con);
					
					$SQL95 ="INSERT INTO [01S] (UU) VALUES (".mssql_escape($AN).") ";
					$resultset95=mssql_query($SQL95, $con);
					
					$SQL93="SELECT DOB FROM [07O6] WHERE AN='$AN' ";
					$resultset93=mssql_query($SQL93, $con);
					
						while ($row = mssql_fetch_array($resultset93)) 
						{
						     $DOB = $row['DOB'];
						}
					
					$SQL92="INSERT INTO [01C] (UU, BD) VALUES (".mssql_escape($AN).", '$DOB') ";
					$resultset92=mssql_query($SQL92, $con);
				}
				
				// Arizona FH
				elseif ($PC=='azfsh')
				{
					$SQL96 = "INSERT INTO [01D] (UU, UA, UC, NF, NL, ME, ES, FIN, DA, UM, REGION, VER) 
						VALUES (".mssql_escape($AN).", ".mssql_escape($AN).", ".mssql_escape($UC).", ".mssql_escape($StudName[0]).", ".mssql_escape($StudName[1]).", '$ME', '$IDparts[3]', '0', '$todaytime', '$AM', 'AZGEN', 'FS9') ";
						$resultset96=mssql_query($SQL96, $con);
					
					$SQL95 ="INSERT INTO [01S] (UU) VALUES (".mssql_escape($AN).") ";
					$resultset95=mssql_query($SQL95, $con);
					
					$SQL93="SELECT DOB FROM [07O6] WHERE AN='$AN' ";
					$resultset93=mssql_query($SQL93, $con);
					
						while ($row = mssql_fetch_array($resultset93)) 
						{
						     $DOB = $row['DOB'];
						}
					
					$SQL92="INSERT INTO [01C] (UU, BD) VALUES (".mssql_escape($AN).", '$DOB') ";
					$resultset92=mssql_query($SQL92, $con);
				}

				// Alaska, Anchorage FH
				elseif ($PC=='akan')
				{
					$SQL96 = "INSERT INTO [01D] (UU, UA, UC, NF, NL, ME, ES, FIN, DA, UM, REGION, VER) 
						VALUES (".mssql_escape($AN).", ".mssql_escape($AN).", ".mssql_escape($UC).", ".mssql_escape($StudName[0]).", ".mssql_escape($StudName[1]).", '$ME', '$IDparts[3]', '0', '$todaytime', '$AM', 'AKAN', 'FS9') ";
						$resultset96=mssql_query($SQL96, $con);
					
					$SQL95 ="INSERT INTO [01S] (UU) VALUES (".mssql_escape($AN).") ";
					$resultset95=mssql_query($SQL95, $con);
					
					$SQL93="SELECT DOB FROM [07O6] WHERE AN='$AN' ";
					$resultset93=mssql_query($SQL93, $con);
					
						while ($row = mssql_fetch_array($resultset93)) 
						{
						     $DOB = $row['DOB'];
						}
					
					$SQL92="INSERT INTO [01C] (UU, BD) VALUES (".mssql_escape($AN).", '$DOB') ";
					$resultset92=mssql_query($SQL92, $con);
				}
				
				// New Mexico FH
				elseif ($PC=='nmfsh')
				{
					$SQL96 = "INSERT INTO [01D] (UU, UA, UC, NF, NL, ME, ES, FIN, DA, UM, VER) 
						VALUES (".mssql_escape($AN).", ".mssql_escape($AN).", ".mssql_escape($UC).", ".mssql_escape($StudName[0]).", ".mssql_escape($StudName[1]).", '$ME', '$IDparts[3]', '0', '$todaytime', '$AM', 'FS9') ";
						$resultset96=mssql_query($SQL96, $con);
					
					$SQL95 ="INSERT INTO [01S] (UU) VALUES (".mssql_escape($AN).") ";
					$resultset95=mssql_query($SQL95, $con);
					
					$SQL93="SELECT DOB FROM [07O6] WHERE AN='$AN' ";
					$resultset93=mssql_query($SQL93, $con);
					
						while ($row = mssql_fetch_array($resultset93)) 
						{
						     $DOB = $row['DOB'];
						}
					
					$SQL92="INSERT INTO [01C] (UU, BD) VALUES (".mssql_escape($AN).", '$DOB') ";
					$resultset92=mssql_query($SQL92, $con);
				}
				
				// Idaho FH
				elseif ($PC=='idfsh')
				{
					$SQL96 = "INSERT INTO [01D] (UU, UA, UC, NF, NL, ME, ES, FIN, DA, UM, VER) 
						VALUES (".mssql_escape($AN).", ".mssql_escape($AN).", ".mssql_escape($UC).", ".mssql_escape($StudName[0]).", ".mssql_escape($StudName[1]).", '$ME', '$IDparts[3]', '0', '$todaytime', '$AM', 'FS6') ";
						$resultset96=mssql_query($SQL96, $con);
					
					$SQL95 ="INSERT INTO [01S] (UU) VALUES (".mssql_escape($AN).") ";
					$resultset95=mssql_query($SQL95, $con);
					
					$SQL93="SELECT DOB FROM [07O6] WHERE AN='$AN' ";
					$resultset93=mssql_query($SQL93, $con);
					
						while ($row = mssql_fetch_array($resultset93)) 
						{
						     $DOB = $row['DOB'];
						}
					
					$SQL92="INSERT INTO [01C] (UU, BD) VALUES (".mssql_escape($AN).", '$DOB') ";
					$resultset92=mssql_query($SQL92, $con);
				}
				
				// Texas FH
				elseif ($PC=='txfsh')
				{
					$SQL96 = "INSERT INTO [01D] (UU, UA, UC, NF, NL, ME, ES, FIN, DA, UM, REGION, VER) 
						VALUES (".mssql_escape($AN).", ".mssql_escape($AN).", ".mssql_escape($UC).", ".mssql_escape($StudName[0]).", ".mssql_escape($StudName[1]).", '$ME', '$IDparts[3]', '0', '$todaytime', '$AM', '$VC', 'FS9') ";
						$resultset96=mssql_query($SQL96, $con);
					
					$SQL95 ="INSERT INTO [01S] (UU) VALUES (".mssql_escape($AN).") ";
					$resultset95=mssql_query($SQL95, $con);
					
					$SQL93="SELECT DOB FROM [07O6] WHERE AN='$AN' ";
					$resultset93=mssql_query($SQL93, $con);
					
						while ($row = mssql_fetch_array($resultset93)) 
						{
						     $DOB = $row['DOB'];
						}
					
					$SQL92="INSERT INTO [01C] (UU, BD) VALUES (".mssql_escape($AN).", '$DOB') ";
					$resultset92=mssql_query($SQL92, $con);
				}
				
				
				
				//	WEST VIRGINIA COURSES
				// NEED TO BE ADDED
				//
				// !!!!!!!!!!!!!!!!!!!!
				
				// Ohio Level One FH
				elseif ($PC=='ohfsh')
				{
					$SQL96 = "INSERT INTO [01D] (UU, UA, UC, NF, NL, ME, ES, FIN, DA, UM, REGION, VER) 
						VALUES (".mssql_escape($AN).", ".mssql_escape($AN).", ".mssql_escape($UC).", ".mssql_escape($StudName[0]).", ".mssql_escape($StudName[1]).", '$ME', '$IDparts[3]', '0', '$todaytime', '$AM', 'OHGEN', 'FS9') ";
						$resultset96=mssql_query($SQL96, $con);
					
					$SQL95 ="INSERT INTO [01S] (UU) VALUES (".mssql_escape($AN).") ";
					$resultset95=mssql_query($SQL95, $con);
					
					$SQL93="SELECT DOB FROM [07O6] WHERE AN='$AN' ";
					$resultset93=mssql_query($SQL93, $con);
					
						while ($row = mssql_fetch_array($resultset93)) 
						{
						     $DOB = $row['DOB'];
						}
					
					$SQL92="INSERT INTO [01C] (UU, BD) VALUES (".mssql_escape($AN).", '$DOB') ";
					$resultset92=mssql_query($SQL92, $con);
				}
				
				// Norfolk VA FH
				elseif ($PC=='vaccfsh')
				{
					$SQL96 = "INSERT INTO [01D] (UU, UA, UC, NF, NL, ME, ES, FIN, DA, UM, VER) 
						VALUES (".mssql_escape($AN).", ".mssql_escape($AN).", ".mssql_escape($UC).", ".mssql_escape($StudName[0]).", ".mssql_escape($StudName[1]).", '$ME', '$IDparts[3]', '0', '$todaytime', '$AM', 'FS9') ";
						$resultset96=mssql_query($SQL96, $con);
					
					$SQL95 ="INSERT INTO [01S] (UU) VALUES (".mssql_escape($AN).") ";
					$resultset95=mssql_query($SQL95, $con);
					
					$SQL93="SELECT DOB FROM [07O6] WHERE AN='$AN' ";
					$resultset93=mssql_query($SQL93, $con);
					
						while ($row = mssql_fetch_array($resultset93)) 
						{
						     $DOB = $row['DOB'];
						}
					
					$SQL92="INSERT INTO [01C] (UU, BD) VALUES (".mssql_escape($AN).", '$DOB') ";
					$resultset92=mssql_query($SQL92, $con);
				}
				
				// Retail FSM
				elseif ($PC=='fsrt' || $PC=='oh2rt')
				{
					$SQL96 = "INSERT INTO [01D] (UU, UA, UC, NF, NL, ME, ES, FIN, DA, UM, VER) 
						VALUES (".mssql_escape($AN).", ".mssql_escape($AN).", ".mssql_escape($UC).", ".mssql_escape($StudName[0]).", ".mssql_escape($StudName[1]).", '$ME', '$IDparts[3]', '0', '$todaytime', '$AM', 'FS9') ";
						$resultset96=mssql_query($SQL96, $con);
					
					$SQL95 ="INSERT INTO [01S] (UU) VALUES (".mssql_escape($AN).") ";
					$resultset95=mssql_query($SQL95, $con);
				}
				
				// Utah FH
				elseif ($PC=='utfsh')
				{
					$SQL96 = "INSERT INTO [01D] (UU, UA, UC, NF, NL, ME, ES, FIN, DA, UM, REGION, GENDER, VER) 
						VALUES (".mssql_escape($AN).", ".mssql_escape($AN).", ".mssql_escape($UC).", ".mssql_escape($StudName[0]).", ".mssql_escape($StudName[1]).", '$ME', '$IDparts[3]', '0', '$todaytime', '$AM', '$IDparts[7]', '$IDparts[8]', 'FS6H') ";
						$resultset96=mssql_query($SQL96, $con);

										
					$SQL95 ="INSERT INTO [01S] (UU) VALUES (".mssql_escape($AN).") ";
					$resultset95=mssql_query($SQL95, $con);
					
					$SQL93="SELECT DOB FROM [07O6] WHERE AN='$AN' ";
					$resultset93=mssql_query($SQL93, $con);
					
						while ($row = mssql_fetch_array($resultset93)) 
						{
						     $DOB = $row['DOB'];
						}
					
					$SQL92="INSERT INTO [01C] (UU, BD) VALUES (".mssql_escape($AN).", '$DOB') ";
					$resultset92=mssql_query($SQL92, $con);

					// Utah special table for Username, Work Phone and County	
					$SQL98 = "INSERT INTO [01D2] (UU, EWP, COUNTY) 
						VALUES (".mssql_escape($AN).", '$IDparts[10]', ".mssql_escape($IDparts[9]).") ";
						$resultset98=mssql_query($SQL98, $con);	
				}
				
				// Florida FH
				elseif ($PC=='flfsh')
				{
					$SQL96 = "INSERT INTO [01D] (UU, UA, UC, NF, NL, ME, ES, FIN, DA, UM, REGION, floridaLicense, VER) 
						VALUES (".mssql_escape($AN).", ".mssql_escape($AN).", ".mssql_escape($UC).", ".mssql_escape($StudName[0]).", ".mssql_escape($StudName[1]).", '$ME', '$IDparts[3]', '0', '$todaytime', '$AM', 'FLGEN', '$IDparts[4]', 'FS9') ";
						$resultset96=mssql_query($SQL96, $con);
					
					$SQL95 ="INSERT INTO [01S] (UU) VALUES (".mssql_escape($AN).") ";
					$resultset95=mssql_query($SQL95, $con);
					
					$SQL93="SELECT DOB FROM [07O6] WHERE AN='$AN' ";
					$resultset93=mssql_query($SQL93, $con);
					
						while ($row = mssql_fetch_array($resultset93)) 
						{
						     $DOB = $row['DOB'];
						}
					
					$SQL92="INSERT INTO [01C] (UU, BD) VALUES (".mssql_escape($AN).", '$DOB') ";
					$resultset92=mssql_query($SQL92, $con);
				}
				
				// Wichita FH
				elseif ($PC=='ksfsh')
				{
					$SQL96 = "INSERT INTO [01D] (UU, UA, UC, NF, NL, ME, ES, FIN, DA, UM, REGION, VER) 
						VALUES (".mssql_escape($AN).", ".mssql_escape($AN).", ".mssql_escape($UC).", ".mssql_escape($StudName[0]).", ".mssql_escape($StudName[1]).", '$ME', '$IDparts[3]', '0', '$todaytime', '$AM', 'KSGEN', 'FS9') ";
						$resultset96=mssql_query($SQL96, $con);
					
					$SQL95 ="INSERT INTO [01S] (UU) VALUES (".mssql_escape($AN).") ";
					$resultset95=mssql_query($SQL95, $con);
					
					$SQL93="SELECT DOB FROM [07O6] WHERE AN='$AN' ";
					$resultset93=mssql_query($SQL93, $con);
					
						while ($row = mssql_fetch_array($resultset93)) 
						{
						     $DOB = $row['DOB'];
						}
					
					$SQL92="INSERT INTO [01C] (UU, BD) VALUES (".mssql_escape($AN).", '$DOB') ";
					$resultset92=mssql_query($SQL92, $con);
				}
				
				// Tulsa FH
				elseif ($PC=='tufsh')
				{
					$SQL96 = "INSERT INTO [01D] (UU, UA, UC, NF, NL, ME, ES, FIN, DA, UM, REGION, VER) 
						VALUES (".mssql_escape($AN).", ".mssql_escape($AN).", ".mssql_escape($UC).", ".mssql_escape($StudName[0]).", ".mssql_escape($StudName[1]).", '$ME', '$IDparts[3]', '0', '$todaytime', '$AM', 'OKTU', 'FS9') ";
						$resultset96=mssql_query($SQL96, $con);
					
					$SQL95 ="INSERT INTO [01S] (UU) VALUES (".mssql_escape($AN).") ";
					$resultset95=mssql_query($SQL95, $con);
					
					$SQL93="SELECT DOB FROM [07O6] WHERE AN='$AN' ";
					$resultset93=mssql_query($SQL93, $con);
					
						while ($row = mssql_fetch_array($resultset93)) 
						{
						     $DOB = $row['DOB'];
						}
					
					$SQL92="INSERT INTO [01C] (UU, BD) VALUES (".mssql_escape($AN).", '$DOB') ";
					$resultset92=mssql_query($SQL92, $con);
				}
				
				// Earn More with Service
				elseif ($PC=='emws')
				{
					$SQL96 = "INSERT INTO [06D] (UU, UA, UC, NF, NL, ES, AL, JT, DA, UM) 
						VALUES (".mssql_escape($AN).", ".mssql_escape($AN).", ".mssql_escape($UC).", ".mssql_escape($StudName[0]).", ".mssql_escape($StudName[1]).", ".mssql_escape($IDparts[3]).", '1', 'All', '$todaytime', '$AM') ";
						$resultset96=mssql_query($SQL96, $con);
				}
				
				// Cooking Basics/Chef Fundamentals
				elseif ($PC=='cf' || $PC=='cb')
				{
					$SQL96 = "INSERT INTO [03D] (UU, UA, UC, NF, NL, ES, FIN, DA, UM, CF) 
						VALUES (".mssql_escape($AN).", ".mssql_escape($AN).", ".mssql_escape($UC).", ".mssql_escape($StudName[0]).", ".mssql_escape($StudName[1]).", '$IDparts[3]', '0', '$todaytime', '$AM', '1') ";
						$resultset96=mssql_query($SQL96, $con);
					
					$SQL95 ="INSERT INTO [03S] (UU) VALUES (".mssql_escape($AN).") ";
					$resultset95=mssql_query($SQL95, $con);
				}
				
				// Allergen Awareness
				elseif ($PC=='aa')
				{
				
				
				
					$SQL96 = "INSERT INTO [09D] (UU, UA, UC, NF, NL, ES, FIN, DA, UM) 
						VALUES (".mssql_escape($AN).", ".mssql_escape($AN).", ".mssql_escape($UC).", ".mssql_escape($StudName[0]).", ".mssql_escape($StudName[1]).", '$IDparts[3]', '0', '$todaytime', '$AM') ";
						$resultset96=mssql_query($SQL96, $con);
				
				
					
					$SQL95 ="INSERT INTO [09S] (UU) VALUES (".mssql_escape($AN).") ";
					$resultset95=mssql_query($SQL95, $con);
				
					
					$SQL93="SELECT DOB FROM [07O6] WHERE AN='$AN' ";
					$resultset93=mssql_query($SQL93, $con);
					
						while ($row = mssql_fetch_array($resultset93)) 
						{
						     $DOB = $row['DOB'];
						}
					
					$SQL92="INSERT INTO [01C] (UU, BD) VALUES (".mssql_escape($AN).", '$DOB') ";
					$resultset92=mssql_query($SQL92, $con);
				
				
				
				}

				// Alcohol
				elseif ($PC=='alc')
				{
				
				
				
					$SQL96 = "INSERT INTO [12D] (UU, UA, UC, NF, NL, ES, FIN, DA, UM) 
						VALUES (".mssql_escape($AN).", ".mssql_escape($AN).", ".mssql_escape($UC).", ".mssql_escape($StudName[0]).", ".mssql_escape($StudName[1]).", 'ENGLISH', '0', '$todaytime', '$AM') ";
						$resultset96=mssql_query($SQL96, $con);
				
				
					
					$SQL95 ="INSERT INTO [12S] (UU) VALUES (".mssql_escape($AN).") ";
					$resultset95=mssql_query($SQL95, $con);
				
					
					$SQL93="SELECT DOB FROM [07O6] WHERE AN='$AN' ";
					$resultset93=mssql_query($SQL93, $con);
					
						while ($row = mssql_fetch_array($resultset93)) 
						{
						     $DOB = $row['DOB'];
						}
					
					$SQL92="INSERT INTO [12C] (UU, BD) VALUES (".mssql_escape($AN).", '$DOB') ";
					$resultset92=mssql_query($SQL92, $con);
				
				
				
				}
				
				// HACCP, SFIS,Allergen Plan Development, Allergen Plan Specialist
				else
				{

					if($PC=='nhaccp'){
						$SQL96 = "INSERT INTO [$addstudTable] (UU, UA, UC, NF, NL, ES, FIN, DA, UM, VER) 
						VALUES (".mssql_escape($AN).", ".mssql_escape($AN).", ".mssql_escape($UC).", ".mssql_escape($StudName[0]).", ".mssql_escape($StudName[1]).", 'ENGLISH', '0', '$todaytime', '$AM', 'H8') ";
						$resultset96=mssql_query($SQL96, $con);
					}
					else{
						$SQL96 = "INSERT INTO [$addstudTable] (UU, UA, UC, NF, NL, ES, FIN, DA, UM) 
						VALUES (".mssql_escape($AN).", ".mssql_escape($AN).", ".mssql_escape($UC).", ".mssql_escape($StudName[0]).", ".mssql_escape($StudName[1]).", 'ENGLISH', '0', '$todaytime', '$AM') ";
						$resultset96=mssql_query($SQL96, $con);
					}

					
					if($PC=='nhaccp')
					{
						$SQL95 ="INSERT INTO [04S] (UU) VALUES (".mssql_escape($AN).") ";
						$resultset95=mssql_query($SQL95, $con);
					}
					if($PC=='sfis')
					{
						$SQL95 ="INSERT INTO [05S] (UU) VALUES (".mssql_escape($AN).") ";
						$resultset95=mssql_query($SQL95, $con);
					}
					if($PC=='ad')
					{
						$SQL95 ="INSERT INTO [10S] (UU) VALUES (".mssql_escape($AN).") ";
						$resultset95=mssql_query($SQL95, $con);

						$SQL93="SELECT DOB FROM [07O6] WHERE AN='$AN' ";
						$resultset93=mssql_query($SQL93, $con);
						while ($row = mssql_fetch_array($resultset93)) 
						{
							$DOB = $row['DOB'];
						}
						
						$SQL92="INSERT INTO [01C] (UU, BD) VALUES (".mssql_escape($AN).", '$DOB') ";
						$resultset92=mssql_query($SQL92, $con);
					}
					if($PC=='as')
					{
						$SQL95 ="INSERT INTO [11S] (UU) VALUES (".mssql_escape($AN).") ";
						$resultset95=mssql_query($SQL95, $con);

						$SQL93="SELECT DOB FROM [07O6] WHERE AN='$AN' ";
						$resultset93=mssql_query($SQL93, $con);
						while ($row = mssql_fetch_array($resultset93)) 
						{
							$DOB = $row['DOB'];
						}
						
						$SQL92="INSERT INTO [01C] (UU, BD) VALUES (".mssql_escape($AN).", '$DOB') ";
						$resultset92=mssql_query($SQL92, $con);
					}
					
					
				}
				
				
	//------- This will get the current number of licenses then it will subtract one license because the student was registered			
				
				//get # of licenses
				/*$SQL91="SELECT $numbCourses FROM [$table] WHERE UA='$AN' ";
					$resultset91=mssql_query($SQL91, $con); 
				
					while ($row = mssql_fetch_array($resultset91)) 
					{
					     $current_num_licenses = $row[$numbCourses];
					} 
					
					//subtract one license
					$lic_after_adding_student = $current_num_licenses - 1; 
					
					
					//echo "licenses after adding student=";
					//echo $lic_after_adding_student;
				
				//update table with new number of license
				if($current_num_licenses > 0)
				{
					//update table after subtracting license
					$SQL90="UPDATE [$table] SET $numbCourses='$lic_after_adding_student' ";		
					$resultset90=mssql_query($SQL90, $con);
				}*/

				$context = new Db();

				$productIdQuery = "SELECT [id],[JobType] FROM [07DS2] WHERE ProID = '" . $PC . "'";

				//die($productIdQuery);

				$product = $context->RunQuery($productIdQuery);

				//die(var_dump($product));

				$licenseQuery = "SELECT * FROM [Licenses] WHERE [UserId] = '" .$AN. "' AND [ProductId] = ".$product['id'];

				//die($licenseQuery);

				$license = $context->RunQuery($licenseQuery);

				//die(var_dump($license));
				
				$newLicenseTotal = 1 - $license['LicensesRemaining'];
				$newLicenseQuery = "UPDATE [Licenses] SET [LicensesRemaining] = ".$newLicenseTotal. " WHERE [LicenseID] = ".$license['LicenseID'];
								

				$newLicenseResult = $context->RunInsert($newLicenseQuery);
				

				
				// if user purchased single course and was enrrolled
				
	
				//tapseries-php-qa.us-west-2.elasticbeanstalk.com
				echo "
				
					<script>
 							 window.location.href = 'https://www.tapseries.com/courses/shop/congratulations.php?studentadded=yes&UA=$AN&invoice=$IDparts[0]&total=$IDparts[1]&last4=$IDparts[5]&oh2_id=$IDparts[12]';
					</script>

				";
				

				//**********************  EMAIL SENDER *************************
				$SQL002="SELECT AC FROM [07L3] WHERE AN='$AN' ";
				$resultset002=mssql_query($SQL002, $con);
				while ($row = mssql_fetch_array($resultset002)) 
				{
				     $acct_pw = $row['AC'];
				} 

				$to = $AM;
				//$to = 'mg@tapseries.com';
				$subject = "TAP Series Login Information";

				$message .= "<span>Thank you for your purchase $StudName[0] $StudName[1].</span><br>";	
				$message .= "<span>To start the course, go to <a href='https://www.tapseries.com/'>www.tapseries.com</a></span><br>";
				$message .= "<span>Click Login To Course</span><br>";	
				$message .= "<span>Enter your username: $AN, then your password: $acct_pw</span><br>";	
				$message .= "<br>";	
				$message .= "<span>For technical support, please call 888-826-5222</span><br>";			
				$message .= "<span>After hours technical support (8am-8pm Pacific time): 818-809-3762</span><br>";			
						

				


					$header = "From:orders@tapseries.com \r\n";
					$header .= "Cc:dp@tapseries.com \r\n";
					$header .= "MIME-Version: 1.0\r\n";
					$header .= "Content-type: text/html\r\n";

					$retval = mail ($to,$subject,$message,$header);	

				//******************************************** email ends here ************************************************				
				
				
				
				
			}
			
			//	if user purchased multiple licenses or purchased course for somene else, user has the option to register students
			else
			{
				

				
				echo "
				
					<script>
 							 window.location.href = 'https://www.tapseries.com/courses/shop/congratulations.php?studentadded=no&UA=$AN&invoice=$IDparts[0]&total=$IDparts[1]&last4=$IDparts[5]&LK=$LK_created_string&corp=$IDparts[6]&oh2_id=$IDparts[12]';
					</script>

				";
				
				


			}
			
			
			// ------------ INVOICE EMAIL -------------------------------------------------	

				$invoice = $IDparts[0];
				$total = $IDparts[1];
				$date = date("m/d/Y");

				// format was conflicting
				//$total = number_format($total,2);
				


				// get info from corp info table if corp admin purchase licenses from corp place orders page
				if($IDparts[6])
				{
					//get AN information ex. address etc from Billing Table
					$SQL33="SELECT * FROM [07L2] WHERE UU ='$AN' ";
						$resultset33=mssql_query($SQL33, $con); 

						while ($row = mssql_fetch_array($resultset33)) 
					{
					     $NF = $row['NF'];
					     $NL = $row['NL'];
					     $NCPY = $row['UA'];
					     $AA1 = $row['AA1'];
					     $AA2 = $row['AA2'];
					     $ACI = $row['ACI'];
					     $AST = $row['AST'];
					     $AZ = $row['AZ'];
					     $ACO = $row['ACO'];
					     $AP = $row['AP'];
					     $AM = $row['UM'];
					} 

					 $NCON = $NF. " " .$NL;

					//get vendor name
					$SQL45="SELECT VC FROM [07O2] WHERE OID ='$invoice' ";
					$resultset45=mssql_query($SQL45, $con); 
					while ($row = mssql_fetch_array($resultset45)) 
					{
						$VC_check = $row['VC'];
					}
					if($VC_check){
						$SQL46="SELECT NC FROM [07SL1C] WHERE VC ='$VC_check' ";
						$resultset46=mssql_query($SQL46, $con); 
						while ($row = mssql_fetch_array($resultset46)) 
						{
							$vendor_name = $row['NC'];
						}
					}
					else{
						$vendor_name = "TAP Series";
					}	

				}
				else
				{

					//get AN information ex. address etc from Billing Table
					$SQL33="SELECT NCON, NCPY, AA1, AA2, ACI, AST, AZ, ACO, AP, AM FROM [07O1] WHERE AN ='$AN' ";
						$resultset33=mssql_query($SQL33, $con); 

						while ($row = mssql_fetch_array($resultset33)) 
					{
					     $NCON = $row['NCON'];
					     $NCPY = $row['NCPY'];
					     $AA1 = $row['AA1'];
					     $AA2 = $row['AA2'];
					     $ACI = $row['ACI'];
					     $AST = $row['AST'];
					     $AZ = $row['AZ'];
					     $ACO = $row['ACO'];
					     $AP = $row['AP'];
					     $AM = $row['AM'];
					} 

					//get vendor name
					$SQL45="SELECT VC FROM [07O2] WHERE OID ='$invoice' ";
					$resultset45=mssql_query($SQL45, $con); 
					while ($row = mssql_fetch_array($resultset45)) 
					{
						$VC_check = $row['VC'];
					}
					if($VC_check){
						$SQL46="SELECT NC FROM [07SL1] WHERE VC ='$VC_check' ";
						$resultset46=mssql_query($SQL46, $con); 
						while ($row = mssql_fetch_array($resultset46)) 
						{
							$vendor_name = $row['NC'];
						}
					}
					else{
						$vendor_name = "TAP Series";
					}					
				}





				/*
				$SQL001="SELECT AC FROM [07L3] WHERE AN='$AN' ";
					$resultset001=mssql_query($SQL001, $con);
				
					while ($row = mssql_fetch_array($resultset001)) 
					{
					     $acct_pw = $row['AC'];
					} 	
				*/

							//**********************  EMAIL SENDER *************************

						$to = $AM;
						//$to = 'mg@tapseries.com';
					$subject = "TAP Series Receipt";

					$message = "<p>Paid in full</p>";
					$message .= "<p>Credit/Debit Card: XXXX XXXX XXXX $IDparts[5]</p>";
					//$message .= "<p>Username: $AN</p>";
					//$message .= "<p>Password: $acct_pw</p>";
					$message .= "

						<table style='border: 1px solid black; height: 119px; width: 311px;'>
				<tbody>
				<tr style='height: 12px;'>
				<td style='color: white; font-family: sans-serif; border: 1px solid black; width: 464px; height: 12px; background-color: #0c7bab;' colspan='3'>Order number</td>
				</tr>
				<tr style='height: 12px;'>
				<td style='font-family: sans-serif; border: 1px solid black; width: 464px; height: 12px;' colspan='3'>$invoice</td>
				</tr>
				<tr style='height: 12px;'>
				<td style='color: white; font-family: sans-serif; border: 1px solid black; width: 464px; height: 12px; background-color: #0c7bab;' colspan='3'>Order date</td>
				</tr>
				<tr style='height: 12px;'>
				<td style='font-family: sans-serif; border: 1px solid black; width: 464px; height: 12px;' colspan='3'>$date</td>
				</tr>
				<tr style='height: 12px;'>
				<td style='color: white; font-family: sans-serif; border: 1px solid black; width: 464px; height: 12px; background-color: #0c7bab;' colspan='3'>Vendor name</td>
				</tr>
				<tr style='height: 12px;'>
				<td style='font-family: sans-serif; border: 1px solid black; width: 464px; height: 12px;' colspan='3'>$vendor_name</td>
				</tr>
				<tr style='height: 12px;'>
				<td style='color: white; font-family: sans-serif; border: 1px solid black; width: 464px; height: 12px; background-color: #0c7bab;' colspan='3'>Billing information</td>
				</tr>
				<tr style='height: 62px;'>
				<td style='font-family: sans-serif; border: 1px solid black; width: 464px; height: 62px;' colspan='3'>$NCON <br>
								  $NCPY<br>
								   $AA1<br>				  
								   $AA2<br>				  
								   $ACI $AST, $AZ<br>
								   $ACO<br>				   
								   $AM<br>
								   $AP<br>
								   </td>
				</tr>
				";

				if($IDparts[12] !="")
				{
					$SQL5 = "SELECT * FROM ohioProctor WHERE id='$IDparts[12]' ";
					$resultset5=mssql_query($SQL5, $con);
					while ($row = mssql_fetch_array($resultset5)) 
					{
						$oh2_county = trim($row['county']);
						$oh2_educator = trim($row['educator']);
						$oh2_email = trim($row['email']);
						$oh2_phone = trim($row['phone']);
					}

					$message .= "
								<tr style='height: 34px;'>
								<td style='color: white; font-family: sans-serif; border: 1px solid black; width: 464px; height: 34px; background-color: #0c7bab;' colspan='3'>
								Ohio Approved Proctor</p>
								</td>
								</tr>
								<tr style='height: 12px;'>
								<td style='font-family: sans-serif; border: 1px solid black; width: 464px; height: 12px;' colspan='3'>
								<strong>County</strong>: $oh2_county<br>
								<strong>Educator</strong>: $oh2_educator<br>
								<strong>Email</strong>: $oh2_email<br>
								<strong>Phone</strong>: $oh2_phone					
								</td>
								</tr>
							";
					
				}

				$message .= "
				<tr style='height: 34px;'>
				<td style='color: white; font-family: sans-serif; border: 1px solid black; width: 464px; height: 34px; background-color: #0c7bab;' colspan='3'>
				<p>Order details</p>
				</td>
				</tr>";

					$SQL="SELECT * FROM [07O4] WHERE OID ='$invoice' ";
						$resultset=mssql_query($SQL, $con); 

					while ($row = mssql_fetch_array($resultset)) 
					{
					     $OID = $row['OID'];
					     $PC = $row['PC'];
					     $PN = $row['PN'];
					     $PRI = $row['PRI'];
					     $NO = $row['NO'];

					     $PRI = number_format($PRI,2);


				$message .= "													
				<tr style='height: 34px;'>												
				<td style='font-family: sans-serif; border: 1px solid black; width: 345.667px; height: 34px;'>$PN</td>
				<td style='font-family: sans-serif; border: 1px solid black; width: 38.3333px; height: 34px;'>$NO</td>
				<td style='font-family: sans-serif; border: 1px solid black; width: 80px; height: 34px;'><span>$</span>$PRI</td>
				</tr>
				";
					}												
				$message .= "
				<tr style='height: 12.3333px;'>
				<td style='font-family: sans-serif; border: 1px solid black; width: 345.667px; height: 12.3333px;'>&nbsp;</td>
				<td style='font-family: sans-serif; border: 1px solid black; width: 38.3333px; height: 12.3333px;'>Total:</td>
				<td style='font-family: sans-serif; border: 1px solid black; width: 80px; height: 12.3333px;'><span>$</span>$total</td>
				</tr>
				";

				// if purchased license keys
				if($IDparts[11] == "yes")
				{
	
					$message .= "<tr style='height: 12px;'>";
					$message .= "<td style='font-family: sans-serif; border: 1px solid black; width: 464px; height: 12px;' colspan='3'>
								Purchased license keys:<br>
								";
						foreach ($LK_created as $LK_created_indiv) 
						{
							$message .= "$LK_created_indiv <br>";
						}
					$message .= "</td>";	
					$message .= "</tr>";	
				}

	

				$message .= "
					        </tbody>
				        	</table>
						    ";

				// if purchased license keys			
				if($IDparts[11] == "yes")
				{
					$message .= "<p>Each of your employees is to receive one license key. The employee will use their license key as their password when they enroll themselves in the course.</p>";			
				}

				$message .= "<p>Thank you for shopping with us.</p>";			
				$message .= "<p>For technical support, email our TAP Series Tech Team at techsupport@tapseries.com or call us at 888-826-5222.</p>";			
				$message .= "<p>We hope to see you again soon.</p>";			
				$message .= "<p>To login to your course, click <a href='https://www.tapseries.com/training/'>here</a> or go to <a href='https://www.tapseries.com/'>www.tapseries.com</a> and click Login To Course.</p>";			
				$message .= "<p>Customers who bought your course frequently bought our Chef Fundamentals course.</p>";			

				


					$header = "From:orders@tapseries.com \r\n";
					$header .= "Cc:orders@tapseries.com \r\n";
					$header .= "MIME-Version: 1.0\r\n";
					$header .= "Content-type: text/html\r\n";

					$retval = mail ($to,$subject,$message,$header);	

				//******************************************** email ends here ************************************************



			//check if the customer works for one of the hotels that are part of Marriott
			//check if one of the values from the array can be found on the company name
			if($PC == "fs" && $NCPY)
			{
				$company_name = $NCPY;
				$SQL200 = "SELECT hotel_name FROM [marriott_hotels] ";		
				$resultset200=mssql_query($SQL200, $con); 
				while ($row = mssql_fetch_array($resultset200)) 
				{
					$array_marriott_hotels[] = $row['hotel_name'];
				}   

				function check_cn_array($company_name){
					
					global $array_marriott_hotels;
					
					foreach ($array_marriott_hotels as $marriott_hotel){
						if (stripos($company_name,$marriott_hotel) !== false) {
								return true;
						}
					}
					
				}

				$company_name_match = check_cn_array($company_name);
				// ENDS HERE
			}


			//email only for Marriott companies
			if($VC_check == "marriott" && $PC == "fs" || $company_name_match === true && $PC == "fs")
			{
				//email starts
				$from = "info@tapseries.com";
				$subject = "TAP Series Food Safety Manager Training Course";
				$cc_address = "dp@tapseries.com";
				$body = "<span>Greetings,</span><br><br>";
				$body .= "<span>Thank you for your purchase of the Foodservice Safety Manager Training Course. The course will fulfill your Brand Standard requirement for Marriott's for food safety training. The course provides the necessary training to prepare your employees for the online ANSI proctored exam. The course can be taken on smartphones, tablets, or PC devices without needing to download any apps, and users can switch between any of their devices while taking the course. There are 14 lessons and a TAP Series' online practice exam. Any lesson may be retaken.  We recommend that the employee earns a 90% or better on each lesson before sitting for the online ANSI proctored exam. There is a study guide available at the main menu of the course. The main menu is accessible after each lesson. </span><br><br>";	
				$body .= "If you have any questions, please submit a ticket at <a href='https://www.tapseries.com/'>www.tapseries.com</a> by clicking on 'Need Help' or email us at sk@tapseries.com.<br><br>";
				$body .= "To start your course, go to <a href='https://www.tapseries.com/'>www.tapseries.com</a>, and click on 'Login to Course'.<br><br>";
				$body .= "Stay calm and TAP on,<br>The TAP Series Team<br><br>";
				$body .= "Other TAP Series Courses at <a href='https://www.tapseries.com/'>www.tapseries.com</a>:<br>
						Alcohol Training<br>
						Allergen Friendly Series&reg; - Allergen Awareness&reg;, Allergen Plan Development, Allergen Plan Specialist<br>
						HACCP - ACF 15 Continuing Education hours.<br> 
						Cooking Basics - ACF 15 Continuing Education hours.<br> 
						Earn More With Service - ACF 15 Continuing Education hours.<br>  
						Strategies for Increasing Sales - ACF 15 Continuing Education hours.
						";

				$smtp = new smtp_class;
				$smtp->host_name = 'smtp.gmail.com'; // Google mail host.
				$smtp->host_port = 465; // Secure port.
				$smtp->ssl = 1;
				$smtp->start_tls = 0;
				$smtp->localhost = 'tapseries.com';
				$smtp->direct_delivery = 0;
				$smtp->timeout = 10;
				$smtp->data_timeout = 0;
				$smtp->debug = 0;
				$smtp->html_debug = 0;
				$smtp->user = 'info@tapseries.com'; // Or orders@tapseries.com
				$smtp->password = 'Training0nline!'; // refer to salesforce or sticky note

				// Create a new array.
				$recipients = [];
				// Push your $email address to the array.
				array_push($recipients,$AM);

				$headers = [];
				array_push($headers,"Subject: ". $subject);
				array_push($headers,"To: " . $AM);
				array_push($headers,"Cc: " . $cc_address);
				array_push($headers,"Date: ".strftime("%a, %d %b %Y %H:%M:%S %Z"));
				array_push($headers, "Content-Type: text/html; charset=ISO-8859-1");
				// If you are going to send the email to more than one person, 
				// $to will need to be an array of the email addresses you want to send.
				$sent = $smtp->SendMessage($from, $recipients, $headers, $body); // This sends the email.
				/*
				if(!$sent)
					die($smtp -> error);
				*/
				//email ends
			}

		



}
else
{
	echo "<p style='text-align:center;margin-top:100px'>The transaction was declined.</p>";
	echo "<p style='text-align:center'>Confirm your billing address. Please check your information and try again.</p>";
	echo "<p style='text-align:center'><button onclick='goBack()'>Go Back</button></p>";
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





//print_r(array_values($LK_created));

?>





<style>
#wrapper{
	max-width:1000px;
	height:600px;
	border:1px solid #333;
	background-color:white;
	margin:30px auto;
	border-radius:5px;
	text-align:center;
	
}
body{
	background-color:white;
	font-family: 'Open Sans', sans-serif;  
	font-size:20px;
}
</style>

<script>
function goBack() {
    window.history.back();
}
</script>
