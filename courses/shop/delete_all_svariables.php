<?php
if($_POST["delete"]){
    session_start();
    // remove all session variables
    session_unset(); 

    // destroy the session 
    session_destroy(); 
}
?>