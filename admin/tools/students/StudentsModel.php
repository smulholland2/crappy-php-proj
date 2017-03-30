<?php

    include_once $_SERVER['DOCUMENT_ROOT'].'/config/connection.php';

    class StudentsModel
    {
        // TABLE FIELDS           // User name, email, pass, first, last, admin email, date added, birthday
        const FIELDS                = "[UU],[UM],[UC],[NF],[NL],[UA],[DA],[ES],[FRANCHNO]";
        const FIELDSVER             = "[UU],[UM],[UC],[NF],[NL],[UA],[DA],[VER],[ES],[FRANCHNO]";
        const FIELDSNODOB           = "[UU],[UM],[UC],[NF],[NL],[UA],[DA],[VER],[ES],[FRANCHNO]";        
        const FIELDSME              = "[UU],[UM],[UC],[NF],[NL],[UA],[DA],[VER],[ES],[FRANCHNO],[ME],[REGION]";
        const FIELDSUTAH            = "[UU],[UM],[UC],[NF],[NL],[UA],[DA],[VER],[ES],[FRANCHNO],[ME],[REGION],[GENDER]";
        const FIELDSMEMAN           = "[UU],[UM],[UC],[NF],[NL],[UA],[DATE_EXPIRE],[DA],[VER],[ES],[FRANCHNO],[ME],[REGION]";
        const FIELDSIL              = "[UU],[UM],[UC],[NF],[NL],[UA],[DATE_EXPIRE],[DA],[VER],[ES],[FRANCHNO],[ME],[IL]";
        const FIELDSDOB             = "[UU],[BD]";
        const FIELDSUTAHX           = "[UU],[UA1],[UA2],[UZ],[UST],[UCI],[UP],[EWP],[MI],[COUNTY]";
        const FIELDSCBCF            = "[UU],[UM],[UC],[NF],[NL],[UA],[DA],[ES],[FRANCHNO],[CF]";

        const ALCOHOLPARAMS         = array(
                                        'username'    => '@username',
                                        'useremail'   => '@useremail',
                                        'password'    => '@password',
                                        'firstname'   => '@firstname',
                                        'lastname'    => '@lastname',
                                        'account'     => '@account',
                                        'dateadded'   => '@dateadded',
                                        'language'    => '@language',
                                        'storenumber' => '@storenumber'
                                    );
        const DOBPARAMS             = array(
                                        'username'  => '@username',
                                        'dateadded' => '@dateadded',
                                        'birthday'  => '@birthday'
                                    );

        // LANGUAGES
        const ENGLISH             = "English";
        const SPANISH             = "Spanish";
        const ENGLISHX            = 0x454e474c495348;
        const SPANISHX            = 0x5350414e495348;

        public $connector         = null;

        public function __construct()
        {

        }

        public function AddStudent($values, $table)
        {
            setlocale(LC_ALL, "en_US.UTF-8");

            $context = new Db();
            $sql = "INSERT INTO [" . $table . "] ";
            $sql .= "(" . self::FIELDS . ") ";
            $sql .= "VALUES (";
            $sql .= $values["username"]   . ","; //UU
            $sql .= $values["email"]      . ","; //UM
            $sql .= $values["password"]   . ","; //UC
            $sql .= $values["firstname"]  . ","; //NF
            $sql .= $values["lastname"]   . ","; //NL
            $sql .= $values["admin"] . ","; //UA
            $sql .= "'" . date("Y-m-d", strtotime("-8 hours"))   . "',"; //DA
            $sql .= $values["lang"] . ",";
            $sql .= isset($values["storenum"]) ? $values["storenum"] : 'NULL';
            $sql .= ")";

            return $context -> RunInsert($sql);
        }

        public function AddStudentVER($values, $table)
        {
            setlocale(LC_ALL, "en_US.UTF-8");            
            $context = new Db();
            $sql = "INSERT INTO [" . $table . "] ";
            $sql .= "(" . self::FIELDSVER . ") ";
            $sql .= "VALUES (";
            $sql .= $values["username"]   . ","; //UU
            $sql .= $values["email"]      . ","; //UM
            $sql .= $values["password"]   . ","; //UC
            $sql .= $values["firstname"]  . ","; //NF
            $sql .= $values["lastname"]   . ","; //NL
            $sql .= $values["admin"] . ","; //UA
            $sql .= "'" . date("Y-m-d", strtotime("-8 hours"))   . "',"; //DA
            $sql .= $values["lang"] != self::SPANISHX ? $values["courselink"] . "," : $values["scourselink"] . ","; //VER
            $sql .= $values["lang"] . ","; //ES
            $sql .= isset($values["storenum"]) ? $values["storenum"] : 'NULL';
            $sql .= ")";

            return $context -> RunInsert($sql);
        }

        // This Query is used to insert Allergen and Alcohol courses
        // It uses no extra fields and inserts the user into the DOB table.
        public function AddStudentDOB($values, $table)
        {
            setlocale(LC_ALL, "en_US.UTF-8");

            $context = new Db();
            $sql = "INSERT INTO [" . $table . "] ";
            $sql .= "(" . self::FIELDS . ") ";
            $sql .= "VALUES (";
            $sql .= $values["username"]   . ","; //UU
            $sql .= $values["email"]      . ","; //UM
            $sql .= $values["password"]   . ","; //UC
            $sql .= $values["firstname"]  . ","; //NF
            $sql .= $values["lastname"]   . ","; //NL
            $sql .= $values["admin"] . ","; //UA
            $sql .= "'" . date("Y-m-d", strtotime("-8 hours"))   . "',"; //DA
            $sql .= $values["lang"] . ","; //ES
            $sql .= isset($values["storenum"]) ? $values["storenum"] : 'NULL';
            $sql .= ")";

            $newStudent = $context -> RunInsert($sql);

            if(strlen($values["dob"] > 0))
                $this -> AddDob($values["username"],$values["dob"],$table);

            return $newStudent;
        }    

        // This Query is used to insert Food Safety Handler courses
        // It uses the ME field and inserts the user into the DOB table.
        // Food Safety Managers also use this query, but they do not add a DOB.
        public function AddStudentME($values, $table, $me)
        {
            setlocale(LC_ALL, "en_US.UTF-8");

            $context = new Db();
            $sql = "INSERT INTO [" . $table . "] ";
            $sql .= "(" . self::FIELDSME . ") ";
            $sql .= "VALUES (";
            $sql .= $values["username"]   . ","; //UU
            $sql .= $values["email"]      . ","; //UM
            $sql .= $values["password"]   . ","; //UC
            $sql .= $values["firstname"]  . ","; //NF
            $sql .= $values["lastname"]   . ","; //NL
            $sql .= $values["admin"] . ","; //UA
            $sql .= "'" . date("Y-m-d", strtotime("-8 hours"))   . "',"; //DA
            $sql .= $values["lang"] != self::SPANISHX ? $values["courselink"] . "," : $values["scourselink"] . ","; //VER
            $sql .= $values["lang"] . ","; //ES
            $sql .= isset($values["storenum"]) ? $values["storenum"]."," : 'NULL,';
            $sql .= $me;
            $sql .= $values["region"] == '' ? "," .'NULL' : ",'".$values['region']."'";
            $sql .= ")";
            $newStudent = $context -> RunInsert($sql);            
            if(strlen($values["dob"] > 0))
                $this -> AddDob($values["username"], $values["dob"],$table);

            return $newStudent;
        }

        public function AddStudentUtah($values, $valuesUtah)
        {
            setlocale(LC_ALL, "en_US.UTF-8");

            $context = new Db();
            $sql = "INSERT INTO [01D] ";
            $sql .= "(" . self::FIELDSUTAH . ") ";
            $sql .= "VALUES (";
            $sql .= $values["username"]   . ","; //UU
            $sql .= $values["email"]      . ","; //UM
            $sql .= $values["password"]   . ","; //UC
            $sql .= $values["firstname"]  . ","; //NF
            $sql .= $values["lastname"]   . ","; //NL
            $sql .= $values["admin"] . ","; //UA
            $sql .= "'" . date("Y-m-d", strtotime("-8 hours"))   . "',"; //DA
            $sql .= $values["lang"] == self::ENGLISHX ? $values["courselink"] . "," : $values["scourselink"] . ","; //VER
            $sql .= $values["lang"] == self::ENGLISHX ? $values["lang"] . ",": $values["lang"] . ","; //ES
            $sql .= isset($values["storenum"]) ? $values["storenum"]."," : 'NULL,';
            $sql .= 19 . ",";
            $sql .= "'".$values['region']."',";
            $sql .= $valuesUtah['gender'];
            $sql .= ")";

            $newStudent = $context -> RunInsert($sql);

            $this -> AddDob($values["username"], $values["dob"],"01C");

            $this -> AddExtraUtah($valuesUtah);

            return $newStudent;
        }

        // This Query is used to insert Food Safety Manager courses
        // It uses the ME field and inserts the user into the DOB table.
        // Food Safety Managers also use this query, but they do not add a DOB.
        public function AddStudentMEManager($values, $table, $me, $exp)
        {
            setlocale(LC_ALL, "en_US.UTF-8");

            $context = new Db();
            $sql = "INSERT INTO [" . $table . "] ";
            $sql .= "(" . self::FIELDSMEMAN . ") ";
            $sql .= "VALUES (";
            $sql .= $values["username"]   . ","; //UU
            $sql .= $values["email"]      . ","; //UM
            $sql .= $values["password"]   . ","; //UC
            $sql .= $values["firstname"]  . ","; //NF
            $sql .= $values["lastname"]   . ","; //NL
            $sql .= $values["admin"] . ","; //UA
            $sql .= "'" . $exp . "',"; //DATE_EXPIRE
            $sql .= "'" . date("Y-m-d", strtotime("-8 hours"))   . "',"; //DA
            $sql .= $values["lang"] != self::SPANISHX ? $values["courselink"] . "," : $values["scourselink"] . ","; //VER
            $sql .= $values["lang"] . ","; //ES
            $sql .= isset($values["storenum"]) ? $values["storenum"]."," : 'NULL,';
            $sql .= $me;
            $sql .= $values["region"] == '' ? "," .'NULL' : ",'".$values['region']."'";
            $sql .= ")";
            $newStudent = $context -> RunInsert($sql);            

            return $newStudent;
        }

        // This query is used to insert Food Safety Recertification students.
        // It uses the IL column and has a ME value preset to 2 for all courses.
        // It does not insert a DOB.
        public function AddStudentIL($values, $table, $me, $il, $exp)
        {
            setlocale(LC_ALL, "en_US.UTF-8");

            $context = new Db();
            $sql = "INSERT INTO [" . $table . "] ";
            $sql .= "(" . self::FIELDSIL . ") ";
            $sql .= "VALUES (";
            $sql .= $values["username"]   . ","; //UU
            $sql .= $values["email"]      . ","; //UM
            $sql .= $values["password"]   . ","; //UC
            $sql .= $values["firstname"]  . ","; //NF
            $sql .= $values["lastname"]   . ","; //NL
            $sql .= $values["admin"] . ","; //UA
            $sql .= "'" . $exp . "',"; //UA
            $sql .= "'" . date("Y-m-d", strtotime("-8 hours"))   . "',"; //DA
            $sql .= $values["lang"] != self::SPANISHX ? $values["courselink"] . "," : $values["scourselink"] . ","; //VER
            $sql .= $values["lang"] . ","; //ES
            $sql .= isset($values["storenum"]) ? $values["storenum"]."," : 'NULL,';
            $sql .= $me . ",";
            $sql .= $il;
            $sql .= ")";

            return $context -> RunInsert($sql);
        }

        public function AddStudentAlcohol($args)
        {
            $context = new Db();
            $dob = $args["dob"];
            unset($args["dob"]);
            
            $proc = 'InsertStudentAlcohol';

            $params = self::ALCOHOLPARAMS;            

            $context -> ExecuteStoredProcedureMultiArg($proc,$params,$args);

            $this -> AddAlcoholDob($args["username"], $dob);

            return true;

        }

        public function AddAlcoholDob($username,$dob)
        {
            $addedDate = date("Y-m-d", strtotime("-8 hours"));

            $args = array(
                "username" => $username, 
                "dateadded" => $addedDate, 
                "birthday" => $dob
            );
            
            $context = new Db();

            $proc = 'InsertStudentAlcoholDob';

            $params = self::DOBPARAMS;

            return $context -> ExecuteStoredProcedureMultiArg($proc,$params,$args);
        }

        public function AddDob($username,$dob,$table)
        {
            if($table == "09D" || $table == "10D" || $table == "11D")
                $dobtable = "AllergenDob";
            else
                $dobtable = "01C";
            $context = new Db();
            $sql = "INSERT INTO [".$dobtable."] ";//FIELDSDOB
            $sql .= "(" . self::FIELDSDOB . ") ";
            $sql .= "VALUES (";
            $sql .= $username . ","; //UU
            $sql .= "'" . $dob . "'"; //UM
            $sql .= ")";

            return $context -> RunInsert($sql);
        }

        public function AddStudentCBCF($values, $cfBool)
        {
            setlocale(LC_ALL, "en_US.UTF-8");

            $context = new Db();
            $sql = "INSERT INTO [03D] ";
            $sql .= "(" . self::FIELDSCBCF . ") ";
            $sql .= "VALUES (";
            $sql .= $values["username"]   . ","; //UU
            $sql .= $values["email"]      . ","; //UM
            $sql .= $values["password"]   . ","; //UC
            $sql .= $values["firstname"]  . ","; //NF
            $sql .= $values["lastname"]   . ","; //NL
            $sql .= $values["admin"] . ","; //UA
            $sql .= "'" . date("Y-m-d", strtotime("-8 hours"))   . "',"; //DA
            $sql .= $values["lang"] . ",";
            $sql .= isset($values["storenum"]) ? $values["storenum"]."," : 'NULL,';
            $sql .= $cfBool;
            $sql .= ")";

            return $context -> RunInsert($sql);
        }

        public function AddAllergenPlan($username)
        {
            $connector = new Db();
            $sql = "INSERT INTO [09PLAN] (UU) VALUES (". $username.")";
            $connector -> RunInsert($sql);
        }

        public function CheckForExisting($requested, $table)
        {
            $connector = new Db();
            $sql = "SELECT [UU] FROM [". $table ."] WHERE [UU] = " . $requested;
            $exists = $connector -> RunQuery($sql);
            return isset($exists["UU"]) ? true : false;
        }

        public function GetCourseList($admin)
        {
            $context = new Db();
            // Return this list to be displayed in a select on the page.
            $list = [];

            // Join the product table and the license table by the product id with the admin user as the filter.
            // Admin user is coming from session created at login.
            $sql = "SELECT [07DS2].[ProductName], [07DS2].[id], [Licenses].[LicensesRemaining] ";
            $sql .= "FROM [07DS2] ";
            $sql .= "INNER JOIN [Licenses] ";
            $sql .= "ON [07DS2].[id]=[Licenses].[ProductId] ";
            $sql .= "WHERE [Licenses].[UserId] = " . $admin;
            $sql .= " AND [07DS2].[LMS] > 0";
            $sql .= " AND [Licenses].[LicensesRemaining] != 0 AND [Licenses].[LicensesRemaining] != -2";
            $sql .= " ORDER BY [07DS2].[ProductName] ASC";

            $list = $context -> RunQuery($sql);

            return $list;
        }

        public function GetCorpCourse($id)
        {
            $context = new Db();
            $list = [];

            $sql = "SELECT [ProductName] FROM [07DS2] WHERE [id] = " . $id;

            return $context -> RunQuery($sql);
        }

        public function GetFullCourseList()
        {
            $context = new Db();
            // Return this list to be displayed in a select on the page.
            $list = [];

            // Join the product table and the license table by the product id with the admin user as the filter.
            // Admin user is coming from session created at login.
            $sql = "SELECT [ProductName], [id] ";
            $sql .= "FROM [07DS2] ";
            $sql .= "WHERE [LMS] > 0 ";
            $sql .= " ORDER BY [07DS2].[ProductName] ASC";

            $list = $context -> RunQuery($sql);

            return $list;
        }

        public function LookupCourse($productid)
        {
            $connector = new Db();
            // Find the "ProID" by the "id".
            $sql = "SELECT [ProID], [TableCode], [ProductName] ";
            $sql .= "FROM [07DS2] ";
            $sql .= "WHERE [id] = " . $productid;
            $course = $connector -> RunQuery($sql);

            return $course;
        }

        public function GetCourseData($proid)
        {
            $connector = new Db();
            $sql = "SELECT [id],[ProductName],[SpanishAvai],[TableCode],[CourseLink],[SCourseLink] FROM [07DS2] WHERE [id] = " . $proid;
            $course = $connector -> RunQuery($sql);
            foreach ($course as $key => $value) {
                if($key == "ProductName")
                    $this -> coursename = $value;
                if($key == "id")
                    $this -> productid = $value;
                if($key == "TableCode")
                    $this -> tablecode = $value;
                if($key == "CourseLink")
                    $this -> courselink = $value;
                if($key == "SCourseLink")
                    $this -> scourselink = $value;
            }
        }

        public function GetCourseLanguages($proid)
        {
            $connector = new Db();
            $sql = "SELECT [SpanishAvai] FROM [07DS2] WHERE [id] = " . $proid;
            $langs = $connector -> RunQuery($sql);
            return $langs;
        }

        public function CheckLisc($proid, $admin)
        {
            $connector = new Db();
            $sql = "SELECT [LicensesRemaining] FROM [Licenses] WHERE [ProductId] = " . $proid . " AND [UserId] = " . $admin;
            $remaining = $connector -> RunQuery($sql);
            if($remaining["LicensesRemaining"] == 0)
                return false;
            else
                return true;
        }

        public function DeductLicense($proid, $admin)
        {
            $context = new Db();
            $sql = "SELECT [LicensesRemaining] FROM [Licenses] WHERE [ProductId] = " . $proid . " AND [UserId] = " . $admin;
            $remaining = $context -> RunQuery($sql);
            
            if(!isset($remaining["LicensesRemaining"]))
                return false;
            else if($remaining["LicensesRemaining"] > 0)
            {
                $newtotal = $remaining["LicensesRemaining"] - 1;
                $sql = "UPDATE [Licenses] SET [LicensesRemaining] = " . $newtotal . " WHERE [ProductId] = " . $proid . " AND [UserId] = " . $admin;
                $context -> RunInsert($sql);
            }
        }

        public function DeductCorpLicense($proid, $admin)
        {
            $context = new Db();
            $sql = "SELECT [LicensesRemaining] FROM [Licenses] WHERE [ProductId] = " . $proid . " AND [UserId] = '" . $admin ."'";
            $remaining = $context -> RunQuery($sql);

            if($remaining["LicensesRemaining"] > 0)
            {
                $newtotal = $remaining["LicensesRemaining"] - 1;
                $sql = "UPDATE [Licenses] SET [LicensesRemaining] = " . $newtotal . " WHERE [ProductId] = " . $proid . " AND [UserId] = '" . $admin ."'";
                $context -> RunInsert($sql);
            }
        }

        public function RefundLicense($proid, $admin)
        {
            $connector = new Db();
            $sql = "SELECT [LicensesRemaining] FROM [Licenses] WHERE [ProductId] = " . $proid . " AND [UserId] = " . $admin;
            $remaining = $connector -> RunQuery($sql);

            if($remaining["LicensesRemaining"] > 0)
            {
                $newtotal = $remaining["LicensesRemaining"] + 1;
                $sql = "UPDATE [Licenses] SET [LicensesRemaining] = " . $newtotal . " WHERE [ProductId] = " . $proid . " AND [UserId] = " . $this -> cleanadmin;
                $connector -> RunInsert($sql);
            }
        }

        public function ActivateLicense($key, $admin, $studentName, $timestamp)
        {
            $context = new Db();
            $sql = "UPDATE [SerialNumber] SET [ACTIVATED] = 1, 
            [DATE_ACTIVATED] = '" . $timestamp . "', [STUDENT_USER_NAME] = " . $studentName 
            . " WHERE [ACCOUNT_NAME] = " . $admin . " AND [SERIAL] = '" . $key ."'";
            $context -> RunInsert($sql);
        }

        public function IsStudentInCourse($student,$table)
        {
            $connector = new Db();
            $sql = "SELECT * FROM [". $table ."] WHERE [UU] = " . $student;
            $result = $connector -> RunQuery($sql);
            return $result > 1 ? true : false;
        }

        public function DeleteStudentCourseData($tables, $studentname)
        {
            $connector = new Db();
            foreach ($tables as $table) {
                
                $sql = "DELETE TOP(1)
                        FROM [$table]
                        WHERE UU = " . $studentname;

                $connector -> RunQuery($sql);
            }
        }

        public function CheckLiscWarranty($student, $table)
        {
            // Refunds are granted to students that were enrolled within 30 days and that have not started the second lesson.
            // For classes with only one lesson, they cannot have finished the lesson to get the refund.
            $context = new Db();
            $sql = "SELECT [DA] FROM [" . $table . "] WHERE [UU] = " . $student;
            $warranty = $context -> RunQuery($sql);

            if(isset($warranty["DA"]))
            {
                // Create a timestamp for today.
                $today = date('Y-m-d');
                $today = new DateTime($today);

                // Create a timestamp for the DA value.
                $refund = new DateTime($warranty["DA"]);

                // Add 30 days to the DA value.
                $refund ->  add(new DateInterval('P30D'));

                // Compare the two timestamps.
                $withinLimit = $today -> getTimestamp() < $refund -> getTimestamp() ? true : false;

            }
            else
                return false;

            // If the DA value is with 30 days, we need to check the P table to see what lessons the student has taken.
            if($withinLimit)
            {
                // HACCP does not use the P table for score tracking.
                // If HACCP, use the D table instead.
                if($table != "06D")
                    // All other courses use the P table.
                    $ptable = str_replace('D','P', $table);
                else
                    $ptable = $table;

                
                $sql = "SELECT [DE] FROM [" . $ptable . "] WHERE [NUM] = '02' AND [UU] = " . $student;
                $lesson2 = $context -> RunQuery($sql);

                if(!isset($lesson2['DE']))
                {
                    $sql = "SELECT [DS] FROM [" . $ptable . "] WHERE [NUM] = '02'" . $student;
                    $lesson1 = $context -> RunQuery($sql);
                    if(!isset($lesson2['DS']))
                    {
                        $sql = "SELECT [DE] FROM [" . $ptable . "] WHERE [NUM] = '01'" . $student;
                        $lesson1 = $context -> RunQuery($sql);
                        if(isset($lesson1['DE']))
                            return false;
                        else
                            return true;
                    }
                    else
                        return false;
                }
            }
            else
                return false;

        }

        public function GetVoucher($voucherCode)
        {
            $context = new Db();
            $sql = "SELECT [SERIAL] FROM [SerialNumber] WHERE [ACTIVATED] = 0 AND [SERIAL] = " . $voucherCode;
            return $context -> RunQuery($sql);
        }

        public function ActivateVoucher($voucherCode, $studentName, $timestamp)
        {
            $context = new Db();
            $sql = "UPDATE [SerialNumber] SET [ACTIVATED] = 1, 
            [DATE_ACTIVATED] = '" . $timestamp . "', [STUDENT_USER_NAME] = " . $studentName 
            . " WHERE [SERIAL] = " . $voucherCode;
            $context -> RunInsert($sql);
        }

        public function GetStoreNum($admin, $table, $userCol)
        {
            $context = new Db();
            $sql = "SELECT [FRANCHISESET] FROM [" . $table . "] WHERE [" . $userCol . "] = '" . $admin . "'";
            return $context -> RunQuery($sql);
        }

        public function SetProgressInit($values)
        {

        }

        public function SetScoreInit($values, $table)
        {
            $context = new Db();
            if($table != "06S")
            {
                $sql = "INSERT INTO [" . $table . "] ([UU]) VALUES (".$values['username'].")";
                return $context -> RunInsert($sql);
            }
            else
                return true;
        }

        public function GetMECode($values, $table)
        {
            $context = new Db();
            $sql = "SELECT [JobType] FROM [07DS2] WHERE [id] = " . $values['productid'];
            return $context -> RunQuery($sql);
        }

        public function GetILCode($values, $table)
        {
            $context = new Db();
            $sql = "SELECT [StuType] FROM [07DS2] WHERE [id] = " . $values['productid'];
            return $context -> RunQuery($sql);
        }

        public function SetDOB($values)
        {
            $context = new Db();
            $sql = "INSERT INTO [01C] ([UU],[BD]) VALUES (".$values['username'].",'".$values['dob']."')";
            return $context -> RunInsert($sql);
        }

        public function GetTableCode($productId)
        {
            $context = new Db();
            $sql = "SELECT [TABLECODE] FROM [07DS2] WHERE [id] = " . $productId;
            return $context -> RunQuery($sql);
        }

        public function CheckCorporate($admin)
        {
            $context = new Db();
            $sql = "SELECT [CA] FROM [07L3] WHERE [AN] = " . $admin;
            $corpAdminId = $context -> RunQuery($sql);

            if(isset($corpAdminId['CA']))
            {
                $sql = "SELECT [SUB] FROM [07L2] WHERE [id] = '" . $corpAdminId['CA'] . "'";
                return $context -> RunQuery($sql);
            }
            else
            {
                return false;
            }
        }

        public function GetSpanishAvailable($productId)
        {
            $context = new Db();
            $sql = "SELECT [SpanishAvai] FROM [07DS2] WHERE [id] = " . $productId;
            return $context -> RunQuery($sql);
        }

        public function GetRegion($productId)
        {
            $context = new Db();
            $sql = "SELECT [Region] FROM [07DS2] WHERE [id] = " . $productId;
            return $context -> RunQuery($sql);
        }

        public function CheckLimit($admin)
        {
            $context = new Db();
            $sql = "SELECT [MINLIC],[REORDER] FROM [07L3] WHERE [AN] = " . $admin;
            return $context -> RunQuery($sql);
        }

        public function CheckDobTable($user)
        {
            $context = new Db();
            $sql = "SELECT [UU] FROM [01C] WHERE [UU] = " . $user;
            $exists = $context -> RunQuery($sql);
            return isset($exists["UU"]) ? true : false;
        }

        public function GetExpDate($admin)
        {
            $context = new Db();
            $sql = "SELECT [TRAIN_PERIOD] FROM [07L3] WHERE [AN] = " . $admin;
            return $context -> RunQuery($sql);
        }

        private function AddExtraUtah($values)
        {
            $context = new Db();
            $sql = "INSERT INTO [01D2] ";//FIELDSDOB
            $sql .= "(" . self::FIELDSUTAHX . ") ";
            $sql .= "VALUES (";
            $sql .= $values['username'] . ","; //UU
            $sql .= $values['address1'] . ","; //UU
            $sql .= $values['address2'] . ","; //UU
            $sql .= $values['zip'] . ","; //UU
            $sql .= "'UT',"; //UU
            $sql .= $values['city'] . ","; //UU
            $sql .= $values['phone'] . ","; //UU
            $sql .= $values['workphone'] . ","; //UU
            $sql .= $values['midinitial'] . ","; //UU
            $sql .= "'".$values['county']."'"; //UU
            $sql .= ")";

            return $context -> RunInsert($sql);
        }

        public function GetUtahRegion($city)
        {
            $context = new Db();
            $sql = "SELECT [County],[Region] FROM [UtahCities] WHERE [City] = " . $city;
            return $context -> RunQuery($sql);
        }
    }
?>