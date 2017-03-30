<?php
error_reporting(0); 

$user=$_SERVER['DB_USERNAME'];
$password=$_SERVER['DB_PASSWORD'];
$server=$_SERVER['DB_HOSTNAME'];
$database='newtap';
$con = mssql_connect($server,$user,$password) or die('Could not connect to the server!');
mssql_select_db($database, $con) or die('Could not select a database.'); 

session_start();
$place_orders_un = $_SESSION['user'];

$SQL="SELECT VC FROM [07L3] WHERE AN = '$place_orders_un' ";				
    $resultset=mssql_query($SQL, $con); 

        while ($row = mssql_fetch_array($resultset)) 
        {
            $acctVC = $row['VC'];
        }

$SQL0="SELECT LicensesRemaining FROM [Licenses] WHERE UserId = '$place_orders_un' ";				
    $resultset0=mssql_query($SQL0, $con); 

		while ($row = mssql_fetch_array($resultset0)) 
		{
			$LicensesRemaining = $row['LicensesRemaining'];
		}

if($LicensesRemaining=="-3")
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

        //Get Course Price
	$SQL = "SELECT * FROM [07SL1] WHERE VC = '$acctVC' ";				
	$resultset=mssql_query($SQL, $con); 	
		while ($row = mssql_fetch_array($resultset)) 
		{
		     $fs_price = $row['01C'];
			 $fs_price = number_format($fs_price,2);

		     $fsrt_price = $row['01RC'];
			 $fsrt_price = number_format($fsrt_price,2);

		     $refs_price = $row['02C'];
			 $refs_price = number_format($refs_price,2);
			 
		     $rewi_price = $row['01RWEC'];
			 $rewi_price = number_format($rewi_price,2);

		     $nhaccp_price = $row['04C'];
			 $nhaccp_price = number_format($nhaccp_price,2);

		     $cb_price = $row['03C'];
			 $cb_price = number_format($cb_price,2);

			 $alc_price = $row['12C'];
			 $alc_price = number_format($alc_price,2);

		     $cf_price = $row['03C'];
			 $cf_price = number_format($cf_price,2);

		     $emws_price = $row['06C'];
			 $emws_price = number_format($emws_price,2);

		     $sfis_price = $row['05C'];
			 $sfis_price = number_format($sfis_price,2);

		     $aa_price = $row['09C'];
			 $aa_price = number_format($aa_price,2);

             $oh2rt_price = $row['01RC'];
			 $oh2rt_price = number_format($oh2rt_price,2);

			 $sd_price = $row['01SDEC'];
			 $sd_price = number_format($sd_price,2);

			 $utfsh_price = $row['01UTEC'];
			 $utfsh_price = number_format($utfsh_price,2);

			 $mofsh_price = $row['01MOEC'];
			 $mofsh_price = number_format($mofsh_price,2);

			 $nfon_price = $row['01EC'];
			 $nfon_price = number_format($nfon_price,2);
		}

        //Get Courses Name
    $SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'fs' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $fs_c_name = $row['Course_Name'];
		}     
    $SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'fsrt' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $fsrt_c_name = $row['Course_Name'];
		}
    $SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'oh2' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $oh2_c_name = $row['Course_Name'];
		}
    $SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'oh2rt' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $oh2rt_c_name = $row['Course_Name'];
		}
        
    $SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'remn' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $remn_c_name = $row['Course_Name'];
		} 
    $SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'reri' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $reri_c_name = $row['Course_Name'];
		} 
    $SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'rewi' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $rewi_c_name = $row['Course_Name'];
		}
    $SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'nhaccp' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $nhaccp_c_name = $row['Course_Name'];
		}
    $SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'cb' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $cb_c_name = $row['Course_Name'];
		}
    $SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'cf' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $cf_c_name = $row['Course_Name'];
		}  
    $SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'emws' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $emws_c_name = $row['Course_Name'];
		}   
    $SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'sfis' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $sfis_c_name = $row['Course_Name'];
		}   
    $SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'aa' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $aa_c_name = $row['Course_Name'];
		}  
	$SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'casd' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $sd_c_name = $row['Course_Name'];
		}  
	$SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'utfsh' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $utfsh_c_name = $row['Course_Name'];
		}  
	$SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'mofsh' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $mofsh_c_name = $row['Course_Name'];
		}  
	$SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'nfon' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $nfon_c_name = $row['Course_Name'];
		}  







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
			if($Show_Course=="nfon"){
                $Show_NFON="yes";
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
            $Show_NFON="yes";
        }



    }

}

