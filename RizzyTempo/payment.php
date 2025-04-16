<?php
session_start();
require_once 'helper.php';

// Check if the user is logged in
if (!isset($_SESSION['user_email'])) {
    header('Location: index.php');
    exit();
}
//Check if the user click any button?
$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
$useremail = $_SESSION['user_email'];

$sql2 = "SELECT * FROM user WHERE email = '$useremail'";
$result2 = $con->query($sql2);
if ($row2 = $result2->fetch_object()) {
    $uname = $row2->username;
    $uemail = $row2->email;
    $ugender = $row2->gender;
}

$result2->free();

if (isset($_POST["submit"])) {
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

    $error["email"] = checkEmail2($email);
    
    if (empty($address)) {
        $error["address"] = "Address is required.";
    }

    if (empty($poscode)) {
        $error["poscode"] = "Postal code is required.";
    } elseif (!preg_match("/^[0-9]{5}$/", $poscode)) {
        $error["poscode"] = "Invalid postal code format.";
    }

    if (empty($city)) {
        $error["city"] = "City is required.";
    }

    if (empty($region)) {
        $error["region"] = "Region is required.";
    }

    if (empty($cardNumber)) {
        $error["cardNumber"] = "Card number is required.";
    } elseif (!preg_match("/^[0-9-]{16}$/", $cardNumber)) {
        $error["cardNumber"] = "Invalid card number format.";
    }

    if (empty($cvv)) {
        $error["cvv"] = "CVV is required.";
    } elseif (!preg_match("/^[0-9]{3}$/", $cvv)) {
        $error["cvv"] = "Invalid CVV format.";
    }

    // Remove null value
    $errors = array_filter($error);

    $eventName = trim($_GET['eventTicketName']);
    $type = trim($_GET['ticketType']);

    $sql3 = "SELECT * FROM event WHERE eventName = '$eventName'";
    $getevent = $con->query($sql3);
    if ($row = $getevent->fetch_object()) {
        $ticket = $row->eventName;
        $headline = $row->headline;
        $descrip = $row->description;
        $banner = $row->eventBanner;
        $date = $row->dateOfEvent;
        $time = $row->time;
        $loc = $row->location;
    }
    
    $sql2 = "SELECT * FROM ticket WHERE eventTicketName = '$eventName' AND ticketType = '$type'";
    $getticket = $con->query($sql2);
    if ($row = $getticket->fetch_object()) {
        $tick = $row->eventTicketName;
        $ticktype = $row->ticketType;
        $price = $row->price;
    }

    if (empty($errors)) {
        // GOOD, no error, proceed to insert record
        // Use MySQLi prepared statement for the INSERT query
        $query = "INSERT INTO payment (email, eventName, ticketType, price, cardNumber) VALUES (?, ?, ?, ?, ?)";
        $stmt = $con->prepare($query);
        $stmt->bind_param("sssss", $uemail, $eventName, $type, $price, $cardNumber);
        $result = $stmt->execute();

        $eventName = trim($_GET["eventTicketName"]);
        $eventtable = str_replace(' ', '_', $eventName);
        $lowercasetable = strtolower($eventtable);

        $sql2 = "INSERT INTO `$lowercasetable` (username, email, gender) VALUES (?,?,?) ";
        $insert = $con->prepare($sql2);
        $insert->bind_param("sss", $uname, $uemail, $ugender);

        //step 3:execute sql
        $insert->execute();

        $receipt = "INSERT INTO receipt (email, eventName, ticketType, price, date, time, location) VALUES ('$uemail', '$ticket','$type', '$price','$date','$time','$loc')";
        $inreceipt = $con->query($receipt);
        
        // Check for errors
        if (!$result) {
            $errors = "Failed to create payment: " . mysqli_error($con);
        } else {
            // Execute the SQL statement
            if (mysqli_affected_rows($con) > 0) {

                $eventName = trim($_GET["eventTicketName"]);
                $ticketType = trim($_GET["ticketType"]);
                // Record inserted
                printf('<script>alert("Payment Completed! Thanks for supporting us.");document.location.href="receipt.php?eventTicketName=%s&ticketType=%s"</script>', $eventName, $ticketType);
            } else {
                // Record unable to insert
                $errors = "Failed to create payment: no rows affected.";
            }
        }

        // Close the database connection
        mysqli_close($con);
    } else {

        $eventName = trim($_GET["eventTicketName"]);
        $ticketType = trim($_GET["ticketType"]);

        foreach ($errors as $value) {
            echo "<script>alert('$value');</script>";
        }
        printf('<script>window.location.href="payment.php?eventTicketName=%s&ticketType=%s"</script>', $eventName, $ticketType);
    }
}
?>

