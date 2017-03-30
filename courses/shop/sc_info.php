<?php
error_reporting(0); 


$user=$_SERVER['DB_USERNAME'];
$password=$_SERVER['DB_PASSWORD'];
$server=$_SERVER['DB_HOSTNAME'];
$database='newtap';
   
// Connect to the database (host, username, password)
$con = mssql_connect($server,$user,$password) or die('Could not connect to the server!');
mssql_select_db($database, $con) or die('Could not select a database.'); 

$SQL = "SELECT ProID FROM [07DS2] ";		
	$resultset=mssql_query($SQL, $con); 
	
		while ($row = mssql_fetch_array($resultset)) 
		{
		     $ProIDDB[] = $row['ProID'];
		}   


//current year Copyright
$cyear = date("Y");
	
session_start();
$newusername = $_SESSION["newusername"];
$newpassword = $_SESSION["newpassword"];
$whosbuying = $_SESSION["whosbuying"];
$courseLanguage = $_SESSION["courseLanguage"];

$region_username = $_SESSION["region_username"];

$corporate_super_admin = $_SESSION["corporate_super_admin"];

$corporate_username=$_SESSION["corporate_username"];
$corpVC=$_SESSION["corpVC"];

$existingusername = $_SESSION["existingusername"];
$existingpassword = $_SESSION["existingpassword"];

$floridaCompany = $_SESSION["floridaCompany"];

 $month = $_SESSION["month"];
 $day = $_SESSION["day"];
 $year = $_SESSION["year"];


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

$realTotal = $_SESSION["realTotal"];
$realTotalQTY = $_SESSION["realTotalQTY"];
$numofcourses = $_SESSION["numofcourses"];

$Utah_work_phone = $_SESSION["Utah_work_phone"];
	 
	
if($whosbuying=='single' && $realTotalQTY==1 && $numofcourses==1)
{
	$addSudentToCourse = 'yes';
	$_SESSION["addSudentToCourse"]= $addSudentToCourse;
}
else
{
	$addSudentToCourse = 'no';
	$_SESSION["addSudentToCourse"]=$addSudentToCourse;
}	
	

if($existingusername)
{
	
	$whosbuying='multiple';
	
	// billing info
	$SQL99 = "SELECT * FROM [07O1] WHERE AN='$existingusername' ";
	$resultset99=mssql_query($SQL99, $con);


		while ($row = mssql_fetch_array($resultset99)) 
		{
		     $DIV_NAMEb = $row['DIV_NAME'];
		     $cardcn = $row['NCPY'];
		     $cardadd1 = $row['AA1'];
		     $cardadd2 = $row['AA2'];
		     $cardci = $row['ACI'];
		     $cardst = $row['AST'];
		     $cardzip = $row['AZ'];
		     $cardcou = $row['ACO'];
		     $cardphone = $row['AP'];
		     $cardem = $row['AM'];
		}   
	
	$DIV_NAMEbilling = explode("_", $DIV_NAMEb);
	$cardfn = $DIV_NAMEbilling[0];	//cardfn
	$cardln = $DIV_NAMEbilling[1];	//cardln
	
	

	// user info
	$SQL96 = "SELECT * FROM [07O6] WHERE AN='$existingusername' ";
	$resultset96=mssql_query($SQL96, $con);
	
		while ($row = mssql_fetch_array($resultset96)) 
		{
		     $DIV_NAMEc = $row['DIV_NAME'];
		     $usercn = $row['NCPY'];
		     $useradd1 = $row['AA1'];
		     $useradd2 = $row['AA2'];
		     $userci = $row['ACI'];
		     $userst = $row['AST'];
		     $userzip = $row['AZ'];
		     $usercou = $row['ACO'];
		     $userphone = $row['AP'];
		     $userem = $row['AM'];
		}   
	
	$DIV_NAMEcustomer = explode("_", $DIV_NAMEc);
	$userfn = $DIV_NAMEcustomer[0];	//userfn
	$userln = $DIV_NAMEcustomer[1];	//userln
	
	
	$checkfn = $userfn;
	$checkln = $userln;
	$checkcn = $usercn;
	$checkadd1 = $useradd1;
	$checkadd2 = $useradd2;
	$checkci = $userci;
	$checkst = $userst;
	$checkzip = $userzip;
	$checkcou = $usercou;
	$checkphone = $userphone;
	$checkem = $userem;
	
	
	

	
}

if($corporate_username && $corpVC)
{
	// corporate account info
	$SQL3 = "SELECT * FROM [07L2] WHERE UU='$corporate_username' ";
	$resultset3=mssql_query($SQL3, $con);


		while ($row = mssql_fetch_array($resultset3)) 
		{
		     $cardfn = $row['NF'];
		     $cardln = $row['NL'];
		     $cardcn = $row['UA'];
		     $cardadd1 = $row['AA1'];
		     $cardadd2 = $row['AA2'];
		     $cardci = $row['ACI'];
		     $cardst = $row['AST'];
		     $cardzip = $row['AZ'];
		     $cardcou = $row['ACO'];
		     $cardphone = $row['AP'];
		     $cardem = $row['UM'];
		}   
}




	
		//shows all the session variables/arrays and display them, except discode or empty spaces, after that creates an array with those results
foreach ($_SESSION as $key=>$val)
{
	if(in_array($key, $ProIDDB)){
		
		$sessionm[] = $val[2];
	}

}


	
	if($whosbuying=='single' && $realTotalQTY==1 && ($sessionm[0]=='fs' || $sessionm[0]=='oh2' || $sessionm[0]=='cb' 
	|| $sessionm[0]=='emws' || $sessionm[0]=='haccp' || $sessionm[0]=='sfis'  || $sessionm[0]=='refs'  || $sessionm[0]=='ifl' 
	|| $sessionm[0]=='rewi' || $sessionm[0]=='reri' || $sessionm[0]=='remn')){
		
		//echo 'single fs, cb, emws haccp or sfis course';
		$titlepage='Contact Information';
		$bdvisi='none';
		$studinfovisi='block';
		
		
	}
	elseif($whosbuying=='multiple' or $realTotalQTY >1 ){
		//echo "multiple licenses";
		$titlepage='Administrator Information';
		$studinfovisi='none';
		
		
	}
	else{
		$titlepage='Contact Information';
		$bdvisi='in-line';
		$studinfovisi='block';
	}
	
	

echo "
<script src='https://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.12.4.min.js'></script>
<link rel='stylesheet' href='https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css'>
<script src='https://code.jquery.com/ui/1.11.4/jquery-ui.js'></script>
<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Open+Sans' />
<meta name='viewport' content='width=device-width, initial-scale=1.0'>
<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
	
	
	<div id='wrapper'>
	
	<h2 style='text-align:center'>$titlepage</h2>
	
	
	
	<a href='sc_shopping_cart.php' style='text-decoration:none'><div id='shc'>


<p style='text-align:center;margin-top:10px'><img src='images/shoppingc.png' width='21'>
&nbsp;&nbsp;$$realTotal
</p>
</div>
</a>



<form name='cardform' action='sc_order_summaryvar.php' onsubmit='return validatecardForm()' method='post'>

<input type='hidden' value='$sessionm[0]' name='courseProID'>
<input type='hidden' value='$realTotalQTY' name='totalnumoftrainings'>
<input type='hidden' value='$whosbuying' name='whosbuyinginfo'>
<input type='hidden' name='samebilluserinfo' id='samebilluserinfo'>
<input type='hidden' name='courseLanguage' id='courseLanguage' value='$courseLanguage'>

