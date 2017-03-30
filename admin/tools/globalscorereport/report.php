<?php
    //include($_SERVER['DOCUMENT_ROOT']."/config/config.php");
    header('Content-Type: application/json');
    const from_error = "Please select a from date";
    const to_error = "Please select a to date";
    //const fname_error = "Please enter the first name";
    //const lname_error = "Please enter the last name";
    const productid_error = "Please select a course";
    const success_msg = "Success";

    isset($_POST["from"]) ? $from = $_POST["from"] : $result["error"]["from"] = from_error;
    isset($_POST["to"]) ? $to = $_POST["to"] : $result["error"]["to"] = to_error;
    //isset($_POST["fname"]) ? $fname = $_POST["fname"] : $result["error"]["fname"] = fname_error;
    //isset($_POST["lname"]) ? $lname = $_POST["lname"] : $result["error"]["lname"] = lname_error;
    isset($_POST["productid"]) ? $product = $_POST["productid"] : $result["error"]["productid"] = productid_error;

    !isset($result["error"]) ? $result = make_query($_POST, $user) : print_r($result["error"]);

    //echo isset($result["error"]) || !is_null($result["error"]) ? $result["error"] : $result["success"] = success_msg;
    if(isset($result["error"])) {
        print_r($result["error"]);
        if(is_null($result["error"]))
            print_r($result["error"]);
    } else {        
        $result["success"] = success_msg;
        echo json_encode($result);
    }

    function make_query($data, $user, $productid)
    {
        //QA CONNECTION CREDENTIALS
        $user = $_SERVER['DB_USERNAME'];
        $password = $_SERVER['DB_PASSWORD'];
        $server = $_SERVER['DB_HOSTNAME'];
        $database = 'newtap';

        $connectionInfo = array( "Database"=>"newtap", "UID"=>$user, "PWD"=>$password);
        $conn = sqlsrv_connect( $server, $connectionInfo);

        if( !$conn ) {
            echo "Connection could not be established.<br />";
            die( print_r( sqlsrv_errors(), true));
        }

        //$sql = "SELECT NF, NL, UU, UC, UM FROM [01D] WHERE [UA] = 'mmskip'";
        session_start();
        $sql = "SELECT TOP [01D].[NF],[01D].[NL],[01D].[UU],[01D].[UC],[01D].[UM],[01D].[ME],[01P].[NUM],[01P].[PER]
                FROM [newtap].[dbo].[01D]
                INNER JOIN [newtap].[dbo].[01P]
                ON [newtap].[dbo].[01D].[UU]=[newtap].[dbo].[01P].[UU]
                WHERE [newtap].[dbo].[01D].[UA] = '".$_SESSION["USERNAME"]."' AND [newtap].[dbo].[01D].[ME] = ". $data["productid"];
        $stmt = sqlsrv_query ( $conn , $sql );
        if( $stmt === false ) {
            die( print_r( sqlsrv_errors(), true));
        }

        $result["students"] = array();
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
             array_push($result["students"],$row);
            //echo $row['LastName'].", ".$row['FirstName']."<br />";
        }

        // Get the row fields. Field indeces start at 0 and must be retrieved in order.
        // Retrieving row fields by name is not supported by sqlsrv_get_field.
        //$result["fname"] = sqlsrv_get_field( $stmt, 0);

        //$result["lname"] = sqlsrv_get_field( $stmt, 1);

        return $result;
    }

?>