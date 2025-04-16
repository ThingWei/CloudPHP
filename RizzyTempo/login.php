<?php
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
    </head>
    <body>
        <?php
        require_once 'helper.php';

// Connect to the database
        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        mysqli_set_charset($con, 'utf8');

// Check connection
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }

// Get the user input from the form
        $loginEmail = isset($_POST['loginEmail']) ? $_POST['loginEmail'] : '';
        $loginPassword = isset($_POST['loginPassword']) ? $_POST['loginPassword'] : '';

        $email = filter_var($loginEmail, FILTER_SANITIZE_EMAIL);
        $password = $loginPassword; // Don't sanitize the password, it will be hashed
// Prepare the SQL statements
        $sql1 = $con->prepare("SELECT * FROM user WHERE email= ?");
        $sql1->bind_param("s", $email);

        $sql2 = $con->prepare("SELECT * FROM admin WHERE email= ?");
        $sql2->bind_param("s", $email);

// Execute the queries
        $sql1->execute();
        $result1 = $sql1->get_result();

        $sql2->execute();
        $result2 = $sql2->get_result();

// Initialize a flag to check if login was successful
        $loginSuccess = false;

// Check if the email exists in the user table
        if ($result1->num_rows > 0) {
            $row = $result1->fetch_assoc();
            $hashedPassword = $row['userPw']; // Retrieve the hashed password from the database
            $username = $row['username'];
            
            // Compare the entered plain text password with the retrieved hashed password
            if (password_verify($password, $hashedPassword)) {
                // Password is correct, redirect to the next page
                $_SESSION['user_email'] = $email;
                echo "<script>alert('Login Successful, welcome back $username.');document.location.href='home.php';</script>";
                $loginSuccess = true;
            } else {
                // Password is incorrect
                echo "<script>alert('Invalid password for email: $loginEmail');document.location.href='loginSignUp.php';</script>";
                $loginSuccess = true; // To stop further processing after alert
            }
        }

// Check if the email exists in the admin table, only if login wasn't successful yet
        if (!$loginSuccess && $result2->num_rows > 0) {
            $row = $result2->fetch_assoc();
            $hashedPassword = $row['adminPw']; // Retrieve the hashed password from the database
            $adminName = $row['adminName'];
            
            // Compare the entered plain text password with the retrieved hashed password
            if (password_verify($password, $hashedPassword)) {
                // Password is correct, redirect to the next page
                $_SESSION['admin_email'] = $email;
                echo "<script>alert('Login Successful, welcome back $adminName.');document.location.href='homeAdmin.php';</script>";
                $loginSuccess = true;
            } else {
                // Password is incorrect
                echo "<script>alert('Invalid password for email: $loginEmail');document.location.href='loginSignUp.php';</script>";
                $loginSuccess = true; // To stop further processing after alert
            }
        }

// If login was not successful
        if (!$loginSuccess) {
            echo "<script>alert('Email not found: $loginEmail');document.location.href='loginSignUp.php';</script>";
        }

// Close the database connection
        mysqli_close($con);
        ?>
    </body>
</html>