";

	if($whosbuying=='single' && $realTotalQTY==1 && ($sessionm[0]=='fs' || $sessionm[0]=='oh2' || $sessionm[0]=='califsh' || $sessionm[0]=='nfon' || $sessionm[0]=='ilfsh' || $sessionm[0]=='mofsh' || $sessionm[0]=='azfsh' || $sessionm[0]=='nmfsh' || $sessionm[0]=='idfsh' || $sessionm[0]=='txfsh' || $sessionm[0]=='wvmvfsh' || $sessionm[0]=='wvchfsh' || $sessionm[0]=='wvwcfsh' || $sessionm[0]=='WVMV' || $sessionm[0]=='ohfsh' || $sessionm[0]=='vaccfsh' || $sessionm[0]=='fsrt' || $sessionm[0]=='utfsh' || $sessionm[0]=='flfsh' || $sessionm[0]=='ksfsh' || $sessionm[0]=='tufsh' || $sessionm[0]=='refs' || $sessionm[0]=='emws' || $sessionm[0]=='cf' || $sessionm[0]=='aa'))
	{
		echo "
				<div id='languagewrapper' style='width:100%;height:42px;border:1px solid transparent;margin:auto;margin-top:30px;overflow:hidden;background-color:white;color:white;font-weight:bold;'>
				
				<div id='languageopttions' style='width:30%;float:left;border:1px solid transparent;height:40px;text-align:center;background-color:white;color:black'><p style='margin-top:5px'>Course Language</p></div>
				
				<div id='englishopt' style='width:30%;float:left;border:1px solid #ddd;border-right:none;height:40px;text-align:center;background-color:#1E2B41;color:white;cursor:pointer'><p style='margin-top:5px'>English</p></div>
				
				<div id='spanishopt' style='width:30%;float:left;border:1px solid #ddd;border-left:none;height:40px;text-align:center;background-color:white;color:black;cursor:pointer'><p style='margin-top:5px'>Espa&ntilde;ol</p></div>
				
				</div>
		";
	}

if($whosbuying=='single' && $realTotalQTY==1 && $sessionm[0]=='akan'){
	echo "
			<div id='akan_div' style='border:1px solid transparent; width:90%;margin:auto; margin-top:50px'>
				<label>Course Language</label>
				<select id='akan_languages'>
					<option value='ENGLISH'>English</option>
					<option value='SPANISH'>Spanish</option>
					<option value='MANDARIN'>Mandarin</option>
					<option value='KOREAN'>Korean</option>
					<option value='VIETNAM'>Vietnamese</option>
					<option value='TAGALOG'>Tagalog</option>
				</select>
			</div>
		";
}		

echo "
 	<div id='studinfowrapper' style='display:$studinfovisi'>
	<div id='studentinfo' style='border-radius:3px;width:90%;height:auto;border:1px solid #ddd;margin:30px auto;overflow:hidden;'>
	<h3 style='text-align:center'>Certificate Information</h3>

	<div class='form-group'>
    <label>First Name of the student</label>
    <input class='form-control' type='text' id='cardstudfn' name='cardstudfn' value='$userfn' style='max-width:300px' maxlength='69'>
	</div>

	<div class='form-group'>
    <label>Last Name of the student</label>
    <input class='form-control' type='text' id='cardstudln' name='cardstudln' value='$userln' style='max-width:300px' maxlength='69'>
	</div>
	";


// birth date
echo "
	<span style='display:$bdvisi'><label>Date of Birth</label><br> <select style='font-size:18px;margin-left:5px' id='month' name='month'>
				 <option value='' select>Month</option>
	";				  
					  
		for ($monthnum = 1; $monthnum <= 12; $monthnum++) {
		   
			echo "<option value='$monthnum'>$monthnum</option>";
		} 

echo "
				</select>		
				<select style='font-size:18px' id='day' name='day'>
				<option value='' select>Day</option>	  
	";				  
					  
		for ($daynum = 1; $daynum <= 31; $daynum++) 
		{   
			echo "<option value='$daynum'>$daynum</option>";
		} 
echo "					
					</select>
					<select style='font-size:18px' id='year' name='year'>
					<option value='' select>Year</option>
	";				  
					  
		for ($yearnum = 1915; $yearnum <= 2010; $yearnum++) {
		   
			echo "<option value='$yearnum'>$yearnum</option>";
		} 

echo "		 
		</select></span>
		<br><br>
	";	




