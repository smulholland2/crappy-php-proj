<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/config/connection.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/lib/Mailer.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/lib/Helper.php';

class LoginController
{
    /* CONSTANTS FOR LOGIN MESSAGES */
    const SUCCESSFULLOGINCODE    = 0;
    const INVALIDUSERNAMECODE    = 1;
    const INVALIDPASSWORDCODE    = 2;
    const USERISLOCKEDOUTCODE    = 3;
    const CONNECTIONFAILEDCODE   = 4;

    const MAXFAILEDLOGINATTEMPTS = 5;

    const RESETLINK              = "http://www.tapseries.com/account/newpass?action=reset";
    const FORGOTPASSSUB          = "Your password reset link from TAP Series.";
    const REQFIELDSERR           = 1;
    const FORGOTPASSUSER         = "info@tapseries.com";
    const FORGOTPASSPASS         = "Training0nline!";
    const FSTABLE                = "01D";
    const ADMINTABLE             = "07";
    const COMPANYTABLE           = "07O6";
    const MULTITABLE             = "07L2";
    const INSTRUCTTABLE          = "07SL4";
    const COMPANYLOGIN           = "07L3";
    const DOBTABLE               = "dob";

    const INSTRUCTORDISPLAYTYPE  = 0;
    const COMPANYDISPLAYTYPE     = 1;
    const MULTIUNITDISPLAYTYPE   = 2;
    const REGIONDISPLAYTYPE      = 3;


    private $resetLink           = null;
    private $conn                = false;
    private $locked              = false;
    private $loggedin            = false;

    private $username            = null;
    private $password            = null;
    private $rawuser             = null;
    private $companyfk           = null;

    function __construct($logout = null)
    {
        // Check to see is this is a logout attempt.
        if(isset($logout))
            $this -> logout();

        if(isset($_SESSION))
        {
            unsset($_SESSION["user"]);
            unsset($_SESSION["displayname"]);
            unsset($_SESSION["admintable"]);
            unsset($_SESSION["menu"]);
            unsset($_SESSION["enrollment"]);
        }

        $headers = apache_request_headers();
        $this -> resetLink = 'http://www.tapseries.com/account/newpass?action=reset';
    }

    public function instructor($table, $menu, $enrollment)
    {
        $configured = $this -> Configure();
        
        if(!isset($configured))
        {            
            session_start();
            $_SESSION["error"] = true;
            header("Location:/account/login");
            exit();
        }
        else 
        {
            // Check password
            $sql = "SELECT [IU],[VC] FROM [". TABLE ."] WHERE [IU] = " . $this -> username . " AND [IC] = " . $this -> password;
            $stmt = mssql_query ( $sql , $this -> conn );
            $row = mssql_fetch_assoc($stmt);            
            if(!isset($row['IU']))
            {
                // Failed to log in. Log invalid login attempts.
                //$sql = "INSERT INTO [LoginFailed] ('username','timestamp') VALUES ('" . $this -> username . "', '". date("Y-m-d H:i:s") . "')";
                //$stmt = sqlsrv_query ( $conn , $sql );

                // Check to see if user is or should be locked out.
                //$this -> lockedout($username);
                //$this -> locked ? header("Location:login.php?result=" . self::INVALIDPASSWORDCODE) : header("Location:login.php?result=" . self::USERISLOCKEDOUTCODE);

                session_start();
                $_SESSION["error"] = true;
                header("Location:/account/login");
                exit();
            } 
            else 
            {
                //Login successful. Store user in session and procede to menu.
                $this -> companyfk = $row['VC'];
                $displayname = $this -> DisplayName(self::INSTRUCTORDISPLAYTYPE, $this -> companyfk);

                session_start();
                session_regenerate_id(true);
                $_SESSION["user"] = $row['IU'];
                $_SESSION["displayname"] = $displayname['NC'];
                $_SESSION["admintable"] = $table;
                $_SESSION["menu"] = $menu;
                $_SESSION["enrollment"] = $enrollment;
                header("Location:" . $menu);
                exit();
            }
        }
    }
    
