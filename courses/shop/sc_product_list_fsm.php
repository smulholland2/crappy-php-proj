<?php
$user=$_SERVER['DB_USERNAME'];
$password=$_SERVER['DB_PASSWORD'];
$server=$_SERVER['DB_HOSTNAME'];
$database='newtap';
$con = mssql_connect($server,$user,$password) or die('Could not connect to the server!');
mssql_select_db($database, $con) or die('Could not select a database.');

    //Get Course Price
	$SQL = "SELECT [01C], [01RC], [02C], [01RWEC] FROM [07SL1] WHERE VC = 'tapseries' ";				
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

session_start();
 $course = implode(" ",$_SESSION['course']);               
?>


<!DOCTYPE html>
<html>
<head>
<title>Food Safety Manager Courses</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

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
	max-width: 785px;
	height: 450px !important;
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
	width: 500px;
	height: 900px !important;
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
	width: 300px;
    height: 550px !important;
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


<div class="container" style="margin-top:70px">
<div class="page-header">
<h3>Food Safety Manager Courses</h3>
</div>

<div class="container">
	<div class='well'>
	<h4><strong>Terms of Purchase</strong></h4>
	100% money back of the purchase price, or credit to your corporate account, if returned within 30 days of enrollment, and if no more than lesson 1 has been studied. If you have any questions or comments on our return policy/terms of purchase, please feel free to contact us at 888-826-5222.<br><br>Courses are purchased as single use enrollments. Each lesson allows up to 5 reviews. After 5 reviews the lesson is closed. Courses are active for 180 days from date of enrollment and will stop functioning 180 days after the enrollment. Within the 180 day active period,  the name of the student can be changed for a $20 fee for all courses except Food Handler, if a TAP Certificate of Achievement has NOT been awarded. Changing of the name will not re-activate any inactive, closed or ended functions. We reserve the right to charge a $5 fee for Food Handler name changes. To submit a name change form, click here.
	</div>

	 <div class="well" <?php if($course == "Ohio"){echo "style='display:block'";}else{echo "style='display:none'";}?>>
	 	 <b>Ohio test center users need to send a copy of the TAP Training Certificate and exam certificate to the state.  <a href="/home/ohiolevel2.php">Click here</a> for instructions.</b>
	 </div>
 
 	<div class="well" <?php if($course == "Illinois"){echo "style='display:block'";}else{echo "style='display:none'";}?>>
		 <b>After passing the online proctored exam, you need to apply for an Illinois Food Service Sanitation Manager Certificate (FSSMC).  <a href="http://www.dph.illinois.gov/sites/default/files/publications/New-FSSMC-Students-1pager-V3-120116-121216.pdf">Click here for instructions</a>.</b>
	 </div>

</div>

<!--
<div class="btn-group" style="margin-bottom:30px">
    <button type="button" id="withoutdetails" class="btn btn-default"> <span class="glyphicon glyphicon-th-large"></button>
    <button type="button" id="withdetails" class="btn btn-default"> <span class="glyphicon glyphicon-th-list"></button>
</div>
-->
</div>


<div id="wrapper">
 
<div class="course_container" <?php if($course == "Ohio"){echo "style='display:none'";}else{echo "style='display:block'";}?>>
	<div class="image">
		<img src="images/fs1.png">
        <div class="btns">
			<p><a href = "/courses/foodsafetymanager/description/fs" class = "btn btn-default" role = "button">Learn More</a><a href = "/courses/shop/foodsafetymanager/fs" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "/courses/shop/foodsafetymanager/fs"><?php echo $fs_c_name; ?></a></h4>
		</div>
        <a href = "/courses/shop/foodsafetymanager/fs">
		<div class="price">
			<h4>$<?php echo $fs_price; ?></h4>
		</div>
        </a>
	</div>
</div>

<div class="course_container"  <?php if($course != "Ohio"){echo "style='display:none'";}else{echo "style='display:block'";}?>>
	<div class="image">
		<img src="images/oh21.png">
        <div class="btns">
			<p><a href = "/courses/foodsafetymanager/description/oh2" class = "btn btn-default" role = "button">Learn More</a><a href = "/courses/shop/foodsafetymanager/oh2" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "/courses/shop/foodsafetymanager/oh2"><?php echo $oh2_c_name; ?></a></h4>
		</div>
        <a href = "/courses/shop/foodsafetymanager/oh2">
		<div class="price">
			<h4>$<?php echo $fs_price; ?></h4>
		</div>
        </a>
	</div>
