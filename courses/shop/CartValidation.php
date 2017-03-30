<?php
class CartValidation
{
    const NOUSERNAME = "User Name is a required field.";
    const NOPASS1 = "Password is a required field.";
    const NOPASS2 = "Password is a required field.";
    const PASSNOMATCH = "Passwords do not match.";    

    const INVALIDUSERNAME = "User Name can only contain letters and numbers.";

    const LETNUMREGEX = "/^[a-zA-Z0-9]+$/";

    public $error = array();

    public function ValidateNewUserSignIn($data)
    {
        // Check for input data
        isset($_POST["newusername"]) ? true : $this->validation_error(self::NOUSERNAME);
        isset($_POST["newpassword"]) ? true : $this->validation_error(self::NOPASS1);
        isset($_POST["newcpassword"]) ? true : $this->validation_error(self::NOPASS2);
        // Make sure passwords match
        $_POST["newpassword"] == $_POST["newcpassword"] ? true : $this->validation_error(self::PASSNOMATCH);
        // Check for valid input date_add
        preg_match(self::LETNUMREGEX, $_POST["newusername"]) ? false : $this->validation_error(self::INVALIDUSERNAME);
    }

    public function ValidateExistingSignIn($data)
    {
        isset($_POST["existingusername"]) ? true : $this->validation_error(self::NOUSERNAME);
        isset($_POST["existingpassword"]) ? true : $this->validation_error(self::NOPASS1);
        preg_match(self::LETNUMREGEX, $_POST["newusername"]) ? false : $this->validation_error(self::INVALIDUSERNAME);
    }

    public function ValidateInfo()
    {
        
    }

    public function test()
    {
        
    }

    private function validation_error($err)
    {        
        array_push($this->error, $err);
    }
}
?>