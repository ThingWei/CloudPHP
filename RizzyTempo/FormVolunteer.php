<?php
session_start();
require_once 'helper.php';

// Check if the user is logged in
if (!isset($_SESSION['user_email'])) {
    header('Location: index.php');
    exit();
}
?>

<html>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Volunteer Form</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="css/header.css" rel="stylesheet">
        <link href="css/footer.css" rel="stylesheet">
        <link href="css/error.css" rel="stylesheet" type="text/css"/>
        <style>
            .navbar {
                box-sizing: content-box;
            }

            input {
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
            .error{

            }
        </style>
    </head>
    <body>

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

        <?php
        require_once 'helper.php';

        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        $useremail = $_SESSION['user_email'];

        $sql = "SELECT * FROM user WHERE email = '$useremail'";
        $result = $con->query($sql);
        if ($row = $result->fetch_object()) {
            $uname = $row->username;
            $uemail = $row->email;
            $ugender = $row->gender;
        }

        $result->free();
        ?>

        <!-- HTML Form -->
        <form action="" method="POST">
            <div class="container mt-5 pt-5">
                <div class="row">
                    <div class="col-12 col-sn-8 col-nd-6 m-auto">
                        <div class="card" style="margin-top:50px;margin-bottom:50px;">
                            <!-- Form title -->
                            <h2 class="d-flex justify-content-center" style="padding-top: 20px;">Volunteer Form</h2>
                            <hr>
                            <div class="card-body">
                                <?php
// Handle form submission
                                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                    // Retrieve other fields from the form
                                    $name = trim($_POST["txtUsername"]);
                                    $gender = isset($_POST["rbGender"]) ? $_POST["rbGender"] : null;
                                    $email = trim($_POST["txtEmail"]);

                                    // Validate form inputs
                                    $error["name"] = checkUsername($name);
                                    $error["gender"] = checkGender($gender);
                                    $error["email"] = checksEmail($email);

                                    // Remove empty error messages
                                    $error = array_filter($error);

                                    if (empty($error)) {
                                        // If validation successful, process the form
                                        if (isMember($name)) {
                                            if (checkUserIdExistsInVolunteer($name)) {
                                                echo "<div class='message' style=\"color:blue;font-size:20px;\">You Have Already Submitted The Form.</div>";
                                            } else {
                                                insertVolunteerData($name, $gender, $email);
                                                echo "<div class='success-message' style=\"color:blue;font-size:20px;\">Submit Successful</br></div>";
                                            }
                                        } else {
                                            echo "<div class='error-message' style=\"color:blue;font-size:20px;\">You are not a member of Rizzy Tempo Music Society and cannot submit the form.</div>";
                                        }
                                    } else {
                                        // Display error messages
                                        echo "<ul class='error'>";
                                        foreach ($error as $value) {
                                            echo "<li>$value</li>";
                                        }
                                        echo "</ul>";
                                    }
                                }
                                ?>  
                                <!-- Form fields -->
                                <div class="form-group">

                                    <h3 style='text-align:center'>Send us an application and we will contact you for an interview via email soon!<br>
                                        <b style='color:red'>**Make sure the applicant is a user of our society**</b></h3>

                                    <label for="username">Username:</label>
                                    <input style="margin-bottom: 1rem !important;" type="text" name="txtUsername" value="<?php echo $uname ?>"
                                           maxlength="30" class="form-control py-2" placeholder="Tan Ah Gaw">

                                    <br>
                                    <label for="gender">Gender:</label>
                                    &nbsp;
                                    <input style="margin-bottom: 1rem !important;" type="radio" name="rbGender" value="F" /> Female♀️
                                    &nbsp;
                                    <input style="margin-bottom: 1rem !important;" type="radio" name="rbGender" value="M" /> Male♂️
                                    <br><br>

                                    <label for="email">Email:</label>
                                    <input style="margin-bottom: 1rem !important;" type="text" name="txtEmail" value="<?php echo $uemail ?>"
                                           maxlength="30" class="form-control py-2" placeholder="abc@email.com">
                                    <br>
                                    <input style="margin-bottom: 1rem !important;" type="checkbox" name="TnC">
                                    <label for="term">I've read through and agreed to the <a href="term.php">Terms and Conditions</a>.</label>

                                </div>
                                <!-- Form submission buttons -->
                                <div class="text-center mt-3">
                                    <br>
                                    <input style="border: none;" class="btn btn-primary" type="submit" name="btnSubmit"/>
                                    <input type="reset" name="btnReset" class="btn btn-primary" onclick='location = "FormVolunteer.php"'/>
                                    <input type="button" name="btnBack" class="btn btn-primary" value="Back" onclick='location = "event.php"'/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

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
        <script src="dragdrop.js"></script>
    </body>

</html>                                                                                                                                