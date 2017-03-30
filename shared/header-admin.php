<?php
	error_reporting(0);
	if(!isset($_SESSION))
		session_start();
	
	if (!isset($_SESSION['CREATED'])) {
    	$_SESSION['CREATED'] = time();
	} else if (time() - $_SESSION['CREATED'] > 1200) {
    	// session started more than 20 minutes ago
    	session_regenerate_id(true);    // change session ID for the current session and invalidate old session ID
    	$_SESSION['CREATED'] = time();  // update creation time
	}

	if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1200)) {
    	// last request was more than 20 minutes ago
    	session_unset();     // unset $_SESSION variable for the run-time 
    	session_destroy();   // destroy session data in storage
	}

	$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

	// Redirect logged in users.
    if(isset($_SESSION['user']) && $_SERVER["PHP_SELF"] == '/account/login.php')
        header("Location:" . $_SESSION['menu']);
	// Allow license key additions to access single student add page.
	else if(isset($_SESSION['Serial']['Start']))
	{
		unset($_SESSION['Serial']['Start']);
		header("Location:/admin/tools/students/single");
	}		
	else if(!isset($_SESSION['user']))
		header("Location:/account/login");


	// Start the css directory file path.
	$cssFile = "/wwwroot/css/";

	// Check for path
	if(dirname($_SERVER["PHP_SELF"]) != '\\') {
		$cssFile .= ltrim(dirname($_SERVER["PHP_SELF"]),'/') . "/";
	}

	// Remove the .php file extension from the PHP_SELF variable by passing '' as the replacement argument.
	$cssFile .= str_replace(".php", "", basename($_SERVER['PHP_SELF']));

	// Append the .css file extension so we can echo the $cssFile variable cleanly in the link call in the header.
	$cssFile .= ".css";

	/*function getUserIP()
	{
		$client  = @$_SERVER['HTTP_CLIENT_IP'];
		$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
		$remote  = $_SERVER['REMOTE_ADDR'];

		if(filter_var($client, FILTER_VALIDATE_IP))
		{
			$ip = $client;
		}
		elseif(filter_var($forward, FILTER_VALIDATE_IP))
		{
			$ip = $forward;
		}
		else
		{
			$ip = $remote;
		}

		return $ip;
	}


	$user_ip = getUserIP();
	if($user_ip == '108.185.164.176')
		echo "Valid TAP IP.";
	else
		header('Location: http://maintenance.tapseries.com');*/

?>
<!DOCTYPE html>
<html>
<head>
	<title>Food Safety Training | TAP Series</title>  
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="/favicon.ico?v=1" type="image/x-icon">
	<link rel="shortcut icon" href="/favicon.ico?v=1" type="image/x-icon" />
  	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans" />
	<link rel="stylesheet" type="text/css" href="/wwwroot/lib/bootstrap-datepicker/css/bootstrap-datepicker3.min.css">
  	<link rel="stylesheet" type="text/css" href="/wwwroot/css/styles.css">
	<?php echo file_exists($_SERVER["DOCUMENT_ROOT"] . $cssFile) ? '<link rel="stylesheet" type="text/css" href="'.$cssFile.'" ?>': ''; ?>
	<!-- Google Analytics Tracking Code -->
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-90442747-1', 'auto');
		ga('send', 'pageview');
	</script>	
	<!-- Hotjar Tracking Code for http://www.tapseries.com -->
	<script>
		(function(h,o,t,j,a,r){
			h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
			h._hjSettings={hjid:445735,hjsv:5};
			a=o.getElementsByTagName('head')[0];
			r=o.createElement('script');r.async=1;
			r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
			a.appendChild(r);
		})(window,document,'//static.hotjar.com/c/hotjar-','.js?sv=');
	</script>		
</head>
<body>
<!-- Freshdesk Support Widget -->
<script type="text/javascript" src="http://assets.freshdesk.com/widget/freshwidget.js"></script>
<script type="text/javascript">
	FreshWidget.init("", {"queryString": "&widgetType=popup&submitTitle=Send", "utf8": "✓", "widgetType": "popup", "buttonType": "text", "buttonText": "Need Help?", "buttonColor": "white", "buttonBg": "#F72A00", "alignment": "2", "offset": "200px", "formHeight": "500px", "url": "https://tapseries.freshdesk.com"} );
</script>
<?php include 'menu.php';?>