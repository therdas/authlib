<?php 
    // require('connection.inc.php');
    // require('functions.inc.php');
    require('sidebar.inc.php');
    //require('index.php');
?>
<?php  
    if($_SESSION['SALESPERSON_LOGIN'] != 'yes'){ 
        ?>
        <script>window.location.href="/RAS/index.php";</script>
    <?php
    }
    
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

    <div class="main_content">
        <div>
            <h3 style="float: right; margin-right: 40px;">Welcome, <?php echo $row['NAME'] ?></h3><br>
            <h3 style="margin-left: 1000px;"><a href="logout.php">Logout</a></h3>
        </div>
        <div class="card">
            <h4 class="box-title"><strong>Generate Report</strong></h4>
        </div>
        <div class="page-description" style="margin-left: 20px;">
            This form generates a report of the sales of artwork by a given artist in a given time period, along with the total sale figures.
            This form generates a report of the sales of artwork by a given artist in a given time period, along with the total sale figures.
            This form generates a report of the sales of artwork by a given artist in a given time period, along with the total sale figures.
        </div><br><br>
        <div>
            <form action="salesPersonReport.php" class="report-form" method="post" target="_blank">
                
                <button style="width: 90%; height: 50px; margin-left: 20px; cursor: pointer;" type="submit" class="submit-btn" value="Submit" name="submit">See Your Sales Report</button>
            </form>
        </div><br><br>
        
    </div>
</body>
</html>
