<?php
session_start();
require_once 'helper.php';

// Check if the user is logged in
if (!isset($_SESSION['user_email'])) {
    header('Location: index.php');
    exit();
}

$user_email = $_SESSION['user_email'];

?>

<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Update User Acc Information</title>
        <link href="css/login-insert.css" rel="stylesheet" type="text/css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="css/header.css" rel="stylesheet" type="text/css"/>
        <link href="css/footer.css" rel="stylesheet" type="text/css"/>

        <style>
            body {
                background-color: #f0f0f0;
                margin-top: 120px;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }
            .profile-container {
                display: flex;
                padding-top: 20px;
                flex-direction: row; /* Force horizontal layout */
                flex-wrap: nowrap; /* Prevent wrapping to new line */
                gap: 20px;
                max-width: 1000px;
                margin: 0 auto;
                height: 450px;
            }

            /* Add this media query for mobile devices */
            @media (max-width: 768px) {
                .profile-container {
                    flex-direction: column; /* Switch to vertical on small screens */
                }
            }
            .profile-card {
                background-color: #333;
                color: white;
                border-radius: 10px;
                padding: 30px;
                text-align: center;
                width: 100%;
                max-width: 350px;
                align-content: center;
            }
            .profile-details {
                background-color: #333;
                color: white;
                border-radius: 10px;
                padding: 30px;
                padding-left: 10%;
                padding-right: 10%;
                width: 100%;
                flex-grow: 1;
                align-content: center;
                height: fit-content;
            }
            .detail-row {
                padding: 15px 0;
                border-bottom: 1px solid #444;
                display: flex;
            }
            .detail-row:last-child {
                border-bottom: none;
            }
            .detail-label {
                font-weight: 500;
                width: 150px;
            }
            .detail-value {
                color: #a0a0a0;
            }
            .changeBtn {
                display: flex;
                justify-content: center;
                margin-top: 20px; /* optional spacing */
            }
            .btnModify {
                font-size: 20px;
                padding: 6px 14px;
                border: none;
                background-color:rgb(0, 132, 255);
                color: white;
                border-radius: 15px;
                transition: all 0.3s ease-in-out;
                margin-right: 5px;
                text-decoration: none;
                display: inline-block;
            }
            .btnModify:hover {
                background-color:rgb(10, 86, 173);
                transform: scale(1.05);
            }
            .btnCancel {
                font-size: 20px;
                padding: 6px 14px;
                border: none;
                background-color:rgb(235, 0, 0);
                color: white;
                border-radius: 15px;
                transition: all 0.3s ease-in-out;
                margin-right: 5px;
                text-decoration: none;
                display: inline-block;
            }
            .btnCancel:hover {
                background-color:rgb(200, 0, 0);
                transform: scale(1.05);
            }
            input[type="radio"]:hover {
                cursor: pointer;
                transform: scale(1.2);
                
            }
        </style>
    </head>
    <body>
        <!-- Navbar -->
        <?php include 'headerUser.php'; ?>
        <!-- End of Navbar -->

        <p>&nbsp;</p>
        <h1>Update User Account Information</h1>
        <?php
            require_once 'helper.php';

            echo '<div class = "justify-content-center">';
            // Check if the user has clicked the modify button
            if (isset($_POST['btnModify'])) {

                $name2 = trim($_POST["name"]);
                $gender = isset($_POST['gender']) ? trim($_POST['gender']) : '';
                $password = $_POST["password"];
                $password2 = $_POST["password2"];

                //validation
                $error["name"] = checkName($name2);
                $error["password"] = checkPassword($password);
                $error["password2"] = checkPassword($password2);

                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                mysqli_set_charset($con, 'utf8');
                // Check if email already exists in the database
                $stmt = $con->prepare("SELECT COUNT(*) FROM user WHERE email = ?");
                $stmt->bind_param("s", $user_email);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_row();

                if (strcmp($password, $password2)!= 0) {
                    $error["password"] = "Password and Confirm Password Not Match.";
                }

                //remove null value
                $error = array_filter($error);

                if (empty($error)) {
                    //GOOD, no good,proceed to insert record 

                    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                    mysqli_set_charset($con, 'utf8');

                    //step 2:sql statement 
                    // Hash the password
                    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

                    $query = "UPDATE user SET username='$name2', gender='$gender', userPw='$hashedPassword' WHERE email='$user_email'";
                    $result = mysqli_query($con, $query);

                    // Check for errors
                    if (!$result) {
                        $error = "Failed to Update user: " . mysqli_error($con);
                    } else {
                        // Execute the SQL statement
                        if (mysqli_affected_rows($con) > 0) {
                            //record inserted 
                            echo "<script>
                                    alert('User has been updated.');
                                    window.location.href = 'profile.php';
                                </script>"
                            ;
                        } else {
                            //record unable to insert 
                            $error = "Failed to create user: no rows affected.";
                        }
                    }

                    // Close the database connection
                    mysqli_close($con);
                } else {
                    foreach ($error as $value) {
                        echo "<script>alert('$value');</script>";
                    }
                }
            } else {
                // Get the ID of the record from the URL
                $id = trim($_GET["id"]);

                // Retrieve the details of the record from th+e database
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                mysqli_set_charset($con, 'utf8');

                $sql = "SELECT * FROM user WHERE username = ?";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("s", $id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($row = $result->fetch_object()) {
                    $name = $row->username;
                    $email = $row->email;
                    $gender = $row->gender;
                    $password = $row->userPw;
                } else {
                    // Not good, display error msg
                    echo "<ul class='error'>";
                    foreach ($error as $value) {
                        echo "<li style='color: red;'>$value</li>";
                    }
                    echo "</ul>";
                }

                $result->free();
                $con->close();
            }
        ?>    
        <!--
        <div class="container">
            <form action="" method="POST">
                <table>
                    <tr>
                        <th>Username:</th>
                        <td><input type="text" name="name"  class="input-field" value="<?php echo isset($name) ? $name : ""; ?>"/></td>
                    </tr>

                    <tr>
                        <th>Email:</th>
                        <td><input type="email" name="email" class="input-field" value="<?php echo $user_email; ?>" disabled/></td>
                    </tr>

                    <tr>
                        <th>Gender:</th>
                        <td>  <input type="radio" name="gender" class="male" value="M" required> Male</td>
                        <td> <input type="radio" name="gender" class="female"  value="F" required> Female</td>
                    </tr>

                    <tr>
                        <th>Password:</th>
                        <td><input type="password" name="password" class="input-field" value="<?php echo isset($password) ? $password : ""; ?>"/></td>
                    </tr>

                    <tr>
                        <th>Confirm Password:</th>
                        <td><input type="password" name="password2" class="input-field" value="<?php echo isset($password2) ? $password2 : ""; ?>"/></td>
                    </tr>
                    </table>
                    <br/>
                    <input type="submit" value="modify" name="btnModify" class="input-button" />
                    <input type="button" value="Cancel" name="btnCancel" class="input-button" onclick="location = 'profile.php'"/>
                </form>
            </div>
        </div>-->
       



        <form action="" method="POST">
            <div class="profile-container">
                <div class="profile-details">
                    <div class="detail-row">
                        <div class="detail-label">Name</div>
                        <div class="detail-value"><input type="text" name="name" style="margin-left: 100px;" class="input-field" value="<?php echo isset($name) ? $name : ""; ?> "/></div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Email</div>
                        <div class="detail-value"><div class="emailLabel" style="margin-left: 100px;"><?php echo htmlspecialchars($email); ?></div></div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Gender</div>
                        <div class="detail-value">
                            <input type="radio" style="margin-left: 100px;" name="gender" class="male" value="M" required> Male
                        </div>
                        <div class="detail-value">
                            <input type="radio" style="margin-left: 100px;" name="gender" class="female"  value="F" required> Female
                        </div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Password</div>
                        <div class="detail-value"><input type="password" style="margin-left: 100px;" name="password" class="input-field" value=""/></div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Confirm Password</div>
                        <input type="password" style="margin-left: 100px;" name="password2" class="input-field" value="<?php echo isset($password2) ? $password2 : ""; ?>"/>
                    </div>

                    <br/>
                    <div class="changeBtn">
                        <input type="submit" value="Modify" name="btnModify" class="btnModify" />
                        <input type="button" value="Cancel" name="btnCancel" class="btnCancel" onclick="location = 'profile.php'"/>
                    </div>
                </div>
            </div>
        </form>

        <p>&nbsp;</p>
        <p>&nbsp;</p>

        <!-- Footer -->
        <?php include 'footerUser.php'; ?>
        <!-- End Of Footer -->

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    </body>
</html>
