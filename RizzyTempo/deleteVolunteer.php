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
        <title>Delete Volunteer Record</title>
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
                font-family: Arial, sans-serif;
            }

            body{
                background: url(img/musicbg.jpg) no-repeat center;
                background-size: cover;
                width: 100%;
                height: 100%;
            }

            .container {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100%;
            }
            .card {
                max-width: 500px;
                width: 100%;
                border: 1px solid #ced4da;
                border-radius: 10px;
                background-color: #fff;
                box-shadow: 0 0 10px rgba(0,0,0,0.1);
                padding: 20px;
            }
            h1 {
                margin-top: 0;
                color: #007bff;
            }
            p {
                margin-bottom: 20px;
            }
            table {
                width: 100%;
                border-collapse: collapse;
            }
            th, td {
                padding: 10px;
                border-bottom: 1px solid #dee2e6;
                text-align: left;
            }
            th {
                background-color: #007bff;
                color: #fff;
            }
            td {
                background-color: #f8f9fa;
            }
            .btn-group {
                display: flex;
                justify-content: space-between;
                width:20px;
            }
            .btn {
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                transition: background-color 0.3s;
                width:20px;
            }
            .btn-primary {
                background-color: #007bff;
                color: #fff;
            }
            .btn-primary:hover {
                background-color: #0056b3;
            }
            .btn-secondary {
                background-color: #6c757d;
                color: #fff;
            }
            .btn-secondary:hover {
                background-color: #5a6268;
            }
            .info {
                color: #28a745;
                font-weight: bold;
            }
            .error {
                color: #dc3545;
                font-weight: bold;
            }
        </style>

    </head>
    <body >

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

        <h1>&nbsp;</h1>
        <h1>&nbsp;</h1>
        <h1>&nbsp;</h1>

        <?php
        require_once 'helper.php';
        ?> 

        <div class="container">
            <div class="card mt-5">
                <div class="card-body">

                    <?php
                    if ($_SERVER["REQUEST_METHOD"] == 'GET') {
                        // Retrieve studentID from URL
                        $Name = isset($_GET['username']) ? strtoupper(trim($_GET['username'])) : "";

                        // Connect to the database
                        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                        $name = $con->real_escape_string($Name);

                        // Query to select volunteer data by userId
                        $sql = "SELECT * FROM volunteer WHERE username = '$name'";
                        $result = $con->query($sql);

                        if ($row = $result->fetch_object()) {
                            $username = $row->username;
                            $gender = $row->gender;
                            $email = $row->email;

                            // Get gender value from getGender() function
                            $genderValue = isset(getGender()[$gender]) ? getGender()[$gender] : "";

                            // Display confirmation message and form
                            printf('<h1>Delete Volunteer</h1>
        
        <p>Are You Sure Want To Delete the Following Volunteer?</p>
        <form method="POST" action="">
        <table border="1" cellpadding="10" cellspacing="0">
        
            <tr> 
                <td>Username:&nbsp</td>
                <td>%s</td>
            </tr> 
                        
            <tr> 
                <td>Gender:</td>
                <td>%s</td>
            </tr>
                        
            <tr> 
                <td>Email:</td>
                <td>%s</td>
            </tr>
        </table><br/>
       
            <input type="hidden" name="hdName" value="%s" />
            <input type="hidden" name="hdEmail" value="%s" />
            <input type="submit" value="Yes" name="btnYes" style="margin-right:5px;" />
            <input type="button" value="Cancel" name="btnCancel" 
                   onclick="location=\'listVolunteer.php\'"/>
        </form>',
                                    $username, $genderValue, $email, $username, $email);
                        } else {
                            // Record not found
                            echo "<div class='error'>Database Error! Please try again! [<a href='listVolunteer.php'>Back to List Volunteer</a>]</div>";
                        }

                        $result->free();
                        $con->close();
                    } else {
                        // Retrieve userId and other fields from the form
                        $name = trim($_POST["hdName"]);
                        $email = trim($_POST["hdEmail"]);

                        // Connect to the database
                        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                        // Query to delete volunteer record by userId
                        $sql = "DELETE FROM volunteer WHERE username = ?";

                        // Prepare and execute the delete statement
                        $stmt = $con->prepare($sql);
                        $stmt->bind_param("s", $name);
                        $stmt->execute();

                        // Check if the deletion was successful
                        if ($stmt->affected_rows > 0) {
                            // Record deleted
                            printf("<div class='info'>User <b>%s</b> Has Been Deleted! [<a href='listVolunteer.php'>Back to List Volunteer</a>]</div>", $name);
                        } else {
                            // Unable to delete
                            echo "<div class='error'>Unable to Delete the Record. [<a href='listVolunteer.php'>Back to List Volunteer</a>]</div>";
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        
        <h1>&nbsp;</h1>
        <h1>&nbsp;</h1>
        
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
    </body>

</html>
