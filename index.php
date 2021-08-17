<?php 
    require('connection.inc.php');
    require('functions.inc.php');
    $msg='';
    $type='admin';
    // prx($_SERVER);

   if(isset($_POST['submit'])){
      $username=get_safe_value($con,$_POST['username']);
      $password=get_safe_value($con,$_POST['password']);
      echo $username;
      echo $password;
    
      $sql="select * from users where UserId='$username'";// and password='$password'";
      $res=mysqli_query($con,$sql);
      $count=mysqli_num_rows($res);

      // prx($res);
      if($count > 0){
         if($row=mysqli_fetch_assoc($res)){
            // prx($row);
            $type = $row['TYPE'];
            $type='salesPerson';
            if($type == 'admin'){
                $_SESSION['ADMIN_LOGIN'] ='yes';
                 $_SESSION['ADMIN_USERNAME']=$username;
                 //prx($_SESSION);
                 header('location:admin/index.php');
                 die();
             }elseif($type == 'accountant') {
                 $_SESSION['ACCOUNTANT_LOGIN'] ='yes';
                 $_SESSION['ACCOUNTANT_USERNAME']=$username;
                 //prx($_SESSION);
                 header('location:accountant/index.php');
                 die();
             }
             elseif($type == 'salesPerson'){
                 $_SESSION['SALESPERSON_LOGIN'] ='yes';
                 $_SESSION['SALESPERSON_USERNAME']=$username;
                 //prx($_SESSION);
                 header('location:salesPerson/index.php');
                 die();
             }
             else{
                $msg="Invalid login credentials";
             }
         }
         
      }else{
         $msg="Please enter correct login details";
      }
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body class="body-index"> 
    <!-- Header starts -->
    <div class="sign-up-form">
        <form method="post">
            <div class="heading">
                <h2>ADMIN LOGIN</h2>
            </div>
            <div>
                <label for="username">Username</label><br>
                <input type="text" name="username" placeholder="Enter username" required><br>
                <label for="password">Password</label><br>
                <input type="password" name="password" placeholder="Enter password" required><br>
                <button type="submit" name="submit">Login</button>
            </div>
            
            <div class="field-error">
                     
                <p><?php
                    echo $msg;
                ?></p>
            </div>
        </form>
    </div>
</body>
</html>