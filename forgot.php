<?php
require_once "SendMail.php";

require_once "configLoader.php";
require_once "Auth.php";
$config = loadConfig('config_car_system.ini');
$auth = new Auth(
                    new mysqli("localhost", $config["username"], $config["password"], $config["database"])
                );

if(isset($_POST) && isset($_POST["username"])) {
    
    $email = $auth->getEmail($_POST["username"]);

    if($email == false){
        echo "A e-mail with an reset link has been sent to your registered email address, if it existssdsdsdsd.";
        die;
    }

    echo $email;

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

    if(sendMail($email, "[RAS] Your requested E-Mail reset token.", '
        <h1>RAS</h1>
        <hr>
        <p> Click on the following link to reset your password. <a href=\"'.$uri.'\">'.$uri.'</a>
        If you did not ask for a reset token, please ignore this message.
    ')) {
        echo "A e-mail with an reset link has been sent to your registered email address, if it exists.";
    } else {
        echo "error sending message";
    }

    echo $uri;

} else {
 echo '
    <html>
    <head>
    <title>LOGIN PAGE</title>
    </head>
    <body>
    <form method="POST">
        <input type="text" name="username" placeholder="Enter Username">
        <input type="submit">
    </form>
    </body>
    </html>
    ';
}
?>
