<?php
session_start();
require_once 'helper.php';

// Check if the user is logged in
if (!isset($_SESSION['user_email'])) {
    header('Location: index.php');
    exit();
}

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

<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Feedback</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="css/header.css" rel="stylesheet">
        <link href="css/footer.css" rel="stylesheet">
        <link href="css/feedback.css" rel="stylesheet">
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

            .info
            {
                border: 2px solid #92CAE4;
                background-color: #D5EDF8;
                color: #205791;
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
                            &nbsp; RT Music Society</h5>
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
                                <a class="nav-link active mx-lg-2" style='color:white' href="feedback.php">Feedback</a>
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
        ?>
        <p class="gap">&nbsp;</p>
        <p class="gap">&nbsp;</p>


        <form action="" method="POST">
            <div class="feedback-container" style="width:700px;height:900px;background-color:white;margin:auto;">
                <h1>Please Give Your Feedback</h1>
                <p><b>Your Feedback Is Important For Us</b></p>

                <?php
//handle form submission
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    //retrieve other fields from the form
                    $rating = isset($_POST["rate"]) ? $_POST["rate"] : null;
                    $name = trim($_POST["txtUsername"]);
                    $email = trim($_POST["txtEmail"]);
                    $description = trim($_POST["txtDescription"]);

                    //Validation form inputs
                    $error["rate"] = checkRating($rating);
                    $error["username"] = checkUsername($name);
                    $error["email"] = checkingEmail($email);
                    $error["description"] = checkDescription($description);

                    //remove empty error messages
                    $error = array_filter($error);

                    if (empty($error)) {
                        //if validation successful , process the form
                        insertFeedbackData($rating, $name, $email, $description);
                        echo "<div class='success-message' style=\"color:blue;\">Feedback Submited Successfully</br></div>";
                    } else {
                        //display error messages 
                        echo "<ul class='error'>";
                        foreach ($error as $value) {
                            echo "<li>$value</li>";
                        }
                        echo "</ul>";
                    }
                }
                ?>

                <!-- form field  -->
                <div class="center">
                    <div class="stars">
                        <input type="radio" id="five" name="rate" value="5">
                        <label for="five"></label>
                        <input type="radio" id="four" name="rate" value="4">
                        <label for="four"></label>
                        <input type="radio" id="three" name="rate" value="3">
                        <label for="three"></label>
                        <input type="radio" id="two" name="rate" value="2">
                        <label for="two"></label>
                        <input type="radio" id="one" name="rate" value="1">
                        <label for="one"></label>
                    </div>
                </div>
                <div class="info-field">
                    <div class="name">
                        <label for="name">Username</label>
                        <input type="text" id="username" name="txtUsername" value="<?php echo $uname ?>" maxlength="50" placeholder="Tan Ah Gaw" />
                    </div>
                    <div class="email">
                        <label for="email">Email</label>
                        <input type="text" id="emailaddress" name="txtEmail" value="<?php echo $uemail ?>" maxlength="50" placeholder="tanahgaw@example.com"  />
                        <br/>
                    </div>
                    <div>
                        <label for="review" style= "position:relative;font-weight:bold;
                               font-size:1rem;margin-bottom:0.5rem;">
                            Please Give Your Review</label>
                        <textarea id="textarea" rows="6" cols="20" name="txtDescription" maxlength="300"
                                  placeholder="Rizzy Tempo Music Society website are user-friendly to use..."></textarea>
                        <br/>
                    </div>
                    <div class="condition">
                        <input type="radio" id="accept" value="accept" method="POST">
                        <label for="accept">I accept the <a href="condition.php">terms and conditions</a></label><br>
                    </div>
                    <div style="display: flex; justify-content: center;">
                        <input type="submit" name="btnSubmit" style="padding:10px 20px;font-size:20px;background-color:#1c84ff;color:#fff;
                               border:none;border-radius:5px;cursor:pointer;width:200px;margin-bottom:50px;
                               margin-top:30px;box-shadow: 2.5px 3.5px 4px #828282;margin-right:10px;"/>
                        <input type="reset" name="btnReset" onclick="location = 'feedback.php'"
                               style="padding:10px 20px;font-size:20px;background-color:#1c84ff;color:#fff;
                               border:none;border-radius:5px;cursor:pointer;width:200px;margin-bottom:50px;
                               margin-top:30px;box-shadow: 2.5px 3.5px 4px #828282; margin-left: 30px;"/>

                    </div>


                </div>
            </div>
        </form>
        <p class="gap">&nbsp;</p>

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