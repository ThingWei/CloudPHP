<?php
session_start();
require_once 'helper.php';

// Check if the user is logged in
if (!isset($_SESSION['admin_email'])) {
    header('Location: index.php');
    exit();
}

?>

<?php
require_once 'helper.php';
?>

<html>

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Event Participants</title>

        <!-- Bootstrap Css -->
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
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            if (isset($_GET['eventName'])) {
                $eventName = trim($_GET['eventName']);

                //connect php to database
                //NOTE: the sequence of the parameter in myspli
                //must be followed
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                //NOTE:
                //-> will only appear and used in database access
                if ($con->connect_error) {
                    die("Connection failed: " . $con->connect_error);
                }

                $eventname = $con->real_escape_string($eventName);

                $sql2 = "SELECT * FROM event WHERE eventName = '$eventname'";
                $result2 = $con->query($sql2);

                if ($row2 = $result2->fetch_object()) {
                    $eventname = $row2->eventName;
                    $headline = $row2->headline;
                    $description = $row2->description;
                    $eventBanner = $row2->eventBanner;
                    $dateOfEvent = $row2->dateOfEvent;
                    $time = $row2->time;
                    $location = $row2->location;

                    echo '<div class = "d-flex justify-content-center">';
                    echo '<div style = "width: 60%; text-align: center;">';
                    echo "<h1 style = 'padding-bottom: 15px;'>$eventname</h1>";
                    echo '<div class = "infotable">';
                    echo '<table class = "table">';
                    echo '<thead>';
                    echo '<tr>';
                    echo '<th scope = "col" style = "width: 10%;">#</th>';
                    echo '<th scope = "col" style = "width: 25%;">Username</th>';
                    echo '<th scope = "col" style = "width: 30%;">Email</th>';
                    echo '<th scope = "col" style = "text-align:center">Gender</th>';
                    echo '<th scope = "col" colspan = "2" style = "text-align: center;">Action</th>';
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody class = "table-group-divider">';

                    $eventtable = str_replace(' ', '_', $eventname);
                    //sql statement
                    $sql = "SELECT * FROM $eventtable";

                    //ask coonection to run sql query 
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
                                <td style='text-align:center;'>%s</td>
                                
                                <td class='text-center mt-3' style='width: 15px;'><a href='updateUser.php?eventname=%s&username=%s'><button class='action'>Update</button></a></td>
                                <td class='text-center mt-3' style='width: 15px;'><a href='deleteUser.php?eventname=%s&username=%s'><button class='action'>Delete</button></a></td>
                                                                
                                </tr>
                                    ", $no
                                    , $row->username
                                    , $row->email
                                    , $row->gender
                                    , $eventname
                                    , $row->username
                                    , $eventname
                                    , $row->username
                            );
                            $no++;
                        }

                        $result->free();
                        $con->close();
                        $result2->free();
                    } else {
                        echo '<tr><td colspan="5" style="text-align:center"> No Participant(s) yet.</td></tr>';
                    }
                }
            }
        }
        ?>
    </tbody>
</table>
</div>
</div>
</div>

<!-- End Of Content -->

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

<!-- Bootstrap Js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
crossorigin="anonymous"></script>

</body>

</html>