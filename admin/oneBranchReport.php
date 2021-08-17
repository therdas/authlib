<?php
    require('connection.inc.php');
    require('functions.inc.php');
    //prx($_SESSION);
    if($_SESSION['ADMIN_LOGIN'] != 'yes'){ 
        ?>
        <script>window.location.href="index.php";</script>
    <?php
    }
    // prx($_POST);
    $res='';
?>

<?php
    if(isset($_POST["BId"])){
        $BId = get_safe_value($con, $_POST["BId"]);
    }
    $sql = "select model, VIN, count(AName) AS \"Acc\", sum(AAmount) As \"AccSum\", BPrice + sum(AAmount) AS \"Total\" from Bill NATURAL JOIN Accessories  NATURAL JOIN Vehicle where Branch = \"{$BId}\" group by BID ;";
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
                <span><img src="logo1.jpg"></span>
                <span>
                    <h1>Gallery 15</h1>
                    <h4>Where art meets inspiration</h4>
                </span>
                
            </div>
            

                <!-- <div class="fetch-report-artist-download">
                    <button class="btn btn-primary" id="download"> download pdf</button>
                </div> -->
            </div>

            <table class="mytable">
                <thead>
                    <tr>
                        <th>VIN</th>
                        <th>Model Name</th>
                        <th>No. Of Accessories</th>
                        <th>Total Price of Accessories</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(mysqli_num_rows($res)>0){
                            while($row=mysqli_fetch_assoc($res)){ ?>
                            <tr>
                                <td><?php echo $row['VIN'] ?></td>
                                <td><?php echo $row['model'] ?></td>
                                <td><?php echo $row['Acc'] ?></td>
                                <td><?php echo $row['AccSum'] ?></td>
                                <td><?php echo $row['Total'] ?></td>
                                <?php
                                     $tot = $tot + $row["Total"]; 
                                ?>
                            </tr>
                    <?php
                            }
                        }else{
                            echo "No data found";
                        }
                    ?>
                    <tr>
                        <td colspan="4">Total Sales:</td>
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