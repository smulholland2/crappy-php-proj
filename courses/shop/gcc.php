<?php 
session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>4u page</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

 <style>
 img{
 	width: 300px;
 	border:1px solid transparent;
 }
 .container{
 	margin-top: 30px;
 }
 .btn{
 	background-color: #1E2B41;
 	border-color: #1E2B41;
 	margin-left: 20px;
 	margin-top:5px;
 } 		
 </style>      

</head>
<body>
<div class="container text-center">
    <img src="/courses/shop/images4u/ghirlogo.jpg">
    <br><br>
    


<h1>Welcome to the Training Achievement Program Series (TAP Series) training site.</h1>
<br>
<h4>Please enter your user name in the box below and click Submit.<br>Your user name is the letters gc and your store number without spaces. Example: gc000</h4>
		<div class="alert alert-danger" <?php if($_SESSION["bad_username"]){echo "style='display:block'";}else{echo "style='display:none'";}?>>
          <strong>Usernames need to start with the letters gc and end with your store number.</strong>
        </div>
		<div class="alert alert-danger" <?php if($_SESSION["username_pending"]){echo "style='display:block'";}else{echo "style='display:none'";}?>>
          <strong>Your account is still pending,  you will be notified when your account is active.</strong>
        </div>
<div class="well" style="max-width: 300px;margin: 40px auto;">
	<form action="gcc_verify_store.php" method="get">
		<div class="form-group">
			<label>Username</label>
  			<input type="text" class="form-control" name="UN" style="text-align: center;" autocomplete="off" required>
		</div>
		<div class="form-group">
  			<input type="submit" class="btn btn-primary" value="Submit">
		</div>
	</form>	
</div>
<h4>For technical support, please call<br>888-826-5222</h4>
<br>
<h4><strong>&copy; Copyright 2017 TAP Series, LLC <br /><a style="text-decoration: none;" href="/home/privacy">Privacy Policy</a></strong></h4>




</div>
<?php //print_r($_SESSION); ?>
<?php unset($_SESSION['bad_username']);?>
<?php unset($_SESSION['username_pending']);?>

</body>
</html>    