// for Utah show gender options
if($sessionm[0]=='utfsh' && $addSudentToCourse == 'yes')
{
	echo "
			<label>Gender</label><br>
			<select style='font-size:18px;margin-left:5px' id='Utah_gender' name='Utah_gender'>
			<option value='' select>Select your Gender</option>
			<option value='F' select>Female</option>
			<option value='M' select>Male</option>
			</select>

			<br><br>

			<label>Food Handler&rsquo;s City</label><br>
			<select style='font-size:18px;margin-left:5px' id='Utah_userci' name='Utah_userci'>
																		<option value=''>Click here to view list</option>
																	  	<option value='Alpine'>Alpine</option>
																		<option value='Alta'>Alta</option>
																		<option value='Altamont'>Altamont</option>
																		<option value='Alton'>Alton</option>
																		<option value='Amalga'>Amalga</option>
																		<option value='American Fork'>American Fork</option>
																		<option value='Annabella'>Annabella</option>
																		<option value='Antimony'>Antimony</option>
																		<option value='Apple Valley'>Apple Valley</option>
																		<option value='Aurora'>Aurora</option>
																		<option value='Ballard'>Ballard</option>
																		<option value='Bear River'>Bear River</option>
																		<option value='Beaver City'>Beaver City</option>
																		<option value='Beaver County'>Beaver County</option>
																		<option value='Beryl'>Beryl</option>
																		<option value='Bicknell'>Bicknell</option>
																		<option value='Big Water'>Big Water</option>
																		<option value='Blanding'>Blanding</option>
																		<option value='Bluffdale'>Bluffdale</option>
																		<option value='Bluffdale South'>Bluffdale South</option>
																		<option value='Boulder'>Boulder</option>
																		<option value='Bountiful'>Bountiful</option>
																		<option value='Box Elder County'>Box Elder County</option>
																		<option value='Brian Head'>Brian Head</option>
																		<option value='Brigham'>Brigham</option>
																		<option value='Bryce Canyon'>Bryce Canyon</option>
																		<option value='Cache County'>Cache County</option>
																		<option value='Cache Valley Transit'>Cache Valley Transit</option>
																		<option value='Cannonville'>Cannonville</option>
																		<option value='Carbon County'>Carbon County</option>
																		<option value='Castle Dale'>Castle Dale</option>
																		<option value='Castle Valley'>Castle Valley</option>
																		<option value='Cedar City'>Cedar City</option>
																		<option value='Cedar Fort'>Cedar Fort</option>
																		<option value='Cedar Hills'>Cedar Hills</option>
																		<option value='Centerfield'>Centerfield</option>
																		<option value='Centerville'>Centerville</option>
																		<option value='Central Valley'>Central Valley</option>
																		<option value='Charleston'>Charleston</option>
																		<option value='Circleville'>Circleville</option>
																		<option value='Clarkston'>Clarkston</option>
																		<option value='Clawson'>Clawson</option>
																		<option value='Clearfield'>Clearfield</option>
																		<option value='Cleveland'>Cleveland</option>
																		<option value='Clinton'>Clinton</option>
																		<option value='Coalville'>Coalville</option>
																		<option value='Corinne'>Corinne</option>
																		<option value='Cornish'>Cornish</option>
																		<option value='Cottonwood Heights'>Cottonwood Heights</option>
																		<option value='Daggett County'>Daggett County</option>
																		<option value='Daniel'>Daniel</option>
																		<option value='Davis County'>Davis County</option>
																		<option value='Delta'>Delta</option>
																		<option value='Deweyville'>Deweyville</option>
																		<option value='Draper'>Draper</option>
																		<option value='Draper City South'>Draper City South</option>
																		<option value='Duchesne City'>Duchesne City</option>
																		<option value='Duchesne County'>Duchesne County</option>
																		<option value='Eagle Mountain'>Eagle Mountain</option>
																		<option value='East Carbon'>East Carbon</option>
																		<option value='Elk Ridge'>Elk Ridge</option>
																		<option value='Elmo'>Elmo</option>
																		<option value='Elsinore'>Elsinore</option>
																		<option value='Elwood'>Elwood</option>
																		<option value='Emery City'>Emery City</option>
																		<option value='Emery County'>Emery County</option>
																		<option value='Enoch'>Enoch</option>
																		<option value='Enterprise'>Enterprise</option>
																		<option value='Ephraim'>Ephraim</option>
																		<option value='Erda'>Erda</option>
																		<option value='Escalante'>Escalante</option>
																		<option value='Eureka'>Eureka</option>
																		<option value='Fairfield'>Fairfield</option>
																		<option value='Fairview'>Fairview</option>
																		<option value='Falcon Hill Clearfield<'>Falcon Hill Clearfield</option>
																		<option value='Falcon Hill Davis'>Falcon Hill Davis</option>
																		<option value='Falcon Hill Riverdale'>Falcon Hill Riverdale</option>
																		<option value='Falcon Hill Roy'>Falcon Hill Roy</option>
																		<option value='Falcon Hill Sunset'>Falcon Hill Sunset</option>
																		<option value='Farmington'>Farmington</option>
																		<option value='Farr West'>Farr West</option>
																		<option value='Fayette'>Fayette</option>
																		<option value='Ferron'>Ferron</option>
																		<option value='Fielding'>Fielding</option>
																		<option value='Fillmore'>Fillmore</option>
																		<option value='Fountain Green'>Fountain Green</option>
																		<option value='Francis'>Francis</option>
																		<option value='Fruit Heights'>Fruit Heights</option>
																		<option value='Garden City'>Garden City</option>
																		<option value='Garfield County'>Garfield County</option>
																		<option value='Garland'>Garland</option>
																		<option value='Genola'>Genola</option>
																		<option value='Glendale'>Glendale</option>
																		<option value='Glenwood'>Glenwood</option>
																		<option value='Goshen'>Goshen</option>
																		<option value='Grand County'>Grand County</option>
																		<option value='Grantsville'>Grantsville</option>
																		<option value='Green River'>Green River</option>
																		<option value='Gunnison'>Gunnison</option>
																		<option value='Hanksville'>Hanksville</option>
																		<option value='Harrisville'>Harrisville</option>
																		<option value='Hatch'>Hatch</option>
																		<option value='Heber'>Heber</option>
																		<option value='Helper'>Helper</option>
																		<option value='Henefer'>Henefer</option>
																		<option value='Henrieville'>Henrieville</option>
																		<option value='Herriman'>Herriman</option>
																		<option value='Hideout'>Hideout</option>
																		<option value='Highland'>Highland</option>
																		<option value='Hildale'>Hildale</option>
																		<option value='Hinckley'>Hinckley</option>
																		<option value='Holden'>Holden</option>
																		<option value='Holladay'>Holladay</option>
																		<option value='Honeyville'>Honeyville</option>
																		<option value='Hooper'>Hooper</option>
																		<option value='Howell'>Howell</option>
																		<option value='Huntington'>Huntington</option>
																		<option value='Huntsville'>Huntsville</option>
																		<option value='Hurricane'>Hurricane</option>
																		<option value='Hyde Park'>Hyde Park</option>
																		<option value='Hyrum'>Hyrum</option>
																		<option value='Independence'>Independence</option>
																		<option value='Iron County'>Iron County</option>
																		<option value='Ivins'>Ivins</option>
																		<option value='Joseph'>Joseph</option>
																		<option value='Juab County<'>Juab County</option>
																		<option value='Junction'>Junction</option>
																		<option value='Kamas'>Kamas</option>
																		<option value='Kanab'>Kanab</option>
																		<option value='Kanarraville'>Kanarraville</option>
																		<option value='Kane County'>Kane County</option>
																		<option value='Kanosh'>Kanosh</option>
																		<option value='Kaysville'>Kaysville</option>
																		<option value='Kingston'>Kingston</option>
																		<option value='Koosharem'>Koosharem</option>
																		<option value='La Verkin'>La Verkin</option>
																		<option value='Lakepoint'>Lakepoint</option>
																		<option value='Laketown'>Laketown</option>
																		<option value='Layton'>Layton</option>
																		<option value='Leamington'>Leamington</option>
																		<option value='Leeds'>Leeds</option>
																		<option value='Lehi'>Lehi</option>
																		<option value='Levan'>Levan</option>
																		<option value='Lewiston'>Lewiston</option>
																		<option value='Lincoln'>Lincoln</option>
																		<option value='Lindon'>Lindon</option>
																		<option value='Loa'>Loa</option>
																		<option value='Logan'>Logan</option>
																		<option value='Lyman'>Lyman</option>
																		<option value='Lynndyl'>Lynndyl</option>
																		<option value='Manila'>Manila</option>
																		<option value='Manti'>Manti</option>
																		<option value='Mantua'>Mantua</option>
																		<option value='Mapleton'>Mapleton</option>
																		<option value='Marriott-Slaterville'>Marriott-Slaterville</option>
																		<option value='Marysvale'>Marysvale</option>
																		<option value='Mayfield'>Mayfield</option>
																		<option value='Meadow'>Meadow</option>
																		<option value='Mendon'>Mendon</option>
																		<option value='Midvale'>Midvale</option>
																		<option value='Midway'>Midway</option>
																		<option value='Milford'>Milford</option>
																		<option value='Millard County'>Millard County</option>
																		<option value='Millville'>Millville</option>
																		<option value='Minersville'>Minersville</option>
																		<option value='Moab'>Moab</option>
																		<option value='Mona'>Mona</option>
																		<option value='Monroe'>Monroe</option>
																		<option value='Monticello'>Monticello</option>
																		<option value='Morgan City'>Morgan City</option>
																		<option value='Morgan County'>Morgan County</option>
																		<option value='Moroni'>Moroni</option>
																		<option value='Mt. Pleasant'>Mt. Pleasant</option>
																		<option value='Murray'>Murray</option>
																		<option value='Myton'>Myton</option>
																		<option value='Naples'>Naples</option>
																		<option value='Nephi'>Nephi</option>
																		<option value='New Harmony'>New Harmony</option>
																		<option value='Newton'>Newton</option>
																		<option value='Nibley'>Nibley</option>
																		<option value='North Logan'>North Logan</option>
																		<option value='North Ogden'>North Ogden</option>
																		<option value='North Salt Lake'>North Salt Lake</option>
																		<option value='Oak City'>Oak City</option>
																		<option value='Oakley'>Oakley</option>
																		<option value='Ogden'>Ogden</option>
																		<option value='Ophir'>Ophir</option>
																		<option value='Orangeville'>Orangeville</option>
																		<option value='Orderville'>Orderville</option>
																		<option value='Orem'>Orem</option>
																		<option value='Panguitch'>Panguitch</option>
																		<option value='Paradise'>Paradise</option>
																		<option value='Paragonah'>Paragonah</option>
																		<option value='Park City'>Park City</option>
																		<option value='Park City East'>Park City East</option>
																		<option value='Parowan'>Parowan</option>
																		<option value='Payson'>Payson</option>
																		<option value='Perry'>Perry</option>
																		<option value='Piute County'>Piute County</option>
																		<option value='Plain City'>Plain City</option>
																		<option value='Pleasant Grove'>Pleasant Grove</option>
																		<option value='Pleasant View'>Pleasant View</option>
																		<option value='Plymouth'>Plymouth</option>
																		<option value='Portage'>Portage</option>
																		<option value='Price'>Price</option>
																		<option value='Providence'>Providence</option>
																		<option value='Provo'>Provo</option>
																		<option value='Randolph'>Randolph</option>
																		<option value='Redmond'>Redmond</option>
																		<option value='Rich County'>Rich County</option>
																		<option value='Richfield'>Richfield</option>
																		<option value='Richmond'>Richmond</option>
																		<option value='River Heights'>River Heights</option>
																		<option value='Riverdale'>Riverdale</option>
																		<option value='Riverton'>Riverton</option>
																		<option value='Rockville'>Rockville</option>
																		<option value='Rocky Ridge Town'>Rocky Ridge Town</option>
																		<option value='Roosevelt'>Roosevelt</option>
																		<option value='Roy'>Roy</option>
																		<option value='Rush Valley'>Rush Valley</option>
																		<option value='Salem'>Salem</option>
																		<option value='Salina'>Salina</option>
																		<option value='Salt Lake City'>Salt Lake City</option>
																		<option value='Salt Lake County'>Salt Lake County</option>
																		<option value='San Juan County'>San Juan County</option>
																		<option value='Sandy'>Sandy</option>
																		<option value='Sanpete County'>Sanpete County</option>
																		<option value='Santa Clara'>Santa Clara</option>
																		<option value='Santaquin'>Santaquin</option>
																		<option value='Santaquin South'>Santaquin South</option>
																		<option value='Saratoga Springs'>Saratoga Springs</option>
																		<option value='Scipio'>Scipio</option>
																		<option value='Scofield'>Scofield</option>
																		<option value='Sevier County'>Sevier County</option>
																		<option value='Sigurd'>Sigurd</option>
																		<option value='Smithfield'>Smithfield</option>
																		<option value='Snowville'>Snowville</option>
																		<option value='Snyderville Basin Tr Dist'>Snyderville Basin Tr Dist</option>
																		<option value='South Jordan'>South Jordan</option>
																		<option value='South Ogden'>South Ogden</option>
																		<option value='South Salt Lake'>South Salt Lake</option>
																		<option value='South Weber'>South Weber</option>
																		<option value='Spanish Fork'>Spanish Fork</option>
																		<option value='Spring City'>Spring City</option>
																		<option value='Springdale'>Springdale</option>
																		<option value='Springville'>Springville</option>
																		<option value='St. George'>St. George</option>
																		<option value='Stansbury Park'>Stansbury Park</option>
																		<option value='Sterling'>Sterling</option>
																		<option value='Stockton'>Stockton</option>
																		<option value='Summit County'>Summit County</option>
																		<option value='Sunnyside'>Sunnyside</option>
																		<option value='Sunset'>Sunset</option>
																		<option value='Syracuse'>Syracuse</option>
																		<option value='Tabiona'>Tabiona</option>
																		<option value='Taylorsville'>Taylorsville</option>
																		<option value='Tooele City'>Tooele City</option>
																		<option value='Tooele County'>Tooele County</option>
																		<option value='Toquerville'>Toquerville</option>
																		<option value='Torrey'>Torrey</option>
																		<option value='Tremonton'>Tremonton</option>
																		<option value='Trenton'>Trenton</option>
																		<option value='Tropic'>Tropic</option>
																		<option value='Uintah'>Uintah</option>
																		<option value='Uintah County'>Uintah County</option>
																		<option value='Utah County'>Utah County</option>
																		<option value='Utah Data Center SL Co'>Utah Data Center SL Co</option>
																		<option value='Utah Data Center Utah Co'>Utah Data Center Utah Co</option>
																		<option value='Vernal'>Vernal</option>
																		<option value='Vernon'>Vernon</option>
																		<option value='Vineyard'>Vineyard</option>
																		<option value='Virgin'>Virgin</option>
																		<option value='Wales'>Wales</option>
																		<option value='Wallsburg'>Wallsburg</option>
																		<option value='Wasatch County'>Wasatch County</option>
																		<option value='Washington City'>Washington City</option>
																		<option value='Washington County'>Washington County</option>
																		<option value='Washington Terrace'>Washington Terrace</option>
																		<option value='Wayne County'>Wayne County</option>
																		<option value='Weber County'>Weber County</option>
																		<option value='Wellington'>Wellington</option>
																		<option value='Wellsville'>Wellsville</option>
																		<option value='Wendover'>Wendover</option>
																		<option value='West Bountiful'>West Bountiful</option>
																		<option value='West Haven'>West Haven</option>
																		<option value='West Jordan'>West Jordan</option>
																		<option value='West Point'>West Point</option>
																		<option value='West Valley City'>West Valley City</option>
																		<option value='Willard'>Willard</option>
																		<option value='Woodland Hills'>Woodland Hills</option>
																		<option value='Woodruff'>Woodruff</option>
																		<option value='Woods Cross'>Woods Cross</option>
		</select>
		<br>
		<br>

		<div class='form-group'>
    	<label>Food Handler's Work Phone Number</label>
    	<input class='form-control' type='text' id='Utah_work_phone' name='Utah_work_phone' value='$Utah_work_phone' style='max-width:300px' maxlength='20'>
		</div>

	";

}


