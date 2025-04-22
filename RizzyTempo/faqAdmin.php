<?php
session_start();
require_once 'helper.php';

// Check if the user is logged in
if (!isset($_SESSION['admin_email'])) {
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
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Frequently Asked Question</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="css/faq.css" rel="stylesheet" type="text/css" />
        <link href="css/header.css" rel="stylesheet" type="text/css" />
        <link href="css/footer.css" rel="stylesheet" type="text/css" />

        <style>
            body {
                background: url(img/musicbg.jpg) no-repeat center;
                background-size: cover;
                width: 100%;
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
    </head>

    <body>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg fixed-top">
            <div class="container-fluid">
                <a class="navbar-brand me-auto" href="homeAdmin.php"><img class="mslogo" src="img/music.png"></a>
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                     aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasNavbarLabel"><img class="mslogo" src="img/music.png">
                            &nbsp; TARUMT Graduation Service</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
                            <li class="nav-item">
                                <a class="nav-link mx-lg-2" aria-current="page"
                                   href="homeAdmin.php">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mx-lg-2" href="eventsAdmin.php">Events</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mx-lg-2" href="createEvent.php">Create Event</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mx-lg-2" href="deleteTicket.php">Ticket List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mx-lg-2" href="adminTicket.php">Insert Ticket</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mx-lg-2" href="list-payment.php">Payment List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mx-lg-2" href="list-login.php">User List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mx-lg-2" href="listVolunteer.php">Volunteer List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mx-lg-2" href="adminFeedback.php">Feedback</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mx-lg-2" href="aboutUsAdmin.php">About Us</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active mx-lg-2" style='color:white;' href="faqAdmin.php">FAQ</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <a href="profileAdmin.php"><img class="profilepic" src="img/adminprofile.png"></a>
                <button class="navbar-toggler pe-0" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>
        <!-- End of Navbar -->

        <p class="gap">&nbsp;</p>
        <p class="gap">&nbsp;</p>
        <p class="gap">&nbsp;</p>

        <div class="container">
            <div class="header-text-box">
                <img src="https://www.smtusa.com/uploads/faqs.jpg" alt="alt"
                     style="width: 40%;margin-top: 50px;margin-left: 35%;margin-bottom: 70px;border-radius: 100px;" />
                <h1 style="margin-left: 32%;">About Frequently Asked Question</h1>
            </div>

            <section>
                <h2
                    style="margin-left: 35%;margin-top: 100px;margin-bottom: 20px; font-family: Times New Roman; font-weight: bold; font-size: 50px; color: #00566e">
                    Most for people ask</h2>
                <div class="grid-3-cols">
                    <div>
                        <p class="features-title"><strong>About Events</strong></p>
                        <p class="features-text">
                        <details>
                            <summary>What types of events does the society organize?</summary>
                            <p style=" font-size: 15px;color: #009987;">We will hosting all type of events.</p>
                        </details>
                        <details>
                            <summary>Are events open to non-members</summary>
                            <p style=" font-size: 15px;color: #009987;">Sometime we will open for non-members but just a few time.</p>
                        </details>
                        <details>
                            <summary>Can members suggest or organize events?</summary>
                            <p style=" font-size: 15px;color: #009987;">Sure.Members can request to related department and wait for
                                reply.</p>
                        </details>
                        </p>
                    </div>

                    <div>
                        <p class="features-title">
                            <strong>Instruments and Skill Levels</strong>
                        </p>
                        <p class="features-text">
                        <details>
                            <summary>What if I'm a beginner?</summary>
                            <p style=" font-size: 15px;color: #009987;">It is doesn't matter for that. </p>
                        </details>
                        <details>
                            <summary>Are there opportunities for lesson or workshops?</summary>
                            <p style=" font-size: 15px;color: #009987;">We have free lessons that is one hour for first time to let
                                people try.</p>
                        </details>
                        <details>
                            <summary>Is there equipment available use?</summary>
                            <p style=" font-size: 15px;color: #009987;">Yes, we have prepare some for spare.</p>
                        </details>
                        </p>
                    </div>

                    <div>
                        <p class="features-title">
                            <strong>Social and Networking</strong>
                        </p>
                        <p class="features-text">
                        <details>
                            <summary>Does the society organize social events?</summary>
                            <p style=" font-size: 15px;color: #009987;">Yes, something will have some event will be hold.</p>
                        </details>
                        <details>
                            <summary>Are there networking opportunities for members?</summary>
                            <p style=" font-size: 15px;color: #009987;">Don't worry, we also prepare some activity.</p>
                        </details>
                        </p>
                    </div>
                </div>
            </section>

            <section class="testimonial-section">
                <div class="grid-3-cols" style="margin-right: 20%;">

                    <div class="testimonial-box">
                        <h2>Is have other Frequently Asked Question can <a href="#">contest us</a></h2>
                    </div>
                </div>
            </section>
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
                        <h3>Navigation<div class="underline"><span class="uline"></span></div></h3>
                        <ul class="footnav" style='padding:0'>
                            <li><a href="homeAdmin.php">Dashboard</a></li>
                            <li><a href="eventsAdmin.php">Events</a></li>
                            <li><a href="createEvent.php">Create Event</a></li>
                            <li><a href="deleteTicket.php">Ticket List</a></li>
                            <li><a href="adminTicket.php">Insert Ticket</a></li>
                            <li><a href="list-payment.php">Payment List</a></li>
                            <li><a href="list-user.php">User List</a></li>
                            <li><a href="listVolunteer.php">Volunteer List</a></li>
                            <li><a href="adminFeedback.php">Feedback</a></li>
                            <li><a href="aboutUsAdmin.php">About Us</a></li>
                            <li><a href="faqAdmin.php">FAQ</a></li>
                        </ul>
                    </div>
                    <div class="colfoot">
                        <h3 style="font-size: 12px;" class="fblow">Find Us Thru Our Social Media Below!<div
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

</html>