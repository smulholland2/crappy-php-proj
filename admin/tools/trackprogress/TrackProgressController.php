<?php

    include_once $_SERVER["DOCUMENT_ROOT"]."/admin/tools/trackprogress/TrackProgressModel.php";
    include_once $_SERVER["DOCUMENT_ROOT"]."/lib/Helper.php";
    include_once $_SERVER["DOCUMENT_ROOT"]."/lib/Mailer.php";

    class TrackProgressController
    {
        const TABLECODEERR     = "The table code is invalid. Please try again.";
        const PROIDEERR        = "The product id is invalid. Please try again.";
        const EMAILERR         = "The email address is invalid. Please try again.";

        const STATUSINPROGRESS = "In Progress";
        const STATUSINTRO      = "Intro";
        const STATUSNOTCLOSED  = "Not Closed";

        const SFISSCORETABLE   = "05S";
        const EMWSSCORETABLE   = "06D";

        const UNITTABLE        = "07L3";

        const SMTPUSER         = "info@tapseries.com";
        const SMTPPASS         = "Training0nline!";

        const SCOREREPORTTITLE = "";
        const SCOREREPORTDESC  = "";
        const QUICKTRACKTITLE  = "";
        const QUICKTRACKDESC   = "";

        const FSHTABLE         = "01P";
        const FSMTABLE         = "01P";
        const RETABLE          = "02P";
        const CBTABLE          = "03P";
        const HACCPTABLE       = "04P";
        const SFISTABLE        = "05P";
        const EMWSABLE         = "06P";
        const AATABLE          = "09P";
        const ADTABLE          = "10P";
        const ASTABLE          = "11P";
        const ALTABLE          = "12P";

        const RECERTMAX        = 15;

        const ALASKAID         = 185;
        const ANCHORAGEREGION  = "AKAN";

        private $admin         = [];
        private $model         = null;        
        private $admintable    = null;
        private $fromdate      = null;
        private $todate        = null;
        private $fname         = null;
        private $lastname      = null;
        private $course        = null;

        public function __construct()
        {
            $this -> model = new TrackProgressModel();
            
            if(!isset($_SESSION))
                session_start();

            $validator = new Helper();

            if(isset($_SESSION["unit"]))
            {
                if(preg_match($validator::NUMBERONLY, $_SESSION["unit"]))
                    $user = "'" . $_SESSION["unit"] . "'";
                else
                    $user = $validator -> CleanAdmin($_SESSION["unit"]);

                $this -> admin = Array(
                    'user'  => $user,
                    'table' => self::UNITTABLE
                );
            }
            else
            {
                if(preg_match($validator::NUMBERONLY, $_SESSION["user"]))
                    $user = "'" . $_SESSION["user"] . "'";
                else
                    $user = $validator -> CleanAdmin($_SESSION["user"]);

                $this -> admin = Array(
                    'user'  => $user,
                    'table' => $_SESSION['admintable']
                );
            }
        }

        public function ListCourses()
        {
            // Get a list of all courses that the admin has students in.
            return $this -> model -> GetCourses($this -> admin);
        }

        public function GetStudents($tablecode)
        {
            $validator = new Helper();
            $errors = [];
            $course = null;

            // Validate the table with regex and by counting the number of characters
            // We do it this way because mssql reads a hex encoded table name as literal.
            if(isset($tablecode))
            {
                $match = preg_match($validator::LETNUMREGEX, $tablecode) ? true : false;
                $length = strlen($tablecode) > 2 && strlen($tablecode) < 5 ? true : false;
            }
            if(!$match || !$length)
                array_push($errors, self::TABLECODEERR);
            
            if($tablecode == '01D')
                if(isset($_POST['productid']) && strlen($_POST['productid']) > 0)
                    if(strlen($_POST['productid']) > 0 && preg_match($validator::LETNUMREGEX, $_POST['productid']))
                        $productid = $validator -> mssql_escape_int($_POST['productid']);
                    else
                        array_push($errors, 'Password field is invalid.');
                else
                    array_push($errors, 'Product ID is required for Food Saftey courses.');

            if(count($errors) === 0)
            {
                // Find the course for food handler table.
                if($tablecode == '01D')
                    $course = $this -> model -> GetSafteyCourse($productid);

                if(isset($_SESSION['enrollment']) && $_SESSION['enrollment'] == 1)
                {
                    return $this -> model -> GetSelfEnrolledStudents($this -> admin, $tablecode, $course['JobType']);
                    exit;
                }

                return $this -> model -> GetStudents($this -> admin, $tablecode, $course['JobType']);
            }
            else
                return $errors;
        }

        public function ProgressReport($showCompany)
        {
            // First grab the JobType and the ExamNumber for the course. 
            // We will need this to filter the FoodHandler table and to get progress info for all courses.
            $course = $this -> model -> GetCourseCodeAndExam($_POST['productid']);

            // Get the filtered student list from the course login table.
            // Most of this data will go into the table on the progress report page.
            $me = isset($course['JobType']) ? $course['JobType'] : $course['StuType'];            
            $studentinfo = $this -> model -> 
                GetStudentListByCourse($this -> admin, $_POST["tablecode"], $me,$_POST["fromdate"],$_POST["todate"]);            

            // The return array.
            $report = [];

            // If there is only one student in the S table, we need to put it in an array.
            // This makes it easier to handle on the view page, since the view is setup 
            // to handle multiple students list by default.
            if(count($studentinfo) > 0 && !isset($studentinfo[0]['id']))
            {
                $temp = $studentinfo; // Store the current info
                unset($studentinfo); // Destory the array
                $studentinfo[0] = $temp; // Create an index and store the temp array in it
                unset($temp); // Destroy the temp array
            }
            
            // If no students are found, end the function.
            if(count($studentinfo) == 0)
                return false;

            // Loop over the students in the course. 
            // Lookup their progress and scores and combine all the data into the return array.
            for ($i = 0; $i < count($studentinfo); $i++)
            {
                $validator = new Helper();
                $student = $validator -> mssql_escape_int($studentinfo[$i]['UU']);
                
                $progress = $this -> GetProgress($student, $course['TotalLessons'], $_POST["tablecode"],$course['ExamType']);

                $score = 0;

                if(isset($progress))
                {
                    if(isset($progress['Complete']))
                    {
                        if($progress['Complete'] == true)
                        {
                            $score = "Complete";
                            $certlink = $this -> MakeCertLink($studentinfo[$i]);
                            $date = new DateTime($studentinfo[$i]['DE']);
                            $completed = $date->format('Y-m-d');
                        }
                        else if($progress['Complete'] == false)
                        {
                            $score = "Incomplete";
                            $certlink = NULL;
                            $completed = self::STATUSINPROGRESS;
                        }
                    }
                    else if($progress['MaxLesson'] == 0)
                    {
                        // The course has not been started.
                        $score = self::STATUSINTRO;
                        $certlink = NULL;
                        $completed = self::STATUSINPROGRESS;
                    }
                    else if($progress['Score'] >= $course['MinScore'])
                    {
                        $score = $progress['Score'] . "%";
                        $certlink = $this -> MakeCertLink($studentinfo[$i]);
                        $date = new DateTime($studentinfo[$i]['DE']);
                        $completed = $date->format('Y-m-d');
                    }
                    else if($progress['Score'] < $course['MinScore'] && ($progress['MaxLesson'] == $course['TotalLessons'] || $progress['MaxLesson'] == self::RECERTMAX))
                    {
                        $score = $progress['Score'] . "%";
                        $certlink = NULL;
                        $date = new DateTime($studentinfo[$i]['DE']);
                        $completed = $date->format('Y-m-d');
                    }                    
                    else
                    {
                        // The course has been started but it was not completed
                        $score = "L" . $progress['MaxLesson'];
                        $certlink = NULL;
                        $completed = self::STATUSINPROGRESS;
                    }
                }
                else
                {
                    // The course has not been started.
                    $score = self::STATUSINTRO;
                    $certlink = NULL;
                    $completed = self::STATUSINPROGRESS;                    
                }

                // In some cases, the student hasn't closed the course even though they finished all the lessons.
                // Progress is already set so we don't have to worry about which course we are dealing with.
                // Mark these courses as Not Closed so the instructor knows to tell his student to close the course.
                if(!isset($studentinfo[$i]['DE']) && $progress['Score'] > $course['MinScore'])
                {
                    $certlink = NULL;
                    $completed = self::STATUSNOTCLOSED;
                }                    

                // Format the date so it looks better on the page.
                $date = new DateTime($studentinfo[$i]['DA']);
                $dateadded = $date->format('Y-m-d');

                $companyName = '';
                if($showCompany)
                    $companyName = $this -> CompanyName(trim($studentinfo[$i]['UU']));

                $row = array(
                    "id"          => trim($studentinfo[$i]['id']),
                    "LastName"    => trim($studentinfo[$i]['NL']),
                    "FirstName"   => trim($studentinfo[$i]['NF']),
                    "Email"       => trim($studentinfo[$i]['UM']),
                    "CompanyName" => trim($companyName),
                    "UserName"    => trim($studentinfo[$i]['UU']),
                    "DateAdded"   => trim($dateadded),
                    "Completed"   => trim($completed),
                    "Progress"    => trim($score),
                    "Cert"        => trim($certlink)
                );

                array_push($report, $row);
            }

            return $report;

        }

        private function GetProgress($student, $exam, $table, $type)
        {
            $progress = null;

            switch ($table)
            {
                case '01D': // Food Safety Manager / Handler
                    if($type == 1)
                    {
                        // FSM
                        $progress = $this -> FSFinalReport($student, $exam);
                    }
                    else
                    {
                        // FSH
                        $progress = $this -> FSHReport($student, $exam);
                    }
                    break;
                case '02D': // Food Safety Recertification
                    $progress = $this -> RecertReport($student, $exam);
                    break;
                case '03D': // Cooking Basics
                    $progress = $this -> CBReport($student, $exam);
                    break;
                case '04D': // HACCAP
                    $progress = $this -> HACCPReport($student, $exam);
                    break;
                case '05D': // Strategies for Increasing Sales
                    $progress = $this -> SFISReport($student, $exam);
                    break;
                case '06D': // Earn More with Service
                    $progress = $this -> EMWSReport($student, $exam);
                    break;                
                case '09D': //Allergen Awareness
                    $progress = $this -> AAReport($student, $exam);
                    break;
                case '10D': // Allergen Plan Development
                    $progress = $this -> ADReport($student, $exam);
                    break;
                case '11D': // Allergen Plan Specialist
                    $progress = $this -> ASReport($student, $exam);
                    break;
                case '12D': // Alcohol Report
                    $progress = $this -> AlcoholReport($student, $exam);
                    break;
                default:
                    $progress = null;
                    break;
            }

            return $progress;
        }

        private function FSFinalReport($student, $exam)
        {
            $progress = null;
            $examIndex = $exam - 1;            
            $lessons = $this -> model -> GetFSFinalReport($student);
            $maxLesson = 0;
            if(count($lessons) > 0)
                $maxLesson = isset($lessons[0]['NUM']) ? count($lessons) : 1;
            else
                $maxLesson = 0;

            if(isset($lessons[$examIndex]) && isset($lessons[$examIndex]['DE']))
                return array("Score" => $lessons[$examIndex]['PER'], "MaxLesson" => trim($maxLesson));
            else
                return array("Score" => 0, "MaxLesson" => trim($maxLesson));
        }

        private function FSHReport($student, $exam)
        {
            $progress = null;
            $examIndex = $exam - 1;

            $lessons = $this -> model -> GetFSFinalReport($student);
            $maxLesson = count($lessons) > 0 ? 1 : 0;

            if(isset($lessons['DE']))
                return array("Score" => $lessons['PER'], "MaxLesson" => trim($maxLesson));
            else
                return array("Score" => 0, "MaxLesson" => trim($maxLesson));
        }

        private function RecertReport($student, $exam)
        {
            $progress = null;
            $examIndex = $exam - 1;            
            $lessons = $this -> model -> GetRecertReport($student);
            $maxLesson = 0;
            $maxIndex = 0;
            $average = 0;
            
            if(count($lessons) > 0 && isset($lessons[0]['NUM']))
            {
                // More than one lesson
                $maxLesson = count($lessons);
                $maxIndex = $maxLesson - 1;
                $maxLesson = $lessons[$maxIndex]['NUM'];
            }            
            else if(count($lessons) > 0 && !isset($lessons[0]['NUM']))
            {
                // Only one lesson
                $maxLesson = $lessons['NUM'];
            }
            else
                $maxLesson = 0; // No lessons
                        
            if(isset($lessons[$examIndex]) && isset($lessons[$examIndex]['DE']))
            {
                $average = $this -> CalculateAverage($lessons);
                return array("Score" => $average, "MaxLesson" => trim($maxLesson));
            }
            else
                return array("Score" => 0, "MaxLesson" => trim($maxLesson));
        }

        private function CBReport($student, $exam)
        {
            $progress = null;
            $examIndex = $exam - 1;            
            $lessons = $this -> model -> GetCBReport($student);
            $maxLesson = 0;
            $maxIndex = 0;
            $average = 0;
            
            if(count($lessons) > 0 && isset($lessons[0]['NUM']))
            {
                // More than one lesson
                $maxLesson = count($lessons);
                $maxIndex = $maxLesson - 1;
                $maxLesson = $lessons[$maxIndex]['NUM'];
            }            
            else if(count($lessons) > 0 && !isset($lessons[0]['NUM']))
            {
                // Only one lesson
                $maxLesson = $lessons['NUM'];
            }
            else
                $maxLesson = 0; // No lessons
                        
            if(isset($lessons[$examIndex]) && isset($lessons[$examIndex]['DE']))
            {
                $average = $this -> CalculateAverage($lessons);
                return array("Score" => $average, "MaxLesson" => trim($maxLesson));
            }
            else
                return array("Score" => 0, "MaxLesson" => trim($maxLesson));
        }

        private function HACCPReport($student, $exam)
        {
            $progress = null;
            $examIndex = $exam - 1;            
            $lessons = $this -> model -> GetHACCPReport($student);
            $maxLesson = 0;
            if(count($lessons) > 0)
                $maxLesson = isset($lessons[0]['NUM']) ? count($lessons) : 1;
            else
                $maxLesson = 0;

            if(isset($lessons[$examIndex]) && isset($lessons[$examIndex]['DE']))
                return array("Score" => $lessons[$examIndex]['PER'], "MaxLesson" => trim($maxLesson));
            else
                return array("Score" => 0, "MaxLesson" => trim($maxLesson));
        }

        private function SFISReport($student, $exam)
        {
            // BYLESSON == 1 indicates that the course is being viewed one lesson at a time.
            // If that is the case, the L values will be used instead of PER.
            $progress = null;
            $examIndex = $exam - 1;            
            $lessons = $this -> model -> GetSFISReport($student);
            $maxLesson = 0;
            $maxIndex = 0;
            $average = 0;
            
            if(count($lessons) > 0 && isset($lessons[0]['NUM']))
            {
                // More than one lesson
                $maxLesson = count($lessons);
                $maxIndex = $maxLesson - 1;
                $maxLesson = $lessons[$maxIndex]['NUM'];
            }            
            else if(count($lessons) > 0 && !isset($lessons[0]['NUM']))
            {
                // Only one lesson
                $maxLesson = $lessons['NUM'];
            }
            else
                $maxLesson = 0; // No lessons
                        
            if(isset($lessons[$examIndex]) && isset($lessons[$examIndex]['DE']))
            {
                $average = $this -> CalculateAverage($lessons);
                return array("Score" => $average, "MaxLesson" => trim($maxLesson));
            }
            else
                return array("Score" => 0, "MaxLesson" => trim($maxLesson));
        }

        private function EMWSReport($student, $exam)
        {
            // EMWS is marked in the database because it has special conditions.
            // The table in which to look up the scores is 06D.
            $progress = null;
            $examIndex = $exam - 1;            
            $lessons = $this -> model -> GetEMWSReport($student);
            $maxLesson = 0;
            $maxIndex = 0;
            $average = 0;
            
            if(count($lessons) > 0 && isset($lessons[0]['NUM']))
            {
                // More than one lesson
                $maxLesson = count($lessons);
                $maxIndex = $maxLesson - 1;
                $maxLesson = $lessons[$maxIndex]['NUM'];
            }            
            else if(count($lessons) > 0 && !isset($lessons[0]['NUM']))
            {
                // Only one lesson
                $maxLesson = $lessons['NUM'];
            }
            else
                $maxLesson = 0; // No lessons
                        
            if(isset($lessons[$examIndex]) && isset($lessons[$examIndex]['DE']))
            {
                $average = $this -> CalculateAverage($lessons);
                return array("Score" => $average, "MaxLesson" => trim($maxLesson));
            }
            else
                return array("Score" => 0, "MaxLesson" => trim($maxLesson));
        }

        private function AAReport($student, $exam)
        {
            $progress = null;
            $examIndex = $exam - 1;
            $lessons = $this -> model -> GetAAReport($student);
            $maxLesson = 0;
            if(count($lessons) > 0)
                $maxLesson = isset($lessons[0]['NUM']) ? count($lessons) : 1;
            else
                $maxLesson = 0;

            if(isset($lessons[$examIndex]) && isset($lessons[$examIndex]['DE']))
                return array("Score" => $lessons[$examIndex]['PER'], "MaxLesson" => trim($maxLesson));
            else
                return array("Score" => 0, "MaxLesson" => trim($maxLesson));
        }

        private function ADReport($student, $exam)
        {
            // Allergen Plan can only be marked as complete or incomplete.
            $progress = null;
            $examIndex = $exam - 1;
            $lessons = $this -> model -> GetADReport($student);
            $maxLesson = count($lessons) > 0 ? 1 : 0;

            if(isset($lessons['DE']))
                return array("Score" => 0, "MaxLesson" => trim($maxLesson), "Complete" => true);
            else
                return array("Score" => 0, "MaxLesson" => trim($maxLesson), "Complete" => false);
        }

        private function ASReport($student, $exam)
        {
            $progress = null;
            $examIndex = $exam - 1;
            $lessons = $this -> model -> GetASReport($student);
            $maxLesson = 0;
            if(count($lessons) > 0)
                $maxLesson = isset($lessons[0]['NUM']) ? count($lessons) : 1;
            else
                $maxLesson = 0;

            if(isset($lessons[$examIndex]) && isset($lessons[$examIndex]['DE']))
                return array("Score" => $lessons[$examIndex]['PER'], "MaxLesson" => trim($maxLesson));
            else
                return array("Score" => 0, "MaxLesson" => trim($maxLesson));
        }

        private function AlcoholReport($student, $exam)
        {
            $progress = null;
            $examIndex = $exam - 1;
            $lessons = $this -> model -> GetAlcoholReport($student);
            $maxLesson = 0;
            if(count($lessons) > 0)
                $maxLesson = isset($lessons[0]['NUM']) ? count($lessons) : 1;
            else
                $maxLesson = 0;

            if(isset($lessons[$examIndex]) && isset($lessons[$examIndex]['DE']))
                return array("Score" => $lessons[$examIndex]['PER'], "MaxLesson" => trim($maxLesson));
            else
                return array("Score" => 0, "MaxLesson" => trim($maxLesson));
        }

        private function MakeCertLink($student)
        {
            if(isset($student['REGION']))
            {
                if($student['REGION'] == self::ANCHORAGEREGION)
                    $link = '/certificate/cert.php?';
                else
                    $link = 'http://asp.tapseries.com/certificate/ShowCertificate_.asp?';
            }
            else
                $link = 'http://asp.tapseries.com/certificate/ShowCertificate_.asp?';
            $link .= 'lname100="'.urlencode($student['NL']).'"&';
            $link .= 'ctname933='.$student['UU'].'&';
            $link .= 'lname200=&';
            $link .= 'month=Month&';
            $link .= 'day=Day&';
            $link .= 'year=Year';

            return $link;
        }

        private function CalculateAverage($lessons)
        {
            $average = 0;
            $total = 0;

            foreach ($lessons as $idx => $lesson)
            {
                $total = $total + $lessons[$idx]['PER'];
            }

            $average = round($total / count($lessons));

            return $average;
        }

        public function TableCode($productid)
        {
            $validator = new Helper();
            
            $validated = preg_match($validator::LETNUMREGEX, $productid) ? true : false;

            if($validated)
            {
                $productid = $validator -> mssql_escape_int($_POST['productid']);
                return str_replace(" ", "", $this -> model -> GetTableCode($productid));
            }
            else
                return self::PROIDEERR;
        }

        public function ProgramInfo()
        {
            $instructorinfo = $this -> model -> GetInstructorInfo($this -> admin);

            if(isset($instructorinfo['INF']))
                $instructorinfo['NCON'] = $instructorinfo['INF'];

            if(isset($instructorinfo['INL']))
                $instructorinfo['NCON'] .= $instructorinfo['INL'];

            if(isset($instructorinfo['IM']))
                $instructorinfo['AM'] = $instructorinfo['IM'];

            $coursetitle = $this -> model -> GetCourseTitle($_POST['productid']);

            $daterange = "[" . $_POST['fromdate'] . "] - [" . $_POST['todate'] . "]";

            $programinfo = array(
                // We will use the session variable 'displayname' for the organization name.
                "InstructorName"  => $instructorinfo['NCON'],
                "Dates"           => $daterange,
                "CourseTitle"     => $coursetitle['ProductName'],
                "InstructorEmail" => $instructorinfo['AM'],
            );

            return $programinfo;
        }

        public function MessageStudent()
        {
            include_once $_SERVER['DOCUMENT_ROOT']."/lib/Mailer.php";

            $mailer = new Mailer();
            $validator = new Helper();

            $validated = true;

            // Make the email strings into arrays so we can validate each one individually.
            $fromlist = explode(",", $_POST['from']);
            $tolist = explode(",", $_POST['to']);

            // CC emails are optional.
            if(isset($_POST['cc']) && strlen($_POST['cc']) > 0)
                $cclist = explode(",", $_POST['cc']);

            // Validate all the emails.
            for($i = 0; $i < count($fromlist); $i++)
            {
                if($validated)
                    $validated = filter_var($fromlist[$i], FILTER_VALIDATE_EMAIL) ? true : false;
            }

            for($i = 0; $i < count($tolist); $i++)
            {
                if($validated)
                    $validated = filter_var($tolist[$i], FILTER_VALIDATE_EMAIL) ? true : false;
            }

            // CC emails are optional.
            if(isset($_POST['cc']) && strlen($_POST['cc']) > 0)
            {
                for($i = 0; $i < count($cclist); $i++)
                {
                    if($validated)
                        $validated = filter_var($cclist[$i], FILTER_VALIDATE_EMAIL) ? true : false;
                }
            }

            // The Subject is optional.
            if(isset($_POST['subject']) && strlen($_POST['subject']) > 0)
                if($validated)
                    $validated = preg_match($validator::PASSWORDCHARS, $_POST['subject']) ? true : false;
            
            if($validated)
                    $validated = preg_match($validator::PASSWORDCHARS, $_POST['message']) ? true : false;

            if($validated)
            {
                // Once everything is validated, create a new array and send it to the mailer.
                $args = Array(
                    "from"     => $_POST['from'],
                    "to"       => $_POST['to'],
                    "cc"       => $_POST['cc'],
                    "subject"  => $_POST['subject'],
                    "body"     => $_POST['message'],
                    "smtpuser" => self::SMTPUSER,
                    "smtppass" => self::SMTPPASS
                );

                $mailer -> MessageStudent($args);
            }
            else
                echo self::EMAILERR;
        }

        public function IsEmailRequired($productId)
        {
            $ids = array(2,3,16,18,19,20,21,24,68,73,74,75,76,79,80,162,163,164,169);
            if(in_array($productId, $ids))
                return false;
            else
                return true;
        }

        public function CompanyName($student)
        {
            $studentInfo = $this -> model -> GetSelfEnrolledCompany($student);

            if(isset($studentInfo['NCPY']))
                return $studentInfo['NCPY'];
            else
                return '';
        }
    }

?>