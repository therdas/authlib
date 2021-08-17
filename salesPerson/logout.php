<?php
    session_start();
    unset($_SESSION['SALESPERSON_LOGIN']);
    unset($_SESSION['SALESPERSON_USERNAME']);
    header('location:/RAS/index.php');
    die();
?>