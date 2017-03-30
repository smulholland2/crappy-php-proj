<?php
error_reporting(0);
session_start();


$user=$_SERVER['DB_USERNAME'];
$password=$_SERVER['DB_PASSWORD'];
$server=$_SERVER['DB_HOSTNAME'];
$database='newtap';
$con = mssql_connect($server,$user,$password);
mssql_select_db($database, $con);

 $studentadded = $_GET['studentadded'];
 $AN = $_GET['UA'];
 $invoice = $_GET['invoice'];
 $total = $_GET['total'];
 $last4 = $_GET['last4'];
 $LK = $_GET['LK'];
 $corp = $_GET['corp'];

 $oh2_id = $_GET['oh2_id'];

// get account password
$SQL="SELECT AC FROM [07L3] WHERE AN='$AN' ";
		$resultset=mssql_query($SQL, $con); 

		while ($row = mssql_fetch_array($resultset)) 
		{
				$AC = $row['AC'];
		}  

// user first and last name
	$SQL2 = "SELECT * FROM [07O6] WHERE AN='$AN' ";
	$resultset2=mssql_query($SQL2, $con);
	
		while ($row = mssql_fetch_array($resultset2)) 
		{
		     $DIV_NAMEc = $row['DIV_NAME'];
		}   
	
	$DIV_NAMEcustomer = explode("_", $DIV_NAMEc);
	$userfn = $DIV_NAMEcustomer[0];	//userfn
	$userln = $DIV_NAMEcustomer[1];	//userln



?>




<!DOCTYPE html>
<html>
<head>
<title>Transaction Completed</title>
	<meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<?php
if($_SESSION["discode"]=="ol2"){
    echo "  
		<!-- Google Code for Ohio Level 2 purchases Conversion Page --> 
		<script type='text/javascript'>
			/* <![CDATA[ */
			var google_conversion_id = 863205414;
			var google_conversion_language = 'en';
			var google_conversion_format = '3';
			var google_conversion_color = 'ffffff';
			var google_conversion_label = '5z0ZCK-frG0QpvDNmwM'; 
			var google_remarketing_only = false;
			/* ]]> */
		</script>
		<script type='text/javascript' src='//www.googleadservices.com/pagead/conversion.js'>
		</script>
		<noscript>
		<div style='display:inline;'>
		<img height='1' width='1' style='border-style:none;' alt=''  
		src='//www.googleadservices.com/pagead/conversion/863205414/?label=5z0ZCK-frG0QpvDNmwM&amp;guid=ON&amp;script=0'/>
		</div>
		</noscript>
        ";    
}
?>




</head>
<body>
<?php include $_SERVER['DOCUMENT_ROOT'].'/shared/header.php';?>


<?php
if($studentadded == 'yes')
{

    echo "
				
				
				<div class='container' style='margin-top:90px;margin-bottom:350px'>

				<div class='page-header'>				
				<h1>Congratulations! You were successfully enrolled to the course.</h1>
                </div>

				<div class='well'>
				<h4><strong>Terms of Purchase</strong></h4>
				If you are unsatisfied with the program for any reason, a full refund will be provided if only Lesson 1 has been started and/or it has not been longer than 30 days from the date on this receipt. If lesson 2 has not been started, the course can be assigned to another person for up to 180 days for a $20 name change fee. For further assistance, please call 818-889-8799.
				</div>

                <p><strong>Student's Full Name:</strong> $userfn $userln</p>
                <p><strong>Student's Username:</strong> $AN</p>
                <p><strong>Student's Password:</strong> $AC</p>


                <br>
				<a href='/training'><button type='button' class='btn btn-primary'>Start Training</button></a>
                <br><br>
                <a href='printreceipt.php?UA=$AN&invoice=$invoice&total=$total&last4=$last4&oh2_id=$oh2_id' target='_blank'><button type='button' class='btn btn-success' >Print Receipt</button></a>
				
				<br><br><br>



                </div>
				
				";

}

if($studentadded == 'no')
{
// Store ProID on Session
$SQL3="SELECT PC FROM [07O4] WHERE OID='$invoice' ";
$resultset3=mssql_query($SQL3, $con); 
while ($row = mssql_fetch_array($resultset3)) 
{
	echo $PC = $row['PC'];
	$_SESSION['ProID'] =  $PC;
} 

  			  echo "
					
					
					<div class='container' style='margin-top:90px;margin-bottom:350px'>
					
                    <div class='page-header'>
					<h1>Congratulations! You have successfully completed your purchase.</h1>
                    </div>

					<div class='well'>
					<h4><strong>Terms of Purchase</strong></h4>
					If you are unsatisfied with the program for any reason, a full refund will be provided if only Lesson 1 has been started and/or it has not been longer than 30 days from the date on this receipt. If lesson 2 has not been started, the course can be assigned to another person for up to 180 days for a $20 name change fee. For further assistance, please call 818-889-8799.
					</div>
					";
					if(!$LK)
					{
					echo "<h3>Training cannot be started until a student is added.</h3>";
					}
					
					if(strlen($corp) == 0)
					{
						//die(print(strlen($corp)));
						if(!$LK)
						{
							echo "
								<br>
							<a href='/admin/tools/students/single'><button type='button' class='btn btn-primary'>Click here to enroll students</button></a>
							";
						}
						echo "
						<br><br>
						<a href='printreceipt.php?UA=$AN&invoice=$invoice&total=$total&last4=$last4&LK=$LK&corp=$corp&oh2_id=$oh2_id' target='_blank'><button type='button' class='btn btn-success'>Print Receipt</button></a>
						";
					}
					else
					{
						// Get Company Name for Session
						$sql = "SELECT [UA] FROM [07L2] WHERE UU = '$AN'";

						$result = mssql_query($sql, $con);

						while ($row = mssql_fetch_array($result))
						{
							$company = $row['UA'];
							$_SESSION['displayname'] = $company;
						}

						$_SESSION['menu'] = "/admin/multi_unit";
						$_SESSION['admintable'] = "07L2";
						echo "
							<br>
						<a href='".$_SESSION['menu']."'><button type='button' class='btn btn-primary'>Click here to return to your menu</button></a>
						<br><br>
						<a href='printreceipt.php?UA=$AN&invoice=$invoice&total=$total&last4=$last4&LK=$LK&corp=$corp&oh2_id=$oh2_id' target='_blank'><button type='button' class='btn btn-success'>Print Receipt</button></a>
						";
					}
					

					if($LK)
					{
					 echo "
					 	   <br><br>
						   <p>Click <strong>Print Receipt</strong> to print your list of purchased license keys.  A list of your license keys will also be sent to you by email.</p>
						   <p>Each of your employees is to receive one license key.  The employee will use their license key as their password when they enroll themselves in the course.</p>
						";
					}	

			  echo "		
					<br><br>
					<p>If you need instructions on how to add a student, <a href='/wwwroot/pdf/tutorials/HowToAddStudent(s)Tutorial(FSH).pdf' target='_blank'>click here</a>.</p>

					<br><br>



                    </div>


				";

}

foreach ($_SESSION as $key => $value) {
	if($key != 'CREATED' && $key != 'LAST_ACTIVITY' && $key != 'admintable' && $key != 'menu' && $key != 'displayname' && $key != 'ProID')
		unset($_SESSION[$key]);
}

//storing user, AC,  into a session variable so we can add students later
$_SESSION['user'] =  $AN;
$_SESSION['AC'] =  $AC;
$_SESSION['postpurchase'] =  1;

?>

<?php include $_SERVER['DOCUMENT_ROOT'].'/shared/footer.php';?>
</body>
</html>