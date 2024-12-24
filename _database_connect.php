<?php
    $servername = "localhost";
    $username = "root";
    $password = "pass";
    $database = "isp";
    
    // Create a connection
    $connect = mysqli_connect($servername, $username, $password, $database);
    
    if(!$connect){die("Dtatbase did no connect");}
?>