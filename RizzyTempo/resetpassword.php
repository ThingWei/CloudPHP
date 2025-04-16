<?php
// Include your database configuration file
require_once 'helper.php';

// Initialize variables for error messages
$emailError = $passwordError = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["Email"]);
    $password = trim($_POST["resetpassword"]);
    $confirmPassword = trim($_POST["confirmpassword"]);

    // Updated regex patterns
    $emailValidation = '/^\S+@\S+\.\S+$/';

    // Validate email
    if (!preg_match($emailValidation, $email)) {
        $emailError = "Invalid email format";
    }

    // Check if passwords match
    if ($password !== $confirmPassword) {
        $passwordError = "Passwords do not match";
    }

    // If no errors, proceed with database update
    if (empty($emailError) && empty($passwordError)) {
        // Create connection
        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        // Check connection
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }

        // Prepare the SQL statement
        $stmt = $con->prepare("UPDATE user SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $password, $email); // No hashing here

        // Execute the statement
        if ($stmt->execute()) {
            echo "Password reset successful.";
        } else {
            echo "Error updating record: " . $stmt->error;
        }

        // Close the statement and connection
        $stmt->close();
        $con->close();
    }
}
?>

<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Project/PHP/PHPProject.php to edit this template
-->
<html>

<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <style>
        @import url('https //fonts.googleapis.com/css family=poppins');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #020410;
            overflow: hidden;
        }

        .background {
            width: 100%;
            height: 100vh;
            background: url('img/background.png')no-repeat;
            background-repeat: cover;
            background-position: center;
            filter: blur(15px);
        }

        .container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 75%;
            height: 600px;
            background: url('img/background.png')no-repeat;
            background-size: cover;
            background-position: center;
            border-radius: 10px;
            margin-top: 20px;
        }

        .container .content {
            position: absolute;
            top: 0;
            left: 0;
            width: 70%;
            height: 100%;
            background: transparent;
            padding: 80px;
            color: #e4e4e4;
            display: flex;
            justify-content: space-between;
            flex-direction: column;
        }

        .logo {
            font-size: 70px;
            margin-left: -10px;
            color: transparent;
            -webkit-text-stroke: 1px #fff;
            background: url('img/back.png');
            -webkit-background-clip: text;
            background-position: 0 0;
            animation: back 20s linear infinite;
        }

        @keyframes back {
            100% {
                background-position: 2000px 0;
            }
        }

        .text-sci h2 {
            font-size: 40px;
            line-height: 1;
        }

        .text-sci h2 span {
            font-size: 25px;
        }

        .text-sci p {
            font-size: 20px;
            margin: 20px 0;
            word-spacing: 1.5px;
        }

        .social-icons a i {
            font-size: 22px;
            color: #e4e4e4;
            margin-right: 10px;
            transition: .5s ease;
        }

        .social-icons a:hover i {
            transform: scale(1.2);
        }

        .container .logreg-box {
            position: absolute;
            top: 0;
            right: 0;
            width: 40%;
            height: 100%;
            overflow: hidden;
        }

        .logreg-box .form-box {
            position: absolute;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100%;
            background: transparent;
            backdrop-filter: blur(20px);
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
            color: #e4e4e4;
        }

        .logreg-box .form-box.login {
            transform: translateX(0);
            transition: transform .6s ease;
            transition-delay: .7s;
        }

        .logreg-box.active .form-box.login {
            transform: translateX(430px);
            transition-delay: 0s;
        }


        .logreg-box .form-box.register {
            transform: translateX(430px);
            transition: transform .5s ease;
            transition-delay: 0s;
        }

        .logreg-box.active .form-box.register {
            transform: translateX(0);
            transition-delay: .7s;
        }

        .form-box h2 {
            font-size: 32px;
            text-align: center;
        }

        .form-box .input-box {
            position: relative;
            width: 340px;
            height: 50px;
            border-bottom: 2px solid #e4e4e4;
            margin: 20px 0;

        }


        .input-box input {
            width: 100%;
            height: 100%;
            background: transparent;
            border: none;
            outline: none;
            font-size: 16px;
            color: #e4e4e4;
            font-weight: 500;
            padding-right: 28px;

        }


        .input-box label {
            position: absolute;
            top: 40%;
            left: 0;
            transform: translateY(-40%);
            font-size: 16px;
            font-weight: 500;
            pointer-events: none;
            transition: .5s ease;
        }

        .input-box input:focus~label,
        .input-box input:valid~label {
            top: -5px;
        }



        .input-box .icon {
            position: absolute;
            top: 13px;
            right: 0;
            font-size: 19px;

        }

        .form-box .remember-forgot {
            font-size: 14.5px;
            font-weight: 500;
            margin: -15px 0 15px;
            display: flex;
            justify-content: space-between;
        }

        .remember-forgot label input {
            accent-color: #e4e4e4;
            margin-right: 3px;
        }

        .remember-forgot a {
            color: #e4e4e4;
            text-decoration: none;
        }

        .remember-forgot a:hover {
            text-decoration: underline;
        }

        .btn {
            width: 100%;
            height: 45px;
            background: #3d1602;
            border: none;
            outline: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            color: #e4e4e4;
            font-weight: 500;
            box-shadow: 0 0 10px rgba(0, 0, 0, .5);
        }

        .form-box .login-register {
            font-size: 14.5px;
            font-weight: 500;
            text-align: center;
            margin-top: 20px;

        }

        .login-register p a {
            color: #e4e4e4;
            font-weight: 600;
            text-decoration: none;
        }

        .login-register p a:hover {
            text-decoration: underline;
            color: blue;
        }

        html,
        body {
            width: 100vw;
            height: 100vh;
        }

        div {
            width: 100%;
            height: 100%
        }

        .captcha {
            width: 70%;
            background: black;
            text-align: center;
            font-size: 24px;
            font-weight: 700;

        }

        .form-box.register {
            padding-left: 40px;
        }

        .form-box.register .btn {
            width: 90%;
        }

        .form-box.register .btn:hover {
            background-color: lawngreen;
        }

        .form-box.login .btn:hover {
            background-color: lawngreen;
        }

        .col-md-6.form-group {
            left: -15px;
        }
    </style>
