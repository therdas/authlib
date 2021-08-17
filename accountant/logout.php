<?php
    session_start();
    unset($_SESSION['ACCOUNTANT_LOGIN']);
    unset($_SESSION['ACCOUNTANT_USERNAME']);
    header('location:/RAS/index.php');
    die();
?>