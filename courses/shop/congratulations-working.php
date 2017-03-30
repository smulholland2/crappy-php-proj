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

	// This is when a student is automatically added by a new user.	
	if($studentadded == 'yes')
	{
		$h1 = "Congratulations! You were successfully enrolled to the course.";
		$body = "<p><strong>Student's Full Name:</strong> $userfn $userln</p>";
		$body .= "<p><strong>Student's Username:</strong> $AN</p>";
		$body .= "<p><strong>Student's Password:</strong> $AC</p>";
		$body .= "<br>";
		$body .= "<a href='/training'><button type='button' class='btn btn-primary'>Start Training</button></a>";
		$body .= "<br><br>";
		$body .= "<a href='printreceipt.php?UA=$AN&invoice=$invoice&total=$total&last4=$last4&oh2_id=$oh2_id' target='_blank'><button type='button' class='btn btn-success' >Print Receipt</button></a>";
	}
	// This is when a corporate user logs in through their place order link	
	else if($studentadded == 'no' && strlen($corp) > 0)
	{
		// Store ProID on Session
		$sql = "SELECT PC FROM [07O4] WHERE OID='$invoice'";

		$result = mssql_query($sql, $con);

		while ($row = mssql_fetch_array($result))
		{
			$PC = $row['PC'];
			$_SESSION['ProID'] = $PC;
		}

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

		$h1 = "Congratulations! You have successfully completed your purchase.";
		$body = "<h3>Training cannot be started until a student is added.</h3>";
		$body .= "<br>";
		$body .= "<a href='/admin/multi_unit'><button type='button' class='btn btn-primary'>Click here to return to your main menu</button></a>";
		$body .= "<br><br>";
		$body .= "<a href='printreceipt.php?UA=$AN&invoice=$invoice&total=$total&last4=$last4&LK=$LK&corp=$corp&oh2_id=$oh2_id' target='_blank'><button type='button' class='btn btn-success'>Print Receipt</button></a>";
		
		if($LK)
		{
			$body .= "<br><br>";
			$body .= "<p>Click <strong>Print Receipt</strong> to print your list of purchased license keys.  A list of your license keys will also be sent to you by email.</p>";
			$body .= "<p>";
		}

		$body .= "<br><br>";
		$body .= "<p>If you need instructions on how to add a student, <a href='https://www.tapseries.com/tutorials/addstu.pdf' target='_blank'>click here</a>.</p>";
		$body .= "<br><br>";
		$body .= "</div>";
	}
	// This is when a company purchases a course through their place order link.
	else if($studentadded == 'no' && strlen($corp) == 0 && isset($_SESSION['admintable']))
	{
		// Store ProID on Session
		$sql = "SELECT PC FROM [07O4] WHERE OID='$invoice'";

		$result = mssql_query($sql, $con);

		while ($row = mssql_fetch_array($result))
		{
			$PC = $row['PC'];
			$_SESSION['ProID'] = $PC;
		}

		$h1 = "Congratulations! You have successfully completed your purchase.";
		$body = "<h3>Training cannot be started until a student is added.</h3>";
		$body .= "<br>";
		$body .= "<a href='/admin/tools/students'><button type='button' class='btn btn-primary'>Click here to enroll students</button></a>";
		$body .= "<br><br>";
		$body .= "<a href='printreceipt.php?UA=$AN&invoice=$invoice&total=$total&last4=$last4&LK=$LK&corp=$corp&oh2_id=$oh2_id' target='_blank'><button type='button' class='btn btn-success'>Print Receipt</button></a>";
		
		if($LK)
		{
			$body .= "<br><br>";
			$body .= "<p>Click <strong>Print Receipt</strong> to print your list of purchased license keys.  A list of your license keys will also be sent to you by email.</p>";
			$body .= "<p>";
		}

		$body .= "<br><br>";
		$body .= "<p>If you need instructions on how to add a student, <a href='https://www.tapseries.com/tutorials/addstu.pdf' target='_blank'>click here</a>.</p>";
		$body .= "<br><br>";
		$body .= "</div>";
	}
	// This is when a company purchases through the shopping cart
	else if($studentadded == 'no' && strlen($corp) == 0)
	{
		// Store ProID on Session		
		$sql = "SELECT PC FROM [07O4] WHERE OID='$invoice'";

		$result = mssql_query($sql, $con);

		while ($row = mssql_fetch_array($result))
		{
			$PC = $row['PC'];
			$_SESSION['ProID'] = $PC;
		}

		// Get Company Name for Session
		$sql = "SELECT [NCPY] FROM [07O6] WHERE AN = '$AN'";

		$result = mssql_query($sql, $con);

		while ($row = mssql_fetch_array($result))
		{
			$company = $row['UA'];
			$_SESSION['displayname'] = $company;
		}

		$_SESSION['menu'] = "/admin/company";
		$_SESSION['admintable'] = "07L3";

		$h1 = "Congratulations! You have successfully completed your purchase.";
		$body = "<h3>Training cannot be started until a student is added.</h3>";
		$body .= "<br>";
		$body .= "<a href='/admin/tools/students/single'><button type='button' class='btn btn-primary'>Click here to enroll students</button></a>";
		$body .= "<br><br>";
		$body .= "<a href='printreceipt.php?UA=$AN&invoice=$invoice&total=$total&last4=$last4&LK=$LK&corp=$corp&oh2_id=$oh2_id' target='_blank'><button type='button' class='btn btn-success'>Print Receipt</button></a>";
		
		if($LK)
		{
			$body .= "<br><br>";
			$body .= "<p>Click <strong>Print Receipt</strong> to print your list of purchased license keys.  A list of your license keys will also be sent to you by email.</p>";
			$body .= "<p>";
		}

		$body .= "<br><br>";
		$body .= "<p>If you need instructions on how to add a student, <a href='https://www.tapseries.com/tutorials/addstu.pdf' target='_blank'>click here</a>.</p>";
		$body .= "<br><br>";
		$body .= "</div>";
	}

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Transaction Completed</title>
		<meta name='viewport' content='width=device-width, initial-scale=1.0'>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	</head>
	<body>
		<?php include $_SERVER['DOCUMENT_ROOT'].'/shared/header.php';?>
		<div class='container' style='margin-top:90px;margin-bottom:350px'>
			<div class='page-header'>
				<h1><?php echo $h1; ?></h1>
			</div>
			<div class='well'>
				<h4><strong>Terms of Purchase</strong></h4>
				<p>If you are unsatisfied with the program for any reason, a full refund will be provided if only Lesson 1 has been started and/or it has not been longer than 30 days from the date on this receipt. If lesson 2 has not been started, the course can be assigned to another person for up to 180 days for a $20 name change fee. For further assistance, please call 818-889-8799.</p>
			</div>
			<?php echo $body; ?>
		</div>

		<?php

			foreach ($_SESSION as $key => $value) {
				// Keep the session variables we need to log into the admin section.
				if($key != 'CREATED' && $key != 'LAST_ACTIVITY' && $key != 'admintable' && $key != 'menu' && $key != 'displayname')
					unset($_SESSION[$key]);
			}

			//storing user, AC,  into a session variable so we can add students later
			$_SESSION['user'] =  $AN;
			$_SESSION['AC'] =  $AC;
			$_SESSION['postpurchase'] =  1;

			include $_SERVER['DOCUMENT_ROOT'].'/shared/footer.php'

		?>
	</body>
</html>