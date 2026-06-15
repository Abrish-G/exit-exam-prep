<?php

ini_set('session.gc_maxlifetime', 86400);
session_set_cookie_params(86400, '/');
session_start();

if(!isset($_SESSION['user_id'])){

    header("Location: ../login.php");
    exit();
}


if($_SESSION['role'] != 'admin'){

    header("Location: ../dashboard.php");
    exit();
}
?>