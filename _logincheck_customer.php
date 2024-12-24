<?php
        session_start();
        if(!isset($_SESSION['user']) || $_SESSION['user'] != "customer")
        {
            session_unset();
            session_destroy();
            header("location: login.php");
            die();
        }
    ?>