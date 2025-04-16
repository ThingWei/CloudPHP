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
        <title>Ticket Details</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="css/header.css" rel="stylesheet">
        <link href="css/footer.css" rel="stylesheet">
        <script src="scripts/jquery-1.9.1.js"></script>
        <style>
            body {
                background: url(img/musicbg.jpg) no-repeat center;
                background-size: cover;
                width: 100%;
                height: 100%;
            }
            .container {
                margin: auto;
                width: 700px;
                margin-top: 50px;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                margin-bottom: 40px;
                font-family: Arial, sans-serif;
                background-color: #fff;
            }
            table {
                margin: auto;
                border: 1px solid #ccc;
                border-radius: 20px;
                width: 100%;
                border-collapse: collapse;
            }
            th, td {
                border: 1px solid #ccc;
                padding: 10px;
                text-align: left;
            }
            th {
                background-color: #f4f4f4;
            }
            input[type="text"], input[type="submit"] {
                width: 100%;
                padding: 10px;
                margin-bottom: 10px;
                border: 1px solid #ccc;
                border-radius: 0;
            }
            input[type="submit"] {
                background-color: #007bff;
                color: white;
                border: none;
                cursor: pointer;
                margin-top:5px;
            }
            input[type="submit"]:hover {
                background-color: #0056b3;
            }
            .error, .info {
                padding: 5px;
                margin: 5px;
                font-size: 0.9em;
                list-style-position: inside;
            }
            .error {
                border: 2px solid #FBC2C4;
                background-color: #FBE3E4;
                color: #8A1F11;
            }
            .success-message {
                color: blue;
                font-size: 25px;
            }
            .ticket-list {
                margin-top: 50px;
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
                                <a class="nav-link active mx-lg-2" style='color:white;' href="deleteTicket.php">Ticket List</a>
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

        $tickets = getAllTickets();

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btnDelete"])) {
            // Check if any checkboxes are checked
            if (isset($_POST['eventTicketName']) && is_array($_POST['eventTicketName'])) {
                // Connect to the database
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                if ($con->connect_error) {
                    die("Connection failed: " . $con->connect_error);
                }

                // Prepare SQL statement to delete checked records
                $sql = "DELETE FROM ticket WHERE eventTicketName = ?";
                $stmt = $con->prepare($sql);

                if ($stmt) {
                    // Bind parameter for the ticketID
                    $stmt->bind_param("s", $ticketID);

                    // Iterate over checked checkboxes
                    foreach ($_POST['eventTicketName'] as $ticketID) {
                        // Execute the delete query for each checked record
                        if (!$stmt->execute()) {
                            // Error occurred while deleting record
                            echo "<div class='alert alert-danger'>Error deleting record with ticketID: " . $ticketID . "</div>";
                        } else {
                            // Record deleted successfully
                            $successMessage = "Record with ticket of event name: " . $ticketID . " deleted successfully.";
                        }
                    }

                    // Close statement and database connection
                    $stmt->close();
                    $con->close();

                    // Redirect back to the page after deletion
                    echo "<script>window.location.href = '$_SERVER[PHP_SELF]';</script>";
                    exit();
                } else {
                    echo "<div class='alert alert-warning'>Error in prepared statement.</div>";
                }
            } else {
                echo "<div class='alert alert-warning'>Please select at least one record to delete.</div>";
            }
        }
        ?>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btnUpdate"])) {
            // Get form data
            $eventTicketName = $_POST['eventTicketName'];
            $ticketType = $_POST['ticketType'];
            $price = $_POST['price'];

            // Update the ticket data in the database
            $success = updateTicket($eventTicketName, $ticketType, $price);

            if ($success) {
                // Redirect to the ticket list page or display a success message
                header("Location: updateTicketDetail.php");
                exit();
            } else {
                // Handle update failure
                echo "<p>Error updating ticket.</p>";
            }
        }
        ?>


        <div class="container ticket-list" style="margin-top:150px;">
            <h2>Ticket List</h2>
            <?php
            if (isset($successMessage)) {
                echo "<div class='alert alert-success'>$successMessage</div>";
            }
            ?>
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <table>
                    <thead>
                        <tr>
                            <th>Delete</th>
                            <th>Event Name</th>
                            <th>Ticket Type</th>
                            <th>Ticket Price</th>
                            <th>Update</th> <!-- New column for update button -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($tickets) {
                            foreach ($tickets as $ticket) {
                                echo "<tr>";
                                echo "<td><input type='checkbox' name='eventTicketName[]' value='" . htmlspecialchars($ticket['eventTicketName']) . "'></td>";
                                echo "<td>" . htmlspecialchars($ticket['eventTicketName']) . "</td>";
                                echo "<td>" . htmlspecialchars($ticket['ticketType']) . "</td>";
                                echo "<td>  RM     " . htmlspecialchars($ticket['price']) . "</td>";
                                // Add a button in each row to update the ticket
                                echo "<td><a href='updateTicketDetail.php?eventTicketName=" . htmlspecialchars($ticket['eventTicketName']) . "' class='btn btn-primary'>Update</a></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No Record Found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <input type="submit" value="Delete Checked" name="btnDelete" onclick="return confirm('Are you sure you want to delete the selected records?');" />
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
