<?php
session_start();
require_once 'helper.php';

// Check if the user is logged in
if (!isset($_SESSION['admin_email'])) {
    header('Location: index.php');
    exit();
}

?>

<html>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Update User Details</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="css/header.css" rel="stylesheet">
        <link href="css/footer.css" rel="stylesheet">
        <link href="css/error.css" rel="stylesheet" type="text/css"/>
        <style>
            .navbar {
                box-sizing: content-box;
            }

            input,
            textarea {
                box-sizing: border-box;
            }

            body {
                background: url(img/musicbg.jpg) no-repeat center;
                background-size: cover;
                width: 100%;
            }

            .btn {
                background-color: #00b383;
                border: 0;
            }
            @media (max-width:815px){
                .card h2{
                    font-size: 22px;
                }
            }
        </style>
    </head>

    <body>
        <?php
        require_once 'helper.php'
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

        <div class='errorpage'>
            <?php
            //NOTE: for delete / update function ,use both GET and 
            //POST METHOD together 
            if ($_SERVER["REQUEST_METHOD"] == 'GET') {
                //get method - retrieve existing record to display
                if (isset($_GET['eventname'])) {
                    $eventName = trim($_GET['eventname']);
                } else {
                    $eventName = "";
                }

                //Step1:create connection btw system with DB
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                if ($con->connect_error) {
                    die("Connection failed: " . $con->connect_error);
                }

                $sql2 = "SELECT * FROM event WHERE eventName = '$eventName'";
                $result2 = $con->query($sql2);

                if ($row2 = $result2->fetch_object()) {
                    $eventname = $row2->eventName;
                    $headline = $row2->headline;
                    $description = $row2->description;
                    $eventBanner = $row2->eventBanner;
                    $dateOfEvent = $row2->dateOfEvent;
                    $time = $row2->time;
                    $location = $row2->location;

                    $eventtable = str_replace(' ', '_', $eventname);

                    $result = null;
                    if (isset($_GET['username'])) {
                        $userName = trim($_GET['username']);
                    } else {
                        $userName = "";
                    }

                    //clean id by removing special character/symbol
                    //,present sql injection attack
                    $username = $con->real_escape_string($userName);

                    //Step2:sql statement
                    $sql = "SELECT * FROM $eventtable WHERE username = '$username'";

                    $result = $con->query($sql);

                    if ($row = $result->fetch_object()) {
                        $username = $row->username;
                        $email = $row->email;
                        $gender = $row->gender;
                    }
                } else {
                    echo '<script>alert("Unable to make action, please try again later.");document.location="eventsAdmin.php";</script>';
                }
                //for safety purpose
                $result->free();
                $con->close();
                $result2->free();
            } else {
                $eventname = trim($_GET["eventname"]);
                $newname = trim($_POST["username"]);
                //validation
                $error["username"] = checkUpUsername($newname);

                //remove null value
                $error = array_filter($error);

                if (empty($error)) {
                    //GOOD ,proceed to insert record 
                    //post method - update the selected record 
                    $newname = trim($_POST["username"]);
                    $name = trim($_POST["hdName"]);

                    //Step 1:create connection with DB
                    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                    $eventtable = str_replace(' ', '_', $eventname);
                    $lowercasetable = strtolower($eventtable);

                    //Step 2:sql statement 
                    $sql = "UPDATE $lowercasetable SET username = ? WHERE username = '$name'";

                    //Step 3:process sql
                    $stmt = $con->prepare($sql);

                    $stmt->bind_param('s', $newname);

                    //Step 3.1:execute sql
                    $stmt->execute();

                    //NOTE: $stmt->affected_rows ,how many rows is 
                    //being changed, only application to CUD
                    //select function $con-num_rows ,tell you how many 
                    //row od record returned 
                    if ($stmt->affected_rows > 0) {
                        //record deleted
                        echo '<script>alert("User details UPDATED.");document.location="eventsJoined.php?eventName=' . urlencode($eventname) . '";</script>';
                    }
                    $stmt->close();
                    $con->close();
                } else {
                    //Not good ,display error msg
                    echo"<ul class='error'>";
                    foreach ($error as $value) {
                        echo "<li>$value</li>";
                    }
                    echo"</ul>";
                }
            }
            ?>
        </div>

        <!-- Form -->
        <div class="container" style="margin-bottom:25px">
            <div class="row">
                <div class="col-12 col-sn-8 col-nd-6 m-auto">
                    <div class="card">
                        <h2 class="d-flex justify-content-center" style="padding-top: 20px;">Edit Participant's Information
                        </h2>
                        <hr>
                        <div class="card-body">
                            <form action="" method="post">
                                <label for="username">Username:</label>
                                <input style="margin-bottom: 1rem !important;" type="text" name="username"
                                       class="form-control py-2" value="<?php echo isset($username) ? $username : ""; ?>">
                                <label for="gender">Email:</label>
                                <input style="margin-bottom: 1rem !important;" type="text" name="email"
                                       class="form-control py-2" value="<?php echo isset($email) ? $email : ""; ?>" disabled>
                                <label for="gender">Gender:</label>
                                <input style="margin-bottom: 1rem !important;" type="text" name="gender"
                                       class="form-control py-2" value="<?php echo isset($gender) ? $gender : ""; ?>" disabled>
                                <input type="hidden" name="hdName" value="<?php echo isset($username) ? $username : ""; ?>"/>

                                <div class="text-center mt-3">
                                    <br>
                                    <button type="submit" name="btnUpdate" class="btn btn-primary">Update</button>
                                    <button type="reset" name="btnReset" class="btn btn-primary"
                                            onclick='location = "eventsJoined.php?eventName=<?php echo $eventname ?>"'>Back</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Form  -->

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
        <script src="dragdrop.js"></script>
    </body>

</html>