echo "

	</div>
	</div>	
		
				
		<div id='cardorcheck' style='width:100%;height:42px;border:1px solid transparent;margin:auto;margin-top:30px;overflow:hidden;background-color:white;color:white;font-weight:bold;'>
		
		<div id='pmethod' style='width:30%;float:left;border:1px solid transparent;height:40px;text-align:center;background-color:white;color:black'><p style='margin-top:5px'>Payment</p></div>
		
		<div id='card' style='width:30%;float:left;border:1px solid #ddd;border-right:none;height:40px;text-align:center;background-color:#1E2B41;color:white;cursor:pointer'><p style='margin-top:5px'><span id='cardoptmobil'>Credit/Debit</span> Card</p></div>
		
		<div id='check' style='width:30%;float:left;border:1px solid #ddd;border-left:none;height:40px;text-align:center;background-color:white;color:black;cursor:pointer'><p style='margin-top:5px'>Check/Wire</p></div>
		
		</div>
		
		
		
		<div id='billinginfo' style='border-radius:3px;width:90%;height:auto;border:1px solid #ddd;margin:20px auto;overflow:hidden;'>
		
		<h3 style='text-align:center'>Billing Information</h3>
";


	// super_admin_accounts 4u corp page
		if(!empty($corporate_super_admin))
		{



echo "	<label>Select Corporate/Regional Administrator</label>
		<br>
			<select name='CorporateSubAccountID' style='font-size:18px;margin-left:5px'>
	";

	if($region_username){
		$SQL94 = "SELECT id, UU, NF, NL FROM [07L2] WHERE SUB='$corporate_super_admin' AND UU='$region_username' ";
	}
	else{
		$SQL94 = "SELECT id, UU, NF, NL FROM [07L2] WHERE SUB='$corporate_super_admin' ";
	}
	$resultset94=mssql_query($SQL94, $con);
	
		while ($row = mssql_fetch_array($resultset94)) 
		{
		     $sub_accountsid = $row['id'];
		     $sub_accountsUU = $row['UU'];
		     $sub_accountsNF = $row['NF'];
		     $sub_accountsNL = $row['NL'];

			 echo "<option value='$sub_accountsid' style='font-size:19px'>$sub_accountsNF $sub_accountsNL($sub_accountsUU)</option>";
		} 	
		
echo "	</select>
		<br><br>
";

		}





