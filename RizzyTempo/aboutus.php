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
    <title>About Us</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="css/header.css" rel="stylesheet">
    <link href="css/footer.css" rel="stylesheet">
    <link href="css/aboutus.css" rel="stylesheet">

    <style>
        body {
            background: url(img/musicbg.jpg) no-repeat center;
            background-size: cover;
            width: 100%;
        }
    </style>
</head>

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
                                <a class="nav-link active mx-lg-2" style='color:white;' href="aboutus.php">About Us</a>
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

    <div class="container mt-5 pt-5">
        <div class="container-content">
            <h1 class="conth1"><b>About Us</b></h1>
            <img src="img/background2.jpg" class="backimg">
            <p class="contp1"><b>Welcome to TARUMT Graduation Services !</b>
            </p>
            <h2 class="conth2">Who We Are?</h2>
            <p class="contp">At TARUMT University, graduation isn’t just a ceremony — it’s a celebration of achievement,
                 a milestone of perseverance, and a gateway to the future.
                At the heart of this proud moment lies TARUMT Graduation Services, 
                your trusted platform for all graduation-related needs.
Whether you're a graduate preparing for your big day or a family member supporting their journey, 
we are here to provide a smooth, meaningful, and memorable experience as you mark this important chapter.
</p>
            <h2 class="conth2">Our Mission:</h2>
            <p class="contp">We understand the emotional and symbolic value of graduation. Our mission is to provide every graduating student and their loved ones with a seamless, 
                accessible, and enriching platform to:
                Explore and purchase official graduation merchandise,
                Receive timely updates and support,
                Celebrate the transition from student life to the next great adventure.
                From ordering gowns and certificates to personalized memorabilia, TARUMT Graduation Services ensures everything you need is just a click away.


            </p>
            <h2 class="conth2"> What We Offer ?</h2>
            <p class="contp">
                <b>Graduation Essentials:</b> &nbsp;Caps, gowns, sashes, and official regalia — everything you need to walk the stage in pride. Easy browsing and ordering through our online platform.
            </p>
            <p class="contp"><b>Customized Merchandise:</b>&nbsp;
            Commemorative items including class rings, name-engraved plaques, graduation bears, 
            photo frames, and more — perfect for gifting or keepsakes.
            </p>
            <p class="contp"><b>Graduation Photos and Videos:</b>
                &nbsp;Capture the memories of your graduation day with professional photography and videography services. 
                We partner with skilled photographers to offer packages that include candid shots, family portraits, 
                and staged photos during the ceremony.
                We also provide high-quality video recordings of the event so you can relive the special moments whenever you want.
            </p>
            
            <img class="backimg2" src="img/joinus.jpg" alt="joinus">

            <h2 class="conth2">Join Us</h2>
            <p class="contp">Whether you're here to listen, learn, or
                lend
                your talents, Rizzy Tempo Music Society welcomes you. Together, let's embark on a symphonic adventure,
                creating unforgettable melodies and rhythms that resonate not just within the walls of Tarumt College,
                but
                beyond.
            </p>
            <p class="contp9"> Dive into the harmony
                of
                Rizzy Tempo Music Society—where your musical dreams become our shared reality. Let's make music that
                moves,
                inspires, and brings us together. Welcome to our community, where every note counts!
            </p>
        </div>
    </div>

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
                    <li><a href="event.php">Products</a></li>
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
        <p class="parafoot" style="text-align: center; font-size: 16px;">TARUMT Graduation Service @ 2025</p>
    </footer>
</div>
<!-- End Of Footer -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>