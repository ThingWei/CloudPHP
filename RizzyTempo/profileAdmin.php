<?php
session_start();
require_once 'helper.php';

// Check if the user is logged in
if (!isset($_SESSION['admin_email'])) {
    header('Location: index.php');
    exit();
}
// Check if the logout button is clicked
if (isset($_POST['logout'])) {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect back to index.php or any other page after logout
    header("Location: index.php");
    exit;
}

// Retrieve user email from session
$user_email = $_SESSION['admin_email'];

// Create a new database connection
$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Prepare SQL statement to fetch user profile
$stmt = $con->query("SELECT * FROM admin WHERE email = '$user_email'");

if ($row = $stmt->fetch_object()) {
    $name = $row->adminName;
    $email = $row->email;
}

$stmt->close();
$con->close();
?>
<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Project/PHP/PHPProject.php to edit this template
-->
<html>

    <head>
        <meta charset="UTF-8">
        <title>Profile</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="css/profile.css" rel="stylesheet" type="text/css" />
        <link href="css/header.css" rel="stylesheet" type="text/css" />
        <link href="css/footer.css" rel="stylesheet" type="text/css" />
        <style>
            <style>
            body {
                background-color: #f0f0f0;
                margin-top: 120px;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }
            .profile-container {
                display: flex;
                padding-top: 20px;
                flex-direction: row; /* Force horizontal layout */
                flex-wrap: nowrap; /* Prevent wrapping to new line */
                gap: 20px;
                max-width: 1000px;
                margin: auto;
                height: 450px;
                
            }

            /* Add this media query for mobile devices */
            @media (max-width: 768px) {
                .profile-container {
                    flex-direction: column; /* Switch to vertical on small screens */
                }
            }
            .profile-card {
                background-color: #333;
                color: white;
                border-radius: 10px;
                padding: 30px;
                text-align: center;
                width: 100%;
                max-width: 350px;
                align-content: center;
            }
            .profile-details {
                background-color: #333;
                color: white;
                border-radius: 10px;
                padding: 30px;
                padding-left: 10%;
                padding-right: 10%;
                width: 100%;
                flex-grow: 1;
                align-content: center;
            }
            .avatar {
                width: 120px;
                height: 120px;
                margin: 0 auto 20px;
                position: relative;
            }
            .avatar img {
                width: 100%;
                height: 100%;
                border-radius: 50%;
                object-fit: cover;
            }
            .detail-row {
                padding: 15px 0;
                border-bottom: 1px solid #444;
                display: flex;
            }
            .detail-row:last-child {
                border-bottom: none;
            }
            .detail-label {
                font-weight: 500;
                width: 150px;
            }
            .detail-value {
                color: #a0a0a0;
            }
        </style>
    </head>

    <body>
        <!-- Navbar -->
        <?php include 'headerAdmin.php'; ?> 
        <!-- End of Navbar -->

        <form>
            <div class="profile-container" style="margin-top: 9%;">
            <!-- Left Profile Card -->
            <div class="profile-card">
                <div class="avatar">
                    <img src="img/adminprofile.png" alt="User" id="img0" width="100;" class="rounded-circle">
                </div>
                <h3><b><?php echo htmlspecialchars($name); ?></b></h3>
            </div>
            
            <!-- Right Details Card -->
            <div class="profile-details">
                <div class="detail-row">
                    <div class="detail-label">Name</div>
                    <div class="detail-value"><?php echo htmlspecialchars($name); ?></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Email</div>
                    <div class="detail-value"><?php echo htmlspecialchars($email); ?></div>
                </div>
                <br/>
            </div>
            
        </div>
        </form>

        <br/>
        <div class="logout" style="margin-bottom:20px"><form method='post'><button type="submit" name="logout" class="btn btn-primary"
        style='display:block;margin-left: auto;margin-right: auto' 
        onclick="alert('<?php echo htmlspecialchars($email); ?>, you have successfully logged out. \nThanks for using RT Music Society\'s website.\nWe hope to see you again soon.')" >
        Log Out</button></form></div>


        <!-- Footer -->
        <?php include 'footerAdmin.php'; ?>
        <!-- End Of Footer -->
                                                                                   
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    </body>
</html>