    public function company($table, $menu, $enrollment)
    {
        $configured = $this -> Configure();
        
        if(!isset($configured))
        {            
            session_start();
            $_SESSION["error"] = true;
            header("Location:/account/login");
            exit();
        }
        
        //Check username
        $sql = "SELECT [AN] FROM [". $table ."] WHERE [AN] = " . $this -> username;
        $founduser = $this -> RunQuery($sql);
        
        if( count($founduser) != 1 ) 
        {
            session_start();
            $_SESSION["error"] = true;            
            header("Location:/account/login");
            exit();
        } 
        else 
        {
            // Check password
            $sql = "SELECT [AN] FROM [". $table ."] WHERE [AN] = " . $this -> username . " AND [AC] = " . $this -> password;
            $matchedpass = $this -> RunQuery($sql);
            $this -> companyfk = $matchedpass['AN'];
            if($matchedpass == false) 
            {
                // Failed to log in. Log invalid login attempts.
                //$sql = "INSERT INTO [LoginFailed] ('username','timestamp') VALUES ('" . $this -> username . "', '". date("Y-m-d H:i:s") . "')";
                //$stmt = sqlsrv_query ( $conn , $sql );

                // Check to see if user is or should be locked out.
                //$this -> lockedout($username);
                //$this -> locked ? header("Location:login.php?result=" . self::INVALIDPASSWORDCODE) : header("Location:login.php?result=" . self::USERISLOCKEDOUTCODE);
                session_start();
                $_SESSION["error"] = true;
                header("Location:/account/login");
                exit();
            } 
            else 
            {
                //Login successful. Store user in session and procede to menu.

                $displayname = $this -> DisplayName(self::COMPANYDISPLAYTYPE, $this -> companyfk);

                //die(self::COMPANYDISPLAYTYPE . " - " . $this -> companyfk);

                session_start();
                session_regenerate_id(true);
                $_SESSION["user"] = $founduser['AN'];
                $_SESSION["displayname"] = $displayname['NCPY'];
                $_SESSION["admintable"] = $table;
                $_SESSION["enrollment"] = $enrollment;
                $_SESSION["menu"] = $menu;
                header("Location:" . $menu);
                exit();
            }
        }
    }

    public function multi_unit($table, $menu)
    {
        $configured = $this -> Configure();
        
        if(!isset($configured))
        {            
            session_start();
            $_SESSION["error"] = true;
            header("Location:/account/login");
            exit();
        }

        //Check username
        $sql = "SELECT [UU],[SUB] FROM [". $table ."] WHERE [UU] = " . $this -> username;
        $founduser = $this -> RunQuery($sql);

        if( !$founduser || $founduser['UU'] != $founduser['SUB']) 
        {
            session_start();
            $_SESSION["error"] = true;            
            header("Location:/account/login");
            exit();
        } 
        else 
        {
            // Check password
            $sql = "SELECT [UU],[UA] FROM [". TABLE ."] WHERE [UU] = " . $this -> username . " AND [UC] = " . $this -> password;
            $matchedpass = $this -> RunQuery($sql);
            if($matchedpass == false) 
            {
                // Failed to log in. Log invalid login attempts.
                //$sql = "INSERT INTO [LoginFailed] ('username','timestamp') VALUES ('" . $this -> username . "', '". date("Y-m-d H:i:s") . "')";
                //$stmt = sqlsrv_query ( $conn , $sql );

                // Check to see if user is or should be locked out.
                //$this -> lockedout($username);
                //$this -> locked ? header("Location:login.php?result=" . self::INVALIDPASSWORDCODE) : header("Location:login.php?result=" . self::USERISLOCKEDOUTCODE);
                session_start();
                $_SESSION["error"] = true;            
                header("Location:/account/login");
                exit();
            } 
            else
            {
                //Login successful. Store user in session and procede to menu.
                session_start();
                session_regenerate_id(true);
                $_SESSION["user"] = $founduser['UU'];
                $_SESSION["displayname"] = $matchedpass['UA'];
                $_SESSION["admintable"] = $table;
                $_SESSION["menu"] = $menu;
                header("Location:" . $menu);
                exit();
            }
        }
    }

