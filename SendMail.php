<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once 'configLoader.php';

$config = false;

function sendMail(String $to, String $subject, String $message): bool {
    global $config;
    if($config == false)
        $config = loadConfig("config_car_system.ini");

    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPDebug  = 0;
    $mail->SMTPSecure = "tls";
    $mail->SMTPAuth   = true;
    $mail->Host       = $config["em_host"];
    $mail->Port       = $config["em_port"];
    $mail->IsHTML(true);
    $mail->Username   = $config["em_username"];
    $mail->Password   = $config["em_password"];
    $mail->SetFrom($config["em_username"]);
    $mail->AddAddress($to);
    $mail->Subject    = $subject;
    $mail->Body       = $message;
    if(!$mail->Send())
        return false;
    return true;
}
?>