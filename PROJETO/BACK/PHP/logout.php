<?php
    session_start();

    session_unset(); 

    session_destroy(); 

    header("Location: ../../FRONT/HTML/login.php"); 
?>