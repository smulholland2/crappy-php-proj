<?php
 error_reporting(0);

$user=$_SERVER['DB_USERNAME'];
$password=$_SERVER['DB_PASSWORD'];
$server=$_SERVER['DB_HOSTNAME'];
$database='newtap';
$con = mssql_connect($server,$user,$password) or die('Could not connect to the server!');
mssql_select_db($database, $con) or die('Could not select a database.'); 

$ProID=$_GET["ProID"];

// For regular courses 
$Price_Table = "07SL1"; 

if($ProID == "WVBA" OR $ProID == "WVCH" OR $ProID == "WVMN" OR $ProID == "WVPE" OR $ProID == "WVPO" OR $ProID == "WVUP" OR $ProID == "WVWA" OR $ProID == "WVOH"  OR $ProID == "WVRN")
{
	//West Virginia Counties Price Table
	$Price_Table = "07SL1WV"; 
}

if($ProID == "txfsh"){
	$Price_Table = "07SL1TX";
}

session_start();
$discode = $_SESSION["discode"];
$price_discode = $_SESSION["price_discode"];

$purchasestate = $_SESSION["alcoholtraining"]["purchasestate"];

$corporate_username=$_SESSION["corporate_username"];
$corpVC=$_SESSION["corpVC"];

$purchase_license_keys=$_SESSION["purchase_license_keys"];

if($ProID == "westvirginia")
{
	$Course_Name="West Virginia Courses";
	$Course_Description="Description for West Virginia";

}
else
{
	//get course info from new Courses_Table usinf ProID
	$SQL4="SELECT * FROM Courses_Table WHERE ProID='$ProID' ";
		$resultset4=mssql_query($SQL4, $con); 	
							
			while ($row = mssql_fetch_array($resultset4)) 
			{
				$Price_Column = $row['Price_Column'];
				$Course_Name = $row['Course_Name'];
				$Certificate_Expiration = $row['Certificate_Expiration'];
				$Course_Time = $row['Course_Time'];
				$Course_Description = $row['Course_Description'];
			}
}			

	
// if corporate_username and  corpVC are true it means user came from corporate place order page
if($corporate_username && $corpVC)
{
	$SQL3 = "SELECT [$Price_Column] FROM [07SL1C] WHERE VC = '$corpVC' ";				
		$resultset3=mssql_query($SQL3, $con); 	
						
		while ($row = mssql_fetch_array($resultset3)) 
		{
			$ProPrice = $row[$Price_Column];
		}		  
}

else
{

	//set discode equals to tapseries if discode is empty
	if($discode == '')
	{
		$SQL = "SELECT [$Price_Column]  FROM [$Price_Table] WHERE VC = 'tapseries' ";				
		$resultset=mssql_query($SQL, $con); 	
		
			while ($row = mssql_fetch_array($resultset)) 
			{
				$ProPrice = $row[$Price_Column];
			}    

	}
	
	//if discode is not empty get specific ProPrice from database
	else
	{
		if($price_discode){
			$real_price_discode = $price_discode;
		}
		else{
			$real_price_discode = $discode;
		}


		$SQL2 = "SELECT [$Price_Column]  FROM [$Price_Table] WHERE VC = '$real_price_discode' ";				
		$resultset2=mssql_query($SQL2, $con); 	
		
			while ($row = mssql_fetch_array($resultset2)) 
			{
				$ProPrice = $row[$Price_Column];
			}  
	}

}

// no matter what, ProPrice is never going to be empty
if($ProPrice === "")
{
	$SQL = "SELECT [$Price_Column]  FROM [$Price_Table] WHERE VC = 'tapseries' ";				
	$resultset=mssql_query($SQL, $con); 	
		while ($row = mssql_fetch_array($resultset)) 
		{
		     $ProPrice = $row[$Price_Column];
		}  
	
}
$ProPrice = number_format($ProPrice,2);



if($ProID=="alc"){
		$SQL5="SELECT * FROM Alcohol_Courses WHERE State='$purchasestate' ";
		$resultset5=mssql_query($SQL5, $con); 					
			while ($row = mssql_fetch_array($resultset5)) 
			{
				$Course_Name = $row['Course_Name'];
				$Course_Description = $row['Description'];
			}


}

//echo $ProID;
//print_r($_SESSION);
?>





<!DOCTYPE html>
<html>
<head>
<title><?php echo $Course_Name;?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<style>
.panel-group .panel-heading {
    background-color: #1E2B41;
    color:white;	
}
a:hover {
text-decoration:none;	
}
.container {
    width: 100% !important;
	margin-top:-10px;
	border:1px solid transparent;
}	
body{
	background-color:white;
	font-family: 'Open Sans', sans-serif;  
	font-size:20px;
}
#wrapper{
	max-width:650px !important;
	height:100%;
	border:2px solid white;
	background-color:white;
	margin:100px auto;
	border-radius:5px;
	box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}
button{
	background-color:#1E2B41;
	border:3px solid #1E2B41;
	color:white;
	font-size:25px;
	font-weight:bold;
	cursor:pointer;
	border-radius:3px;
	height:50px;
	width:100% !important;
}

button:hover{
	background-color:#182234;
}

 #img_container img{
	 width:100% !important;
	 border-radius:3px;
 }

 #img_details{
	 margin:20px auto;
	 max-width:95%;
	 min-height:280px;
	 border: 1px solid transparent;
	 
 }
 #img_container{
	 width: 43%;
	 height:auto;
	 border:1px solid transparent;
	 float:left;
 }
 #details_container{
	 width: 55%;
	 height:auto;
	 border:1px solid transparent;
	 float: right;
	 margin-left:5px;
	 margin-top:20px;
 }


