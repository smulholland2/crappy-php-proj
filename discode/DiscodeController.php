<?php
include_once $_SERVER['DOCUMENT_ROOT']."/lib/Helper.php";

class DiscodeController
{
    const DISCODETAKENEC       = 1;
    const INVALIDDISCODEEC     = 1;
    const INVALIDLOGOURLEC     = 1;
    const INVLAIDHTMLCODESEC   = 1;

    const DISCODETAKENMSG      = "";
    const INVALIDDISCODEMSG    = "";
    const INVALIDLOGOURLMSG    = "";
    const INVLAIDHTMLCODESMSG  = "";

    const ADDSUCCESSMSG        = "";
    const EDITSUCCESSMSG       = "";
    const REMOVESUCCESSMSG     = "";

    const LOGODIR              = "/wwwroot/images/4ulogos/";
    
    private $data              = [];
    private $logo              = [];
    private $action            = null;
    private $validated         = false;
    private $discode           = null;
    private $logo_url          = null;    
    private $htmlcodes         = null;
    private $customcss         = null;
    private $customjs          = null;


    public function __construct($_action, $_data = null, $_logo = null)
    {        
        $this -> action = $_action;
        $this -> data = $_data;
        $this -> logo = $_logo;
        session_start();
    }

    public function ListDiscodes()
    {
        $sql = "SELECT id, discode FROM [discodes]";
        return $discodes = $this -> RunQuery($sql);
    }

    public function AddDiscode()
    {
        $this -> logo_url = $this -> logo["logo"]["name"];
        $this -> ValidateForm();        
        if($this -> validated)
        {            
            $sql = "SELECT discode FROM [discodes] WHERE discode = " . $this -> discode;
            $discode = $this -> RunQuery($sql);            
            $discode_taken = $this -> CheckExisting($discode);
            $logo_url = $this -> UploadLogo();            
            if($discode_taken)
                $this -> Failed(self::DISCODETAKENEC);
            else
            {
                $sql = "INSERT INTO [discodes] (discode, logo, html, js, css, active)"; 
                $sql .= "VALUES (" .$this -> discode. ","; 
                $sql .= $this -> logo_url . ","; 
                $sql .= $this -> htmlcodes .","; 
                $sql .= $this -> customjs .","; 
                $sql .= $this -> customcss. ", 1)";
                $this -> RunQuery($sql);
                $_SESSION["AddSuccess"] = self::ADDSUCCESSMSG;
                header("Location: /discode");
            }
        }
    }

    public function EditDiscode()
    {
        $this -> ValidateForm();
        if($validated)
        {

        }
    }

    public function RemoveDiscode()
    {
        $this -> ValidateForm();
    }

    private function RunQuery($sql)
    {        
        $conn = mssql_connect($_SERVER['DB_HOSTNAME'], $_SERVER['DB_USERNAME'], $_SERVER['DB_PASSWORD']);
        mssql_select_db("newtap", $conn);

        $response["rows"] = [];
        $stmt = mssql_query ( $sql , $conn );
        if( $stmt === false ) {
            $this -> Failed(self::INVALIDQUERYEC);
        } else {
            while( $row = mssql_fetch_assoc($stmt) ) {                    
                $response["rows"] > 1 ? array_push($response["rows"], $row) : false;
            }
            return $response["rows"];
        }
    }

    private function UploadLogo()
    {
        
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($this -> logo["logo"]["name"]);
        $uploadOk = 1;        
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        // Check if image file is a actual image or fake image
        if(isset($this -> data["logo"])) {
            $check = getimagesize($_FILES["logo"]["tmp_name"]);
            if($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
                die( "Upload ok");
            } else {
                die( "File is not an image.");
                $uploadOk = 0;
            }
            // Check file size
            if ($_FILES["logo"]["size"] > 500000) {
                die( "Sorry, your file is too large.");
                $uploadOk = 0;
            }
            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
                die( "Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
                $uploadOk = 0;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                die( "Sorry, your file was not uploaded.");
            // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file)) {
                    echo "The file ". basename( $_FILES["logo"]["name"]). " has been uploaded.";
                } else {
                    die( "Sorry, there was an error uploading your file.");
                }
            }
        }
    }
    private function ValidateForm()
    {
        isset($this -> data["discode"]) ? true : $this -> Failed(self::INVALIDDISCODEEC);        
        isset($this -> data["htmlcodes"]) ? true : $this -> Failed(self::INVLAIDHTMLCODESEC);

        $this -> SanitizeForm();        
    }

    private function SanitizeForm()
    {
        $sanitizer = new Helper();

        $this -> discode = $sanitizer -> mssql_escape($this -> data["discode"]);        
        $this -> htmlcodes = $sanitizer -> mssql_escape($this -> data["htmlcodes"]);
        $this -> logo_url = $sanitizer -> mssql_escape($this -> logo_url);

        // Javascript and CSS are optional. If they aren't entered, set them to NULL.
        $this -> customjs = isset($this -> data["customjs"]) ? $sanitizer -> mssql_escape($this -> data["customjs"]) : null;
        $this -> customcss = isset($this -> data["customcss"]) ? $sanitizer -> mssql_escape($this -> data["customcss"]) : null;

        $this -> validated = true;
    }

    private function CheckExisting()
    {
        while ($row = mssql_fetch_array($resultset1)) 
        {
            return $row['discode'] ? true : false;
        }
    }

    private function Failed($e)
    {
        switch($e)
        {
            case 1:
                $_SESSION["discode_error"] = "Please try a different discode, the one you entered exists in the database.";
                $_SESSION["logo"] = $logo;
                $_SESSION["htmlcodes"] = $htmlcodes;
                $_SESSION["customjs"] = isset($customjs) ? $customjs : null;
                $_SESSION["customcss"] = isset($customcss) ? $customcss : null; 
                header("Location: ". $this -> action .".php");
            case 2:
            case 3:
            case 4:
            default:
        }
        
    }
}

?>