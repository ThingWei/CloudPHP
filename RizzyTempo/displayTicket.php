<?php
session_start();
require_once 'helper.php';

// Check if the user is logged in
if (!isset($_SESSION['user_email'])) {
    header('Location: index.php');
    exit();
}

$user_email = $_SESSION['user_email'];

?>

<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Purchased Tickets</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="css/header.css" rel="stylesheet">
        <link href="css/footer.css" rel="stylesheet">

        <style>
            .navbar {
                box-sizing: content-box;
            }

            body {
                background: url(img/musicbg.jpg) no-repeat center;
                background-size: cover;
                width: 100%;
            }

            .infotable {
                overflow: auto;
                white-space: wrap;
                margin-bottom: 80px;
            }

            .action {
                font-size: 10px;
                padding: 5px;
                border: none;
                background-color: #009970;
                color: #fff;
                border-radius: 15px;
                transition: 0.3s background-color;
            }

            .action:hover {
                background-color: #00b383;
            }
        </style>
    </head>
    <body>
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
                            &nbsp; TARUMT Graduation Service</h5>
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
                                <a class="nav-link active mx-lg-2" style="color: white;" aria-current="page"
                                   href="displayTicket.php">Purchased Tickets</a>
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

        <h1>&nbsp;</h1>
        <h1>&nbsp;</h1>
        <h1>&nbsp;</h1>   

        <?php
        //connect php to database
        //NOTE: the sequence of the parameter in myspli
        //must be followed
        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        //NOTE:
        //-> will only appear and used in database access
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }

        echo '<div class = "d-flex justify-content-center">';
        echo '<div style = "width: 80%; text-align: center;">';
        echo "<h1 style = 'padding-bottom: 15px;'>Purchased Ticket(s)</h1>";
        echo '<div class = "infotable">';
        echo '<table class = "table">';
        echo '<thead>';
        echo '<tr>';
        echo '<th scope = "col">#</th>';
        echo '<th scope = "col">Email</th>';
        echo '<th scope = "col">Event Name</th>';
        echo '<th scope = "col">Ticket Type</th>';
        echo '<th scope = "col">Price</th>';
        echo '<th scope = "col">Date</th>';
        echo '<th scope = "col">Time</th>';
        echo '<th scope = "col">Location</th>';
        echo '<th scope = "col" style = "text-align: center;">Action</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody class = "table-group-divider">';

        $sql = "SELECT * FROM receipt WHERE email = '$user_email'";
        $result = $con->query($sql);

        if ($result->num_rows > 0) {
            //record found
            //why while loop? while i can still access the record
            //we will retreive 
            //fetch_object() - take record 1 by 1 from $result 

            $no = 1;
            while ($row = $result->fetch_object()) {
                printf("
                                <tr>
                                <th scope='row'>%s</th>
                                <td>%s</td>
                                <td>%s</td>
                                <td>%s</td>
                                <td>RM %s</td>
                                <td>%s</td>
                                <td>%s</td>
                                <td>%s</td>
                                
                                <td class='text-center mt-3' style='width: 15px;'><a href='receipt.php?email=%s&eventTicketName=%s&ticketType=%s'><button class='action'>View Ticket</button></a></td>
                                
                                </tr>
                                    ", $no
                        , $row->email
                        , $row->eventName
                        , $row->ticketType
                        , $row->price
                        , $row->date
                        , $row->time
                        , $row->location
                        , $row->email
                        , $row->eventName
                        , $row->ticketType
                );
                $no++;
            }

            $result->free();
            $con->close();
        } else {
            echo '<tr><td colspan="9"> No Ticket Booked yet.</td></tr>';
        }
        ?>
    </tbody>
</table>
</div>
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
