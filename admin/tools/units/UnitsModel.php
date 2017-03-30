<?php

    include_once $_SERVER['DOCUMENT_ROOT']."/config/connection.php";

    class UnitsModel
    {
        public function GetUnitsList($admin)
        {
            $connector = new Db();

            // First get [07L3].[AN] using the current user. 
            $sql = "SELECT [07L3].[AN]
                    FROM [07L3]
                    INNER JOIN [07L2]
                    ON [07L3].[CA] = [07L2].[id]
                    WHERE [07L2].[UU] =" . $admin;
            return $connector -> RunQuery($sql);
        }

        public function GetUnitBasicInfo($name)
        {
            $connector = new Db();

            $sql = "SELECT [AN], [NCON] FROM [07O6] WHERE [AN] = '" . $name ."'";
            return $connector -> RunQuery($sql);
        }

        public function GetRegionList($admin, $isRegion = false)
        {
            $connector = new Db();

            if(!$isRegion)
                $sql = "SELECT [id],[UU] FROM [07L2] WHERE [SUB] = " . $admin;
            else
                $sql = "SELECT [id],[UU] FROM [07L2] WHERE [UU] = " . $admin;

            return $connector -> RunQuery($sql);
        }

        public function GetCorpAdmin($admin)
        {
            $connector = new Db();
            $sql = "SELECT [SUB] FROM [07L2] WHERE [UU] = " . $admin;
            $corpUser = $connector -> RunQuery($sql);
            $sql = "SELECT [id] FROM [07L2] WHERE [UU] = '" . $corpUser['SUB'] . "'";
            $corpId = $connector -> RunQuery($sql);
            return Array("corpUser" => $corpUser['SUB'], "corpId" => $corpId['id'] );
        }

        public function Add($_unitdata)
        {
            $connector = new Db();
            $sql = "INSERT INTO [07L3] ([AN],[AC],[CA]) VALUES (";
            $sql .= $_unitdata['unitid'] . ",";
            $sql .= $_unitdata['password'] . ",";
            $sql .= $_unitdata['regionid'] . ")";            

            $connector -> RunInsert($sql);

            $sql = "INSERT INTO [07O6] ([AN],[NCPY],[NCON],[AA1],[ACI],[AST],[AZ],[ACO],[AP],[AM]) VALUES (";
            $sql .= $_unitdata['unitid'] . ",";
            $sql .= $_unitdata['unitname'] . ",";
            $sql .= $_unitdata['firstlast'] . ",";
            // TODO: ADD form fields and validation for adress information.
            $sql .= "' ',";// Blank space
            $sql .= "' ',";// Blank space
            $sql .= "' ',";// Blank space
            $sql .= "' ',";// Blank space
            $sql .= "' ',";// Blank space
            $sql .= "' ',";// Blank space
            $sql .= $_unitdata['email'] . ")";

            $connector -> RunInsert($sql);
        }

        public function Edit($_unitdata)
        {
            $connector = new Db();
            $sql = "UPDATE [07L3] SET ";
            $sql .= "[AC] = " . $_unitdata['password'];
            $sql .= ",[CA] = " . $_unitdata['regionid'];
            $sql .= " WHERE [AN] = ". $_unitdata['unitid'];

            $connector -> RunInsert($sql);

            $sql = "UPDATE [07O6] SET ";
            $sql .= "[NCPY] = " . $_unitdata['unitname'] . ",";
            $sql .= "[NCON] = " . $_unitdata['firstlast'] . ",";
            $sql .= "[AM] = " . $_unitdata['email'];
            $sql .= " WHERE [AN] = ". $_unitdata['unitid']; 

            $connector -> RunInsert($sql);
        }

        public function GetSingleUnit($admin, $unitid)
        {
            $connector = new Db();
            $sql = "SELECT [AN], [AC], [CA] FROM [07L3] WHERE [AN] = " . $unitid;
            $unitcredentials = $connector -> RunQuery($sql);

            $sql = "SELECT [AN], [NCPY], [NCON], [AM] FROM [07O6] WHERE [AN] = " . $unitid;
            $unitinfo = $connector -> RunQuery($sql);

            $name = explode(" ", $unitinfo['NCON']);

            $singleunit = Array(
                'AccountName' => $unitcredentials['AN'],
                'Password'    => $unitcredentials['AC'],
                'RegionId'    => $unitcredentials['CA'],
                'UnitName'     => $unitinfo['NCPY'],
                'Email'       => $unitinfo['AM'],
                'FirstName'   => $name[0],
                'LastName'    => $name[count($name) - 1]
            );

            return $singleunit;
        }
    }

?>