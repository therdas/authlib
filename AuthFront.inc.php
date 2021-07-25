<?php
require_once("Auth.php");
$LOGIN_PAGE = "login.php";

$auth = new Auth(new mysqli("localhost", "root", "", "test"));

//Debug
$a = $auth->isUsernameActive();
echo var_dump($a)."<br>";
$b = $auth->remember();
echo var_dump($b)."<br><hr>";

if(!auth->isUsernameActive() && !auth->remember()) {
    header("location: {$LOGIN_PAGE}");
    die();
}
?>