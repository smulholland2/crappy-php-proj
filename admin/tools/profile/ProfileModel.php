<?php

    include_once $_SERVER['DOCUMENT_ROOT'] . "/config/connection.php";

    class ProfileModel
    {
        public function GetProfile($admin)
        {
            $context = new Db();

            $sql = "SELECT [UU],[UC],[NF],[NL],[UA],[AA1],[AA2],[ACI],[AST],[AZ],[ACO],[UM],[AP],[AF]
             FROM [07L2] WHERE [UU] = " . $admin;

            return $context -> RunQuery($sql);
        }

        public function EditProfile($data, $admin)
        {
            $context = new Db();

            $sql = "UPDATE [07L2] SET
            [UC] = ".$data['password'].",
            [NF] = ".$data['firstname'].",
            [NL] = ".$data['lastname'].",
            [UA] = ".$data['company'].",
            [AA1] = ".$data['address1'].",
            [AA2] = ".$data['address2'].",
            [ACI] = ".$data['city'].",
            [AST] = ".$data['state'].",
            [AZ] = ".$data['zip'].",
            [ACO] = ".$data['country'].",
            [UM] = ".$data['email'].",
            [AP] = ".$data['phone'].",
            [AF] = ".$data['fax']." WHERE [UU] = " . $admin;

            return $context -> RunInsert($sql);
        }

        public function GetCorrectAnswersRequired($admin)
        {
            $context = new Db();

            $sql = "SELECT [FORCECOR] FROM [07L2] WHERE [UU] = " . $admin;

            return $context -> RunQuery($sql);
        }

        public function SetCorrectAnswersRequired($forcecor, $admin)
        {
            $context = new Db();

            $sql = "UPDATE [07L2] SET [FORCECOR] = ". $forcecor ." WHERE [UU] = " . $admin;

            return $context -> RunInsert($sql);
        }
    }

?>