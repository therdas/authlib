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
            $title=get_safe_value($con,$_GET['title']);
            
            $delete_sql="delete from artwork where title='$title'";
            $res=mysqli_query($con,$delete_sql);
            if($res == false){
                ?>
                <script>
                    alert("This artwork can't be deleted, as it is used as reference for other tables");
                </script>
                <?php
            }
        }
    }
?>
<?php

    
    $sql="select * from artwork order by title";
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
        
            
            <h4 class="box-title"><strong>Artwork</strong><small> Details</small></h4>
            <h4 class="box-link"><a href="manage_artwork.php">Add Artwork</a></h4>
            
        </div>
        <div class="">
            <div class="box-table">
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Artist</th>
                            <th>Year</th>
                            <th>Type of Art</h>
                            <th>Group</th>
                            <th>Image</th>
                            <th>Price</th>
                            <th>Pieces Available</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            while($row=mysqli_fetch_assoc($res)) {?>
                                <tr>
    
                                    <td><?php echo $row['title'] ?></td>
                                    <td><?php echo $row['artist_name'] ?></td>
                                    <td><?php echo $row['year'] ?></td>
                                    <td><?php echo $row['type_of_art'] ?></td>
                                    <td><?php echo $row['group_name'] ?></td>
                                    <td><img src='<?php echo ARTWORK_IMAGE_SITE_PATH.$row['image'] ?>' height="100px" width="130px"></td>
                                    <td>₹<?php echo $row['price'] ?></td>
                                    <td><?php echo $row['pieces'] ?></td>
                                    <td>
                                        <?php
                                            echo "<span class='edit'><a href='manage_artwork.php?type=edit&title=".$row['title']."'>Edit</a></span>&nbsp&nbsp";
                                            echo "<span class='delete'><a href='?type=delete&title=".$row['title']."'>Delete</a></span>&nbsp&nbsp";
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
