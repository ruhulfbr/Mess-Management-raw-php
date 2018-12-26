<?php
require_once "config.php";

    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){

        $sql = "SELECT * FROM member ";
        $result = mysqli_query($link, $sql);
        $total_bazar = 0;
        $grand_total_meel = 0;
        $meel_rate = 1;
    
    while($row_1 = mysqli_fetch_array($result)){
        $total_bazar = $total_bazar+$row_1['bazar'];
        $grand_total_meel = $grand_total_meel + $row_1['total_meel'];
        $meel_rate = $total_bazar/$grand_total_meel;
        $meel_rate = round($meel_rate,2);
    } 
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM member WHERE id = '$id'";
            $result = mysqli_query($link, $sql);
    
            if(mysqli_num_rows($result) == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                // Retrieve individual field value
                $name = $row["name"];
                 $phone = $row["phone"];
                  $bazar = $row["bazar"];
                   $total_meel = $row["total_meel"];

            }
        
    mysqli_close($link);
    }else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Final Hisab</title>
    <link rel="stylesheet" href="assets/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 900px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <div class="page-header">
                        <h1 style="color: green;">Final Ammount For <b><?php echo $row["name"]; ?></b></h1>
                    </div>
                    <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Total Meel</th>
                        <th>Baazar</th>
                        <th>Meel Rate</th>
                        <th>Total Ammout</th>
                        <th>Remark</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td style="font-weight: bold;"><?php echo $row["name"]; ?></td>
                        <td><?php echo $row["phone"]; ?></td>
                        <td><?php echo $row["total_meel"]; ?></td>
                        <td><?php echo $row["bazar"]; ?> Taka</td>
                        <td><?php echo $meel_rate; ?> Taka</td>
                        <?php 
                            $total_ammount = $row["total_meel"] * $meel_rate;
                        ?>
                        <td><?php echo $total_ammount; ?> Taka</td>
                        <td>
                            <?php 
                                $dena_paona = $total_ammount - $row["bazar"];
                                $dena_paona = round($dena_paona,2);
                                if($dena_paona <0){
                                    echo "Need to Get from Mess : " . $dena_paona*-1 . "  Taka";
                                }else{
                                    echo "Need to Give Mess : " . $dena_paona . "  Taka";
                                }
                            ?>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                    
                    <p><a href="index.php" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>