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
        <title>Update Volunteer</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="css/header.css" rel="stylesheet">
        <link href="css/footer.css" rel="stylesheet">
        <style>

            body {
                display: flex;
                flex-direction: column;
                margin: 0;
                background: url(img/musicbg.jpg) no-repeat center;
                background-size: cover;
                width: 100%;
                height: 100%;
            }
            main {
                flex: 1;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .container {
                width: 500px;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 0 15px rgba(0,0,0,0.1);
                background-color: #fff;
                margin-top:200px;
                margin-bottom:50px;
            }
            footer {
                text-align: center;
                padding: 10px;
                background-color: #343a40; /* Dark background color */
                color: #ffffff; /* White text color */
            }
            .error, .info {
                padding: 5px;
                margin: 5px;
                font-size: 0.9em;
                list-style-position: inside;
            }
            .info
            {
                border: 2px solid #92CAE4;
                background-color: #D5EDF8;
                color: #205791;
            }

            .error {
                border: 2px solid #FBC2C4;
                background-color: #FBE3E4;
                color: #8A1F11;
                margin-top: 20px;
            }
            .success-message {
                color: blue;
                font-size: 25px;
            }
            label {
                display: block;
                margin-bottom: 5px;
            }
            input[type="text"],
            input[type="submit"],
            input[type="button"] {
                width: 100%;
                padding: 10px;
                margin-bottom: 10px;
                border: 1px solid #ccc;
                border-radius: 0;
            }
            input[type="submit"],
            input[type="button"] {
                background-color: #007bff;
                color: white;
                border: none;
                cursor: pointer;
            }
            input[type="submit"]:hover,
            input[type="button"]:hover {
                background-color: #0056b3;
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

        <main>
            <div class="container">
                <?php
                require_once 'helper.php';

                if ($_SERVER["REQUEST_METHOD"] == "GET") {
                    // Retrieve existing record to display
                    // Retrieve user ID from URL
                    if (isset($_GET['username'])) {
                        $Name = strtoupper(trim($_GET['username']));
                    } else {
                        $Name = "";
                    }

                    // Step 1: Establish database connection
                    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                    // Clean id by removing special characters
                    $name = $con->real_escape_string($Name);

                    // Step 2: Query to select record
                    $sql = "SELECT * FROM volunteer WHERE username = '$name'";
                    $result = $con->query($sql);

                    if ($result->num_rows > 0) {
                        if ($row = $result->fetch_object()) {
                            // Record found
                            $name = $row->username;
                            $gender = $row->gender;
                            $email = $row->email;
                        }
                    } else {
                        // Record not found
                        echo "<div class='error'>Record not found. Please try again.
                          [<a href='listVolunteer.php'>Back to List Volunteer</a>]
                          </div>";
                        exit; // Exit the script to prevent further execution
                    }
                    $result->free(); // Free the result set
                } else {
                    // Update action
                    // Retrieve form data
                    $Name = trim($_GET["username"]);        
                    $name = trim($_POST["txtName"]);
                    $gender = isset($_POST["rbGender"]) ? $_POST["rbGender"] : null;

                    // Step 1: Establish database connection
                    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                    // Step 2: Prepare update query
                    $sql = "UPDATE volunteer SET username=?, gender=? WHERE username=?";

                    // Step 3: Prepare and execute statement
                    $stmt = $con->prepare($sql);
                    $stmt->bind_param("sss", $name, $gender, $Name);
                    $stmt->execute();

                    // Check if the update was successful
                    if ($stmt->affected_rows > 0) {
                        echo "<div class='info'>User <b>$name</b> has been updated.
                          [<a href='listVolunteer.php'>Back to List Volunteer</a>]
                          </div>";
                    } else {
                        // Update unsuccessful
                        echo "<div class='error'>Unable to update record. Please try again.
                          [<a href='listVolunteer.php'>Back to List Volunteer</a>]
                          </div>";
                    }

                    $stmt->close(); // Close the statement
                }
                ?>

                <form action="" method="POST">
                    <h2>Update Volunteer Details</h2>
                    <br/>
                    
                    <label for="username">Username :</label>
                    <input type="text" name="txtName" value="<?php echo $name; ?>"><br/>
                    
                    <br/>
                    <label for="gender">Gender :</label>
                    <input type="radio" name="rbGender" value="F" <?php echo ($gender == 'F') ? 'checked' : ''; ?>> Female👧 &nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="rbGender" value="M" <?php echo ($gender == 'M') ? 'checked' : ''; ?>> Male👨
                    <br/><br/>
                    <label for="email">User Email :</label>
                    <input type="text" name="txtEmail" value="<?php echo $email; ?>" disabled><br/>
                    <input type="submit" value="Update" name="btnUpdate" style="margin-top:20px;"/>
                    <input type="button" value="Cancel" name="btnCancel" onclick="location = 'listVolunteer.php'"/>
                </form>
            </div>
        </main>

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
