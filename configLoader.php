<?php
function loadConfig($filename = "config.ini", $directory="") {
    echo "TEST";
    if($directory === "") {
        $directory = $_SERVER["DOCUMENT_ROOT"];
        
        $a = strripos($directory, "\\");
        $b = strripos($directory, "/");


        $pos;
        if($a === false)
            $pos = $b;
        else
            $pos = $a;

        $directory = substr($directory, 0, $pos)."/config";
    }
    
    return parse_ini_file($directory."/".$filename);
}
?>