echo "
		<div class='form-group'>
    	<label>First Name on credit/debit card</label>
   		<input class='form-control' type='text' id='cardfn' name='cardfn' value='$cardfn' style='max-width:300px' maxlength='69'>
		</div>
		
		<div class='form-group'>
    	<label>Last Name on credit/debit card</label>
   		<input class='form-control' type='text' id='cardln' name='cardln' value='$cardln' style='max-width:300px' maxlength='69'>
		</div>

		<div class='form-group'>
    	<label>Last 4 digits of credit/debit card</label>
   		<input class='form-control' type='text' id='last4' name='last4' value='$last4' style='max-width:100px' maxlength='4'>
		</div>

		<div class='form-group'>
    	<label>Credit/debit card Address line 1</label>
   		<input class='form-control' type='text' id='cardadd1' name='cardadd1' value='$cardadd1' style='max-width:500px' maxlength='75'>
		</div>

		<div class='form-group'>
    	<label>Credit/debit card Address line 2 (optional)</label>
   		<input class='form-control' type='text' id='cardadd2' name='cardadd2' value='$cardadd2' style='max-width:500px' maxlength='75'>
		</div>

		<div class='form-group'>
    	<label>City</label>
   		<input class='form-control' type='text' id='cardci' name='cardci' value='$cardci' style='max-width:300px' maxlength='50'>
		</div>

		<div class='form-group'>
    	<label>State</label>
   		<input class='form-control' type='text' id='cardst' name='cardst' value='$cardst' style='max-width:300px' maxlength='50'>
		</div>
	";

		if($sessionm[0]=='oh2' && isset($newusername)){
			echo "<div class='form-group'>";


			echo "<label>Region</label>";
			echo "<br>";
			echo "<select style='font-size:18px;margin-left:5px' name='oh2_id'>";
																		
			$SQL1 = "SELECT id, county FROM ohioProctor ORDER BY county";
			$resultset1=mssql_query($SQL1, $con); 
			while ($row = mssql_fetch_array($resultset1)) 
			{
		     	$oh2_county = $row['county'];
		     	$oh2_id = $row['id'];
				echo "<option value='$oh2_id'>$oh2_county</option>";
			}
			echo "</select>";
						echo "<br>";

			echo "<span style='font-size:15px;margin-left:5px'><strong>If you are purchasing for multiple locations call TAP Series – 888-826-5222, extension 101.</strong></span>";
			echo "<br>";
			echo "<span style='font-size:15px;margin-left:5px'><strong>If your county is not in the list above, you can take the exam at a local test center. </strong></span>";
			echo "<br>";
			echo "<span style='font-size:15px;margin-left:5px'><strong>Click <a href='/testcenters/' target='_blank'>here</a> to locate a test center.</strong></span>";

			echo "</div>";
		
		}

echo "
		<div class='form-group'>
    	<label>Zip Code</label>
   		<input class='form-control' type='text' id='cardzip' name='cardzip' value='$cardzip' style='max-width:100px' maxlength='15'>
		</div>

		<div class='form-group'>
    	<label>Country</label>
   		<input class='form-control' type='text' id='cardcou' name='cardcou' value='$cardcou' style='max-width:200px' maxlength='50'>
		</div>

		<div class='form-group'>
    	<label>Phone Number</label>
   		<input class='form-control' type='text' id='cardphone' name='cardphone' value='$cardphone' style='max-width:200px' maxlength='20'>
		</div>

		<div class='form-group'>
    	<label>Email</label>
   		<input class='form-control' type='text' id='cardem' name='cardem' value='$cardem' style='max-width:400px' maxlength='69'>
		</div>

		<div class='form-group'>
    	<label>Confirm Email</label>
   		<input class='form-control' type='text' id='cardem_c' name='cardem_c' value='$cardem' style='max-width:400px' maxlength='69'>
		</div>

		
			";

	if($sessionm[0] != "flfsh")
	{
		echo "			
			<div class='form-group'>
			<label>School/Company Name</label>
			<input class='form-control' type='text' id='cardcn' name='cardcn' value='$cardcn' style='max-width:400px' maxlength='50'>
			</div>

			";
	}		

	if($sessionm[0] == "flfsh")
	{
		echo "	
			<div class='form-group'>
    		<label>Company Name (Florida)</label>
   			<input class='form-control' type='text' name='floridaCompany' id='floridaCompany' value='$floridaCompany' style='max-width:400px'>
			</div>

			";
	}
	
echo "	
		
		
		<div id='isthisyourcard' style='max-width:800px;height:auto;border:1px solid transparent;margin:auto;margin-top:30px;overflow:hidden;background-color:white;color:white;font-weight:bold;'>
		<div id='questioncard' style='width:100%;border:1px solid transparent;height:auto;text-align:center;background-color:white;color:black'><p style='margin-top:5px'>Is this your credit/debit card?</p></div>
		<div id='yescard'><p style='margin-top:5px'>Yes</p></div>
		<div id='nocard'><p style='margin-top:5px'>No</p></div>
		</div>		

		<p id='continuebtn_bi' style='text-align:center;margin-top:50px'><button id='btncontinue1'>Continue</button></p>
		
		<br>
		
		
		
		</div>
		
		
		
		
		
		
		<div id='customerinformation' style='border-radius:3px;width:90%;height:auto;border:1px solid #ddd;margin:20px auto;overflow:hidden;'>
		
		<h3 style='text-align:center'>Customer Information</h3>

		<div class='form-group'>
    	<label>Your First Name</label>
   		<input class='form-control' type='text' id='userfn' name='userfn' value='$userfn' style='max-width:300px' maxlength='69'>
		</div>

		<div class='form-group'>
    	<label>Your Last Name</label>
   		<input class='form-control' type='text' id='userln' name='userln' value='$userln' style='max-width:300px' maxlength='69'>
		</div>

		<div class='form-group'>
    	<label>School/Company Name</label>
   		<input class='form-control' type='text' id='usercn' name='usercn' value='$usercn' style='max-width:400px' maxlength='50'>
		</div>

		<div class='form-group'>
    	<label>Address Line 1</label>
   		<input class='form-control' type='text' id='useradd1' name='useradd1' value='$useradd1' style='max-width:500px' maxlength='75'>
		</div>

		<div class='form-group'>
    	<label>Address Line 2</label>
   		<input class='form-control' type='text' id='useradd2' name='useradd2' value='$useradd2' style='max-width:500px' maxlength='75'>
		</div>
	";

	// if course is single Utah FH and user will take it, hide student city because we asked for it above
	if($sessionm[0]=='utfsh' && $addSudentToCourse = 'yes')
	{
		echo"";
	}
	else
	{
		echo "	
				<div class='form-group'>
				<label>City</label>
				<input class='form-control' type='text' id='userci' name='userci' value='$userci' style='max-width:300px' maxlength='50'>
				</div>
			";
	}

