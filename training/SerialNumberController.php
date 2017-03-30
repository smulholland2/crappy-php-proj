<?php

    include_once $_SERVER['DOCUMENT_ROOT']."/training/SerialNumberModel.php";
    include_once $_SERVER['DOCUMENT_ROOT']."/lib/Helper.php";

    class SerialNumberController
    {
        public $model   = null;

        public function __construct()
        {
            $this -> model = new SerialNumberModel();

            if(isset($_SESSION))
                if(isset($_SESSION['Serial']))
                    unset($_SESSION['Serial']);
        }

        public function LookupKey($licenseKey)
        {
            $validator = new Helper();
            $key['data'] = [];
            $key['data']['errors'] = [];

            if(isset($licenseKey) && strlen($licenseKey) > 0)
                if(strlen($licenseKey) > 0 && preg_match($validator::PASSWORDCHARS, $licenseKey))
                    $licenseKey = $validator -> mssql_escape($licenseKey);
                else
                    array_push($key['data']['errors'], 'User name is invalid.');
            else
                array_push($key['data']['errors'], 'User name is required.');

            if(count($key['data']['errors']) == 0)
            {
                $serialAccount = $this -> model -> GetSerialAccount($licenseKey);

                if(count($serialAccount) == 0)
                    array_push($key['data']['errors'], 'License Key does not exist.');
                else if($serialAccount['ACTIVATED'] == 1)
                    // If the serial account has been activated, send the students user name to their course.
                    if(is_numeric($serialAccount['STUDENT_USER_NAME']))
                        return "'" . $serialAccount['STUDENT_USER_NAME'] . "'";
                    else
                        return $validator -> mssql_escape($serialAccount['STUDENT_USER_NAME']);
                else
                    // Otherwise set the account to null so a new one can be created.
                    return null;
            }

            return $key['data'];
        }

        public function AddNewStudent($username)
        {
            $username = $this -> ValidateUser($username);

            if(!isset($username['error']))
            {
                $serialAccount = $this -> model -> GetSerialOwner($username);

                $prefix = substr($serialAccount['SERIAL'], 0, 4); 
                $serialAccount['ID'] = $this -> SetCourseId($prefix);
                if(!isset($_SESSION))
                    session_start();

                $_SESSION['Serial'] = [];

                $_SESSION['Serial']['Start'] = 1;
                $_SESSION['Serial']['LicenseKey'] = $serialAccount['SERIAL'];
                $_SESSION['Serial']['Admin'] = $serialAccount['ACCOUNT_NAME'];
                $_SESSION['Serial']['ProductId'] = $serialAccount['ID'];

                header("Location: /admin/tools/students");
            }
        }

        private function ValidateUser($username)
        {
            $validator = new Helper();
            $errors = [];
            $errors['error'] = [];

            if(isset($username) && strlen($username) > 0)
                if(strlen($username) > 0 && preg_match($validator::PASSWORDCHARS, $username))
                    $username = $validator -> mssql_escape($username);
                else
                    array_push($errors['error'], 1, 'User name is invalid.');
            else
                array_push($errors['error'], 2, 'User name is required.');

            if(count($errors['error']) > 0)
                return $errors;
            else
                return $username;
        }

        private function SetCourseId($prefix)
        {
            switch ($prefix) 
            {
                case "LKFS":
                    $proId = "fs"; // voucher only valid for food saftymanager;
                    break;
                case "LKFR":
                    $proId = "fsrt"; // voucher only valid for food saftymanager
                    break;
                case "LKCA":
                    $proId = "califsh"; // voucher only valid for food saftymanager
                    break;
                case "LKNM":
                    $proId = "nmfsh"; // voucher only valid for food saftymanager
                    break;
                case "LKRW":
                    $proId = "rewi"; // voucher only valid for food saftymanager
                    break;
                case "LKAZ":
                    $proId = "azfsh"; // voucher only valid for food saftymanager
                    break;
                case "LKAA":
                    $proId = "aa"; // voucher only valid for food saftymanager
                    break;
                case "LKAS":
                    $proId = "as"; // voucher only valid for food saftymanager
                    break;
                case "LKAD":
                    $proId = "ad"; // voucher only valid for food saftymanager
                    break;
                case "LKMO":
                    $proId = "mofsh"; // voucher only valid for food saftymanager
                    break;
                case "LKIL":
                    $proId = "ilfsh"; // voucher only valid for food saftymanager
                    break;
                case "LKFH":
                    $proId = "nfon"; // voucher only valid for food saftymanager
                    break;
                case "LKID":
                    $proId = "idfsh"; // voucher only valid for food saftymanager
                    break;
                case "LKTX":
                    $proId = "txfsh"; // voucher only valid for food saftymanager
                    break;
                case "LKWV":
                    $proId = "wvfsh"; // voucher only valid for food saftymanager
                    break;
                case "LKOH":
                    $proId = "ohfsh"; // voucher only valid for food saftymanager
                    break;
                case "LKKS":
                    $proId = "ksfsh"; // voucher only valid for food saftymanager
                    break;
                case "LKTU":
                    $proId = "tufsh"; // voucher only valid for food saftymanager
                    break;
                case "LKUT":
                    $proId = "utfsh"; // voucher only valid for food saftymanager
                    break;
                case "LKFL":
                    $proId = "flfsh"; // voucher only valid for food saftymanager
                    break;
                case "LKVA":
                    $proId = "vaccfsh"; // voucher only valid for food saftymanager
                    break;
                case "LKRE":
                    $proId = "fsre"; // voucher only valid for food saftymanager
                    break;
                case "LKHA":
                    $proId = "nhaccp"; // voucher only valid for food saftymanager
                    break;
                case "LKCB":
                    $proId = "cb"; // voucher only valid for food saftymanager
                    break;
                case "LKEM":
                    $proId = "emws"; // voucher only valid for food saftymanager
                    break;
                case "LKSF":
                    $proId = "sfis"; // voucher only valid for food saftymanager
                    break;
                default:
                    header("Location: /training");
                    break;
            }

            $id = $this -> model -> GetProductId($proId);
            return $id['id'];
        }
    }

?>