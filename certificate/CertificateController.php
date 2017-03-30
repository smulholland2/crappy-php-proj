<?php
    include_once $_SERVER['DOCUMENT_ROOT']."/lib/Helper.php";
    include_once $_SERVER['DOCUMENT_ROOT']."/config/config.php";

    class CertificateController
    {
        // Form types.
        const DOBTYPE         = "dob";
        const USERNTYPE       = "usern";

        // Error codes for reporting various errors.
        const INVALIDEC       = 1;
        const IDLOOKUPEC      = 2;
        const INVALIDTYPEEC   = 3;
        const INVALIDCOURSEEC = 4;
        const INVALIDDOBEC    = 5;
        const INVALIDUSEREC   = 6;
        const INVALIDLNAMEEC  = 7;
        const INVALIDQUERYEC  = 8;
        const INVALIDPRODUCTEC= 9;

        // Error messages for reporting various errors.
        const INVALIDM        = "";
        const IDLOOKUPM       = "";
        const INVALIDTYPEM    = "";
        const INVALIDCOURSEM  = "";
        const INVALIDDOBM     = "";
        const INVALIDUSERM    = "";
        const INVALIDLNAMEM   = "";
        const INVALIDQUERYM   = "";
        const INVALIDPRODUCTM = "";
        const INVALIDLOGIN    = "The user could not be found for this course.";

        // Class properties.
        public $validated     = false;
        public $data          = [];
        public $response      = "OK";
        public $formerr       = "None";
        public $course        = null;
        public $productname   = null;
        public $conn          = null;
        public $user          = null;
        public $validdob      = false;
        public $validusern    = false;
        public $userlist      = []; 
        public $certdata      = [];
        public $passdate      = null;
        public $table         = null;
        public $coursenum     = null;

        // Class methods.
        public function GetCert($_table)
        {
            // Set the primary certificate table.
            $this -> table = $_table;
            // Validate the student credentials.
            $this -> CertLogin();
            // Get the rest of the students data. 
            $this -> LoadCertData();
            // Create the PDF using student's data.
            $this -> MakePDF();
        }

        public function CertLogin()
        {
            // Get the username, first name, last name and course code from the initial query.
            if(isset($this -> data["dob"]))
                // If the dob is given, we will have to lookup the user name.
                $sql = "SELECT [UU],[NF],[NL],[ME] FROM [". $this -> table ."] WHERE [NL] = " . $this -> data["lastname"] ." AND [ME] = " . $this -> data["course"];
            else
                // Username given, just find the matching record.
                $sql = "SELECT [UU],[NF],[NL],[ME] FROM [". $this -> table ."] WHERE [NL] = " . $this -> data["lastname"] . " AND [UU] = " . $this -> data["usern"];            

            // Add the resulting response to an array.
            $this -> userlist = $this -> RunQuery($sql);
            
            // IF the array is empty, the user wasn't found. Fail with error.
            $this -> userlist ? true : $this -> Failed(self::INVALIDLOGIN);
            
            // If the dob is given, there will probably be multiple records with matching last names.
            if(isset($this -> data["dob"]) && count($this -> userlist) > 1)
            {
                for($i = 0; $i < count($this -> userlist); $i++)
                {   
                    // Look through each record and match a lastname to a birthday. 
                    $this -> ValidateDob($this -> userlist[$i]["UU"], $i);
                }
                // Once we find a matching dob, lookup the course name. Fail on no match.
                $this -> validdob ? $this -> LocateCourse() : $this -> Failed(self::INVALIDDOBEC);
            }
            else
            {
                // Username is a unique field.
                // The array will only have one record when a username and lastname are given.
                // Set instance properties with records from array.
                $this -> data["user"] = $this -> userlist[0]["UU"];
                $this -> data["firstname"] = $this -> userlist[0]["NF"];
                $this -> data["coursenum"] = $this -> userlist[0]["ME"];

                // Make sure they are trying to access the right course.
                $this -> LocateCourse();
            }
        }

        public function ValidateDob($_username, $recordnum)
        {
            // Lookup the birthday based on user name
            $sql = "SELECT [BD] FROM [01C] WHERE [UU] = '" . $_username . "'";
            $rows = $this -> RunQuery($sql);

            // Create a valid date from the form input string.
            $input_date = date_create($this -> data["dob"]);

            // There may be multiple users with identical last names and dobs
            // so we have to collect them all and give the user choices later.
            if(count($rows) > 1)
            {
                for($i = 0; $i < count($rows); $i++)
                {
                    // Create a valid date from the record string.
                    $db_date = date_create($rows[$i]["BD"]);

                    // This will evaluate as true when the date from the form matches a date from the db.
                    if(date_format($input_date,"Y-m-d") == date_format($db_date,"Y-m-d"))
                    {
                        die(var_dump($rows));
                        // Store the user's certificate data in the data array.
                        // This will be used to print onto the PDF.
                        $this -> data["user"] = $_username;
                        $this -> data["firstname"] = $this -> userlist[$recordnum]["NF"];
                        $this -> data["coursenum"] = $this -> userlist[$recordnum]["ME"];
                        $this -> validdob = "true";
                    }
                }
            }
            else
            {
                $db_date = date_create($rows[0]["BD"]);
                if(date_format($input_date,"Y-m-d") == date_format($db_date,"Y-m-d"))
                {
                    die(var_dump($rows));
                    $this -> data["user"] = $_username;
                    $this -> data["firstname"] = $this -> userlist[$recordnum]["NF"];
                    $this -> data["coursenum"] = $this -> userlist[$recordnum]["ME"];
                    $this -> validdob = "true";
                }
            }
        }

        public function ValidateUsern($_username, $_lastname)
        {
            $this -> user = $this -> data["usern"];
            $sql = "SELECT [UU],[NF] FROM [01D] WHERE [NL] = " . $this -> data["lastname"] . "AND [UU] = ". $this -> user;
            $validuser = $this -> RunQuery($sql);
            $validuser ? true : $this -> Failed(self::INVALIDLOGIN);
        }

        public function LocateCourse()
        {
            // We need to match the form up to the course a user is registered to.
            $sql = "SELECT [ProductName] FROM [07DS2] WHERE [JobType] = '" . $this -> data["coursenum"] . "'";

            $course = $this -> RunQuery($sql);

            $this -> data["course"] = $course[0]["ProductName"];
            
            // If the form the user came in from does not match the course they are registered to, 
            // fail the login attempt. The UI will offer the user a sugjestion for the correct course.
            return $this -> data["course"];// == $this -> data["productname"] ? true : $this -> Failed(self::INVALIDPRODUCTEC);
        }

        public function LoadCertData()
        {
            // This is the rest of the data needed to print the PDF
            $sql = "SELECT [DE], [REGION] FROM [". $this -> table ."] WHERE [UU] = '" . $this -> data["user"] . "'";

            $certdata = $this -> RunQuery($sql);

            // Find and store the date the course was completed.
            $this -> data["completeddate"] = date_format(date_create($certdata[0]["DE"]), "Y-m-d");

            // Find and store the region.
            $this -> data["region"] = $certdata[0]["REGION"];
        }

        public function GetProductName()
        {            
            $sql = "SELECT [ProductName] FROM [07DS2] WHERE [ProId] = '" . $this -> data["coursenum"] . "'";
            $proname = $this -> RunQuery($sql);
            if(count($proname) == 0)
                $this -> data["productname"] = $this -> course;
            else
                $this -> data["productname"] = $proname;
        }

        public function GetCourseTitle($_table, $_course = null)
        {
            $conn = mssql_connect($_SERVER['DB_HOSTNAME'], $_SERVER['DB_USERNAME'], $_SERVER['DB_PASSWORD']);
            mssql_select_db("newtap", $conn);

            $this -> table = $_table;
            $course = isset($this -> data['course']) ? $this -> data['course'] : $_course;
            $sql = "SELECT [CourseTitle] FROM [" . $_table . "] WHERE [CourseId] = " . $course;
            $stmt = mssql_query ( $sql , $conn );
            if( $stmt === false ) {
                $this -> Failed(self::IDLOOKUPEC);
            } else {
                $result = mssql_fetch_row($stmt);
                if(isset($this -> data["course"]))
                    $this -> course = $result[0];
                else
                    echo $this -> course = $result[0];
            }
        }

        public function NameChangeRequest()
        {
            return true;
        }

        public function RunQuery($sql)
        {
            $conn = mssql_connect($_SERVER['DB_HOSTNAME'], $_SERVER['DB_USERNAME'], $_SERVER['DB_PASSWORD']);
            mssql_select_db("newtap", $conn);

            $response["rows"] = [];
            $stmt = mssql_query ( $sql , $conn );
            if( $stmt === false ) {
                $this -> Failed(self::INVALIDQUERYEC);
            } else {
                while( $row = mssql_fetch_assoc($stmt) ) {                    
                    $response["rows"] > 1 ? array_push($response["rows"], $row) : false;
                }
                return $response["rows"];
            }
        }

        public function MakePDF()
        {
            //var_dump($this -> data);
        }

        // Helpers //

        public function Validate($_data)
        {
            $validator = new Helper();
            preg_match($validator::LETTERONLY, $_data["type"]) ? false : $this -> Failed(self::INVALIDTYPE);
            preg_match($validator::LETTERONLY, $_data["lastname"]) ? false : $this -> Failed(self::INVALIDLNAMEEC);
            preg_match($validator::NUMBERONLY, $_data["course"]) ? false : $this -> Failed(self::INVALIDCOURSE);
            if(isset($_data["dob"]))
                preg_match($validator::DATEREGEX2, $_data["dob"]) ? false : $this -> Failed(self::INVALIDDOB);
            else
                preg_match($validator::LETNUMREGEX, $_data["usern"]) ? false : $this -> Failed(self::INVALIDUSER);            
        }

        public function Clean($_data)
        {
            $sanitizer = new Helper();
            $this -> data["type"] = $sanitizer -> mssql_escape($_data["type"]);
            $this -> data["lastname"] = $sanitizer -> mssql_escape($_data["lastname"]);
            $this -> data["dob"] = $_data["dob"];
            $this -> data["course"] = $sanitizer -> mssql_escape($_data["course"]);
        }

        public function Failed($_failcode)
        {
            switch($_failcode) {                
                case 1:
                   throw new Exception();
                case 2:
                   throw new Exception();
                case 3:
                   throw new Exception();
                case 4:
                   throw new Exception();
                case 5:
                   throw new Exception();
                case 6:
                   throw new Exception();
                case 7:
                   throw new Exception();
                case 8:
                   throw new Exception(mssql_get_last_message());
                default:
                   throw new Exception();
            }
        }

        public function GetResponse()
        {
            return $this -> response;
        }
    }
?>