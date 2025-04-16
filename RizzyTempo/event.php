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
        <title>Events</title>
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
                background: url(img/musicbg.jpg) no-repeat center;
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
        </style>
    </head>

    <body>
        <?php
        require_once 'helper.php';
        ?>

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
                                <a class="nav-link active mx-lg-2" style='color:white;' aria-current="page" href="event.php">Events</a>
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
            echo '<h1 style="margin: auto; text-align: center; padding-bottom: 20px;text-decoration:underline;">Active Events</h1>';
            echo '<table class="d-flex justify-content-center">';

            // Start looping through each row
            while ($row = $result->fetch_object()) {
                printf('
            <tr>
            <td style="margin-top: 10px;"><div class="custom-card"><div class="img-box"><img src="%s"></div>
            <div class="custom-content"><div class="content_text"><h2>%s</h2><p>%s</p></div>
            <a href="eventdets.php?eventName=%s">Read More</a></div></div></td>',
                        $row->eventBanner,
                        $row->eventName,
                        $row->headline,
                        $row->eventName
                    );

                // Fetch the next row for the second value in array
                $row = $result->fetch_object();

                // Check if there's another row available
                if ($row !== null) {
                    // Output the second item
                    printf('
                <td style="margin-top: 10px;"><div class="custom-card"><div class="img-box"><img src="%s"></div>
                <div class="custom-content"><div class="content_text"><h2>%s</h2><p>%s</p></div>
                <a href="eventdets.php?eventName=%s">Read More</a></div></div></td>',
                            $row->eventBanner,
                            $row->eventName,
                            $row->headline,
                            $row->eventName
                    );
                } else {
                    // If there are no more rows, close the row
                    echo "</tr>";
                }
            }

            // Close table and container
            echo '</table>';
            echo '</div>';

            // Free result set and close connection
            $result->free();
            $con->close();
        } else {
            // No records returned
        }
        ?>

        <!-- End of content -->

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

</html>