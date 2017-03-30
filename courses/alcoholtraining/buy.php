<?php

    include_once $_SERVER["DOCUMENT_ROOT"]."/courses/CoursesController.php";

    session_start();

    $courses = new CoursesController();

    if(isset($_POST['state']) && strlen($_POST['state']) === 2)
    {
        $state = $courses -> PurchaseState();
        exit;
    }
    else
    {
        $course = $courses -> AlcoholCourse();
    }
?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo $Course_Name;?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<style>
.panel-group .panel-heading {
    background-color: #1E2B41;
    color:white;	
}
a:hover {
text-decoration:none;	
}
.container {
    width: 100%;
	margin-top:-10px;
	border:1px solid transparent;
}	
body{
	background-color:white;
	font-family: 'Open Sans', sans-serif;  
	font-size:20px;
}
#wrapper{
	max-width:650px;
	height:100%;
	border:2px solid white;
	background-color:white;
	margin:100px auto;
	border-radius:5px;
	box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}
button{
	background-color:#1E2B41;
	border:3px solid #1E2B41;
	color:white;
	font-size:25px;
	font-weight:bold;
	cursor:pointer;
	border-radius:3px;
	height:50px;
	width:100%;
}

button:hover{
	background-color:#182234;
}

 img{
	 width:100%;
	 border-radius:3px;
 }

 #img_details{
	 margin:20px auto;
	 max-width:95%;
	 min-height:280px;
	 border: 1px solid transparent;
	 
 }
 #img_container{
	 width: 43%;
	 height:auto;
	 border:1px solid transparent;
	 float:left;
 }
 #details_container{
	 width: 55%;
	 height:auto;
	 border:1px solid transparent;
	 float: right;
	 margin-left:5px;
	 margin-top:20px;
 }


@media only screen and (max-width: 670px) {
#wrapper{
	max-width:325px;
}
#img_container{
	 width: 95%;
	 margin:auto;
	 float: none;
}
#details_container{
	 width: 100%;
	 height:auto;
	 float: none;
 }


 }	 
</style>
</head>
<body>
	
<div id="wrapper">
<h2 style="text-align:center;color:#1E2B41;padding:0px 20px 0px 20px"><?php echo $_SESSION['alcoholtraining']['purchasestate']; ?>&nbsp;State Alcohol Training</h2>
<div id="img_details">
<div id="img_container"><img src="/courses/shop/images/<?php echo $course['ProID'];?>1.png"></div>
<div id="details_container">
	<form method="get" action="/courses/shop/sc_shopping_cart.php" >
		<br>
		<input type="hidden" name="Qty" value="1">
		<input type="hidden" name="ProName" value="<?php echo $course['CourseName'] ?>">
		<input type="hidden" name="ProID" value="<?php echo $course['ProID'] ?>">
		<input type="hidden" name="ProPrice" value="<?php echo $course['Price'] ?>">
		
		<p><strong>Price: </strong> $<?php echo $course['Price'] ?></p>
		<p><strong>Certificate Valid for: </strong><?php echo $course['CertificateExpiration'] ?></p>
		<p><strong>Approximate Time: </strong><?php echo $course['CourseTime'] ?></p>
		<p><strong>Compatible: </strong>Computers, tablets and smartphones</p>
		<p style="text-align:center"><button tyle="submit">Buy Now </button></p>
	</form>
</div>
</div>
<!-- details -->
<div class="container">
  <div class="panel-group">
    <div class="panel-primary class">
      <a data-toggle="collapse" href="#collapse2">    
	<div class="panel-heading">
	   <h4 class="panel-title">
	     Description <span class="caret"></span>
	   </h4>
	</div>
      </a>	
      <div id="collapse2" class="panel-collapse collapse">
        <div class="panel-body">
		<?php echo $course['CourseDescription'] ?>
		</div>
      </div>
    </div>
  </div>
</div>