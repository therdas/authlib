<html>
<head>
<title>LOGIN PAGE</title>
<link rel="stylesheet" href="loginpage.css">
</head>
<body>
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
    die;
}
?>
    <div class="hero-img-login"><img src="images/logo.png" width="150px"></div>
    <div class="input-card">
        <h3>Enter your new password: </h3>
        <form method="POST">
            <input type="text" name="password" placeholder="Enter your new password">
            <span class="login-buttons">
                <input type="submit">
            </span>
        </form>
    </div>
</body>
</html>


