<?php

    include_once $_SERVER["DOCUMENT_ROOT"]."/admin/tools/trackprogress/TrackProgressController.php";
    include_once $_SERVER["DOCUMENT_ROOT"]."/admin/tools/trackprogress/scorereport/ScoreReportModel.php";
    include_once $_SERVER["DOCUMENT_ROOT"]."/lib/Mailer.php";
    include_once $_SERVER["DOCUMENT_ROOT"]."/lib/Helper.php";
    

    class ScoreReportController extends TrackProgressController
    {
        const GENERALERROR = "Error";

        public $totaltime = 0;

        public function __construct()
        {
            $this -> model = new ScoreReportModel();

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

        public function ChangeStudentEmail()
        {
            $validator = new Helper();

            $validated = filter_var($_POST['newemail'], FILTER_VALIDATE_EMAIL) ? true : false;

            if($validated)
                $validated = preg_match($validator::LETNUMREGEX, $_POST['studentid']) ? true : false;
            else
                $validated = preg_match($validator::LETNUMREGEX, $_POST['studentid']) ? false : false;

            if($validated)
                $validated = preg_match($validator::LETNUMREGEX, $_POST['tablecode']) ? true : false;
            else
                $validated = preg_match($validator::LETNUMREGEX, $_POST['tablecode']) ? false : false;

            if($validated)
            {
                $newemail  = $validator -> mssql_escape_int($_POST['newemail']);
                $studentid = $validator -> mssql_escape_int($_POST['studentid']);
                $tablecode = $_POST['tablecode'];
                return $this -> model -> UpdateStudentEmail($newemail, $studentid, $tablecode);
            }
            else
                echo self::EMAILERR;
        }

        public function ChangeStudentInfo()
        {
            $validator = new Helper();

            $validated = filter_var($_POST['newemail'], FILTER_VALIDATE_EMAIL) ? true : false;//NAMECHARS

            if($validated)
                $validated = preg_match($validator::NAMECHARS, $_POST['newfirstname']) ? true : false;
            else
                $validated = preg_match($validator::NAMECHARS, $_POST['newfirstname']) ? false : false;

            if($validated)
                $validated = preg_match($validator::NAMECHARS, $_POST['newfirstname']) ? true : false;
            else
                $validated = preg_match($validator::NAMECHARS, $_POST['newfirstname']) ? false : false;

            if($validated)
                $validated = preg_match($validator::LETNUMREGEX, $_POST['studentid']) ? true : false;
            else
                $validated = preg_match($validator::LETNUMREGEX, $_POST['studentid']) ? false : false;

            if($validated)
                $validated = preg_match($validator::LETNUMREGEX, $_POST['tablecode']) ? true : false;
            else
                $validated = preg_match($validator::LETNUMREGEX, $_POST['tablecode']) ? false : false;

            if($validated)
                $validated = preg_match($validator::LETNUMREGEX, $_POST['newpassword']) ? true : false;
            else
                $validated = preg_match($validator::LETNUMREGEX, $_POST['newpassword']) ? false : false;

            if($validated)
            {
                $student['newemail']  = $validator -> mssql_escape_int($_POST['newemail']);
                $student['newfirstname']  = $validator -> mssql_escape_int($_POST['newfirstname']);
                $student['newlastname']  = $validator -> mssql_escape_int($_POST['newlastname']);
                $student['newpassword']  = $validator -> mssql_escape_int($_POST['newpassword']);
                $student['id']  = $validator -> mssql_escape_int($_POST['studentid']);
                $student['table']  = $_POST['tablecode'];
                return $this -> model -> UpdateStudentInfo($student);
            }
            else
                echo self::EMAILERR;
        }

        public function StudentInfo()
        {
            $validator = new Helper();
            // Validate the table with regex and by counting the number of characters
            // We do it this way because mssql reads a hex encoded table name as literal.
            $validated = preg_match($validator::LETNUMREGEX, $_POST["studentid"])           ? true : false;
            $validated = preg_match($validator::LETNUMREGEX, $_POST["tablecode"])           ? true : false;
            $validated = strlen($_POST["tablecode"]) > 2 && strlen($_POST["tablecode"]) < 5 ? true : false;

            if($validated)
            {
                $studentid = $validator -> mssql_escape_int($_POST['studentid']);
                $student = $this -> model -> GetStudentInfo($this -> admin, $_POST["tablecode"], $studentid);

                $date = new DateTime($student['DA']);
                $formattedDA = $date->format('m-d-Y');
                unset($student['DA']);
                $student['DA'] = $formattedDA;

                $date = new DateTime($student['DE']);
                if(strlen($student['DE']) > 0)
                {
                    $formattedDE = $date->format('m-d-Y');
                    unset($student['DE']);
                    $student['DE'] = $formattedDE;
                }
                
                $studentinfo = array(
                    "name" => $student['NF'] . ' ' . $student['NL'],
                    "firstName" => $student['NF'],
                    "lastName" => $student['NL'],
                    "username" => $student['UU'],
                    "password" => $student['UC'],
                    "dateAdded" => $student['DA'],
                    "dateEnded" => $student['DE'],
                    "email" => $student['UM'],
                    "password" => $student['UC']
                );
                return $studentinfo;
            }
            else
                return self::TABLECODEERR;
        }

        public function IsTimeTracked()
        {
            if($_SESSION['admintable'] == '07L3')
            {
                $admindata = $this -> model -> GetTimeTracked($this -> admin);
                if($admindata['LESSONTIME'] == 1)
                    return true;
                else
                    return false;
            }
            else
                return false;
        }

        public function IsStudentEditable()
        {
            if($_SESSION['admintable'] == '07L3')
            {
                $admindata = $this -> model -> GetStudentEditable($this -> admin);
                if($admindata['STU_EDIT_INFO'] == 1)
                    return true;
                else
                    return false;
            }
            else
                return false;
        }

        public function ScoreReport($showtime = null)
        {
            $validator = new Helper();
            $validated['studentid'] = preg_match($validator::LETNUMREGEX, $_POST["studentid"])           ? true : false;
            $validated['tablecode'] = preg_match($validator::LETNUMREGEX, $_POST["tablecode"])           ? true : false;
            $validated['productid'] = preg_match($validator::LETNUMREGEX, $_POST["productid"])           ? true : false;
            $validated['studentid'] = strlen($_POST["studentid"]) > 2 && strlen($_POST["studentid"]) < 5 ? true : false;
            $validated['tablecode'] = strlen($_POST["tablecode"]) > 2 && strlen($_POST["tablecode"]) < 5 ? true : false;
            $validated['productid'] = strlen($_POST["productid"]) > 2 && strlen($_POST["productid"]) < 5 ? true : false;
            if($validated)
            {
                $studentid = $validator -> mssql_escape_int($_POST['studentid']);
                $productid = $_POST['productid'];
                $tablecode = str_replace('D','P', $_POST['tablecode']);
                $lessons = $this -> model -> GetLessons($productid);

                $scores =  $this -> model -> GetScoreReport($tablecode, $studentid, $productid);

                $scoreviewdata = [];
                $totaltime = 0;
                $lessontime = 0;
                
                if(!isset($lessons[0]['id']))
                {
                    $lesson = $lessons;
                    unset($lessons);
                    $lessons = [];
                    $lessons[0] = [];
                    $lessons[0] = $lesson;
                }

                // Keep track of lessons
                $i = 1;
                foreach ($lessons as $key => $lesson)
                {
                    $score =  $this -> model -> GetLessonScore($tablecode, $studentid, $lesson['LessonNumber']);                    

                    if($showtime && $tablecode != '02P')
                    {
                        if(isset($score['UTIME']))
                        {
                            $lessontime = $score['UTIME'];
                            $totaltime = $totaltime + $score['UTIME'];
                        }

                        $seconds = $lessontime % 60;
                        $lessontime = floor($lessontime / 60);
                        if(strlen($seconds) == 1)
                            $seconds = "0" . $seconds;

                        $minutes = $lessontime % 60;
                        $lessontime = floor($lessontime / 60); 
                        if(strlen($minutes) == 1)
                            $minutes = "0" . $minutes;

                        $hours = $lessontime % 60;
                        $lessontime = floor($lessontime / 60);
                        if(strlen($hours) == 1)
                            $hours = "0" . $hours;

                        $lessontime = $hours . ":" . $minutes . ":" . $seconds;
                    }
                    else if($showtime && $tablecode == '02P' && isset($score['UTIME']))
                    {
                        $lessontime = $this -> RecertLessonTime($score['UTIME']);

                        $this -> totaltime = $this -> RecertTotalTime($this -> totaltime, $lessontime);
                    }
                    else
                        $lessontime = null;

                    if(isset($score['DS']))
                    {
                        // Format the date so it looks better on the page.
                        $date = new DateTime($score['DS']);
                        $cleandate = $date->format('m-d-Y');
                        unset($score['DS']);
                        $score['DS'] = $cleandate;
                    } 

                    if(!isset($score['DE']))
                    {
                        $endDate = '';
                        $lessonStatus = 'Not Started';
                        $lessonScore = '';
                    }
                    if(isset($score['PER']))
                    {
                        if($score['PER'] == 100)
                        {
                            $date = new DateTime($score['DE']);
                            $endDate = $date->format('m-d-Y');
                            $lessonStatus = 'Complete';
                            $lessonScore = $score['PER']."%";
                        }
                        if(isset($score['DE']))
                        {
                            $date = new DateTime($score['DE']);
                            $endDate = $date->format('m-d-Y');
                            $lessonStatus = 'Complete';
                            $lessonScore = $score['PER']."%";
                        }
                    }                    
                    if(!isset($score['DE']) && isset($score['DS']))
                    {
                        //$date = new DateTime($score['DS']);
                        $endDate = '';
                        $lessonStatus = 'In Progress';
                        $lessonScore = '';
                    }                                       

                    if($i < 10)
                        $lessonNumber = '0' . $i;
                    else
                        $lessonNumber = $i;

                    $i++;
                    $lessonmodel = Array(
                        "LessonId"      => $lesson['id'],
                        "Lesson"        => $lessonNumber,
                        "LessonTitle"   => $lesson['LessonTitle'],
                        "LessonStatus"  => $lessonStatus,
                        "EndDate"     => $endDate,
                        "LessonTime"    => $lessontime,
                        "LessonScore"   => $lessonScore                        
                    );                    
                    array_push($scoreviewdata, $lessonmodel);
                }
                return $scoreviewdata;                
            }
            else
                return self::TABLECODEERR;
        }

        public function TotalTime($student)
        {
            $ptablecode = str_replace('D','P', $_POST['tablecode']);
            $lessons = $this -> model -> GetTotalTime($student, $ptablecode);
            $totaltime = 0;
            foreach ($lessons as $idx => $lesson) {
                foreach ($lesson as $key => $value) {
                    $totaltime = $totaltime + $value;
                }                
            }
            $seconds = $totaltime % 60;
            $totaltime = floor($totaltime / 60);
            if(strlen($seconds) == 1)
                $seconds = "0" . $seconds;

            $minutes = $totaltime % 60;
            $totaltime = floor($totaltime / 60); 
            if(strlen($minutes) == 1)
                $minutes = "0" . $minutes;

            $hours = $totaltime % 60;
            $totaltime = floor($totaltime / 60);
            if(strlen($hours) == 1)
                $hours = "0" . $hours;

            if($ptablecode == '02P')
                return $this -> totaltime;
            else
                return $totaltime = $hours . ":" . $minutes . ":" . $seconds;
        }

        public function ClassMates()
        {
            $valid = true;
            $temp = "temp";
            $validator = new Helper();
            $validated['studentidx'] = is_numeric($_POST["studentid"]) ? true : false;
            $validated['tablecodex'] = preg_match($validator::LETNUMREGEX, $_POST["tablecode"])  ? true : false;
            $validated['productidx'] = is_numeric($_POST["productid"]) ? true : false;
            $validated['tablecode'] = strlen($_POST["tablecode"]) > 2 && strlen($_POST["tablecode"]) < 5 ? true : false;
            $validated['productid'] = strlen($_POST["productid"]) > 0 && strlen($_POST["productid"]) < 5 ? true : false;

            foreach ($validated as $key => $value) {
                if(!$value)
                {
                    $valid = false;
                    $temp = "Is not valid";

                }
            }

            if($valid)
            {
                $student = $this -> model -> GetStudentName($_POST["studentid"],$_POST["tablecode"]);
                $lastName = $validator -> mssql_escape_int($student["NL"]);

                $table = $_POST["tablecode"];
                switch (trim($table)) {
                    case '01D':
                        $course = $this -> model -> GetME($_POST["productid"]);
                        return $classMates = $this -> model -> GetClassMatesFS($lastName,$_POST["tablecode"],$this -> admin['user'], $course['JobType']);
                        break;
                    case '02D':
                        $course = $this -> model -> GetIL($_POST["productid"]);
                        return $classMates = $this -> model -> GetClassMatesRE($lastName,$_POST["tablecode"],$this -> admin['user'], $course['StuType']);
                        break;
                    default:
                        return $classMates = $this -> model -> GetClassMates($lastName,$_POST["tablecode"],$this -> admin['user']);
                        break;
                }
            }
            else
                header('Location: /admin/tools/trackprogress');
        }

        public function SelfEnrollClassMates()
        {
            $valid = true;
            $temp = "temp";
            $validator = new Helper();
            $validated['studentidx'] = is_numeric($_POST["studentid"]) ? true : false;
            $validated['tablecodex'] = preg_match($validator::LETNUMREGEX, $_POST["tablecode"])  ? true : false;
            $validated['productidx'] = is_numeric($_POST["productid"]) ? true : false;
            $validated['tablecode'] = strlen($_POST["tablecode"]) > 2 && strlen($_POST["tablecode"]) < 5 ? true : false;
            $validated['productid'] = strlen($_POST["productid"]) > 0 && strlen($_POST["productid"]) < 5 ? true : false;

            foreach ($validated as $key => $value) {
                if(!$value)
                {
                    $valid = false;
                    $temp = "Is not valid";

                }
            }

            if($valid)
            {
                $student = $this -> model -> GetStudentName($_POST["studentid"],$_POST["tablecode"]);
                $lastName = $validator -> mssql_escape_int($student["NL"]);

                $table = $_POST["tablecode"];
                switch (trim($table)) {
                    case '01D':
                        $course = $this -> model -> GetME($_POST["productid"]);
                        return $classMates = $this -> model -> GetSelfEnrollClassMatesFS($lastName,$_POST["tablecode"],$this -> admin['user'], $course['JobType']);
                        break;
                    case '02D':
                        $course = $this -> model -> GetIL($_POST["productid"]);
                        return $classMates = $this -> model -> GetSelfEnrollClassMatesRE($lastName,$_POST["tablecode"],$this -> admin['user'], $course['StuType']);
                        break;
                    default:
                        return $classMates = $this -> model -> GetSelfEnrollClassMates($lastName,$_POST["tablecode"],$this -> admin['user']);
                        break;
                }
            }
            else
                header('Location: /admin/tools/trackprogress');
        }

        public function ResendCredentials()
        {
            $validator = new Helper();            
            $validated['studentid'] = preg_match($validator::LETNUMREGEX, $_POST["studentid"])           ? true : false;
            $validated['tablecode'] = preg_match($validator::LETNUMREGEX, $_POST["tablecode"])           ? true : false;
            $validated['productid'] = preg_match($validator::LETNUMREGEX, $_POST["productid"])           ? true : false;
            $validated['studentid'] = strlen($_POST["studentid"]) > 2 && strlen($_POST["studentid"]) < 5 ? true : false;
            $validated['tablecode'] = strlen($_POST["tablecode"]) > 2 && strlen($_POST["tablecode"]) < 5 ? true : false;
            $validated['productid'] = strlen($_POST["productid"]) > 2 && strlen($_POST["productid"]) < 5 ? true : false;
            if($validated)
            {
                $mailer = new Mailer();
                $student = $this -> model -> GetStudentCourseData($_POST["studentid"],$_POST["tablecode"]);
                $course = $this -> model -> GetCourseData($_POST['productid']);
                $studentinfo = array(
                    "coursename" => $course['ProductName'],
                    "firstname" => $student['NF'],
                    "lastname" => $student['NL'],
                    "username" => $student['UU'],
                    "password" => $student['UC'],
                    "email" => $student['UM'],
                    "to" => $student['UM']
                );
                $mailer -> ResendCredentials($studentinfo);
            }
            else
                echo self::GENERALERROR;
        }

        private function RecertLessonTime($time)
        {
            $splitTime = explode('_', $time);
            $hour = $splitTime[0] > 9 ? $splitTime[0] : '0' . $splitTime[0];
            $min = $splitTime[1] > 9 ? $splitTime[1] : '0' . $splitTime[1];
            $sec = $splitTime[2] > 9 ? $splitTime[2] : '0' . $splitTime[2];
            $newTime = $hour . ':' . $min . ':' . $sec;

            return $newTime;
        }

        private function RecertTotalTime($total, $time)
        {
            if($total === 0)
                $totalTime = $time;
            else
            {
                $currentTime = explode(':', $total);
                $lessonTime = explode(':', $time);

                $seconds = $currentTime[2] + $lessonTime[2];
                $minutes = $currentTime[1] + $lessonTime[1];
                $hours = $currentTime[0] + $lessonTime[0];

                if($seconds > 59)
                {
                    $minutes = $minutes + 1;
                    $seconds = $seconds - 60;
                }

                if($minutes > 59)
                {
                    $hours = $hours + 1;
                    $minutes = $minutes - 60;
                }

                $hours = $hours > 9 ? $hours : '0' . $hours;
                $minutes = $minutes > 9 ? $minutes : '0' . $minutes;
                $seconds = $seconds > 9 ? $seconds : '0' . $seconds;

                $totalTime = $hours . ':' . $minutes . ':' . $seconds;
            }

            return $totalTime;
        }
    }

?>