/*
// these are the courses that are not unlimited for BN because of the state fees
if($_SESSION["discode"]=="bn"){
	        $Show_SD="yes";
	        $Show_UTFSH="yes";
	        $Show_MOFSH="yes";
	        $Show_WV="yes";

	        $Show_FH="no";
            $Show_FS="no";
            $Show_OH2="no";
            $Show_OH2RT="no";
            $Show_RERI="no";
            $Show_REMN="no";
            $Show_REWI="no";
            $Show_NHACCP="no";
            $Show_FSRT="no";
            $Show_ALCOHOL="no";
            $Show_CB="no";
            $Show_CF="no";
            $Show_EMWS="no";
            $Show_SFIS="no";
}
*/

?>


<!DOCTYPE html>
<html>
<head>
<title>Place Orders</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <style>

    .course_container{
	width: 375px;
	height: 200px;
	border:1px solid #ddd;
	float: left;
	margin-left: 10px;
	margin-top: 10px;
}
#wrapper{
	border:1px solid transparent;
	max-width: 785px !important;
	height: 1600px;
	margin: auto;
}
.image{
	width: 167px;
	height: 167px;
	float: left;
	margin-top: 13px;
	margin-left: 13px;
	border:1px solid transparent;
	position:relative;
	
}
.image:hover img{
	opacity: 0.5;
}
.image:hover .btns{
    display:block;
}
.content{
	width: 167px;
	height: 167px;
	float: left;
	margin-top: 13px;
	margin-left: 13px;
	border:1px solid transparent;
}
img{
	transition: opacity 0.5s ease;
	width: 100%;
}
.title{
	width: 100%;
	height: 70%;
	border:1px solid transparent;
	text-align: center;
	color: #1E2B41;
}
.title h4{
	margin-top: 0px;
	font-size: 19px;
	cursor: pointer;
}
.title h4 a:hover{
	color:blue;
}
.title h4 a{
    color:#1E2B41;
	transition: all 1s;    
}

.price{
	width: 100%;
	height: 30%;
	border:1px solid transparent;
	background-color: #1E2B41;
	color: white;
	text-align: center;
	cursor: pointer;
}
.price:hover{
	background-color:#182234;
}
.price h4{
	margin-top: 10px;
	font-size: 25px;
}
.price a{
    color:white;
    text-decoration:none;
}
.content a:hover{
    text-decoration:none;
}
.btns{
    display:none;
    position:absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    margin: auto;
    height:50%;
    text-align: center;
}
.btns a{
	margin-top: 5px;
}
.btn-primary{
    background-color: #1E2B41;
    border-color: #1E2B41;
}



@media only screen and (max-width: 790px) {

.course_container{
    width: 100%;
    margin:10px auto;
    height: 258px;
    }
#wrapper{
	width: 500px !important;
	height: 4000px;
}
.image{
	margin-left:25px;
	margin-top:20px;
	width: 45%;
	height: 87%;
}
.content{
	margin-top:20px;
	width: 45%;
	height: 87%;
}
.title{
	height: 70%;
}
.title h4{
	font-size: 25px;
	margin-top: 10px;
}
.price{
	height: 30%;
}
.price h4{
	margin-top: 15px;
	font-size: 30px;
}


}	


