<?php
//error_reporting(0); 

$user=$_SERVER['DB_USERNAME'];
$password=$_SERVER['DB_PASSWORD'];
$server=$_SERVER['DB_HOSTNAME'];
$database='newtap';
   
// Connect to the database (host, username, password)
$con = mssql_connect($server,$user,$password) or die('Could not connect to the server!');
mssql_select_db($database, $con) or die('Could not select a database.'); 

session_start();

// testing  corporate_username
$corporate_username = $_SESSION['user'];

	$SQL0 = "SELECT VC FROM [07L2] WHERE UU = '$corporate_username' ";				
		$resultset0=mssql_query($SQL0, $con); 	
		
			while ($row = mssql_fetch_array($resultset0)) 
			{
				$corpVC = $row['VC'];
			}

			if($corpVC  != ''){
				$_SESSION["corporate_username"] = "$corporate_username";
                $_SESSION["corpVC"] = "$corpVC";
			}


?>
<!DOCTYPE html>
<html>
<head>
<title>Place Orders</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
</head>
<body>
<?php include $_SERVER['DOCUMENT_ROOT'].'/shared/header.php';?>	

<!-- Show Menu if corporate administrator has place orders menu enable -->
<div class="container" <?php if ($corpVC  != ''){echo"style='display:block;margin-bottom:450px;margin-top:100px'";}else{echo"style='display:none'";}?>>

    <div class="page-header">
    <h1>Purchase Courses</h1>
    <p>Please select a category from the list below</p>
    </div>

        <div class='well' >
		<h4><strong>Terms of Purchase</strong></h4>
		100% money back of the purchase price, or credit to your corporate account, if returned within 30 days of enrollment, and if no more than lesson 1 has been studied. If you have any questions or comments on our return policy/terms of purchase, please feel free to contact us at 888-826-5222.<br><br>Courses are purchased as single use enrollments. Each lesson allows up to 5 reviews. After 5 reviews the lesson is closed. Courses are active for 180 days from date of enrollment and will stop functioning 180 days after the enrollment. Within the 180 day active period, the name of the student can be changed for a $20 fee for all courses except Food Handler, if a TAP Certificate of Achievement has NOT been awarded. Changing of the name will not re-activate any inactive, closed or ended functions. We reserve the right to charge a $5 fee for Food Handler name changes. To submit a name change form, click here.
		</div>

    <div class="panel-group">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" href="#collapse1">Allergen Friendly</a>
                </h4>
            </div>
            <div id="collapse1" class="panel-collapse collapse">
                <div class="panel-body"><a href='allergenfriendly/aa'>Allergen Awareness</a></div>
                <div class="panel-body"><a href='allergenfriendly/ad'>Allergen Plan Development</a></div>
                <div class="panel-body"><a href='allergenfriendly/as'>Allergen Plan Specialist</a></div>
             </div>
        </div>
    </div>

    <div class="panel-group">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" href="#collapse2">Food Handler Training</a>
                </h4>
            </div>
            <div id="collapse2" class="panel-collapse collapse">
                <div class="panel-body"><a href='foodhandler/akan'>Anchorage, AK Food Handler</a></div>
                <div class="panel-body"><a href='foodhandler/azfsh'>Arizona Food Handler Training</a></div>
                <div class="panel-body"><a href='foodhandler/califsh'>California Food Handler Training</a></div>
                <div class="panel-body"><a href='foodhandler/flfsh'>Florida Food Worker Training Program</a></div>
                <div class="panel-body"><a href='foodhandler/nfon'>Food Handler Training (all other states)</a></div>
                <div class="panel-body"><a href='foodhandler/idfsh'>Idaho Food Handler Training</a></div>
                <div class="panel-body"><a href='foodhandler/ilfsh'>Illinois Food Handler Training</a></div>
                <div class="panel-body"><a href='foodhandler/mofsh'>Jackson County MO Food Handler Training</a></div>
                <div class="panel-body"><a href='foodhandler/nmfsh'>New Mexico County MO Food Handler Training</a></div>
                <div class="panel-body"><a href='foodhandler/vaccfsh'>Norfolk VA County MO Food Handler Training</a></div>
                <div class="panel-body"><a href='foodhandler/ohfsh'>Ohio Level One Certification</a></div>
                <div class="panel-body"><a href='foodhandler/txfsh'>Texas Food Handler Training</a></div>
                <div class="panel-body"><a href='foodhandler/utfsh'>Utah Food Handler Training</a></div>
                <div class="panel-body"><a href='foodhandler/ksfsh'>Wichita KS Food Handler Training</a></div>
             </div>
        </div>
    </div>

    <div class="panel-group">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" href="#collapse3">Food Safety Manager</a>
                </h4>
            </div>
            <div id="collapse3" class="panel-collapse collapse">
                <div class="panel-body"><a href='foodsafetymanager/fs'>Food Safety Manager Certification Training</a></div>
                <div class="panel-body"><a href='foodsafetymanager/fsrt'>Retail Food Safety Manager Certification Training</a></div>
                <div class="panel-body"><a href='foodsafetymanager/refs'>Food Safety Re-Certification Training</a></div>
             </div>
        </div>
    </div>

    <div class="panel-group">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" href="#collapse4">Other Courses</a>
                </h4>
            </div>
            <div id="collapse4" class="panel-collapse collapse">
                <div class="panel-body"><a href='foodserviceoperations/cf'>Chef Fundamentals</a></div>
                <div class="panel-body"><a href='foodserviceoperations/cb'>Cooking Basics</a></div>
                <div class="panel-body"><a href='foodserviceoperations/emws'>Earn More With Service</a></div>
                <div class="panel-body"><a href='haccp/nhaccp'>HACCP Managers Certificate Course</a></div>
                <div class="panel-body"><a href='foodserviceoperations/sfis'>Strategies for Increasing Sales</a></div>
             </div>
        </div>
    </div>

</div>


<!-- Show message if corporate administrator doesn't have Place Orders enable -->
<div class="container" <?php if ($corpVC  == ''){echo"style='display:block;margin-bottom:350px;margin-top:150px'";}else{echo"style='display:none'";}?>>
<!--<h1 style="text-align:center">Sorry, please contact TAP Series to enable Place Orders</h1>-->
<div class="jumbotron">
    <h2 class="text-center">Your account does not have this feature enabled.<br>Please call our technical support at 888-826-5222 for assistance.</h2>
  </div>
</div>


<?php //print_r($_SESSION); ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/shared/footer.php';?>
</body>
</html>