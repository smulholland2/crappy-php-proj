<?php

    // Only ajax requests are allowed to access this page.
    if(empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest')
        header('Location: /');

    


?>