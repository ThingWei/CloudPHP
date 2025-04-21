<?php
session_start();
require_once 'helper.php';

// Check if the user is logged in
if (!isset($_SESSION['user_email'])) {
    header('Location: index.php');
    exit();
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
    <title>Welcome to TAR UMT Graduation Service</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="css/header.css" rel="stylesheet">
    <link href="css/footer.css" rel="stylesheet">
    <link href="css/hometry.css" rel="stylesheet">
    <style>
        .navbar {
            box-sizing: content-box;
        }

        body {
            background: url('img2/background.png') no-repeat center center fixed;
            background-size: cover;
            width: 100%;
            height: 100%;
        }

        h1, h2, h3, p {
            color: white; /* or try #fffae3, #f0f0f0 for softer brightness */
            text-shadow: 1px 1px 2px black; /* optional: gives text more contrast */
        }

        body, html {
            height: 100%;
        }

        .background-container {
            position: relative;
            background: url('img2/background.png') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
        }

        .background-container::before {
            content: "";
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background-color: rgba(0, 0, 0, 0.4); /* 👈 adjust for light/dark overlay */
            z-index: 1;
        }

        .background-container > * {
            position: relative;
            z-index: 2;
            color: white; /* Makes text readable on dark overlay */
        }

        .img {
            width: 20px;
            height: 20px;
        }

        .background-image {
            background-image: url('img2/recentgraduates.jpg');
            background-size: cover;
            background-position: center;
            height: 700px;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .overlay {
            background-color: rgba(0, 0, 0, 0.5);
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .overlay h1 {
            font-size: 25px;
            text-align: center;
            color: white;
        }

        .overlay h1:hover {
            color: #E1C564;
        }

        .gallery-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;

        }

        div.gallery {
            margin: 5px;
            border: 2px solid white;
            float: left;
            width: 180px;
            margin-right: 15px;

        }

        div.gallery:hover {
            border: 1px solid black;
        }

        div.gallery img {
            width: 100%;
            height: 250px;
        }

        div.desc {
            padding: 5px;
            text-align: center;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <?php include 'headerUser.php'; ?>
    <!-- End of Navbar -->

    <div class="background-image">
        <div class="overlay">
            <h1 style="font-size:50px;"><b>Welcome To TAR UMT Graduation Services</b></h1>
        </div>
    </div>

    <div class="background-container">
        <h1 style="text-align:center;font-size:45px;margin-top:50px;">About Us<br></h1>
        <p style="font-size:20px;text-align:center;margin-top:20px;">
            At TAR UMT Graduation Services, we’re here to help you celebrate your big day.<br>
            We offer beautiful graduation flowers, gift bundles, and plush toys – perfect for marking this special moment. <br>
            Whether you're graduating or supporting someone who is, we’ve got just the thing to make it memorable.<br>
            Thank you for letting us be a part of your celebration! 
        </p>
        <br/>

        <h1 style="text-align:center;font-size:45px;">Graduation Items</h1>

        <div class="gallery-container" style="margin:20px;">
            <div class="gallery" style="border-radius: 15px">
                    <a href="event.php">
                        <img src="img/flowers.jpg" alt="event1" width="600" height="400"
                            style="border-top-left-radius: 15px;border-top-right-radius: 15px">
                    </a>
                    <div class="desc">Flowers</div>
                </div>

                <div class="gallery" style="border-radius: 15px">
                    <a href="event.php">
                        <img src="img2/GradCap.png" alt="event2" width="600" height="300"
                            style="border-top-left-radius: 15px;border-top-right-radius: 15px">
                    </a>
                    <div class="desc">Graduation Caps</div>
                </div>

                <div class="gallery" style="border-radius: 15px">
                    <a href="event.php">
                        <img src="img2/GradTeddy.png" alt="event3" width="600" height="300"
                            style="border-top-left-radius: 15px;border-top-right-radius: 15px">
                    </a>
                    <div class="desc">Graduation Teddy</div>
                </div>

                <div class="gallery" style="border-radius: 15px">
                    <a href="event.php">
                        <img src="img2/MoneyBanquet.png" alt="event4" width="600" height="300"
                            style="border-top-left-radius: 15px;border-top-right-radius: 15px">
                    </a>
                    <div class="desc">Money Banquet</div>
                </div>

                <div class="gallery" style="border-radius: 15px">
                    <a href="event.php">
                        <img src="img2/PhotoPrinting.png" alt="event5" width="600" height="300"
                            style="border-top-left-radius: 15px;border-top-right-radius: 15px">
                    </a>
                    <div class="desc">Instant Photo Printing Service</div>
                </div>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>

    <!-- Footer -->
    <?php include 'footerUser.php'; ?>
    <!-- End Of Footer -->
 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>