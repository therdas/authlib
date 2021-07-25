<?php
require_once("config.php");
require_once("LoginDBManager.php");

class LoginManager {
    private $resetTimeout = 60 * 20;
    private $authTimeout  = 60 * 60 * 24 * 7;
    private int $tokenLength;
    private LoginDBManager $udb;    

    const AS_REMEMBER = 0;
    const AS_RESET    = 1;

    public function __construct(mysqli $connection, $options = false) {
        if(!$options) {
            $options = [];
        }

        $this->udb = new LoginDBManager($connection, $options);
        
        $this->resetTimeout = $options["reset_timeout"] ?? 20 * 60;
        $this->authTimeout  = $options["auth_timeout"]  ?? 60 * 24 * 7;
        $this->tokenLength  = $options["token_length"]  ?? 256/8;
    }

    public function checkIfMatch(string $username, string $password): bool {
        $passwordHash = $this->udb->getPasswordHash($username);
        if($passwordHash != FALSE) 
        {
            if(password_verify($password,$passwordHash)) {
                return true;
            }
        }   
        return false;
    }

    public function getEmail(string $username) {
        return $this->udb->getUserEmail($username);
    }

    public function addUser(string $username, string $password): bool {
        return $this->udb->setUser($username, password_hash($password, PASSWORD_DEFAULT));
    }

    public function updatePassword(string $username, string $passwordOld, string $passwordNew): bool {
        return $this->checkIfMatch($username, $passwordOld) && 
               $this->udb->updatePassword($username, password_hash($passwordNew), PASSWORD_DEFAULT);
    }

    public function updatePasswordWToken(string $username, string $token, string $passwordNew): bool {
        return $this->verifyAuthToken($token, LoginManager::AS_RESET) && 
               $this->udb->updatePassword($username, password_hash($passwordNew, PASSWORD_DEFAULT));
    }

    public function generateAuthToken(string $username, $storeMethod = LoginManager::AS_REMEMBER){
        $token    =  $this->getRandomData();
        $hash     =  hash("sha256", $token);
        $combined =  $this->generateValidableToken($username, $token);

        $ret = false;
        if($storeMethod == LoginManager::AS_REMEMBER) {
            $ret = $this->udb->storePersistentToken($username, $hash,$this->authTimeout);
        } else {
            $ret = $this->udb->storeResetToken($username, $hash, $this->resetTimeout);
        }

        if($ret == false) 
            return false; 
        else 
            return $combined;
    }

    public function verifyAuthToken(string $token, $storeMethod = LoginManager::AS_REMEMBER): bool {
        list ($username, $t, $hash) = explode(':', $token);

        if($storeMethod == LoginManager::AS_REMEMBER)
            return $this->verifyValidableToken($token) && $this->udb->isPersistentToken($username, hash('sha256',$t));
        else
            return $this->verifyValidableToken($token) && $this->udb->isResetToken($username, hash('sha256', $t));    
    }

    public function discardToken(string $token, $storeMethod = LoginManager::AS_REMEMBER) {
        list ($username, $t, $hash) = explode(':', $token);
        if($storeMethod == LoginManager::AS_REMEMBER)
            return $this->verifyValidableToken($token) && $this->udb->deletePersistentToken($username, hash('sha256',$t));
        else
            return $this->verifyValidableToken($token) && $this->udb->deleteResetToken($username, hash('sha256', $t));    

    }

    public function getUsernameFromToken(string $token) {
        list ($u, $t, $h) = explode(":", $token);
        return $u;
    }

    private function verifyValidableToken(string $combinedToken): bool {
        list ($username, $token, $hash) = explode(':', $combinedToken);

        if(hash_equals(hash_hmac('sha256', $username.$token, KEY), $hash)) {
            return true;
        } else{
            return false;
        }
    }

    private function generateValidableToken(string $input, string $rand): string {
        return $input.":".$rand.":".hash_hmac('sha256', $input.$rand, KEY);
    }

    private function getRandomData(): string {
        return bin2hex(random_bytes($this->tokenLength));
    }
}

?>