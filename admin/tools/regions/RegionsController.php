<?php
    include_once $_SERVER['DOCUMENT_ROOT']."/lib/Helper.php";
    include_once $_SERVER['DOCUMENT_ROOT']."/admin/tools/regions/RegionsModel.php";

    class RegionsController
    {

        const ADDFORM    = 0;
        const EDITFORM   = 1;
        const DELETEFORM = 2;

        private $model   = null;

        public $admin    = null;
        public $regions  = [];

        public function __construct($_post = null)
        {
            $validator = new Helper();

            if(!isset($_SESSION))
		        session_start();

            $this -> admin = $validator -> CleanAdmin($_SESSION["user"]);

            $this -> model = new RegionsModel();
        }

        public function RegionsList()
        {
            //$this -> Validate();

            // Store the account names so we can iterate over them and get individual account data.
            $regions = $this -> model -> GetRegionsList($this -> admin);

            return $regions;
        }

        public function ValidateRegion($type = 0)
        {
            $validator = new Helper();
            $errors = [];
            $regionok = false;

            if(isset($_POST['deleteregion']))
                $_POST['regionid'] = $_POST['deleteregion'];

            if(isset($_POST['regionid']))
                if(strlen($_POST['regionid']) > 0 && preg_match($validator::LETNUMREGEX, $_POST['regionid']))
                {
                    $regiondata['regionid'] = $validator -> mssql_escape($_POST['regionid']);
                    $regionok = true;
                }
                else
                    array_push($errors, 'Region ID field is invalid.');
            else
                array_push($errors, 'Region ID field is required.');

            if(isset($_POST['password']) && strlen($_POST['password']) > 0)
                if(strlen($_POST['password']) > 0 && preg_match($validator::PASSWORDCHARS, $_POST['password']))
                    $regiondata['password'] = $validator -> mssql_escape($_POST['password']);
                else
                    array_push($errors, 'Password field is invalid.');
            else
                array_push($errors, 'Password field is required.');

            if(isset($_POST['verify']) && strlen($_POST['verify']) > 0)
                if(strlen($_POST['verify']) > 0 && preg_match($validator::PASSWORDCHARS, $_POST['verify']))
                    $regiondata['verify'] = $validator -> mssql_escape($_POST['verify']);
                else
                    array_push($errors, 'Verify Password field is invalid.');
            else
                array_push($errors, 'Verify Password field is required.');

            if(isset($_POST['verify']) && isset($_POST['password']))
                if($_POST['verify'] != $_POST['password'])
                    array_push($errors, 'Passwords do not match.');

            if(isset($_POST['firstname']) && strlen($_POST['firstname']) > 0)
                if(strlen($_POST['firstname']) > 0 && preg_match($validator::NAMECHARS, $_POST['firstname']))
                    $regiondata['firstname'] = $validator -> mssql_escape($_POST['firstname']);
                else
                    array_push($errors, 'First Name field is invalid.');
            else if(isset($_POST['firstname']) && strlen($_POST['firstname']) < 1)
                $regiondata['firstname'] = '\'\'';
            else
                array_push($errors, 'An unknown error has occured. Please reload the page');

            if(isset($_POST['lastname']) && strlen($_POST['lastname']) > 0)
                if(strlen($_POST['lastname']) > 0 && preg_match($validator::NAMECHARS, $_POST['lastname']))
                    $regiondata['lastname'] = $validator -> mssql_escape($_POST['lastname']);
                else
                    array_push($errors, 'Last Name field is invalid.');
            else if(isset($_POST['lastname']) && strlen($_POST['lastname']) < 1)
                $regiondata['lastname'] = '\'\'';
            else
                array_push($errors, 'An unknown error has occured. Please reload the page');

            if(isset($_POST['addunit']))
                if(($_POST['addunit'] == 1 || $_POST['addunit'] == 0 ))
                    $regiondata['addunit'] = $_POST['addunit'];
                else
                    array_push($errors, 'Add Unit field is invalid.');
            else
                $regiondata['addunit'] = 0;

            if(isset($_POST['addstudent']))
                if(($_POST['addstudent'] == 1 || $_POST['addstudent'] == 0))
                    $regiondata['addstudent'] = $_POST['addstudent'];
                else
                    array_push($errors, 'Add Student field is invalid.');
            else
                $regiondata['addstudent'] = 0;
            
            if(count($errors) == 0 || ($type == self::DELETEFORM && $regionok))
            {
                if($type == self::ADDFORM)
                {
                    $admindata = $this -> model -> GetAdminDetails($this ->admin);
                    $newregion = array_merge($regiondata, $admindata);
                    return $this -> model -> Add($newregion, $this ->admin);
                }                    
                else if($type == self::EDITFORM)
                    return $this -> model -> Edit($regiondata, $this ->admin);
                else if($type == self::DELETEFORM)
                    return $this -> model -> Delete($regiondata, $this ->admin);
                exit;
            }
            else
                return $errors;
        }

        public function RegionList()
        {
            return $this -> model -> GetRegionList($this -> admin);
        }

        public function CurrentRegion()
        {
            $validator = new Helper();
            $validated = preg_match($validator::LETNUMREGEX, $_POST['regionid']) ? true : false;

            if($validated)
                $regiondata['regionid'] = $validator -> mssql_escape($_POST['regionid']);

            if($validated && isset($regiondata))
            {
                $region =  $this -> model -> GetRegion($regiondata['regionid'], $this -> admin);

                $region["AA"] == 1 ? $region["AA"] = 'checked' : '';
                $region["ASTU"] == 1 ? $region["ASTU"] = 'checked' : '';

                return $viewmodel = Array(
                    "RegionID" => $region["UU"],
                    "Password" => $region["UC"],
                    "FirstName" => $region["NF"],
                    "LastName" => $region["NL"],
                    "AddUnit" => $region["AA"],
                    "AddStudent" => $region["ASTU"],
                );

                exit;
            }
        }
    }
?>