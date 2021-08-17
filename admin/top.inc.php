<?php
    require('connection.inc.php');
    require('functions.inc.php');
    $group_res=mysqli_query($con,"select * from groups where status=1 order by group_name");
    $group_arr=array();
    while($row=mysqli_fetch_assoc($group_res)){
        $group_arr[] = $row;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
    <style>
    
    </style>
    <title>RAS: Road-ready Account Syatem</title>
</head>
<body>
    <!--Header Starts -->
    <div id="sidenav">
        <div class="inside">
            <div class="logo-container">
                <img src="/RAS/media/images/elonMask.jpg" width="100px" height="100px">
                <h1>Elon Mask</h1>
                <h4>Admin</h4>
            </div>  
            
            <a class="nav-item" href="report.php">Create Report</a>
            <a class="nav-item" href="logout.php">Logout</a>
              
        </div>
        <!-- <a href="login.php?continue_to=order.php" style="float:right">ORDER NOW</a>                       -->
    </div>
    <div id="content">
    <!--header Ends -->