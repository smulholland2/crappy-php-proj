<?php
    include $_SERVER['DOCUMENT_ROOT'].'/account/LoginController.php';
    // The table where accounts are stored and menu to redirect. 
    const TABLE = "07L2";
    const MENU = "/admin/multi_unit";

    // Send the table and menu to the login controller.
    $login = new LoginController();
    $login -> multi_unit(TABLE, MENU);
    // If the user is logged in, redirect them to their menu page.
    //!$account -> authenticated() ? $account -> login(TABLE, MENU) : header("Location:" . MENU);
?>
