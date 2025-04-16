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
            html,
            .wrapper {
                background-color: #999999;
                width: 100%;
            }

            #video {
                display: none;
                width: 100%;
                max-width: 400px;
                margin: 0 auto;
            }

            details {
                margin-bottom: 20px;
                background-color: #f2f2f2;
                padding: 10px;
                border-radius: 5px;
            }

            /* Style the summary element inside details */
            summary {
                cursor: pointer;
                font-size: 16px;
                font-weight: bold;
                background-color: #ddd;
                padding: 5px 10px;
                border-radius: 3px;
            }
        </style>
    <body>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg fixed-top">
            <div class="container-fluid">
                <a class="navbar-brand me-auto" href="home.php"><img class="mslogo" src="img/music.png"
                                                                     style="height:65px;width:65px;"></a>
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                     aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasNavbarLabel"><img class="mslogo" src="img/music.png">
                            &nbsp; RT Music Society</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
                            <li class="nav-item">
                                <a class="nav-link mx-lg-2" aria-current="page" href="home.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mx-lg-2" aria-current="page" href="event.php">Events</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mx-lg-2" aria-current="page" href="displayTicket.php">Purchased Tickets</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mx-lg-2" href="aboutus.php">About Us</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mx-lg-2" href="feedback.php">Feedback</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mx-lg-2" href="faq.php">FAQ</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <a href="profile.php"><img class="profilepic" src="img/profile.png"></a>
                <button class="navbar-toggler pe-0" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                </button>
            </div>
        </nav>
        <!-- End of Navbar -->

        <form>
            <div class="wrapper">
                <div class="left">
                    <div class="userimage">
                        <img style="border-radius: 50%" src="img/profile.png" alt="user" id="img0" width="100;" />
                    </div>
                    <h4><b><?php echo htmlspecialchars($name); ?></b></h4>

                </div>
                <div class="right">
                    <div class="info">
                        <h3>Information</h3>
                        <div class="info_data">
                            <div class="data">
                                <h4>Email</h4>
                                <b><?php echo htmlspecialchars($email); ?></b>
                            </div>
                            <div class="data">
                                <h4>Gender</h4>
                                <b><?php echo htmlspecialchars($gender); ?></b>
                            </div>
                        </div>
                    </div>
                    <input type="button" class="btn btn-primary" value="Change User Details" onclick="document.location.href = 'updateUserDets.php?id=<?php echo $name ?>'">
                </div>
            </div>
        </form>

        <div class="change" style="margin-bottom:20px;">
            <details>
                <summary>Choose User Image</summary>
                <div class="imgset" style="width: 65%;height: 6rem; ">
                    <img src="img/profile.png" alt="" width="100" onclick="changeprofile('img/profile.png')">
                    <img src="img/profile1.png" alt="" width="100" onclick="changeprofile('img/profile1.png')">
                    <img src="img/profile2.png" alt="" width="100" onclick="changeprofile('img/profile2.png')">
                    <img src="img/profile3.png" alt="" width="100" onclick="changeprofile('img/profile3.png')">
                    <img src="img/profile4.png" alt="" width="100" onclick="changeprofile('img/profile4.png')">
                    <img src="img/profile5.png" alt="" width="100" onclick="changeprofile('img/profile5.png')">
                    <img src="img/profile6.png" alt="" width="100" onclick="changeprofile('img/profile6.png')">
                    <img src="img/profile7.png" alt="" width="100" onclick="changeprofile('img/profile7.png')">
                    <img src="img/profile8.png" alt="" width="100" onclick="changeprofile('img/profile8.png')">

                </div>
            </details>
            <details>
                <summary>Capture Photo to Change User Image</summary>
                <button id="start-btn" onclick="startCapture()" style="">Start Capture</button>
                <!--                use to display the capture video-->
                <video id="video" autoplay></video>
                <!--                use to capture image-->
                <button id="capture-btn" onclick="capturePhoto()" style="display:none;">Capture Photo</button>
            </details>
        </div>
        <div class="logout" style="margin-bottom:20px"><form method='post'><button type="submit" name="logout" class="btn btn-primary"
                                                                                   style='display:block;margin-left: auto;margin-right: auto' onclick="alert('<?php echo htmlspecialchars($email); ?>, you have successfully logged out. \nThanks for using RT Music Society\'s website.\nWe hope to see you again soon.')" >Log Out</button></form></div>

        <!-- Footer -->
        <div class="foot">
            <footer>
                <div class="rowfoot">
                    <div class="colfoot">
                        <img src="img/music.png" class="logofoot">
                        <p class="parafoot">Welcome to Rizzy Tempo Music Society, where passion meets melody and rhythm!
                            Whether you're a seasoned virtuoso or just beginning your musical journey, our society offers a
                            harmonious space for creativity, learning, and collaboration.</p>
                        <br>
                        <p class="parafoot">Join us as we embark on a symphonic adventure, doesn't matter if you're here to
                            listen, learn, or lend your talents!</p>
                    </div>
                    <div class="colfoot">
                        <h3>Contact Us<div class="underline"><span class="uline"></span></div>
                        </h3>
                        <p class="parafoot">77, Lorong Lembah</p>
                        <p class="parafoot">Permai 3, 11200 </p>
                        <p class="parafoot">Tanjung Bungah,</p>
                        <p class="parafoot">Pulau Pinang, Malaysia</p>
                        <p class="email-id">penang@tarc.edu.my</p>
                        <h4><a class="callus" href="tel:+04-899 5230">(+6) 04-899 5230</a></h4>
                    </div>
                    <div class="colfoot">
                        <h3>Navigation<div class="underline"><span class="uline"></span></div>
                        </h3>
                        <ul class="footnav">
                            <li><a href="home.php">Home</a></li>
                            <li><a href="event.php">Events</a></li>
                            <li><a href="displayTicket.php">Purchased Tickets</a></li>
                            <li><a href="aboutus.php">About Us</a></li>
                            <li><a href="feedback.php">Feedback</a></li>
                            <li><a href="faq.php">FAQ</a></li>
                        </ul>
                    </div>
                    <div class="colfoot">
                        <h3 style="font-size: 14px;" class="fblow">Find Us Thru Our Social Media Below!<div
                                class="underline"><span class="uline"></span></div>
                        </h3>
                        <div>
                            <a href="https://www.instagram.com/"><button id="insta" style="background-image: url(img/instalogo.png);background-size: cover; width: 45px;
                                                                         height: 43px; box-sizing: border-box;"></button></a>
                            <a href="https://www.facebook.com/"><button id="facebook" style="background-image: url(img/facebooklogo.png);background-size: cover; width: 45px;
                                                                        height: 43px; box-sizing: border-box;"></button></a>
                            <a href="https://twitter.com/"><button id="twitter" style="background-image: url(img/twitterlogo.png);background-size: cover; width: 45px;
                                                                   height: 43px; box-sizing: border-box;"></button></a>
                            <a href="https://mail.google.com/"><button id="email" style="background-image: url(img/maillogo.png);background-size: cover; width: 45px;
                                                                       height: 43px; box-sizing: border-box;"></button></a>
                            <a href="https://www.whatsapp.com/"><button id="phone" style="background-image: url(img/whatsapplogo.png);background-size: cover; width: 45px;
                                                                        height: 43px; box-sizing: border-box;"></button></a>
                        </div>
                    </div>
                </div>
                <hr>
                <p class="parafoot" style="text-align: center; font-size: 16px;">Rizzy Tempo Music Society @ 2024</p>
            </footer>
        </div>
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