echo "
		<div class='form-group'>
    	<label>State</label>
   		<input class='form-control' type='text' id='userst' name='userst' value='$userst' style='max-width:300px' maxlength='50'>
		</div>

		<div class='form-group'>
    	<label>Zip Code</label>
   		<input class='form-control' type='text' id='userzip' name='userzip' value='$userzip' style='max-width:100px' maxlength='15'>
		</div>

		<div class='form-group'>
    	<label>Country</label>
   		<input class='form-control' type='text' id='usercou' name='usercou' value='$usercou' style='max-width:200px' maxlength='50'>
		</div>

		<div class='form-group'>
    	<label>Phone Number</label>
   		<input class='form-control' type='text' id='userphone' name='userphone' value='$userphone' style='max-width:200px' maxlength='20'>
		</div>

		<div class='form-group'>
    	<label>Email</label>
   		<input class='form-control' type='text' id='userem' name='userem' value='$userem' style='max-width:400px' maxlength='69'>
		</div>

		<p id='continuebtn_ci' style='text-align:center;margin-top:50px'><button class='continuebtn_ci_btn'>Continue</button></p>
		</div>
		</form>		
		
		
		
		<div id='customerinformation_check' style='border-radius:3px;width:90%;height:auto;border:1px solid #ddd;margin:20px auto;overflow:hidden;'>
		
		<h3 style='text-align:center'>Customer Information (check)</h3>
		
		<form name='checkform' action='sc_check_order_summaryvar.php' onsubmit='return validatecheckForm()' method='post'>

		<div class='form-group'>
    	<label>Your First Name</label>
   		<input class='form-control' type='text' id='checkfn' name='checkfn' value='$checkfn' style='max-width:300px' maxlength='69'>
		</div>

		<div class='form-group'>
    	<label>Your Last Name</label>
   		<input class='form-control' type='text' id='checkln' name='checkln' value='$checkln' style='max-width:300px' maxlength='69'>
		</div>

		<div class='form-group'>
    	<label>School/Company Name</label>
   		<input class='form-control' type='text' id='checkcn' name='checkcn' value='$checkcn' style='max-width:400px' maxlength='50'>
		</div>

		<div class='form-group'>
    	<label>Address Line 1</label>
   		<input class='form-control' type='text' id='checkadd1' name='checkadd1' value='$checkadd1' style='max-width:500px' maxlength='75'>
		</div>

		<div class='form-group'>
    	<label>Address Line 2 (optional)</label>
   		<input class='form-control' type='text' id='checkadd2' name='checkadd2' value='$checkadd2' style='max-width:500px' maxlength='75'>
		</div>

		<div class='form-group'>
    	<label>City</label>
   		<input class='form-control' type='text' id='checkci' name='checkci' value='$checkci' style='max-width:300px' maxlength='50'>
		</div>

		<div class='form-group'>
    	<label>State</label>
   		<input class='form-control' type='text' id='checkst' name='checkst' value='$checkst' style='max-width:300px' maxlength='50'>
		</div>

		<div class='form-group'>
    	<label>Zip Code</label>
   		<input class='form-control' type='text' id='checkzip' name='checkzip' value='$checkzip' style='max-width:100px' maxlength='15'>
		</div>

		<div class='form-group'>
    	<label>Country</label>
   		<input class='form-control' type='text' id='checkcou' name='checkcou' value='$checkcou' style='max-width:200px'  maxlength='50'>
		</div>

		<div class='form-group'>
    	<label>Phone Number</label>
   		<input class='form-control' type='text' id='checkphone' name='checkphone' value='$checkphone' style='max-width:200px'  maxlength='20'>
		</div>

		<div class='form-group'>
    	<label>Email</label>
   		<input class='form-control' type='text' id='checkem' name='checkem' value='$checkem' style='max-width:400px'  maxlength='69'>
		</div>

		<p style='margin-left:10px'><strong>WIRE TRANSFER</strong>
		<ul>
			<li><small>Wire transfers are for international customers only.</small></li>
			<li><small>Please add a $15 wire fee to your order total and send an email to info@tapseries.com with the order number.</small></li>
			<li><small>Wire transfer instructions will be emailed to you.</small></li>
		</ul>

		<p id='continuebtn_ci' style='text-align:center;margin-top:50px'><button class='continuebtn_ci_btn' type='submit'>Continue</button></p>
		</form>
		
		</div>
		
		
		<br><br>
		<p style='text-align:center'><strong>&#169; Copyright $cyear TAP Series, LLC <br><a style='text-decoration:none' href='/home/privacy'>Privacy Policy</a></strong></p>

		</div>


";


//print_r($_SESSION);
?>

<style>
.continuebtn_ci_btn{
	width:50%;
	height:50px;
	background-color:#3079ed;
	border:1px solid transparent;
	border-radius:3px;
	font-size:20px;
	color:white;
	font-weight:bold;
	cursor:pointer;
}
.continuebtn_ci_btn:hover{
	background-color:#318fed;
}

#btncontinue1{
	width:50%;
	height:50px;
	background-color:#3079ed;
	border:1px solid transparent;
	border-radius:3px;
	font-size:20px;
	color:white;
	font-weight:bold;
	cursor:pointer;
}
#btncontinue1:hover{
	background-color:#318fed;
}

#floridaCompany{
	width:70%;
}

#nocard{
	width:48%;
	float:left;
	border:1px solid #ddd;
	height:40px;
	text-align:center;
	background-color:white;
	color:black;
	cursor:pointer;
	background-color:#1E2B41;
	color:white;
}
#nocard:hover{
	background-color:white;
	color:black;
	border:1px solid black;
}
#yescard{
	width:48%;
	float:left;
	border:1px solid #ddd;
	height:40px;
	text-align:center;
	background-color:#1E2B41;
	color:white;cursor:pointer;
}
#yescard:hover{
	background-color:white;
	color:black;
	border:1px solid black;
}
input{
	font-size:18px
}
.form-control {
	font-size:18px;
	margin-left:5px
}	

label{
	margin-left:5px;
}

#shc{
	border:1px solid transparent;
	background-color:#333;
	height:50px;
	color:white;
	width:150px;
	margin-left:-1px;
	border-top-right-radius:10px;
	border-bottom-right-radius:10px;
	-webkit-transition: width 2s; /* For Safari 3.1 to 6.0 */
    transition: width 2s;
}
#shc:hover{
	background-color:#404040;
	width: 180px;
}
#wrapper{
	max-width:1000px;
	height:auto;
	border:1px solid #1E2B41;
	background-color:white;
	margin:30px auto;
	border-radius:5px;
	overflow:hidden;
}
body{
	background-color:#1E2B41;
	font-family: 'Open Sans', sans-serif;  
	font-size:20px;
}





