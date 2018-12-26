<?php
session_start();
// Include config file
require_once "config.php";
 

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $name = trim($_POST["name"]);
    $phone = trim($_POST["phone"]);
    $bazar = trim($_POST["bazar"]);
    $total_meel = trim($_POST["total_meel"]);
    
    
    // Check input errors before inserting in database
    if(!empty($name) && !empty($phone) && !empty($bazar) && !empty($total_meel)){
        // Prepare an insert statement
        $sql = "INSERT INTO member (name, phone, bazar,total_meel) VALUES ('$name', '$phone','$bazar','$total_meel')";
         
        if (mysqli_query($link, $sql)) {
            
            $_SESSION['success'] = "New record created successfully";
            header("location:index.php");
        } else {
            $_SESSION['roor'] = "Error: " . $sql . "<br>" . mysqli_error($link);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="assets/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 800px;
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
                        <h2>Add New Member</h2>
                    </div>
                    <p>Please fill this form and submit to add employee record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" required="" placeholder="Enter Member Name">
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                           <input type="number" name="phone" class="form-control" placeholder="Enter Member Phone Number" required="">
                        </div>
                        <div class="form-group">
                            <label>Total Meel</label>
                           <input type="number" name="total_meel" class="form-control" placeholder="Enter TOtal Meel" required="">
                        </div>
                        <div class="form-group">
                            <label>Bazar</label>
                           <input type="number" name="bazar" class="form-control" placeholder="Enter Bazar Ammount" required="">
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>