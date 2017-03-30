<?php

    include_once $_SERVER['DOCUMENT_ROOT'].'/admin/tools/students/StudentsModel.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/config/connection.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/lib/Helper.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/lib/Mailer.php';

    class StudentsController
    {        
        // EMPTY FORM FIELD ERROR CONSTANTS
        const NOFNAME             = "First Name is a required field.";
        const NOLNAME             = "Last Name is a required field.";
        const NOEMAIL             = "Email is a required field.";
        const NOUSERNAME          = "Username is a required field.";
        const NOPASS1             = "Password is a required field.";
        const NOPASS2             = "Password is a required field.";
        const PASSNOMATCH         = "Passwords do not match.";
        const NOPRODUCTID         = "Product is a required field.";
        const NOLANG              = "Language is a required field.";
        const NODOB               = "Birthday is a required field.";
        const NOTABLE             = "A course table is required.";
        const NOCOURSE            = "A valid course is required.";
        const NOSTORE             = "A store number is required.";
        const NOLISCENSES         = "You do not have any licenses remaining for this course.";
        const EMAILNOMATCH        = "The student email addresses you entered do not match.";
        const NOADDRESS           = "Address is required in the state of Utah.";
        const NOGENDER            = "Gender is required in the state of Utah.";
        const NOCITY              = "Enter your city so we can determine your county.";
        const NOSTATE             = "State is required in the state of Utah.";
        const NOZIP               = "Zip is required in the state of Utah.";
        const NOPHONE             = "Phone is required in the state of Utah.";
        const NOWPHONE            = "Work phone is required in the state of Utah.";
        const NOINITIAL           = "Middle initial is required in the state of Utah.";
        const INVALIDADDRESS      = "The address is invalid.";
        const INVALIDADDRESS2     = "The apartment number or suite is invalid.";
        const INVALIDGENDER       = "The gender is invalid.";
        const INVALIDCITY         = "The city is invalid.";
        const INVALIDZIP          = "The zip code is invalid.";
        const INVALIDPHONE        = "The phone number is invalid.";
        const INVALIDINITIAL      = "The middle initial is invalid.";

        // INVALID FORM FIELD ERROR CONSTANTS
        const INVALIDFNAME        = "First Name can only contain letters.";
        const INVALIDLNAME        = "Last Name can only contain letters.";
        const INVALIDUSERNAME     = "Username can only contain letters and numbers.";
        const INVALIDPASSCHARS    = "Password can only contain letters and numbers.";
        const INVALIDEMAIL        = "Email format is invalid.";
        const INVALIDMANEMAIL     = "Managers email format is invalid.";
        const INVALIDPASS         = "Password is required.";
        const INVALIDPRODUCTID    = "That product does not exist.";
        const INVALIDPRODUCTIDFMT = "Product can only contain letters.";
        const INVALIDLANG         = "Language can only be English or Spanish.";
        const INVALIDLANGFMT      = "Language can only contain letters.";
        const INVALIDDOB          = "Birth day must be in the mm/dd/yyyy format.";
        const INVALIDSTOREFMT     = "Store numbers can consist of letters and numbers only.";
        const USEREXISTSERR       = "That username is already taken. Create a unique username [ie. test01a]";
        const INVALIDVOUCHERER    = "That voucher does not exist or has already been used.";
        const GENERALERROR        = "An error has occured. Please call techincal support. 888-826-5222.";

        // DELETE MESSAGE
        const DELETESUCCESSMSG    = "The following student was successfully deleted and a license has been added to your account:";
        const DELETESUBMSG        = "The following student was successfully deleted:";
        const DELETEERRMSG        = "The following student does not exist in the course you selected:";
        const DELETEINVALID       = "You cannot delete the student at this time. Please call techincal support. 888-826-5222.";
    
        // TABLE FIELDS           // User name, email, pass, first, last, admin email, date added, birthday
        const FIELDS              = "[UU],[UM],[UC],[NF],[NL],[UA],[DA],[DOB],[VER],[ES]";
        const DOBTABLES           = ['01D','09D','10D','11D','12D'];
        const FOODHANDTABLE       = "01D";
        const CORPACCOUNTS        = ["tj", "tjh", "tcoam", "tcoah", "ehcifh", "sunsetfm", "ddonut", "prifh", "nchotels", "gmi", "gcer", "entertainmentcruises", "ecmanagement", "bnd130"];

        const RECERTME            = 2; // ME Value for Recert table, 02D
        const FOODSAFEMANID       = 2;
        const OHLEVEL2MANAGER     = 179;
        const OHLEVEL2RECERT      = 182;
        const RETAILFOODSAFE      = 169;
        const FSMPROIDS           = array('2','179','182','169');
        const UTAHPROID           = 80; // ProductId for Utah Food Handler Training

        // LANGUAGES
        const ENGLISH             = "ENGLISH";
        const SPANISH             = "SPANISH";
        const ENGLISHX            = 0x456e676c697368;
        const SPANISHX            = 0x456e676c697368;

        const SUCCESS             = "Success";
        const FAILURE             = "Failure";

        // Class properties
        public $model             = null;
        public $admin             = null;
        public $firstname         = null;
        public $lastname          = null;
        public $username          = null;
        public $email             = null;
        public $password          = null;
        public $coursename        = null;
        public $productid         = null;
        public $tablecode         = null;
        public $language          = null;
        public $dob               = null;
        public $courselink        = null;
        public $scourselink       = null;
        private $studentcount     = null;
        private $storenum         = null;
        public $errorLog          = [];
        private $errfields        = [];
        private $errmsgs          = [];
        private $serial           = [];
        public $emailRequired     = false;
        public $dobRequired       = false;

        // UTAH Food Handler Training specific fields        
        public $address1          = null;
        public $address2          = null;
        public $zip               = null;
        public $state             = null;
        public $city              = null;
        public $phone             = null;
        public $workphone         = null;
        public $midinitial        = null;
        public $county            = null;
        public $gender            = null;


        public function __construct()
        {
            if(!isset($_SESSION))
		        session_start();

            $validator = new Helper();
            $this -> model = new StudentsModel();

            if(isset($_SESSION["unit"]))
                if(preg_match($validator::NUMBERONLY, $_SESSION["unit"]))
                    $this -> admin = "'".$_SESSION["unit"]."'";
                else
                    $this -> admin = $validator -> CleanAdmin($_SESSION["unit"]);
            else if(isset($_SESSION["Serial"]))
            {
                if(preg_match($validator::NUMBERONLY, $_SESSION["Serial"]["Admin"]))
                    $serial = $this -> admin = "'" .$_SESSION["Serial"]["Admin"] . "'" ;
                else
                    $serial = $this -> admin = $validator -> CleanAdmin($_SESSION["Serial"]["Admin"]);                
            }
            else if(isset($_SESSION["postpurchase"]))
            {
                if(preg_match($validator::NUMBERONLY, $_SESSION["user"]))
                    $this -> admin = "'".$_SESSION["user"]."'";
                else                
                    $buyer = $this -> admin = $validator -> CleanAdmin($_SESSION["user"]);
            }
            else
            {
                if(preg_match($validator::NUMBERONLY, $_SESSION["user"]))
                    $this -> admin = "'".$_SESSION["user"]."'";
                else
                    $this -> admin = $validator -> CleanAdmin($_SESSION["user"]);
            }
                
        }

        public function AddSingle()
        {
            // Determine which fields are required.
            $reqs = $this -> GetRequiredFields();

            // Validate the fields. Errors will be logged here.
            $validated = $this -> Validate();

            // Set the object properties.
            $this -> SetProps();
            // Convert all the values to hex code with the Sanitize function
            $values = $this -> Sanitize();

            if($this -> tablecode == '01D')
            {
                $region = $this -> model -> GetRegion($values['productid']);                
                $values['region'] = $region['Region'];
                if($values['region'] == '')
                    $values['region'] = null;
            }

            // This is where we handle license key usage
            // If its not a license key, check to see if the account has enough licenses to add a student.
            if(!isset($_SESSION['Serial']))
            {
                // Check for corporate accounts and discode accounts first.
                $isCorporate = $this -> model -> CheckCorporate($this -> admin);;
                if(!$isCorporate){
                    $lisccheck = $this -> CheckLisc($values["productid"]);                    
                }
                else if(isset($_SESSION['discode']))
                {
                    $discode = trim($_SESSION['discode']);
                    $key = array_search($discode, self::CORPACCOUNTS);
                    if($key !== false)
                        $lisccheck = 1;
                    else
                        $lisccheck = $this -> CheckLisc($values["productid"]);
                            if($lisccheck == 0)
                                $lisccheck = $this -> CheckCorpLisc($values["productid"],$isCorporate['SUB']);
                }
                else
                {
                    $lisccheck = $this -> CheckLisc($values["productid"]);
                    if($lisccheck == 0)
                        $lisccheck = $this -> CheckCorpLisc($values["productid"],$isCorporate['SUB']);
                }
            }
            else
            {
                // If its a license key, we will assume the license checks out for now.
                $lisccheck = 1;
                $_SESSION["TrainingLogin"] = 1;
            }
            if($lisccheck == -3)
            {
                // Check to see if the voucher is valid and not activated.
                $isVoucher = $this -> model -> GetVoucher($values['password'], $this -> admin);

                if(count($isVoucher) == 0)
                {
                    // The voucher is not valid so we have to return it back to the add student page.
                    $this -> ValidationError("voucher", self::INVALIDVOUCHERER);
                    $this -> StudentSession(null);
                    header("Location:/admin/tools/students/single");
                    exit;
                }

            }
            
            $isuser = false;

            // Look to see if this user exists already.
            $isuser = $this -> model -> CheckForExisting($values["username"], $this -> tablecode);
            if($isuser)
                $this -> userTaken();
            
            // Check DOB tables when required. Does not apply to allergen courses since the DOB table allows multiple user names.
            if(strlen($_POST['dob']) > 0 && trim($_POST['tablecode']) == "01D" && !in_array($_POST['productid'], self::FSMPROIDS))
            {
                $isuser = $this -> model -> CheckDobTable($values["username"]);
                if($isuser)
                    $this -> userTaken();
            }
            else if(strlen($_POST['dob']) > 0 && trim($_POST['tablecode']) == "12D")
            {
                $isuser = $this -> model -> CheckDobTable($values["username"]);
                if($isuser)
                    $this -> userTaken();
            }

            // Proceede to add the student and remove licenses if the post data is validated and there are enough licenses.
            if($validated && $lisccheck != 0 && !$isuser)
            {
                // Check for Utah Food Handler Training
                if($_POST['productid'] == self::UTAHPROID)
                {
                    $validated = $this -> ValidateUtah();
                    if($validated)
                    {
                        $this -> SetUtahProps();
                        $valuesUtah = $this -> SanitizeUtah();                        
                        unset($values['region']);
                        $utahCityInfo = $this -> model -> GetUtahRegion($valuesUtah['city']);
                        $values['region'] = $utahCityInfo['Region'];
                        $valuesUtah['county'] = $utahCityInfo['County'];
                        $studentadded = $this -> model -> AddStudentUtah($values, $valuesUtah);
                    }
                    
                }
                else
                {                    
                    // The user name does not exist, so add the new student to the database.
                    // Check for the 01D and 02D tables to get the ME or IL fields.
                    if($this -> tablecode == '01D')
                        $me = $this -> model -> GetMECode($values, $this -> tablecode);
                    else if($this -> tablecode == '02D')
                        $il = $this -> model -> GetILCode($values, $this -> tablecode);

                    if($reqs['dob'])
                        if(isset($me))
                            // Add to student login database.
                            $studentadded = $this -> model -> AddStudentME($values, $this -> tablecode, $me['JobType']);
                        else if($this -> tablecode == '12D')
                        {
                            $args = $this -> SetAlcoholArgs($values);
                            $studentadded = $this -> model -> AddStudentAlcohol($args);                               
                        }
                        else
                            $studentadded = $this -> model -> AddStudentDOB($values, $this -> tablecode);
                    else if(isset($il))
                    {   
                        // Add to student login database.
                        $expirationDate = $this -> FindExpDate($this -> admin);
                        $studentadded = $this -> model -> AddStudentIL($values, $this -> tablecode, self::RECERTME, $il['StuType'],$expirationDate);
                    }
                    else
                        if(isset($me))
                        {
                            // Find the expiration date from the admin table
                            $expirationDate = $this -> FindExpDate($this -> admin);
                            // Add to fsm student login database.
                            $studentadded = $this -> model -> AddStudentMEManager($values, $this -> tablecode, $me['JobType'], $expirationDate);
                        }                        
                        else if($this -> tablecode == '04D')
                            // Add to student HACCP login database.
                            $studentadded = $this -> model -> AddStudentVER($values, $this -> tablecode);
                        else if($this -> tablecode == '03D')
                        {
                            // Add to student HACCP login database.
                            $cfBool = $values["productid"] == 170 ? 1 : 0;
                            $studentadded = $this -> model -> AddStudentCBCF($values, $cfBool);
                        }
                        else
                            // Add to student login database.
                        $studentadded = $this -> model -> AddStudent($values, $this -> tablecode);
                }
                // As long as there are no errors..
                if($studentadded)
                {
                    // Creating a smaller variable to hold the table code for code readability.
                    /*$tc = $this -> tablecode;
                    // The following tables need to have the student info put into the 01C birthdate table.
                    if($tc == '01D' || $tc == '09D'|| $tc == '10D'|| $tc == '11D'|| $tc == '12D')
                        $this -> model -> SetDOB($values);*/

                    // Add student to allergen plan.
                    if($this -> tablecode == '09D')
                    {                            
                        $this -> model -> AddAllergenPlan($values['username']);
                    }
                    $this -> InitStudentProgress($values, $this -> tablecode);
                    // Reduce the number of licenses remaining or activate a license key or voucher.
                    if(isset($_SESSION["Serial"]))
                    {
                        // Activate the license key with the student name and a timestamp.
                        $date = new DateTime();
                        $timestamp = $date->format('m-d-Y h:m:s');
                        $this -> model -> ActivateLicense($_SESSION["Serial"]["LicenseKey"], $this -> admin, $values['username'], $timestamp);
                    }
                    else
                    {   // a -3 in the License table indicates the account in on a vocher system.
                        if($lisccheck == -3)
                        {
                            // If we get a voucher returned from the query, mark it as used with student name and timestamp.
                            $date = new DateTime();
                            $timestamp = $date->format('m-d-Y h:m:s');
                            $this -> model -> ActivateVoucher($values["password"],$values["username"],$timestamp);
                        }
                        else
                            // Reduce the number of remaining licenses by 1.
                            if(!$isCorporate)
                                $this -> model -> DeductLicense($values["productid"], $this -> admin);
                            else
                            {
                                $deducted = $this -> model -> DeductLicense($values["productid"], $this -> admin);
                                
                                if(!$deducted)
                                    $this -> model -> DeductCorpLicense($values["productid"], $isCorporate['SUB']);
                            }
                    }
                    // Set the argument to 1 to mark the insert query as a success.
                    $this -> StudentSession(1);
                    // Send the login link to the students email.
                    $mailer = new Mailer();
                    $mailer -> AddedToCouse($_POST);
                    $limit = $this -> model -> CheckLimit($this -> admin);

                    if($lisccheck > -1 && $limit['MINLIC'] > 0 && $limit['MINLIC'] >= $lisccheck)
                    {
                        $courseName = $this -> model -> LookupCourse($values["productid"]);

                        if($isCorporate)
                            $accountType = 'Corporate';
                        else
                            $accountType = 'Instructor';

                        $reorderInfo = array (
                            "type" => $accountType,
                            "user" => $_SESSION["user"],
                            "add" => $limit['REORDER'],
                            "course" => $courseName['ProductName'],
                            "min" => $limit['MINLIC'],
                            "remaining" => $lisccheck
                        );
                        $mailer -> SendLimitNote($reorderInfo);
                    }                        
                    // Redirect to the succes page.
                    header("Location:/admin/tools/students/success");
                    exit();
                }
                else
                {
                    // Something went wrong when adding a student. Log errors and POST vars and return to add student page.
                    $this -> ValidationError("unknown", self::GENERALERROR);
                    $this -> StudentSession(null);
                    header("Location:/admin/tools/students/single");
                    exit();
                }
            }
            else if(!$validated || $lisccheck == 0)
            {
                // Put the logged errors and POST vars into session and redirect back to the add student page.
                if($lisccheck == 0)
                {
                    $this -> ValidationError("license", self::NOLISCENSES);
                    $this -> StudentSession(null);
                }
                $this -> StudentSession();
                header("Location:/admin/tools/students/single");
                exit();
            }
        }

        public function AddMultiple()
        {
            // Determine which fields are required.
            $reqs = $this -> GetRequiredFields();

            $validated = $this -> ValidateMultiple();

            $this -> SetProps();

            $values = $this -> SanitizeExcel();

            if($this -> tablecode == '01D')
            {
                $region = $this -> model -> GetRegion($values['productid']);
                $values['region'] = $region['Region'];
            }

            // Check for corporate and discode accounts first.            
            $isCorporate = $this -> model -> CheckCorporate($this -> admin);

            if(!$isCorporate)
                $lisccheck = $this -> CheckLisc($values["productid"]);
            else if(isset($_SESSION['discode']))
            {
                $discode = trim($_SESSION['discode']);

                $key = array_search($discode, self::CORPACCOUNTS);
                if($key !== false)
                    $lisccheck = 1;
            }
            else
            {
                $lisccheck = $this -> CheckLisc($values["productid"]);
                if($lisccheck == 0)
                    $lisccheck = $this -> CheckCorpLisc($values["productid"],$isCorporate['SUB']);
            }
            
            if(count($this -> errorLog) == 0 && $lisccheck != 0)
            {
                $isuser = $this -> model -> CheckForExisting($values["username"], $this -> tablecode);
                if(strlen($_POST['dob']) > 0 && trim($_POST['tablecode']) == "01D" && !in_array($_POST['productid'], self::FSMPROIDS) && !isuser)
                    $isuser = $this -> model -> CheckDobTable($values["username"]);
                else if(strlen($_POST['dob']) > 0 && trim($_POST['tablecode']) == "12D" && !$isuser)
                    $isuser = $this -> model -> CheckDobTable($values["username"]);
                if(!$isuser)
                {
                    // The user name does not exist, so add the new student to the database.
                    // Check for the 01D and 02D tables to get the ME fields.                    
                    if($this -> tablecode == '01D')
                        $me = $this -> model -> GetMECode($values, $this -> tablecode);
                    else if($this -> tablecode == '02D')
                        $il = $this -> model -> GetILCode($values, $this -> tablecode);

                    if($reqs['dob'])
                        if(isset($me))
                            // Add to student login database.
                            $studentadded = $this -> model -> AddStudentME($values, $this -> tablecode, $me['JobType']);
                        else if($this -> tablecode == '12D')
                        {
                            $args = $this -> SetAlcoholArgs($values);
                            $studentadded = $this -> model -> AddStudentAlcohol($args);                               
                        }
                        else
                            $studentadded = $this -> model -> AddStudentDOB($values, $this -> tablecode, $me['JobType']);
                    else if(isset($il))
                    {
                        $expirationDate = $this -> FindExpDate($this -> admin);
                        // Add to student login database.
                        $studentadded = $this -> model -> AddStudentIL($values, $this -> tablecode, self::RECERTME,$il['StuType'],$expirationDate);
                    }
                    else
                        if(isset($me))
                        {
                            // Find the expiration date from the admin table
                            $expirationDate = $this -> FindExpDate($this -> admin);                            
                            // Add to fsm student login database.
                            $studentadded = $this -> model -> AddStudentMEManager($values, $this -> tablecode, $me['JobType'], $expirationDate);
                        }
                        else if($this -> tablecode == '04D')
                            // Add to student HACCP login database.
                            $studentadded = $this -> model -> AddStudentVER($values, $this -> tablecode);
                        else if($this -> tablecode == '03D')
                        {
                            // Add to student HACCP login database.
                            $cfBool = $values["productid"] == 170 ? 1 : 0;
                            $studentadded = $this -> model -> AddStudentCBCF($values, $cfBool);
                        }
                        else
                            // Add to student login database.
                            $studentadded = $this -> model -> AddStudent($values, $this -> tablecode);

                    // As long as there are no errors..
                    if($studentadded)
                    {
                        // Creating a smaller variable to hold the table code for code readability.
                        /*$tc = $this -> tablecode;
                        // The following tables need to have the student info put into the 01C birthdate table.
                        if($tc == '01D' || $tc == '09D'|| $tc == '10D'|| $tc == '11D'|| $tc == '12D')
                            $this -> model -> SetDOB($values);*/

                        // Add student to allergen plan.
                        if($this -> tablecode == '09D')
                        {                            
                            $this -> model -> AddAllergenPlan($values['username']);
                        }
                        $this -> InitStudentProgress($values, $this -> tablecode);
                        // Reduce the number of licenses remaining.
                        if($lisccheck == -3)
                        {
                            $isVoucher = $this -> model -> GetVoucher($values['password']);
                            if(count($isVoucher) > 0)
                            {
                                $date = new DateTime();
                                $timestamp = $date->format('m-d-Y h:m:s');
                                $this -> model -> ActivateVoucher($values["password"],$values["username"],$timestamp);
                                // Send the login link to the students email.
                                $mailer = new Mailer();
                                $mailer -> AddedToCouse($_POST);
                                return self::SUCCESS;
                                exit;
                            }
                            else
                            {
                                $this -> StudentSession(null);
                                $this -> ValidationError("voucher",self::INVALIDVOUCHERER);
                                return self::FAILURE;
                                exit;
                            }
                        }
                        else
                        {
                            // Reduce the number of remaining licenses by 1 for non corporate accounts.
                            if(!$isCorporate)
                            {
                                $this -> model -> DeductLicense($values["productid"], $this -> admin);
                                // Send the login link to the students email.
                                $mailer = new Mailer();
                                $mailer -> AddedToCouse($_POST);
                                return self::SUCCESS;
                                exit;
                            }
                            // Reduce the corporate account license pool by 1.
                            else
                            {
                                $deducted = $this -> model -> DeductLicense($values["productid"], $this -> admin);
                                
                                if(!$deducted)
                                    $this -> model -> DeductCorpLicense($values["productid"], $isCorporate['SUB']);

                                // Send the login link to the students email.
                                $mailer = new Mailer();
                                $mailer -> AddedToCouse($_POST);

                                return self::SUCCESS;
                                exit;
                            }
                        }
                    }
                }
                else if($isuser)
                {                    
                    // The user name already exists. Log errors and POST vars.
                    $this -> ValidationError("username", self::USEREXISTSERR);
                    $this -> StudentSession(null);
                    return $this -> errorLog;
                    exit;
                } 
            }
            else
            {
                if($lisccheck == 0)
                {
                    $this -> ValidationError("license", self::NOLISCENSES);
                    $this -> StudentSession(null);
                    return $_SESION['studentErrors'];
                }
                $this -> StudentSession(null);
                return self::FAILURE;
                exit;
            }
        }

        private function InitStudentProgress($values, $table)
        {
            //$ptable = str_replace('D','P', $table);
            //$this -> model -> SetProgressInit($values,$ptable);
            $stable = trim(str_replace('D','S', $_POST["tablecode"]));
            $this -> model -> SetScoreInit($values, $stable);
        }

        public function LoadExcel()
        {
            /* Include PHPExcel_IOFactory */
            require_once $_SERVER['DOCUMENT_ROOT'].'/lib/PHPExcel/Classes/PHPExcel/IOFactory.php';
            $admins = [];
            if(isset($_FILES["fileToUpload"]["name"])){
                $inputFileType = 'Excel2007';

                $target_dir = $_SERVER['DOCUMENT_ROOT']."/wwwroot/uploads/";
                $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);

                $objPHPExcel = PHPExcel_IOFactory::load($target_file);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);

                $worksheetData = $objReader->listWorksheetInfo($target_file);
                $data = $objPHPExcel->getActiveSheet()->getCell('B3')->getValue();

                $worksheetName = $worksheetData[0]["worksheetName"];
                $lastColLtr = $worksheetData[0]["lastColumnLetter"];
                $lastColIdx = $worksheetData[0]["lastColumnIndex"];
                $totalRows = $worksheetData[0]["totalRows"];
                $totalCols = $worksheetData[0]["totalColumns"];

                //start on 2nd row because the first row is the header info.
                $i = 2;
                $students = [];
                while($i <= $totalRows)
                {
                    $students[$i]["firstname"] = $objPHPExcel->getActiveSheet()->getCell('A'. $i)->getValue();
                    $students[$i]["lastname"] = $objPHPExcel->getActiveSheet()->getCell('B'. $i)->getValue();
                    $students[$i]["email"] = $objPHPExcel->getActiveSheet()->getCell('C'. $i)->getValue();
                    $students[$i]["adminemail"] = $objPHPExcel->getActiveSheet()->getCell('D'. $i)->getValue();
                    $students[$i]["username"] = $objPHPExcel->getActiveSheet()->getCell('E'. $i)->getValue();
                    $students[$i]["password"] = $objPHPExcel->getActiveSheet()->getCell('F'. $i)->getValue();
                    $students[$i]["lang"] = $objPHPExcel->getActiveSheet()->getCell('G'. $i)->getValue();
                    $dobInteger = $objPHPExcel->getActiveSheet()->getCell('H'. $i)->getValue();
                    $dob = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($dobInteger));
                    $students[$i]["dob"] = $dob;
                    array_push($admins, $students[$i]["adminemail"]);
                    $i++;                    
                }
            }

            $this -> studentcount = count($students);

            return $students;
        }

        public function Delete()
        {
            $sanitizer = new Helper();
            // *** THESE ARE THE TABLES WHERE THE STUDENT'S INFORMATION WILL BE DELETED
            // FSM AND HANDLERS
            $course = $this -> LookupCourse($_POST["productid"]);

            // RE-CERTIFICATION
            if($course["ProID"] == "refs" || $course["ProID"] == 'rewi'){
                $tables = array( "02S", "02A", "02P", "02D");
            }
            //COOKING BASICS
            else if($course["ProID"] == "cb"){
                $tables = array( "03S", "03A01", "03A02", "03A03", "03A04", "03A05", "03A06", "03A07", "03A08", "03A09", "03A10", "03A11", "03A12", "03A13", "03A14", "03A15", "03A16", "03A17", "03A18", "03A19", "03P", "03D");	
            }
            // HACCP
            else if($course["ProID"] == "nhaccp"){
                $tables = array( "04S","04P","04A","04D");
            }
            // STRATEGIES FOR INCREASING SALES
            else if($course["ProID"] == "sfis"){
                $tables = array("05F01","05S","05F02","05F03","05A01","05A02","05A03","05A04","05A05","05A06","05A07","05A08","05A09","05A10","05A11","05A12","05A13","05A14","05A15","05A16","05A17","05A18","05P","05F04","05F05","05F06","05F07","05F08","05F09","05F10","05F11","05F12","05F13","05F14","05F15","05F16","05F17","05F18","05F19","05F20","05F21","05F22","05F23","05F24","05F25","05F26","05F27","05F28","05F29","05F30","05F31","05F32","05F33","05F34","05F35","05F36","05F37","05F38","05F39","05F40","05F41","05D","05F42");	
            }
            // EARN MORE WITH SERVICE
            else if($course["ProID"] == "emws"){
                $tables = array( "06P","06D");
            }
            // ALLERGEN AWARENESS
            else if($course["ProID"] == "aa"){
                $tables = array( "09S","09A","09P","09D", "AllergenDob");
            }
            // ALLERGEN DEVELOPMENT
            else if($course["ProID"] == "ad"){
                $tables = array("10S","10A","10P","10D", "AllergenDob");
            }
            // ALLERGEN SPECIALIST
            else if($course["ProID"] == "as"){
                $tables = array("11S","11A","11P","11D", "AllergenDob");
            }
            else{
                $tables = array( "01S", "01A", "01P", "01D");
            }
            if(is_numeric($_POST["uname"]))
                $studentname = "'" . $_POST["uname"] . "'";
            else
                $studentName = $sanitizer -> mssql_escape($_POST["uname"]);

            // Check to see if student is in the course in the first place.
            $isincourse = $this -> model -> IsStudentInCourse($studentName, $course["TableCode"]);
            // Check the warranty status before deleting the student from the table.
            $underwarranty = $this -> model -> CheckLiscWarranty(trim($studentName), trim($course["TableCode"]));

            // ******* THIS CODE DELETES THE STUDENT'S INFORMATION FROM ALL THE TABLES (DATABASE)
            if($isincourse && $underwarranty)
            {
                $this -> model -> DeleteStudentCourseData($tables,$studentName);

                //******** THE CODE BELOW CHECKS HOW MANY LICENSES THE ACCOUNT HAD BEFORE AND INCREASES IT BY ONE
                $this -> RefundLicense($_POST["productid"]);
                $_SESSION["delete"]["success"] = self::DELETESUCCESSMSG;
                $_SESSION["delete"]["studentun"] = $_POST["uname"];
                header("Location:/admin/tools/students/delete");
                exit();
            }
            else if(!$underwarranty)
            {
                $_SESSION["delete"]["failure"] = self::DELETEINVALID;
                header("Location:/admin/tools/students/delete");
                unset($_POST);
                exit();
            }
            else if(!$isincourse)
            {
                $_SESSION["delete"]["failure"] = self::DELETEERRMSG;
                header("Location:/admin/tools/students/delete");
                unset($_POST);
                exit();
            }
        }

        public function CourseList()
        {
            if(!isset($_SESSION))
		        session_start();

            unset($_SESSION["courselist"]);

            // Return this list to be displayed in a select on the page.
            $list = $this -> model -> GetCourseList($this -> admin);

            $isCorporate = $this -> model -> CheckCorporate($this -> admin);
            // Check the license table for a corporate account.
            if(!$isCorporate)
            {
                $_SESSION["courselist"] = $list;
                return $list;
            }                
            else
            {
                $clist = $this -> model -> GetCourseList("'".$isCorporate['SUB']."'");

                if(!isset($clist[0]['id']))
                {
                    $temp = $clist;
                    unset($clist);
                    $clist = '';
                    $clist[0] = $temp;
                    unset($temp);
                }
                
                if(count($list) > 0)
                {
                    if(!isset($list[0]['id']))
                    {
                        $temp = $list;
                        unset($list);
                        $list = '';
                        $list[0] = $temp;
                        unset($temp);
                    }

                    $clist = $this -> FilterCorporateList($clist, $list);                    
                    $newCorpList = array_merge($list, $clist);
                    $_SESSION["courselist"] = $clist;
                    return $clist;
                }
                else
                {
                    $_SESSION["courselist"] = $clist;                    
                    return $clist;
                }
            }
        }

        public function CorpCourseList($discode)
        {
            $courseList = [];
            switch ($discode) {
                case 'tj':                
                    $courseIdList = ["2"];
                    for($i = 0; $i < count($courseIdList); $i++)
                    {
                        $courseInfo = $this -> model -> GetCorpCourse($courseIdList[$i]);
                        $course = Array(
                            "ProductName" => $courseInfo["ProductName"],
                            "id" => $courseIdList[$i],
                            "LicensesRemaining" => "-1"
                        );
                        array_push($courseList, $course);
                    }                    
                    break;
                case 'tjh':
                    $courseIdList = ["166","163","16","75","19","162","164","24","21","79","80","68","76","3","18"];
                    for($i = 0; $i < count($courseIdList); $i++)
                    {
                        $courseInfo = $this -> model -> GetCorpCourse($courseIdList[$i]);
                        $course = Array(
                            "ProductName" => $courseInfo["ProductName"],
                            "id" => $courseIdList[$i],
                            "LicensesRemaining" => "-1"
                        );
                        array_push($courseList, $course);
                    }
                    break;
                case 'tcoam':                    
                    $courseIdList = ["2","180","181","179"];
                    for($i = 0; $i < count($courseIdList); $i++)
                    {
                        $courseInfo = $this -> model -> GetCorpCourse($courseIdList[$i]);
                        $course = Array(
                            "ProductName" => $courseInfo["ProductName"],
                            "id" => $courseIdList[$i],
                            "LicensesRemaining" => "-1"
                        );                        
                        array_push($courseList, $course);
                    }  
                    break;
                case 'tcoah':
                    $courseIdList = ["166","163","16","75","19","162","164","24","21","79","80","68","76","3", "18"];
                    for($i = 0; $i < count($courseIdList); $i++)
                    {
                        $courseInfo = $this -> model -> GetCorpCourse($courseIdList[$i]);
                        $course = Array(
                            "ProductName" => $courseInfo["ProductName"],
                            "id" => $courseIdList[$i],
                            "LicensesRemaining" => "-1"
                        );
                        array_push($courseList, $course);
                    }
                    break;
            }
            
            return $courseList;
        }

        public function FullCourseList()
        {
            // Return this list to be displayed in a select on the page.
            return $this -> model -> GetFullCourseList();
        }

        private function LookupCourse($productid)
        {
            // Find the "ProID" by the "id".
            $sql = "SELECT [ProID], [TableCode] ";
            $sql .= "FROM [07DS2] ";
            $sql .= "WHERE [id] = " . $productid;
            $course = $this -> RunQuery($sql);

            return $course;
        }

        public function GetCourseData()
        {
            if(isset($_SESSION['Serial']))
                $sql = "SELECT [id],[ProductName],[SpanishAvai],[TableCode],[CourseLink],[SCourseLink] FROM [07DS2] WHERE [id] = " . $_SESSION['Serial']['ProductId'];
            else if(isset($_SESSION['postpurchase']))
                $sql = "SELECT [id],[ProductName],[SpanishAvai],[TableCode],[CourseLink],[SCourseLink] FROM [07DS2] WHERE [ProID] = '" . $_SESSION['ProID'] . "'";
            else if(isset($_SESSION['studentErrors']))
                $sql = "SELECT [id],[ProductName],[SpanishAvai],[TableCode],[CourseLink],[SCourseLink] FROM [07DS2] WHERE [id] = " . $_SESSION['student']['productid'];
            else
                $sql = "SELECT [id],[ProductName],[SpanishAvai],[TableCode],[CourseLink],[SCourseLink] FROM [07DS2] WHERE [id] = " . $_POST['productid'];

            $course = $this -> RunQuery($sql);

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

        public function GetCourseLanguages()
        {
            $sql = "SELECT [SpanishAvai] FROM [07DS2] WHERE [id] = " . $_POST['productid'];
            $langs = $this -> RunQuery($sql);
            return $langs;
        }

        public function GetProductId($proId)
        {
            $sql = "SELECT [id] FROM [07DS2] WHERE [ProID] = '" . $proId ."'";
            $id = $this -> RunQuery($sql);
            return $id;
        }

        public function CheckStoreNum()
        {
            if(isset($_SESSION['admintable']))
            {
                $userCol = $_SESSION['admintable'] == '07L2' ? 'UU' : 'AN';
                $admininfo = $this -> model -> GetStoreNum($_SESSION['user'],$_SESSION['admintable'],$userCol);

                return $storeNumSet = $admininfo['FRANCHISESET'] > 0 ? true: false;
            }
            else
            {
                return false;
            }
        }

        public function CheckDobRequired($productId = null)
        {
            $dobTables = ['01D','09D','10D','11D','12D'];
            if(!isset($productId))
                $productId = $_POST['productid'];
            $type = 'productId';
            $product = $this -> model -> GetTableCode($productId, $type);

            if($productId == self::FOODSAFEMANID || $productId == self::OHLEVEL2RECERT || $productId == self::OHLEVEL2MANAGER || $productId == self::RETAILFOODSAFE)
                return false;
            else if(in_array(trim($product['TABLECODE']),$dobTables))
                return true;
            else
                return false;
        }

        public function SpanishAvailable($productId = null)
        {
            if(!isset($productId))
                $productId = $_POST['productid'];
            $available = $this -> model -> GetSpanishAvailable($productId);
            
            if($available['SpanishAvai'] == 1)
                return true;
            else if($available['SpanishAvai'] == 0)
                return false;
        }

        private function DeductLicense($proid)
        {
            $sql = "SELECT [LicensesRemaining] FROM [Licenses] WHERE [ProductId] = " . $proid . " AND [UserId] = " . $this -> admin;
            $remaining = $this -> RunQuery($sql);

            if($remaining["LicensesRemaining"] > 0)
            {
                $newtotal = $remaining["LicensesRemaining"] - 1;
                $sql = "UPDATE [Licenses] SET [LicensesRemaining] = " . $newtotal . " WHERE [ProductId] = " . $proid . " AND [UserId] = " . $this -> admin;
                $this -> RunInsert($sql);
            }
        }

        private function RefundLicense($proid)
        {
            $sql = "SELECT [LicensesRemaining] FROM [Licenses] WHERE [ProductId] = " . $proid . " AND [UserId] = " . $this -> admin;
            $remaining = $this -> RunQuery($sql);

            if($remaining["LicensesRemaining"] >= 0)
            {
                $newtotal = $remaining["LicensesRemaining"] + 1;
                $sql = "UPDATE [Licenses] SET [LicensesRemaining] = " . $newtotal . " WHERE [ProductId] = " . $proid . " AND [UserId] = " . $this -> admin;
                $this -> RunInsert($sql);
            }
        }

        private function IsStudentInCourse($student,$table)
        {
            $sql = "SELECT * FROM [". $table ."] WHERE [UU] = '".$student."'";
            $result = $this -> RunQuery($sql);
            return $result > 1 ? true : false;
        }

        private function DeleteStudentCourseData($tables)
        {
            foreach ($tables as $table) {
                
                $sql = "DELETE
                        FROM [$table]
                        WHERE UU = '" . $_POST["uname"]. "'";

                $this -> RunQuery($sql);
            }
        }

        private function CheckLisc($proid)
        {
            $sql = "SELECT [LicensesRemaining] FROM [Licenses] WHERE [ProductId] = " . $proid . " AND [UserId] = " . $this -> admin;

            $remaining = $this -> RunQuery($sql);
            if(!isset($remaining["LicensesRemaining"]))
                return 0;
            if($remaining["LicensesRemaining"] == 0)
                return 0;
            else
                return $remaining["LicensesRemaining"];
        }

        private function CheckCorpLisc($proid, $cadmin)
        {
            $sql = "SELECT [LicensesRemaining] FROM [Licenses] WHERE [ProductId] = " . $proid . " AND [UserId] = '".$cadmin."'";

            $remaining = $this -> RunQuery($sql);

            if(!isset($remaining["LicensesRemaining"]))
                return 0;
            else if($remaining["LicensesRemaining"] == 0)
                return 0;
            else
                return $remaining["LicensesRemaining"];
        }

        private function CheckLiscWarranty($student, $table)
        {
            $sql = "SELECT [DA] FROM [" . $table . "] WHERE [DS] IS NULL AND [UU] = '" . $student . "'";
            $warranty = $this -> RunQuery($sql);

            $today = date('Y-m-d');
            $today = new DateTime($today);
            $refund = new DateTime($warranty["DA"]);
            $refund -> add(new DateInterval('P31D'));

            return $today -> getTimestamp() < $refund -> getTimestamp() ? true : false;
        }

        private function CheckVoucher($voucherCode)
        {
            return $this -> model -> GetVoucher($voucherCode);
        }

        private function RunQuery($sql, $kill = 0)
        {
            $conn = Db::getInstance();

            $response = [];

            $stmt = mssql_query ( $sql , $conn );
            
            if( gettype($stmt) != "boolean" )
            {
                while($row = mssql_fetch_assoc($stmt))
                {
                    array_push($response, $row);
                    if($kill == 2)
                        die(var_dump($response));
                }
            }
            else
            {
               // Error 
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

        private function Validate()
        {
            //Sanitize the POST data
            $validator = new Helper();

            //Check to see if the form fields have data. They cannot be blank.
            $validated = isset($_POST["firstname"])   ? true : $this -> ValidationError("firstname",self::NOFNAME);

            if($validated)
                $validated = isset($_POST["lastname"])    ? true : $this -> ValidationError("lastname",self::NOLNAME);
            else
                $validated = isset($_POST["lastname"])    ? false : $this -> ValidationError("lastname",self::NOLNAME);
            
            if($validated && $this -> emailRequired)
                $validated = isset($_POST["email"])       ? true : $this -> ValidationError("email",self::NOEMAIL);
            else
                $validated = isset($_POST["email"])       ? false : $this -> ValidationError("email",self::NOEMAIL);

            if($validated)
                $validated = isset($_POST["username"])    ? true : $this -> ValidationError("username",self::NOUSERNAME);
            else
                $validated = isset($_POST["username"])    ? false : $this -> ValidationError("username",self::NOUSERNAME);

            if($validated)
                $validated = isset($_POST["password"])    ? true : $this -> ValidationError("password",self::NOPASS1);
            else
                $validated = isset($_POST["password"])    ? false : $this -> ValidationError("password",self::NOPASS1);

            if($validated)
                $validated = isset($_POST["pass2"])       ? true : $this -> ValidationError("pass2",self::NOPASS2);
            else
                $validated = isset($_POST["pass2"])       ? false : $this -> ValidationError("pass2",self::NOPASS2);

            if($validated)
                $validated = isset($_POST["productid"])   ? true : $this -> ValidationError("productid",self::NOPRODUCTID);
            else
                $validated = isset($_POST["productid"])   ? false : $this -> ValidationError("productid",self::NOPRODUCTID);

            if($validated)
                $validated = isset($_POST["lang"])        ? true : $this -> ValidationError("lang",self::NOLANG);
            else
                $validated = isset($_POST["lang"])        ? false : $this -> ValidationError("lang",self::NOLANG);

            if($validated)
                $validated = isset($_POST["tablecode"])   ? true : $this -> ValidationError("tablecode",self::NOTABLE);
            else
                $validated = isset($_POST["tablecode"])   ? false : $this -> ValidationError("tablecode",self::NOTABLE);

            if($validated)
                $validated = isset($_POST["courselink"])  ? true : $this -> ValidationError("courselink",self::NOCOURSE);
            else
                $validated = isset($_POST["courselink"])  ? false : $this -> ValidationError("courselink",self::NOCOURSE);

            //if($validated)
                $hasStoreN = isset($_POST["storenum"])    ? true : false;
            //else
                //$hasStoreN = isset($_POST["storenum"])    ? false : false;
            
            // Store number is optional / not available for all users. If the user cannot use store numbers, no input
            // will be displayed on the form, so the $_POST wont be set.
            if($hasStoreN)
                $validated = strlen($_POST["storenum"]) > 1   ? true : $this -> ValidationError("storenum",self::NOSTORE);

            // Handle the date input by combining the three selects, formatting them and putting them into $_POST.
            $_POST["dob"] = 0;

            if(isset($_POST["month"]) && isset($_POST["day"]) && isset($_POST["year"]))
            {
                if($_POST["month"] == "Month" || $_POST["day"] == "Day" || $_POST["year"] == "Year")
                    $this -> ValidationError("dob",self::NODOB);
                else
                {
                    $date = new DateTime($_POST["month"] . "/" . $_POST["day"] . "/" . $_POST["year"]);
                    $dob = $date->format('m-d-Y');
                    $_POST["dob"] = $dob;
                }
            }

            //Check for matching passwords.
            if($validated)
                $validated = $_POST["password"] == $_POST["pass2"]                     ? true : $this -> ValidationError("password",self::PASSNOMATCH);
            else
                $validated = $_POST["password"] == $_POST["pass2"]                     ? false : $this -> ValidationError("password",self::PASSNOMATCH);

            //Check for matching emails. We only need to do this 
            if(strlen($_POST["email"]) > 0)
            {
                if($validated)
                    $validated = $_POST["email"] == $_POST["confirmemail"]                     ? true : $this -> ValidationError("email",self::EMAILNOMATCH);
                else
                    $validated = $_POST["email"] == $_POST["confirmemail"]                     ? false : $this -> ValidationError("email",self::EMAILNOMATCH);
            }            

            //Test the data using regular expressions to make sure we are getting the expected data type.
            if($validated)
                $validated = preg_match($validator::NAMECHARS, $_POST["firstname"])      ? true : $this -> ValidationError("firstname",self::INVALIDFNAME);
            else
                $validated = preg_match($validator::NAMECHARS, $_POST["firstname"])      ? false : $this -> ValidationError("firstname",self::INVALIDFNAME);

            if($validated)
                $validated = preg_match($validator::NAMECHARS, $_POST["lastname"])       ? true : $this -> ValidationError("lastname",self::INVALIDLNAME);
            else
                $validated = preg_match($validator::NAMECHARS, $_POST["lastname"])       ? false : $this -> ValidationError("lastname",self::INVALIDLNAME);
            
            if($validated)
                $validated = preg_match($validator::LETNUMREGEX, $_POST["username"])     ? true : $this -> ValidationError("username",self::INVALIDUSERNAME);
            else
                $validated = preg_match($validator::LETNUMREGEX, $_POST["username"])     ? false : $this -> ValidationError("username",self::INVALIDUSERNAME);

            if($validated)
                $validated = preg_match($validator::LETNUMREGEX, $_POST["password"])     ? true : $this -> ValidationError("password",self::INVALIDPASSCHARS);
            else
                $validated = preg_match($validator::LETNUMREGEX, $_POST["password"])     ? false : $this -> ValidationError("password",self::INVALIDPASSCHARS);

            if($validated)
                $validated = strpos($_POST["username"], '/') === FALSE ? true : $this -> ValidationError("username",self::INVALIDUSERNAME);
            else
                $validated = strpos($_POST["username"], '/') === FALSE ? false : $this -> ValidationError("username",self::INVALIDUSERNAME);

            if($validated && $this -> emailRequired)
                $validated = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL)      ? true : $this -> ValidationError("email",self::INVALIDEMAIL);
            else if($this -> emailRequired)
                $validated = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL)      ? false : $this -> ValidationError("email",self::INVALIDEMAIL);

            if(count($_POST["adminemail"]) > 5)
            {
                if($validated)
                    $validated = filter_input(INPUT_POST, "adminemail", FILTER_VALIDATE_EMAIL) ? true : $this -> ValidationError("adminemail",self::INVALIDMANEMAIL);
                else
                    $validated = filter_input(INPUT_POST, "adminemail", FILTER_VALIDATE_EMAIL) ? false : $this -> ValidationError("adminemail",self::INVALIDMANEMAIL);
            }            

            if($validated)        
                $validated = preg_match($validator::LETNUMREGEX, $_POST["productid"])      ? true : $this -> ValidationError("productid",self::INVALIDPRODUCTIDFMT);
            else
                $validated = preg_match($validator::LETNUMREGEX, $_POST["productid"])      ? false : $this -> ValidationError("productid",self::INVALIDPRODUCTIDFMT);

            if($validated)            
                $validated = preg_match($validator::LETNUMREGEX, $_POST["lang"])           ? true : $this -> ValidationError("lang",self::INVALIDLANGFMT);
            else
                $validated = preg_match($validator::LETNUMREGEX, $_POST["lang"])           ? false : $this -> ValidationError("lang",self::INVALIDLANGFMT);
            
            if($validated)
                if($hasStoreN)
                    $validated = preg_match($validator::LETNUMREGEX, $_POST["storenum"])   ? true : $this -> ValidationError("storenum",self::INVALIDSTOREFMT);
            else
                if($hasStoreN)
                    $validated = preg_match($validator::LETNUMREGEX, $_POST["storenum"])   ? false : $this -> ValidationError("storenum",self::INVALIDSTOREFMT);
            
            if(count($this -> errorLog) > 0)
                return false;
            else
                return true;
        }

        private function ValidateMultiple()
        {
            //Sanitize the POST data
            $validator = new Helper();            

            //Check to see if the form fields have data. They cannot be blank.
            $validated = isset($_POST["firstname"])   ? true : $this -> ValidationError("firstname",self::NOFNAME);

            if($validated)
                $validated = isset($_POST["lastname"])    ? true : $this -> ValidationError("lastname",self::NOLNAME);
            else
                $validated = isset($_POST["lastname"])    ? false : $this -> ValidationError("lastname",self::NOLNAME);
            
            if($validated && $this -> emailRequired)
                $validated = isset($_POST["email"])       ? true : $this -> ValidationError("email",self::NOEMAIL);
            else if($this -> emailRequired)
                $validated = isset($_POST["email"])       ? false : $this -> ValidationError("email",self::NOEMAIL);

            if($validated)
                $validated = isset($_POST["username"])    ? true : $this -> ValidationError("username",self::NOUSERNAME);
            else
                $validated = isset($_POST["username"])    ? false : $this -> ValidationError("username",self::NOUSERNAME);

            if($validated)
                $validated = isset($_POST["password"])    ? true : $this -> ValidationError("password",self::NOPASS1);
            else
                $validated = isset($_POST["password"])    ? false : $this -> ValidationError("password",self::NOPASS1);

            if($validated)
                $validated = isset($_POST["productid"])   ? true : $this -> ValidationError("productid",self::NOPRODUCTID);
            else
                $validated = isset($_POST["productid"])   ? false : $this -> ValidationError("productid",self::NOPRODUCTID);

            if($validated)
                $validated = isset($_POST["lang"])        ? true : $this -> ValidationError("lang",self::NOLANG);
            else
                $validated = isset($_POST["lang"])        ? false : $this -> ValidationError("lang",self::NOLANG);

            if($validated)
                $validated = isset($_POST["tablecode"])   ? true : $this -> ValidationError("tablecode",self::NOTABLE);
            else
                $validated = isset($_POST["tablecode"])   ? false : $this -> ValidationError("tablecode",self::NOTABLE);

            if($validated)
                $validated = isset($_POST["courselink"])  ? true : $this -> ValidationError("courselink",self::NOCOURSE);
            else
                $validated = isset($_POST["courselink"])  ? false : $this -> ValidationError("courselink",self::NOCOURSE);

            if($validated && $this -> dobRequired)
                $validated = strlen($_POST["dob"]) >= 10   ? true : $this -> ValidationError("dob",self::NODOB);
            
            if($validated)
                $hasStoreN = isset($_POST["storenum"])    ? true : false;
            else
                $hasStoreN = isset($_POST["storenum"])    ? false : false;

            // Excel will not need to validate the passwords and email address against eachother.
            if(trim(strtoupper($_POST["formtype"])) != 'EXCEL')
            {                
                // Check for matching emails and passwords.
                if($validated)
                {
                    if(strlen($_POST["email"]) > 0)
                    {
                        $validated = $_POST["email"] == $_POST["email2"] ? true : $this -> ValidationError("email",self::EMAILNOMATCH);;
                    }
                    $validated = $_POST["password"] == $_POST["password2"] ? true : $this -> ValidationError("password",self::PASSNOMATCH);
                }
                else
                {
                    if(strlen($_POST["email"]) > 0)
                    {
                        $validated = $_POST["email"] == $_POST["email2"] ? true : $this -> ValidationError("email",self::EMAILNOMATCH);;
                    }
                    $validated = $_POST["password"] == $_POST["password2"] ? true : $this -> ValidationError("password",self::PASSNOMATCH);
                }
            }
            
            // Store number is optional / not available for all users. If the user cannot use store numbers, no input
            // will be displayed on the form, so the $_POST wont be set.
            if($hasStoreN)
                $validated = strlen($_POST["storenum"]) > 1   ? true : $this -> ValidationError("storenum",self::NOSTORE);

            //Test the data using regular expressions to make sure we are getting the expected data type.
            if($validated)
                $validated = preg_match($validator::NAMECHARS, $_POST["firstname"])      ? true : $this -> ValidationError("firstname",self::INVALIDFNAME);
            else
                $validated = preg_match($validator::NAMECHARS, $_POST["firstname"])      ? false : $this -> ValidationError("firstname",self::INVALIDFNAME);

            if($validated)
                $validated = preg_match($validator::NAMECHARS, $_POST["lastname"])       ? true : $this -> ValidationError("lastname",self::INVALIDLNAME);
            else
                $validated = preg_match($validator::NAMECHARS, $_POST["lastname"])       ? false : $this -> ValidationError("lastname",self::INVALIDLNAME);
            
            if($validated)
                $validated = preg_match($validator::PASSWORDCHARS, $_POST["username"])     ? true : $this -> ValidationError("username",self::INVALIDUSERNAME);
            else
                $validated = preg_match($validator::PASSWORDCHARS, $_POST["username"])     ? false : $this -> ValidationError("username",self::INVALIDUSERNAME);

            if($validated)
                $validated = strpos($_POST["username"], '/') === FALSE ? true : $this -> ValidationError("username",self::INVALIDUSERNAME);
            else
                $validated = strpos($_POST["username"], '/') === FALSE ? false : $this -> ValidationError("username",self::INVALIDUSERNAME);

            if($validated)
                $validated = preg_match($validator::PASSWORDCHARS, $_POST["password"])     ? true : $this -> ValidationError("password",self::INVALIDPASS);
            else
                $validated = preg_match($validator::PASSWORDCHARS, $_POST["password"])     ? false : $this -> ValidationError("password",self::INVALIDPASS);

            if($validated && $this -> emailRequired)
                $validated = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL)      ? true : $this -> ValidationError("email",self::INVALIDEMAIL);
            else if($this -> emailRequired)
                $validated = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL)      ? false : $this -> ValidationError("email",self::INVALIDEMAIL);

            if(count($_POST["adminemail"]) > 5)
            {
                if($validated)
                    $validated = filter_input(INPUT_POST, "adminemail", FILTER_VALIDATE_EMAIL) ? true : $this -> ValidationError("email",self::INVALIDEMAIL);
                else
                    $validated = filter_input(INPUT_POST, "adminemail", FILTER_VALIDATE_EMAIL) ? false : $this -> ValidationError("email",self::INVALIDEMAIL);
            }

            //Check for matching emails. We only need to do this 
            /*if(strlen($_POST["email"]) > 0)
            {
                if($validated)
                    $validated = $_POST["email"] == $_POST["confirmemail"]                     ? true : $this -> ValidationError("email",self::EMAILNOMATCH);
                else
                    $validated = $_POST["email"] == $_POST["confirmemail"]                     ? false : $this -> ValidationError("email",self::EMAILNOMATCH);
            }*/ 

            if($validated && $this -> dobRequired)
            {
                $validated = strlen($_POST["dob"]) == 10   ? true : $this -> ValidationError("dob",self::NODOB);
            }                

            if($validated)        
                $validated = preg_match($validator::LETNUMREGEX, $_POST["productid"])      ? true : $this -> ValidationError("productid",self::INVALIDPRODUCTIDFMT);
            else
                $validated = preg_match($validator::LETNUMREGEX, $_POST["productid"])      ? false : $this -> ValidationError("productid",self::INVALIDPRODUCTIDFMT);

            if($validated)            
                $validated = preg_match($validator::LETNUMREGEX, $_POST["lang"])           ? true : $this -> ValidationError("lang",self::INVALIDLANGFMT);
            else
                $validated = preg_match($validator::LETNUMREGEX, $_POST["lang"])           ? false : $this -> ValidationError("lang",self::INVALIDLANGFMT);
            
            if($validated)
                if($hasStoreN)
                    $validated = preg_match($validator::LETNUMREGEX, $_POST["storenum"])   ? true : $this -> ValidationError("storenum",self::INVALIDSTOREFMT);
            else
                if($hasStoreN)
                    $validated = preg_match($validator::LETNUMREGEX, $_POST["storenum"])   ? false : $this -> ValidationError("storenum",self::INVALIDSTOREFMT);
            
            if(count($this -> errorLog) > 0)
                return false;
            else
                return true;
        }

        private function ValidationError($field,$err)
        {
            $log = Array($field => $err);
            array_push($this -> errorLog, $log);
            return false;
        }

        private function StudentSession($success = null)
        {
            if(!isset($_SESSION))
		        session_start();

            $_SESSION["student"] = [];
            $_SESSION["studentErrors"] = [];

            if(isset($success))
                $_SESSION["student"]["success"] = $success;
            else
            {
                //$_SESSION["student"]["errors"] = [];

                if(isset($err))
                    array_push($this -> errorLog, $err);

                if(count($this -> errorLog) > 0)
                {
                    //$sessionErrors = Array("errors", $this -> errorLog);
                    array_push($_SESSION["studentErrors"], $this -> errorLog);
                    //die(var_dump($this -> errorLog));
                }
            }

            // Set all the student information in this session.
            $_SESSION["student"]["firstname"] = $this -> firstname;
            $_SESSION["student"]["lastname"] = $this -> lastname;
            $_SESSION["student"]["username"] = $this -> username;
            $_SESSION["student"]["email"] = $this -> email;
            $_SESSION["student"]["password"] = $this -> password;
            $_SESSION["student"]["coursename"] = $this -> coursename;
            $_SESSION["student"]["productid"] = $this -> productid;
            $_SESSION["student"]["language"] = $this -> language;
            $_SESSION["student"]["dob"] = $this -> dob;
            $_SESSION["student"]["tablecode"] = $this -> tablecode;
            $_SESSION["student"]["courselink"] = $this -> courselink;

            if(count($this -> adminemail) > 0)
                $_SESSION["student"]["adminemail"] = $this -> adminemail;

            if(isset($_POST["storenum"]))
                if(count($_POST["storenum"]) > 0)
                        $_SESSION["student"]["storenum"] = $this -> storenum;

            /*if(count($this -> errfields) == 1)
            {
                $key = $this -> errfields[0];
                unset($_SESSION["student"][$key]);
            }
            if(count($this -> errfields) > 1)
            {
                for($i = 0; $i < count($this -> errfields); $i++) 
                {
                    // Iterate over erroneous fields and unset their session.
                    $key = $this -> errfields[$i];
                    unset($_SESSION["student"][$key]);
                }
            }*/            
        }

        private function SetProps()
        {
            if(isset($_POST['year']) && isset($_POST['month']) && isset($_POST['day']))
            {
                $dates = Array($_POST['year'],$_POST['month'],$_POST['day']);
                $dob = join("-", $dates);
            }
            else
            {
                $dob = trim($_POST["dob"]);
            }                

            $this -> firstname  = trim($_POST["firstname"]);
            $this -> lastname   = trim($_POST["lastname"]);
            $this -> username   = trim($_POST["username"]);
            $this -> email      = trim($_POST["email"]);
            $this -> password   = trim($_POST["password"]);
            $this -> coursename = trim($_POST["coursename"]);
            $this -> productid  = trim($_POST["productid"]);
            $this -> dob        = $dob;
            $this -> tablecode  = trim($_POST["tablecode"]);
            $this -> courselink = strtoupper(trim($_POST["courselink"]));



            if($this -> courselink == 'DEMOFULL' || $this -> courselink == 'FS9H' || $this -> courselink == 'FS9R' 
            || $this -> courselink == 'FS9HG' || $this -> courselink == 'FS9HAK' || $this -> courselink == 'FS9HAKNEW3')
                $this -> courselink = 'FS9';
            else if($this -> courselink == 'FSHUT' || $this -> courselink == 'FSHUNI')
                $this -> courselink = 'FS6H';
            

            if(isset($_POST["adminemail"]))
                $this -> adminemail = trim($_POST["adminemail"]);

            if(isset($_POST["scourselink"]))
            {
                $this -> scourselink = strtoupper(trim($_POST["scourselink"]));
                if($this -> scourselink == 'F8PAGE')
                    $this -> scourselink = 'FS8';
                else if($this -> scourselink == 'FS9H' || $this -> scourselink == 'F8R' || $this -> scourselink == 'FS9HAKNEW3')
                    $this -> scourselink = 'FS9';
                else if($this -> scourselink == 'DEMOFULL' || $this -> scourselink == 'FSHUT' || $this -> scourselink == 'FSHUNI')
                    $this -> scourselink = 'FS6H';
            }
            // Handle West Virginia
            $wvIdArray = Array(7,83,110,113,114,115,123,124,157);
            if(in_array($_POST['productid'], $wvIdArray))
            {
                if($_POST['productid'] == 114 || $_POST['productid'] == 157)
                {
                    $this -> courselink = 'FS6H';
                    $this -> scourselink = 'FS6H';
                }
                else
                {
                    $this -> courselink = 'FS6';
                    $this -> scourselink = 'FS6';
                }
            }

            if(isset($_POST["storenum"]))
                $this -> storenum = trim($_POST["storenum"]);

            // Some language will come through as a whole word, others as initials.
            // We just read the first two characters and set them to lower case to handle all cases.
            $this -> language = strtoupper(trim($_POST["lang"]));
        }

        private function Sanitize()
        {
            $sanitizer = new Helper();
            $data = [];
            $rawAdmin = str_replace('\'', '', $this -> admin);
            if(preg_match($sanitizer::NUMBERONLY, $rawAdmin))
                $data["admin"]      = $this -> admin;
            else
                $data["admin"]      = $sanitizer -> mssql_escape($this -> admin);

            if(is_numeric($this -> username))
                $data["username"] = "'" . $this -> username . "'";
            else
                $data["username"]   = $sanitizer -> mssql_escape($this -> username);

            if(is_numeric($this -> password))
                $data["password"] = "'" . $this -> password . "'";
            else
                $data["password"]   = $sanitizer -> mssql_escape($this -> password);

            $data["firstname"]  = $sanitizer -> mssql_escape($this -> firstname);
            $data["lastname"]   = $sanitizer -> mssql_escape($this -> lastname);            
            $data["email"]      = $sanitizer -> mssql_escape($this -> email);            
            //$data["coursename"] = $sanitizer -> mssql_escape($this -> coursename);
            $data["productid"]  = $sanitizer -> mssql_escape($this -> productid);
            $data["lang"]       = $sanitizer -> mssql_escape($this -> language);            
            $data["tablecode"]  = $sanitizer -> mssql_escape($this -> tablecode);
            $data["courselink"] = $sanitizer -> mssql_escape($this -> courselink);
            $data["scourselink"] = $sanitizer -> mssql_escape($this -> scourselink);
            $data["dob"]        = strlen($this -> dob) > 0 ? date("Y-m-d",strtotime($this -> dob)) : null;

            if(isset($_POST["storenum"]))
                $data["storenum"] = $sanitizer -> mssql_escape($this -> storenum);

            return $data;
        }

        private function SanitizeExcel()
        {
            $sanitizer = new Helper();
            $data = [];
            $rawAdmin = str_replace('\'', '', $this -> admin);

            if(preg_match($sanitizer::NUMBERONLY, $rawAdmin))
                $data["admin"]      = $this -> admin;
            else
                $data["admin"]      = $sanitizer -> mssql_escape($this -> admin);

            if(is_numeric($this -> username))
                $data["username"] = "'" . $this -> username . "'";
            else
                $data["username"]   = $sanitizer -> mssql_escape($this -> username);

            if(is_numeric($this -> password))
                $data["password"] = "'" . $this -> password . "'";
            else
                $data["password"]   = $sanitizer -> mssql_escape($this -> password);

            $data["firstname"]  = $sanitizer -> mssql_escape($this -> firstname);
            $data["lastname"]   = $sanitizer -> mssql_escape($this -> lastname);            
            $data["email"]      = $sanitizer -> mssql_escape($this -> email);
            //$data["coursename"] = $sanitizer -> mssql_escape($this -> coursename);
            $data["productid"]  = $sanitizer -> mssql_escape($this -> productid);
            $data["lang"]       = $sanitizer -> mssql_escape($this -> language);
            $data["tablecode"]  = $sanitizer -> mssql_escape($this -> tablecode);
            $data["courselink"] = $sanitizer -> mssql_escape($this -> courselink);
            $data["scourselink"] = $sanitizer -> mssql_escape($this -> scourselink);
            $data["dob"]        = strlen($this -> dob) > 0 ? date("Y-m-d",strtotime($this -> dob)) : null;

            if(isset($_POST["storenum"]))
                $data["storenum"] = $sanitizer -> mssql_escape($this -> storenum);

            return $data;
        }

        private function CleanAdmin()
        {
            $sanitizer = new Helper();
            $this -> admin = $sanitizer -> mssql_escape($_SESSION["user"]);
        }

        private function FilterCorporateList($clist, $list)
        {
            // If no corporate licenses exist, return the individual licenses.
            if(count($clist) == 0)
                return $list;

            $fullList = [];
            $finalList = array_replace_recursive($list, $clist);
            /*foreach ($clist as $ckey => $cvalue) {
                // Look at each product id from the corporate table
                foreach ($cvalue as $ck => $cv) {
                    if($ck == 'id')
                    {
                        // Search for a matching product id in the individual list.
                        foreach ($list as $key => $value) {
                            $match = array_search($cv, $value);

                            // Replace the corporate value with the individual value.
                            if($match && $value['LicensesRemaining'] != 0)
                            {
                                array_push($fullList, $value);
                            }
                        }
                    }
                }
            }*/

            //$finalList = array_unique(array_merge($fullList,$clist), SORT_REGULAR);
            return $finalList;
        }

        private function GetRequiredFields()
        {
            $dobTables = ['01D','09D','10D','11D','12D'];

            if(in_array(trim($_POST['tablecode']), $dobTables) && $_POST['productid'] != self::FOODSAFEMANID 
            && $_POST['productid'] != self::OHLEVEL2MANAGER && $_POST['productid'] != self::OHLEVEL2RECERT && $_POST['productid'] != self::RETAILFOODSAFE)
            {
                $this -> emailRequired = false;
                $this -> dobRequired = true;
            }
            else
            {
                $this -> emailRequired = true;
                $this -> dobRequired = false;
            }

            $reqs = Array (
                "dob" => $this -> dobRequired,
                "email" => $this -> emailRequired
            );

            return $reqs;
        }

        private function FindExpDate($admin)
        {            
            $numberOfDays = $this -> model -> GetExpDate($admin);

            if(!isset($numberOfDays))
                $timeExpire = '180';
            else
                $timeExpire = (string)$numberOfDays['TRAIN_PERIOD'];
                
            return date('m-d-Y', strtotime('+' . $timeExpire . ' days'));

        }

        private function ValidateUtah()
        {
            $validator = new Helper();

            $validated = strlen($_POST["address1"]) > 0    ? true : $this -> ValidationError("address1",self::NOADDRESS);

            if($validated)
                $validated = strlen($_POST["zip"]) > 0    ? true : $this -> ValidationError("zip",self::NOZIP);
            else
                $validated = strlen($_POST["zip"])  > 0   ? false : $this -> ValidationError("zip",self::NOZIP);

            if($validated)
                $validated = strlen($_POST["city"]) > 0    ? true : $this -> ValidationError("city",self::NOCITY);
            else
                $validated = strlen($_POST["city"]) > 0    ? false : $this -> ValidationError("city",self::NOCITY);

            if($validated)
                $validated = strlen($_POST["phone"]) > 0    ? true : $this -> ValidationError("phone",self::NOPHONE);
            else
                $validated = strlen($_POST["phone"]) > 0    ? false : $this -> ValidationError("phone",self::NOPHONE);

            if($validated)
                $validated = strlen($_POST["workphone"]) > 0    ? true : $this -> ValidationError("workphone",self::NOWPHONE);
            else
                $validated = strlen($_POST["workphone"]) > 0    ? false : $this -> ValidationError("workphone",self::NOWPHONE);

            if($validated)
                $validated = strlen($_POST["gender"]) > 0    ? true : $this -> ValidationError("gender",self::NOINITIAL);
            else
                $validated = strlen($_POST["gender"]) > 0   ? false : $this -> ValidationError("gender",self::NOINITIAL);

            if(strlen($_POST['address2']) > 0)
                $validated = preg_match($validator::ADDRESSCHARS, $_POST["lang"]) ? true : $this -> ValidationError("address2",self::INVALIDADDRESS2);

            if($validated)
                $validated = preg_match($validator::ADDRESSCHARS, $_POST["address1"])    ? true : $this -> ValidationError("address1",self::INVALIDADDRESS);
            else
                $validated = preg_match($validator::ADDRESSCHARS, $_POST["address1"])    ? false : $this -> ValidationError("address1",self::INVALIDADDRESS);

            if($validated)
                $validated = preg_match($validator::LETNUMREGEX, $_POST["zip"])    ? true : $this -> ValidationError("zip",self::INVALIDZIP);
            else
                $validated = preg_match($validator::LETNUMREGEX, $_POST["zip"])    ? false : $this -> ValidationError("zip",self::INVALIDZIP);

            if($validated)
                $validated = preg_match($validator::ADDRESSCHARS, $_POST["city"])    ? true : $this -> ValidationError("city",self::INVALIDCITY);
            else
                $validated = preg_match($validator::ADDRESSCHARS, $_POST["city"])    ? false : $this -> ValidationError("city",self::INVALIDCITY);

            if($validated)
                $validated = preg_match($validator::PHONEREGEX, $_POST["phone"])    ? true : $this -> ValidationError("phone",self::INVALIDPHONE);
            else
                $validated = preg_match($validator::PHONEREGEX, $_POST["phone"])    ? false : $this -> ValidationError("phone",self::INVALIDPHONE);

            if($validated)
                $validated = preg_match($validator::PHONEREGEX, $_POST["workphone"])    ? true : $this -> ValidationError("workphone",self::INVALIDPHONE);
            else
                $validated = preg_match($validator::PHONEREGEX, $_POST["workphone"])    ? false : $this -> ValidationError("workphone",self::INVALIDPHONE);

            if(strlen($_POST["midinitial"]) > 0)
            {
                if($validated)
                    $validated = preg_match($validator::LETNUMREGEX, $_POST["midinitial"])    ? true : $this -> ValidationError("midinitial",self::INVALIDINITIAL);
                else
                    $validated = preg_match($validator::LETNUMREGEX, $_POST["midinitial"])    ? false : $this -> ValidationError("midinitial",self::INVALIDINITIAL);
            }            
            
            if($validated)
                $validated = preg_match($validator::LETNUMREGEX, $_POST["gender"])    ? true : $this -> ValidationError("gender",self::INVALIDGENDER);
            else
                $validated = preg_match($validator::LETNUMREGEX, $_POST["gender"])    ? false : $this -> ValidationError("gender",self::INVALIDGENDER);

            if($validated)
                return true;
            else
                return false;
        }

        private function SanitizeUtah()
        {
            $sanitizer = new Helper();
            $data = [];            

            if(is_numeric($this -> username))
                $data["username"] = "'" . $this -> username . "'";
            else
                $data["username"]   = $sanitizer -> mssql_escape($this -> username);

            $data["address1"]   = $sanitizer -> mssql_escape($this -> address1);            
            $data["zip"]        = $sanitizer -> mssql_escape($this -> zip);
            $data["state"]      = $sanitizer -> mssql_escape($this -> state);
            $data["city"]       = $sanitizer -> mssql_escape($this -> city);
            $data["phone"]      = $sanitizer -> mssql_escape($this -> phone);
            $data["workphone"]  = $sanitizer -> mssql_escape($this -> workphone);
            $data["gender"]     = $sanitizer -> mssql_escape($this -> gender);

            if(isset($this -> address2))
                $data["address2"]   = $sanitizer -> mssql_escape($this -> address2);
            else
                $data["address2"] = 'null';
            if(isset($this -> midinitial))
                $data["midinitial"] = $sanitizer -> mssql_escape($this -> midinitial);
            else
                $data["midinitial"] = 'null';

            return $data;
        }

        private function SetUtahProps()
        {
            $this -> address1 = $_POST['address1'];
            
            $this -> zip = $_POST['zip'];
            $this -> city = $_POST['city'];
            $this -> phone = $_POST['phone'];
            $this -> workphone = $_POST['workphone'];
            $this -> gender = strtoupper($_POST['gender']);

            if(strlen($_POST['address2']) > 0)
                $this -> address2 = $_POST['address2'];
            if(strlen($_POST['midinitial']) > 0)
                $this -> midinitial = $_POST['midinitial'];
        }


        private function SetAlcoholArgs()
        {
            $storenumber = null;

            if(isset($this -> storenumber))
                $storenumber = $this -> storenumber;

            $args = array(
                "username" => $this -> username,
                "useremail" => $this -> email,
                "password" => $this -> password,
                "firstname" => $this -> firstname,
                "lastname" => $this -> lastname,
                "account" => $_SESSION["user"],
                "dateadded" => date("Y-m-d", strtotime("-8 hours")),
                "language" => $this -> language,
                "storenumber" => $storenumber,
                "dob" => $this -> dob
            );

            return $args;
        }
        private function userTaken()
        {
            // The user name already exists. Log errors and POST vars and return to add student page.
            $this -> ValidationError("username", self::USEREXISTSERR);
            $this -> StudentSession(null);
            header("Location:/admin/tools/students/single");
            exit;
        }
        // END CLASS METHODS
    }
?>