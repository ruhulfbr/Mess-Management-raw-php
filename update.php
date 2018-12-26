<?php
session_start();
// Include config file
require_once "config.php";
$name = "";
$phone = "";
$bazar = "";
$total_meel = "";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate name
    $name = trim($_POST["name"]);
    $phone = trim($_POST["phone"]);
    $bazar = trim($_POST["bazar"]);
    $total_meel = trim($_POST["total_meel"]);
    
    
    // Check input errors before inserting in database
    if(!empty($name) && !empty($phone) && !empty($bazar) && !empty($total_meel)){
        // Prepare an update statement
        $sql = "UPDATE member SET name='$name', phone='$phone', bazar='$bazar', total_meel='$total_meel' WHERE id='$id'";
         if (mysqli_query($link, $sql)) {
                
                $_SESSION['success'] = "Successfully Updated";
                header("location:index.php");
            } else {
                
                $_SESSION['success'] = "Error: " . $sql . "<br>" . mysqli_error($link);
            }
    }else{
        echo "Please Fill Up Form Correctly";
    }
    
    // Close connection
    mysqli_close($link);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
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
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="assets/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
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
                        <h2>Update Member</h2>
                    </div>
                    <p>Please edit the input values and submit to update the record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="number" name="phone" class="form-control" value="<?php echo $phone; ?>">
                        </div>
                        <div class="form-group">
                            <label>Bazar</label>
                            <input type="number" name="bazar" class="form-control" value="<?php echo $bazar; ?>">
                        </div>
                        <div class="form-group">
                            <label>Total Meel</label>
                            <input type="number" name="total_meel" class="form-control" value="<?php echo $total_meel; ?>">
                        </div>

                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Update">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>