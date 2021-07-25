<?php
require_once("config.php");

class LoginDBManager {
    //Connection
    private $conn;

    public function __construct(mysqli $connection, $options = false) {
        if(!$options) {
            $options = [];
        }

        if(!array_key_exists('columns', $options)) {
            $options['columns'] = [];
        }
 
        $this->table      = $options["columns"]["table"]        ?? "users";
        $this->username   = $options["columns"]["username"]     ?? "username";
        $this->password   = $options["columns"]["password"]     ?? "password";
        $this->reauth_token = $options["columns"]["reauth_token"] ?? "reauth_token";
        $this->email      = $options["columns"]["email"]        ?? "email";
        $this->timeout    = $options["columns"]["timeout"]      ?? "timeout";

        $this->rem_table  = $options["columns"]["auth_table"]   ?? "remember_me";
        $this->auth_token = $options["columns"]["auth_token"]   ?? "auth_token";
        $this->conn       = $connection;
    }

    public function getUserEmail($username){
        $queryString = "select ".$this->email." from ".$this->table.
                       " where ".$this->username." = ?";
        $query = $this->conn->prepare($queryString);

        if($query == false)
            return false;

        $query->bind_param("s", $username);
        $query->execute();

        if($query == false)
            return false;

        $res = $query->get_result();
        if($tuple = $res->fetch_assoc()) {
            $res->free_result();
            return $tuple[$this->email];
        } else {
            return false;
        }

        return false;
    }

    public function getPasswordHash($username){
        $queryString = "select ".$this->password." from ".$this->table.
                       " where ".$this->username." = ?";

        $query = $this->conn->prepare($queryString);

        if($query == false)
            return false;

        $query->bind_param("s", $username);
        $query->execute();

        if($query == false)
            return false;

        $res = $query->get_result();
        if($tuple = $res->fetch_assoc()) {
            $res->free_result();
            return $tuple[$this->password];
        } else {
            return false;
        }

        return false;
    }

    public function setUser($username, $passwordHash): bool {
        $queryString = "insert into ".$this->table.
                        "(".$this->username.",".$this->password.") values (?, ?)";

        $query = $this->conn->prepare($queryString);

        if($query == false)
            return false;

        $query->bind_param("ss", $username, $passwordHash);
        $query->execute();

        return $query == true;
    }

    public function updatePassword($username, $passwordHash): bool {
        $queryString = "update ".$this->table." set ".$this->password.
                       " = ? where ".$this->username." = ?";
        $query = $this->conn->prepare($queryString);

        if($query == false)  
            return false;

        $query->bind_param("ss", $passwordHash, $username);
        $query->execute();
        return $query == true;
    }

    public function storePersistentToken($username, $tokenHash, $timeout):bool {
        $time = date("Y-m-d H:i:s", strtotime("+{$timeout} seconds"));
        $queryString = "insert into {$this->rem_table} (
                            {$this->username}, {$this->auth_token},
                            {$this->timeout}) 
                        values (?,?,?)";
        
        $query = $this->conn->prepare($queryString);
        
        if($query == false)
            return false;
        
        $query->bind_param("sss", $username, $tokenHash, $time);
        $query->execute();
        return $query == true;
    }

    public function isPersistentToken($username, $tokenHash): bool {
        $queryString = "select {$this->username}, {$this->auth_token}, {$this->timeout}".
                       " from {$this->rem_table} where ".
                       " {$this->username} = ? and {$this->auth_token} = ?";
        
        $query = $this->conn->prepare($queryString);
        if($query == false)
            return false;

        $query->bind_param("ss", $username, $tokenHash);
        $query->execute();
        
        if($query == false){
            return false;
        }
        $res = $query->get_result();
        if($tuple = $res->fetch_assoc()){
            $res->free_result();
            $res_timeout = $tuple[$this->timeout];

            if(time() > strtotime($res_timeout)){
                $this->deletePersistentToken($username, $tokenHash);
                return false;
            } else {
                return true;
            }

        } else 
            return false;
    }

    public function deletePersistentToken($username, $tokenHash): bool {
        $queryString = "delete from {$this->rem_table} where {$this->username} = ? and
                        {$this->auth_token} = ?";
        $query = $this->conn->prepare($queryString);
        if($query == false)
            return false;
        
        $query->bind_param("ss", $username, $tokenHash);
        $query->execute();
        return $query == true;
    }

    public function storeResetToken($username, $tokenHash, $timeout):bool {
        $time = date("Y-m-d H:i:s", strtotime("+{$timeout} seconds"));
        $queryString = "update {$this->table}
                        set {$this->reauth_token} = ?,
                            {$this->timeout} = ?
                        where {$this->username} = ?";
        
        $query = $this->conn->prepare($queryString);
        
        if($query == false)
            return false;
        
        $query->bind_param("sss", $tokenHash, $time, $username);
        $query->execute();
        return $query == true;
    }

    public function isResetToken($username, $tokenHash): bool {
        $queryString = "select {$this->username}, {$this->reauth_token}, {$this->timeout} 
                        from {$this->table} 
                        where {$this->username} = ?";
        
        $query = $this->conn->prepare($queryString);

        if($query == false)
            return false;

        $query->bind_param("s", $username);
        $query->execute();
        
        if($query == false)
            return false;
        
        $res = $query->get_result();
        if($tuple = $res->fetch_assoc()){
            $res->free_result();
            $res_timeout = $tuple[$this->timeout];
            $res_hash = $tuple[$this->reauth_token];

            if (time() < strtotime($res_timeout) && hash_equals($tokenHash, $res_hash)){
                return true;
            } else {
                return false;
            }
        } else 
            return false;
    }

    public function deleteResetToken($username, $tokenHash): bool {
       $queryString = "update {$this->table}
                       set {$this->reauth_token} = NULL,
                           {$this->timeout} = NULL
                       where {$this->username} = ?";
        $query = $this->conn->prepare($queryString);
        if($query == false)
            return false;
        
        $query->bind_param("s", $username);
        $query->execute();
        return $query == true;
    }
}
?>