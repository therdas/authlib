<?php
    require_once "../auth.php";
    $con=mysqli_connect('localhost',"root","","rasdb");
    $auth = new Auth(new mysqli("localhost", "root", "", "rasdb"));
        
    define('SERVER_PATH',$_SERVER['DOCUMENT_ROOT'].'/RAS/');
    define('SITE_PATH','http://'.$_SERVER["HTTP_HOST"].'/RAS/');

    define('STAFF_IMAGE_SERVER_PATH',SERVER_PATH.'media/images/');
    define('STAFF_IMAGE_SITE_PATH',SITE_PATH.'media/images/');

?>