<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Payment</title>
        <script src="payment.js"></script>
        <!-- Bootstrap Css -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <style>
            * {
                padding: 0;
                margin: 0;
                box-sizing: border-box;
                font-family: Century Gothic Std, AppleGothic, Arial, sans-serif;
            }

            body {
                background: url(img/musicbg.jpg) no-repeat center;
                background-size: cover;
                width: 100%;
            }

            .everything {
                display: flex;
                margin-left: 35px;
            }

            .background {
                width: 40%;
                height: 100vh;
                background: url('img/musicPhoto.png')no-repeat;
                background-repeat: cover;
                background-position: center;
            }

            .container {
                background-color: white;
                backdrop-filter: blur(50px);
                max-width: 900px;
                max-height: 800px;
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                padding: 2rem 1.5rem;
                border-radius: 20px;
                font-size: 20px;
                user-select: none;
                color: black;
                border: 1px solid;
                margin-top: 20px;
                margin-bottom: 20px;
                gap: 20px;
            }

            .left {
                flex-basis: 50%;
            }

            .right {
                flex-basis: 50%;
            }

            form {
                padding: 1.5rem;
            }

            form input[type="text"] {
                width: 100%;
                padding: 1.2rem 0.7rem;
                margin-top: 1rem;
                outline: none;
                border-radius: 20px;
                font-size: 15px;
            }

            #fnBox,
            #emailBox {
                width: 100%;
                margin-right: 50px;
            }

            #zip {
                display: flex;
                column-gap: 20px;
                margin-top: 0.5rem;
            }

            #zip select {
                padding: 1.2rem 1rem;
                outline: none;
                border-radius: 20px;
                font-size: 15px;
            }

            #zip input[type="number"] {
                padding: 1.2rem 0.5rem;
                margin-right: 80px;
                outline: none;
                width: 80%;
                border-radius: 20px;
            }

            #cardNumberBox {
                width: 100%;
                padding: 1.2rem 0.7rem;
                margin-top: 1rem;
                outline: none;
                border-radius: 20px;
                font-size: 15px;

            }

            #monthBox {
                width: 100%;
                padding: 1.2rem 0.7rem;
                margin-top: 1rem;
                outline: none;
                border-radius: 20px;
                font-size: 15px;
            }

            input[type="submit"] {
                width: 86%;
                padding: 0.7rem 2rem;
                background-color: black;
                color: white;
                outline: none;
                margin: 0.5rem;
                font-size: 2rem;
                border-radius: 20px;
            }

            input[type="submit"]:hover {
                background: green;
            }

            .x {
                color: black;
                cursor: pointer;
                position: absolute;
                right: 20px;
                top: 1px;
                font-size: 70px;
                border: none;
                background: rgba(1, 1, 1, 0);
            }

            .x:hover {
                color: green;
            }

            .container .column {
                display: flex;
                column-gap: 20px;
            }

            #region {
                width: 200px;
            }

            #poscode {
                width: 200px;
                border-radius: 20px;
                height: 58px;
                margin-top: 16px;
                padding-left: 10px;
            }

            #inputBox:focus:valid,
            #region:focus:valid,
            #poscode:focus:valid,
            #fnBox:focus:valid {
                background-color: rgb(220, 255, 220);
                background-image: url('img/cg_valid.png');
                background-repeat: no-repeat;
                background-position: 96%;
                background-size: 25px;
            }

            #inputBox:focus:invalid,
            #region:focus:invalid,
            #poscode:focus:invalid,
            #fnBox:focus:invalid {
                background-color: rgb(255, 232, 232);
                background-image: url('img/cg_invalid.png');
                background-repeat: no-repeat;
                background-position: 96%;
                background-size: 25px;
            }



            label {
                font-size: 20px;
            }

            p {
                font-size: 17px;
                margin: 10px 0;
                display: inline-block;
                padding: 5px 25px;
            }

            header .title {
                display: flex;
                align-items: center;
                /* Align items vertically */
                justify-content: space-between;
                /* Separate titles to each end */
                background-color: black;
                height: 100px;
                padding-left: 50px;
                padding-right: 50px;

            }

            @keyframes back {
                100% {
                    background-position: 2000px 0;
                }
            }

            .title h1 {
                font-size: 65px;
                margin: 0;
                /* Remove default margin */
                color: transparent;
                -webkit-text-stroke: 1px #fff;
                background: url('img/back.png');
                -webkit-background-clip: text;
                background-position: 0 0;
                animation: back 20s linear infinite;
            }

            .title2 {
                color: white;
                font-size: 35px;
                margin: 0;
                /* Remove default margin */
            }

            .movementTitle {
                display: flex;
                /* Set to flex container */
                align-items: center;
                /* Align items vertically */
            }

            .title2 {
                margin-left: 800px;
                /* Adjust margin for spacing */
                margin-bottom: 100px;
            }

            @keyframes moveTitle {
                0% {
                    transform: translateX(-40%);
                }

                50% {
                    transform: translateX(50%);
                }

                100% {
                    transform: translateX(-40%);
                }
            }

            .movementTitle .title2 {
                position: absolute;
                animation: moveTitle 18s linear infinite;
            }

            @keyframes moving {
                0% {
                    left: -20px;
                }

                100% {
                    left: 100%;
                }
            }
            .receipt {
                background-color: #fff;
                border-radius: 20px;
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.5);
                padding: 30px;
                text-align: center;
                max-width: 500px;
                width: 100%;
                position: relative;
            }
            .receipt::before {
                content: '';
                position: absolute;
                top: -20px;
                left: calc(50% - 20px);
                width: 40px;
                height: 40px;
                background-color: #FF5722;
                border-radius: 50%;
                box-shadow: 0 0 20px rgba(255, 87, 34, 0.5);
            }
            .receipt h2 {
                color: #333;
                margin-top: 20px;
                margin-bottom: 20px;
            }
            .receipt p {
                margin: 10px 0;
            }
            .receipt .highlight {
                color: #FF5722;
                font-weight: bold;
            }
            .receipt .header {
                background-color: #FF5722;
                color: #fff;
                border-radius: 20px 20px 0 0;
                padding: 20px;
                margin-bottom: 20px;
            }
            .receipt .footer {
                background-color: #f8f8f8;
                border-radius: 0 0 20px 20px;
                padding: 20px;
                margin-top: 20px;
            }
            .yearBox{
                width:150px;
                height:50px;
                border-radius:20px;
                padding-left: 45px;
                margin-left: 30px;
            }

            .monthBox{
                width:150px;
                height:50px;
                border-radius:20px;
                padding-left: 45px;
                margin-left: 13px;
            }

            .cvv{
                width:150px;
                height:50px;
                border-radius:20px;
                padding-left: 45px;
                margin-left: 70px;
            }
        </style>
    </head>
    <body>    
        <header>
            <div class="title">
                <h1><b>RT Music Society</b></h1>
            </div>

            <div class="movementTitle">
                <h1 class="title2">Thank You For Your Support!</h1>
            </div>

        </header>
        <div class="everything">
            <div>
                <div class="receipt-container" >
                    <h1>&nbsp;</h1>
                    <h1>&nbsp;</h1>
                    <div class="receipt">
                        <div class="header">
                            <h2><b>Invoice</b></h2>
                        </div>
                        <?php
                        // Create connection

                        $eventName = trim($_GET["eventTicketName"]);
                        $ticketType = trim($_GET["ticketType"]);

                        $sql = "SELECT ticket.eventTicketName, ticket.ticketType, ticket.price,
                                event.dateOfEvent, event.time, event.location FROM ticket
                                INNER JOIN event ON ticket.eventTicketName = event.eventName
                                WHERE ticket.eventTicketName = '$eventName' AND ticket.ticketType = '$ticketType'";

                        // Execute query
                        $result = $con->query($sql);

                        // Display data
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            echo '<p><strong>Event Name :</strong> ' . $row["eventTicketName"] . '</p>';
                            echo '<p><strong>Ticket Type :</strong> ' . $row["ticketType"] . '</p>';
                            echo '<p><strong>Price      :</strong> RM' . number_format($row["price"], 2) . '</p>';
                            echo '<p><strong>Event Date :</strong> ' . $row["dateOfEvent"] . '</p>';
                            echo '<p><strong>Event Time :</strong> ' . $row["time"] . '</p>';
                            echo '<p><strong>Location :</strong> ' . $row["location"] . '</p>';
                        }

                        // Close connection
                        $result->free();
                        $con->close();
                        ?>
                        <div class="footer">
                            <p>Please double check your order!</p>
                        </div>
                    </div>
                </div>
            </div>
            <form id="payment" method='post' action=''>
                <div class="container">
                    <div class="left">
                        <h1>Billing Address</h1>
                        <label>Username</label>
                        <input type="text" id="fnBox" name='name' value="<?php echo $uname ?>" placeholder="Enter Your Name"/>
                        <br><br>
                        <label>Email</label>
                        <input type="text" id="emailBox" name='email' onkeyup="validateEmail()" value="<?php echo $uemail ?>" placeholder="Enter Your Email"/>
                        <p id="emailError"></p>


                        <div class="input-box">
                            <label>Address</label>
                            <input type="text" id="inputBox" name="address" placeholder="Enter street address"/>
                            <input type="text" id="inputBox" name="address2" placeholder="Enter street address line 2"/>
                            <div class="column">
                                <input type="text" id="inputBox" name="country" placeholder="Enter your country"/>
                                <input type="text" id="inputBox" name="city" placeholder="Enter your city"/>
                            </div>
                            <div class="column">
                                <input id="region" type="text"  name="region" placeholder="Enter your region"/>                                                   
                                <input id="poscode" type="number" name="poscode" placeholder="Enter postal code"/>                   
                            </div>
                        </div>
                    </div>
                    <div class="right">
                    <button class='x' onclick="location = 'event.php'">×</button>
                    <h1>Payment Details</h1>

                    <br><br>
                    <label>Accepted Cards</label>
                    <br>
                    <img src="img/visa.png">
                    <img src="img/mastercard.png">
                    <img src="img/jcb.png">                        
                    <img src="img/paypal.png">
                    <br>
                    <label>Card Number</label><br>
                    <input type="text" name="cardNumber" id="cardNumberBox" onkeyup="checkCardNumber()" placeholder="Enter Your Card Number" value="<?php echo isset($cardNumber) ? $cardNumber : ''; ?>" required>
                    <p id="message"></p>

                    <br>

                    <label for="expMonth">Exp Month</label>
                    <select name="expMonth" class="monthBox" required>
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
                    </select>

                    <br><br>

                    <label>Exp year</label>
                    <select name="expYear" class="yearBox" required>
                        <option value="" >Year</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                    </select>
                    </label>


                    <br><br>
                    <label>
                        CVV  
                        <input id="cvvBox" name="cvv" class="cvv" type="number" onkeyup="checkCvvNumber()" placeholder="CVV" value="<?php echo isset($cvv) ? $cvv : ''; ?>" required>
                        <p id="response"></p>
                    </label>
                    <br><br>
                        <input id="submit" name="submit" type="submit" value="Proceed To Pay">
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>

