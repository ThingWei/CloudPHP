<?php
session_start();
require_once 'helper.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);
// Check if the user is logged in
if (!isset($_SESSION['admin_email'])) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <style>
            form {
                background-color: #444;
                color:white;
       

            }
        </style>
        <meta charset="UTF-8">
        <title>Delete Login Information</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <!--        <link href="css/login-delete.css" rel="stylesheet" type="text/css"/>-->
        <link href="css/login-insert.css" rel="stylesheet" type="text/css"/>
        <link href="css/header.css" rel="stylesheet" type="text/css"/>
        <link href="css/footer.css" rel="stylesheet" type="text/css"/>
       
    </head>
    <body>
        <!-- Navbar -->
        <?php include 'headerAdmin.php';?>
        <!-- End of Navbar -->

        <h1>&nbsp;</h1>
        <p>&nbsp;</p>
        <p>&nbsp;</p>

        <?php
        require_once 'helper.php';

        // Check if the user has clicked the delete button
        if (isset($_POST['btnDelete'])) {
            // Get the ID of the record from the form
            $id = $_POST['hdID'];

            // Delete the record from the database
            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            mysqli_set_charset($con, 'utf8');

            $sql = "DELETE FROM user WHERE username = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("s", $id);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                // Display the alert message on the same page
                echo "<script>alert('Account has been deleted.');</script>";

                // Redirect to the next webpage
                echo "<script>window.location.href = 'list-login.php';</script>";
            } else {
                echo "<div class='error'>Failed to delete record.</div>";
            }

            $stmt->close();
            $con->close();
        } else {
            // Get the ID of the record from the URL
            $id = trim($_GET["id"]);

            // Retrieve the details of the record from th+e database
            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            mysqli_set_charset($con, 'utf8');

            $sql = "SELECT * FROM user WHERE username = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("s", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_object();
                $result->free();
                ?>
                
                <h1>Delete Login Detail</h1>
                <form action="" method="POST" class="container mt-5 w-50 p-4 rounded shadow">
                    <div class="mb-3">
                        <label class="form-label"><strong>Username:</strong></label>
                        <input type="text" class="form-control" value="<?= $row->username ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Email:</strong></label>
                        <input type="email" class="form-control" value="<?= $row->email ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Gender:</strong></label>
                        <input type="text" class="form-control" value="<?= $row->gender ?>" readonly>
                    </div>
                    
            
                    <input type="hidden" name="hdID" value="<?= $row->username ?>">
            
                    <div class="mb-3 text-danger text-center fw-bold">Are you sure you want to delete this account?</div>
            
                    <div class="d-flex justify-content-center gap-3">
                        <button type="submit" name="btnDelete" class="btn btn-danger px-4"
                                onclick="return confirm('Are you sure you want to delete this record?')">Delete</button>
                        <a href="list-login.php" class="btn btn-secondary px-4">Cancel</a>
                    </div>
                </form>
            
                <?php
            } else {
                echo "<div class='error text-danger text-center mt-5 fw-bold'>Record not found.</div>";
            }
            
            $stmt->close();
            $con->close();
        }
        ?>


        <h1>&nbsp;</h1>

        <!-- Footer -->
        <?php include 'footerAdmin.php'; ?>

        <!-- End Of Footer -->

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    </body>
</html>
