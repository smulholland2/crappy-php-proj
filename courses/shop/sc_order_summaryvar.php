<?php
error_reporting(0);

$user=$_SERVER['DB_USERNAME'];
$password=$_SERVER['DB_PASSWORD'];
$server=$_SERVER['DB_HOSTNAME'];
$database='newtap';
$con = mssql_connect($server,$user,$password) or die('Could not connect to the server!');
mssql_select_db($database, $con) or die('Could not select a database.'); 

session_start();


$addSudentToCourse = $_SESSION["addSudentToCourse"];

echo $Utah_userci = $_POST["Utah_userci"];
echo $Utah_gender = $_POST["Utah_gender"];
echo $Utah_work_phone = $_POST["Utah_work_phone"];

if(isset($_POST["oh2_id"])){
$_SESSION['oh2_id'] = $_POST["oh2_id"];
}


if($Utah_userci)
{

	$_SESSION["Utah_userci"] = "$Utah_userci";
	$_SESSION["Utah_gender"] = "$Utah_gender";
	$_SESSION["Utah_work_phone"] = "$Utah_work_phone";


	$UTBRarray = array("Bear River","Brigham","Corinne","Deweyville","Elwood","Fielding","Garland","Honeyville","Howell","Mantua","Perry","Plymouth","Portage","Snowville","Tremonton","Willard","Amalga","CacheCount","Cache Valley Transit","Clarkston","Cornish","Hyde Park","Hyrum","Lewiston","Logan","Mendon","Millville","Newton","Nibley","North Logan","Paradise","Providence","Richmond","RiverHeights","Smithfield","Trenton","Wellsville","Garden City","Laketown","Randolph","Rich County","Woodruff","Box Elder County");

	$UTCUarray = array("Eureka","Juab County","Levan","Mona","Nephi","Rocky Ridge Town","Santaquin South","Delta","Fillmore","Hinckley","Holden","Kanosh","Leamington","Lynndyl","Meadow","Millard County","Oak City","Scipio","Circleville","Junction","Kingston","Marysvale","Piute County","Centerfield","Ephraim","Fairview","Fayette","Fountain Green","Gunnison","Manti","Mayfield","Moroni","Mt. Pleasant","Sanpete County","Spring City","Sterling","Wales","Annabella","Aurora","Central Valley","Elsinore","Glenwood","Joseph","Koosharem","Monroe","Redmond","Richfield","Salina","Sevier County","Sigurd","Bicknell","Hanksville","Loa","Lyman","Torrey","Wayne County");

	$UTDAarray = array("Bountiful","Centerville","Clearfield","Clinton","Davis County","Falcon Hill Clearfield","Falcon Hill Davis","Falcon Hill Sunset","Farmington","Fruit Heights","Kaysville","Layton","North Salt Lake","South Weber","Sunset","Syracuse","West Bountiful","West Point","Woods Cross");

	$UTSEarray = array("Carbon County","East Carbon","Helper","Price","Scofield","Sunnyside","Wellington","Castle Dale","Clawson","Cleveland","Elmo","Emery City","Emery County","Ferron","Green River","Huntington","Orangeville","Castle Valley","Grand County","Moab","Blanding","Monticello","San Juan County");

	$UTSLarray = array("Alta","Bluffdale","Cottonwood Heights","Draper","Herriman","Holladay","Midvale","Murray","Riverton","Salt Lake City","Salt Lake County","Sandy","South Jordan","South Salt Lake","Taylorsville","Utah Data Center SL Co","West Jordan","West Valley City");

	$UTSWarray = array("Beaver City","Beaver County","Milford","Minersville","Antimony","Boulder","Bryce Canyon","Cannonville","Escalante","Garfield County","Hatch","Henrieville","Panguitch","Tropic","BrianHead","Cedar City","Enoch","Iron County","Kanarraville","Paragonah","Parowan","Alton","Big Water","Glendale","Kanab","KaneCounty","Orderville","Apple Valley","Enterprise","Hildale","Hurricane","Ivins","La Verkin","Leeds","New Harmony","Rockville","Santa Clara","Springdale","St. George","Toquerville","Virgin","Washington City","Washington County", "Beryl");

	$UTSUarray = array("Coalville","Francis","Henefer","Kamas","Oakley","Park City","Snyderville Basin Tr Dist","Summit County");

	$UTTOarray = array("Erda","Grantsville","Lakepoint","Lincoln","Ophir","Rush Valley","Stansbury Park","Stockton","Tooele City","Tooele County","Vernon","Wendover");

	$UTTCarray = array("Daggett County","Manila","Altamont","Duchesne City","Duchesne County","Myton","Roosevelt","Tabiona","Ballard","Naples","Uintah County","Vernal");

	$UTUTarray = array("Alpine","American Fork","Bluffdale South","Cedar Fort","Cedar Hills","Draper City South","Eagle Mountain","Elk Ridge","Fairfield","Genola","Goshen","Highland","Lehi","Lindon","Mapleton","Orem","Payson","Pleasant Grove","Provo","Salem","Santaquin","Saratoga Springs","Spanish Fork","Springville","Utah County","Utah Data Center Utah Co","Vineyard","Woodland Hills");

	$UTWAarray = array("Charleston","Daniel","Heber","Hideout","Independence","Midway","Park City East","Wallsburg","Wasatch County");

	$UTWMarray = array("Morgan City","Morgan County","Falcon Hill Riverdale","Falcon Hill Roy","Farr West","Harrisville","Hooper","Huntsville","Marriott-Slaterville","North Ogden","Ogden","Plain City","Pleasant View","Riverdale","Roy","South Ogden","Uintah","Washington Terrace","Weber County","West Haven");



	if (in_array($Utah_userci, $UTBRarray))
	{
	echo $Utah_Region="UTBR";
	}
	elseif (in_array($Utah_userci, $UTCUarray))
	{
	echo $Utah_Region="UTCU";
	}
	elseif (in_array($Utah_userci, $UTDAarray))
	{
	echo $Utah_Region="UTDA";
	}
	elseif (in_array($Utah_userci, $UTSEarray))
	{
	echo $Utah_Region="UTSE";
	}
	elseif (in_array($Utah_userci, $UTSLarray))
	{
	echo $Utah_Region="UTSL";
	}
	elseif (in_array($Utah_userci, $UTSWarray))
	{
	echo $Utah_Region="UTSW";
	}
	elseif (in_array($Utah_userci, $UTSUarray))
	{
	echo $Utah_Region="UTSU";
	}
	elseif (in_array($Utah_userci, $UTTOarray))
	{
	echo $Utah_Region="UTTO";
	}
	elseif (in_array($Utah_userci, $UTTCarray))
	{
	echo $Utah_Region="UTTC";
	}
	elseif (in_array($Utah_userci, $UTUTarray))
	{
	echo $Utah_Region="UTUT";
	}
	elseif (in_array($Utah_userci, $UTWAarray))
	{
	echo $Utah_Region="UTWA";
	}
	elseif (in_array($Utah_userci, $UTWMarray))
	{
	echo $Utah_Region="UTWM";
	}
	else
	{
		echo "Match not found";
	}

	$_SESSION["Utah_Region"] = "$Utah_Region";


	$BoxElder = array("Bear River","Brigham","Corinne","Deweyville","Box Elder County","Elwood","Fielding","Garland","Honeyville","Howell","Mantua","Perry","Plymouth","Portage","Snowville","Tremonton","Willard");
	$Cache = array("Amalga","Cache County","Cache Valley Transit","Clarkston","Cornish","Hyde Park","Hyrum","Lewiston","Logan","Mendon","Millville","Newton","Nibley","North Logan","Paradise","Providence","Richmond","RiverHeights","Smithfield","Trenton","Wellsville");
	$Rich = array("Garden City","Laketown","Randolph","Rich County","Woodruff");
	$Juab = array("Eureka","Juab County","Levan","Mona","Nephi","Rocky Ridge Town","Santaquin South");
	$Millard = array("Delta","Fillmore","Hinckley","Holden","Kanosh","Leamington","Lynndyl","Meadow","Millard County","Oak City","Scipio");
	$Piute = array("Circleville","Junction","Kingston","Marysvale","Piute County");
	$Sanpete = array("Centerfield","Ephraim","Fairview","Fayette","Fountain Green","Gunnison","Manti","Mayfield","Moroni","Mt. Pleasant","Sanpete County","Spring City","Sterling","Wales");
	$Sevier = array("Annabella","Aurora","Central Valley","Elsinore","Glenwood","Joseph","Koosharem","Monroe","Redmond","Richfield","Salina","Sevier County","Sigurd");
	$Wayne = array("Bicknell","Hanksville","Loa","Lyman","Torrey","Wayne County");
	$Davis = array("Bountiful","Centerville","Clearfield","Clinton","Davis County","Falcon Hill Clearfield","Falcon Hill Davis","Falcon Hill Sunset","Farmington","Fruit Heights","Kaysville","Layton","North Salt Lake","South Weber","Sunset","Syracuse","West Bountiful","West Point","Woods Cross");
	$Carbon = array("Carbon County","East Carbon","Helper","Price","Scofield","Sunnyside","Wellington");
	$Emery = array("Castle Dale","Clawson","Cleveland","Elmo","Emery City","Emery County","Ferron","Green River","Huntington","Orangeville");
	$Grand = array("Castle Valley","Grand County","Moab");
	$SanJuan = array("Blanding","Monticello","San Juan County");
	$SaltLake = array("Alta","Bluffdale","Cottonwood Heights","Draper","Herriman","Holladay","Midvale","Murray","Riverton","Salt Lake City","Salt Lake County","Sandy","South Jordan","South Salt Lake","Taylorsville","Utah Data Center SL Co","West Jordan","West Valley City");
	$Beaver = array("Beaver City","Beaver County","Milford","Minersville");
	$Garfield = array("Antimony","Boulder","Bryce Canyon","Cannonville","Escalante","Garfield County","Hatch","Henrieville","Panguitch","Tropic");
	$Iron = array("Brian Head","Cedar City","Enoch","Iron County","Kanarraville","Paragonah","Parowan", "Beryl");
	$Kane = array("Alton","Big Water","Glendale","Kanab","KaneCounty","Orderville");
	$Washington = array("Apple Valley","Enterprise","Hildale","Hurricane","Ivins","La Verkin","Leeds","New Harmony","Rockville","Santa Clara","Springdale","St. George","Toquerville","Virgin","Washington City","Washington County");
	$Summit = array("Coalville","Francis","Henefer","Kamas","Oakley","Park City","Snyderville Basin Tr Dist","Summit County");
	$Tooele = array("Erda","Grantsville","Lakepoint","Lincoln","Ophir","Rush Valley","Stansbury Park","Stockton","Tooele City","Tooele County","Vernon","Wendover");
	$Daggett = array("Daggett County","Manila");
	$Duchesne = array("Altamont","Duchesne City","Duchesne County","Myton","Roosevelt","Tabiona");
	$Unitah = array("Ballard","Naples","Uintah County","Vernal");
	$UtahCounty = array("Alpine","American Fork","Bluffdale South","Cedar Fort","Cedar Hills","Draper City South","Eagle Mountain","Elk Ridge","Fairfield","Genola","Goshen","Highland","Lehi","Lindon","Mapleton","Orem","Payson","Pleasant Grove","Provo","Salem","Santaquin","Saratoga Springs","Spanish Fork","Springville","Utah County","Utah Data Center Utah Co","Vineyard","Woodland Hills");
	$Wasatch = array("Charleston","Daniel","Heber","Hideout","Independence","Midway","Park City East","Wallsburg","Wasatch County");
	$Morgan = array("Morgan City","Morgan County");
	$Weber = array("Falcon Hill Riverdale","Falcon Hill Roy","Farr West","Harrisville","Hooper","Huntsville","Marriott-Slaterville","North Ogden","Ogden","Plain City","Pleasant View","Riverdale","Roy","South Ogden","Uintah","Washington Terrace","Weber County","West Haven");


	if (in_array($Utah_userci, $BoxElder))
	{
	echo $Utah_County="Box Elder";
	}
	elseif (in_array($Utah_userci, $Cache))
	{
	echo $Utah_County="Cache";
	}
	elseif (in_array($Utah_userci, $Rich))
	{
	echo $Utah_County="Rich";
	}
	elseif (in_array($Utah_userci, $Juab))
	{
	echo $Utah_County="Juab";
	}
	elseif (in_array($Utah_userci, $Millard))
	{
	echo $Utah_County="Millard";
	}
	elseif (in_array($Utah_userci, $Piute))
	{
	echo $Utah_County="Piute";
	}
	elseif (in_array($Utah_userci, $Sanpete))
	{
	echo $Utah_County="Sanpete";
	}
	elseif (in_array($Utah_userci, $Sevier))
	{
	echo $Utah_County="Sevier";
	}
	elseif (in_array($Utah_userci, $Wayne))
	{
	echo $Utah_County="Wayne";
	}
	elseif (in_array($Utah_userci, $Davis))
	{
	echo $Utah_County="Davis";
	}
	elseif (in_array($Utah_userci, $Carbon))
	{
	echo $Utah_County="Carbon";
	}
	elseif (in_array($Utah_userci, $Emery))
	{
	echo $Utah_County="Emery";
	}
	elseif (in_array($Utah_userci, $Grand))
	{
	echo $Utah_County="Grand";
	}
	elseif (in_array($Utah_userci, $SanJuan))
	{
	echo $Utah_County="San Juan";
	}
	elseif (in_array($Utah_userci, $SaltLake))
	{
	echo $Utah_County="Salt Lake";
	}
	elseif (in_array($Utah_userci, $Beaver))
	{
	echo $Utah_County="Beaver";
	}
	elseif (in_array($Utah_userci, $Garfield))
	{
	echo $Utah_County="Garfield";
	}
	elseif (in_array($Utah_userci, $Iron))
	{
	echo $Utah_County="Iron";
	}
	elseif (in_array($Utah_userci, $Kane))
	{
	echo $Utah_County="Kane";
	}
	elseif (in_array($Utah_userci, $Washington))
	{
	echo $Utah_County="Washington";
	}
	elseif (in_array($Utah_userci, $Summit))
	{
	echo $Utah_County="Summit";
	}
	elseif (in_array($Utah_userci, $Tooele))
	{
	echo $Utah_County="Tooele";
	}
	elseif (in_array($Utah_userci, $Daggett))
	{
	echo $Utah_County="Daggett";
	}
	elseif (in_array($Utah_userci, $Duchesne))
	{
	echo $Utah_County="Duchesne";
	}
	elseif (in_array($Utah_userci, $Unitah))
	{
	echo $Utah_County="Unitah";
	}
	elseif (in_array($Utah_userci, $UtahCounty))
	{
	echo $Utah_County="Utah County";
	}
	elseif (in_array($Utah_userci, $Wasatch))
	{
	echo $Utah_County="Wasatch";
	}
	elseif (in_array($Utah_userci, $Morgan))
	{
	echo $Utah_County="Morgan";
	}
	elseif (in_array($Utah_userci, $Weber))
	{
	echo $Utah_County="Weber";
	}
	else{
		echo "Match not found";
	}


	$_SESSION["Utah_County"] = "$Utah_County";

}


