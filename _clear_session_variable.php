<?php
    //Store The Needed Variables
    $session_id = $_SESSION['id'];
    $session_user = $_SESSION['user'];

    //Session Variable Unset
    session_unset();

    //Again Set the Session variable
    $_SESSION['id'] = $session_id;
    $_SESSION['user'] = $session_user;
?>