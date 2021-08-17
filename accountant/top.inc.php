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
    <title>Gallery 15: Where Art Meets Inspiration</title>
</head>
<body>
    <!--Header Starts -->
    <div id="sidenav">
        <div class="inside">
            <div class="logo-container">
                <img src="/RAS/media/images/accountant.jpg" width="100px" height="100px">
                <h1>Accountant's Name</h1>
                <h4>Accountant</h4>
            </div>  
            <div class="login-container">
            <?php
                if(isset($_SESSION['CUSTOMER_USERNAME'])) {
                    ?>
                        <span>Welcome, <?php echo $_SESSION['CUSTOMER_USERNAME']?></span><br>
                        <span>
                            <a href="customer_portal">Your Account</a> | 
                            <a href="logout.php">Log Out</a>
                            <!-- <a style="float:right;" href="logout.php">Log Out</a> -->
                            <!-- <a style="float:right;" href="logout.php">Log Out</a> -->
                        </span>
                    <?php
                } else {
                    if(isset($_COOKIE['CUSTOMER_USERNAME'])){
                        $_SESSION['CUSTOMER_LOGIN'] = 'yes';
                        $_SESSION['CUSTOMER_USERNAME']=$_COOKIE['CUSTOMER_USERNAME'];
                        ?>
                            <span>Welcome, <?php echo $_SESSION['CUSTOMER_USERNAME']?></span><br>
                            <span>
                                <a href="customer_portal">Your Account</a> | 
                                <a href="logout.php">Log Out</a>
                            </span>
                        <?php
                    }else{
                        $substring='login.php';
                        $string=$_SERVER['REQUEST_URI'];
                        if(strpos($string, $substring) == true){
                            ?>
                                <a href="login.php">Log In</a>
                            <?php
                        }else{
                            $substring='signup.php';
                            if(strpos($string, $substring) == true){
                                ?>
                                    <a href="login.php">Log In</a>
                                <?php
                            }else{
                                ?>
                                    <a href="login.php?continue_to=<?php echo urlencode($_SERVER['REQUEST_URI']);?>">Log In</a>
                                <?php
                            }
                        }
                    }
                   
                }
            ?>
            </div>
            <a class="nav-item" href="index.php">Home</a>
            <!-- <a href="artist.html">ARTIST FORM</a>
            <a href="sample.html">SAMPLE</a>
            <a href="artwork.html">ARTWORK FORM</a>
            <a href="login.php">ORDER NOW</a> -->
            <?php 
                foreach($group_arr as $list){
                    ?>
                    <a class="nav-item" href="artwork.php?group_name=<?php echo $list['group_name'] ?>"><?php echo $list['group_name'] ?></a>
                    <?php
                } 
            ?>   
            <a class="nav-item admin-item" href="admin/index.php">Administrator Panel</a>     
        </div>
        <!-- <a href="login.php?continue_to=order.php" style="float:right">ORDER NOW</a>                       -->
    </div>
    <div id="content">
    <!--header Ends -->