@media only screen and (max-width: 600px) {
	#cardoptmobil{display:none}
}
</style>


<script>

$(document).ready(function(){

$(function() {
    $( "#floridaCompany" ).autocomplete({
        source: 'floridaLicense.php',
		minLength:1,
		
    });
});
});

</script>

<script>
$(document).ready(function(){
	
	$("#akan_languages").change(function(){
		$("#courseLanguage").val($(this).val());
	});
	
	 $('#cardem, #cardem_c').bind("cut copy paste",function(e) {
          e.preventDefault();
      });
	
	
	
	$("#customerinformation").hide();
	$("#continuebtn_bi").hide();
	$("#customerinformation_check").hide();
	$("#card").css({"background-color": "#1E2B41", "color": "white"});
	
	if($("#courseLanguage").val() == "")
	{
	$("#courseLanguage").val("ENGLISH");
	}
	
	if($("#courseLanguage").val() == "SPANISH")
	{
		$("#spanishopt").css({"background-color": "#1E2B41", "color": "white"});
		$("#englishopt").css({"background-color": "white", "color": "black"});
	}
	


	
	$("#spanishopt").click(function(){
		$("#spanishopt").css({"background-color": "#1E2B41", "color": "white"});
		$("#englishopt").css({"background-color": "white", "color": "black"});
		$("#courseLanguage").val("SPANISH");
	});
	
	
	$("#englishopt").click(function(){
		$("#englishopt").css({"background-color": "#1E2B41", "color": "white"});
		$("#spanishopt").css({"background-color": "white", "color": "black"});
		$("#courseLanguage").val("ENGLISH");
	});
	
	
	
    $("#check").click(function(){
		$("#check").css({"background-color": "#1E2B41", "color": "white"});
		$("#card").css({"background-color": "white", "color": "black"});
		$("#customerinformation_check").show();
		$("#customerinformation").hide();
        $("#billinginfo").hide();
        $("#studentinfo").hide();
		
    });
	
	$("#card").click(function(){
		$("#card").css({"background-color": "#1E2B41", "color": "white"});
		$("#check").css({"background-color": "white", "color": "black"});
		$("#customerinformation_check").hide();
		$("#customerinformation").hide();
        $("#billinginfo").show();
        $("#studentinfo").show();
    });
	
	$("#yescard").click(function(){
		$("#nocard").css({"background-color": "white", "color": "black"});
		$("#yescard").css({"background-color": "#1E2B41", "color": "white"});
		$("#continuebtn_bi").show();
		$("#customerinformation").hide();
		$("#samebilluserinfo").val("yes");
		//$("#userfn").val("");
		//$("#userln").val("");
		$("#usercn").val("");
		$("#useradd1").val("");
		$("#useradd2").val("");
		$("#userci").val("");
		$("#userst").val("");
		$("#userzip").val("");
		$("#usercou").val("");
		$("#userphone").val("");
		$("#userem").val("");
	});
	
	$("#nocard").click(function(){
		$("#yescard").css({"background-color": "white", "color": "black"});
		$("#nocard").css({"background-color": "#1E2B41", "color": "white"});
		$("#continuebtn_bi").hide();
		$("#customerinformation").show();
		$("#samebilluserinfo").val("no");
		$("#userfn").val($("#cardstudfn").val());
		$("#userln").val($("#cardstudln").val());
	});

<?php
	if($_SESSION['displayname']=="Ghirardelli" && $realTotal>0) {  ?>
		$("#continuebtn_bi").show();
		$("#isthisyourcard").hide();
<?php	} ?>

});


