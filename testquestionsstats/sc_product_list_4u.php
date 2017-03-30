<?php
error_reporting(0); 

$user=$_SERVER['DB_USERNAME'];
$password=$_SERVER['DB_PASSWORD'];
$server=$_SERVER['DB_HOSTNAME'];
$database='newtap';
$con = mssql_connect($server,$user,$password) or die('Could not connect to the server!');
mssql_select_db($database, $con) or die('Could not select a database.'); 

session_start();

$discode = "djlebeau";

$SQL="SELECT VC FROM [07L3] WHERE AN = '$place_orders_un' ";				
    $resultset=mssql_query($SQL, $con); 

        while ($row = mssql_fetch_array($resultset)) 
        {
            $acctVC = $row['VC'];
        }

$SQL0="SELECT FSNum FROM [07DS1] WHERE UA = '$place_orders_un' ";				
    $resultset0=mssql_query($SQL0, $con); 

		while ($row = mssql_fetch_array($resultset0)) 
		{
			$FSNum = $row['FSNum'];
		}

if($FSNum=="-3")
{
    $show_licensekeys_div = "yes";
    $show_error_div = "no";
    $show_placeorders_div = "no";
    $_SESSION["discode"] = "$acctVC";
    $_SESSION["existingusername"] = "$place_orders_un";
    $_SESSION["purchase_license_keys"] = "yes";
}
else
{        

    if($acctVC=="tapseries" OR $acctVC=="")
    {
        $show_error_div = "yes";
        $show_licensekeys_div = "no";
        $show_placeorders_div = "no";
    }
    else
    {
        $show_placeorders_div = "yes";
        $show_error_div = "no";
        $show_licensekeys_div = "no";
        $_SESSION["discode"] = "$acctVC";
        $_SESSION["existingusername"] = "$place_orders_un";

        $SQL1="SELECT ProID FROM Place_Orders_Menu WHERE AU = '$place_orders_un' ";				
        $resultset1=mssql_query($SQL1, $con); 

		while ($row = mssql_fetch_array($resultset1)) 
		{
			$Show_Course = $row['ProID'];

            if($Show_Course=="fh"){
                $Show_FH="yes";
            }
            if($Show_Course=="fs"){
                $Show_FS="yes";
            }
            if($Show_Course=="oh2"){
                $Show_OH2="yes";
            }
             if($Show_Course=="oh2rt"){
                $Show_OH2RT="yes";
            }
            if($Show_Course=="nhaccp"){
                $Show_NHACCP="yes";
            }
            if($Show_Course=="fsrt"){
                $Show_FSRT="yes";
            }
            if($Show_Course=="reri"){
                $Show_RERI="yes";
            }
            if($Show_Course=="remn"){
                $Show_REMN="yes";
            }
            if($Show_Course=="rewi"){
                $Show_REWI="yes";
            }
            if($Show_Course=="alcohol"){
                $Show_ALCOHOL="yes";
            }
            if($Show_Course=="cb"){
                $Show_CB="yes";
            }
            if($Show_Course=="cf"){
                $Show_CF="yes";
            }
            if($Show_Course=="emws"){
                $Show_EMWS="yes";
            }
            if($Show_Course=="sfis"){
                $Show_SFIS="yes";
            }
		}

        // if no specific course, SHOW ALL
        if($Show_Course=="")
        {
            $Show_FH="yes";
            $Show_FS="yes";
            $Show_OH2="yes";
            $Show_OH2RT="yes";
            $Show_RERI="yes";
            $Show_REMN="yes";
            $Show_REWI="yes";
            $Show_NHACCP="yes";
            $Show_FSRT="yes";
            $Show_ALCOHOL="yes";
            $Show_CB="yes";
            $Show_CF="yes";
            $Show_EMWS="yes";
            $Show_SFIS="yes";
        }



    }

}

?>


<!DOCTYPE html>
<html>
<head>
<title>Place Orders</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <style>
    .container{
        margin-top:100px;
    }
    .col-md-6{
        margin-top:30px;
    }
    col-sm-6{
        margin-top:20px;
    }
    h3{
        font-size:16px;
    }
    .well{
        margin-bottom:70px;
    }
    .caption{
        text-align:center;
        border:1px solid white;
        height:100px;
    }
    </style>
