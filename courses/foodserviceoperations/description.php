<?php

    // $_SESSION['course']['state']);
    if(isset($_GET['id'])){
        $sql = "SELECT [Course_Name],[ProID],[Course_Description] FROM [Courses_Table] WHERE [ProID] = '" . $_GET['id'] . "'";
        $id = $_GET['id'];
    }
    /*
    else{
        $sql = "SELECT [ProductName],[ProId],[ProductDescription],[Price] FROM [07DS2] WHERE [ProId] = 'nfon'";
    }
    */    

    $conn = mssql_connect($_SERVER['DB_HOSTNAME'], $_SERVER['DB_USERNAME'], $_SERVER['DB_PASSWORD']);
    mssql_select_db("newtap", $conn);

    $response["rows"] = [];
    $stmt = mssql_query ( $sql , $conn );
    if( $stmt === false ) {        
        $this -> Failed(self::INVALIDQUERYEC);
    } else {
        while( $row = mssql_fetch_assoc($stmt) ) {
            $response["rows"] > 1 ? array_push($response["rows"], $row) : false;
        }
        $name = $response["rows"][0]["Course_Name"];
        //$id = $response["rows"][0]["ProID"];
        $description = $response["rows"][0]["Course_Description"];
        //$price = $response["rows"][0]["Price"];
    }

session_start();
$course = implode(" ",$_SESSION['course']);
  

?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/shared/header.php';?>
<div id="wrapper">
    <div class="container">
        <div class="col-md-12">
            <div class="page-header">
                <h1><?php echo $name; ?></h1>
            </div>
			<br />
            <div class="row">
                 <p><?php echo str_replace("MyCourse",$course,$description); ?></p>
                 <a class="btn btn-primary" href="/courses/shop/foodserviceoperations/<?php echo $id; ?>"; >Buy It</a>                 
            </div>
            <br />
            <div class="row">            
                <strong>Terms of Purchase</strong>
                <p>100% money back of the purchase price, or credit to your corporate account, if returned within 30 days of enrollment, and if no more than lesson 1 has been studied. If you have any questions or comments on our return policy/terms of purchase, please feel free to contact us at 888-826-5222.</p>
                <p>Courses are purchased as single use enrollments. Each lesson allows up to 5 reviews. After 5 reviews the lesson is closed. Courses are active for 180 days from date of enrollment and will stop functioning 180 days after the enrollment. Within the 180 day active period, the name of the student can be changed for a $20 fee for all courses except Food Handler, if a TAP Certificate of Achievement has NOT been awarded. Changing of the name will not re-activate any inactive, closed or ended functions. We reserve the right to charge a $5 fee for Food Handler name changes.</p> 
                <a href="/certificate/namechange">To submit a name change form, click here.</a>
                <br />
                <a href="/home/privacy">Click here for privacy policy</a>
                <br />
                <a href="/home/privacyhs">Seguridad y Confidencial de Informacion</a>
            </div>
			<br />
        </div>
    </div>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'].'/shared/footer.php';?>
</body>
</html>