<?php	
	// start the css directory file path.
	$jsFile = "/wwwroot/js/";

	// check for path
	if(dirname($_SERVER["PHP_SELF"]) != '\\')
		$jsFile .= ltrim(dirname($_SERVER["PHP_SELF"]),'/') . "/";
	
	// remove the .php file extension from the PHP_SELF variable by passing '' as the replacement argument.	
	$jsFile .= str_replace(".php", "", basename($_SERVER['PHP_SELF']));

	// append the .js file extension so we can echo the $jsFile variable cleanly in the script call in the footer.
	$jsFile .= ".js";
?>
<footer class="navbar-fixed-bottom">	
	<p style="text-align:center;margin-top:50px;font-size:15px">&copy;  Copyright 2016&nbsp;<b>TAPSeries.com</b>. All rights reserved.</p>
</footer>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script src="/wwwroot/lib/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="/wwwroot/js/site.js" type="text/javascript"></script>
<?php echo file_exists($_SERVER["DOCUMENT_ROOT"] . $jsFile) ? '<script src="'. $jsFile .'" type="text/javascript"></script>': ''; ?>
