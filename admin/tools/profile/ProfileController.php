<?php

    include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/tools/profile/ProfileModel.php";
    include_once $_SERVER['DOCUMENT_ROOT'] . "/lib/Helper.php";

    class ProfileController
    {
        public function __construct($_post = null)
        {
            if(!isset($_SESSION))
		        session_start();

            $this -> model = new ProfileModel();

            $validator = new Helper();

            $this -> admin = $validator -> CleanAdmin($_SESSION["user"]);            
        }

        public function CurrentProfile()
        {            
            $profile = $this -> model -> GetProfile($this -> admin);

            return $viewmodel = Array(
                "UserName" => $profile["UU"],
                "Password" => $profile["UC"],
                "FirstName" => $profile["NF"],
                "LastName" => $profile["NL"],
                "Company" => $profile["UA"],
                "Address1" => $profile["AA1"],
                "Address2" => $profile["AA2"],
                "City" => $profile["ACI"],
                "State" => $profile["AST"],
                "Zip" => $profile["AZ"],
                "Country" => $profile["ACO"],
                "Email" => $profile["UM"],
                "Phone" => $profile["AP"],
                "Fax" => $profile["AF"]
            );
        }

        public function Edit()
        {
            $validator = new Helper();
            $errors = [];

            if(strlen($_POST['email']) > 0)
                $validated = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ? true : false;

            if($validated)
            {
                $profiledata['email'] = $validator -> mssql_escape($_POST['email']);
            }
            else if(!$validated && (strlen($_POST['email']) < 1 || !isset($_POST['email'])))
                array_push($errors, 'Email field is invalid.');

            if($validated)
            {
                $validated = preg_match($validator::PASSWORDCHARS, $_POST['password']) ? true : false;
                $validated = preg_match($validator::PASSWORDCHARS, $_POST['verify']) ? true : false;

                if($_POST['password'] === $_POST['verify'])
                    $profiledata['password'] = $validator -> mssql_escape($_POST['password']);
                else {
                    $validated = false;
                    array_push($errors, 'Passwords do not match.');
                }
            }
            else if(!$validated && (strlen($_POST['password']) < 1 || !isset($_POST['password'])))
                array_push($errors, 'Password field is invalid.');

            if($validated)
            {
                $validated = preg_match($validator::NAMECHARS, $_POST['firstname']) ? true : false;
                $profiledata['firstname'] = $validator -> mssql_escape($_POST['firstname']);
            }
            else if(!$validated && (strlen($_POST['firstname']) < 1 || !isset($_POST['firstname'])))
                array_push($errors, 'First Name field is invalid.');

            if($validated)
            {
                $validated = preg_match($validator::NAMECHARS, $_POST['lastname']) ? true : false;
                $profiledata['lastname'] = $validator -> mssql_escape($_POST['lastname']);
            }
            else if(!$validated && strlen($_POST['lastname']) < 1 || !isset($_POST['lastname']))
                array_push($errors, 'Last Name field is invalid.');

            if($validated)
            {
                $validated = preg_match($validator::NAMECHARS, $_POST['company']) ? true : false;
                $profiledata['company'] = $validator -> mssql_escape($_POST['company']);
            }
            else if(!$validated && (strlen($_POST['company']) < 1 || !isset($_POST['company'])))
                array_push($errors, 'Company field is invalid.');

            if($validated)
            {
                $validated = preg_match($validator::ADDRESSCHARS, $_POST['address1']) ? true : false;
                $profiledata['address1'] = $validator -> mssql_escape($_POST['address1']);
            }
            else if(!$validated && (strlen($_POST['address1']) < 1 || !isset($_POST['address1'])))
                array_push($errors, 'Address 1 field is invalid.');

            if($validated && isset($_POST['address2']))
            {
                if(strlen($_POST['address2'] > 0)){
                    $validated = preg_match($validator::ADDRESSCHARS, $_POST['address2']) ? true : false;
                    $profiledata['address2'] = $validator -> mssql_escape($_POST['address2']);
                } else
                    $profiledata['address2'] = '\'\'';
            }
            else if(!isset($_POST['address2']))
                $profiledata['address2'] = '\'\'';

            if($validated)
            {
                $validated = preg_match($validator::ADDRESSCHARS, $_POST['city']) ? true : false;
                $profiledata['city'] = $validator -> mssql_escape($_POST['city']);
            }
            else if(!$validated && (strlen($_POST['city']) < 1 || !isset($_POST['city'])))
                array_push($errors, 'City field is invalid.');

            if($validated)
            {
                $validated = preg_match($validator::ADDRESSCHARS, $_POST['state']) ? true : false;
                $profiledata['state'] = $validator -> mssql_escape($_POST['state']);
            }
            else if(!$validated && (strlen($_POST['state']) < 1 || !isset($_POST['state'])))
                array_push($errors, 'State field is invalid.');

            if($validated)
            {
                $validated = preg_match($validator::NUMBERONLY, $_POST['zip']) ? true : false;
                $profiledata['zip'] = $validator -> mssql_escape($_POST['zip']);
            }
            else if(!$validated && (strlen($_POST['zip']) < 1 || !isset($_POST['zip'])))
                array_push($errors, 'Zip field is invalid.');

            if($validated)
            {
                $validated = preg_match($validator::ADDRESSCHARS, $_POST['country']) ? true : false;
                $profiledata['country'] = $validator -> mssql_escape($_POST['country']);
            }
            else if(!$validated && (strlen($_POST['country']) < 1 || !isset($_POST['country'])))
                array_push($errors, 'Country field is invalid.');

            if($validated)
            {
                $validated = preg_match($validator::NUMBERONLY, $_POST['phone']) ? true : false;
                $profiledata['phone'] = $validator -> mssql_escape($_POST['phone']);
            }
            else if(!$validated && (strlen($_POST['phone']) < 1 || !isset($_POST['phone'])))
                array_push($errors, 'Phone Number field is invalid.');

            if($validated && isset($_POST['fax']))
            {
                if(strlen($_POST['fax'] > 0)){
                    $validated = preg_match($validator::NUMBERONLY, $_POST['fax']) ? true : false;
                    $profiledata['fax'] = $validator -> mssql_escape($_POST['fax']);
                } else {
                    $profiledata['fax'] = '\'\'';
                }
            }
            else if(!isset($_POST['fax']))
                $profiledata['fax'] = '\'\'';
            

            // Everything is validated so let's run the update query.
            if($validated)
            {
                return $this -> model -> EditProfile($profiledata, $this-> admin);
            }
            else
                return $errors;
        }

        public function CorrectAnswersRequired()
        {
            $profile = $this -> model -> GetCorrectAnswersRequired($this -> admin);

            $change = $profile['FORCECOR'] == 1 ? 0 : 1;
            $text = $profile['FORCECOR'] == 1 ? 'required' : 'not required';
            $button = $profile['FORCECOR'] == 1 ? 'Disable' : 'Enable';

            return $viewmodel = Array(
                "Change" => $change,
                "EnabledText" => $text,
                "EnabledButton" => $button
            );
        }

        public function RequirementChange()
        {
            $errors = [];

            if(isset($_POST['forcecor']))
                if(($_POST['forcecor'] == 1 || $_POST['forcecor'] == 0 ))
                    $forcecor = $_POST['forcecor'];
                else
                    array_push($errors, 'Correct answer requirement is invalid.');
            else
                $forcecor = 0;

            if(count($errors) == 0)
            {
                return $this -> model -> SetCorrectAnswersRequired($forcecor, $this -> admin);
            }
        }
    }

?>