@media only screen and (max-width: 670px) {
#wrapper{
	max-width:325px !important;
}
#img_container{
	 width: 95%;
	 margin:auto;
	 float: none;
}
#details_container{
	 width: 100%;
	 height:auto;
	 float: none;
 }


 }	 
</style>
</head>
<body>
<?php include $_SERVER['DOCUMENT_ROOT'].'/shared/header.php';?>	
<div id="wrapper">

<h2 style="text-align:center;color:#1E2B41;padding:0px 20px 0px 20px"><?php echo $Course_Name;?><?php if($purchase_license_keys=="yes"){echo" License Key";}?></h2>
<p <?php if($ProID=="WVMV"){echo"style='display:block;font-size:12px;text-align:center;padding:0px 20px 0px 20px'";}else{echo"style='display:none'";}?>><strong>This includes Calhoun County, Pleasants County, Ritchie County, Roane County, Wirt County, and Wood County</strong></p>
<p <?php if($ProID=="WVPE" OR $ProID=="WVPO" OR $ProID=="WVRN"){echo"style='display:block;font-size:12px;text-align:center;padding:0px 20px 0px 20px'";}else{echo"style='display:none'";} ?>><strong> If you pay the county fee, your handler card will ONLY be valid in <?php if($ProID=="WVPE"){echo "Pendleton";} if($ProID=="WVPO"){echo"Pocahontas";} ?> County</strong></p>
<div id="img_details">
<div id="img_container"><img src="/courses/shop/images/<?php if($ProID=="ad"){echo "allergend";}else{echo "$ProID";}?>1.png"></div>
<div id="details_container">
	<form method="post" action="/courses/shop/sc_shopping_cart.php" <?php if ($ProID == "westvirginia"){ echo 'style="display:none;"'; }?> >
		<input type="hidden" name="Qty" value="1">
		<input type="hidden" name="ProName" value="<?php echo $Course_Name;?>">
		<input type="hidden" name="ProID" value="<?php echo $ProID;?>">
		<input type="hidden" name="ProPrice" value="<?php  echo $ProPrice; ?>">
		<!--<p><strong>Course: </strong><?php echo $Course_Name;?><?php if($purchase_license_keys=="yes"){echo" License Key";}?></p>-->
		<p><strong>Price: </strong> $<?php echo $ProPrice;?></p>
		<p><strong>Certificate Valid for: </strong><?php echo $Certificate_Expiration;?></p>
		<p><strong>Approximate Time: </strong><?php echo $Course_Time;?></p>
		<p><strong>Compatible: </strong>Computers, tablets and smartphones</p>
		<p style="text-align:center"><button tyle="submit">Buy Now</button></p>
	</form>
	<!-- Pendleton County & Pocahontas County State Fee + $10   -->
</div>

</div>

<!-- details -->
<div class="container">
  <div class="panel-group">
    <div class="panel-primary class">
      <a data-toggle="collapse" href="#collapse1">    
	<div class="panel-heading">
	   <h4 class="panel-title">
	     Description <span class="caret"></span>
	   </h4>
	</div>
      </a>	
      <div id="collapse1" class="panel-collapse collapse">
        <div class="panel-body">
		<?php echo $Course_Description;?>
		</div>
      </div>
    </div>
  </div>
</div>

</div>







<!-- show only when user wants to purchase WVPE or WVPO, state fee-->
<div id="wrapper" <?php if ($ProID == "WVPE" OR $ProID == "WVPO"  OR $ProID == "WVRN"){ echo "style='display:block;margin-top:-40px' "; }else{ echo "style='display:none;' "; }?> >
<h2 style="text-align:center;color:#1E2B41;padding:0px 20px 0px 20px"><?php echo $Course_Name;?><?php if($purchase_license_keys=="yes"){echo" License Key";}?></h2>
<p style="font-size:12px;text-align:center;padding:0px 20px 0px 20px"><strong>If you pay the state fee, your handler card will be valid in the entire state</strong></p>
<div id="img_details">
<div id="img_container"><img src="/courses/shop/images/<?php echo $ProID;?>1.png"></div>
<div id="details_container" style="margin-top:0px">
	<form method="post" action="/courses/shop/sc_shopping_cart.php" >
		<br>
		<input type="hidden" name="Qty" value="1">
		<input type="hidden" name="ProName" value="<?php echo $Course_Name;?>">
		<input type="hidden" name="ProID" value="<?php echo $ProID;?>">
		<input type="hidden" name="ProPrice" value="<?php  echo $StatePrice = $ProPrice+10; ?>">
		
		<p><strong>Price: </strong> $<?php echo $StatePrice = $ProPrice+10;?></p>
		<p><strong>Certificate Valid for: </strong><?php echo $Certificate_Expiration;?></p>
		<p><strong>Approximate Time: </strong><?php echo $Course_Time;?></p>
		<p><strong>Compatible: </strong>Computers, tablets and smartphones</p>
		<p style="text-align:center"><button tyle="submit">Buy Now </button></p>
	</form>
</div>
</div>
<!-- details -->
<div class="container">
  <div class="panel-group">
    <div class="panel-primary class">
      <a data-toggle="collapse" href="#collapse2">    
	<div class="panel-heading">
	   <h4 class="panel-title">
	     Description <span class="caret"></span>
	   </h4>
	</div>
      </a>	
      <div id="collapse2" class="panel-collapse collapse">
        <div class="panel-body">
		<?php echo $Course_Description;?>
		</div>
      </div>
    </div>
  </div>
</div>
</div>
<!-- END show only when user wants to purchase WVPE or WVPO, state fee-->


<?php //print_r($_SESSION); ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/shared/footer.php';?>
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
