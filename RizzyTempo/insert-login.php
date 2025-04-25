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
       
      
        <meta charset="UTF-8">
        <title>Insert Login Information</title>
        <link href="css/login-insert.css" rel="stylesheet" type="text/css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<!--        <link href="css/login-insert.css" rel="stylesheet" type="text/css"/>-->
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
            /* === Delete Checked Button === */
            .action-delete {
                font-size: 14px;
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
            .action-delete:hover {
                background-color:rgb(200, 0, 0);
                transform: scale(1.05);
            }
            .action-create {
                margin-top: 20px;
                padding: 10px 20px;
                background-color: #00b383;
                color: white;
                border: none;
                border-radius: 10px;
                font-size: 16px;
                transition: all 0.2s ease-in-out;
            }
            .action-create:hover {
                background-color:#009970;
                transform: scale(1.05);
            }
            input[type="button"][name="btnCancel"] {
                margin-top: 20px;
                margin-left: 20px;
                padding: 10px 20px ;
                background-color: #dc3545;
                color: white;
                border: none;
                border-radius: 10px;
                font-size: 16px;
                transition: all 0.2s ease-in-out;
            }

            input[type="button"][name="btnDCancel"]:hover {
                background-color: #c82333;
                transform: scale(1.05);
            }
            input[type="radio"]:hover {
                cursor: pointer;
                transform: scale(1.5);
            }
        </style>

    </head>
    <body>
        <!-- Navbar -->
        <?php
        include 'headerAdmin.php';
        ?>
        <!-- End of Navbar -->

        <h1>&nbsp;</h1>

        <?php
        require_once 'helper.php';
        ?>

        <h1>Create New User</h1>

        <?php
        //check if the user click any button?
        if (empty($_POST)) {
            //USER never click anything
        } else {
            //Yes,user click on a button
            //retreive user input 
            //trim (ignore space)from user
            $name = trim($_POST["name"]);
            $email = trim($_POST["email"]);
            $gender = isset($_POST['gender']) ? trim($_POST['gender']) : '';
            $password = $_POST["password"];
            $password2 = $_POST["password2"];

            //validation
            $error["name"] = checkName($name);
            $error["email"] = checkEmail($email);
            $error["password"] = checkPassword($password);
            $error["password2"] = checkPassword($password2);

            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            mysqli_set_charset($con, 'utf8');
            // Check if email already exists in the database
            $stmt = $con->prepare("SELECT COUNT(*) FROM user WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_row();

            if ($row[0] > 0) {
                // Email already exists, display error message
                $error["email"] = "Email already exists in the database.";
            } else if ($password != $password2) {
                $error["password"] = "Password and Confirm Password Not Match.";
                echo "<script>window.location.href =insert-login.php';</script>";
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

                $query = "INSERT INTO user (username, email, gender, userPw) VALUES ('$name', '$email', '$gender', '$hashedPassword')";
                $result = mysqli_query($con, $query);

                // Check for errors
                if (!$result) {
                    $error = "Failed to create user: " . mysqli_error($con);
                } else {
                    // Execute the SQL statement
                    if (mysqli_affected_rows($con) > 0) {
                        echo "
<!-- Success Modal -->
<div class='modal fade' id='successModal' tabindex='-1' aria-labelledby='successModalLabel' aria-hidden='true'>
  <div class='modal-dialog modal-dialog-centered'>
    <div class='modal-content'>
      <div class='modal-header'>
        <h5 class='modal-title' id='successModalLabel'>User Created</h5>
        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
      </div>
      <div class='modal-body'>
        User <b>$name</b> has been successfully inserted.
      </div>
      <div class='modal-footer'>
        <a href='list-login.php' class='btn btn-primary'>Back to Login List</a>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    var modalElement = document.getElementById('successModal');
    if (modalElement) {
      var showModal = new bootstrap.Modal(modalElement);
      showModal.show();
    }
  });
</script>
";

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
        }
        ?>
      
<form action="" method="POST">
            <div class="profile-container">
                <div class="profile-details">
                    <div class="detail-row">
                        <div class="detail-label">Name</div>
                        <div class="detail-value"><input type="text" name="name" style="margin-left: 100px;" class="input-field" value="<?php echo isset($name) ? $name : ""; ?> "/></div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Email</div>
                        <div class="detail-value"><input type="email" name="email" class="input-field" style="margin-left:100px;" value="<?php echo isset($email) ? $email : ""; ?>"/></div>
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

                    <div class="changeBtn">
                    <input type="submit" value="Create User" name="btnCreate" class="action-create"/>&nbsp;
                        <input type="button" value="Cancel" name="btnCancel" class="action-delete" onclick="location = 'list-login.php'"/>
                    </div>
                </div>
            </div>
        </form>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>

        <!-- Footer -->
        <?php
        include 'footerAdmin.php';
        ?>
        <!-- End Of Footer -->

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>


    </body>
</html>