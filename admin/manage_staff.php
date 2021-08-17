<?php
    require('connection.inc.php');
    require('functions.inc.php'); 
    // prx($_SERVER);
    if($_SESSION['ADMIN_LOGIN'] != 'yes'){ 
        ?>
        <script>window.location.href="index.php";</script>
     <?php
    } 
?>
<?php
    $userId='';
    $name='';
    $gender='';
    $dob='';
    $address='';
    $phone='';
    $aadhar='';
    $BId='';
    $image='';
    $password='';

    $msg='';
    $image_required='required';
    
    if(isset($_POST['submit'])){
        $userId=get_safe_value($con,$_POST['userId']);
        $name=get_safe_value($con,$_POST['name']);
        $gender=get_safe_value($con,$_POST['gender']);
        $dob=get_safe_value($con,$_POST['dob']);
        $address=get_safe_value($con,$_POST['address']);
        $phone=get_safe_value($con,$_POST['phone']);
        $aadhar=get_safe_value($con,$_POST['aadhar']);
        $BId=get_safe_value($con,$_POST['BId']);
        $Email=get_safe_value($con, $_POST['email']);
        if(isset($_GET['type']) && $_POST['image'] != ''){
            $image=get_safe_value($con,$_POST['image']);
        }
        
        $password=get_safe_value($con,$_POST['password']);
        $sql="select * from users where UserId='$userId'";
        $res= mysqli_query($con,$sql);
        $check=mysqli_num_rows($res);
        if($check>0){
            $msg="UserId already exists";  
        }
         //prx($_FILES);
        if($_FILES['image']['type'] != '' && $_FILES['image']['type'] != 'image/png'){
            if($_FILES['image']['type'] != 'image/jpg'){
                if($_FILES['image']['type'] != 'image/jpeg'){
                    $msg="Please select only png/jpg/jpeg image format";
                }
                
            }
            
        }

        if($msg == ''){
            
            $image=rand(11111111,99999999).'_'.$_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'],STAFF_IMAGE_SERVER_PATH.$image);
            $sql="insert into users(UserId,NAME,GENDER,DOB,ADR,PH,IMG,AADHAR,BID) values('$userId','$name','$gender','$dob','$address','$phone','$image','$aadhar','$BId')";
            $res=mysqli_query($con,$sql);
            $auth->addUser($userId, $password);
            $sql="update login_credentials set email = \"{$Email}\" where userid = \"{$userId}\"";
            $res=mysqli_query($con, $sql);
            echo mysqli_error($con);
            header('Location: staffManagement.php');
            die();
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="stylemanage.css">
    <title>Add or Edit Artwork | Gallery 15</title>
</head>
<body>
    <!--Header Starts -->
    <div>
        <!-- <h1 style="margin: 5px 5px; padding: 5px 5px; font-size: 40px; text-align:center; color: rgb(16, 17, 17); font-family: Arial, Helvetica, sans-serif;"> ARTBASE GALLERY</h1> -->
    </div>
   
    <form method="POST" enctype="multipart/form-data">
        <div style="padding: 16px 16px;"> 
            <h2 style="margin-left: 40px;">Staff Details</h2>
            <span>UserId:</span> <input type="text" name="userId" value="" required><br>
                            
            <span>Name:</span> <input type="text" name="name" value="" required><br>
            
            <span>Gender:</span> <select name="gender">
                <option>M</option>
                <option>F</option>
            </select><br>
            <span>DOB:</span><input type="date" name="dob" value="" required> <br>
            
            
            <span>Address:</span> <input type="text" name="address" value="" required><br>
            <span>Phone:</span> <input type="number" name="phone" value="" required><br>
            <span>Email ID:</span> <input type="email" name="email" value="" required><br>
            <span>Aadhar:</span> <input type="number" name="aadhar" value="" required><br>

            <span>Branch:</span> <select name="BId" required>
                    <?php 
                        $sql="select * from branch";
                        $res=mysqli_query($con,$sql); 
                    ?>
                    <!-- <option value="<?php echo $group_name ?>"><?php echo $group_name ?></option> -->
                    <?php
                        while($row=mysqli_fetch_assoc($res)){
                    ?>
                    <option value="<?php echo $row['BID'] ?>"><?php echo $row['BName'] ?></option>
                        
                    <?php 
                        }
                    ?>
            </select><br>
            <span>Password:</span> <input type="password" name="password" value="" required><br>
            <span>Image: <br>(Choose or Drag-and-Drop)</span> <input type="file" name="image" <?php echo $image_required ?>><br>
            
            <button style="cursor: pointer" type="submit" name="submit">Submit</button><br>
            
        </div>
        <div class="field_error">
            <strong><p style="text-align: center; color: red; font-size: 30px;"><?php echo $msg ?></p><strong>
        </div>
    </form>
   
</body>
</html>