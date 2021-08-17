<?php 
require_once "configLoader.php";
$config = loadConfig('config_car_system.ini');

$con = new mysqli("localhost", $config["username"], $config["password"], $config["database"]);
$sql = "select IMG from users where UserId = ?";

function getImageURL(string $userid): string {
    global $con, $sql;
    $query = $con->prepare($sql);
    if($query == FALSE)
        return false;
    
    $query->bind_param("s", $userid);
    $query->execute();

    if($query == FALSE)
        return false;

    $res = $query->get_result();
    if($tuple = $res->fetch_assoc()){
        $res->free_result();
        return $tuple["IMG"];
    } else 
        return false;
}
?>