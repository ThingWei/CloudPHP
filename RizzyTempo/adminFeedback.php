<?php
session_start();
require_once 'helper.php';

// Check if the user is logged in
if (!isset($_SESSION['admin_email'])) {
    header('Location: index.php');
    exit();
}

// Create associative array for table headers
$header = array(
    "rating" => "Rating",
    "username" => "Username",
    "email" => "User Email",
    "description" => "User Review"
);

// Retrieve order, sort, and description filter from URL
$sort = isset($_GET["sort"]) && in_array($_GET["sort"], array_keys($header)) ? $_GET["sort"] : "rating";
$order = isset($_GET["order"]) && in_array(strtoupper($_GET["order"]), ["ASC", "DESC"]) ? strtoupper($_GET["order"]) : "ASC";
$description = isset($_GET["description"]) ? $_GET["description"] : "%";
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Feedback Details</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="css/header.css" rel="stylesheet">
        <link href="css/footer.css" rel="stylesheet">
        <style>
            body {
                background: url(img/musicbg.jpg) no-repeat center;
                background-size: cover;
                width: 100%;
            }

            table {
                margin: auto; /* Center the table */
                margin-top: 200px;
                border: 1px solid #ccc;
                border-radius: 20px;
                margin-bottom: 500px;
            }
            .button-container {
                text-align: left;
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
                                <a class="nav-link active mx-lg-2" style='color:white;' href="adminFeedback.php">Feedback</a>
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

// Check if the form has been submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btnDelete"])) {
            // Check if any checkboxes are checked
            if (isset($_POST['chkDelete']) && is_array($_POST['chkDelete'])) {
                // Connect to the database
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                if ($con->connect_error) {
                    die("Connection failed: " . $con->connect_error);
                }

                // Prepare SQL statement to delete checked records
                $sql = "DELETE FROM feedback WHERE rating = ?";
                $stmt = $con->prepare($sql);

                if ($stmt) {
                    // Bind parameter for the rating
                    $stmt->bind_param("i", $rating);

                    // Iterate over checked checkboxes
                    foreach ($_POST['chkDelete'] as $rating) {
                        // Execute the delete query for each checked record
                        if (!$stmt->execute()) {
                            // Error occurred while deleting record
                            echo "<div class='alert alert-danger'>Error deleting record with rating: " . $rating . "</div>";
                        }
                    }

                    // Close statement and database connection
                    $stmt->close();
                    $con->close();

                    // Redirect back to the page after deletion
                    echo '<script>document.location.href="adminFeedback.php"</script>';
                    exit();
                } else {
                    echo "<div class='alert alert-warning'>Error in prepared statement.</div>";
                }
            } else {
                echo "<div class='alert alert-warning'>Please select at least one record to delete.</div>";
            }
        }
        ?>
        <form action="" method="POST">

            <table class="table" style="width:900px;justify-content:center;">

                <thead>
                    <tr>
                        <th colspan="6" class="management-heading" style="font-size:35px;text-align:center;">Feedback Details Management</th>
                    </tr>
                    <tr>
                        <th></th>
                        <?php
// Display table headers
                        foreach ($header as $key => $value) {
                            $sortIcon = ($key == $sort) ? (($order == 'ASC') ? 'asc.png' : 'desc.png') : '';
                            $newOrder = ($key == $sort && $order == 'ASC') ? 'DESC' : 'ASC';
                            printf("<th scope='col'><a href='?sort=%s&order=%s&description=%s'>%s</a> <img src='img/%s'/></th>",
                                    htmlspecialchars($key), htmlspecialchars($newOrder), htmlspecialchars($description), htmlspecialchars($value), htmlspecialchars($sortIcon));
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
// Connect to the database
                    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                    if ($con->connect_error) {
                        die("Connection failed: " . $con->connect_error);
                    }

// Prepare and execute SQL statement
                    $sql = "SELECT * FROM feedback WHERE description LIKE ? ORDER BY $sort $order";
                    $stmt = $con->prepare($sql);
                    $stmt->bind_param("s", $description);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_object()) {
                            printf("<tr>
                            <td><input type='checkbox' name='chkDelete[]' value='%s' /></td>
                            <td>%s</td>
                            <td>%s</td>
                            <td>%s</td>
                            <td>%s</td>
                            </tr>",
                                    htmlspecialchars($row->rating), htmlspecialchars($row->rating), htmlspecialchars($row->username),
                                    htmlspecialchars($row->email), htmlspecialchars($row->description));
                        }

                        printf('<tr><td colspan="6">%d record(s) returned.</td></tr>', $result->num_rows);
                    } else {
                        echo "<tr><td colspan='6'>No records found.</td></tr>";
                    }

// Close connections
                    $result->free();
                    $stmt->close();
                    $con->close();
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6" class="button-container">
                            <input type="submit" value="Delete Checked" name="btnDelete" onclick="return confirm('Are you sure you want to delete the selected records?');" />
                        </td>
                    </tr>
                </tfoot>
            </table>
            <br/>
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
