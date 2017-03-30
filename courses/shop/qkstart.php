<?php
error_reporting(0); 
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


<div class="container" >
<div class="page-header">
  <h1>District Managers</h1>
</div>
 <div class="row col-md-6 col-md-offset-3 <?php echo isset($err) ? 'hello': 'hidden' ?>">
                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>ERROR:</strong> That username was not found. Please try again.
                </div>
            </div>
<div class="clearfix"></div>
<div class="well text-center">
<p>Please enter your username in the box below and click Submit.<br>
Example: qk000</p>
<br>
<form action="qk_verify_store.php" method="get">
<label>Username</label>
<input type="text" class="form-control" name="UN" style="max-width:400px;margin:auto;text-align:center" autocomplete="off" required>
<br>
<input type="submit" class="btn btn-primary" value="Submit">
</form>
<br>
<p><strong>For technical support, please call<br>888-826-5222</strong></p>
</div>

</div>






</div>


</body>
</html>
