<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>  
    <body>
        <?php
        require_once 'helper.php';
// Connect to the database
        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        mysqli_set_charset($con, 'utf8');

// Check connection
        if (!$con) {
            die("Connection failed: " . mysqli_connect_error());
        }

// Get the user input from the form
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $gender = trim($_POST['rbgender']);
        $password = trim($_POST['password']);
        $password2 = trim($_POST['password2']);

// Validate user input
        if ($password != $password2) {
            echo "<script>alert('Password and confirm password do not match.');</script>";
            echo "<script>window.location.href = 'loginSignUp.php';</script>";
        } else {
            // Check if the email address already exists in the database
            $stmt = $con->prepare("SELECT * FROM user WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo "<script>alert('Email address already exists.');</script>";
                echo "<script>window.location.href = 'loginSignUp.php';</script>";
            } else {
                // Insert the user's data into the database
                $stmt = $con->prepare("INSERT INTO user (username, email, gender, userPw) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $name, $email, $gender, $password);
                $username = $_POST['name'];
                $email = $_POST['email'];
                $password = password_hash($password, PASSWORD_DEFAULT);

                if ($stmt->execute()) {
                    echo "<script>alert('Account has been created.');</script>";
                    echo "<script>window.location.href = 'loginSignUp.php';</script>";
                } else {
                    echo "<p style='color: red;'>Error: " . mysqli_error($con) . "</p>";
                }
            }
        }

// Close the database connection
        $con->close();
        ?>
    </body>
</html>