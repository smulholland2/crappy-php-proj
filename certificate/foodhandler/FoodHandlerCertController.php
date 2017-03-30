<?php
    
    include_once $_SERVER['DOCUMENT_ROOT']."/certificate/CertificateController.php";

    class FoodHandlerCertController extends CertificateController
    {
        const TABLE       = "01D";
        const LOOKUPTABLE = "FoodHandlerLookUp"; // Table for the food handler records.

        public function __construct($_data)
        {
            try {
                // Validate the POST vars.
                $this -> Validate($_data);                

                // If the data is valid, convert it to hexidecimal values.
                // This will prevent SQL injection.
                $this -> Clean($_data);
                
                // Get the course title from the lookup table.
                $this -> GetCourseTitle(self::LOOKUPTABLE);
                
                // Determine the type of form that was sent and run get the Cert data.
                $this -> GetCert(self::TABLE);
                //die(var_dump($_data));

                // Final step is to print the PDF.
                //$this -> PrintPDF();

            } catch (Exception $e) {

                // Exit and report errors if something went wrong.
                // $this -> failed($e);
                die($e);
            }
        }
    }

?>
