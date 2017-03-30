<?
    include_once $_SERVER["DOCUMENT_ROOT"]."/courses/CoursesModel.php";
    include_once $_SERVER["DOCUMENT_ROOT"]."/lib/Helper.php";
    include_once $_SERVER["DOCUMENT_ROOT"]."/lib/Mailer.php";

    class CoursesController
    {
        
        public function __construct()
        {
            if(!isset($_SESSION))
                session_start();
        }

        public function AlcoholCourse()
        {
            $helper = new Helper();
            $model = new CoursesModel();

            //$validated = $helper -> mssql_escape();
            return $model -> GetAlcoholCourse();
            if($validated)
            {
                return $model -> GetAlcoholCourse();
            }


        }

        public function PurchaseState()
        {
            $helper = new Helper();
            $_SESSION['alcoholtraining']['purchasestate'] = $helper -> FindFullName($_POST['state']);
            exit;
        }
    }
?>

