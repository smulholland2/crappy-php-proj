<?php

    include_once $_SERVER['DOCUMENT_ROOT'].'/lib/PHPExcel/Classes/PHPExcel/IOFactory.php';
    include_once $_SERVER["DOCUMENT_ROOT"].'/admin/tools/trackprogress/TrackProgressController.php';
    include_once $_SERVER["DOCUMENT_ROOT"]."/admin/tools/trackprogress/totalenrollment/TotalEnrollmentModel.php";

    class TotalEnrollmentController extends TrackProgressController
    {
        public function __construct()
        {
            $this -> model = new TotalEnrollmentModel();

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

        public function TotalEnrollment()
        {
            // First grab the JobType
            // We will need this to filter the FoodHandler table.
            $course = $this -> model -> GetCourseCodeAndExam($_POST['productid']);
            
            // Get the filtered student list from the course login table.
            // Most of this data will go into the table on the quicktrack page.
            $studentinfo = $this -> model -> GetStudentListByCourse($this -> admin, $_POST["tablecode"], $course['JobType'],$_POST["fromdate"],$_POST["todate"]);

            // The return array.
            $totalenrollment = [];

            // Loop over the students in the course. 
            // Lookup their progress and scores and combine all the data into the return array.
            for ($i = 0; $i < count($studentinfo); $i++) {
                
                // Format the date so it looks better on the page.
                $date = new DateTime($studentinfo[$i]['DA']);
                $dateadded = $date->format('m-d-Y');

                $row = array(
                    "LastName" => $studentinfo[$i]['NL'],
                    "FirstName" => $studentinfo[$i]['NF'],
                    "Email" => $studentinfo[$i]['UM'],
                    "UserName" => $studentinfo[$i]['UU'],
                    "DateAdded" => $dateadded,
                );

                array_push($totalenrollment, $row);
            }

            return $totalenrollment;
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

        public function CreateExcel()
        {
            
        }
    }

?>