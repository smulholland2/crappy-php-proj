<?php
 error_reporting(0);
?>

<!DOCTYPE html>
<html>
<head>
	<title>States</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans" />

	<script>
	$(document).ready(function(){

    $(".spanish").hide();

		$("#wrapper").hide();
		$("#wrapper").fadeIn(1500);
    });

	</script>

</head>
<body>
<?php 
if(!isset($_SESSION))
  session_start();
$discode=$_GET["discode"];
if($discode==""){
include 'menu.php';
}
?>    

<h1 id="maintext" style="text-align:center;"><span  class="english">Select the state where you work</span><span class="spanish" >Seleccione el estado donde vive</span></h1>
	<p style="text-align:center;font-size:16px"><span class="english">Already paid for the course?</span><span class="spanish">Ya pago por el curso?</span> <a href="http://www.tapseries.com/onlinetraining.htm" style="text-decoration:none;color:#008abf"><span class="english">Login to Course</span><span class="spanish">Entrar al Curso</span></a></p>  
  <div id="wrapper">

  <table class="table table-bordered" style="margin-top: 30px" id="table1">
   
    <tbody>
      <tr>
        <td onclick="location.href='http://www.tapseries.com/usmap/states/AK/'">Alaska</td>
        <td onclick="location.href='http://www.tapseries.com/usmap/states/AL/'">Alabama</td>
        <td onclick="location.href='http://www.tapseries.com/usmap/states/AR/'">Arkansas</td>
        <td onclick="location.href='http://www.tapseries.com/usmap/states/AZ/'">Arizona</td>
        <td onclick="location.href='http://www.tapseries.com/usmap/states/CA/'">California</td>
      </tr>
      <tr>
        <td onclick="location.href='http://www.tapseries.com/usmap/states/CO/'">Colorado</td>
        <td onclick="location.href='http://www.tapseries.com/usmap/states/CT/'">Conneticut</td>
        <td onclick="location.href='http://www.tapseries.com/usmap/states/DC/'">District of Columbia</td>
        <td onclick="location.href='http://www.tapseries.com/usmap/states/DE/'">Delaware</td>
        <td onclick="location.href='http://www.tapseries.com/usmap/states/FL/'">Florida</td>
      </tr>
      <tr>
        <td onclick="location.href='http://www.tapseries.com/usmap/states/GA/'">Georgia</td>
        <td onclick="location.href='http://www.tapseries.com/usmap/states/HI/'">Hawaii</td>
        <td onclick="location.href='http://www.tapseries.com/usmap/states/IA/'">Iowa</td>
        <td onclick="location.href='http://www.tapseries.com/usmap/states/ID/'">Idaho</td>
        <td onclick="location.href='http://www.tapseries.com/usmap/states/IL/'">Illinois</td>
      </tr>
      <tr>
        <td onclick="location.href='http://www.tapseries.com/usmap/states/IN/ '">Indiana</td>
        <td onclick="location.href='http://www.tapseries.com/usmap/states/KS/ '">Kansas</td>
        <td onclick="location.href='http://www.tapseries.com/usmap/states/KY/ '">Kentucky</td>
        <td onclick="location.href='http://www.tapseries.com/usmap/states/LA/ '">Louisiana</td>
        <td onclick="location.href='http://www.tapseries.com/usmap/states/MA/ '">Massachusetts</td>
      </tr>
      <tr>
        <td onclick="location.href='http://www.tapseries.com/usmap/states/MD/ '">Maryland</td>
        <td onclick="location.href='http://www.tapseries.com/usmap/states/ME/ '">Maine</td>
        <td onclick="location.href='http://www.tapseries.com/usmap/states/MI/ '">Michigan</td>
        <td onclick="location.href='http://www.tapseries.com/usmap/states/MN/ '">Minnesota</td>
        <td onclick="location.href='http://www.tapseries.com/usmap/states/MO/ '">Missouri</td>
      </tr>
      <tr>
        <td onclick="location.href='http://www.tapseries.com/usmap/states/MS/ '">Mississippi</td>
        <td onclick="location.href='http://www.tapseries.com/usmap/states/MT/ '">Montana</td>
        <td onclick="location.href='http://www.tapseries.com/usmap/states/NC/ '">North Carolina</td>
        <td onclick="location.href='http://www.tapseries.com/usmap/states/ND/ '">North Dakota</td>
        <td onclick="location.href='http://www.tapseries.com/usmap/states/NE/ '">Nebraska</td>
      </tr>
      <tr>
        <td onclick="location.href='http://www.tapseries.com/usmap/states/NH/ '">New Hampshire</td>
        <td onclick="location.href='http://www.tapseries.com/usmap/states/NJ/ '">New Jersey</td>
        <td onclick="location.href='http://www.tapseries.com/usmap/states/NM/ '">New Mexico</td>
        <td onclick="location.href='http://www.tapseries.com/usmap/states/NV/ '">Nevada</td>
        <td onclick="location.href='http://www.tapseries.com/usmap/states/NY/ '">New York</td>
      </tr>
      <tr>
        <td onclick="location.href='http://www.tapseries.com/usmap/states/OH/ '">Ohio</td>
        <td onclick="location.href='http://www.tapseries.com/usmap/states/OK/ '">Oklahoma</td>
        <td onclick="location.href='http://www.tapseries.com/usmap/states/OR/ '">Oregon</td>
        <td onclick="location.href='http://www.tapseries.com/usmap/states/PA/ '">Pennsylvania</td>
        <td onclick="location.href='http://www.tapseries.com/usmap/states/RI/ '">Rhode Island</td>
      </tr>
      <tr>
        <td onclick="location.href='http://www.tapseries.com/usmap/states/SC/ '">South Carolina</td>
        <td onclick="location.href='http://www.tapseries.com/usmap/states/SD/ '">South Dakota</td>
        <td onclick="location.href='http://www.tapseries.com/usmap/states/TN/ '">Tennessee</td>
        <td onclick="location.href='http://www.tapseries.com/usmap/states/TX/ '">Texas</td>
        <td onclick="location.href='http://www.tapseries.com/usmap/states/UT/ '">Utah</td>
      </tr>
      <tr>
        <td onclick="location.href='http://www.tapseries.com/usmap/states/VA/ '">Virginia</td>
        <td onclick="location.href='http://www.tapseries.com/usmap/states/VT/ '">Vermont</td>
        <td onclick="location.href='http://www.tapseries.com/usmap/states/WA/ '">Washington</td>
        <td onclick="location.href='http://www.tapseries.com/usmap/states/WI/ '">Wisconsin</td>
        <td onclick="location.href='http://www.tapseries.com/usmap/states/WV/ '">West Virginia</td>
      </tr>
      <tr style="border:1px solid white">
      <td  onclick="location.href='http://www.tapseries.com/usmap/states/WY/ '">Wyoming</td>
      
      </tr>
    </tbody>
  </table>


  <div id="mobile_list" style="margin-top: 30px">
        <div class="mobile_option"><p onclick="location.href='http://www.tapseries.com/usmap/states/AK/'">Alaska</p></div>
        <div class="mobile_option"><p onclick="location.href='http://www.tapseries.com/usmap/states/AL/'">Alabama</p></div>
        <div class="mobile_option"><p onclick="location.href='http://www.tapseries.com/usmap/states/AR/'">Arkansas</p></div>
        <div class="mobile_option"><p onclick="location.href='http://www.tapseries.com/usmap/states/AZ/'">Arizona</p></div>
        <div class="mobile_option"><p onclick="location.href='http://www.tapseries.com/usmap/states/CA/'">California</p></div>
        <div class="mobile_option"><p onclick="location.href='http://www.tapseries.com/usmap/states/CO/'">Colorado</p></div>
        <div class="mobile_option"><p onclick="location.href='http://www.tapseries.com/usmap/states/CT/'">Conneticut</p></div>
        <div class="mobile_option"><p onclick="location.href='http://www.tapseries.com/usmap/states/DC/'">District of Columbia</p></div>
        <div class="mobile_option"><p onclick="location.href='http://www.tapseries.com/usmap/states/DE/'">Delaware</p></div>
        <div class="mobile_option"><p onclick="location.href='http://www.tapseries.com/usmap/states/FL/'">Florida</p></div>
        <div class="mobile_option"><p onclick="location.href='http://www.tapseries.com/usmap/states/GA/'">Georgia</p></div>
        <div class="mobile_option"><p onclick="location.href='http://www.tapseries.com/usmap/states/HI/'">Hawaii</p></div>
        <div class="mobile_option"><p onclick="location.href='http://www.tapseries.com/usmap/states/IA/'">Iowa</p></div>
        <div class="mobile_option"><p onclick="location.href='http://www.tapseries.com/usmap/states/ID/'">Idaho</p></div>
        <div class="mobile_option"><p onclick="location.href='http://www.tapseries.com/usmap/states/IL/'">Illinois</p></div>
        <div class="mobile_option"><p onclick="location.href='http://www.tapseries.com/usmap/states/IN/ '">Indiana</p></div>
        <div class="mobile_option"><p onclick="location.href='http://www.tapseries.com/usmap/states/KS/ '">Kansas</p></div>
        <div class="mobile_option"><p onclick="location.href='http://www.tapseries.com/usmap/states/KY/ '">Kentucky</p></div>
        <div class="mobile_option"><p onclick="location.href='http://www.tapseries.com/usmap/states/LA/ '">Louisiana</p></div>
        <div class="mobile_option"><p onclick="location.href='http://www.tapseries.com/usmap/states/MA/ '">Massachusetts</p></div>
        <div class="mobile_option"><p onclick="location.href='http://www.tapseries.com/usmap/states/MD/ '">Maryland</p></div>
        <div class="mobile_option"><p onclick="location.href='http://www.tapseries.com/usmap/states/ME/ '">Maine</p></div>
        <div class="mobile_option"><p onclick="location.href='http://www.tapseries.com/usmap/states/MI/ '">Michigan</p></div>
        <div class="mobile_option"><p onclick="location.href='http://www.tapseries.com/usmap/states/MN/ '">Minnesota</p></div>
        <div class="mobile_option"><p onclick="location.href='http://www.tapseries.com/usmap/states/MO/ '">Missouri</p></div>
        <div class="mobile_option"><p onclick="location.href='http://www.tapseries.com/usmap/states/MS/ '">Mississippi</p></div>
        <div class="mobile_option"><p onclick="location.href='http://www.tapseries.com/usmap/states/MT/ '">Montana</p></div>
        <div class="mobile_option"><p onclick="location.href='http://www.tapseries.com/usmap/states/NC/ '">North Carolina</p></div>
        <div class="mobile_option"><p onclick="location.href='http://www.tapseries.com/usmap/states/ND/ '">North Dakota</p></div>
        <div class="mobile_option"><p onclick="location.href='http://www.tapseries.com/usmap/states/NE/ '">Nebraska</p></div>
        <div class="mobile_option"><p onclick="location.href='http://www.tapseries.com/usmap/states/NH/ '">New Hampshire</p></div>
        <div class="mobile_option"><p onclick="location.href='http://www.tapseries.com/usmap/states/NJ/ '">New Jersey</p></div>
        <div class="mobile_option"><p onclick="location.href='http://www.tapseries.com/usmap/states/NM/ '">New Mexico</p></div>
        <div class="mobile_option"><p onclick="location.href='http://www.tapseries.com/usmap/states/NV/ '">Nevada</p></div>
        <div class="mobile_option"><p onclick="location.href='http://www.tapseries.com/usmap/states/NY/ '">New York</p></div>
        <div class="mobile_option"><p onclick="location.href='http://www.tapseries.com/usmap/states/OH/ '">Ohio</p></div>
        <div class="mobile_option"><p onclick="location.href='http://www.tapseries.com/usmap/states/OK/ '">Oklahoma</p></div>
        <div class="mobile_option"><p onclick="location.href='http://www.tapseries.com/usmap/states/OR/ '">Oregon</p></div>
        <div class="mobile_option"><p onclick="location.href='http://www.tapseries.com/usmap/states/PA/ '">Pennsylvania</p></div>
        <div class="mobile_option"><p onclick="location.href='http://www.tapseries.com/usmap/states/RI/ '">Rhode Island</p></div>
        <div class="mobile_option"><p onclick="location.href='http://www.tapseries.com/usmap/states/SC/ '">South Carolina</p></div>
        <div class="mobile_option"><p onclick="location.href='http://www.tapseries.com/usmap/states/SD/ '">South Dakota</p></div>
        <div class="mobile_option"><p onclick="location.href='http://www.tapseries.com/usmap/states/TN/ '">Tennessee</p></div>
        <div class="mobile_option"><p onclick="location.href='http://www.tapseries.com/usmap/states/TX/ '">Texas</p></div>
        <div class="mobile_option"><p onclick="location.href='http://www.tapseries.com/usmap/states/UT/ '">Utah</p></div>
        <div class="mobile_option"><p onclick="location.href='http://www.tapseries.com/usmap/states/VA/ '">Virginia</p></div>
        <div class="mobile_option"><p onclick="location.href='http://www.tapseries.com/usmap/states/VT/ '">Vermont</p></div>
        <div class="mobile_option"><p onclick="location.href='http://www.tapseries.com/usmap/states/WA/ '">Washington</p></div>
        <div class="mobile_option"><p onclick="location.href='http://www.tapseries.com/usmap/states/WI/ '">Wisconsin</p></div>
        <div class="mobile_option"><p onclick="location.href='http://www.tapseries.com/usmap/states/WV/ '">West Virginia</p></div>
      	<div class="mobile_option"><p  onclick="location.href='http://www.tapseries.com/usmap/states/WY/ '">Wyoming</p></div>
      </div>

  <br><br><br><br><br><br><br><br><br><br>
	  
  </div>  
	
<?php 
if($discode==""){
include 'footer.php';
}
?> 	
  
<style>
.table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
    border: 2px solid #ddd;
}	

#maintext{
	margin-top:150px
}

.mobile_option{
	border:2px solid #ddd;
	width: 90%;
	height:50px;
	margin:10px auto;
	
}
.mobile_option p{
	font-size:17px;
	
}
.mobile_option:hover{
	background-color: #333;
	color: white;
}
.mobile_option p{
	margin-top: 15px; 
}
td{
	text-align: center;
	cursor: pointer;
	font-size:16px;
}
td:hover{
	background-color: #333;
	color: white;
	border-color:#333;
}
#wrapper{
  border:1px solid transparent;
  max-width:90%;
  height:auto;
  margin:auto;
  border-radius: 5px;
}
body{
	font-family: 'Open Sans', sans-serif; 
}
p{
	text-align: center;
}
#mobile_list{
	display: none;
	cursor: pointer;
}


@media only screen and (max-width: 550px) {
#maintext{
	margin-top:110px
}

#table1{
	display: none;
}

#mobile_list {
	display: block;
}



}
  </style>

</body>
</html>