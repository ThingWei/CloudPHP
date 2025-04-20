<?php
session_start();
require_once 'helper.php';

// Check if the user is logged in
if (!isset($_SESSION['user_email'])) {
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
$user_email = $_SESSION['user_email'];

// Create a new database connection
$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Prepare SQL statement to fetch user profile
$stmt = $con->query("SELECT * FROM user WHERE email = '$user_email'");

if ($row = $stmt->fetch_object()) {
    $name = $row->username;
    $email = $row->email;
    $gender = $row->gender;
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
                margin: 0 auto;
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
            .btn-follow {
                background-color: #3b7fdb;
                color: white;
                border: none;
                padding: 8px 30px;
                margin-right: 10px;
            }
            .btn-message {
                background-color: transparent;
                color: white;
                border: 1px solid #555;
                padding: 8px 25px;
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
            .changeBtn {
                display: flex;
                justify-content: center;
                margin-top: 20px; /* optional spacing */
            }
        </style>
    <body>
        <!-- Navbar -->
        <?php include 'headerUser.php'; ?>
        <!-- End of Navbar -->

        <form>
            <div class="profile-container">
            <!-- Left Profile Card -->
            <div class="profile-card">
                <div class="avatar">
                    <img src="img/profile.png" alt="User" id="img0" width="100;" class="rounded-circle">
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
                <div class="detail-row">
                    <div class="detail-label">Gender</div>
                    <div class="detail-value"><?php echo htmlspecialchars($gender); ?></div>
                </div>
                <br/>
                <div class="changeBtn">
                    <input type="button" class="btn btn-primary" value="Change User Details" onclick="document.location.href = 'updateUserDets.php?id=<?php echo $name ?>'">
                </div>
            </div>
            
        </div>
        </form>

        <br/>
        <div class="logout" style="margin-bottom:20px"><form method='post'><button type="submit" name="logout" class="btn btn-primary"
        style='display:block;margin-left: auto;margin-right: auto' 
        onclick="alert('<?php echo htmlspecialchars($email); ?>, you have successfully logged out. \nThanks for using RT Music Society\'s website.\nWe hope to see you again soon.')" >
        Log Out</button></form></div>


        <!-- Footer -->
        <?php include 'footerUser.php'; ?>
        <!-- End Of Footer -->

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    </body>
    <script>
        var video = document.getElementById('video');
        var canvas = document.createElement('canvas');
        var userImg = document.getElementById('img0');

        function startCapture() {
            // Access webcam
            navigator.mediaDevices.getUserMedia({video: true})
                    .then(function (stream) {
                        video.srcObject = stream;
                        video.play();
                        video.style.display = 'block'; // Show the video element
                        document.getElementById('start-btn').style.display = 'none'; // Hide the start button
                        document.getElementById('capture-btn').style.display = 'block'; // Show the capture button
                    })
                    .catch(function (err) {
                        console.log('Error accessing webcam:', err);
                    });
        }

        function capturePhoto() {
            var context = canvas.getContext('2d');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            var imageDataURL = canvas.toDataURL('image/png');
            userImg.src = imageDataURL;
            // Save captured image data to local storage
            localStorage.setItem('capturedImage', imageDataURL);
            stopCapture();
        }

        function stopCapture() {
            var stream = video.srcObject;
            var tracks = stream.getTracks();
            tracks.forEach(function (track) {
                track.stop();
            });
            video.srcObject = null;
            video.style.display = 'none'; // Hide the video element
            document.getElementById('start-btn').style.display = 'block'; // Show the start button
            document.getElementById('capture-btn').style.display = 'none'; // Hide the capture button
        }

        function changeprofile(imageSrc) {
            userImg.src = imageSrc;
            localStorage.setItem('lastProfileImage', imageSrc);
            localStorage.removeItem('capturedImage'); // Remove captured image data when a profile image is selected
        }

        window.onload = function () {
            var lastProfileImage = localStorage.getItem('lastProfileImage');
            if (lastProfileImage) {
                userImg.src = lastProfileImage;
            } else {
                // If no last profile image is set, use the default profile image
                userImg.src = 'image/profile.png';
            }

            // retrieve captured image data from local storage
            var capturedImage = localStorage.getItem('capturedImage');
            if (capturedImage) {
                userImg.src = capturedImage;
            }
        };
    </script>


</html>