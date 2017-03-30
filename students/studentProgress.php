<?php 
$con = mssql_connect($_SERVER['DB_HOSTNAME'],$_SERVER['DB_USERNAME'],$_SERVER['DB_PASSWORD']);
mssql_select_db('newtap', $con);
error_reporting(0);
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Student Track Progress</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<?php include $_SERVER['DOCUMENT_ROOT'].'/shared/header.php';?>

<div class="container">

<div class="page-header">
<h1>Student Track Progress</h1>
</div>

<!-- Error Message-->
<div class="alert alert-danger alert-dismissable fade in" <?php if(!$_SESSION["error"]){echo "style='display:none'";}?>>
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong><?php echo $_SESSION["error"];?></strong>
</div>
<!-- Error Message-->

<form action="studentProgress_view.php" method="post">
<div class="form-group">
<label for="username">Username:</label>
<input type="text" class="form-control" name="username" required>
</div>
<div class="form-group">
<label for="password">Password:</label>
<input type="text" class="form-control" name="password" required>
</div>
<div class="form-group">
<label for="pwd">Course:</label>
<select class="form-control" name="id" required>
    <option value=''>Select a course</option>
<?php
$SQL="SELECT ProductName, id  FROM [07DS2] WHERE LMS=1 ORDER BY ProductName";
$resultset=mssql_query($SQL, $con); 
while ($row = mssql_fetch_array($resultset)) 
{
    $ProductName = $row['ProductName'];
    $id = $row['id'];
    
    echo "<option value='$id'>$ProductName</option>";
}
?>
</select>
</div>
<button type="submit" class="btn btn-primary">Submit</button>
</form>

</div>

<?php include $_SERVER['DOCUMENT_ROOT'].'/shared/footer.php';?>
<?php unset($_SESSION["error"]); ?>
<style>
.container{
    margin-top:90px;
    height:800px;
}
.form-control{
    max-width:550px;
}
</style>
</body>
</html>