    public function region($table, $menu)
    {
        $configured = $this -> Configure();
        
        if(!isset($configured))
        {            
            session_start();
            $_SESSION["error"] = true;
            header("Location:/account/login");
            exit();
        }

        //Check username
        $sql = "SELECT [UU],[SUB] FROM [". $table ."] WHERE [UU] = " . $this -> username;
        $founduser = $this -> RunQuery($sql);

        if(!$founduser) 
        {
            session_start();
            $_SESSION["error"] = true;            
            header("Location:/account/login");
            exit();
        }
        else if($founduser['UU'] == $founduser['SUB'])
        {
            session_start();
            $_SESSION["error"] = true;            
            header("Location:/account/login");
            exit();
        }
        else 
        {
            // Check password
            $sql = "SELECT [UU],[UA] FROM [". TABLE ."] WHERE [UU] = " . $this -> username . " AND [UC] = " . $this -> password;
            $matchedpass = $this -> RunQuery($sql);
            if($matchedpass == false) 
            {
                // Failed to log in. Log invalid login attempts.
                //$sql = "INSERT INTO [LoginFailed] ('username','timestamp') VALUES ('" . $this -> username . "', '". date("Y-m-d H:i:s") . "')";
                //$stmt = sqlsrv_query ( $conn , $sql );

                // Check to see if user is or should be locked out.
                //$this -> lockedout($username);
                //$this -> locked ? header("Location:login.php?result=" . self::INVALIDPASSWORDCODE) : header("Location:login.php?result=" . self::USERISLOCKEDOUTCODE);
                session_start();
                $_SESSION["error"] = true;            
                header("Location:/account/login");
                exit();
            } 
            else
            {
                //Login successful. Store user in session and procede to menu.
                session_start();
                session_regenerate_id(true);
                $_SESSION["user"] = $founduser['UU'];
                $_SESSION["displayname"] = $matchedpass['UA'];
                $_SESSION["admintable"] = $table;
                $_SESSION["menu"] = $menu;
                header("Location:" . $menu);
                exit();
            }
        }
    }

    public function ForgotStudentPassword()
    {
        if(isset($_POST['producttable']))
        {
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) // Validate email address
            {
                $message =  "Invalid email address please type a valid email!!";
            }
            else
            {
                $sanitizer = new Helper();
                $inputs["login"] = [];

                $inputs["table"] = isset($_POST['producttable']) && preg_match($sanitizer::LETNUMREGEX,$_POST['producttable']) ? strtoupper($_POST['producttable']) : null;
                $inputs["firstname"] = isset($_POST['firstname']) ? $sanitizer -> mssql_escape($_POST['firstname']) : null;
                $inputs["lastname"] = isset($_POST['lastname']) ? $sanitizer -> mssql_escape($_POST['lastname']) : null;
                $inputs["email"] = isset($_POST['email']) ? $sanitizer -> mssql_escape($_POST['email']) : null;
                $inputs["rawemail"] = $_POST['email'];
                $inputs["logintype"] = $_POST['logintype'];

                if(isset($_POST['login']) && preg_match($sanitizer::DATEREGEX2,$_POST['login']))
                {
                    $inputs["login"]["dob"] = $_POST['login'];
                }
                else
                {
                    $inputs["login"]["username"] = $sanitizer -> mssql_escape($_POST['login']);
                }

                if($inputs["logintype"] === self::DOBTABLE)
                    $hascredentials = isset($inputs["login"]["dob"]) ? true : false;
                else
                    $hascredentials = isset($inputs["login"]["username"]) ? true : false;

                if(!isset($inputs["table"]) || !isset($inputs["email"]) || !$hascredentials)
                        return 0;

                $studentinfo = $this -> GetStudentInfo($inputs);

                if(isset($studentinfo))
                {
                    $this -> InitReset($inputs, $studentinfo);
                    return true;
                }
                else
                    return 0; //Account not found.
            }
        }

