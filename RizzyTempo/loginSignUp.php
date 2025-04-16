<?php
session_start();
require_once 'helper.php';

$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$rand = rand(9999, 1000);
if (isset($_REQUEST['login'])) {
    $captcha = $_REQUEST['captcha'];
    $captcharandom = $_REQUEST['captcha-rand'];

    if ($captcha != $captcharandom) {
        ?>
        <script type="text/javascript">
            alert("Invalid captcha value");
        </script>
        <?php
    } else {
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $pwd = mysqli_real_escape_string($con, $_POST['password']);
        $select_query = mysqli_query($con, "select * from user where email='$email' and userPw='$pwd'");
        $result = mysqli_num_rows($select_query);
        if ($result > 0) {
            ?>
            <script type="text/javascript">
                alert("Login success");
                document.location.href = 'home.php';
            </script>
            <?php
        } else {
            ?>
            <script type="text/javascript">
                alert("Invalid email or password");
            </script>
            <?php
        }
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
        <title>Sign Up - Log In</title>
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

            <!--login-->
            <div class="logreg-box">
                <div class="form-box login">
                    <form action="login.php" method="post">
                        <h2>Sign In</h2>

                        <div class="input-box">
                            <span class="icon"></span>
                            <input type="email" name="loginEmail" id="loginEmail" required>
                            <label>Email</label>

                        </div>

                        <div class="input-box">
                            <span class="icon"></span>
                            <input type="password" name="loginPassword" id="loginPassword" required>
                            <label>Password</label>
                        </div>

                        <div class="remember-forgot">
                            <label><input type="checkbox">Remember me</label>
                            <a href="resetpassword.php">Forgot password?</a>
                        </div>

                        <input type="submit" class="btn" value="Submit"/>

                        <div class="login-register">
                            <p>Don't have an account?  <a href="#" class="register-link">Sign up</a></p>
                        </div>
                    </form>
                </div>

                <!--register-->
                <div class="form-box register">
                    <form method="post" action="users.php" id="myForm">
                        <h2>Sign Up</h2>

                        <div class="input-box">
                            <span class="icon"></span>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo isset($name) ? $name : ""; ?>" required>
                            <label>Username</label>
                        </div>

                        <div class="input-box">
                            <span class="icon"></span>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($email) ? $email : ""; ?>"required>
                            <label>Email</label>
                        </div>

                        <div>
                            <label style="font-weight: 500;font-size: 16px;">Gender</label> &nbsp;&nbsp;&nbsp;
                            <span class="icon"></span>
                            <input type="radio" name="rbgender" value="M"> Male &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" name="rbgender" value="F"> Female
                        </div>

                        <div class="input-box" style="margin-top:0px">
                            <span class="icon"></span>
                            <input type="password" id="password" name="password"  required>
                            <label>Password</label>

                        </div>

                        <div class="input-box">
                            <span class="icon"></span>
                            <input type="password" id="password2" name="password2" onkeyup="checkPassword()" required>
                            <label>Confirm Password</label>
                            <p id="message"></p>

                        </div>

                        <div class="col-md-6 form-group">
                            <label for="captcha">Captcha</label>
                            <input type="text" name="captcha" id="captcha" placeholder="Enter Captcha" required class="form-control"/>
                            <input type="hidden" name="captcha-rand" value="<?php echo $rand; ?>">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="captcha-code">Captcha Code</label>
                            <div class="captcha"><?php echo $rand; ?></div>
                        </div>

                        <div class="remember-forgot">
                            <label><input type="checkbox">I agree to the terms & conditions</label>
                        </div>


                        <input type="submit" class="btn" value="Submit"/>

                        <div class="login-register">
                            <p>Already have an account?  <a href="#" class="login-link">Log in</a></p>
                        </div>

                    </form>
                </div>
            </div>

</html>

<script>
    const logregBox = document.querySelector('.logreg-box');
    const loginLink = document.querySelector('.login-link'); // Corrected variable name
    const registerLink = document.querySelector('.register-link'); // Corrected variable name

    registerLink.addEventListener('click', () => {
        logregBox.classList.add('active');
    });

    loginLink.addEventListener('click', () => { // Corrected event listener variable
        logregBox.classList.remove('active');
    });





    function checkPassword() {
        let password = document.getElementById("password").value;
        let confirmPassword = document.getElementById("password2").value;
        console.log(password, confirmPassword);
        let message = document.getElementById("message");

        if (password.length != 0) {
            if (password == confirmPassword) {
                message.textContent = "Passwords match";
                message.style.color = "#3ae374";
            } else {
                message.textContent = "Password dont't match";
                message.style.color = "#ff4d4d";
            }
        } else {
            alert("Password can't be empty!");
            message.textContent = "";
        }
    }
</script>