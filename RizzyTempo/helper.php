<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "music_society");

function checkEventName($eventname) {
    if ($eventname == null) {
        return "Please fill in <b>Product Name</b>. ";
    }
}

function checkHeadline($headline) {
    if ($headline == null) {
        return "Please fill in <b>Headline</b> for this Product. ";
    }
}

function checkDesc($description) {
    if ($description == null) {
        return "Please fill in <b>Description</b> for this Product. ";
    }
}

function checkBanner($banner) {
    if ($banner == null) {
        return "Please Drop an <b>Event Banner</b> for this Product. ";
    }
}

function checkProductPrice($productprice) {
    if ($productprice == null) {
        return "Please input <b>price</b> for this Product. ";
    }
}

function checkProductType($producttype) {
    if ($producttype == null) {
        return "Please input <b>time</b> for this Product. ";
    }
}


// Function to return all gender options
function getGender() {
    return array(
        "M" => "Male👨",
        "F" => "Female👧"
    );
}

function checkUpUsername($newname) {
    if ($newname == null) {
        return "Please input a <b>name</b>.";
    }
}

function checkUpEmail($newemail) {
    if ($newemail == null) {
        return "Please Enter An <b>Email</b>.";
    } else if (!preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/", $newemail)) {
        return "Invalid <b>Email</b> format.";
    }
}

// Function to check if a user is a member
function isMember($name) {
    // Create a database connection
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare a SQL statement to select the user with the given ID
    $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->bind_param("s", $name);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if the user exists and is a member
    if ($result->num_rows > 0) {
        // Fetch the user data
        $userData = $result->fetch_assoc();
        $stmt->close();
        $conn->close();
        return true;
    } else {
        // Not a member
        $stmt->close();
        $conn->close();
        return false;
    }
}

// Function to check if a user ID exists in the volunteer table
function checkUserIdExistsInVolunteer($name) {
    // Create a database connection
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare a SQL statement to select the user with the given ID
    $stmt = $conn->prepare("SELECT * FROM volunteer WHERE username = ?");
    $stmt->bind_param("s", $name);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if the user ID exists
    if ($result->num_rows > 0) {
        $stmt->close();
        $conn->close();
        return true;
    } else {
        $stmt->close();
        $conn->close();
        return false;
    }
}

// Function to insert volunteer data into the database
function insertVolunteerData($name, $gender, $email) {
    // Create a database connection
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare a SQL statement to insert data into the volunteer table
    $stmt = $conn->prepare("INSERT INTO volunteer (username, gender, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $gender, $email);

    // Execute the statement
    $stmt->execute();

    // Check if the record was inserted successfully
    if ($stmt->affected_rows > 0) {
        echo "";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}

// Function to validate a user ID
function checkUserId($id) {
    if ($id == null) {
        return "Please Enter Your <b>User ID</b>.";
    } else if (!preg_match('/^MS\d{3}$/', $id)) {
        return "Invalid <b>User ID</b>, Please Try Again";
    }
}

// Function to validate a username
function checkUsername($name) {
    if ($name == null) {
        return "Please enter your <b>Username</b>.";
    } else if (strlen($name) > 30) {
        return "Your <b>Username</b> exceeded 30 characters.";
    } else if (!preg_match('/^[A-Za-z @\.]+$/', $name)) {
        return "Invalid <b>Username</b>.";
    }
}

// Function to validate a gender
function checkGender($gender) {
    if ($gender == null) {
        return "Please Select Your <b>Gender</b>.";
    } else if (!array_key_exists($gender, getGender())) {
        return "Invalid <b>Gender</b>.";
    }
}

function insertFeedbackData($rating, $name, $email, $description) {
    //create a database connection 
    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    //check the connection
    if ($con->connect_error) {
        die("Connection failed:" . $con->connect_error);
    }

    //prepare sql statement
    $stmt = $con->prepare("INSERT INTO feedback(rating,username,email,description) VALUES (?,?,?,?)");

    //bind parameters and execute the statement
    $stmt->bind_param("isss", $rating, $name, $email, $description);

    //execute the statement
    $stmt->execute();

    //check if the record was insert successful
    if ($stmt->affected_rows > 0) {
        echo "";
    } else {
        echo "Error:" . $stmt->error;
    }
    //close th statement and connect
    $stmt->close();
    $con->close();
}

// Function to validate a rating
function checkRating($rating) {
    if ($rating == null) {
        return "Please Select Your <b>Rating</b>.";
    } else if (!is_numeric($rating) || $rating < 1 || $rating > 5) {
        return "Invalid <b>Rating</b>. Please Select a Rating between 1 and 5.";
    }
}

// Function to validate an email address
function checksEmail($email) {
    if ($email == null) {
        return "Please Enter Your <b>Email.</b>";
    } else if (strlen($email) > 30) {
        return "Your <b>Email</b> exceeded 30 characters.";
    } else if (!preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/", $email)) {
        return "Invalid <b>Email</b>.";
    }
}

//Function to validate a description
function checkDescription($description) {
    if ($description == null) {
        return "Please Enter Your <b>Description</b>.";
    } else if (strlen($description) > 300) {
        return "Your <b>Description</b> exceeded 300 characters.";
    }
}

// Function to retrieve ticket data based on event name
function getTicket($eventTicketName) {
    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    $stmt = $con->prepare("SELECT * FROM ticket WHERE eventTicketName = ?");
    $stmt->bind_param("s", $eventTicketName);
    $stmt->execute();
    $result = $stmt->get_result();

    $tickets = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tickets[] = $row;
        }
    }

    $stmt->close();
    $con->close();

    return $tickets;
}

