<?php
session_start();
require_once 'helper.php';

// Check if the user is logged in
if (!isset($_SESSION['user_email'])) {
    header('Location: index.php');
    exit();
}

$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$useremail = $_SESSION['user_email'];

$sql = "SELECT * FROM user WHERE email = '$useremail'";
$result = $con->query($sql);
if ($row = $result->fetch_object()) {
    $uname = $row->username;
    $uemail = $row->email;
    $ugender = $row->gender;
}

$result->free();
?>

<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Feedback</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="css/header.css" rel="stylesheet">
        <link href="css/footer.css" rel="stylesheet">
        <link href="css/feedback.css" rel="stylesheet">
        <style>
            .navbar {
                box-sizing: content-box;
            }

            body {
                background: url(img/musicbg.jpg) no-repeat center;
                background-size: cover;
                width: 100%;
            }

            .img {
                width: 20px;
                height: 20px;
            }
            .error, .info
            {
                padding: 5px;
                margin: 5px;
                font-size: 0.9em;
                list-style-position: inside;
            }

            .error
            {
                border: 2px solid #FBC2C4;
                background-color: #FBE3E4;
                color: #8A1F11;
            }

            .info
            {
                border: 2px solid #92CAE4;
                background-color: #D5EDF8;
                color: #205791;
            }
        </style>
    </head>

    <body>

        <!-- Navbar -->
        <?php
        include 'headerUser.php';
        ?>
        <!-- End of Navbar -->

        <?php
        require_once 'helper.php';
        ?>
        <p class="gap">&nbsp;</p>
        <p class="gap">&nbsp;</p>


        <form action="" method="POST">
            <div class="feedback-container" style="width:700px;height:900px;background-color:white;margin:auto;">
                <h1>Please Give Your Feedback</h1>
                <p><b>Your Feedback Is Important For Us</b></p>

                <?php
//handle form submission
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    //retrieve other fields from the form
                    $rating = isset($_POST["rate"]) ? $_POST["rate"] : null;
                    $name = trim($_POST["txtUsername"]);
                    $email = trim($_POST["txtEmail"]);
                    $description = trim($_POST["txtDescription"]);

                    //Validation form inputs
                    $error["rate"] = checkRating($rating);
                    $error["username"] = checkUsername($name);
                    $error["email"] = checkingEmail($email);
                    $error["description"] = checkDescription($description);

                    //remove empty error messages
                    $error = array_filter($error);

                    if (empty($error)) {
                        //if validation successful , process the form
                        insertFeedbackData($rating, $name, $email, $description);
                        echo "<div class='success-message' style=\"color:blue;\">Feedback Submited Successfully</br></div>";
                    } else {
                        //display error messages 
                        echo "<ul class='error'>";
                        foreach ($error as $value) {
                            echo "<li>$value</li>";
                        }
                        echo "</ul>";
                    }
                }
                ?>

                <!-- form field  -->
                <div class="center">
                    <div class="stars">
                        <input type="radio" id="five" name="rate" value="5">
                        <label for="five"></label>
                        <input type="radio" id="four" name="rate" value="4">
                        <label for="four"></label>
                        <input type="radio" id="three" name="rate" value="3">
                        <label for="three"></label>
                        <input type="radio" id="two" name="rate" value="2">
                        <label for="two"></label>
                        <input type="radio" id="one" name="rate" value="1">
                        <label for="one"></label>
                    </div>
                </div>
                <div class="info-field">
                    <div class="name">
                        <label for="name">Username</label>
                        <input type="text" id="username" name="txtUsername" value="<?php echo $uname ?>" maxlength="50" placeholder="Tan Ah Gaw" />
                    </div>
                    <div class="email">
                        <label for="email">Email</label>
                        <input type="text" id="emailaddress" name="txtEmail" value="<?php echo $uemail ?>" maxlength="50" placeholder="tanahgaw@example.com"  />
                        <br/>
                    </div>
                    <div>
                        <label for="review" style= "position:relative;font-weight:bold;
                               font-size:1rem;margin-bottom:0.5rem;">
                            Please Give Your Review</label>
                        <textarea id="textarea" rows="6" cols="20" name="txtDescription" maxlength="300"
                                  placeholder="Rizzy Tempo Music Society website are user-friendly to use..."></textarea>
                        <br/>
                    </div>
                    <div class="condition">
                        <input type="radio" id="accept" value="accept" method="POST">
                        <label for="accept">I accept the <a href="condition.php">terms and conditions</a></label><br>
                    </div>
                    <div style="display: flex; justify-content: center;">
                        <input type="submit" name="btnSubmit" style="padding:10px 20px;font-size:20px;background-color:#1c84ff;color:#fff;
                               border:none;border-radius:5px;cursor:pointer;width:200px;margin-bottom:50px;
                               margin-top:30px;box-shadow: 2.5px 3.5px 4px #828282;margin-right:10px;"/>
                        <input type="reset" name="btnReset" onclick="location = 'feedback.php'"
                               style="padding:10px 20px;font-size:20px;background-color:#1c84ff;color:#fff;
                               border:none;border-radius:5px;cursor:pointer;width:200px;margin-bottom:50px;
                               margin-top:30px;box-shadow: 2.5px 3.5px 4px #828282; margin-left: 30px;"/>

                    </div>


                </div>
            </div>
        </form>
        <p class="gap">&nbsp;</p>

        <!-- Footer -->
        <?php
    include 'footerUser.php';
    ?>
        <!-- End Of Footer -->

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    </body>

</html>