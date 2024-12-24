<?php
    $tenp_id = $_SESSION['id'];
    $temp_user = $_SESSION['user'];
    session_unset();
    $_SESSION['id'] = $tenp_id;
    $_SESSION['user'] = $temp_user;
?>