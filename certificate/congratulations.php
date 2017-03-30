<!DOCTYPE html>
<html lang="en">
<head>
  <title>Transaction Completed</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container"> 

<div class="page-header">
    <h1>Congratulations</h1>
</div>
<p>Click the button below to print your certificate</p> 

<form action="reprint_cert.php" method="post" target="_blank">
    <input type="hidden" name="id" value="<?php echo $_GET["id"]; ?>">
    <button type="submit" class="btn btn-primary">Print Certificate</button>
</form>

<br>
<form action="print_receipt.php" method="post" target="_blank">
    <input type="hidden" name="id" value="<?php echo $_GET["id"]; ?>">
    <input type="hidden" name="last4" value="<?php echo $_GET["last4"]; ?>">
    <button type="submit" class="btn btn-primary">Print Receipt</button>
</form>

</div>

</body>
</html>