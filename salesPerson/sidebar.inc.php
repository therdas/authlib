<?php
    require('connection.inc.php');
    require('functions.inc.php');
?>

<?php
$userId=$_SESSION['SALESPERSON_USERNAME'];
$sql="select * from users where UserId='$userId'";
$res=mysqli_query($con,$sql);
if($res == true){
    if($row=mysqli_fetch_assoc($res)){

    }
    else{
    ?>
        <script>
            alert("Something went wrong, try later");
            window.location.href='/RAS/index.php';
        </script>
    <?php
    }
}
else{
    ?>
    <script>
        alert("Something went wrong, try later");
        window.location.href='/RAS/index.php';
    </script>
<?php
}
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
        <div style="margin-left: 9%">
        <img src="<?php echo STAFF_IMAGE_SITE_PATH.$row['IMG']?>" width="100px" height="100px" style="border: 1px solid black; border-radius: 50%">
        <h1><?php echo $row['NAME'] ?></h1>
        <h4>Logged In as Sales Person</h4>
    </div>
        
    <div style="margin-left: 9%; margin-top: 10%">
        <a style="color: black;" href="index.php">Sales Report</a>
    </div>
    <!-- side bar ends -->
</div>