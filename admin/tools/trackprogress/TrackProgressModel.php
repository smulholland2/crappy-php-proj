<?php

    include_once $_SERVER["DOCUMENT_ROOT"]."/config/connection.php";
    include_once $_SERVER["DOCUMENT_ROOT"]."/lib/Helper.php";

    const FOODSAFETYTABLE = '01D';

    class TrackProgressModel
    {
        const INSTRUCTORTABLE = "07L3";
        const ORGTABLE = "07O6";

        public function GetCourses($admin)
        {
            $connector = new Db();
            // Return this list to be displayed in a select on the page.

            $sql = "SELECT [id],[ProId],[TableCode],[ProductName] FROM [07DS2] WHERE [LMS] > 0 ORDER BY [ProductName] ASC";
            return $connector -> RunQuery($sql);
        }

        public function GetStudents($admin, $table, $course = null)
        {
            $connector = new Db();
            
            if(isset($course))
                $sql = "SELECT [id],[NF],[NL] FROM [" . $table . "] WHERE [UA] = " . $admin['user'] . " AND [ME] = ". $course . " AND [DA] > '12/31/2013' ORDER BY [NL] ASC";
            else
                $sql = "SELECT [id],[NF],[NL] FROM [" . $table . "] WHERE [UA] = " . $admin['user'] . " AND [DA] > '12/31/2013' ORDER BY [NL] ASC";

            return $connector -> RunQuery($sql);
        }

        public function GetSelfEnrolledStudents($admin, $table, $course = null)
        {
            $context = new Db();
            $sql = "SELECT [".$table."].[id],[".$table."].[NF],[".$table."].[NL]";
            $sql .= " FROM [07SL4], [07SL1], [07L3], [".$table."]";
            $sql .= " WITH (NOLOCK)";
            $sql .= " WHERE [07SL4].VC=[07SL1].VC AND [07L3].PRO = [07SL4].id AND [".$table."].UA = [07L3].AN";
            $sql .= " AND [07SL4].IU=". $admin['user'] ." AND  [".$table."].DA >= '12/31/2013'";
            //$sql .= " AND [07SL4].IU=". $admin['user'];
            if($table == "01D")
                $sql .= " AND [".$table."].[ME] = '". $course ."'";
            if($table == "02D")
                $sql .= " AND [".$table."].[IL] = '". $course ."'";
            $sql .= " ORDER BY [".$table."].[NL] ASC";

            return $context -> RunQuery($sql);
        }

        public function GetStudentInfo($admin, $table, $studentid)
        {
            $connector = new Db();

            $sql = "SELECT [NF], [NL], [UU], [UC], [DA], [DE], [UM], [UC] FROM [" . $table . "] WHERE [id] = " . $studentid;

            return $connector -> RunQuery($sql);
        }

        public function GetStudentListByCourse($admin, $table, $course = null, $from, $to)
        {
            $context = new Db();
            // This handles all self enrollment
            if(isset($_SESSION['enrollment']) && $_SESSION['enrollment'] == 1)
            {
                $sql = "SELECT [".$table."].[id],[".$table."].[NF],[".$table."].[NL],[".$table."].[UU],[".$table."].[UC],[".$table."].[DA],[".$table."].[DE],[".$table."].[UM]";
                $sql .= " FROM [07SL4], [07SL1], [07L3], [".$table."]";
                $sql .= " WITH (NOLOCK)";
                $sql .= " WHERE [07SL4].VC=[07SL1].VC AND [07L3].PRO = [07SL4].id AND [".$table."].UA = [07L3].AN";
                $sql .= " AND [07SL4].IU=". $admin['user'] ." AND  [".$table."].DA >= '". $from ."' AND [".$table."].DA <= ' ". $to ."'";
                if($table == "01D")
                    $sql .= " AND [".$table."].[ME] = '". $course ."'";
                if($table == "02D")
                    $sql .= " AND [".$table."].[IL] = '". $course ."'";
                $sql .= " ORDER BY [".$table."].[NL] ASC";
            }
            else
            {
                 $sql = "SELECT [id], [NF], [NL], [UU], [UC], [DA], [DE], [UM]"; 
                 
                 if($table == "01D")
                    $sql .= ", [REGION]";

                 $sql .= " FROM [" . $table . "]
                    WHERE [UA] = " . $admin['user'] ."
                    AND [DA] >= '" . $from ."'
                    AND [DA] <= '" . $to ."'";

                if($table == "01D")
                    $sql .= " AND [ME] = '" . $course . "'";

                if($table == "02D")
                    $sql .= " AND [IL] = '" . $course . "'";

                $sql .= " ORDER BY [NL] ASC";
            }

            return $context -> RunQuery($sql);
        }

        public function GetLessonInfo($admin, $table, $studentid)
        {
            $connector = new Db();

            $sql = "SELECT [LessonTitle],[LessonNumber] FROM [CourseTitles] WHERE [ProductId] = " . $productid;
            $coursedata = $connector -> RunQuery($sql);

            $progressdata = [];

            $sql = "SELECT [NF], [NL], [UU], [UC], [DA], [DE], [UM] FROM [" . $table . "] WHERE [UA] = " . $admin['user'] ." AND [id] = " . $studentid;
            return $connector -> RunQuery($sql);
        }

        public function GetTableCode($productid)
        {
            $connector = new Db();

            $sql = "SELECT [TableCode] FROM [07DS2] WHERE [id] = " . $productid;
            return $connector -> RunQuery($sql);
        }

        public function GetScoreReport($table, $studentid, $productid)
        {
            $connector = new Db();
            $validator = new Helper();
            //return $studentid;
            $studentusername = $this -> GetStudentUsername($studentid, $table);
            $student = $validator -> mssql_escape_int($studentusername['UU']);

            $sql = "SELECT [CourseTitles].[LessonTitle],[CourseTitles].[LessonNumber], [".$table."].[DS], [".$table."].[PER],[".$table."].[DE]
                    FROM [CourseTitles]
                    INNER JOIN [".$table."]
                    ON [".$table."].[NUM] = [CourseTitles].[LessonNumber]
                    WHERE [".$table."].[UU] = " . $student . " AND [CourseTitles].[ProductId] = " . $productid;

            return $connector -> RunQuery($sql);
        }        

        public function GetStudentUsername($studentid, $table)
        {
            $connector = new Db();
            $table = str_replace('P','D', $table);
            $sql = "SELECT [UU] FROM [".$table."] WHERE [id] = " . $studentid;
            return $connector -> RunQuery($sql);
        }

        public function GetInstructorInfo($admin)
        {
            $connector = new Db();

            if(isset($_SESSION['enrollment']) && $_SESSION['enrollment'] == 1)
            {
                $sql = "SELECT [INF],[INL],[IM] FROM [07SL4] WHERE [IU] = " . $admin['user'];
            }
            else
            {
                $sql = "SELECT [NCON],[AM] FROM [07O6] WHERE [AN] = " . $admin['user'];
            }

            return $connector -> RunQuery($sql);
        }

        public function GetCourseTitle($productid)
        {
            $connector = new Db();
            $sql = "SELECT [ProductName] FROM [07DS2] WHERE id = " . $productid;

            return $connector -> RunQuery($sql);
        }

        public function GetProgress($table, $studentun, $exam)
        {
            $connector = new Db();

            $sql = "SELECT [E], [NUM] FROM [". $table ."] WHERE [UU] = " . $studentun;

            return $connector -> RunQuery($sql);
        }

        public function GetAvgProgress($table, $studentun, $exam)
        {
            $connector = new Db();

            $sql = "SELECT [NUM] FROM [". $table ."] WHERE [UU] = '" . $studentun . "'";

            return $connector -> RunQuery($sql);
        }

        public function GetSFISProgress($table, $studentun, $exam)
        {
            $connector = new Db();

            $sql = "SELECT [E], [NUM], [BYLESSON] FROM [". $table ."] WHERE [UU] = '" . $studentun . "'";

            return $connector -> RunQuery($sql);
        }

        public function GetEMWSProgress($table, $studentun, $exam)
        {
            $context = new Db();

            $sql = "SELECT [E],[NUM],[DE] FROM [06D] WHERE [UU] = '" . $studentun . "'";

            return $context -> RunQuery($sql);
        }

        public function GetExamScore($table, $student, $exam)
        {
            $connector = new Db();
            $sql = "SELECT [PER],[DE] FROM [".$table."] WHERE [UU] = '" . $student ."' AND [NUM] = '" . $exam ."'";

            return $connector -> RunQuery($sql);
        }

        public function GetCourseCodeAndExam($productid)
        {
            $connector = new Db();
            $sql = "SELECT [JobType],[StuType],[TotalLessons],[ExamType],[MinScore] FROM [07DS2] WHERE [id] = '" . $productid ."'";
            return $connector -> RunQuery($sql);
        }

        public function GetExamAverage($table, $student)
        {
            $context = new Db();
            $sql = "SELECT [NUM],[PER],[DE] FROM [".$table."] WHERE [UU] = '" . $student ."'";

            return $context -> RunQuery($sql);
        }

        public function GetEMWSScore($table, $student, $exam)
        {
            $connector = new Db();
            $sql = "SELECT [PER],[BYLESSON] FROM [".$table."] WHERE [UU] = '" . $student ."' AND [NUM] = '" . $exam ."'";
            return $connector -> RunQuery($sql);
        }

        public function UpdateStudentEmail($newemail, $studentid, $table)
        {
            $connector = new Db();
            $sql = "UPDATE [" . $table . "] SET [UM] = " . $newemail . " WHERE [id] = " . $studentid;
            return $connector -> RunQuery($sql);
        }

        public function UpdateStudentInfo($student)
        {
            $connector = new Db();

            $sql = "UPDATE [" . $student['table'] . "] 
            SET [UM] = " . $student['newemail'] . ", [NF] = ".$student['newfirstname'].", [NL] = ".$student['newlastname']." , [UC] = ".$student['newpassword']. "
            WHERE [id] = " . $student['id'];
            return $connector -> RunQuery($sql);
        }

        public function GetSafteyCourse($productid)
        {
            $context = new Db();

            $sql = "SELECT [JobType] FROM [07DS2] WHERE [id] = " . $productid;

            return $context -> RunQuery($sql);
        }

        public function GetLessons($productId)
        {
            $context = new Db();

            $sql = "SELECT [id],[LessonNumber],[LessonTitle] FROM [CourseTitles] WHERE [ProductId] = " . $productId;

            return $context -> RunQuery($sql);
        }

        public function GetTimeTracked($admin)
        {
            $context = new Db();

            $sql = "SELECT [LESSONTIME] FROM [07L3] WHERE [AN] = " . $admin['user'];

            return $context -> RunQuery($sql);
        }

        public function GetTotalTime($student, $ptablecode)
        {
            $context = new Db();

            $sql = "SELECT [UTIME] FROM [".$ptablecode."] WHERE [UU] = '" . $student . "'";

            return $context -> RunQuery($sql);
        }

        public function GetStudentEditable($admin)
        {
            $context = new Db();

            $sql = "SELECT [STU_EDIT_INFO] FROM [07L3] WHERE [AN] = " . $admin['user'];

            return $context -> RunQuery($sql);
        }

        public function GetFSFinalReport($student)
        {
            $context = new Db();
            $sql = "SELECT [NUM],[PER],[DE] FROM [01P] WHERE [UU] = " . $student;
            return $context -> RunQuery($sql);
        }

        public function GetFSHReport($student)
        {
            $context = new Db();
            $sql = "SELECT [NUM],[PER],[DE] FROM [01P] WHERE [UU] = " . $student;

            return $context -> RunQuery($sql);
        }

        public function GetRecertReport($student)
        {
            $context = new Db();
            $sql = "SELECT [NUM],[PER],[DE] FROM [02P] WHERE [UU] = " . $student;

            return $context -> RunQuery($sql);
        }

        public function GetCBReport($student)
        {
            $context = new Db();
            $sql = "SELECT [NUM],[PER],[DE] FROM [03P] WHERE [UU] = " . $student;

            return $context -> RunQuery($sql);
        }

        public function GetHACCPReport($student)
        {
            $context = new Db();
            $sql = "SELECT [NUM],[PER],[DE] FROM [04P] WHERE [UU] = " . $student;

            return $context -> RunQuery($sql);
        }

        public function GetSFISReport($student)
        {
            $context = new Db();
            $sql = "SELECT [NUM],[PER],[DE] FROM [05P] WHERE [UU] = " . $student;

            return $context -> RunQuery($sql);
        }

        public function GetEMWSReport($student)
        {
            $context = new Db();
            $sql = "SELECT [NUM],[PER],[DE] FROM [06P] WHERE [UU] = " . $student;

            return $context -> RunQuery($sql);
        }

        public function GetAAReport($student)
        {
            $context = new Db();
            $sql = "SELECT [NUM],[PER],[DE] FROM [09P] WHERE [UU] = " . $student;

            return $context -> RunQuery($sql);
        }

        public function GetADReport($student)
        {
            $context = new Db();
            $sql = "SELECT [NUM],[PER],[DE] FROM [10P] WHERE [UU] = " . $student;

            return $context -> RunQuery($sql);
        }

        public function GetASReport($student)
        {
            $context = new Db();
            $sql = "SELECT [NUM],[PER],[DE] FROM [11P] WHERE [UU] = " . $student;

            return $context -> RunQuery($sql);
        }

        public function GetAlcoholReport($student)
        {
            $context = new Db();
            $sql = "SELECT [NUM],[PER],[DE] FROM [12P] WHERE [UU] = " . $student;

            return $context -> RunQuery($sql);
        }

        public function GetSelfEnrolledCompany($student)
        {
            //SELECT [NCPY] FROM [07O1] where an = '$student'

            $context = new Db();

            $stmt = 'GetStudentCompany';

            return $context -> ExecuteProcedure($stmt,$student);
        }
    }
?>