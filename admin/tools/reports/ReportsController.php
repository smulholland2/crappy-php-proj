<?php

    include_once $_SERVER['DOCUMENT_ROOT'].'/config/connection.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/lib/Helper.php';

    class ReportsController
    {

        const FROMERROR      = "Please select a from date";
        const TOERROR        = "Please select a to date";
        const FNAMEERROR     = "Please enter the first name";
        const LNAMEERROR     = "Please enter the last name";
        const PRODUCTIDERROR = "Please select a course";
        const SUCCESMSG      = "Success";
    
        public function __construct()
        {
            if(!isset($_SESSION))
		        session_start();
            $this -> admin = $_SESSION['user'];
            $this -> CleanAdmin();
            header('Content-Type: application/json');
        }

        public function GlobalScore()
        {
            
            if(!isset($_SESSION))
		        session_start();
            $sql = "SELECT TOP [01D].[NF],[01D].[NL],[01D].[UU],[01D].[UC],[01D].[UM],[01D].[ME],[01P].[NUM],[01P].[PER]
                    FROM [newtap].[dbo].[01D]
                    INNER JOIN [newtap].[dbo].[01P]
                    ON [newtap].[dbo].[01D].[UU]=[newtap].[dbo].[01P].[UU]
                    WHERE [newtap].[dbo].[01D].[UA] = '".$_SESSION["user"]."' AND [newtap].[dbo].[01D].[ME] = ". $data["productid"];
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

            if(isset($result["error"])) {
                print_r($result["error"]);
                if(is_null($result["error"]))
                    print_r($result["error"]);
            } else {        
                $result["success"] = success_msg;
                echo json_encode($result);
            }

            return $result;
        }

        public function GlobalProgress()
        {

        }

        public function ColorCodedProgress($type)
        {

        }

        public function CoursePass()
        {

        }

        public function GetCourseList()
        {
            // Return this list to be displayed in a select on the page.
            $list = [];

            // Join the product table and the license table by the product id with the admin user as the filter.
            // Admin user is coming from session created at login.
            $sql = "SELECT [07DS2].[ProductName], [07DS2].[id], [Licenses].[LicensesRemaining] ";
            $sql .= "FROM [07DS2] ";
            $sql .= "INNER JOIN [Licenses] ";
            $sql .= "ON [07DS2].[id]=[Licenses].[ProductId] ";
            $sql .= "WHERE [Licenses].[UserId] = '" . $this -> admin . "'";
            $list = $this -> RunQuery($sql);

            return $list;
        }

        private function RunQuery($sql, $kill = 0)
        {
            $conn = Db::getInstance();

            $response = [];

            $stmt = mssql_query ( $sql , $conn );

            if( $stmt === false )
            {
                $this -> Failed(self::INVALIDQUERYEC);
            }
            else
            {
                while($row = mssql_fetch_assoc($stmt))
                {
                    array_push($response, $row);
                    if($kill == 1)
                        die(var_dump($response));
                }
            }

            if(count($response) > 1)
                return $response;
            else if(isset($response[0]))
                return $response[0];
            else
                return $response;
        }

        private function RunInsert($sql, $kill = 0)
        {
            $conn = Db::getInstance();

            $response = [];

            $stmt = mssql_query ( $sql , $conn );

            if( $stmt === false )
            {
                $this -> Failed(self::INVALIDQUERYEC);
            }
            else
            {
                return true;
            }
        }

        private function CleanAdmin()
        {
            $sanitizer = new Helper();
            $this -> cleanadmin = $sanitizer -> mssql_escape($_SESSION["user"]);
        }

        private function Validate()
        {
            //Sanitize the POST data
            $validator = new Helper();
            //Check to see if the form fields have data. They cannot be blank.
            $validated = isset($_POST["firstname"])  ? true : $this -> ValidationError("firstname",self::NOFNAME);
            $validated = isset($_POST["lastname"])   ? true : $this -> ValidationError("lastname",self::NOLNAME);
            $validated = isset($_POST["from"])  ? true : $this -> ValidationError("from",self::NOFNAME);
            $validated = isset($_POST["to"])   ? true : $this -> ValidationError("to",self::NOLNAME);
            $validated = isset($_POST["productid"])  ? true : $this -> ValidationError("productid",self::NOFNAME);
            //$validated = isset($_POST["tablecode"])  ? true : $this -> ValidationError("tablecode",self::NOFNAME);
            //$validated = isset($_POST["tablecode"])  ? true : $this -> ValidationError("tablecode",self::NOFNAME);
            //$validated = isset($_POST["tablecode"])  ? true : $this -> ValidationError("tablecode",self::NOFNAME);
            //$validated = isset($_POST["tablecode"])  ? true : $this -> ValidationError("tablecode",self::NOFNAME);
        }

        private function Sanitize()
        {
            $sanitizer = new Helper();
            $data = [];

            $data["firstname"]  = $sanitizer -> mssql_escape($this -> firstname);
            $data["lastname"]   = $sanitizer -> mssql_escape($this -> lastname);
            $data["productid"]   = $sanitizer -> mssql_escape($this -> productid);
            $data["from"]      = $sanitizer -> mssql_escape($this -> to);
            $data["to"] = $sanitizer -> mssql_escape($this -> adminemail);
            /*$data["username"]   = $sanitizer -> mssql_escape($this -> from);
            $data["tablecode"]  = $sanitizer -> mssql_escape($this -> tablecode);
            $data["coursename"] = $sanitizer -> mssql_escape($this -> coursename);
            $data["reportname"] = $sanitizer -> mssql_escape($this -> reportname);*/

            return $data;
        }

        private function ValidationError($field,$err)
        {
            array_push($this -> errfields, $field);
            array_push($this -> errmsgs, $err);
            return false;
        }
}
?>