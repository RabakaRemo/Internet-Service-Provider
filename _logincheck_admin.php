<?php
        session_start();
        if(!isset($_SESSION['user']) || $_SESSION['user'] != "admin")
        {
            session_unset();
            session_destroy();
            header("location: login.php");
            die();
        }
    ?>