</head>

<body>
    <div class="background"></div>

    <div class="container">
        <div class="content">
            <p>&nbsp;</p>

            <h2 class="logo">RT Music Society</h2>

            <p>&nbsp;</p>
            <p>&nbsp;</p>

            <div class="text-sci">
                <h2><b>Welcome</b><br><span>to Join Our Music Society!</span></h2>
                <p>Music can't live without you</p>
            </div>
        </div>


       <div class="logreg-box">
            <div class="form-box login">
                <form action="loginSignUp.php" method="POST">
                    <h2>Reset Password</h2>
                    <div class="input-box">
                        <span class="icon"></span>
                        <input type="email" name="Email" required>
                        <label>Email</label>
                    </div>
                    <div class="input-box">
                        <span class="icon"></span>
                        <input type="password" name="resetpassword" required>
                        <label>Reset Password</label>
                    </div>
                    <div class="input-box">
                        <span class="icon"></span>
                        <input type="password" name="confirmpassword" required>
                        <label>Confirm Password</label>
                    </div>
                    <button type="submit" class="btn">Reset Password</button>
                    <div class="login-register">
                        <p>Don't have an account? <a href="loginSignUp.php" class="register-link">Sign up</a></p>
                    </div>
                </form>
                <?php
                if (!empty($emailError)) {
                    echo "<div class='alert alert-danger'>$emailError</div>";
                }
                if (!empty($passwordError)) {
                    echo "<div class='alert alert-danger'>$passwordError</div>";
                }
                ?>
            </div>
        </div>
    </div>
        <script src="form-validation.js"></script>
</body>



</html>
<script>
document.getElementById('resetPasswordForm').addEventListener('submit', function(event) {
    var email = document.getElementById('Email').value;
    var password = document.getElementById('resetpassword').value;
    var confirmPassword = document.getElementById('confirmpassword').value;

    if (!email.match(/^\S+@\S+\.\S+$/)) {
        alert("Please enter a valid email address.");
        event.preventDefault(); // Prevent form submission
    }

    if (password.length < 10) {
        alert("Password must be at least 10 characters long.");
        event.preventDefault(); // Prevent form submission
    }

    if (password !== confirmPassword) {
        alert("Passwords do not match.");
        event.preventDefault(); // Prevent form submission
    }
});
</script>
