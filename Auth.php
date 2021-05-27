<?php
require_once("LoginManager.php");

class Auth {
    private $login;

    function __construct(mysqli $connection, $options = false) {
        if(!$options)
            $options = [];

        $this->resetTimeout = $options["reset_timeout"] ?? 20 * 60;
        $this->authTimeout  = $options["auth_timeout"]  ?? 60 * 24 * 7;

        $this->login = new LoginManager($connection, $options);
    }

    public function login($username, $password, bool $rememberMe = FALSE) {
        $correct = $this->login->checkIfMatch($username, $password);
        echo var_dump($correct);
        if($correct) {
            if($rememberMe) {
                echo "REMEMBERING";
                $token = $this->login->generateAuthToken($username, LoginManager::AS_REMEMBER);
                if($token == FALSE) {
                    //Deal with situation that token cannot be generated
                    //This code: Fail Silently
                    return true;
                } else {
                    $this->setCookie($token);
                }
            } 
            $_SESSION["username"] = $username;
            $_SESSION["logged_in"] = TRUE;
            return TRUE;
        } else {
            echo "INCORRECT";
            return FALSE;
        }
    }

    private function setCookie($token) {
        if(isset($_COOKIE["sessionid"])) {
            echo "DESTROYING COOKIE";
            $this->login->discardToken($_COOKIE["sessionid"]);
        } 
        echo "SETTING COOKIE";
        setcookie('sessionid', $token, [
            "httponly" => TRUE,
            "samesite" => TRUE
        ]);
    }
}
?>