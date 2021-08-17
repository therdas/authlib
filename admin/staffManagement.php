<?php 
    require('connection.inc.php');
    require('functions.inc.php');
    require('sidebar.inc.php');

    if($_SESSION['ADMIN_LOGIN'] != 'yes'){ 
        ?>
        <script>window.location.href="index.php";</script>
    <?php
    }
?>
<?php  
    if(isset($_GET['type']) && $_GET['type'] != ''){
        $type=get_safe_value($con,$_GET['type']);
        // if($type=='status'){
        //     $operation=get_safe_value($con,$_GET['operation']);
        //     $id=get_safe_value($con,$_GET['id']);
        //     if($operation=='active'){
        //         $status='1';
        //     }else{
        //         $status='0';
        //     }
        //     $update_status_sql="update categories set status='$status' where id='$id'";
        //     mysqli_query($con,$update_status_sql);
        // }
        if($type=='delete'){
            $userId=get_safe_value($con,$_GET['userId']);
            
            $delete_sql="delete from users where UserId='$userId'";
            $res=mysqli_query($con,$delete_sql);
            if($res == false){
                ?>
                <script>
                    alert("This users can't be deleted, as it is used as reference for other tables");
                </script>
                <?php
            }
        }
    }
?>
<?php

    
    $sql="select * from users order by UserId";
    $res=mysqli_query($con,$sql);
?>
<?php 


?>
    
    <div class="main_content">
        <div>
            <h3 style="float: right; margin-right: 40px;">Welcome, <?php echo $_SESSION['ADMIN_USERNAME'] ?></h3><br>
            <h3 style="margin-left: 1000px;"><a href="logout.php">Logout</a></h3>
        </div>
        <div class="card">
        
            
            <h4 class="box-title"><strong>Staff</strong><small> Details</small></h4>
            <h4 class="box-link"><a href="manage_staff.php">Add staff</a></h4>
            
        </div>
        <div class="">
            <div class="box-table">
                <table>
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Name</th>
                            <!-- <th>Email</th> -->
                            <th>Phone</h>
                            <th>Aadhar</th>
                            <th>Branch</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            while($row=mysqli_fetch_assoc($res)) {?>
                                <tr>
    
                                    <td><?php echo $row['UserId'] ?></td>
                                    <td><?php echo $row['NAME'] ?></td>
                                    <td><?php echo $row['PH'] ?></td>
                                    <td><?php echo $row['AADHAR'] ?></td>
                                    <?php 
                                        $bid=$row['BID'];
                                        $sql="select * from branch where BID='$bid'";
                                        $res1=mysqli_query($con,$sql);
                                        if($row1=mysqli_fetch_assoc($res1)){
                                    ?>
                                    <td><?php echo $row1['BName'] ?></td>
                                    <?php
                                     }
                                     else{
                                        ?>
                                        <td> </td>
                                    <?php
                                     }
                                     ?>
                                    <!-- <td><img src='php echo ARTWORK_IMAGE_SITE_PATH.$row['image'] ?>' height="100px" width="130px"></td>
                                    <td>₹php echo $row['price'] ?></td>
                                    <td>php echo $row['pieces'] ?></td> -->
                                    <td>
                                        <?php
                                            echo "<span class='delete'><a href='?type=delete&userId=".$row['UserId']."'>Delete</a></span>&nbsp&nbsp";
                                        ?> 
                                   </td>
                        
                                </tr>
                        <?php 
                            } 
                        ?>
                    </tbody>
                    
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>
