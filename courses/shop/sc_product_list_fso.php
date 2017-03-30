<?php
$user=$_SERVER['DB_USERNAME'];
$password=$_SERVER['DB_PASSWORD'];
$server=$_SERVER['DB_HOSTNAME'];
$database='newtap';
$con = mssql_connect($server,$user,$password) or die('Could not connect to the server!');
mssql_select_db($database, $con) or die('Could not select a database.');

    //Get Course Price
	$SQL = "SELECT [03C], [05C], [06C] FROM [07SL1] WHERE VC = 'tapseries' ";				
	$resultset=mssql_query($SQL, $con); 	
		while ($row = mssql_fetch_array($resultset)) 
		{
		     $cb_price = $row['03C'];
			 $cb_price = number_format($cb_price,2);

		     $sfis_price = $row['05C'];
			 $sfis_price = number_format($sfis_price,2);

		     $emws_price = $row['06C'];
			 $emws_price = number_format($emws_price,2);
		}

    //Get Courses Name


    $SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'cb' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $cb_c_name = $row['Course_Name'];
		}     
    $SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'sfis' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $sfis_c_name = $row['Course_Name'];
		}
    $SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'emws' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $emws_c_name = $row['Course_Name'];
		}
	$SQL2 = "SELECT Course_Name FROM Courses_Table WHERE ProID = 'cf' ";				
	$resultset2=mssql_query($SQL2, $con); 	
	    while ($row = mssql_fetch_array($resultset2)) 
		{
		     $cf_c_name = $row['Course_Name'];
		}
                
?>


<!DOCTYPE html>
<html>
<head>
<title>Food Service Operations Courses</title>
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
	max-width: 785px  !important;
	height: 450px;
	margin: 0px auto !important;
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
	height: 1200px  !important;
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
    height: 750px !important;
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
<h3>Food Service Operations Courses</h3>
</div>

    <div class="container">
    <div class='well'>
	<h4><strong>Terms of Purchase</strong></h4>
	100% money back of the purchase price, or credit to your corporate account, if returned within 30 days of enrollment, and if no more than lesson 1 has been studied. If you have any questions or comments on our return policy/terms of purchase, please feel free to contact us at 888-826-5222.<br><br>Courses are purchased as single use enrollments. Each lesson allows up to 5 reviews. After 5 reviews the lesson is closed. Courses are active for 180 days from date of enrollment and will stop functioning 180 days after the enrollment. Within the 180 day active period, the name of the student can be changed for a $20 fee for all courses except Food Handler, if a TAP Certificate of Achievement has NOT been awarded. Changing of the name will not re-activate any inactive, closed or ended functions. We reserve the right to charge a $5 fee for Food Handler name changes. To submit a name change form, click here.
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
 
 <!-- cooking basics -->
<div class="course_container">
	<div class="image">
		<img src="images/cb1.png">
        <div class="btns">
			<p><a href = "/courses/foodserviceoperations/description/cb" class = "btn btn-default" role = "button">Learn More</a><a href = "/courses/shop/foodserviceoperations/cb" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "/courses/shop/foodserviceoperations/cb"><?php echo $cb_c_name; ?></a></h4>
		</div>
        <a href = "/courses/shop/foodserviceoperations/cb">
		<div class="price">
			<h4>$<?php echo $cb_price; ?></h4>
		</div>
        </a>
	</div>
</div>

 <!-- strategies for increasing sales -->
<div class="course_container">
	<div class="image">
		<img src="images/sfis1.png">
        <div class="btns">
			<p><a href = "/courses/foodserviceoperations/description/sfis" class = "btn btn-default" role = "button">Learn More</a><a href = "/courses/shop/foodserviceoperations/sfis" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "/courses/shop/foodserviceoperations/sfis"><?php echo $sfis_c_name; ?></a></h4>
		</div>
        <a href = "/courses/shop/foodserviceoperations/sfis">
		<div class="price">
			<h4>$<?php echo $sfis_price; ?></h4>
		</div>
        </a>
	</div>
</div>

<!-- earn more with service -->
<div class="course_container">
	<div class="image">
		<img src="images/emws1.png">
        <div class="btns">
			<p><a href = "/courses/foodserviceoperations/description/emws" class = "btn btn-default" role = "button">Learn More</a><a href = "/courses/shop/foodserviceoperations/emws" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "/courses/shop/foodserviceoperations/emws"><?php echo $emws_c_name; ?></a></h4>
		</div>
        <a href = "/courses/shop/foodserviceoperations/emws">
		<div class="price">
			<h4>$<?php echo $emws_price; ?></h4>
		</div>
        </a>
	</div>
</div>

<!-- chef fundamentals -->
<div class="course_container">
	<div class="image">
		<img src="images/cf1.png">
        <div class="btns">
			<p><a href = "/courses/foodserviceoperations/description/cf" class = "btn btn-default" role = "button">Learn More</a><a href = "/courses/shop/foodserviceoperations/cf" class = "btn btn-primary" role = "button">Buy Now</a></p>
		</div>
	</div>
	<div class="content">
		<div class="title">
			<h4><a href = "/courses/shop/foodserviceoperations/cf"><?php echo $cf_c_name; ?></a></h4>
		</div>
        <a href = "/courses/shop/foodserviceoperations/cf">
		<div class="price">
			<h4>$<?php echo $cb_price; ?></h4>
		</div>
        </a>
	</div>
</div>

</div><!-- #wrapper-->





<?php include $_SERVER['DOCUMENT_ROOT'].'/shared/footer.php';?>
</body>
</html>