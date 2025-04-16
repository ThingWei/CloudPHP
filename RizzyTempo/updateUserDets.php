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
        <title>Update User Acc Information</title>
        <link href="css/login-insert.css" rel="stylesheet" type="text/css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="css/header.css" rel="stylesheet" type="text/css"/>
        <link href="css/footer.css" rel="stylesheet" type="text/css"/>
        <style>
            body {
                background: url(img/musicbg.jpg) no-repeat center;
                background-size: cover;
                width: 100%;
                height: 100%;
            }
            .container{
                max-width: 60%;
                padding-left: 80px;
            }
            .info{
                text-align: center;
                padding: 20px;
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
        <p>&nbsp;</p>
        <p>&nbsp;</p>

        <h1>Update User Account Information</h1>
        <?php
        require_once 'helper.php';

        echo '<div class = "justify-content-center">';
// Check if the user has clicked the modify button
        if (isset($_POST['btnModify'])) {

            $name2 = trim($_POST["name"]);
            $gender = isset($_POST['gender']) ? trim($_POST['gender']) : '';
            $password = $_POST["password"];
            $password2 = $_POST["password2"];

            //validation
            $error["name"] = checkName($name2);
            $error["password"] = checkPassword($password);
            $error["password2"] = checkPassword($password2);

            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            mysqli_set_charset($con, 'utf8');
            // Check if email already exists in the database
            $stmt = $con->prepare("SELECT COUNT(*) FROM user WHERE email = ?");
            $stmt->bind_param("s", $user_email);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_row();

            if (strcmp($password, $password2)!= 0) {
                $error["password"] = "Password and Confirm Password Not Match.";
            }

            //remove null value
            $error = array_filter($error);

            if (empty($error)) {
                //GOOD, no good,proceed to insert record 

                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                mysqli_set_charset($con, 'utf8');

                //step 2:sql statement 
                // Hash the password
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

                $query = "UPDATE user SET username='$name2', gender='$gender', userPw='$hashedPassword' WHERE email='$user_email'";
                $result = mysqli_query($con, $query);

                // Check for errors
                if (!$result) {
                    $error = "Failed to Update user: " . mysqli_error($con);
                } else {
                    // Execute the SQL statement
                    if (mysqli_affected_rows($con) > 0) {
                        //record inserted 
                        printf("
                            <div class='info'>
                            User Account <b>%s</b> has been Updated.
                            [<a href='profile.php'>Back to Profile</a>]
                            </div>
                                ", $name2);
                    } else {
                        //record unable to insert 
                        $error = "Failed to create user: no rows affected.";
                    }
                }

                // Close the database connection
                mysqli_close($con);
            } else {
                foreach ($error as $value) {
                    echo "<script>alert('$value');</script>";
                }
            }
        } else {
            // Get the ID of the record from the URL
            $id = trim($_GET["id"]);

            // Retrieve the details of the record from th+e database
            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            mysqli_set_charset($con, 'utf8');

            $sql = "SELECT * FROM user WHERE username = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("s", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_object()) {
                $name = $row->username;
                $email = $row->email;
                $gender = $row->gender;
                $password = $row->userPw;
            } else {
                // Not good, display error msg
                echo "<ul class='error'>";
                foreach ($error as $value) {
                    echo "<li style='color: red;'>$value</li>";
                }
                echo "</ul>";
            }

            $result->free();
            $con->close();
        }
        ?>    
        
            <div class="container">
                <form action="" method="POST">
                    <table>
                        <tr>
                            <th>Username:</th>
                            <td><input type="text" name="name"  class="input-field" value="<?php echo isset($name) ? $name : ""; ?>"/></td>
                        </tr>

                        <tr>
                            <th>Email:</th>
                            <td><input type="email" name="email" class="input-field" value="<?php echo $user_email; ?>" disabled/></td>
                        </tr>

                        <tr>
                            <th>Gender:</th>
                            <td>  <input type="radio" name="gender" class="male" value="M" required> Male</td>
                            <td> <input type="radio" name="gender" class="female"  value="F" required> Female</td>

                        </tr>

                        <tr>
                            <th>Password:</th>
                            <td><input type="password" name="password" class="input-field" value="<?php echo isset($password) ? $password : ""; ?>"/></td>
                        </tr>

                        <tr>
                            <th>Confirm Password:</th>
                            <td><input type="password" name="password2" class="input-field" value="<?php echo isset($password2) ? $password2 : ""; ?>"/></td>
                        </tr>
                    </table>
                    <br/>
                    <input type="submit" value="modify" name="btnModify" class="input-button" />
                    <input type="button" value="Cancel" name="btnCancel" class="input-button" onclick="location = 'profile.php'"/>
                </form>
            </div>
        </div>
        <p>&nbsp;</p>
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

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    </body>
</html>
