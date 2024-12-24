<?php

        // connect to the database
        require '_database_connect.php';
        
        session_start();
        if(isset($_SESSION['user']))
        {
            //Session Variable Unset And Session Destroy
            session_unset();
            session_destroy();
            
            // Close the database connection
            mysqli_close($connect);
        }
        header("location: login.php");
    ?>