// $cardstudfn = $_POST["cardstudfn"];
// $cardstudln = $_POST["cardstudln"];
 $month = $_POST["month"];
 $day = $_POST["day"];
 $year = $_POST["year"];
 $courseLanguage = $_POST["courseLanguage"];
 
 $floridaCompany = $_POST["floridaCompany"];
 if($floridaCompany)
 {
	$SQL="SELECT * FROM floridaLicenseLookup WHERE CompanyName = '$floridaCompany' ";
		$resultset=mssql_query($SQL, $con); 
		
			while ($row = mssql_fetch_array($resultset)) 
			{
			     $floridaLicense = $row['license'];
			}  
		
			if($floridaLicense == "")
			{
				$floridaLicense = $floridaCompany;
			}		
 }
 

 
$CorporateSubAccountID = $_POST["CorporateSubAccountID"];

 $Utah_gender = $_POST["Utah_gender"];

 $cardfn = $_POST["cardfn"];
 $cardln = $_POST["cardln"];
 $last4 = $_POST["last4"];
 $cardcn = $_POST["cardcn"];
 $cardadd1 = $_POST["cardadd1"];
 $cardadd2 = $_POST["cardadd2"];
 $cardci = $_POST["cardci"];
 $cardst = $_POST["cardst"];
 $cardzip = $_POST["cardzip"];
 $cardcou = $_POST["cardcou"];
 $cardphone = $_POST["cardphone"];
 $cardem = $_POST["cardem"];
 
	if($floridaCompany)
		{
			$cardcn = $floridaCompany;
		}
 
	$userfn = $_POST["userfn"];
	$userln = $_POST["userln"];
	$usercn = $_POST["usercn"];
	$useradd1 = $_POST["useradd1"];
	$useradd2 = $_POST["useradd2"];
	$userci = $_POST["userci"];
	$userst = $_POST["userst"];
	$userzip = $_POST["userzip"];
	$usercou = $_POST["usercou"];
	$userphone = $_POST["userphone"];
	$userem = $_POST["userem"];

	if($userfn == '')
	{
			$userfn = $_POST["cardstudfn"];
			$userln = $_POST["cardstudln"];
			$usercn = $_POST["cardcn"];
			$useradd1 = $_POST["cardadd1"];
			$useradd2 = $_POST["cardadd2"];

		if($Utah_userci)
		{
			$userci = $Utah_userci;
		}	 
		else
		{	 
			$userci = $_POST["cardci"];
		}
			$userst = $_POST["cardst"];
			$userzip = $_POST["cardzip"];
			$usercou = $_POST["cardcou"];
			$userphone = $_POST["cardphone"];
			$userem = $_POST["cardem"];
		
				if($floridaCompany)
				{
					$usercn = $floridaCompany;
				}
			
		
	}
	else
	{
	 $userfn = $_POST["userfn"];
	 $userln = $_POST["userln"];
	 $usercn = $_POST["usercn"];
	 $useradd1 = $_POST["useradd1"];
	 $useradd2 = $_POST["useradd2"];

if($Utah_userci)
{
	$userci = $Utah_userci;
}	 
else
{	
	 $userci = $_POST["userci"];
}
	 $userst = $_POST["userst"];
	 $userzip = $_POST["userzip"];
	 $usercou = $_POST["usercou"];
	 $userphone = $_POST["userphone"];
	 $userem = $_POST["userem"];
	 
		if($floridaCompany)
		{
			$usercn = $floridaCompany;
		}
	}

	
	


