<?php

	include_once $_SERVER['DOCUMENT_ROOT']."/certificate/CertificateController.php";
	
	const TABLE = "FoodHandlerLookUp";
	// Lookup the course title.
	if(isset($_POST["id"])) {		
		$cert = new CertificateController($_POST["id"]);
		//$sanitizer = new Helper();
		//$id = $sanitizer -> mssql_escape($_POST["id"]);
		echo $cert -> GetCourseTitle(TABLE, $_POST["id"]);
	}
?>