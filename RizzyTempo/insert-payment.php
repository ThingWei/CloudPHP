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
        <title>Insert Payment Information</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="css/insert.css" rel="stylesheet" type="text/css"/>
        <link href="css/header.css" rel="stylesheet" type="text/css"/>
        <link href="css/footer.css" rel="stylesheet" type="text/css"/>
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
                
        <h1>Insert User Payment Detail</h1>

        <?php
        require_once 'helper.php';

// Check if the user click any button?
        if (empty($_POST)) {
            // USER never click anything
        } else {
            // Yes, user click on a button
            // Retrieve user input
            // Trim (ignore space) from user
            $name = trim($_POST["name"]);
            $email = trim($_POST["email"]);
            $address = trim($_POST["address"]);
            $address2 = trim($_POST["address2"]);
            $country = trim($_POST["country"]);
            $city = $_POST["city"];
            $region = $_POST["region"];
            $poscode = trim($_POST["poscode"]);
            $cardNumber = trim($_POST["cardNumber"]);
            $expMonth = $_POST["expMonth"];
            $expYear = $_POST["expYear"];
            $cvv = trim($_POST["cvv"]);

            // Initialize $error as an empty array
            $error = array();

            // Validation
            $error["name"] = checkName($name);
            $error["email"] = checkEmail($email);
            $error["address"] = checkAddress($address);
            $error["poscode"] = checkPoscode($poscode);
            $error["region"] = checkRegion($region);
            $error["city"] = checkCity($city);
            $error["cardNumber"] = checkCardNumber($cardNumber);
            $error["cvv"] = checkCVV($cvv);
            // Check if email already exists in the database
            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            mysqli_set_charset($con, 'utf8');
            $stmt = $con->prepare("SELECT COUNT(*) FROM payment WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_row();

            if ($row[0] > 0) {
                // Email already exists, display error message
                $error["email"] = "Email already exists in the database.";
            }

            // Remove null value
            $error = array_filter($error);

            if (empty($error)) {
                // GOOD, no error, proceed to insert record
                // Use MySQLi prepared statement for the INSERT query
                $query = "INSERT INTO payment (name, email, address, address2, country, city, region, poscode, cardNumber, expMonth, expYear, cvv) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $con->prepare($query);
                $stmt->bind_param("sssssssssssi", $name, $email, $address, $address2, $country, $city, $region, $poscode, $cardNumber, $expMonth, $expYear, $cvv);
                $result = $stmt->execute();

                // Check for errors
                if (!$result) {
                    $error = "Failed to create payment: " . mysqli_error($con);
                } else {
                    // Execute the SQL statement
                    if (mysqli_affected_rows($con) > 0) {
                        // Record inserted
                        printf("<div class='info'>User Payment <b>%s</b> has been inserted.<br/>[<a href='list-payment.php'>Back to Payment List</a>]</div>", $name);
                    } else {
                        // Record unable to insert
                        $error = "Failed to create payment: no rows affected.";
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
        <div class="container">
        <form action="" method="POST">
            
                <table>

                    <tr>
                        <td>User Name:</td>
                        <td><input type="text" name="name" class="input-field" value="<?php echo isset($name) ? $name : ''; ?>"></td>
                    </tr>



                    <tr>
                        <td>Email:</td>
                        <td><input type="email" name="email"class="input-field" value="<?php echo isset($email) ? $email : ''; ?>"></td>
                    </tr>



                    <tr>
                        <td>Address:</td>
                        <td><input type="text" name="address"class="input-field" value="<?php echo isset($address) ? $address : ''; ?>"></td>
                    </tr>



                    <tr>
                        <td></td>
                        <td><input type="text" name="address2" class="input-field" value="<?php echo isset($address2) ? $address2 : ''; ?>"></td>
                    </tr>



                    <tr class="column">
                        <td class="country">Country:</td>
                        <td><select name="country" class="selectBox" required>
                                <option value="">Choose Country</option>
                                <option value="Malaysia">Malaysia</option>
                                <option value="Thailand">Thailand</option>
                                <option value="Indonesia">Indonesia</option>
                                <option value="Vietnam">Vietnam</option>
                                <option value="Cambodia">Cambodia</option>
                                <option value="Myanmar">Myanmar</option>
                                <option value="Japan">Japan</option>
                                <option value="Korea">Korea</option>
                            </select></td>

                        <td class="city">City:</td>
                        <td><input type="text" name="city" class="row-field" value="<?php echo isset($city) ? $city : ''; ?>"></td>
                    </tr>



                    <tr class="column">
                        <td>Region:</td>
                        <td><input type="text" name="region"class="region-field" value="<?php echo isset($region) ? $region : ''; ?>"></td>                          


                        <td class="city">Poscode:</td>
                        <td><input type="number" name="poscode" class="row-field" value="<?php echo isset($poscode) ? $poscode : ''; ?>"></td>
                    </tr>



                    <tr>
                        <td >Card Number:</td>
                        <td><input type="text" name="cardNumber" class="input-field" value="<?php echo isset($cardNumber) ? $cardNumber : ''; ?>"></td>
                    </tr>



                    <tr class="column">
                        <td>Exp Month:</td>
                        <td><select name="expMonth" class="select-box" required>
                                <option value="">Month</option>
                                <option value="01">01</option>
                                <option value="02">02</option>
                                <option value="03">03</option>
                                <option value="04">04</option>
                                <option value="05">05</option>
                                <option value="06">06</option>
                                <option value="07">07</option>
                                <option value="08">08</option>
                                <option value="09">09</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select></td>

                        <td>Exp Year:</td>
                        <td><select name="expYear" class="select-box" required>
                                <option value="" >Year</option>
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                                <option value="2026">2026</option>
                            </select></td>

                        <td>CVV:</td>
                        <td><input type="number" name="cvv"  class="field" value="<?php echo isset($cvv) ? $cvv : ''; ?>"></td>
                    </tr>

                </table>
                <br/>
                <div class="button">
                    <input type="submit" value="Insert" class="input-button" name="btnInsert" />
                    <input type="button" value="Cancel" class="input-button" name="btnCancel" onclick="location = 'list-payment.php'"/>
                </div>
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