<?php

    include_once $_SERVER["DOCUMENT_ROOT"]."/admin/tools/trackprogress/TrackProgressModel.php";
    include_once $_SERVER["DOCUMENT_ROOT"]."/lib/Helper.php";

    class ScoreReportModel extends TrackProgressModel
    {
        public function GetLessonScore($table, $studentid, $lessonNum )
        {
            $context = new Db();
            $validator = new Helper();

            $studentusername = $this -> GetStudentUsername($studentid, $table);
            $student = $validator -> mssql_escape_int($studentusername['UU']);

            if($table == '06P')
                $sql = "SELECT [DS], [PER], [DE] FROM [" . $table . "] WHERE [UU] = " . $student . " AND [NUM] = " . $lessonNum;
            else
                $sql = "SELECT [DS], [PER], [DE], [UTIME] FROM [" . $table . "] WHERE [UU] = " . $student . " AND [NUM] = " . $lessonNum;
                
            return $context -> RunQuery($sql);
        }

        public function GetME($productid)
        {
            $context = new Db();
            $sql = "SELECT [JobType] FROM [07DS2] WHERE [id] = ".$productid;
            return $context -> RunQuery($sql);
        }

        public function GetIL($productid)
        {
            $context = new Db();
            $sql = "SELECT [StuType] FROM [07DS2] WHERE [id] = ".$productid;
            return $context -> RunQuery($sql);
        }

        public function GetClassMates($lastName, $table, $admin)
        {
            $context = new Db();

            $sql = "SELECT top(1) [id] FROM [" .$table. "]";
            $sql .= " WHERE ";
            $sql .= " [NL] > " .$lastName;
            $sql .= " AND [UA] = " . $admin;
            $sql .= " AND [DA] >= '" .$_SESSION['track']['fromdate'] . "'";
            $sql .= " AND [DA] <= '" .$_SESSION['track']['todate'] . "'";
            $sql .= " ORDER BY [NL] ASC";

            $next = $context -> RunQuery($sql);

            $sql = "SELECT top(1) [id] FROM [" .$table. "]";
            $sql .= " WHERE ";
            $sql .= " [NL] < " .$lastName;
            $sql .= " AND [UA] = " . $admin;
            $sql .= " AND [DA] >= '" .$_SESSION['track']['fromdate'] . "'";
            $sql .= " AND [DA] <= '" .$_SESSION['track']['todate'] . "'";
            $sql .= " ORDER BY [NL] DESC";

            $prev = $context -> RunQuery($sql);

            if(!isset($next['id']) && !isset($prev['id']))
                return array("Next" => '', "Prev" => '');
            elseif(!isset($next['id']))
                return array("Next" => '', "Prev" => $prev['id']);
            elseif(!isset($prev['id']))
                return array("Next" => $next['id'], "Prev" => '');
            else
                return array("Next" => $next['id'], "Prev" => $prev['id']);
        }

        public function GetClassMatesFS($lastName, $table, $admin, $course)
        {
            $context = new Db();

            $sql = "SELECT top(1) [id] FROM [" .$table. "]";
            $sql .= " WHERE ";
            $sql .= " [NL] > " .$lastName;
            $sql .= " AND [ME] = ".$course;
            $sql .= " AND [UA] = " . $admin;
            $sql .= " AND [DA] >= '" .$_SESSION['track']['fromdate'] . "'";
            $sql .= " AND [DA] <= '" .$_SESSION['track']['todate'] . "'";
            $sql .= " ORDER BY [NL] ASC";

            $next = $context -> RunQuery($sql);

            $sql = "SELECT top(1) [id] FROM [" .$table. "]";
            $sql .= " WHERE ";
            $sql .= " [NL] < " .$lastName;
            $sql .= " AND [ME] = ".$course;
            $sql .= " AND [UA] = " . $admin;
            $sql .= " AND [DA] >= '" .$_SESSION['track']['fromdate'] . "'";
            $sql .= " AND [DA] <= '" .$_SESSION['track']['todate'] . "'";
            $sql .= " ORDER BY [NL] DESC";

            $prev = $context -> RunQuery($sql);

            if(!isset($next['id']) && !isset($prev['id']))
                return array("Next" => '', "Prev" => '');
            elseif(!isset($next['id']))
                return array("Next" => '', "Prev" => $prev['id']);
            elseif(!isset($prev['id']))
                return array("Next" => $next['id'], "Prev" => '');
            else
                return array("Next" => $next['id'], "Prev" => $prev['id']);
        }

        public function GetClassMatesRE($lastName, $table, $admin, $course)
        {
            $context = new Db();

            $sql = "SELECT top(1) [id] FROM [" .$table. "]";
            $sql .= " WHERE ";
            $sql .= " [NL] > " .$lastName;
            $sql .= " AND [IL] = ".$course;
            $sql .= " AND [UA] = " . $admin;
            $sql .= " AND [DA] >= '" .$_SESSION['track']['fromdate'] . "'";
            $sql .= " AND [DA] <= '" .$_SESSION['track']['todate'] . "'";
            $sql .= " ORDER BY [NL] ASC";

            $next = $context -> RunQuery($sql);

            $sql = "SELECT top(1) [id] FROM [" .$table. "]";
            $sql .= " WHERE ";
            $sql .= " [NL] < " .$lastName;
            $sql .= " AND [IL] = ".$course;
            $sql .= " AND [UA] = " . $admin;
            $sql .= " AND [DA] >= '" .$_SESSION['track']['fromdate'] . "'";
            $sql .= " AND [DA] <= '" .$_SESSION['track']['todate'] . "'";
            $sql .= " ORDER BY [NL] DESC";

            $prev = $context -> RunQuery($sql);

            if(!isset($next['id']) && !isset($prev['id']))
                return array("Next" => '', "Prev" => '');
            elseif(!isset($next['id']))
                return array("Next" => '', "Prev" => $prev['id']);
            elseif(!isset($prev['id']))
                return array("Next" => $next['id'], "Prev" => '');
            else
                return array("Next" => $next['id'], "Prev" => $prev['id']);

        }
        public function GetStudentCourseData($id, $table)
        {
            $context = new Db();
            $sql = "SELECT [UU],[UC],[UM],[NF],[NL] FROM [". $table ."] WHERE [id] = " . $id;            
            return $context -> RunQuery($sql);
        }

        public function GetCourseData($id)
        {
            $context = new Db();
            $sql = "SELECT [ProductName] FROM [07DS2] WHERE [id] = " . $id;
            return $context -> RunQuery($sql);
        }

        public function GetStudentName($id, $table)
        {
            $context = new Db();
            $sql = "SELECT [NL] FROM [".$table."] WHERE [id] = " . $id;
            return $context -> RunQuery($sql);
        }

        /* THESE FUNCTIONS HANDLE SELF ENROLLMENT PREV / NEXT STUDENT IDS */
        public function GetSelfEnrollClassMatesRE($lastName, $table, $admin, $course)
        {
            $context = new Db();

            $sql = "SELECT TOP (1) [".$table."].[id]";
            $sql .= " FROM [07SL4], [07SL1], [07L3], [".$table."]";
            $sql .= " WITH (NOLOCK)";
            $sql .= " WHERE [07SL4].VC=[07SL1].VC AND [07L3].PRO = [07SL4].id AND [".$table."].UA = [07L3].AN";
            $sql .= " AND [07SL4].IU=". $admin ." AND  [".$table."].DA >= '". $_SESSION['track']['fromdate'] ."' AND [".$table."].DA <= ' ". $_SESSION['track']['todate'] ."'";
            $sql .= " AND [".$table."].[NL] > " .$lastName;
            $sql .= " AND [".$table."].[IL] = '". $course ."'";
            $sql .= " ORDER BY [".$table."].[NL] ASC";

            $next = $context -> RunQuery($sql);

            $sql = "SELECT TOP (1) [".$table."].[id]";
            $sql .= " FROM [07SL4], [07SL1], [07L3], [".$table."]";
            $sql .= " WITH (NOLOCK)";
            $sql .= " WHERE [07SL4].VC=[07SL1].VC AND [07L3].PRO = [07SL4].id AND [".$table."].UA = [07L3].AN";
            $sql .= " AND [07SL4].IU=". $admin ." AND  [".$table."].DA >= '". $_SESSION['track']['fromdate'] ."' AND [".$table."].DA <= ' ". $_SESSION['track']['todate'] ."'";
            $sql .= " AND [".$table."].[NL] < " .$lastName;
            $sql .= " AND [".$table."].[IL] = '". $course ."'";
            $sql .= " ORDER BY [".$table."].[NL] DESC";

            $prev = $context -> RunQuery($sql);

            if(!isset($next['id']) && !isset($prev['id']))
                return array("Next" => '', "Prev" => '');
            elseif(!isset($next['id']))
                return array("Next" => '', "Prev" => $prev['id']);
            elseif(!isset($prev['id']))
                return array("Next" => $next['id'], "Prev" => '');
            else
                return array("Next" => $next['id'], "Prev" => $prev['id']);
        }

        public function GetSelfEnrollClassMatesFS($lastName, $table, $admin, $course)
        {
            $context = new Db();

            $sql = "SELECT TOP (1) [".$table."].[id]";
            $sql .= " FROM [07SL4], [07SL1], [07L3], [".$table."]";
            $sql .= " WITH (NOLOCK)";
            $sql .= " WHERE [07SL4].VC=[07SL1].VC AND [07L3].PRO = [07SL4].id AND [".$table."].UA = [07L3].AN";
            $sql .= " AND [07SL4].IU=". $admin ." AND  [".$table."].DA >= '". $_SESSION['track']['fromdate'] ."' AND [".$table."].DA <= ' ". $_SESSION['track']['todate'] ."'";
            $sql .= " AND [".$table."].[NL] > " .$lastName;
            $sql .= " AND [".$table."].[ME] = '". $course ."'";
            $sql .= " ORDER BY [".$table."].[NL] ASC";

            $next = $context -> RunQuery($sql);

            $sql = "SELECT TOP (1) [".$table."].[id]";
            $sql .= " FROM [07SL4], [07SL1], [07L3], [".$table."]";
            $sql .= " WITH (NOLOCK)";
            $sql .= " WHERE [07SL4].VC=[07SL1].VC AND [07L3].PRO = [07SL4].id AND [".$table."].UA = [07L3].AN";
            $sql .= " AND [07SL4].IU=". $admin ." AND  [".$table."].DA >= '". $_SESSION['track']['fromdate'] ."' AND [".$table."].DA <= ' ". $_SESSION['track']['todate'] ."'";
            $sql .= " AND [".$table."].[NL] < " .$lastName;
            $sql .= " AND [".$table."].[ME] = '". $course ."'";
            $sql .= " ORDER BY [".$table."].[NL] DESC";

            $prev = $context -> RunQuery($sql);

            if(!isset($next['id']) && !isset($prev['id']))
                return array("Next" => '', "Prev" => '');
            elseif(!isset($next['id']))
                return array("Next" => '', "Prev" => $prev['id']);
            elseif(!isset($prev['id']))
                return array("Next" => $next['id'], "Prev" => '');
            else
                return array("Next" => $next['id'], "Prev" => $prev['id']);
        }

        public function GetSelfEnrollClassMates($lastName, $table, $admin)
        {
            $context = new Db();

            $sql = "SELECT TOP (1) [".$table."].[id]";
            $sql .= " FROM [07SL4], [07SL1], [07L3], [".$table."]";
            $sql .= " WITH (NOLOCK)";
            $sql .= " WHERE [07SL4].VC=[07SL1].VC AND [07L3].PRO = [07SL4].id AND [".$table."].UA = [07L3].AN";
            $sql .= " AND [07SL4].IU=". $admin ." AND  [".$table."].DA >= '". $_SESSION['track']['fromdate'] ."' AND [".$table."].DA <= ' ". $_SESSION['track']['todate'] ."'";
            $sql .= " AND [".$table."].[NL] > " .$lastName;
            $sql .= " ORDER BY [".$table."].[NL] ASC";

            $next = $context -> RunQuery($sql);

            $sql = "SELECT TOP (1) [".$table."].[id]";
            $sql .= " FROM [07SL4], [07SL1], [07L3], [".$table."]";
            $sql .= " WITH (NOLOCK)";
            $sql .= " WHERE [07SL4].VC=[07SL1].VC AND [07L3].PRO = [07SL4].id AND [".$table."].UA = [07L3].AN";
            $sql .= " AND [07SL4].IU=". $admin ." AND  [".$table."].DA >= '". $_SESSION['track']['fromdate'] ."' AND [".$table."].DA <= ' ". $_SESSION['track']['todate'] ."'";
            $sql .= " AND [".$table."].[NL] < " .$lastName;
            $sql .= " ORDER BY [".$table."].[NL] DESC";

            $prev = $context -> RunQuery($sql);

            if(!isset($next['id']) && !isset($prev['id']))
                return array("Next" => '', "Prev" => '');
            elseif(!isset($next['id']))
                return array("Next" => '', "Prev" => $prev['id']);
            elseif(!isset($prev['id']))
                return array("Next" => $next['id'], "Prev" => '');
            else
                return array("Next" => $next['id'], "Prev" => $prev['id']);
        }
    }
?>