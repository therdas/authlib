<?php
require('LoginManager.php');
$loginManager = new LoginManager(new mysqli('localhost', 'root', '', 'test'));
//$loginManager->addUser("root", "root");
/*
echo $loginManager->updatePassword("root", "rsoot", "root");
$tok = $loginManager->generateAuthToken("root", LoginManager::AS_RESET);
if($loginManager->verifyAuthToken($tok, LoginManager::AS_RESET))
    echo "TRUE";
else
    echo "FALSE";
*/
require("Auth.php");
$auth = new Auth(new mysqli("localhost", "root", "", "test"));
echo $auth->login("root", "root", true);
?>