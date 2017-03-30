<?php

    include_once $_SERVER['DOCUMENT_ROOT']."/config/connection.php";
    include_once $_SERVER['DOCUMENT_ROOT']."/lib/Helper.php";
    include_once $_SERVER['DOCUMENT_ROOT']."/config/config.php";
    include_once $_SERVER['DOCUMENT_ROOT']."/training/SerialNumberController.php";

    class TrainingController
    {
        const MAXTABLES  = 13;
        const COURSEHOST = "http://tapseries-assets.s3-website-us-east-1.amazonaws.com/";
        const SHELL      = "/shell.html";
        const KEYPREFIX  = "LK";

        private $username = null;
        private $data = [];

        public function __construct()
        {
            /*if(!isset($_SESSION))
                if(isset($_SESSION['Serial']))
                    unset($_SESSION['Serial']);*/
        }

        public function Login($username)
        {
            $this -> Validate($this -> user = $username);
			// We will store the user name and errors in session so start it here.
			if(!isset($_SESSION))
                session_start();
            if(substr(strtoupper($username), 0, 2) == self::KEYPREFIX)
            {
                // First check to see if this is an unsed liscense key.
                $serial = new SerialNumberController();            
                $serialAccount = $serial -> LookupKey($username);

               

                if(isset($serialAccount['errors']))
                {
                    // Invalid license key. Return the error.
                    $_SESSION["errors"] = $serialAccount['errors'];
                }
                else if(isset($serialAccount))
                    $this -> user = $serialAccount;
                else
                    $this -> user = $serial -> AddNewStudent($username);
            }

            $userfound = false;
            $tables = [];
            $exclude = array(7, 8);

            // Search through tables to find the correct course.
           
            for ($i = 1; $i < self::MAXTABLES; $i++) {
                if (in_array($i, $exclude)) continue;  // Skip tables 7 and 8 because they do not contain course users.
                // Prepend a 0 to the table counter if its less than 9.
                $table = $i < 10 ? "[0" . $i . "D]" : "[" . $i . "D]";
                $registered = $this -> FindUser($table, $i);
                // Load the data array.
                $registered ? $this -> CreateData($table) : false;
            }            
            
            // If the user does not appear in any course table, send back to login page.
            if (count($this -> data) == 0) {
                $_SESSION["errors"] = 1;
                //header("Location:/training");
            } else if(count($this -> data)  > 1) {
                // If there are more than one courses the user is registered for
                // let the user choose which course to go to.                
                $_SESSION["courses"] = $this -> data;
                //die(var_dump($_SESSION["courses"]));
                //header("Location:/training");
            } else {
                // The user is regestered for just one course. Redirect
                //  $_SESSION["link"]=  $this -> data[0]["link"];
                //header("Location: /training/course/". $this -> data[0]["link"] . "/" . $_POST['username']);
                header("Location: " . self::COURSEHOST . $this -> data[0]["link"] . self::SHELL . "?u=".$_POST['username']); 
            }
        }

        private function CreateData($table)
        {
            $tempdata = [];
            switch ($table) {
                case '[01D]':
                    $handlerdata = $this -> GetHandlerData();
                    if($handlerdata)
                    {
                        $coursedata = $this -> GetCourseData($table, $handlerdata["ME"], $handlerdata["REGION"]);
                        $accountdata = $this -> GetAccountData($handlerdata["UA"]);
                        $_SESSION["ad"]=  $accountdata;
                        $corpdata = $this -> GetCorpData($handlerdata["UA"]);
                        $_SESSION["cd"]=  $corpdata;

                        if($corpdata) {
                            $tempdata = array_merge($handlerdata, $coursedata, $accountdata, $corpdata);
                        } else {
                            $tempdata = array_merge($handlerdata, $coursedata, $accountdata);
                        }

                        $tempdata["title"] = $tempdata["ProductName"];

                        if($corpdata["FlashEnabled"] == 1 || $accountdata["FlashEnabled"] == 1)
                        {
                            //Some accounts are forced to get flash version
                            if($corpdata["FlashEnabled"] == 1)
                                $tempdata["link"] = $tempdata["FCourseLink"];
                            else if($accountdata["FlashEnabled"] == 1)
                                $tempdata["link"] = $tempdata["FCourseLink"];
                        } 
                        else
                        {
                            if($tempdata["VER"] == "FS6H" || $tempdata["VER"] == "FS85" || $tempdata["VER"] == "FS8" || $tempdata["VER"] == "FS6") {
                                $tempdata["link"] =  $tempdata["FCourseLink"]; //Flash link
                            } else {
                                $tempdata["link"] = $tempdata["CourseLink"]; //Normal link
                                //die ($tempdata["Courselink"]);
                            }
                            if(is_null($tempdata["VER"])) {
                                $tempdata["link"] = $tempdata["CourseLink"]; //Normal link
                            }
                            if($tempdata["ES"] == "SPANISH") {
                                $tempdata["link"] =  $tempdata["SCourseLink"]; //Spanish link
                            }
                            if($tempdata["ES"] == "MANDARI") {  //Mandarin language gets flash
                                $tempdata["link"] =  $tempdata["FCourseLink"];
                            }
                            if($tempdata["ME"] == 13) { //Special case for West Virginia Food Handler
                                if($tempdata["REGION"] == "WVMV" || $tempdata["REGION"] == "WVPE") {
                                    $tempdata["link"] =  "fshlong";
                                } else {
                                    $tempdata["link"] =  "demofull";
                                }
                            }
                        }

                        $_SESSION["td"]=  $tempdata;
                        unset($tempdata["ME"]);
                        unset($tempdata["VER"]);
                        unset($tempdata["ES"]);
                        unset($tempdata["REGION"]);
                        unset($tempdata["ProductName"]);
                    }
                    break;
                case '[02D]':
                    $recertdata = $this -> GetRecertData();
                    if($recertdata)
                    {
                        $coursedata = $this -> GetCourseData($table, $recertdata["IL"]);
                        $tempdata = array_merge($recertdata, $coursedata);
                        $tempdata["title"] = $tempdata["ProductName"];
                         if($tempdata["IL"] == 23) {
                            $tempdata["link"] =  "rewi"; //Flash link
                        } else {

                            $tempdata["link"] = "re"; //Normal link
                        }
                        unset($tempdata["IL"]);
                        unset($tempdata["VER"]);
                        unset($tempdata["ProductName"]);
                    }
                    break;
                case '[03D]':
                    $cbcfdata = $this -> GetCBCFData();

                    if($cbcfdata)
                    {
                        $coursedata = $this -> GetCourseData($table);
                        $tempdata["title"] = $tempdata["ProductName"];
                         if($cbcfdata["CF"]) {
                            $tempdata["link"] =  "cf6"; //Flash link
                        } else {
                            $tempdata["link"] = "cb6"; //Normal link
                        }
                        unset($tempdata["IL"]);
                        unset($tempdata["VER"]);
                        unset($tempdata["ProductName"]);
                    }
                    break;
                default:
                    $tempdata = $this -> GetCourseData($table);
                    if($tempdata)
                    {
                        $tempdata["title"] = $tempdata["ProductName"];
                        $tempdata["link"] = strtolower($tempdata["CourseLink"]);
                        unset($tempdata["CourseLink"]);
                        unset($tempdata["ProductName"]);
                    }
                    break;
            }

            count($tempdata) > 0 ? array_push($this -> data, $tempdata) : false;
        }

        private function FindUser($table)
        {
            $sql   = "SELECT [UU] FROM " . $table . " WHERE [UU] = " . $this -> user ;
            $found = $this -> RunQuery($sql);
            return $found;
        }

        // Food Safety Handler & Manager
        private function GetHandlerData()
        {
            $sql = "SELECT [ME],[VER],[ES],[REGION],[UA] FROM [01D] WHERE [UU] = " . $this -> user ;   
            return $this -> RunQuery($sql);
        }

        // Food Safety ReCertification
        private function GetRecertData()
        {
            $sql = "SELECT [IL],[VER] FROM [02D] WHERE [UU] = " . $this -> user ;   
            return $this -> RunQuery($sql);
        }

        private function GetCBCFData()
        {
            $sql = "SELECT [CF] FROM [03D] WHERE [UU] = " . $this -> user ;   
            return $this -> RunQuery($sql);
        }

 //get student's account info
        private function GetAccountData($accountname)
        {
            $sql = "SELECT FlashEnabled FROM [07L3] WHERE [AN] = '" . $accountname . "'";  
             $_SESSION["sql"]=  $_SESSION["sql"] .  $sql;    
            return $this -> RunQuery($sql);
        }

        //get student's corporate admin info
        private function GetCorpData($accountname)
        {
            $sql = "SELECT FlashEnabled FROM [07L2] WHERE uu = (SELECT UU FROM [07L2] WHERE UU=(SELECT SUB FROM [07L2] WHERE ID=(SELECT CA FROM [07L3] WHERE AN='" . $accountname ."')))"; 
             $_SESSION["sql"]=  $_SESSION["sql"] .  $sql;    
            return $this -> RunQuery($sql);
        }

        private function GetCourseData($table, $jobtype = null, $region = null)
        {
           $braces = array('[', ']');
            $table  = str_replace($braces, "", $table);
            if(isset($jobtype)) {
                echo $table;
                if($region=="CASD"){ // special case for San Diego, still has jobtype=3
                  $sql    = "SELECT [ProductName],[CourseLink],[FCourseLink],[SCourseLink] FROM [07DS2] WHERE [ProID] = 'casd'";
                } else if ($table=="02D") {
                   $sql    = "SELECT [ProductName],[CourseLink],[FCourseLink],[SCourseLink] FROM [07DS2] WHERE [TableCode] = '" . $table . "' AND [StuType] = " . $jobtype;
                } else {
                  $sql    = "SELECT [ProductName],[CourseLink],[FCourseLink],[SCourseLink] FROM [07DS2] WHERE [TableCode] = '" . $table . "' AND [JobType] = " . $jobtype;
                }
            } else {
                $sql    = "SELECT [ProductName],[CourseLink],[FCourseLink],[SCourseLink] FROM [07DS2] WHERE [TableCode] = '" . $table . "'";
            }
             $_SESSION["sql"]=  $_SESSION["sql"] .  $sql;    
            return $this -> RunQuery($sql);
        }

        private function RunQuery($sql)
        {
            $conn = Db::getInstance();
            $response = [];
            $stmt = mssql_query ( $sql , $conn );
            if( $stmt === false ) {
                //$this -> Failed(self::INVALIDQUERYEC);
            } else {
                $row = mssql_fetch_assoc($stmt);
                return $row ? $row : false;
            }
        }

        private function Validate()
        {
            $sanitizer = new Helper();

            // If a student's user name is all numbers with no letters,
            // it will not be converted into a hexadeciaml value.
            // This will cause a problem with the SQL used to login.
            // We use a regular expression to test for number only logins,
            // and wrap those logins in quotes. Other logins are converted to hex.
            if(preg_match($sanitizer::NUMBERONLY, $this -> user))
                $this -> user = "'" . $this -> user . "'";
            else
                $this -> user = $sanitizer -> mssql_escape($this -> user);
        }
    }

?>