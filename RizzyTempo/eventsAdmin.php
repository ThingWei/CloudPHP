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
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_name'])) {
    $eventNameToDelete = $_POST['delete_name'];

    // Connect to database
    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    // Delete using prepared statement
    $stmt = $con->prepare("DELETE FROM event WHERE eventName = ?");
    $stmt->bind_param("s", $eventNameToDelete);

    if ($stmt->execute()) {
        echo "<script>alert('Product deleted successfully.'); window.location.href='eventsAdmin.php';</script>";
    } else {
        echo "<script>alert('Error deleting product.');</script>";
    }

    $stmt->close();
    $con->close();
}
?>

<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->

<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="css/header.css" rel="stylesheet">
    <link href="css/footer.css" rel="stylesheet">
    <link href="css/event.css" rel="stylesheet">
    <style>
        .navbar {
            box-sizing: content-box;
        }

        body {
            background-color: lightgray;
            background-size: cover;
            width: 100%;
        }

        .img {
            width: 20px;
            height: 20px;
        }

        .custom-card:hover {
            .content_text {
                margin: auto;
                width: 70%;
                border-radius: 10px;
                background: rgba(255, 255, 255, 0.7);
            }
        }

        .createbtn{
            background-color: #009970;
            border: none;
            border-radius: 16px;
            padding: 5px;
            color: white;
            transition: 0.3s background-color;
        }

        .createbtn:hover{
            background-color: #00b383;
            transform: scale(1.05);
        }
        .deletebtn{
            background-color:rgb(235, 0, 0);
            border: none;
            border-radius: 16px;
            padding: 5px;
            color: white;
            transition: 0.3s background-color;
        }

        .deletebtn:hover{
            background-color:rgb(200, 0, 0);
            transform: scale(1.05);
        }
    </style>
</head>

<body>
    <?php
        require_once 'helper.php';
    ?>
    <?php
    include 'headerAdmin.php';
    ?>
    

    <p class="gap">&nbsp;</p>

    <!-- Content -->
    <?php
        //connect php to database
        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }

        //sql statement
        $sql = "SELECT * FROM event";

        //ask coonection to run sql query 
        $result = $con->query($sql);

        if ($result->num_rows > 0) {
            // Record found
            echo '<div id="container">';
            echo '<h1 style="margin: auto; text-align: center; padding-bottom: 20px;">Active Products</h1>';
            echo '<div class="d-flex justify-content-center">
        <a href="createEvent.php"><button class="createbtn">Create Product</button></a> &nbsp;&nbsp;
        <button id="toggleDelete" class="deletebtn">Delete Product</button>
        </div>
        <br></br>';
        echo '<div class="container">';
        echo '<div class="row row-cols-1 row-cols-md-3 g-4">';
        
        while ($row = $result->fetch_object()) {
            echo '
            <div class="col">
                <div class="card h-100 text-center shadow">
                    <img src="' . htmlspecialchars($row->eventBanner) . '" class="card-img-top" style="height: 150px; object-fit: cover;" alt="Banner">
                    <div class="card-body">
                        <h5 class="card-title">' . htmlspecialchars($row->eventName) . '</h5>
                        <form method="POST" onsubmit="return confirm(\'Are you sure you want to delete this product?\');" class="delete-form d-none">
    <input type="hidden" name="delete_name" value="' . htmlspecialchars($row->eventName) . '">
    <button type="submit" class="btn btn-danger mt-2">Delete</button>
</form>
                    </div>
                </div>
            </div>';
        }
        
        echo '</div>';
        echo '</div>';
        echo '</div>';
            // Free result set and close connection
            $result->free();
            $con->close();
        } else {
            // No records returned
        }
        ?>
    <!-- End of Content -->
    <p class="gap">&nbsp;</p>
    <!-- Footer -->
        <?php
        include 'footerAdmin.php';
        ?>
        <!-- End Of Footer -->
        
        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
        <script>
    document.getElementById('toggleDelete').addEventListener('click', function () {
        const deleteForms = document.querySelectorAll('.delete-form');
        deleteForms.forEach(form => {
            form.classList.toggle('d-none');
        });
    });
</script>
</body>

</html>
