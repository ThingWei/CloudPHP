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
        <title>Delete Feedback Record</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="css/header.css" rel="stylesheet">
        <link href="css/footer.css" rel="stylesheet">
        <link href="css/form.css" rel="stylesheet">
        <link href="css/dragdrop.css" rel="stylesheet">
        <style>
            html{
                margin: 0;
                padding: 0;
            }

            body{
                background: url(img/musicbg.jpg) no-repeat center;
                background-size: cover;
                width: 100%;
                height: 100%;
            }

            .container {
                display: grid;
                grid-template-rows: auto 1fr auto;
                height: 100%;
            }
            .table-container {
                text-align: center;
                margin-top: 300px;
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

        <?php
        require_once 'helper.php';
        ?>

        <div class="container">
            <div class="table-container">
                <?php
                if ($_SERVER["REQUEST_METHOD"] == 'GET') {
                    // Retrieve rating from URL
                    $rating = isset($_GET['rating']) ? intval($_GET['rating']) : 0;

                    // Connect to the database
                    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                    if ($con->connect_error) {
                        die("Connection failed: " . $con->connect_error);
                    }

                    // Query to select feedback data by rating
                    $sql = "SELECT * FROM feedback WHERE rating = ?";
                    $stmt = $con->prepare($sql);
                    $stmt->bind_param("i", $rating);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($row = $result->fetch_object()) {
                        $rating = $row->rating;
                        $username = $row->username;
                        $email = $row->email;
                        $description = $row->description;

                        // Display confirmation message and form
                        printf('<h1>Delete Feedback</h1>
    <p>Are you sure you want to delete the following feedback?</p>
    <table border="1" cellpadding="10" cellspacing="0" class="table table-bordered">
        <tr>
            <td>Rating:</td>
            <td>%s</td>
        </tr>
        <tr> 
            <td>Username:</td>
            <td>%s</td>
        </tr> 
        <tr> 
            <td>Email:</td>
            <td>%s</td>
        </tr>
        <tr> 
            <td>Description:</td>
            <td>%s</td>
        </tr>
    </table><br/>
    <form method="POST" action="">
        <input type="hidden" name="hdRating" value="%s" />
        <input type="hidden" name="hdUsername" value="%s" />
        <input type="hidden" name="hdEmail" value="%s" />
        <input type="submit" value="Yes" name="btnYes" class="btn btn-danger" />
        <input type="button" value="Cancel" name="btnCancel" class="btn btn-secondary" onclick="location=\'adminFeedback.php\'" />
    </form>',
                                htmlspecialchars($rating), htmlspecialchars($username), htmlspecialchars($email), htmlspecialchars($description), htmlspecialchars($rating), htmlspecialchars($username), htmlspecialchars($email));
                    } else {
                        // Record not found
                        echo "<div class='alert alert-danger'>Database Error! Please try again! [<a href='adminFeedback.php'>Back to List Feedback</a>]</div>";
                    }

                    $result->free();
                    $stmt->close();
                    $con->close();
                } else {
                    // Retrieve rating and other fields from the form
                    $rating = intval(trim($_POST["hdRating"]));
                    $username = trim($_POST["hdUsername"]);
                    $email = trim($_POST["hdEmail"]);

                    // Connect to the database
                    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                    if ($con->connect_error) {
                        die("Connection failed: " . $con->connect_error);
                    }

                    // Query to delete feedback record by rating
                    $sql = "DELETE FROM feedback WHERE rating = ?";
                    $stmt = $con->prepare($sql);
                    $stmt->bind_param("i", $rating);
                    $stmt->execute();

                    // Check if the deletion was successful
                    if ($stmt->affected_rows > 0) {
                        // Record deleted
                        printf("<div class='alert alert-success'>Feedback with rating <b>%s</b> has been deleted! [<a href='adminFeedback.php'>Back to List Feedback</a>]</div>", htmlspecialchars($rating));
                    } else {
                        // Unable to delete
                        echo "<div class='alert alert-danger'>Unable to delete the record. [<a href='adminFeedback.php'>Back to List Feedback</a>]</div>";
                    }

                    $stmt->close();
                    $con->close();
                }
                ?>
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
