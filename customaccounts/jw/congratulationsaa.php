<?php
$con = mssql_connect($_SERVER['DB_HOSTNAME'],$_SERVER['DB_USERNAME'],$_SERVER['DB_PASSWORD']);
mssql_select_db('newtap', $con);

error_reporting(0); 
session_start();

$username = $_GET["username"];

//get student info
$SQL = "SELECT * FROM [09D] WHERE UU='$username' ";
$resultset=mssql_query($SQL, $con);
while ($row = mssql_fetch_array($resultset)) 
{
    $firstname = $row['NF'];
    $lastname = $row['NL'];
    $email = $row['UM'];
    $password = $row['UC'];
    $lang = $row['ES'];
}
//get DOB
$SQL = "SELECT BD FROM [AllergenDob] WHERE UU='$username' ";
$resultset=mssql_query($SQL, $con);
while ($row = mssql_fetch_array($resultset)) 
{
    $DOB = $row['BD'];
    $DOB = strtotime($DOB);
    $DOB=date('m/d/Y', $DOB);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Food Safety Training | TAP Series</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
  
<div class="container">
    <div class="page-header">
        <h1>Add New Student <small>Confirmation</small></h1>
    </div>
    <div class="alert alert-success alert-dismissable fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Success!</strong> This student has been added to <strong>Allergen Awareness</strong>.
    </div>

    <ul>
        <li>The student listed below is now registered. The information below has been sent to the student by e-mail, along with directions on how to start the course. You can also print this page and give it to the student directly.</li>
        <li>A full refund will be provided if only Lesson 1 has been started, materials are returned undamaged, and/or it has not been longer than 30 days from the date on the Order Form. If lesson 2 has not been started, the course can be assigned to another person for up to one year for a $20 name change fee. We reserve the right to charge a $5 fee for Food Handler name changes.</li>
    </ul>

    <br>
    <table class="table table-responsive">
    <thead>
      <tr></tr>
      <tr></tr>
      <tr>
        <td>First Name:</td>
        <td><?php echo "$firstname";?></td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Last Name:</td>
        <td><?php echo "$lastname";?></td>
      </tr>
      <tr>
        <td>Student Email:</td>
        <td><?php echo "$email";?></td>
      </tr>
      <tr>
        <td>Username:</td>
        <td><?php echo "$username";?></td>
      </tr>
      <tr>
        <td>Password:</td>
        <td><?php echo "$password";?></td>
      </tr>
      <tr>
        <td>Training Program:</td>
        <td>Allergen Awareness</td>
      </tr>
      <tr>
        <td>Language:</td>
        <td><?php echo "$lang";?></td>
      </tr>
      <tr>
        <td>Student Birthdate:</td>
        <td><?php echo "$DOB";?></td>
      </tr>
    </tbody>
  </table>

  <br>
  <a href="indexaa.php" class="btn btn-primary" role="button">Add More Students</a>
       
</div>

</body>
</html>