        exit();
    }

    private function GetStudentInfo($inputs)
    {
        $context = new Db();
        // Foodhandler and FS Manager table.
        if($inputs["logintype"] === self::DOBTABLE && isset($inputs["login"]["dob"]))
        {
            // The date of births are stored in the 01C table. 
            // We need to get the user information from the login table,
            // then cross reference the 01C table for every record.
            $sql = "SELECT [id],[NF],[NL],[UU] FROM [".$inputs["table"]."]"; 
            //$sql .= " WHERE [DOB] = '" . $inputs["login"]["dob"] . "'";
            $sql .= " WHERE [NF] = " . $inputs["firstname"];
            $sql .= " AND [NL] = ". $inputs["lastname"];

            $studentList = $context -> RunQuery($sql);

            foreach($studentList as $idx => $student) {
                foreach($student as $key => $value)
                {
                    // Since UU is a unique field, we will use it to match records.
                    if($key == 'UU')
                    {
                        $sql = "SELECT [UU], [BD] FROM [01C]";
                        $sql .= " WHERE [BD] = '" . $inputs["login"]["dob"] . "'";
                        $sql .= " AND [UU] = '" . $value . "'";
                        
                        $studentMatch = $context -> RunQuery($sql);
                        if(isset($studentMatch['UU']))
                        {
                            return $student = Array(
                                "id" => $student['id'],
                                "NF" => $student['NF'],
                                "NL" => $student['NL'],
                                "UU" => $student['UU']
                            );
                        }
                    }
                }
            }
        }
        else
        {
             // All other tables.
            $sql = "SELECT [id],[NF],[NL]";
            $sql .= "FROM [" . $inputs["table"] . "] ";
            $sql .= "WHERE [UU] = " . $inputs["login"]["username"];
            return $this -> RunQuery($sql);
        }        
    }

    public function ForgotAdminPassword()
    {        
        if(isset($_POST['type']))
        {            
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) // Validate email address
            {
                $message =  "Invalid email address please type a valid email!!";
            }
            else
            {
                $sanitizer = new Helper();

                $inputs["table"] = isset($_POST['type']) && preg_match($sanitizer::LETNUMREGEX,$_POST['type']) ? strtoupper($_POST['type']) : null;
                $inputs["email"] = isset($_POST['email']) ? $sanitizer -> mssql_escape($_POST['email']) : null;
                $inputs["rawemail"] = isset($_POST['email']) ? $_POST['email'] : null;

                // Admin reset requests will not contain any credentials other than an email address and table.
                if(!isset($inputs["table"]) || !isset($inputs["email"]))
                        die(self::REQFIELDSERR);

                $admininfo = $this -> GetAdminInfo($inputs);

                if(count($admininfo) > 0)
                {
                    if(isset($admininfo['id']))
                    {
                        $admininfo['NF'] = $admininfo['INF'];
                        $admininfo['NL'] = $admininfo['INL'];
                    }
                    else
                    {
                        $admininfo['id'] = $admininfo['ID'];
                    }

                    $this -> InitAdminReset($inputs, $admininfo);
                }
                else
                    $message = "Account not found please signup now!!";
            }
        }
        exit();
    }

    public function ForgotShopPassword()
    {        
        if(isset($_POST['type']))
        {            
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) // Validate email address
            {
                $message =  "Invalid email address please type a valid email!!";
            }
            else
            {
                $sanitizer = new Helper();

                $inputs["table"] = self::COMPANYLOGIN;
                $inputs["email"] = isset($_POST['email']) ? $sanitizer -> mssql_escape($_POST['email']) : null;
                $inputs["rawemail"] = isset($_POST['email']) ? $_POST['email'] : null;

                // Admin reset requests will not contain any credentials other than an email address and table.
                if(!isset($inputs["table"]) || !isset($inputs["email"]))
                        die(self::REQFIELDSERR);

                $admininfo = $this -> GetAdminInfo($inputs);

                if(count($admininfo) > 0)
                {
                    if(isset($admininfo['id']))
                    {
                        $admininfo['NF'] = $admininfo['INF'];
                        $admininfo['NL'] = $admininfo['INL'];
                    }
                    else
                    {
                        $admininfo['id'] = $admininfo['ID'];
                    }

                    $this -> InitAdminReset($inputs, $admininfo);
                }
                else
                    $message = "Account not found please signup now!!";
            }
        }
        exit();
    }

    private function GetAdminInfo($inputs)
    {
        if($inputs["table"] === self::COMPANYTABLE)
                $sql = "SELECT [ID],[NF],[NL] FROM [" . $inputs["table"] . "] WHERE [AM] = " . $inputs["email"];
        else if($inputs["table"] === self::MULTITABLE)
                $sql = "SELECT [ID],[NF],[NL] FROM [" . $inputs["table"] . "] WHERE [UM] = " . $inputs["email"];
        else if($inputs["table"] === self::INSTRUCTTABLE)
                $sql = "SELECT [id],[INF],[INL] FROM [" . $inputs["table"] . "] WHERE [IM] = " . $inputs["email"];

        return $this -> RunQuery($sql);
    }

    private function InitReset($inputs, $userinfo)
    {        
        $encrypt = md5(rand(100000, 999999) + $userinfo['id']);
        $date = date('Y-m-d');

        $values["id"]     = $userinfo["id"];
        $values["exp"]    = "'" . date('Y-m-d', strtotime($date. ' + 2 days')) . "'";
        $values["link"]   = "'" . $encrypt . "'";
        $values["active"] = 1;

        $this -> CreateReset($values);

        $greeting = $userinfo["NF"] . " " . $userinfo["NL"];

        $mailargs["to"]              = $inputs["rawemail"];
        $mailargs["from"]            = self::FORGOTPASSUSER;
        $mailargs["subject"]         = self::FORGOTPASSSUB;
        $mailargs["greeting"]        = $greeting;
        $mailargs["body"]["host"]    = $this -> resetLink; //self::RESETLINK;
        $mailargs["body"]["id"]      = $userinfo['id'];
        $mailargs["body"]["course"]  = $inputs['table'];
        $mailargs["body"]["encrypt"] = $encrypt;
        $mailargs["smtpuser"]        = self::FORGOTPASSUSER;
        $mailargs["smtppass"]        = self::FORGOTPASSPASS;
        
        $this -> SendReset($mailargs);
    }

    private function InitAdminReset($inputs, $userinfo)
    {        
        $encrypt = md5(rand(100000, 999999) + $userinfo['id']);
        $date = date('Y-m-d');

        $values["id"]     = $userinfo["id"];                    
        $values["exp"]    = "'" . date('Y-m-d', strtotime($date. ' + 2 days')) . "'";
        $values["link"]   = "'" . $encrypt . "'";
        $values["active"] = 1;

        $this -> CreateReset($values);

        $greeting = $userinfo["NF"] . " " . $userinfo["NL"];

        $mailargs["to"]              = $inputs["rawemail"];
        $mailargs["from"]            = self::FORGOTPASSUSER;
        $mailargs["subject"]         = self::FORGOTPASSSUB;
        $mailargs["greeting"]        = $greeting;
        $mailargs["body"]["host"]    = $this -> resetLink; //self::RESETLINK;
        $mailargs["body"]["id"]      = $userinfo['id'];
        $mailargs["body"]["course"]  = $inputs['table'];
        $mailargs["body"]["encrypt"] = $encrypt;
        $mailargs["smtpuser"]        = self::FORGOTPASSUSER;
        $mailargs["smtppass"]        = self::FORGOTPASSPASS;
        
        $this -> SendReset($mailargs);
    }

    private function CreateReset($values)
    {
        $sql = "INSERT INTO [ResetPassword] VALUES (";
        $sql .= $values["id"] . ", "; // User Id, not Reset Id.
        $sql .= $values["exp"] . ",";
        $sql .= $values["link"] . ",";
        $sql .= $values["active"];
        $sql .= ")";

        $this -> RunInsert($sql);
    }

    private function SendReset($mailargs)
    {
        $mailer = new Mailer();
        $mailer -> ForgotPassword($mailargs);
    }

    private function SendAdminReset($mailargs)
    {
        $mailer = new Mailer();
        $mailer -> ForgotPassword($mailargs);
    }

    public function ResetPassword()
    {
        $sanitizer = new Helper();

        $table = isset($_POST['course']) && preg_match($sanitizer::LETNUMREGEX,$_POST['course']) ? strtoupper($_POST['course']) : null;
        $userid = isset($_POST['userid']) ? $sanitizer -> mssql_escape($_POST['userid']) : null;
        $newpass = isset($_POST['newpass']) ? $sanitizer -> mssql_escape($_POST['newpass']) : null;
        $confirm = isset($_POST['confirm']) ? $sanitizer -> mssql_escape($_POST['confirm']) : null;
        $passmatch = $newpass === $confirm ? true : false;

        if(substr($table, 0, 2) == self::ADMINTABLE)
        {
            if($table == self::COMPANYTABLE)
            {
                $companydata = $this -> GetCompanyUserName($userid);
                $username = $companydata['AN'];
                $table = '07L3';
                $adminData = Array(
                    "table" => $table,
                    "username" => $username,
                    "newpass" => $newpass
                );
            }
            else
            {
                $adminData = Array(
                    "table" => $table,
                    "userid" => $userid,
                    "newpass" => $newpass
                );
            }

            $this -> MakeAdminResetQuery($adminData);
        }
        else
        {
            if(!isset($table) || !isset($userid) || !isset($confirm) || !isset($newpass) || !$passmatch)
                die(self::REQFIELDSERR);
            else
            {
                $sql = "UPDATE [newtap].[dbo].[" . $table . "] SET [UC] = " . $newpass. " WHERE [id] = " . $userid;
                $this -> RunInsert($sql);
            }
        }

        $sql = "UPDATE [ResetPassword] SET [Active] = 0 WHERE [UserId] = " . $userid;
        $this -> RunInsert($sql);
    }

    private function GetCompanyUserName($userid)
    {
        $sql = "SELECT [AN] FROM [07O6] WHERE [ID] = '" . $userid ."'";
        return $this -> RunQuery($sql);
    }

    public function MakeAdminResetQuery($adminData)
    {
        if($adminData['table'] == self::COMPANYLOGIN)
            $sql = "UPDATE [" . $adminData['table'] . "] SET [AC] = " . $adminData['newpass']. " WHERE [AN] = '" . $adminData['username'] . "'";
        else
            $sql = "UPDATE [" . $adminData['table'] . "] SET [UC] = " . $adminData['newpass']. " WHERE [id] = '" . $adminData['userid'] . "'";

        $this -> RunInsert($sql);
    }

    private function RunQuery($sql)
    {
        $conn = Db::getInstance();
        $response = [];
        $stmt = mssql_query ( $sql , $conn );
        if($stmt === false)
        {
            die(mssql_get_last_message());
        }
        else
        {
            $row = mssql_fetch_assoc($stmt);
            return $row ? $row : false;
        }
    }

    private function RunInsert($sql, $kill = 0)
    {
        $sql;
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

    public function logout()
    {
        // Remove the username from session and send to home page.
        session_start();
        session_unset();     // unset $_SESSION variable for the run-time 
    	session_destroy();   // destroy session data in storage
        header("Location:/");
    }

    public function ValidateLink()
    {
        if(isset($_GET['encrypt']))
        {
            $sanitizer = new Helper();
            $inputs["encrypt"] = $sanitizer -> mssql_escape($_GET['encrypt']);

            $sql = "SELECT [Active],[Expiration] from [ResetPassword] WHERE [Link] =" . $inputs["encrypt"];
            $link = $this -> RunQuery($sql);

            // If the link is not active or it has expired, send them back to the home page.
            if($link["Active"] == 1 && $link["Expiration"] > date("Y-d-m"))
                return $active = true;
            else
                header("Location:/");exit();                
        }
    }

    private function Configure()
    {
        $dataexists = null;
        if($_POST["username"] != "" && $_POST["password"] != "")
        {
            $dataexists = true;
        }

        if(isset($dataexists))
        {
            $sanitizer = new Helper();

            // If a user name is all numbers with no letters,
            // it will not be converted into a hexadeciaml value.
            // This will cause a problem with the SQL used to login.
            // We use a regular expression to test for number only logins,
            // and wrap those logins in quotes. Other logins are converted to hex.
            if(preg_match($sanitizer::NUMBERONLY, $_POST["username"]))
                $this -> username = "'" . $_POST["username"] . "'";
            else
                $this -> username = $sanitizer -> mssql_escape($_POST['username']);

            $this -> password = $sanitizer -> mssql_escape($_POST['password']);
            //$this -> rawuser = $_POST['username'];

            $this -> conn = mssql_connect($_SERVER['DB_HOSTNAME'], $_SERVER['DB_USERNAME'], $_SERVER['DB_PASSWORD']) or header('Location:login.php?result=' . self::CONNCENTIONFAILEDCODE);
            mssql_select_db($_SERVER['DB_DATABASE'], $this -> conn) or header('Location:login.php?result=' . self::CONNCENTIONFAILEDCODE);

            return true;
        }

        return null;
    }

    public function authenticated()
    {
        //SEE IF USER IS LOGGED IN ALREADY
        $sql = "SELECT [Active] FROM [AuthenticatedUsers] WHERE [UserName] = " . $_POST["username"];
        $stmt = sqlsrv_query ( $conn , $sql );
        !$stmt ? false : true;
    }

    private function lockedout()
    {
        //
    }

    public function mssql_escape($data) 
    {
        if(is_numeric($data))
            return $data;
        $unpacked = unpack('H*hex', $data);
        return '0x' . $unpacked['hex'];
    }

    public function DisplayName($type, $key)
    {
        $context = new Db();

        switch ($type) {
            case 0:
                $sql = "SELECT [NC] FROM [07SL1] WHERE [VC] = '" . $key . "'";
                return $context -> RunQuery($sql);
                break;
            case 1:
                $sql = "SELECT [NCPY] FROM [07O6] WHERE [AN] = '" . $key . "'";
                return $context -> RunQuery($sql);
                break;
        }
    }
}
?>