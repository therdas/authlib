<?php
require_once("../UserPicture.php");
$uri = getImageURL($auth->getUsername());
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator Panel | Gallery 15</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    
</head>
<body class="body-admin-panel">
    
    
<div class="wrapper">
    <div class="sidebar">
        <div style="margin-left: 10%">
        <img src="/RAS/media/images/<?php echo $uri;?>" width="100px" height="100px">
        <h1><?php echo $auth->getUsername(); ?></h1>
        <h4><?php echo $auth->getStringUserType(); ?></h4>
    </div>
    <div style="margin-left: 10%; margin-top: 20%;">
        <a style="color: black;" href="index.php">Create Report</a><br><br>
        <a style="color: black;" href="staffManagement.php">Staff Management</a>
    </div>  
            
</div>
    <!-- side bar ends -->