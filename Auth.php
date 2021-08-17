<?php
require_once("LoginManager.php");

if(session_status() === PHP_SESSION_NONE)
    session_start();

class Auth {
    private $login;

    function __construct(mysqli $connection, $options = false) {
        if(!$options)
            $options = [];
        

        $this->usernameSessionID  = $options["username_var"]   ?? "username";
        $this->loggedinSessionID  = $options["logged_in_var"]  ?? "logged_in";
        $this->cookieName         = $options["cookie_name"]    ?? "sessionid";

        $this->login = new LoginManager($connection, $options);
    }

    public function addUser(string $username, string $password): bool {
        return $this->login->addUser($username, $password);
    }

    public function getUsername() {
        return $_SESSION[$this->usernameSessionID];
    }

    public function isAuthenticated(): bool {
        if(isset($_SESSION[$this->usernameSessionID]))
            return true;
        if($this->remember())
            return true;
        return false;
    }

    public function login($username, $password, bool $rememberMe = FALSE) {
        $correct = $this->login->checkIfMatch($username, $password);


        if($correct) {
            $this->forget();

            if($rememberMe)
                $this->memorize($username);

            $this->setUsername($username);
            return TRUE;
        } else {
            $this->forgetUsername();
            return FALSE;
        }
    }

    public function logout() {
        $this->forgetUsername();
        $this->forget();
    }

    public function getEmail(string $username) {
        return $this->login->getEmail($username);
    }   

    public function getUsernameFromToken($token) {
        return $this->login->getUsernameFromToken($token);
    }

    public function resetPassword($username, $password, $token) {
        $ret =  $this->login->updatePasswordWToken($username, $token, $password);
        $this->login->discardToken($token, LoginManager::AS_RESET);
        return $ret == true;
    }

    public function getResetToken($username) {
        return $this->login->generateAuthToken($username, LoginManager::AS_RESET);
    }

    private function setUsername($username) {
        $_SESSION[$this->usernameSessionID] = $username;
        $_SESSION[$this->loggedinSessionID] = TRUE;
    }

    private function forgetUsername() {
        unset($_SESSION[$this->usernameSessionID]);
        unset($_SESSION[$this->loggedinSessionID]);
    }

    private function isUsernameActive() {
        return isset($_SESSION[$this->usernameSessionID]) && isset($_SESSION[$this->loggedinSessionID]);
    }

    private function memorize($username) {
        $token = $this->login->generateAuthToken($username, LoginManager::AS_REMEMBER);
        if($token == FALSE) {
            //Deal with situation that token cannot be generated
            return false;
        } 

        $this->setCookie($token);
        return true;
    }

    public function remember(): bool {
        if(!isset($_COOKIE[$this->cookieName]))
            return false;

        //Cookie exists
        if($this->login->verifyAuthToken($_COOKIE[$this->cookieName]) == true) {
            $username = $this->login->getUsernameFromToken($_COOKIE[$this->cookieName]);

            //Set cookie if new login 
            if(!$this->isUsernameActive()) {
                $this->login->discardToken($_COOKIE[$this->cookieName]);
                $this->memorize($username);
            }

            //Correct Token
            $this->setUsername($username);
            return true;
        } else {
            //Invalid cookie, clear
            $this->login->discardToken($_COOKIE[$this->cookieName]);
            return false;
        }
    }

    public function forget() {
        unset($_COOKIE[$this->cookieName]); 
        setcookie($this->cookieName, null, [
            "httponly" => TRUE,
            "samesite" => TRUE
        ]); 
    }

    private function setCookie($token) {
        if(isset($_COOKIE[$this->cookieName]))
            $this->login->discardToken($_COOKIE[$this->cookieName]);
    
        setcookie('sessionid', $token, [
            "httponly" => TRUE,
            "samesite" => TRUE
        ]);
    }

    private function get_client_ip() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
}
?>