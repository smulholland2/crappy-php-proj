<?php

    if(isset($_GET["discode"])){
        $discode = $_GET["discode"];

        $conn = mssql_connect($_SERVER['DB_HOSTNAME'], $_SERVER['DB_USERNAME'], $_SERVER['DB_PASSWORD']);
        mssql_select_db("newtap", $conn);
        
        // Grab the html and logo url from the database.
        $sql = "SELECT logo, html, js, css FROM [discodes] WHERE discode = '$discode' ";
        $stmt = mssql_query ( $sql , $conn );
        // If there was a database error, send them to a 500 page.
        if($stmt === false)
            header("Location:/500");
        $result = mssql_fetch_assoc($stmt);
        // If the discode is not found, send them to the 404 page.
        if(!$result)
            header("Location:/404");

        $htmlcode =$result["html"];
        $logo =$result["logo"];
        $customcss =$result["css"];
        $customjs =$result["js"];
    }
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
 	max-width: 300px;
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

    <img src="/wwwroot/images/4ulogos/<?php echo $logo ?>">
    <br><br>
    <?php echo $htmlcode; ?>
    <br>
    <h4><strong>&#169; Copyright <?php echo $cyear=date("Y"); ?> TAP Series, LLC <br><a style='text-decoration:none' href='/home/privacy'>Privacy Policy</a></strong></h4>
</div>
<?php echo isset($customcss) ? '<style>'.$customcss.'</style>' : null; ?>
<?php echo isset($customjs) ? '<script>'.$customjs.'</script>' : null; ?>
</body>
</html>    
