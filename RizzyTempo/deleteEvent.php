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
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Delete Event</title>
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

            .createbtn {
                background-color: #009970;
                border: none;
                border-radius: 16px;
                padding: 5px;
                color: white;
                transition: 0.3s background-color;
            }

            .createbtn:hover {
                background-color: #00b383;
            }
            .return {
                border: 0;
                width: 60px;
                height: 60px;
                background: transparent;
                margin-left: 20px;
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
                                <a class="nav-link mx-lg-2" href="faqAdmin.php">FAQ</a>
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

        <p class="gap" style="height: 120px;">&nbsp;</p>

        <!-- Content -->
        <a href="eventsAdmin.php"><button class="return"><img class="return" src="img/goback.png"></button></a>
        <?php
        //connect php to database
        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }

        $message = 'return confirm(&quot;Are you sure you want to delete this event?&quot;)';
        
        //sql statement
        $sql = "SELECT * FROM event";

        //ask coonection to run sql query 
        $result = $con->query($sql);

        if ($result->num_rows > 0) {
            // Record found
            echo '<div id="container" style="padding-top: 0;">';
            echo '<h1 style="margin: auto; text-align: center; padding-bottom: 20px;text-decoration:underline;">Active Events</h1>';
            echo '<table class="d-flex justify-content-center">';

            // Start looping through each row
            while ($row = $result->fetch_object()) {
                $eventname = $row->eventName;
                $headline = $row->headline;
                $description = $row->description;
                $banner = $row->eventBanner;
                printf('
            <tr>
            <td style="margin-top: 10px;"><div class="custom-card"><div class="img-box"><img src="%s"></div>
            <div class="custom-content"><div class="content_text"><h2>%s</h2></div>
            <form method="post">
            <input type="hidden" name="deleteEvent" value="%s">
            <button type="submit" name="btnDelete" class="createbtn" style="margin-top:15px" onclick="%s">Delete Event</button></form></div></div></td>',
                        $banner,
                        $eventname,
                        $eventname,
                        $message
                );

                // Fetch the next row for the second value in array
                $row = $result->fetch_object();

                // Check if there's another row available
                if ($row !== null) {
                    $eventname = $row->eventName;
                    $headline = $row->headline;
                    $description = $row->description;
                    $banner = $row->eventBanner;
                    // Output the second item
                    printf('
            <td style="margin-top: 10px;"><div class="custom-card"><div class="img-box"><img src="%s"></div>
            <div class="custom-content"><div class="content_text"><h2>%s</h2></div>
            <form method="post">
            <input type="hidden" name="deleteEvent" value="%s">
            <button type="submit" name="btnDelete" class="createbtn" style="margin-top:15px" onclick="%s">Delete Event</button></form></div></div></td>',
                            $banner,
                            $eventname,
                            $eventname,
                            $message
                    );
                } else {
                    // If there are no more rows, close the row
                    echo "</tr>";
                }
            }

            echo '</table>';
            echo '</div>';

            // Free result set and close connection
            $result->free();
            $con->close();
        } else {
            // No records returned
        }

        //NOTE: for delete / update function ,use both GET and 
        //POST METHOD together 
        if ($_SERVER["REQUEST_METHOD"] == 'POST') {

            //post method - delete the selected record 
            //retrieve from URL
            $eventName = trim($_POST["deleteEvent"]);

            //Step 1:create connection with DB
            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            //Step 2:sql statement 
            $sql = "DELETE FROM event WHERE eventName = ?";

            //Step 3:process sql
            $stmt = $con->prepare($sql);

            $stmt->bind_param('s', $eventName);

            //Step 3.1:execute sql
            $stmt->execute();

            //NOTE: $stmt->affected_rows ,how many rows is 
            //being changed, only application to CUD
            //select function $con-num_rows ,tell you how many 
            //row od record returned 
            if ($stmt->affected_rows > 0) {
                //record deleted

                echo "<script>alert('Event has been DELETED.');document.location='eventsAdmin.php';</script>";
            } else {
                echo "<script>alert('Deletion failed, Please try again later.');document.location='eventsAdmin.php';</script>";
            }
            $stmt->close();
            $con->close();
        }
        ?>
        <!-- End of Content -->

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
        <script>
            // JavaScript function to display confirmation dialog
    function confirmDelete() {
        return confirm("This Event will be deleted.\nAre you sure?");
    }

    // Attach the confirmation function to the form submission event
    document.getElementById("deleteForm").addEventListener("submit", function(event) {
        if (!confirmDelete()) {
            // If not confirmed, prevent the form submission
            event.preventDefault();
        }
    });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    </body>

</html>