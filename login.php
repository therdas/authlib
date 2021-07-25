<?php
    require_once "configLoader.php";
    require_once "Auth.php";
    $config = loadConfig('config_car_system.ini');
    $auth = new Auth(
                        new mysqli("localhost", $config["username"], $config["password"], $config["database"])
                    );

    if($_POST["logout"] ?? false) {
        $auth->logout();
    } else if($auth->isAuthenticated()) {
        echo "Authenticated";
    } else if (isset($_POST)) {
        $remember = $_POST["remember"] ?? false;
        $username = $_POST["username"] ?? "";
        $password = $_POST["password"] ?? "";

        if($auth->login($username, $password, $remember)){
            echo "Logged In...";
        } else {
            echo "Not Logged In...";
        }
    }
    
?>

<html>
<head>
<title>LOGIN PAGE</title>
</head>
<body>
<form method="POST">
    <input type="text" name="username" placeholder="Enter Username">
    <input type="password" name="password" placeholder="Enter Password">
    <input type="checkbox" name="remember">Remember Me</input>
    <input type="submit">
</form>
<form method="POST">
    <input type="submit" name="logout" value="Log Out...">
</form>
<a href="forgot.php">Forgot Password</a>
</body>
</html>