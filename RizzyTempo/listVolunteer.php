<?php
session_start();
require_once 'helper.php';

// Check if the user is logged in
if (!isset($_SESSION['admin_email'])) {
    header('Location: index.php');
    exit();
}

?>

<?php
// Create associative array for table headers
$header = array(
    "username" => "Username",
    "gender" => "User Gender",
    "email" => "User Email",
    "action" => "Action"
);

// Retrieve order, sort, and email filter from URL
if (empty($_GET)) {
    // No parameters in the URL
    $sort = "username";
    $order = "ASC";
    $email = "%";
} else {
    // Parameters exist in the URL
    $sort = isset($_GET["sort"]) ? $_GET["sort"] : "username";
    $order = isset($_GET["order"]) ? $_GET["order"] : "ASC";
    $email = isset($_GET["email"]) ? $_GET["email"] : "%";
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>List Volunteer</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="css/header.css" rel="stylesheet" type="text/css"/>
        <link href="css/form.css" rel="stylesheet" type="text/css"/>
        <link href="css/footer.css" rel="stylesheet" type="text/css"/>

        <?php
        require_once 'helper.php';
        ?>
        <style>
            .navbar {
                box-sizing: content-box;
            }

            body {
                background: url(img/musicbg.jpg) no-repeat center;
                background-size: cover;
                width: 100%;
            }

            .infotable {
                overflow: auto;
                white-space: nowrap;
                margin-bottom: 80px;
                background-color: white;
            }

            .action {
                font-size: 10px;
                padding: 5px;
                border: none;
                background-color: #009970;
                color: #fff;
                border-radius: 15px;
                transition: 0.3s background-color;
                text-decoration: none;
            }

            .action:hover {
                background-color: #00b383;
            }

            .return {
                border: 0;
                width: 60px;
                height: 60px;
                background: transparent;
                margin-left: 20px;
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
                                <a class="nav-link active mx-lg-2" style="color:white;" href="listVolunteer.php">Volunteer List</a>
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

        <?php
// Check if the delete button is clicked
        if (isset($_POST["btnDelete"])) {
            // Delete button clicked
            // Retrieve userIds from the checkboxes
            $checked = isset($_POST["chkDelete"]) ? $_POST["chkDelete"] : null;

            if (!empty($checked)) {
                // Connect to the database
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                $escaped = array();

                foreach ($checked as $value) {
                    $escaped[] = $con->real_escape_string($value);
                }

                // Construct SQL query to delete selected records
                $sql = "DELETE FROM volunteer WHERE username IN ('" . implode("','", $escaped) . "')";

                // Execute the delete query
                if ($con->query($sql)) {
                    printf("<div class='info'><b>%d</b> records have been deleted.</div>", $con->affected_rows);
                }

                $con->close();
            }
        }
        ?>

        <div class="d-flex justify-content-center">
            <div style="width: 60%; text-align: center;">
                <h1 style="padding-bottom: 15px;margin-top:100px;">List Volunteer</h1>
                <form action='' method='POST'>
                    <div class="infotable">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <?php
// Display table headers
                                    foreach ($header as $key => $value) {
                                        if ($key == $sort) {
                                            printf("<th scope='col'>
                                                <a href='?sort=%s&order=%s&email=%s'>%s</a>
                                                <img src='img/%s'/>
                                                </th>",
                                                    $key, ($order == 'ASC') ? 'DESC' : 'ASC',
                                                    $email,
                                                    $value,
                                                    ($order == 'ASC') ? 'asc.png' : 'desc.png'); // You need to provide the image file names for sorting indication
                                        } else {
                                            printf("<th scope='col'>
                                                <a href='?sort=%s&order=ASC&email=%s'>%s</a>
                                                </th>", $key, $email, $value);
                                        }
                                    }
                                    ?>
                                </tr> 
                            </thead>
                            <tbody class="table-group-divider">
                                <?php
                                // Connect to the database
                                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                                if ($con->connect_error) {
                                    die("Connection failed: " . $con->connect_error);
                                }

                                // Construct SQL query to fetch volunteer records
                                $sql = "SELECT * FROM volunteer WHERE email LIKE '$email' ORDER BY $sort $order";

                                $result = $con->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_object()) {
                                        // Use a default value for gender if getGender() returns NULL
                                        $genderValue = isset(getGender()[$row->gender]) ? getGender()[$row->gender] : "Unknown";

                                        printf("<tr>
                                        <td><input type='checkbox' name='chkDelete[]' value='%s' /></td>
                                        <td>%s</td>
                                        <td>%s</td>
                                        <td>%s</td>
                                        <td class='text-center'>
                                            <a href='updateVolunteer.php?username=%s' class='action'>Update</a>
                                            <a href='deleteVolunteer.php?username=%s' class='action'>Delete</a>
                                        </td>
                                    </tr>", $row->username, $row->username, $genderValue, $row->email, $row->username, $row->username);
                                    }

                                    printf('<tr><td colspan="6" style="text-align:left;">
                                    %d Record(s) Returned.
                                    </td></tr>', $result->num_rows);

                                    $result->free();
                                    $con->close();
                                } else {
                                    printf('<tr><td colspan="6">No records found.</td></tr>');
                                }
                                ?>
                            </tbody>
                        </table>
                        <input type="submit" value="Delete Checked" name="btnDelete" onclick="return confirm('This will delete all checked records.\nAre you sure?');" style="text-align:left;"/>

                    </div>
                    <br/> 
                </form>
            </div> 
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