@media only screen and (max-width: 525px) {

#wrapper{
	width: 300px !important;
    height: 2550px;
}
.course_container{
	height: 155px;
}
.content{
	margin-top: 10px;
	height: 132px;
}
.image{
	margin-left:10px;
	margin-top:10px;
	margin-bottom: 10px;
}
.title h4{
	font-size: 15.5px;
	margin-top: 0px;
}
.price h4{
	margin-top: 7px;
	font-size: 20px;
}



}

</style>

<script>
$(document).ready(function(){

$("#withoutdetails").css("background-color", "#E6E6E6");

    $("#withoutdetails").click(function(){
    $("#withoutdetails").css("background-color", "#E6E6E6");
    $("#withdetails").css("background-color", "white");
    });

    $("#withdetails").click(function(){
    $("#withdetails").css("background-color", "#E6E6E6");
    $("#withoutdetails").css("background-color", "white");
    });


});
</script>

</head>
<body>
<?php include $_SERVER['DOCUMENT_ROOT'].'/shared/header.php';?>	
<!-- Place Orders -->
<div  <?php if($show_placeorders_div=="yes"){echo"style='display:block'";}else{echo"style='display:none'";}?>>

<div class="container" style="margin-top:70px">
<div class="page-header">
<h3>Place Orders</h3>
</div>

<div class="container" style="margin-bottom:0px">
<div class='well' >
<h4><strong>Terms of Purchase</strong></h4>
100% money back of the purchase price, or credit to your corporate account, if returned within 30 days of enrollment, and if no more than lesson 1 has been studied. If you have any questions or comments on our return policy/terms of purchase, please feel free to contact us at 888-826-5222.<br><br>Courses are purchased as single use enrollments. Each lesson allows up to 5 reviews. After 5 reviews the lesson is closed. Courses are active for 180 days from date of enrollment and will stop functioning 180 days after the enrollment. Within the 180 day active period, the name of the student can be changed for a $20 fee for all courses except Food Handler, if a TAP Certificate of Achievement has NOT been awarded. Changing of the name will not re-activate any inactive, closed or ended functions. We reserve the right to charge a $5 fee for Food Handler name changes. To request a name change form, send an email to techsupport@tapseries.com.
</div>
</div>

</div>


 <div id="wrapper" style="margin-top:30px">

