<?php
    require('connection.inc.php');
    require('functions.inc.php');
    //prx($_SESSION);
    if($_SESSION['SALESPERSON_LOGIN'] != 'yes'){ 
        ?>
        <script>window.location.href="index.php";</script>
    <?php
    }
    $res='';
?>

<?php
    $salesPersonId=$_SESSION['SALESPERSON_USERNAME'];
    $sql = "select * from bill where SBY='$salesPersonId';";
    $res = mysqli_query($con, $sql);
    $tot = 0;
    
    if($res == false) {
        ?>
            <script>
                window.alert("Something went wrong...." + "<?php echo mysqli_error($con)?>");
                die();
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
    <title>Report For ArtGallery</title>
    <link rel="stylesheet" type="text/css" href="report.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="pdf.css" />
    <script src="pdf.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
</head>
    <body class="fetch-report-body" id="download">

        <!-- <div class="fetch-report-artist-download"> -->
            <button style="float: right; margin-right: 20%; margin-top: 20px;"class="btn btn-primary printButton" id="download"> 
                download pdf
            </button>
        <!-- </div> -->
        <div class="fetch-report-table" id="toPrint">
            
            <div class="logo-container">
                
                <!-- <span class="logo"> <b>G<sup>15</sup></b> </span><br/> -->
                <span><img src="../images/logo.png" width="200px" height="200px"></span>
                
                
            </div>
            

                <!-- <div class="fetch-report-artist-download">
                    <button class="btn btn-primary" id="download"> download pdf</button>
                </div> -->
                <br><br>
                <span>
                    <h1>Sales Person's Report</h1>
                </span>

            <table class="mytable">
                <thead>
                    <tr>
                        <th>Bill Id</th>
                        <th>Date</th>
                        <th>Sales Price</th>
                        
                        
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(mysqli_num_rows($res)>0){
                            while($row=mysqli_fetch_assoc($res)){ ?>
                            <tr>
                                <td><?php echo $row['BID'] ?></td>
                                <td><?php echo $row['DATE'] ?></td>
                                <td><?php echo $row['BPRICE'] ?></td>
                                <?php
                                     $tot = $tot + $row['BPRICE']; 
                                ?>
                            </tr>
                    <?php
                            }
                        }else{
                            echo "No data found";
                        }
                    ?>
                    <tr>
                        <td colspan="2">Total Sales:</td>
                        <td colspan="1">₹<?php echo $tot ?></td>
                    </tr>
                </tbody>
            </table>
            
        </div>
        
        <div>
            <!-- Print button -->
            <button class="printButton" onclick="myfunc('toPrint')">Print</button><br>
            <!-- <button class="printButton" onclick="myfunc('toDownload')">MakePdf</button> -->
            <!-- <button class="btn btn-primary" id="download"> download pdf</button> -->
            
            <button style="float: right; margin-bottom:20px; margin-right: 21%" class="btn btn-primary printButton" id="download"> download pdf</button>
            
        </div>
            
        <script type="text/javascript">
            function myfunc(toPrint){
                // var backup = document.body.innerHTML;
                // var printcontent = document.getElementById('toPrint').innerHTML;
                // document.body.innerHTML = printcontent;
                window.print();
                //document.body.innerHTML = backup;
            }

        </script>

    </body>
</html>