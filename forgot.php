<html>
<head>
<title>LOGIN PAGE</title>
<link rel="stylesheet" href="loginpage.css">
</head>
<body>
<?php
require_once "SendMail.php";

require_once "configLoader.php";
require_once "Auth.php";
require_once "TemplateFiller.php";

$config = loadConfig('config_car_system.ini');
$auth = new Auth(
                    new mysqli("localhost", $config["username"], $config["password"], $config["database"])
                );

if(isset($_POST) && isset($_POST["username"])) {
    
    $email = $auth->getEmail($_POST["username"]);

    if($email == false){
        ?>
            <div class="hero-img-login"><img src="images/logo.png" width="150px"></div>
            <div class="input-card">
                <h3>Success!</h3>
                <p>We've sent you the link to your registered e-mail address, if it exists. Please check your email.</p>
            </div>
        <?php
        die;
    }

    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
        $link = "https";
    else
        $link = "http";
    $link .= "://";
    $link .= $_SERVER['HTTP_HOST'];
    $link .= $_SERVER['REQUEST_URI'];
    $ind = strripos($link, "/");
    $uri = substr($link, 0, $ind);
    $uri .= '/' . 'reset.php?token=';
    $uri .= urlencode($auth->getResetToken($_POST["username"]));

    if(sendMail($email, 
        "[RAS] Reset Link for your Account", 
        FillTemplate(
            file_get_contents("TemplateEmailForPasswordReset.html"), 
            array("resetlink" => $uri, 
                  "username"  => $_POST["username"],
            )
        )
    )) {
        ?>
            <div class="hero-img-login"><img src="images/logo.png" width="150px"></div>
            <div class="input-card">
                <h3>Success!</h3>
                <p>We've sent you the link to your registered e-mail address, if it exists. Please check your email.</p>
            </div>
        <?php
    } else {
        ?>
            <div class="hero-img-login"><img src="images/logo.png" width="150px"></div>
            <div class="input-card">
                <h3>Oh No :(</h3>
                <p>We couldn't send you the email. The E-Mail subsystem reports an error. Please contact the site administrator or try again.</p>
            </div>
        <?php
    }

} else {
    ?>
    <div class="hero-img-login"><img src="images/logo.png" width="150px"></div>
    <div class="input-card">
        <span class="login-header">Login</span>
        <form method="POST">
            <input type="text" name="username" placeholder="Enter Username">
            <span class="login-buttons">
                <input type="submit" value="Send Reset Link">
            </span>
        </form>
    </div>
    <?php
}
?>
</body>
</html>
