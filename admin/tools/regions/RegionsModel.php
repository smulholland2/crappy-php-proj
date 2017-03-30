<?php

    include_once $_SERVER['DOCUMENT_ROOT']."/config/connection.php";

    class RegionsModel
    {
        public function GetRegionsList($admin)
        {
            $context = new Db();

            $sql = "SELECT [UU],[NF],[NL] FROM [07L2] WHERE [SUB] =" . $admin . " AND [UU] != " . $admin;
            return $context -> RunQuery($sql);
        }

        public function Add($region, $admin)
        {
            $context = new Db();

            $sql = "INSERT INTO [07L2] ([UU], [UC], [NF], [NL], [AA], [ASTU], [SUB],
                [TRAIN_PERIOD],[QUIZ],[AUTOEMAIL],[RECEMAIL],[NOTIFYADMIN],[LESPERWK],[MINSCORE],[MINLIC],[REORDER],[SKIP],[SKIPH],[SKIPR],
                [SKIPC],[SKIPHA],[SKIPSF],[SKIPE],[TIMEOUT],[LESSONTIME],[MULTSTU],[F90],[FRANCHISESET],[IS_AI],[FORCECOR],[EXPNOTICE]
                ) VALUES (
                    " . $region['regionid'] . ",
                    " . $region['password'] . ",
                    " . $region['firstname'] . ",
                    " . $region['lastname'] . ",
                    " . $region['addunit'] . ",
                    " . $region['addstudent'] . ",
                    " . $admin . ",
                    " . $region['TRAIN_PERIOD'] . ",
                    " . $region['QUIZ'] . ",
                    " . $region['AUTOEMAIL'] . ",
                    " . $region['RECEMAIL'] . ",
                    " . $region['NOTIFYADMIN'] . ",
                    " . $region['LESPERWK'] . ",
                    " . $region['MINSCORE'] . ",
                    " . $region['MINLIC'] . ",
                    " . $region['REORDER'] . ",
                    " . $region['SKIP'] . ",
                    " . $region['SKIPH'] . ",
                    " . $region['SKIPR'] . ",
                    " . $region['SKIPC'] . ",
                    " . $region['SKIPHA'] . ",
                    " . $region['SKIPSF'] . ",
                    " . $region['SKIPE'] . ",
                    " . $region['TIMEOUT'] . ",
                    " . $region['LESSONTIME'] . ",
                    " . $region['MULTSTU'] . ",
                    " . $region['F90'] . ",
                    " . $region['FRANCHISESET'] . ",
                    " . $region['IS_AI'] . ",
                    " . $region['FORCECOR'] . ",
                    " . $region['EXPNOTICE'] . "

                )";

            return $context -> RunQuery($sql);
        }

        public function Edit($region, $admin)
        {
            $context = new Db();

            $sql = "UPDATE [07L2] SET [UC] = " . $region['password'] .
            ",[NF] = " . $region['firstname'] .
            ",[NL] = " . $region['lastname'] .
            ",[AA] = " . $region['addunit'] .
            ",[ASTU] = " . $region['addstudent'] .
            " WHERE [SUB] = " . $admin .
            " AND [UU] = " . $region['regionid'];

            return $context -> RunInsert($sql);
        }

        public function Delete($region, $admin)
        {
            $context = new Db();

            $sql = "DELETE FROM [07L2] WHERE [UU] = ". $region['regionid'] . " AND [SUB] = " . $admin;

            return $context -> RunDelete($sql);
        }

        public function GetRegion($region, $admin)
        {
            $context = new Db();

            $sql = "SELECT [UU], [UC], [NF], [NL], [AA], [ASTU] FROM [07L2] WHERE [UU] = ". $region . " AND [SUB] = " . $admin;

            return $context -> RunQuery($sql);
        }

        public function GetAdminDetails($admin)
        {
            $context = new Db();

            $sql = "SELECT [TRAIN_PERIOD],[QUIZ],[AUTOEMAIL],[RECEMAIL],[NOTIFYADMIN],[LESPERWK],[MINSCORE],[MINLIC],[REORDER],[SKIP],[SKIPH],[SKIPR],
                [SKIPC],[SKIPHA],[SKIPSF],[SKIPE],[TIMEOUT],[LESSONTIME],[MULTSTU],[F90],[FRANCHISESET],[IS_AI],[FORCECOR],[EXPNOTICE]
                 FROM [07L2] WHERE [UU] = ". $admin;

            return $context -> RunQuery($sql);
        }
    }

?>