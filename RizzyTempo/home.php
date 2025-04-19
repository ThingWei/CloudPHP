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
    <title>Welcome to RT Music Society</title>
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
            background: url(img/musicbg.jpg) no-repeat center;
            background-size: cover;
            width: 100%;
            height: 100%;
        }

        .img {
            width: 20px;
            height: 20px;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
        <?php
        include 'headerUser.php';
        ?>
        <!-- End of Navbar -->

    <div class="background-image">
        <div class="overlay">
            <h1 style="font-size:50px;"><b>Welcome To TAR UMT Graduation Services</b></h1>
        </div>
    </div>

    <style>
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
            border: 2px solid black;
            float: left;
            width: 180px;
            margin-right: 15px;

        }

        div.gallery:hover {
            border: 1px solid white;
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
    <h1 style="text-align:center;font-size:45px;text-decoration:underline;margin-top:50px;">About Us<br></h1>
    <p style="font-size:20px;text-align:center;margin-top:20px;">
        At TAR UMT Graduation Services, we’re here to help you celebrate your big day.<br>
        We offer beautiful graduation flowers, gift bundles, and plush toys – perfect for marking this special moment. <br>
        Whether you're graduating or supporting someone who is, we’ve got just the thing to make it memorable.<br>
        Thank you for letting us be a part of your celebration! <br>
    <h1 style="text-align:center;text-decoration: underline;font-size:45px;">Graduation Items</h1>
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
                <img src="img/event2.jpg" alt="event2" width="600" height="300"
                    style="border-top-left-radius: 15px;border-top-right-radius: 15px">
            </a>
            <div class="desc">Graduation Caps</div>
        </div>

        <div class="gallery" style="border-radius: 15px">
            <a href="event.php">
                <img src="img/event3.jpg" alt="event3" width="600" height="300"
                    style="border-top-left-radius: 15px;border-top-right-radius: 15px">
            </a>
            <div class="desc">Graduation Gowns</div>
        </div>

        <div class="gallery" style="border-radius: 15px">
            <a href="event.php">
                <img src="img/event4.jpg" alt="event4" width="600" height="300"
                    style="border-top-left-radius: 15px;border-top-right-radius: 15px">
            </a>
            <div class="desc">Gifts</div>
        </div>

        <div class="gallery" style="border-radius: 15px">
            <a href="event.php">
                <img src="img/event5.jpg" alt="event5" width="600" height="300"
                    style="border-top-left-radius: 15px;border-top-right-radius: 15px">
            </a>
            <div class="desc">Photo Frames</div>
        </div>

       

    </div>


    </div>
    <div class="clearfix"></div>

    <!-- Footer -->
<?php
include 'footerUser.php';
?>
<!-- End Of Footer -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>