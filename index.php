<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mess Management</title>
    <link rel="stylesheet" href="assets/bootstrap.css">
    <script src="assets/jquery.min.js"></script>
    <script src="assets/bootstrap.js"></script>
    <style type="text/css">
        .wrapper{
            width: 900px;
            margin: 0 auto;
        }
        .page-header h2{
            margin-top: 0;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <h1>Welcome To Ideal Mess</h1>
                        <h3 class="pull-left">Members Details</h3>
                        
                    </div>
                    <h1><a href="create.php" class="btn btn-success">Add New Member</a></h1>
                    <?php 
                        if(isset($_SESSION['success'])){
                            $msg = $_SESSION['success'];
                    ?>
                    <div class="alert alert-success">
                      <strong>Success!</strong> <?php echo $msg; ?>
                    </div>
                            
                     <?php   }
                        if(isset($_SESSION['error'])){
                            $msg = $_SESSION['error'];
                    ?>
                    <div class="alert alert-danger">
                      <strong>Error!</strong> <?php echo $msg; ?>
                    </div>
                    <?php
                        }
                        session_destroy();
                    ?>
                    <?php
                    // Include config file
                    require_once "config.php";
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM member";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th>Name</th>";
                                        echo "<th>phone</th>";
                                        echo "<th>Bazar</th>";
                                        echo "<th>Total Mill</th>";
                                        echo "<th>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";

                                $sl = 1;
                                $total_bazar = 0;
                                $grand_total_meel = 0;
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $sl++ . "</td>";
                                        echo "<td>" . $row['name'] . "</td>";
                                        echo "<td>" . $row['phone'] . "</td>";
                                        echo "<td>" . $row['bazar'] . "</td>";
                                        echo "<td>" . $row['total_meel'] . "</td>";
                                        echo "<td>";
                                            echo "<a class='btn btn-xs btn-info' href='read.php?id=". $row['id'] ."' title='View Record' data-toggle='tooltip'> View</a>";
                                            echo "<a class='btn btn-xs btn-warning' href='update.php?id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'> Edit</a>";
                                            echo "<a class='btn btn-xs btn-danger' href='delete.php?id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'> Delete</a>";
                                        echo "</td>";
                                    echo "</tr>";

                                    $total_bazar = $total_bazar+$row['bazar'];
                                    $grand_total_meel = $grand_total_meel + $row['total_meel'];
                                    $meel_rate = $total_bazar/$grand_total_meel;
                                    $meel_rate = round($meel_rate,2);


                                }
                                echo "</tbody>"; 
                                echo "<thead>";
                                    echo "<tr>";
                                      
                                        echo "<th style='text-align:right' colspan='4'>Total Bazar = $total_bazar Taka</th>";
                                        echo "<th colspan='1'>Total Mill = $grand_total_meel Taka</th>";
                                        echo "<th colspan='1'>Meel Rate = $meel_rate Taka</th>";
                                    echo "</tr>";
                                echo "</thead>";                           
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                    }
 
                    // Close connection
                    mysqli_close($link);
                    ?>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>