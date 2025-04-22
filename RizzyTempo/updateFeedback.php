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
        <title>Update Feedback</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="css/header.css" rel="stylesheet">
        <link href="css/footer.css" rel="stylesheet">

        <script src="js/script.js"></script>
    </head>
    <style>
        body {
            background: url(img/musicbg.jpg) no-repeat center;
            background-size: cover;
            width: 100%;
            height: 100%;
        }

        .container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            padding: 40px;
            margin-top: 50px;
            max-width: 600px;
            margin-top:150px;
            margin-bottom: 50px;
        }

        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }

        label {
            font-weight: bold;
        }

        textarea.form-control {
            resize: none;
        }

        .btn-primary {
            width: 100%;
        }

        .btn-secondary {
            width: 100%;
            margin-top: 10px;
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

    <div class="container">

        <?php
        require_once 'helper.php';

        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        $uemail = trim($_GET['email']);
        $desc = trim($_GET['description']);

        $sql1 = "SELECT * FROM feedback WHERE email = '$uemail' AND description = '$desc'";
        $result = $con->query($sql1);
        if ($row = $result->fetch_object()) {
            $ratings = $row->rating;
            $usernames = $row->username;
            $emails = $row->email;
            $descriptions = $row->description;
        }

// Check if the form has been submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btnUpdate"])) {
            // Check if the necessary form fields are set
            if (isset($_POST['rating'], $_POST['username'], $_POST['description'])) {
                // Retrieve form data
                $rating = $_POST['rating'];
                $username = $_POST['username'];
                $description = $_POST['description'];

                // Perform validation if needed
                // Connect to the database
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                // Check connection
                if ($con->connect_error) {
                    die("Connection failed: " . $con->connect_error);
                }

                // Prepare SQL statement to update the feedback record
                $sql = "UPDATE feedback SET username=?, description=? WHERE description=?";
                $stmt = $con->prepare($sql);

                if ($stmt) {
                    // Bind parameters
                    $stmt->bind_param("sss", $username, $description, $descriptions);

                    // Execute the update query
                    if ($stmt->execute()) {
                        echo "<div class='alert alert-success'>Feedback updated successfully.[<a href='adminFeedback.php'>Back to Feedback Details Management]</a></div>";
                    } else {
                        echo "<div class='alert alert-danger'>Error updating feedback: " . $stmt->error . "</div>";
                    }

                    // Close statement and database connection
                    $stmt->close();
                    $con->close();
                } else {
                    echo "<div class='alert alert-warning'>Error in prepared statement.</div>";
                }
            } else {
                echo "<div class='alert alert-warning'>All fields are required.</div>";
            }
        }
        ?>
        <h1>Update Feedback</h1>

        <form action="" method="POST">
            <div class="mb-3">
                <label for="rating" class="form-label">Rating:</label>
                <input type="text" id="rating" name="rating" class="form-control" value="<?php echo $ratings ?>">
            </div>

            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" id="username" name="username" class="form-control" value="<?php echo $usernames ?>">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" name="email" class="form-control" value='<?php echo $emails ?>' disabled>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description:</label>
                <input type='text' id="description" name="description" rows="4" class="form-control" value='<?php echo $descriptions ?>'>
            </div>

            <button type="submit" name="btnUpdate" class="btn btn-primary">Update Feedback</button>
            <button type="reset" name="btnReset" class="btn btn-secondary">Reset</button>
            <button type="button" name="btnBack" class="btn btn-secondary" onclick="location = 'adminFeedback.php'">Back</button>
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