function checkEventTicketName($eventTicketName) {
    return empty($eventTicketName) ? "Please enter your <b>Event Name</b>." : null;
}

function checkTicketType($ticketType) {
    return empty($ticketType) ? "Please enter the <b>Ticket Type</b>." : null;
}

function checkTicketPrice($price) {
    return empty($price) ? "Please enter the <b>Price</b>." : null;
}

// Function to get all tickets from the database
function getAllTickets() {
    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    $sql = "SELECT * FROM ticket"; // Adjust the table name and columns as per your database
    $result = $con->query($sql);

    $tickets = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tickets[] = $row;
        }
    }

    $con->close();
    return $tickets;
}

//check Student Name...................
function checkName($name) {
    if ($name == null) {
        return "Please enter your Name.";
    } else if (strlen($name) > 30) {
        return"Your <b>Name</b> exceeded 30 character.";
    } else if (!preg_match('/^[A-Za-z @\.]+$/', $name)) {
        return "Invalid name";
    }
}

function checkingEmail($email) {
    if ($email == null) {
        return "Please enter your <b>email</b>. ";
    } else if (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i', $email)) {
        return"Invalid <b>email format</b>,please try again.";
    }
}

function checkEmail($email) {
    if ($email == null) {
        return "Please enter your <b>email</b>. ";
    } else if (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i', $email)) {
        return"Invalid <b>email format</b>,please try again.";
    } else if (checkSameEmail($email) == true) {
        //check duplicated student id
        return "Same <b>email format</b> detected!";
    }
}

function checkEmail3($email) {
    if ($email == null) {
        return "Please enter your <b>email</b>. ";
    } else if (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i', $email)) {
        return"Invalid <b>email format</b>,please try again.";
    } else if (checkSameEmail($email) == false) {
        //check duplicated student id
        return "Unable to find this email from database";
    }
}

function checkEmail2($email) {
    if ($email == null) {
        return "Please enter your email. ";
    } else if (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i', $email)) {
        return"Invalid email format,please try again.";
    }
}

//function to check SAME email 
function checkSameEmail($email) {
    $exist = false;
    //create connection
    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $sql = "SELECT * FROM user WHERE email ='$email'";

    //ASK help from DB to run the sql
    if ($result = $con->query($sql)) {
        if ($result->num_rows > 0) {
            //Record found
            $exist = true;
        }
    }
    $result->free();
    $con->close();
    return $exist;
}

function checkPassword($password) {
    if ($password == null) {
        return "Please enter your <b>password</b>.";
    } else if (strlen($password) < 8) {
        return "Your <b>password</b> must be at least 8 characters long.";
    } else if (!preg_match('/[a-z]/', $password)) {
        return "Your <b>password</b> must contain at least one lowercase letter.";
    } else if (!preg_match('/\d/', $password)) {
        return "Your <b>password</b> must contain at least one digit.";
    } else if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
        return "Your <b>password</b> must contain at least one special character.";
    }
}

function checkAddress($address) {
    if ($address == null) {
        return "Please enter your Address.";
    } else if (strlen($address) > 20) {
        return"Your Address exceeded 30 character.";
    } else if (!preg_match('/[A-Za-z0-9 ]/', $address)) {
        return "Invalid address";
    }
}

function checkAddress2($address2) {
    if ($address2 == null) {
        return "Please enter your Address.";
    } else if (strlen($address2) > 20) {
        return"Your Address exceeded 30 character.";
    } else if (!preg_match('/[A-Za-z0-9 ]/', $address2)) {
        return "Invalid address";
    }
}

function checkCountry($country) {
    if ($country == null) {
        return "Please enter your Country.";
    } else if (strlen($country) > 15) {
        return"Your Country Name exceeded 15 character.";
    } else if (!preg_match('/[A-Za-z ]/', $country)) {
        return "Invalid Country Name Format (No numbers allowed)";
    }
}

function checkCity($city) {
    if ($city == null) {
        return "Please enter your City.";
    } else if (!preg_match('/[A-Za-z ]/', $city)) {
        return "Invalid City Name Format (No numbers allowed)";
    }
}

function checkRegion($region) {
    if ($region == null) {
        return "Please enter your Region.";
    } else if (!preg_match('/[A-Za-z ]/', $region)) {
        return "Invalid Region Name Format (No numbers allowed)";
    }
}

function checkPoscode($poscode) {
    if ($poscode == null) {
        return "Please enter your postcode.";
    } else if (strlen($poscode) > 5) {
        return"Your postcode exceeded 5 character.";
    }
}

function checkExistEmail($existEmail) {

    // Check if the email address already exists in the database
    $stmt = $con->prepare("SELECT * FROM payment WHERE email = ?");
    $stmt->bind_param("s", $existEmail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Email address already exists.');</script>";
        echo "<script>window.location.href = 'insert-payment.php';</script>";
    }
}

function checkCardNumber($cardNumber) {
    if (!strlen($cardNumber) == 16) {
        // Card number does not have a valid length
        return 'Invalid card number';
    }
}

function checkCVV($cvv) {
    if (!strlen($cvv) == 3) {
        // Card number does not have a valid length
        return 'Invalid CVV';
    }
}
