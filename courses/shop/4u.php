<?php

    //unset all the session variables from other 4u pages
    session_start();
    // remove all session variables
    session_unset(); 


    if(isset($_GET["discode"])){
        $discode = $_GET["discode"];

        $conn = mssql_connect($_SERVER['DB_HOSTNAME'], $_SERVER['DB_USERNAME'], $_SERVER['DB_PASSWORD']);
        mssql_select_db("newtap", $conn);
        
        // Grab the html and logo url from the database.
        $sql = "SELECT * FROM discodes WHERE discode = '$discode' ";
        $stmt = mssql_query ( $sql , $conn );
        if( $stmt === false ) {
            // If the discode is not found, send them to the 404 page.
            header("Location:404.php");
        } else {
            $result = mssql_fetch_assoc($stmt);
            $htmlcode =$result["html"];
            $logo =$result["logo"];

            $price_discode =$result["price_discode"];
            $corporate_super_admin =$result["corporate_username"];
            $region_username =$result["region_username"];
            $account_username =$result["account_username"];
            $add_id =$result["add_id"];

            // sessions
            $_SESSION["discode"] = $discode;

            if(!empty($price_discode)){
                 $_SESSION["price_discode"] = $price_discode;
            }
            if(!empty($corporate_super_admin)){
                 $_SESSION["corporate_super_admin"] = $corporate_super_admin;
            }
            if(!empty($region_username)){
                 $_SESSION["region_username"] = $region_username;
            }
            if(!empty($account_username)){
                 $_SESSION["account_username"] = $account_username;
				$_SESSION["user"] = $account_username;
							$_SESSION["admintable"] = "07L3";
            }
			

            if(!empty($add_id)){
                 $_SESSION["add_id"] = $add_id;
            }



        }
    }
?>

<!DOCTYPE html>
<html>
<head>
	<title>4u page</title>
    <meta name="robots" content="noindex">
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
    <img src="/courses/shop/images4u/<?php echo $logo; ?>" <?php if($logo){ echo "style='display:inline'";}else{echo "style='display:none'";}?>>
    <br><br>
    <?php echo $htmlcode; ?>
</div>
<?php //print_r($_SESSION); ?>
<script>
<?php
if($_SESSION["discode"]=="ol2"){
    echo "  
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-90592116-1', 'auto');
            ga('send', 'pageview');
        ";    
}
?>
</script>
</body>
</html>    
