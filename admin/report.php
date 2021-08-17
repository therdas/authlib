<?php 
    require('connection.inc.php');
    require('functions.inc.php');
    require('sidebar.inc.php');
    //require('index.php');
?>
<?php  
    if($_SESSION['ADMIN_LOGIN'] != 'yes'){ 
        ?>
        <script>window.location.href="index.php";</script>
    <?php
    }
    // if(isset($_GET['type']) && $_GET['type'] != ''){
    //     $type=get_safe_value($con,$_GET['type']);
    //     if($type=='delete'){
    //         $order_id=get_safe_value($con,$_GET['order_id']);
            
    //         $delete_sql="delete from orders where order_id='$order_id'";
    //         mysqli_query($con,$delete_sql);
    //     }
    // }
?>
<?php

    
    $sql="select * from orders order by order_id";
    $res=mysqli_query($con,$sql);
?>

    <div class="main_content">
        <div>
            <h3 style="float: right; margin-right: 40px;">Welcome, <?php echo $_SESSION['ADMIN_USERNAME'] ?></h3><br>
            <h3 style="margin-left: 1000px;"><a href="logout.php">Logout</a></h3>
        </div>
        <div class="card">
            <h4 class="box-title"><strong>Generate Report</strong></h4>
        </div>
        <div class="page-description">
            This form generates a report of the sales of artwork by a given artist in a given time period, along with the total sale figures.
            This form generates a report of the sales of artwork by a given artist in a given time period, along with the total sale figures.
            This form generates a report of the sales of artwork by a given artist in a given time period, along with the total sale figures.
        </div>
        <div>
            <form action="fetch_report.php" class="report-form" method="post" target="_blank">
                <button style="width: 90%; height: 50px; margin-left: 20px;" type="submit" class="submit-btn" value="Submit" name="submit">Generate All Branches Report</button>
                <br><br>
                <select style="width: 70%; height: 50px; margin-left: 20px">
                    <option>Select Branch</option>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                </select>
                <button style="width: 18%; height: 50px; margin-left: 20px;" type="submit" class="submit-btn" value="Submit" name="submit">Generate Branch Report</button>

                <!-- <input type="submit" style="float: right; margin-right: 50%; background: cyan; padding: 15px" value="Submit" name="submit"> -->
            </form>
           <!--  <form action="fetch_report.php" class="report-form" method="post" target="_blank">
                
                <select style="width: 70%; height: 50px; margin-left: 20px">
                    <option>Select Branch</option>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                </select>
                <button style="width: 18%; height: 50px; margin-left: 20px;" type="submit" class="submit-btn" value="Submit" name="submit">Generate Branch Report</button>

                <!-- <input type="submit" style="float: right; margin-right: 50%; background: cyan; padding: 15px" value="Submit" name="submit"> -->
            </form> -->
        </div>
    </div>
</body>
</html>
