<?php
error_reporting(0); 
session_start();
$click = $_GET["click"];
$err = $_GET["err"];


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>


<div class="container" <?php if($click=="d"){echo "style='display:block'";}else{echo "style='display:none'";}?>>
<div class="page-header">
  <h1>District Managers</h1>
</div>
        <div class="alert alert-danger" <?php if($_SESSION["bad_username"]){echo "style='display:block'";}else{echo "style='display:none'";}?>>
          <strong>Usernames need to start with the letters bnd and end with your district number.</strong>
        </div>
        <div class="alert alert-danger" <?php if($_SESSION["username_pending"]){echo "style='display:block'";}else{echo "style='display:none'";}?>>
          <strong>Your account is still pending,  you will be notified when your account is active.</strong>
        </div>
<div class="well text-center">
<p>Please enter your user name in the box below and click Submit.<br>
Your user name is the letters bnd and your district number without spaces. Example: bnd00</p>
<br>
<form action="bandn_verify_store.php" method="get">
<label>Username</label>
<input type="text" class="form-control" name="UN" style="max-width:400px;margin:auto;text-align:center" autocomplete="off" required>
<br>
<input type="submit" class="btn btn-primary" value="Submit">
</form>
<br>
<p><strong>For technical support, please call<br>888-826-5222</strong></p>
</div>

</div>



<div class="container" <?php if($click=="s"){echo "style='display:block'";}else{echo "style='display:none'";}?>>
<div class="page-header">
  <h1>Store Managers</h1>
</div>
        <div class="alert alert-danger" <?php if($_SESSION["bad_username"]){echo "style='display:block'";}else{echo "style='display:none'";}?>>
          <strong>Usernames need to start with the letters bnd and end with your district number.</strong>
        </div>
        <div class="alert alert-danger" <?php if($_SESSION["username_pending"]){echo "style='display:block'";}else{echo "style='display:none'";}?>>
          <strong>Your account is still pending,  you will be notified when your account is active.</strong>
        </div>

<div class="well text-center">
<p>Please enter your user name in the box below and click Submit.<br>
Your user name is the letters bnd and your district number without spaces. Example: bnd00</p>
<br>
<form action="bandn_verify_store.php" method="get">
<label>Username</label>
<input type="text" class="form-control" name="UN" style="max-width:400px;margin:auto;text-align:center" autocomplete="off" required>
<input type="hidden" name="click" value="s">
<br>
<input type="submit" class="btn btn-primary" value="Submit">
</form>
<br>
<p><strong>For technical support, please call<br>888-826-5222</strong></p>
</div>


</div>

<?php unset($_SESSION['bad_username']);?>
<?php unset($_SESSION['username_pending']);?>

</body>
</html>
