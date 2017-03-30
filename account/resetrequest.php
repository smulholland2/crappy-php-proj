<?php 

    include_once $_SERVER['DOCUMENT_ROOT'].'/account/LoginController.php';

    if(isset($_POST) && count($_POST) > 0)
    {
        $login = new LoginController();

        if(isset($_POST["type"]))
            echo $login -> ForgotAdminPassword();
        else
            echo $login -> ForgotStudentPassword();
        exit();
    }
    else
        header("Location: /account/forgotpass");

?>