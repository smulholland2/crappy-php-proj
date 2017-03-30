<?php

	include_once $_SERVER['DOCUMENT_ROOT']."/certificate/foodhandler/FoodHandlerCertController.php";
	// Login forms will POST to this page.
	// Check for the POST vars. Type and lastname are always required. Either dob or usrn are also required.
	echo "type=";
	echo $_POST["type"];
	echo "<br>";
	echo "lastname=";
	echo $_POST["lastname"];
	echo "<br>";
	echo "course=";
	echo $_POST["course"];
	echo "<br>";
	echo "dob=";
	echo $_POST["dob"];
	echo "<br>";
	if(isset($_POST["type"]) && isset($_POST["lastname"]) && isset($_POST["course"])) {		
		$cert = new FoodHandlerCertController($_POST);
		//$response = $cert -> GetResponse();
		session_start();
		if($cert -> data["completeddate"]){
		$_SESSION["cert_firstname"] = $cert -> data["firstname"];
		$_SESSION["cert_lastname"] = $_POST["lastname"];
		$_SESSION["cert_course"] = $_POST["course"];
		$_SESSION["cert_region"] = $cert -> data["region"];
		$_SESSION["cert_completeddate"] = $cert -> data["completeddate"];

		header('Location: ../cert.php');

	print_r($_SESSION);
		}
	}
	
?>