//$_SESSION["cardstudfn"] = "$cardstudfn";
//$_SESSION["cardstudln"] = "$cardstudln";

$_SESSION["CorporateSubAccountID"] = "$CorporateSubAccountID";

$_SESSION["month"] = "$month";
$_SESSION["day"] = "$day";
$_SESSION["year"] = "$year";
$_SESSION["courseLanguage"] = "$courseLanguage";

$_SESSION["floridaCompany"] = "$floridaCompany";
$_SESSION["floridaLicense"] = "$floridaLicense";

$_SESSION["cardfn"] = "$cardfn";
$_SESSION["cardln"] = "$cardln";
$_SESSION["last4"] = "$last4";
$_SESSION["cardcn"] = "$cardcn";
$_SESSION["cardadd1"] = "$cardadd1";
$_SESSION["cardadd2"] = "$cardadd2";
$_SESSION["cardci"] = "$cardci";
$_SESSION["cardst"] = "$cardst";
$_SESSION["cardzip"] = "$cardzip";
$_SESSION["cardcou"] = "$cardcou";
$_SESSION["cardphone"] = "$cardphone";
$_SESSION["cardem"] = "$cardem";

$_SESSION["userfn"] = "$userfn";
$_SESSION["userln"] = "$userln";
$_SESSION["usercn"] = "$usercn";
$_SESSION["useradd1"] = "$useradd1";
$_SESSION["useradd2"] = "$useradd2";
$_SESSION["userci"] = "$userci";
$_SESSION["userst"] = "$userst";
$_SESSION["userzip"] = "$userzip";
$_SESSION["usercou"] = "$usercou";
$_SESSION["userphone"] = "$userphone";
$_SESSION["userem"] = "$userem";



print_r($_SESSION);


/*
if (!preg_match("/^[a-zA-Z ]*$/",$cardfn)) 
{
	 $Err = "Only letters are allowed"; 
	 header("Location: sc_info.php?CCfnErr=$Err");
}
elseif (!preg_match("/^[a-zA-Z ]*$/",$cardln)) 
{
	 $Err = "Only letters are allowed"; 
	 header("Location: sc_info.php?CClnErr=$Err");
}
elseif (!preg_match("/^[0-9]*$/",$last4)) 
{
	 $Err = "Only numbers are allowed"; 
	 header("Location: sc_info.php?CClas4Err=$Err");
}
elseif (!preg_match("/^[a-zA-Z ]*$/",$cardfn))  
{
	$Err = "Only letters are allowed"; 
	header("Location: sc_info.php?cardfnErr=$Err");
}
else{
}
*/

header("Location: sc_order_summary.php");

?>
