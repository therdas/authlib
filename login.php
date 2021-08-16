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
                        new mysqli("localhost", $config["username"], $config["password"], $config["database"]),
                        array("table" => "login_credentials")
                    );

                    if($_POST["logout"] ?? false) {
        $auth->logout();
        header("Refresh: 0");
        die;
    } else if($auth->isAuthenticated()) {
        ?>
            <div class="hero-img-login"><img src="images/logo.png" width="150px"></div>
            <div class="input-card">
                <span class="login-header">Welcome, <?php echo $auth->getUsername()?></span>
                
                <form method="POST" class="logout">
                    <span>If this is not you,</span> <input type="submit" name="logout" value="Log Out...">
                </form>
                <a class="logout-redir" href="index.html">Go To Homepage</a>
            </div>
        <?php
    } else if (isset($_POST)) {
        $remember = $_POST["remember"] ?? false;
        $username = $_POST["username"] ?? "";
        $password = $_POST["password"] ?? "";
        $new = false;
        if($remember == false && $username == "" && $password == "")
            $new = true;    

        if($auth->login($username, $password, $remember)){
            ?>
                <div class="hero-img-login"><img src="images/logo.png" width="150px"></div>
                <div class="input-card">
                    <span class="login-header">Login</span>
                    <h2>Logged In, forwarding you to homepage...<h2>
                </div>
            <?php
        } else {
            if(!$new) {
                ?>
                    <p>Invalid Username or Password</p>
                <?php
            }

            ?>
                <div class="hero-img-login"><img src="images/logo.png" width="150px"></div>
                <div class="input-card">
                    <span class="login-header">Login</span>
                    <form method="POST">
                        <input type="text" name="username" placeholder="Enter Username">
                        <input type="password" name="password" placeholder="Enter Password">
                        <input type="checkbox" name="remember">Remember Me</input><br/>
                        <span class="login-buttons">
                            <a href="forgot.php">Forgot Password</a>
                            <input type="submit" value="Log In">
                        </span>
                    </form>
                    <?php
                        if(!$new) {
                            ?>
                                <span class="error">Invalid Username or Password</span>
                            <?php
                        }
                    ?>

                </div>
            <?php
        }
    } else {
        header("Refresh: 0");
        die;
    }
    
?>
</body>
</html>

