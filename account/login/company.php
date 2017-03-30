<?php
    include $_SERVER['DOCUMENT_ROOT'].'/account/LoginController.php';
    // The table where accounts are stored and menu to redirect. 
    const TABLE = "07L3";
    const MENU = "/admin/company";

    $enrollment = $_POST['enrollment'];
    // Send the table and menu to the login controller.
    $login = new LoginController();
    $login -> company(TABLE, MENU, $enrollment);
    // If the user is logged in, redirect them to their menu page.
    //!$account -> authenticated() ? $account -> login(TABLE, MENU) : header("Location:" . MENU);
?>