</head>
<body>
<?php include '../menu.php';?>	

<!-- Place Orders -->
<div class="container" <?php if($show_placeorders_div=="yes"){echo"style='display:block'";}else{echo"style='display:none'";}?>>

    <div class="page-header">
    <h1>Place Orders Menu</h1>
    </div>

 <div class = "row" style="margin-bottom:100px">   

    <div class = "col-sm-6 col-md-6" <?php if($place_orders_un=="ntcre" || $place_orders_un=="afst" || $place_orders_un=="rtsos"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
    <div class = "thumbnail">
    <img src = "../images/aa.png" alt = "Generic placeholder thumbnail">
    </div>
    <div class = "caption">
    <h3>Allergen Awareness</h3>
    <p><a href = "sc_product_options_aa.php?ProID=aa" class = "btn btn-primary" role = "button">Buy Now</a></p>
    </div>
    </div>

    <div class = "col-sm-6 col-md-6" <?php if($Show_FH=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
    <div class = "thumbnail">
    <img src = "../images/USA.png" alt = "Generic placeholder thumbnail">
    </div>
    <div class = "caption">
    <h3>Food Handler Training</h3>
    <p><a href = "fhstates.php" class = "btn btn-primary" role = "button">Buy Now</a></p>
    </div>
    </div>

    <div class = "col-sm-6 col-md-6" <?php if($Show_NHACCP=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
    <div class = "thumbnail">
    <img src = "../images/nhaccp.png" alt = "Generic placeholder thumbnail">
    </div>
    <div class = "caption">
    <h3>HACCP Managers Certificate Course </h3>
    <p><a href = "sc_product_options_aa.php?ProID=nhaccp" class = "btn btn-primary" role = "button">Buy Now</a></p>
    </div>
    </div>

    <div class = "col-sm-6 col-md-6" <?php if($Show_FS=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
    <div class = "thumbnail">
    <img src = "../images/fs.png" alt = "Generic placeholder thumbnail">
    </div>
    <div class = "caption">
    <h3>Food Service Food Safety Manager Certification Training</h3>
    <p><a href = "sc_product_options_aa.php?ProID=fs" class = "btn btn-primary" role = "button">Buy Now</a></p>
    </div>
    </div>

     <div class = "col-sm-6 col-md-6" <?php if($Show_FSRT=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
    <div class = "thumbnail">
    <img src = "../images/fsrt.png" alt = "Generic placeholder thumbnail">
    </div>
    <div class = "caption">
    <h3>Retail Food Safety Manager Certification Training</h3>
    <p><a href = "sc_product_options_aa.php?ProID=fsrt" class = "btn btn-primary" role = "button">Buy Now</a></p>
    </div>
    </div>

    <div class = "col-sm-6 col-md-6" <?php if($Show_OH2=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
    <div class = "thumbnail">
    <img src = "../images/oh2.png" alt = "Generic placeholder thumbnail">
    </div>
    <div class = "caption">
    <h3>Ohio Level 2 Food Service Food Safety Manager Certification Training</h3>
    <p><a href = "sc_product_options_aa.php?ProID=oh2" class = "btn btn-primary" role = "button">Buy Now</a></p>
    </div>
    </div>

    <div class = "col-sm-6 col-md-6" <?php if($Show_OH2RT=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
    <div class = "thumbnail">
    <img src = "../images/oh2rt.png" alt = "Generic placeholder thumbnail">
    </div>
    <div class = "caption">
    <h3>Ohio Level 2 Retail Food Safety Manager Certification Training</h3>
    <p><a href = "sc_product_options_aa.php?ProID=oh2rt" class = "btn btn-primary" role = "button">Buy Now</a></p>
    </div>
    </div>

    <div class = "col-sm-6 col-md-6"  <?php if($Show_REMN=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
    <div class = "thumbnail">
    <img src = "../images/remn.png" alt = "Generic placeholder thumbnail">
    </div>
    <div class = "caption">
    <h3>Minnesota Food Safety Renewal Training </h3>
    <p><a href = "sc_product_options_aa.php?ProID=remn" class = "btn btn-primary" role = "button">Buy Now</a></p>
    </div>
    </div>

    <div class = "col-sm-6 col-md-6" <?php if($Show_RERI=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
    <div class = "thumbnail">
    <img src = "../images/reri.png" alt = "Generic placeholder thumbnail">
    </div>
    <div class = "caption">
    <h3>Rhode Island Food Safety Re-Certification Training </h3>
    <p><a href = "sc_product_options_aa.php?ProID=reri" class = "btn btn-primary" role = "button">Buy Now</a></p>
    </div>
    </div>

    <div class = "col-sm-6 col-md-6" <?php if($Show_REWI=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
    <div class = "thumbnail">
    <img src = "../images/rewi.png" alt = "Generic placeholder thumbnail">
    </div>
    <div class = "caption">
    <h3>Wisconsin Food Safety Re-Certification Training </h3>
    <p><a href = "sc_product_options_aa.php?ProID=rewi" class = "btn btn-primary" role = "button">Buy Now</a></p>
    </div>
    </div>

    <div class = "col-sm-6 col-md-6"  <?php if($Show_ALCOHOL=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
    <div class = "thumbnail">
    <img src = "../images/aa.png" alt = "Generic placeholder thumbnail">
    </div>
    <div class = "caption">
    <h3>Online Alcohol Seller/Server Certification </h3>
    <p><a href = "https://www5.myvlp.com/v1-3/index__tapseries.php" class = "btn btn-primary" role = "button">Buy Now</a></p>
    </div>
    </div>

    <div class = "col-sm-6 col-md-6"  <?php if($Show_CB=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
    <div class = "thumbnail">
    <img src = "../images/cb.png" alt = "Generic placeholder thumbnail">
    </div>
    <div class = "caption">
    <h3>Cooking Basics </h3>
    <p><a href = "sc_product_options_aa.php?ProID=cb" class = "btn btn-primary" role = "button">Buy Now</a></p>
    </div>
    </div>

    <div class = "col-sm-6 col-md-6" <?php if($Show_CF=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
    <div class = "thumbnail">
    <img src = "../images/cf.png" alt = "Generic placeholder thumbnail">
    </div>
    <div class = "caption">
    <h3>Chef Fundamentals </h3>
    <p><a href = "sc_product_options_aa.php?ProID=cf" class = "btn btn-primary" role = "button">Buy Now</a></p>
    </div>
    </div>

    <div class = "col-sm-6 col-md-6" <?php if($Show_EMWS=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
    <div class = "thumbnail">
    <img src = "../images/emws.png" alt = "Generic placeholder thumbnail">
    </div>
    <div class = "caption">
    <h3>Earn More with Service </h3>
    <p><a href = "sc_product_options_aa.php?ProID=emws" class = "btn btn-primary" role = "button">Buy Now</a></p>
    </div>
    </div>

    <div class = "col-sm-6 col-md-6" <?php if($Show_SFIS=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
    <div class = "thumbnail">
    <img src = "../images/sfis.png" alt = "Generic placeholder thumbnail">
    </div>
    <div class = "caption">
    <h3>Strategies For Increasing Sales </h3>
    <p><a href = "sc_product_options_aa.php?ProID=sfis" class = "btn btn-primary" role = "button">Buy Now</a></p>
    </div>
    </div>

    
   
</div>

    <div class='well'>
	<h4><strong>Terms of Purchase</strong></h4>
	100% money back of the purchase price, or credit to your corporate account, if returned within 30 days of enrollment, and if no more than lesson 1 has been studied. If you have any questions or comments on our return policy/terms of purchase, please feel free to contact us at 888-826-5222.<br><br>Courses are purchased as single use enrollments. Each lesson allows up to 5 reviews. After 5 reviews the lesson is closed. Courses are active for 180 days from date of enrollment and will stop functioning 180 days after the enrollment. Within the 180 day active period, the name of the student can be changed for a $20 fee for all courses except Food Handler, if a TAP Certificate of Achievement has NOT been awarded. Changing of the name will not re-activate any inactive, closed or ended functions. We reserve the right to charge a $5 fee for Food Handler name changes. To submit a name change form, click here.
	</div>
</div>

<!-- License Keys Menu -->
<div class="container" <?php if($show_licensekeys_div=="yes"){echo"style='display:block;margin-bottom:450px'";}else{echo"style='display:none'";}?>>

    <div class="page-header">
    <h1>Purchase License Keys</h1>
    <p>Please select a category from the list below</p>
    </div>

    <div class="panel-group">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" href="#collapse1">Allergen Friendly</a>
                </h4>
            </div>
            <div id="collapse1" class="panel-collapse collapse">
                <div class="panel-body"><a href='sc_product_options_aa.php?ProID=aa'>Allergen Awareness</a></div>
                <div class="panel-body"><a href='sc_product_options_aa.php?ProID=ad'>Allergen Plan Development</a></div>
                <div class="panel-body"><a href='sc_product_options_aa.php?ProID=as'>Allergen Plan Specialist</a></div>
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
                <div class="panel-body"><a href='sc_product_options_aa.php?ProID=azfsh'>Arizona Food Handler Training</a></div>
                <div class="panel-body"><a href='sc_product_options_aa.php?ProID=califsh'>California Food Handler Training</a></div>
                <div class="panel-body"><a href='sc_product_options_aa.php?ProID=flfsh'>Florida Food Worker Training Program</a></div>
                <div class="panel-body"><a href='sc_product_options_aa.php?ProID=nfon'>Food Handler Training (all other states)</a></div>
                <div class="panel-body"><a href='sc_product_options_aa.php?ProID=idfsh'>Idaho Food Handler Training</a></div>
                <div class="panel-body"><a href='sc_product_options_aa.php?ProID=ilfsh'>Illinois Food Handler Training</a></div>
                <div class="panel-body"><a href='sc_product_options_aa.php?ProID=mofsh'>Jackson County MO Food Handler Training</a></div>
                <div class="panel-body"><a href='sc_product_options_aa.php?ProID=nmfsh'>New Mexico County MO Food Handler Training</a></div>
                <div class="panel-body"><a href='sc_product_options_aa.php?ProID=vaccfsh'>Norfolk VA County MO Food Handler Training</a></div>
                <div class="panel-body"><a href='sc_product_options_aa.php?ProID=ohfsh'>Ohio Level One Certification</a></div>
                <div class="panel-body"><a href='sc_product_options_aa.php?ProID=txfsh'>Texas Food Handler Training</a></div>
                <div class="panel-body"><a href='sc_product_options_aa.php?ProID=ksfsh'>Wichita KS Food Handler Training</a></div>
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
                <div class="panel-body"><a href='sc_product_options_aa.php?ProID=fs'>Food Safety Manager Certification Training</a></div>
                <div class="panel-body"><a href='sc_product_options_aa.php?ProID=fsrt'>Retail Food Safety Manager Certification Training</a></div>
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
                <div class="panel-body"><a href='sc_product_options_aa.php?ProID=cb'>Chef Fundamentals</a></div>
                <div class="panel-body"><a href='sc_product_options_aa.php?ProID=cb'>Cooking Basics</a></div>
                <div class="panel-body"><a href='sc_product_options_aa.php?ProID=emws'>Earn More With Service</a></div>
                <div class="panel-body"><a href='sc_product_options_aa.php?ProID=nhaccp'>HACCP Managers Certificate Course</a></div>
                <div class="panel-body"><a href='sc_product_options_aa.php?ProID=sfis'>Strategies for Increasing Sales</a></div>
             </div>
        </div>
    </div>



</div>

<!-- If accounts don't have a VC or VC==tapseries on [07L3] they can't use place orders' -->
<div class="container text-center" <?php if($show_error_div=="yes"){echo"style='display:block;height:750px'";}else{echo"style='display:none'";}?>>
    <p style="margin-top:100px">Your account does not have this feature enabled.</p>
    <p>Please call our technical support at 888-826-5222 for assistance.</p>
</div>






<?php print_r($_SESSION); ?>
<?php include '../footer.php';?>
</body>
</html>