<script>

    function checkCardNumber() {
        var cardNumberBox = document.getElementById("cardNumberBox");
        var message = document.getElementById("message");

        if (cardNumberBox.value.length == 16) {
            message.innerHTML = "Valid card number";
            cardNumberBox.style.borderColor = "green";
            message.style.backgroundColor = "#3ae374";
            message.style.top = "120%";
            return true;
        } else {
            message.innerHTML = "Not a valid card number";
            cardNumberBox.style.borderColor = "red";
            message.style.backgroundColor = "#ff4d4d";
            message.style.top = "120%";
            return false;
        }
    }

    function checkCvvNumber() {
        var cvvNumberBox = document.getElementById("cvvBox");
        var response = document.getElementById("response");

        if (cvvNumberBox.value.length == 3) {
            response.innerHTML = "Valid CVV number";
            cvvNumberBox.style.borderColor = "green";
            response.style.backgroundColor = "#3ae374";
            response.style.top = "120%";
            return true;
        } else {
            response.innerHTML = "Invalid CVV number";
            cvvNumberBox.style.borderColor = "red";
            response.style.backgroundColor = "#ff4d4d";
            response.style.top = "120%";
            return false;
        }
    }

    function validateEmail() {
        var emailField = document.getElementById("emailBox");
        var emailError = document.getElementById("emailError");

        if (!emailField.value.match(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/)) {
            emailError.innerHTML = "Please enter a valid email";
            emailField.style.borderColor = "red";
            emailError.style.backgroundColor = "#ff4d4d";
            emailError.style.top = "120%";
            return false;
        } else {
            emailError.innerHTML = "valid email";
            emailField.style.borderColor = "green";
            emailError.style.backgroundColor = "#3ae374";
            emailError.style.top = "120%";
            return true;
        }
    }
</script>
