<?php
    include $_SERVER['DOCUMENT_ROOT'].'/account/LoginController.php';

    // Send the table and menu to the login controller.
    $login = new LoginController("logout");    
    // If the user is logged in, redirect them to their menu page.
    //!$account -> authenticated() ? $account -> login(TABLE, MENU) : header("Location:" . MENU);
?>