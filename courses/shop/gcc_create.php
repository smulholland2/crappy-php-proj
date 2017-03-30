<?php
$UN = $_GET["UN"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container" style="margin-top:50px">
<div class="page-header">
  <h1>Store Manager Request Form</h1>
</div>

<div class="alert alert-info">
<p class="text-left"><strong>Your user name was not found in our system.<br>To set up a new account, please fill out the form below and click Submit.<br>Your information will be sent to the corporate office for approval.<br>You will be notified once the corporate office approves your account.</strong></p>
</div>
<br>

<div class="well" style="max-width:350px;margin:auto">

          <form action="gcc_create_db.php" method="get">

          <div class="form-group">
          <label>Store Username:</label>
          <input type="text" class="form-control" style="max-width:300px"   value="<?php echo $UN;?>" disabled>
          <input type="hidden" class="form-control" style="max-width:300px"  name="UN" value="<?php echo $UN;?>" required>     
          </div>

          <div class="form-group">
          <label>Store Administrator  First Name:</label><br>
          <input type="text" class="form-control" style="max-width:300px" name="NF" required>
          </div>

          <div class="form-group">
          <label>Store Administrator Last Name:</label><br>
          <input type="text" class="form-control" style="max-width:300px" name="NL" required>
          </div>

          <div class="form-group">
          <label>Store Address Line 1:</label><br>
          <input type="text" class="form-control" style="max-width:300px"  name="AA1" required>
          </div>

          <div class="form-group">
          <label>Store Address Line 2:</label><br>
          <input type="text" class="form-control" style="max-width:300px" name="AA2">(Optional)
          </div>

          <div class="form-group">
          <label>Store City:</label><br>
          <input type="text" class="form-control" style="max-width:300px"  name="ACI" required>
          </div>

          <div class="form-group">
          <label>Store State:</label><br>
          <input type="text" class="form-control" style="max-width:300px"  name="AST" required>
          </div>

          <div class="form-group">
          <label>Store Zip Code:</label><br>
          <input type="text" class="form-control" style="max-width:300px"  name="AZ" required>
          </div>

          <div class="form-group">
          <label>Store Phone Number:</label><br>
          <input type="text" class="form-control" style="max-width:300px"  name="AP">(Optional)
          </div>

          <div class="form-group">
          <label>Store E-mail Address:</label><br>
          <input type="text" class="form-control" style="max-width:300px"  name="AM" required>
          </div>

          <div class="form-group text-center">
          <input type="submit" class="btn btn-primary" value="Save Changes">
          </div>
          
          </form>

</div>
<br>
<p class="text-center"><strong>For technical support, please call<br>888-826-5222</strong></p>


</div>
<br><br><br><br>

</body>
</html>