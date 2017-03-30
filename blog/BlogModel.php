<?php

    include_once $_SERVER["DOCUMENT_ROOT"]."/config/connection.php";
    include_once $_SERVER["DOCUMENT_ROOT"]."/lib/Helper.php";

    class BlogModel
    {
        public function GetAllPosts()
        {
            $context = new Db();

            $stmt = 'GetAllPosts';

            return $context -> ExecuteStoredProcedureNoArg($stmt);
        }

        public function GetPostsByTag($tag)
        {
            $context = new Db();

            $stmt = 'GetPostsByTagName';

            $param = '@tag';

            return $context -> ExecuteStoredProcedureSingleArg($stmt,$tag,$param);
        }

        public function GetPostsByDate($from, $to)
        {
            $context = new Db();

            $stmt = 'GetPostsByDate';

            $param = '@date';

            return $context -> ExecuteStoredProcedureSingleVarchar($stmt,$title,$param);
        }

        public function GetPostById($id)
        {

        }

        public function GetPostByTitle($title)
        {
            $context = new Db();

            $stmt = 'GetPostByTitle';

            $param = '@title';

            return $context -> ExecuteStoredProcedureSingleVarchar($stmt,$title,$param);
        }

        public function GetTagCloud()
        {
            $context = new Db();

            $stmt = 'GetAllTagNames';

            return $context -> ExecuteStoredProcedureNoArg($stmt);
        }

        public function GetArchiveDates()
        {
            $context = new Db();

            $stmt = 'GetArchiveDates';

            return $context -> ExecuteStoredProcedureNoArg($stmt);
        }
    }
?>