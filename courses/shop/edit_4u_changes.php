<?php
$user=$_SERVER['DB_USERNAME'];
$password=$_SERVER['DB_PASSWORD'];
$server=$_SERVER['DB_HOSTNAME'];
$database='newtap';
$con = mssql_connect($server,$user,$password) or die('Could not connect to the server!');
mssql_select_db($database, $con) or die('Could not select a database.');

$discode = $_GET["discode"];

$SQL = " SELECT * FROM discodes WHERE discode = '$discode' ";
        $resultset=mssql_query($SQL, $con); 
        while ($row = mssql_fetch_array($resultset)) 
        {
            $discode = $row['discode'];
            $price_discode = $row['price_discode'];
            $logo = $row['logo'];
            $html = $row['html'];
            $js = $row['js'];
            $css = $row['css'];
            $active = $row['active'];
            $corporate_username = $row['corporate_username'];
            $region_username = $row['region_username'];
            $account_username = $row['account_username'];
            $add_id = $row['add_id'];
        }

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>4u Editor</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
  input{
    max-width:300px !important;
  }
  </style>
</head>
<body>

<div class="container">

  <div class="page-header">
    <h1>4u Editor</h1>
  </div>  
  <form method="get" action="edit_4u_changes_db.php">
    <div class="form-group">
      <h2>Editing <span style="color:#034f84"><?php echo $discode;?></span></h2>
      <input type="hidden" name="discode" value="<?php echo $discode;?>">
    </div>
    <div class="form-group">
      <label>price_discode:</label>
      <input type="text" class="form-control" name="price_discode" value="<?php echo $price_discode;?>">
    </div>
    <div class="form-group">
      <label>logo:</label>
      <input type="text" class="form-control" name="logo" value="<?php echo $logo;?>">
    </div>
    <div class="form-group">
      <label>js:</label>
      <input type="text" class="form-control" name="js" value="<?php echo $js;?>">
    </div>
    <div class="form-group">
      <label>css:</label>
      <input type="text" class="form-control" name="css" value="<?php echo $css;?>">
    </div>
    <div class="form-group">
      <label>active (1 or 0):</label>
      <input type="text" class="form-control" name="active" value="<?php echo $active;?>">
    </div>
    <div class="form-group">
      <label>corporate_username:</label>
      <input type="text" class="form-control" name="corporate_username" value="<?php echo $corporate_username;?>">
    </div>
    <div class="form-group">
      <label>region_username:</label>
      <input type="text" class="form-control" name="region_username" value="<?php echo $region_username;?>">
    </div>
    <div class="form-group">
      <label>account_username:</label>
      <input type="text" class="form-control" name="account_username" value="<?php echo $account_username;?>">
    </div>
    <div class="form-group">
      <label>add_id:</label>
      <input type="text" class="form-control" name="add_id" value="<?php echo $add_id;?>">
    </div>
    <div class="form-group">
      <label>html:</label>
      <textarea class="form-control" name="html" style="height:300px"><?php echo $html;?></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
    <a href="edit_4u.php" class="btn btn-default" role="button">Go Back</a>
    
  </form>
</div>
<br><br>

</body>
</html>