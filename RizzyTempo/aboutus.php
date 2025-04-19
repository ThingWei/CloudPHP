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
            background: url('img2/background.png') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
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
    </style>
</head>

<body>
    <!-- Navbar -->
    <?php include 'headerUser.php'; ?>
    <!-- End of Navbar -->
    
    <div class="background-container">
        <div class="container mt-5 pt-5">
            <div class="container-content">
                <h1 class="conth1"><b>About Us</b></h1>
                <img src="img2/aboutusimg.png" class="backimg" style="width: 40%; height: auto;">
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
                

                <h2 class="conth2">Join Us</h2>
                <p class="contp">Whether you're a graduate, a proud family member, or a friend looking to celebrate a milestone, 
                    TARUMT Graduation Services is here to support you every step of the way. 
                    Join our community of achievers and make the most of this once-in-a-lifetime moment. 
                    From essential gear to meaningful mementos, we offer everything you need to honor your journey and step confidently 
                    into the future. Let us help you celebrate success—your way.
                </p>
                <br/>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'footerUser.php'; ?>
    <!-- End Of Footer -->
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>