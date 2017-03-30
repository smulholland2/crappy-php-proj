<?php

    /**
    *
    * This class provides administrators the ability 
    * to view and modify their students SFIS progress.
    *
    * Author: Steve Mulholland
    * Date  : 12/01/2016
    * Chimera Soultions
    *
    **/
    include_once $_SERVER['DOCUMENT_ROOT']."/config/connection.php";
    include_once $_SERVER['DOCUMENT_ROOT']."/lib/Helper.php";

    class SFISController
    {
        public $admin    = null;
        public $student  = [];
        public $guestcard = [];

        public function __constructor()
        {

        }

        public function GetStudentList()
        {
            if(!isset($_SESSION))
		        session_start();
            $this -> admin = $_SESSION["user"];
            $this -> Validate();
            $sql = "SELECT id, NF, NL, DA FROM [05D] WHERE UA = " . $this -> admin;
            return $this -> student = $this -> RunQuery($sql);
        }

        public function GetStudent($_post)
        {
            if(!isset($_SESSION))
		        session_start();
            $this -> admin = $_SESSION["user"];
            $this -> Validate($_post);
            $sql = "SELECT UU, UC, NF, NL, UM, DA FROM [05D] WHERE id=" . $this -> student["studentid"];
            return $this -> student = $this -> RunQuery($sql);
        }

        public function GetCommentCard()
        {
            $sql = "SELECT * FROM [05F03] WHERE UU='" . $this -> student ."'";
            return $this -> RunQuery($sql);
        }

        public function UpdateCommentCard($_post)
        {
            $this -> Validate($_post);
            $sql = "UPDATE [05F03] SET ";
            $sql .= "GCTitle = '" . $this -> guestcard["Title"] ."'";
            $sql .= "GCIntro = '" . $this -> guestcard["Intro"] . "'";
            $sql .= "GCSer1 = '" . $this -> guestcard["Ser1"] . "'";
            $sql .= "GCSer2 = '" . $this -> guestcard["Ser2"] . "'";
            $sql .= "GCSer3 = '" . $this -> guestcard["Ser3"] . "'";
            $sql .= "GCFoo1 = '" . $this -> guestcard["Foo1"] . "'";
            $sql .= "GCFoo2 = '" . $this -> guestcard["Foo2"] . "'";
            $sql .= "GCFoo3 = '" . $this -> guestcard["Foo3"] . "'";
            $sql .= "GCFac1 = '" . $this -> guestcard["Fac1"] . "'";
            $sql .= "GCFac2 = '" . $this -> guestcard["Fac2"] . "'";
            $sql .= "GCFac3 = '" . $this -> guestcard["Fac3"] . "'";
            $sql .= "GCQ1 = '" . $this -> guestcard["Q1"] . "'";
            $sql .= "GCQ2 = '" . $this -> guestcard["Q2"] . "'";
            $sql .= "GCQ3 = '" . $this -> guestcard["Q3"] . "'";
            $sql .= "GCQ4 = '" . $this -> guestcard["Q4"] . "'";
            $sql .= "GCQ5 = '" . $this -> guestcard["Q5"] . "'";
            $sql .= "GCQ6 = '" . $this -> guestcard["Q6"] . "'";
            $sql .= "WHERE UU = '" . $this -> student["user"] . "'";

            return $this -> RunQuery($sql);
        }

        private function Validate($_student = null)
        {
            $sanitizer = new Helper();

            $this -> admin = isset($this -> admin) ? $sanitizer -> mssql_escape($this -> admin) : null; 
            $this -> student["studentid"] = isset($_student["studentid"]) ? $sanitizer -> mssql_escape($_student["studentid"]) : null;
            //$this -> student["username"] = isset($_student["username"]) ? $sanitizer -> mssql_escape($_student["username"]) : null;
            //$this -> student["password"] = isset($_student["password"]) ? $sanitizer -> mssql_escape($_student["password"]) : null;
            
        }

        private function RunQuery($sql)
        {
            $conn = Db::getInstance();
            $response["rows"] = [];
            
            $stmt = mssql_query ( $sql , $conn );
            if( $stmt === false ) {
                //$this -> Failed(self::INVALIDQUERYEC);
            } else {
                while($row = mssql_fetch_assoc($stmt)) {                    
                    array_push($response["rows"], $row);
                }
                return $response["rows"];        
            }
        }
    }

?>