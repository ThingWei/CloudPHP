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
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Welcome to RT Music Society</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined"
              rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="css/adminhome.css" rel="stylesheet" type="text/css"/>
        <link href="css/header.css" rel="stylesheet" type="text/css"/>
        <link href="css/footer.css" rel="stylesheet" type="text/css"/>
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
        <!-- Material Icons -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

        <!-- Custom CSS -->
    </head>
    <body>

        <?php
        require_once 'helper.php';
        //connect php to database
        //NOTE: the sequence of the parameter in myspli
        //must be followed
        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        //NOTE:
        //-> will only appear and used in database access
        //=> used in associative array
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }

        //sql statement
        //SELECT * FROM Student ORDER BY StudentName ASC;
        $sql = "SELECT * FROM user";

        //ask coonection to run sql query 
        $result = $con->query($sql);

        if ($result->num_rows > 0) {
            //record found
            //why while loop? while i can still access the record
            //we will retreive 
            //fetch_object() - take record 1 by 1 from $result 

            $totalNumUser = $result->num_rows;

            $result->free();
            $con->close();
        } else {
            //no record return
        }
        //connect php to database
        //NOTE: the sequence of the parameter in myspli
        //must be followed
        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        //NOTE:
        //-> will only appear and used in database access
        //=> used in associative array
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }

        //sql statement
        //SELECT * FROM Student ORDER BY StudentName ASC;
        $sql = "SELECT * FROM event";

        //ask coonection to run sql query 
        $result = $con->query($sql);

        if ($result->num_rows > 0) {
            //record found
            //why while loop? while i can still access the record
            //we will retreive 
            //fetch_object() - take record 1 by 1 from $result 

            $totalNumEvent = $result->num_rows;

            $result->free();
            $con->close();
        } else {
            //no record return
        }
        
        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        //NOTE:
        //-> will only appear and used in database access
        //=> used in associative array
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }

        //sql statement
        //SELECT * FROM Student ORDER BY StudentName ASC;
        $sql = "SELECT * FROM payment";

        //ask coonection to run sql query 
        $result = $con->query($sql);

        if ($result->num_rows > 0) {
            //record found
            //why while loop? while i can still access the record
            //we will retreive 
            //fetch_object() - take record 1 by 1 from $result 

            $totalNumPay = $result->num_rows;

            $result->free();
            $con->close();
        } else {
            //no record return
        }
        ?>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg fixed-top">
            <div class="container-fluid">
                <a class="navbar-brand me-auto" href="homeAdmin.php"><img class="mslogo" src="img/music.png"></a>
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
                                <a class="nav-link active mx-lg-2" aria-current="page" style="color: white;"
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

        <h1>&nbsp;</h1>
        <p>&nbsp;</p>
        <p>&nbsp;</p>

        <div class="container" style='display:block;margin-left: auto;margin-right: auto;'>

            <!-- Main -->
            <main class="main-container">
                <div class="main-title">
                    <p class="font-weight-bold" style='text-align:center'>DASHBOARD</p>
                </div>

                <div class="main-cards">

                    <div class="card">
                        <div class="card-inner">
                            <p class="text-primary">Number of Member(s)</p>
                            <span class="material-icons-outlined text-blue">assignment_ind</span>
                        </div>
                        <span class="text-primary font-weight-bold"><?php echo isset($totalNumUser) ? $totalNumUser : ""; ?></span>
                    </div>

                    <div class="card">
                        <div class="card-inner">
                            <p class="text-primary">Number of Active Event(s)</p>
                            <span class="material-icons-outlined text-red">event</span>
                        </div>
                        <span class="text-primary font-weight-bold"><?php echo isset($totalNumEvent) ? $totalNumEvent : ""; ?></span>
                    </div>
                    
                    <div class="card" style='border-left: 7px solid #458B74'>
                        <div class="card-inner">
                            <p class="text-primary">Number of Ticket(s) Sold</p>
                            <span class="material-icons-outlined text-green">payment</span>
                        </div>
                        <span class="text-primary font-weight-bold"><?php echo isset($totalNumPay) ? $totalNumPay : ""; ?></span>
                    </div>

                </div>
            </main>
            <!-- End Main -->

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
        
        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

        <!-- ApexCharts -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.3/apexcharts.min.js"></script>

    </body>
</html>