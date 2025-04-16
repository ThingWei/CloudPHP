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
<html>
    <head>
        <meta charset="UTF-8">
        <title>Insert Ticket Details</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="css/header.css" rel="stylesheet">
        <link href="css/footer.css" rel="stylesheet">

        <style>
            body {
                background: url(img/musicbg.jpg) no-repeat center;
                background-size: cover;
                width: 100%;
            }

            .container {
                margin: auto;
                width: 500px;
                margin-top: 50px;
                padding:20px;
                border-radius:10px;
                box-shadow:0 0 10px rgba(0,0,0,0.1);
                margin-bottom:60px;
                font-family:Arial,sans-serif;
                background-color:#fff;
            }

            table {
                margin: auto;
                border: 1px solid #ccc;
                border-radius: 20px;

            }

            .button-container {
                text-align: left;
            }

            input[type="text"],
            input[type="submit"] {
                width: 100%;
                padding: 10px;
                margin-bottom: 30px;
                border: 1px solid #ccc;
                border-radius: 0; /* Square border radius */
            }

            input[type="submit"] {
                background-color: #007bff;
                color: white;
                border: none;
                cursor: pointer;
            }

            input[type="submit"]:hover {
                background-color: #0056b3;
            }
            .error, .info
            {
                padding: 5px;
                margin: 5px;
                font-size: 0.9em;
                list-style-position: inside;
            }

            .error
            {
                border: 2px solid #FBC2C4;
                background-color: #FBE3E4;
                color: #8A1F11;
            }
            .success-message {
                color: blue;
                font-size: 25px;

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
                            &nbsp; RT Music Society</h5>
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
                                <a class="nav-link active mx-lg-2" style='color:white;' href="adminTicket.php">Insert Ticket</a>
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

        <h1 style="text-align:center;margin-top:150px;">Insert Ticket Detail</h1>
        <div class="container">
            <form action="" method="POST">

                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    // Validate data input
                    $eventTicketName = trim($_POST['txtEventName']);
                    $ticketType = trim($_POST['txtTicketType']);
                    $ticketPrice = trim($_POST['txtTicketPrice']);

                    // Validate form inputs
                    $error["eventTicketName"] = checkEventTicketName($eventTicketName);
                    $error["ticketType"] = checkTicketType($ticketType);
                    $error["ticketPrice"] = checkTicketPrice($ticketPrice);

                    $errors = array_filter($error);

                    if (empty($errors)) {
                        // If no errors, insert ticket data into the database
                        $con2 = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                        if ($con2->connect_error) {
                            die("Connection failed: " . $con2->connect_error);
                        }

                        $found = 0;
                        $sql2 = "SELECT * FROM event";
                        $result2 = $con2->query($sql2);
                        while ($row = $result2->fetch_object()) {
                            $eventName = $row->eventName;
                            $headline = $row->headline;
                            $description = $row->description;
                            $eventBanner = $row->eventBanner;
                            $dateOfEvent = $row->dateOfEvent;
                            $time = $row->time;
                            $location = $row->location;

                            if (strcmp($eventName, $eventTicketName) == 0) {
                                $sql2 = "INSERT INTO ticket (eventTicketName, ticketType, price) VALUES (?, ?, ?)";

                                $stmt = $con2->prepare($sql2);
                                $stmt->bind_param("sss", $eventTicketName, $ticketType, $ticketPrice);

                                $stmt->execute();

                                if ($stmt->affected_rows > 0) {
                                    echo "";
                                } else {
                                    echo "Error: " . $stmt->error;
                                }

                                $found = 1;
                                echo '<script>alert("Ticket Inserted!");document.location.href="adminTicket.php"</script>';
                                $stmt->close();
                            }
                        }

                        if ($found < 1) {
                            echo '<script>alert("No event found for this ticket.");document.location.href="adminTicket.php"</script>';
                        }

                        $result2->free();
                        $con2->close();
                    } else {
                        // If there are errors, display them
                        echo "<ul class='error'>";
                        foreach ($errors as $value) {
                            echo "<li>$value</li>";
                        }
                        echo "</ul>";
                    }
                }
                ?>

                <label for="txtEventName">Event Name:</label><br/>
                <input type="text" name="txtEventName" value="" maxlength="50" placeholder="Happy Jazz Day" /><br/>
                <label for="tcktype">Ticket Type:</label><br/>
                <input type="text" name="txtTicketType" value="" placeholder="XXXXX Ticket" /><br/>
                <label for="tcktPrice">Ticket Price</label><br/>
                <input type="text" name="txtTicketPrice" value="" placeholder="RMXXX"/>
                <br/>
                <br/>
                <input type="submit" value="Submit" name="btnSubmit" /><br/>
            </form>
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
