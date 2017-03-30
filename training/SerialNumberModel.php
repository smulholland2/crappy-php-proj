<?php

    include_once $_SERVER['DOCUMENT_ROOT']."/config/connection.php";

    class SerialNumberModel
    {
        public function GetSerialAccount($username)
        {
            $context = new Db();
            $sql = "SELECT * FROM [SerialNumber] WHERE [SERIAL] = " .$username;
            return $context -> RunQuery($sql);
        }

        public function GetSerialOwner($username)
        {
            $context = new Db();
            $sql = "SELECT * FROM [SerialNumber] WHERE [SERIAL] = " .$username;

            return $context -> RunQuery($sql);
        }

        public function GetProductId($proId)
        {
            $context = new Db();
            $sql = "SELECT [id] FROM [07DS2] WHERE [ProId] = '" .$proId ."'";
            return $context -> RunQuery($sql);
        }
    }

?>