</div>

<!-- ohio level 2  retail -->
<div class="course_container"  <?php if($course != "Ohio"){echo "style='display:none'";}else{echo "style='display:block'";}?>>
	<div class="image">
		<img src="images/oh2rt1.png">
        <div class="btns">
			<p><a href = "/courses/foodsafetymanager/description/oh2rt" class = "btn btn-default" role = "button">Learn More</a><a href = "/courses/shop/foodsafetymanager/oh2rt" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "/courses/shop/foodsafetymanager/oh2rt"><?php echo $oh2rt_c_name; ?></a></h4>
		</div>
        <a href = "/courses/shop/foodsafetymanager/oh2rt">
		<div class="price">
			<h4>$<?php echo $fsrt_price; ?></h4>
		</div>
        </a>
	</div>
</div>


<div class="course_container" <?php if($course == "Ohio"){echo "style='display:none'";}else{echo "style='display:block'";}?>>
	<div class="image">
		<img src="images/fsrt1.png">
        <div class="btns">
			<p><a href = "/courses/foodsafetymanager/description/fsrt" class = "btn btn-default" role = "button">Learn More</a><a href = "/courses/shop/foodsafetymanager/fsrt" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "/courses/shop/foodsafetymanager/fsrt"><?php echo $fsrt_c_name; ?></a></h4>
		</div>
        <a href = "/courses/shop/foodsafetymanager/fsrt">
		<div class="price">
			<h4>$<?php echo $fsrt_price; ?></h4>
		</div>
        </a>
	</div>
</div>


<div class="course_container" <?php if($course != "Minnesota"){echo "style='display:none'";}else{echo "style='display:block'";}?>>
	<div class="image">
		<img src="images/remn1.png">
        <div class="btns">
			<p><a href = "/courses/foodsafetymanager/description/remn" class = "btn btn-default" role = "button">Learn More</a><a href = "/courses/shop/foodsafetymanager/remn" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "/courses/shop/foodsafetymanager/remn"><?php echo $remn_c_name; ?></a></h4>
		</div>
        <a href = "/courses/shop/foodsafetymanager/remn">
		<div class="price">
			<h4>$<?php echo $refs_price; ?></h4>
		</div>
        </a>
	</div>
</div>

<div class="course_container" <?php if($course != "Rhode Island"){echo "style='display:none'";}else{echo "style='display:block'";}?>>
	<div class="image">
		<img src="images/reri1.png">
        <div class="btns">
			<p><a href = "/courses/foodsafetymanager/description/reri" class = "btn btn-default" role = "button">Learn More</a><a href = "/courses/shop/foodsafetymanager/reri" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "/courses/shop/foodsafetymanager/reri"><?php echo $reri_c_name; ?></a></h4>
		</div>
        <a href = "/courses/shop/foodsafetymanager/reri">
		<div class="price">
			<h4>$<?php echo $refs_price; ?></h4>
		</div>
        </a>
	</div>
</div>

<div class="course_container" <?php if($course != "Wisconsin"){echo "style='display:none'";}else{echo "style='display:block'";}?>>
	<div class="image">
		<img src="images/rewi1.png">
        <div class="btns">
			<p><a href = "/courses/foodsafetymanager/description/rewi" class = "btn btn-default" role = "button">Learn More</a><a href = "/courses/shop/foodsafetymanager/rewi" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "/courses/shop/foodsafetymanager/rewi"><?php echo $rewi_c_name; ?></a></h4>
		</div>
        <a href = "/courses/shop/foodsafetymanager/rewi">
		<div class="price">
			<h4>$<?php echo $rewi_price; ?></h4>
		</div>
        </a>
	</div>
</div>

</div><!-- #wrapper-->

    



<?php include $_SERVER['DOCUMENT_ROOT'].'/shared/footer.php';?>
</body>
</html>