<!-- allergen awareness -->
<div class="course_container" <?php if($place_orders_un=="ntcre" || $place_orders_un=="afst" || $place_orders_un=="rtsos"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="images/aa1.png">
        <div class="btns">
			<p><a href = "/courses/allergenfriendly/description/aa" class = "btn btn-default" role = "button">Learn More</a><a href = "allergenfriendly/aa" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "allergenfriendly/aa"><?php echo $aa_c_name; ?></a></h4>
		</div>
        <a href = "allergenfriendly/aa">
		<div class="price">
			<h4>$<?php echo $aa_price; ?></h4>
		</div>
        </a>
	</div>
</div>

<!-- san diego fh --> 
<div class="course_container" <?php if($Show_SD=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="images/sd1.png">
        <div class="btns">
			<p><a href = "/courses/foodhandler/description/casd" class = "btn btn-default" role = "button">Learn More</a><a href = "foodhandler/casd" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "foodhandler/casd"><?php echo $sd_c_name; ?></a></h4>
		</div>
        <a href = "foodhandler/casd">
		<div class="price">
			<h4>$<?php echo $sd_price; ?></h4>
		</div>
        </a>
	</div>
</div>

<!-- all other states fh --> 
<div class="course_container" <?php if($Show_NFON=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="images/nfon1.png">
        <div class="btns">
			<p><a href = "/courses/foodhandler/description/nfon" class = "btn btn-default" role = "button">Learn More</a><a href = "foodhandler/nfon" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "foodhandler/nfon"><?php echo $nfon_c_name; ?></a></h4>
		</div>
        <a href = "foodhandler/nfon">
		<div class="price">
			<h4>$<?php echo $nfon_price; ?></h4>
		</div>
        </a>
	</div>
</div>

<!-- utah fh --> 
<div class="course_container" <?php if($Show_UTFSH=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="images/utfsh1.png">
        <div class="btns">
			<p><a href = "/courses/foodhandler/description/utfsh" class = "btn btn-default" role = "button">Learn More</a><a href = "foodhandler/utfsh" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "foodhandler/utfsh"><?php echo $utfsh_c_name; ?></a></h4>
		</div>
        <a href = "foodhandler/utfsh">
		<div class="price">
			<h4>$<?php echo $utfsh_price; ?></h4>
		</div>
        </a>
	</div>
</div>

<!-- jackson county fh --> 
<div class="course_container" <?php if($Show_MOFSH=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="images/mofsh1.png">
        <div class="btns">
			<p><a href = "/courses/foodhandler/description/mofsh" class = "btn btn-default" role = "button">Learn More</a><a href = "foodhandler/mofsh" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "foodhandler/mofsh"><?php echo $mofsh_c_name; ?></a></h4>
		</div>
        <a href = "foodhandler/mofsh">
		<div class="price">
			<h4>$<?php echo $mofsh_price; ?></h4>
		</div>
        </a>
	</div>
</div>

<!-- west virginia fh --> 
<div class="course_container" <?php if($Show_WV=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?> data-toggle="modal" data-target="#WV">
	<div class="image">
		<img src="images/mofsh1.png">
        <div class="btns">
			<p><a href = "#" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4>West Virginia Food Handler</h4>
		</div>
        <a href = "#">
		<div class="price">
			<h4>Buy Course</h4>
		</div>
        </a>
	</div>
</div>


<!-- food handler -->
<div class="course_container" <?php if($Show_FH=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="images/USA1.png">
        <div class="btns">
			<p style="margin-top:30px"><!--<a href = "#" class = "btn btn-default" role = "button">Learn More</a>--><a href = "../foodhandler" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "../foodhandler">Food Handler Training</a></h4>
		</div>
        <a href = "../foodhandler">
		<div class="price">
			<h4>Buy Now</h4>
		</div>
        </a>
	</div>
</div> 

<!-- haccp --> 
<div class="course_container" <?php if($Show_NHACCP=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="images/nhaccp1.png">
        <div class="btns">
			<p><a href = "/courses/haccp/description/nhaccp" class = "btn btn-default" role = "button">Learn More</a><a href = "haccp/nhaccp" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "haccp/nhaccp"><?php echo $nhaccp_c_name; ?></a></h4>
		</div>
        <a href = "haccp/nhaccp">
		<div class="price">
			<h4>$<?php echo $nhaccp_price; ?></h4>
		</div>
        </a>
	</div>
</div>
 
 <!-- fsm --> 
<div class="course_container" <?php if($Show_FS=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="images/fs1.png">
        <div class="btns">
			<p><a href = "/courses/foodsafetymanager/description/fs" class = "btn btn-default" role = "button">Learn More</a><a href = "foodsafetymanager/fs" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "foodsafetymanager/fs"><?php echo $fs_c_name; ?></a></h4>
		</div>
        <a href = "foodsafetymanager/fs">
		<div class="price">
			<h4>$<?php echo $fs_price; ?></h4>
		</div>
        </a>
	</div>
</div>

<!-- retail fsm -->
<div class="course_container" <?php if($Show_FSRT=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="images/fsrt1.png">
        <div class="btns">
			<p><a href = "/courses/foodsafetymanager/description/fsrt" class = "btn btn-default" role = "button">Learn More</a><a href = "foodsafetymanager/fsrt" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "foodsafetymanager/fsrt"><?php echo $fsrt_c_name; ?></a></h4>
		</div>
        <a href = "foodsafetymanager/fsrt">
		<div class="price">
			<h4>$<?php echo $fsrt_price; ?></h4>
		</div>
        </a>
	</div>
</div>

<!-- ohio level 2 -->
<div class="course_container" <?php if($Show_OH2=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="images/oh21.png">
        <div class="btns">
			<p><a href = "/courses/foodsafetymanager/description/oh2" class = "btn btn-default" role = "button">Learn More</a><a href = "foodsafetymanager/oh2" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "foodsafetymanager/oh2"><?php echo $oh2_c_name; ?></a></h4>
		</div>
        <a href = "foodsafetymanager/oh2">
		<div class="price">
			<h4>$<?php echo $fs_price; ?></h4>
		</div>
        </a>
	</div>
</div>

<!-- ohio level 2  retail -->
<div class="course_container" <?php if($Show_OH2RT=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="images/oh2rt1.png">
        <div class="btns">
			<p><a href = "/courses/foodsafetymanager/description/oh2rt" class = "btn btn-default" role = "button">Learn More</a><a href = "foodsafetymanager/oh2rt" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "foodsafetymanager/oh2rt"><?php echo $oh2rt_c_name; ?></a></h4>
		</div>
        <a href = "foodsafetymanager/oh2rt">
		<div class="price">
			<h4>$<?php echo $oh2rt_price; ?></h4>
		</div>
        </a>
	</div>
</div>

<!-- minessota recert -->
<div class="course_container" <?php if($Show_REMN=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="images/remn1.png">
        <div class="btns">
			<p><a href = "/courses/foodsafetymanager/description/remn" class = "btn btn-default" role = "button">Learn More</a><a href = "foodsafetymanager/remn" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "foodsafetymanager/remn"><?php echo $remn_c_name; ?></a></h4>
		</div>
        <a href = "foodsafetymanager/remn">
		<div class="price">
			<h4>$<?php echo $refs_price; ?></h4>
		</div>
        </a>
	</div>
</div>

<!-- rhode island recert -->
<div class="course_container" <?php if($Show_RERI=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="images/reri1.png">
        <div class="btns">
			<p><a href = "/courses/foodsafetymanager/description/reri" class = "btn btn-default" role = "button">Learn More</a><a href = "foodsafetymanager/reri" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "foodsafetymanager/reri"><?php echo $reri_c_name; ?></a></h4>
		</div>
        <a href = "foodsafetymanager/reri">
		<div class="price">
			<h4>$<?php echo $refs_price; ?></h4>
		</div>
        </a>
	</div>
</div>

<!-- wisconsin recert-->
<div class="course_container" <?php if($Show_REWI=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="images/rewi1.png">
        <div class="btns">
			<p><a href = "/courses/foodsafetymanager/description/rewi" class = "btn btn-default" role = "button">Learn More</a><a href = "foodsafetymanager/rewi" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "foodsafetymanager/rewi"><?php echo $rewi_c_name; ?></a></h4>
		</div>
        <a href = "foodsafetymanager/rewi">
		<div class="price">
			<h4>$<?php echo $rewi_price; ?></h4>
		</div>
        </a>
	</div>
</div>

<!-- alcohol -->
<div class="course_container" <?php if($Show_ALCOHOL=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="images/al1.png">
        <div class="btns">
			<p><a href = "/courses/alcoholtraining/description/alc" class = "btn btn-default" role = "button">Learn More</a><a href = "/courses/alcoholtraining" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "/courses/alcoholtraining">Online Alcohol Seller/Server Certification </a></h4>
		</div>
        <a href = "/courses/alcoholtraining">
		<div class="price">
			<h4>$<?php echo $alc_price; ?></h4>
		</div>
        </a>
	</div>
</div>

<!-- cooking basics -->
<div class="course_container" <?php if($Show_CB=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="images/cb1.png">
        <div class="btns">
			<p><a href = "/courses/foodserviceoperations/description/cb" class = "btn btn-default" role = "button">Learn More</a><a href = "foodserviceoperations/cb" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "foodserviceoperations/cb"><?php echo $cb_c_name; ?></a></h4>
		</div>
        <a href = "foodserviceoperations/cb">
		<div class="price">
			<h4>$<?php echo $cb_price; ?></h4>
		</div>
        </a>
	</div>
</div>

<!-- chef fundamentals -->
<div class="course_container" <?php if($Show_CF=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="images/cf1.png">
        <div class="btns">
			<p><a href = "/courses/foodserviceoperations/description/cf" class = "btn btn-default" role = "button">Learn More</a><a href = "foodserviceoperations/cf" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "foodserviceoperations/cb"><?php echo $cf_c_name; ?></a></h4>
		</div>
        <a href = "foodserviceoperations/cf">
		<div class="price">
			<h4>$<?php echo $cb_price; ?></h4>
		</div>
        </a>
	</div>
</div>

<!-- earn more with service -->
<div class="course_container" <?php if($Show_EMWS=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="images/emws1.png">
        <div class="btns">
			<p><a href = "/courses/foodserviceoperations/description/emws" class = "btn btn-default" role = "button">Learn More</a><a href = "foodserviceoperations/emws" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "foodserviceoperations/emws"><?php echo $emws_c_name; ?></a></h4>
		</div>
        <a href = "foodserviceoperations/emws">
		<div class="price">
			<h4>$<?php echo $emws_price; ?></h4>
		</div>
        </a>
	</div>
</div>

<!-- strategies for increasing sales -->
<div class="course_container" <?php if($Show_SFIS=="yes"){echo"style='display:inline !important'";}else{echo"style='display:none'";}?>>
	<div class="image">
		<img src="images/sfis1.png">
        <div class="btns">
			<p><a href = "/courses/foodserviceoperations/description/sfis" class = "btn btn-default" role = "button">Learn More</a><a href = "foodserviceoperations/sfis" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "foodserviceoperations/sfis"><?php echo $sfis_c_name; ?></a></h4>
		</div>
        <a href = "sfoodserviceoperations/sfis">
		<div class="price">
			<h4>$<?php echo $sfis_price; ?></h4>
		</div>
        </a>
	</div>
</div>

</div><!-- #wrapper-->
   

    
</div>

<!-- License Keys Menu -->
<div class="container" <?php if($show_licensekeys_div=="yes"){echo"style='display:block;margin-bottom:450px;margin-top:90px'";}else{echo"style='display:none'";}?>>

    <div id="all_voucher_courses" <?php if($place_orders_un=="svtmgr"){echo"style='display:none'";}?>>
        <div class="page-header">
        <h1>Purchase/Obtain License Keys</h1>
        <p>Please select a category from the list below</p>
        </div>

		<div class='well' >
		<h4><strong>Terms of Purchase</strong></h4>
		100% money back of the purchase price, or credit to your corporate account, if returned within 30 days of enrollment, and if no more than lesson 1 has been studied. If you have any questions or comments on our return policy/terms of purchase, please feel free to contact us at 888-826-5222.<br><br>Courses are purchased as single use enrollments. Each lesson allows up to 5 reviews. After 5 reviews the lesson is closed. Courses are active for 180 days from date of enrollment and will stop functioning 180 days after the enrollment. Within the 180 day active period,  the name of the student can be changed for a $20 fee for all courses except Food Handler, if a TAP Certificate of Achievement has NOT been awarded. Changing of the name will not re-activate any inactive, closed or ended functions. We reserve the right to charge a $5 fee for Food Handler name changes. 
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
                    <div class="panel-body" <?php if($_SESSION['displayname']=="Ghirardelli"){echo "style='display:none'";}?>><a href='allergenfriendly/ad'>Allergen Plan Development</a></div>
                    <div class="panel-body" <?php if($_SESSION['displayname']=="Ghirardelli"){echo "style='display:none'";}?>><a href='allergenfriendly/as'>Allergen Plan Specialist</a></div>
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
                    <div class="panel-body"><a href='foodhandler/casd'>San Diego Food Handler Training</a></div>
                    <div class="panel-body"><a href='foodhandler/txfsh'>Texas Food Handler Training</a></div>
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
                    <div class="panel-body" <?php if($_SESSION['displayname']=="Ghirardelli"){echo "style='display:none'";}?>><a href='foodsafetymanager/fsrt'>Retail Food Safety Manager Certification Training</a></div>
                </div>
            </div>
        </div>

        <div class="panel-group" <?php if($_SESSION['displayname']=="Ghirardelli"){echo "style='display:none'";}?>>
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

    <div id="specific_voucher_courses" <?php if($place_orders_un=="svtmgr"){echo"style='display:block'";}else{echo"style='display:none'";}?>>
        <div class="page-header">
        <h1>Purchase License Keys</h1>
        <p>Please click on the course you want to purchase.</p>
        </div>

        <br>
        <a href='sc_product_options_aa.php?ProID=fsrt' <?php if($place_orders_un=="svtmgr"){echo"style='display:block'";}else{echo"style='display:none'";}?>>Retail Food Safety Manager Certification Training</a>

    </div>    

</div>

<!-- If accounts don't have a VC or VC==tapseries on [07L3] they can't use place orders' -->
<div class="container text-center" <?php if($show_error_div=="yes"){echo"style='display:block;height:750px;margin-top:150px'";}else{echo"style='display:none'";}?>>
    <div class="jumbotron">
    	<h2 class="text-center">Your account does not have this feature enabled.<br>Please call our technical support at 888-826-5222 for assistance.</h2>
  	</div>
</div>



  <!-- Modal -->
  <div class="modal fade" id="WV" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Please select your county</h4>
        </div>
        <div class="modal-body">
			<input type="radio" class="course-opts" name="course-opts" value="WVBA" checked> Barbour County<br>
			<input type="radio" class="course-opts" name="course-opts" value="WVMV"> Calhoun County<br>
			<input type="radio" class="course-opts" name="course-opts" value="WVCH"> Cabell-Huntington County<br>
			<input type="radio" class="course-opts" name="course-opts" value="WVMN"> Monroe County<br>
			<input type="radio" class="course-opts" name="course-opts" value="WVPE"> Pendleton County<br>
			<input type="radio" class="course-opts" name="course-opts" value="WVMV"> Pleasants County<br>
			<input type="radio" class="course-opts" name="course-opts" value="WVPO"> Pocahontas County<br>
			<input type="radio" class="course-opts" name="course-opts" value="WVRN"> Randolph-Elkins County<br>
			<input type="radio" class="course-opts" name="course-opts" value="WVMV"> Ritchie County<br>
			<input type="radio" class="course-opts" name="course-opts" value="WVMV"> Roane County<br>
			<input type="radio" class="course-opts" name="course-opts" value="WVUP"> Upshur County<br>
			<input type="radio" class="course-opts" name="course-opts" value="WVWA"> Wayne County<br>
			<input type="radio" class="course-opts" name="course-opts" value="WVOH"> Wheeling-Ohio County<br>
			<input type="radio" class="course-opts" name="course-opts" value="WVMV"> Wirt County<br>
			<input type="radio" class="course-opts" name="course-opts" value="WVMV"> Wood County<br>
        </div>
        <div class="modal-footer">
		  <a href="/courses/shop/foodhandler/WVBA" id="WV_Ok" class="btn btn-success" role="button">Ok</a>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

<script>
$(document).ready(function(){

	$("input[name=course-opts]").first().prop('checked', true);

	$(".course-opts").click(function(){
        var value_WV = $(this).val();
		$("#WV_Ok").attr("href", "/courses/shop/foodhandler/"+value_WV);
    });

});

</script>

<?php //print_r($_SESSION); ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/shared/footer.php';?>
</body>
</html>