<?php

    /**
    *
    * This class provides corporate and region administrators
    * the ability to add classes to their accounts.
    *
    * Author: Steve Mulholland
    * Date  : 12/01/2016
    * Chimera Soultions
    *
    **/

    include_once $_SERVER['DOCUMENT_ROOT'].'/admin/tools/units/UnitsModel.php';
    include_once $_SERVER['DOCUMENT_ROOT']."/lib/Helper.php";
    
    class UnitsController
    {
        private $model   = null;

        public $admin      = null;
        public $corpadmin  = [];
        public $units      = [];

        public function __construct($_post = null)
        {
            $validator = new Helper();
            if(!isset($_SESSION))
		        session_start();

            if(isset($_POST['regionid']))
                $this -> admin = $validator -> CleanAdmin($_POST['regionid']);
            else
                $this -> admin = $validator -> CleanAdmin($_SESSION["user"]);
                
            $this -> model = new UnitsModel();
        }

        public function UnitsList()
        {
            //$this -> Validate();

            // Store the account names so we can iterate over them and get individual account data.
            $accountnames = $this -> model -> GetUnitsList($this -> admin);

            // Then use [07O6] to gather the rest of the data unit admin data.
            if(count($accountnames) == 1)
            {
                $unit = $this -> model -> GetUnitBasicInfo($accountnames["AN"]);

                if(isset($unit))
                {                    
                    $name = explode(" ", $unit["NCON"]);
                    $formatedunit = [];
                    $formatedunit["AN"] = $unit["AN"];
                    $formatedunit["NL"] = $name[0];
                    $formatedunit["NF"] = $name[count($name) - 1];
                    array_push($this -> units, $formatedunit);
                }
            }
            else
            {
                for($i = 0; $i < count($accountnames); $i++)
                {
                    $unit = $this -> model -> GetUnitBasicInfo($accountnames[$i]["AN"]);

                    if(isset($unit) && count($unit) > 0)
                    {
                        $name = explode(" ", $unit["NCON"]);
                        $formatedunit = [];
                        $formatedunit["AN"] = $unit["AN"];
                        $formatedunit["NL"] = $name[0];
                        $formatedunit["NF"] = $name[count($name) - 1];
                        array_push($this -> units, $formatedunit);
                    }
                }
            }            

            return $this -> units;
        }

        public function AddUnit($edit = false)
        {
            $validator = new Helper();
            $unitdata = null;

            $validated = preg_match($validator::LETNUMREGEX, $_POST['unitid']) ? true : false;

            if($validated)
            {
                $unitdata['unitid'] = $validator -> mssql_escape($_POST['unitid']);
            }
            
            if($validated)
            {
                $validated = preg_match($validator::LETNUMREGEX, $_POST['password']) ? true : false;
                $validated = preg_match($validator::LETNUMREGEX, $_POST['verify']) ? true : false;

                if($_POST['password'] === $_POST['verify'])
                    $unitdata['password'] = $validator -> mssql_escape($_POST['password']);
                else
                    $validated = false;
            }
            
            if($validated)
            {
                $validated = preg_match($validator::LETNUMREGEX, $_POST['regionid']) ? true : false;
                $unitdata['regionid'] = $validator -> mssql_escape($_POST['regionid']);
            }
            
            if($validated)
            {
                $validated = preg_match($validator::LETNUMREGEX, $_POST['addpermission']) ? true : false;
                $unitdata['addpermission'] = $validator -> mssql_escape($_POST['addpermission']);
            }
            
            if($validated)
            {
                //$validated = preg_match($validator::COMPANYNAMEREGEX, $_POST['unitname']) ? true : false;
                $unitdata['unitname'] = $validator -> mssql_escape($_POST['unitname']);
            }
            
            if($validated)
            {
                $validated = preg_match($validator::LETNUMREGEX, $_POST['firstname']) ? true : false;
                $unitdata['firstname'] = $validator -> mssql_escape($_POST['firstname']);
            }

            if($validated)
            {
                $validated = preg_match($validator::LETNUMREGEX, $_POST['lastname']) ? true : false;
                $firstlast = $_POST['firstname'] . " " . $_POST['lastname'];
                $unitdata['firstlast'] = $validator -> mssql_escape($firstlast);
            }
            
            if($validated)
            {
                $validated = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ? true : false;
                $unitdata['email'] = $validator -> mssql_escape($_POST['email']);
            }
            
            if($validated && isset($unitdata))
            {
                if(!$edit)
                    return $this -> model -> Add($unitdata);
                else
                    return $this -> model -> Edit($unitdata);
                exit;
            }
        }

        public function RegionList()
        {
            $list = $this -> model -> GetRegionList($this -> admin);
            
            if(count($list) == 0)
            {
                $this -> corpadmin = $this -> model -> GetCorpAdmin($this -> admin);
                // Since we are grabbing this data directly from the db, there is no reason to encode it.
                $list = $this -> model -> GetRegionList($this -> admin, true);
            }

            return $list;
        }

        public function SingleUnit()
        {
            $validator = new Helper();
            $validated = preg_match($validator::LETNUMREGEX, $_POST['unitid']) ? true : false;

            if($validated)
                $unitdata['unitid'] = $validator -> mssql_escape($_POST['unitid']);

            if($validated && isset($unitdata))
            {
                return $this -> model -> GetSingleUnit($this -> admin, $unitdata['unitid']);
                exit;
            }
        }
    }

?>