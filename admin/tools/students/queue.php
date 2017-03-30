<?php

    /*session_start();
    if(!isset($_SESSION["queued"]))
        header("Location:/admin/tools/students/multiple");*/
    
    ob_start();
    header('Content-Type: application/json');

    include_once $_SERVER['DOCUMENT_ROOT'].'/admin/tools/students/StudentsController.php';

    const USERNAMEEC   = "1";
    const FIRSTNAMEC   = "2";
    const LASTNAMEC    = "3";
    const PASSWORDEC   = "4";
    const EMAILEC      = "5";
    const ADMINEMAILEC = "6";
    const LANGEC       = "7";
    const DOBEC        = "8";

    const USERNAMEERROR   = "User name is required";
    const FIRSTNAMEERROR  = "First name is required";
    const LASTNAMEERROR   = "Last name is required";
    const PASSWORDERROR   = "Password is required";
    const EMAILERROR      = "Email is required";
    const ADMINEMAILERROR = "Admin email is required";
    const LANGERROR       = "Language is required";
    const DOBERROR        = "Language is required";

    const SUCCESS         = "Success";
    const FAILURE         = "Failure";

    $errors = [];
    array_push($errors,isset($_POST["firstname"])  ? 0 : FIRSTNAMEC);
    array_push($errors,isset($_POST["lastname"])   ? 0 : LASTNAMEC);
    array_push($errors,isset($_POST["username"])   ? 0 : USERNAMEEC);
    array_push($errors,isset($_POST["password"])   ? 0 : PASSWORDEC);
    array_push($errors,isset($_POST["email"])      ? 0 : EMAILEC);
    array_push($errors,isset($_POST["adminemail"]) ? 0 : ADMINEMAILEC);
    array_push($errors,isset($_POST["lang"])       ? 0 : LANGEC);
    
    // Check for table 01D before requiring the DOB field.
    array_push($errors,isset($_POST["dob"])        ? 0 : LANGEC);

    $error = false;
    for($i = 0; $i < count($errors); $i++)
    {
        if($errors[$i] < 0)
            $error = true;
    }
    
    $queue = new StudentsController();
    $response = $queue -> AddMultiple();    

    if($response == FAILURE)
    {
        ob_end_clean();
        echo json_encode($_SESSION['studentErrors'][0]);
        exit();
    }
    if($response == SUCCESS)
    {
        $response = str_replace(array('.', ' ', "\n", "\t", "\r"), '', $response);
        ob_end_clean();
        echo json_encode($response);
        exit();
    }
    else
    {
        ob_end_clean();
        echo json_encode($response);
        /*header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: application/json; charset=UTF-8');
        print_r(json_encode(array('message' => 'ERROR', 'code' => 1337)));*/
    }

    function hexDecode($hex) 
    {
        $str = '';
        for($i=0;$i<strlen($hex);$i+=2) $str .= chr(hexdec(substr($hex,$i,2)));
        return $str;
    }

?>