function validatecardForm() {
	
	var hasNumber = /\d/;
	var hasLetter = /[a-zA-Z]/;
	
	var courseProID = document.forms["cardform"]["courseProID"].value;
	var totalnumoftrainings = document.forms["cardform"]["totalnumoftrainings"].value;
	var whosbuyinginfo = document.forms["cardform"]["whosbuyinginfo"].value;
	var samebilluserinfo = document.forms["cardform"]["samebilluserinfo"].value;
	
	
	//this will validate the certificate information depending on the course and quantity
	if(whosbuyinginfo=='single' && totalnumoftrainings==1)
	{
	

	
	var kk = document.forms["cardform"]["cardstudfn"].value;
    if (kk == null || kk == "") {
        alert("First Name of the Student must be filled out");
		document.getElementById("cardstudfn").focus();
        return false;
    }
	if(hasNumber.test(kk)){  
	  document.getElementById("cardstudfn").focus();
      alert('Numbers are not allowed on First Name of the Student'); 
      return false;  
      }  


	var ll = document.forms["cardform"]["cardstudln"].value;
    if (ll == null || ll == "") {
        alert("Last Name of the Student must be filled out");
		document.getElementById("cardstudln").focus();
        return false;
    }
	if(hasNumber.test(ll)){  
	document.getElementById("cardstudln").focus();
    alert('Numbers are not allowed on Last Name of the Student'); 
    return false;  
    } 
	
	
	
	
	
		// birthdate information will be validated here depending on the situation
	if(whosbuyinginfo=='single' && totalnumoftrainings==1 && courseProID!='fs' && courseProID!='oh2' && courseProID!='cb' && courseProID!='emws' && courseProID!='haccp' && courseProID!='sfis' && courseProID!='rewi' && courseProID!='reri' && courseProID!='refs' && courseProID!='remn' && courseProID!='ifl')
	{
		
	var mm = document.forms["cardform"]["month"].value;
    if (mm == null || mm == "") {
        alert("Month must be filled out");
		document.getElementById("month").focus();
        return false;
    }
	var nn = document.forms["cardform"]["day"].value;
    if (nn == null || nn == "") {
        alert("Day must be filled out");
		document.getElementById("day").focus();
        return false;
    }
	var oo = document.forms["cardform"]["year"].value;
    if (oo == null || oo == "") {
        alert("Year must be filled out");
		document.getElementById("year").focus();
        return false;
    }
	
	}
	
	
	
	}
	
	
	
		//billing information
	var aa = document.forms["cardform"]["cardfn"].value;
    if (aa == null || aa == "") {
        alert("First Name on credit/debit card must be filled out");
		document.getElementById("cardfn").focus();
        return false;
    }
	if(hasNumber.test(aa)){  
	alert('Numbers are not allowed on First Name on credit/debit card'); 	
	document.getElementById("cardfn").focus();
    return false;  
    }

	var bb = document.forms["cardform"]["cardln"].value;
    if (bb == null || bb == "") {
        alert("Last Name on credit/debit card must be filled out");
		document.getElementById("cardln").focus();
        return false;
    }
	if(hasNumber.test(bb)){  
	document.getElementById("cardln").focus();
    alert('Numbers are not allowed on Last Name on credit/debit card'); 
    return false;  
    }

	/*
	var qqq1 = document.forms["cardform"]["last4"].value;
    if (qqq1 == null || qqq1 == "") {
        alert("Last 4 digits of credit/debit card must be filled out");
		document.getElementById("last4").focus();
        return false;
    }
	

	if(hasLetter.test(qqq1)){  
	document.getElementById("last4").focus();
    alert('Only numbers are allowed on Last 4 digits of credit/debit card'); 
    return false;  
    }

	
	
	var dd = document.forms["cardform"]["cardadd1"].value;
    if (dd == null || dd == "") {
        alert("Address Line 1 must be filled out");
		document.getElementById("cardadd1").focus();
        return false;
    }
	var ee = document.forms["cardform"]["cardci"].value;
    if (ee == null || ee == "") {
        alert("City must be filled out");
		document.getElementById("cardci").focus();
        return false;
    }
	var ff = document.forms["cardform"]["cardst"].value;
    if (ff == null || ff == "") {
        alert("State must be filled out");
		document.getElementById("cardst").focus();
        return false;
    }
	*/


	var gg = document.forms["cardform"]["cardzip"].value;
    if (gg == null || gg == "") {
        alert("Zip Code must be filled out");
		document.getElementById("cardzip").focus();
        return false;
    }

	/*
	var hh = document.forms["cardform"]["cardcou"].value;
    if (hh == null || hh == "") {
        alert("Country must be filled out");
		document.getElementById("cardcou").focus();
        return false;
    }
	var ii = document.forms["cardform"]["cardphone"].value;
    if (ii == null || ii == "") {
        alert("Phone Number must be filled out");
		document.getElementById("cardphone").focus();
        return false;
    }
	*/
	
	if(courseProID=='fs' || courseProID=='oh2' || courseProID=='cb' || courseProID=='emws' || courseProID=='haccp' || courseProID=='sfis')
	{
		var jj = document.forms["cardform"]["cardem"].value;
		if (jj == null || jj == "") {
			alert("Email must be filled out");
			document.getElementById("cardem").focus();
			return false;
    	}

		var jjjj = document.forms["cardform"]["cardem_c"].value;
		if (jjjj == null || jjjj == "") {
			alert("Confirm Email must be filled out");
			document.getElementById("cardem_c").focus();
			return false;
    	}

		if(jj != jjjj){
			alert("Please make sure Email is exactly the same as Confirm Email");
			document.getElementById("cardem_c").focus();
        	return false;
		}
	}
	
	
	/*
	if(courseProID!='flfsh')
	{
		var cc = document.forms["cardform"]["cardcn"].value;
		if (cc == null || cc == "") {
			alert("School/Company Name must be filled out");
			document.getElementById("cardcn").focus();
			return false;
		}
	}
	*/
	
	
	if(courseProID=='flfsh')
	{
		var fl = document.forms["cardform"]["floridaCompany"].value;
		if (fl == null || fl == "") {
			alert("Company Name must be filled out");
			document.getElementById("floridaCompany").focus();
			return false;
		}
	}
	
	
	
	
	
	
	if(samebilluserinfo=='no')
	{
	
	//user information
	var aaa = document.forms["cardform"]["userfn"].value;
    if (aaa == null || aaa == "") {
        alert("Your First Name must be filled out");
		document.getElementById("userfn").focus();
        return false;
    }
	var bbb = document.forms["cardform"]["userln"].value;
    if (bbb == null || bbb == "") {
        alert("Your Last Name must be filled out");
		document.getElementById("userln").focus();
        return false;
    }
	var ccc = document.forms["cardform"]["usercn"].value;
    if (ccc == null || ccc == "") {
        alert("School/Company Name must be filled out");
		document.getElementById("usercn").focus();
        return false;
    }
	var ddd = document.forms["cardform"]["useradd1"].value;
    if (ddd == null || ddd == "") {
        alert("Address Line 1 must be filled out");
		document.getElementById("useradd1").focus();
        return false;
    }
	var eee = document.forms["cardform"]["userci"].value;
    if (eee == null || eee == "") {
        alert("City must be filled out");
		document.getElementById("userci").focus();
        return false;
    }
	var fff = document.forms["cardform"]["userst"].value;
    if (fff == null || fff == "") {
        alert("State must be filled out");
		document.getElementById("userst").focus();
        return false;
    }
	var ggg = document.forms["cardform"]["userzip"].value;
    if (ggg == null || ggg == "") {
        alert("Zip Code must be filled out");
		document.getElementById("userzip").focus();
        return false;
    }
	var hhh = document.forms["cardform"]["usercou"].value;
    if (hhh == null || hhh == "") {
        alert("Country must be filled out");
		document.getElementById("usercou").focus();
        return false;
    }
	var iii = document.forms["cardform"]["userphone"].value;
    if (iii == null || iii == "") {
        alert("Phone Number must be filled out");
		document.getElementById("userphone").focus();
        return false;
    }
	
	if(courseProID=='fs' || courseProID=='oh2' || courseProID=='cb' || courseProID=='emws' || courseProID=='haccp' || courseProID=='sfis')
	{
	
	var jjj = document.forms["cardform"]["userem"].value;
    if (jjj == null || jjj == "") {
        alert("Email must be filled out");
		document.getElementById("userem").focus();
        return false;
    }
	}
	
	
}
	

	
	
	
}

<?php if($_SESSION['displayname']=="Ghirardelli" && $realTotal=="0.00") { ?>
	
function load(){
	document.cardform.submit()
}

load();
<?php	} ?>


function validatecheckForm() {
	
	var a = document.forms["checkform"]["checkfn"].value;
    if (a == null || a == "") {
        alert("First Name must be filled out");
		document.getElementById("checkfn").focus();
        return false;
    }
	var b = document.forms["checkform"]["checkln"].value;
    if (b == null || b == "") {
        alert("Last Name must be filled out");
		document.getElementById("checkln").focus();
        return false;
    }
	var c = document.forms["checkform"]["checkcn"].value;
    if (c == null || c == "") {
        alert("School/Company Name must be filled out");
		document.getElementById("checkcn").focus();
        return false;
    }
	var d = document.forms["checkform"]["checkadd1"].value;
    if (d == null || d == "") {
        alert("Address Line 1 must be filled out");
		document.getElementById("checkadd1").focus();
        return false;
    }
	var e = document.forms["checkform"]["checkci"].value;
    if (e == null || e == "") {
        alert("City must be filled out");
		document.getElementById("checkci").focus();
        return false;
    }
	var f = document.forms["checkform"]["checkst"].value;
    if (f == null || f == "") {
        alert("State must be filled out");
		document.getElementById("checkst").focus();
        return false;
    }
	var g = document.forms["checkform"]["checkzip"].value;
    if (g == null || g == "") {
        alert("Zip Code must be filled out");
		document.getElementById("checkzip").focus();
        return false;
    }
	var h = document.forms["checkform"]["checkcou"].value;
    if (h == null || h == "") {
        alert("Country must be filled out");
		document.getElementById("checkcou").focus();
        return false;
    }
	var i = document.forms["checkform"]["checkphone"].value;
    if (i == null || i == "") {
        alert("Phone Number must be filled out");
		document.getElementById("checkphone").focus();
        return false;
    }
	var j = document.forms["checkform"]["checkem"].value;
    if (j == null || j == "") {
        alert("Email must be filled out");
		document.getElementById("checkem").focus();
        return false;
    }
	
	
	
	
	
}


<?php
if($_SESSION["discode"]=="ol2"){
    echo "  
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-90592116-1', 'auto');
            ga('send', 'pageview');
        ";    
}
?>

</script>


