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
        <style>
            body {
                background: url(img/musicbg.jpg) no-repeat center;
                background-size: cover;
                width: 100%;
                height: 100%;
            }
        </style>
        <meta charset="UTF-8">
        <title>Insert Login Information</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<!--        <link href="css/login-insert.css" rel="stylesheet" type="text/css"/>-->
        <link href="css/header.css" rel="stylesheet" type="text/css"/>
        <link href="css/footer.css" rel="stylesheet" type="text/css"/>

        <style>
            table ,th ,td{
                border-radius:20px;
                /* remove position: absolute; as it's not necessary */
                align-items: center;
                border-spacing:15px;
                padding: 10px 15px 10px 15px;
            }

            table ,th {
                background-color: black;
                color: white;
                font-size: 25px;
                text-align: left;
            }

            .input-field {
                width:400px;
                height:40px;
                font-size:20px;
                padding:10px;
            }

            h1{
                text-align: center;
            }

            .input-button {
                width: 270px;
                height:60px;
                border-radius:20px;
                border-spacing:5px;
                margin-left:50px;
                font-size:25px;

            }

            .input-button:hover{
                background-color: green;
            }

            .male{
                margin-left: 80px;
            }

            .female{
                margin-left:-170px;
            }

            input[type="radio"] {
                transform: scale(1.5);
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

        <h1>&nbsp;</h1>
        <p>&nbsp;</p>
        <p>&nbsp;</p>

        <?php
        require_once 'helper.php';
        ?>

        <h1>Create new users</h1>

        <?php
        //check if the user click any button?
        if (empty($_POST)) {
            //USER never click anything
        } else {
            //Yes,user click on a button
            //retreive user input 
            //trim (ignore space)from user
            $name = trim($_POST["name"]);
            $email = trim($_POST["email"]);
            $gender = isset($_POST['gender']) ? trim($_POST['gender']) : '';
            $password = $_POST["password"];
            $password2 = $_POST["password2"];

            //validation
            $error["name"] = checkName($name);
            $error["email"] = checkEmail($email);
            $error["password"] = checkPassword($password);
            $error["password2"] = checkPassword($password2);

            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            mysqli_set_charset($con, 'utf8');
            // Check if email already exists in the database
            $stmt = $con->prepare("SELECT COUNT(*) FROM user WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_row();

            if ($row[0] > 0) {
                // Email already exists, display error message
                $error["email"] = "Email already exists in the database.";
            } else if ($password != $password2) {
                $error["password"] = "Password and Confirm Password Not Match.";
                echo "<script>window.location.href =insert-login.php';</script>";
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

                $query = "INSERT INTO user (username, email, gender, userPw) VALUES ('$name', '$email', '$gender', '$hashedPassword')";
                $result = mysqli_query($con, $query);

                // Check for errors
                if (!$result) {
                    $error = "Failed to create user: " . mysqli_error($con);
                } else {
                    // Execute the SQL statement
                    if (mysqli_affected_rows($con) > 0) {
                        //record inserted 
                        printf("
                            <div class='info d-flex justify-content-center'>
                            User  <b>%s</b>  has been inserted.
                            [<a href='list-login.php'>Back to Login List</a>]
                            </div>
                                ", $name);
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
        }
        ?>
        <div class = "d-flex justify-content-center">
            <form action="" method="POST">
                <table>
                    <tr>
                        <th>User Name:</th>
                        <td><input type="text" name="name" class="input-field" value="<?php echo isset($name) ? $name : ""; ?>"/></td>
                    </tr>

                    <tr>
                        <th>Email:</th>
                        <td><input type="email" name="email" class="input-field" value="<?php echo isset($email) ? $email : ""; ?>"/></td>
                    </tr>

                    <tr>
                        <th>Gender:</th>
                        <td><input type="radio" name="gender" class="male" value="M"> Male</td>
                        <td><input type="radio" name="gender" class="female"  value="F"> Female</td>

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
                <div class = "d-flex justify-content-center">
                    <input type="submit" value="Insert" class="input-button" name="btnInsert" />
                    <input type="button" value="Cancel" class="input-button" name="btnCancel" onclick="location = 'list-login.php'"/>
                </div>
            </form>
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