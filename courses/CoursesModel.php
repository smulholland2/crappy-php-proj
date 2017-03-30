<?
    include_once $_SERVER["DOCUMENT_ROOT"]."/config/connection.php";

    class CoursesModel
    {
        public function GetAlcoholCourse()
        {
            $connector = new Db();

            $sql="SELECT * FROM [07DS2] WHERE ProID='alc' ";
		    return $connector -> RunQuery($sql);
        }
    }
?>