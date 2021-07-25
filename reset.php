<?php
require_once "configLoader.php";
require_once "Auth.php";
$config = loadConfig('config_car_system.ini');
$auth = new Auth(
                    new mysqli("localhost", $config["username"], $config["password"], $config["database"])
                );

if(!isset($_GET) || !isset($_GET["token"])) {
    die;
}

$token = urldecode($_GET["token"]);
echo $token;

$name = $auth->getUsernameFromToken($token);

if($name != false) {
    echo "<H1>Hello, ".$name.".</H1>";
}

if(isset($_POST) && isset($_POST["password"])) {
    if($auth->resetPassword($name, $_POST["password"], $token)) {
        echo "<H1> Reset!</H1><br>Your password has been successfully reset.";
    } else {
        echo "There was a problem resetting your password. Please contact the site administrator.";
    }
    
}
?>

<p>Enter your new password: </p>
<form method="POST">
    <input type="text" name="password" placeholder="Enter your new password">
    <input type="submit">
</form>
