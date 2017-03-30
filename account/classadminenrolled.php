<?php
    //include $_SERVER['DOCUMENT_ROOT'].'/account/LoginController.php';
    
    const TABLE = "07L3";    
    const ADMIN_MENU = "/admin/companyaccount/main_menu";

    //QA CONNECTION CREDENTIALS
    $user = $_SERVER['DB_USERNAME'];
    $password = $_SERVER['DB_PASSWORD'];
    $server = $_SERVER['DB_HOSTNAME'];
    $database = 'newtap';

    $connectionInfo = array( "Database"=>"newtap", "UID"=>$user, "PWD"=>$password);
    $conn = mssql_connect( $server, $connectionInfo);

    if( !$conn ) {
        echo "Connection could not be established.<br />";
        //die( print_r( mssql_errors(), true));
    }
    
    //Check username
    $sql = "SELECT [UU] FROM [". $table ."] WHERE [UU] = " . $_POST["username"];
    $stmt = mssql_query ( $conn , $sql );
    if( $stmt === false ) {
        die("User does not exist.");
    } else {
        // Check password
        $sql = "SELECT [UU] FROM [". $table ."] WHERE [UU] = " . $_POST["username"] . " AND [UC] = " . $_POST["password"];
        $stmt = mssql_query ( $conn , $sql );
        if( $stmt === false ) {
            // Log invalid login attempts.
            $sql = "SELECT [UU] FROM [". $table ."] WHERE [UU] = " . $_POST["username"] . " AND [UC] = " . $_POST["password"];
            $stmt = mssql_query ( $conn , $sql );
            die("Incorrect Password");
        }
    }
        //SEE IF USER IS LOGGED IN ALREADY
        $sql = "SELECT [Active] FROM [AuthenticatedUsers] WHERE [UserName] = " . $_POST["username"];
        $stmt = mssql_query ( $conn , $sql );
        if( $stmt === false ) {
            $sql = "SELECT [UU] FROM [". $table ."] WHERE [UU] = " . $_POST["username"] . " AND [UC] = " . $_POST["password"];
            $stmt = mssql_query ( $conn , $sql );
        }
    }

    if( mssql_fetch( $stmt ) === false) {
        die( print_r( mssql_errors(), true));
    }

    // Get the row fields. Field indeces start at 0 and must be retrieved in order.
    // Retrieving row fields by name is not supported by mssql_get_field.
    $name = mssql_get_field( $stmt, 0);
    session_start();
    $_SESSION["USERNAME"] = $name;
    header("Location: {$menu}");
?>