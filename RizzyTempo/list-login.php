<?php
session_start();
require_once 'helper.php';

// Check if the user is logged in
if (!isset($_SESSION['admin_email'])) {
    header('Location: index.php');
    exit();
}

//create associative array 
//key - DT table column name
//value - display test in the html table <th>
$header = array(
    "username" => "User Name",
    "email" => "Email",
    "gender" => "Gender",
    "userPw" => "Password"
);

//retrieve order, sort from URL
if (empty($_GET)) {
//URL has no parameter
    $sort = "username";
    $order = "ASC";
    $program = "%";
} else {
//NOT empty ,URL contain parameter
    $sort = $_GET["sort"];
    $order = $_GET["order"];
    $program = $_GET["program"];
}
?>

<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
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
        <title>User List</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <!--        <link href="css/list-login.css" rel="stylesheet" type="text/css"/>-->
        <link href="css/header.css" rel="stylesheet" type="text/css"/>
        <link href="css/footer.css" rel="stylesheet" type="text/css"/>

        <style>
            container{
                display: block;
                margin-left:auto;
                margin-right:auto;
            }

            table ,th ,td{
                border: 1px solid black;
                /* remove posipxon: absolute; as it's not necessary */
                align-items: center;
                font-size:18px;
                padding:10px;
            }

            th {
                background-color: black;
            }

            th a{
                color:white;
            }

            tr:nth-child(even) {
                background-color: #f2f2f2;
            }

            tr:nth-child(odd) {
                background-color: white;
            }

            h1{
                text-align: center;
            }

            .button{
                height:40px;
                border-radius:20px;
                border-spacing:5px;
                margin-left:200px;
                font-size:20px;

            }

            .button:hover{
                background-color: #00b383;
            }

            img{
                width:30px;
                height:30px;
            }
        </style>

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
                                <a class="nav-link active mx-lg-2" style="color:white" href="list-login.php">User List</a>
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

        <?php
        require_once 'helper.php';
        ?>
        <h1>List User Account Detail</h1>

        <?php
        //check if the user click on the delete button?
        if (isset($_POST["btnDelete"])) {
            //yes ,user click on the delete button
            //retrieve studentID from the checkbox
            if (isset($_POST["checkDelete"])) {
                $checked = $_POST["checkDelete"];
            } else {
                $checked = null;
            }

            if (!empty($checked)) {
                // Connect to the database
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                mysqli_set_charset($con, 'utf8');

// escape the names to prevent SQL injection
                $escaped = array_map(function ($checked) use ($con) {
                    return $con->real_escape_string($checked);
                }, $checked);

// build the SQL query
                $sql = "DELETE FROM user WHERE username IN('" . implode("','", $escaped) . "')";

// execute the query
                if ($con->query($sql) === TRUE) {
                    echo '<div class = "d-flex justify-content-center">Records deleted successfully</div>';
                } else {
                    echo "Error deleting records: " . $con->error;
                }
            }
        }
        ?>
        <div class = "d-flex justify-content-center">
            <div class="container"  style="overflow: auto;white-space: wrap; margin-left: 150px">
                <form action="" method="POST">
                    <table border="1" cellpadding="5" cellspacing="0">
                        <tr>
                            <th></th>
                            <?php
                            foreach ($header as $key => $value) {
                                if ($key == $sort) {
                                    //check if the user sort based on
                                    //a specific column?
                                    printf("<th>
                                <a href='?sort=%s&order=%s&program=%s'>%s</a>
                                <img src='img/%s'/>
                                </th>", $key, ($order == 'ASC') ? "DESC" : "ASC",
                                            $program,
                                            $value,
                                            ($order == 'ASC') ? 'asc.png' : 'desc.png');
                                } else {
                                    //default ,the page run for the first time ,user never click to sort thee record
                                    printf("<th>
                            <a href='?sort=%s&order=ASC&program=%s'>%s</a>
                                
                                </th>", $key, $program, $value);
                                }
                            }
                            ?>
                            <th></th>
                        </tr>

                        <?php
                        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                        mysqli_set_charset($con, 'utf8');

//NOTE:
//-> will only appear and used in database access
//=> used in associative array
                        if ($con->connect_error) {
                            die("Connection failed: " . $con->connect_error);
                        }

//sql statement
//SELECT * FROM Student ORDER BY StudentName ASC;
                        $sql = "SELECT * FROM user 
                            WHERE username LIKE '$program'
                            ORDER BY $sort $order";

//ask coonection to run sql query 
                        $result = $con->query($sql);

                        if ($result->num_rows > 0) {
                            //record found
                            //why while loop? while i can still access the record
                            //we will retreive 
                            //fetch_object() - take record 1 by 1 from $result 

                            while ($row = $result->fetch_object()) {
                                printf("
                                <tr>
                                <td><input type='checkbox' name='checkDelete[]' value='%s' /></td>
                                <td>%s</td> 
                                <td>%s</td>
                                <td style='text-align:center'>%s</td>
                                <td>%s</td>
                                            
                                <td>
                                <a href='delete-login.php?id=%s'>Delete</a>
                                </td>
                                
                                </tr>
                                    ", $row->username //for checkBox
                                        , $row->username
                                        , $row->email
                                        , $row->gender
                                        , $row->userPw
                                        , $row->username //query string
                                );
                            }
                            printf("<tr><td colspan='7'>%d record(s) returned .</td></tr>", $result->num_rows);

                            $result->free();
                            $con->close();
                        } else {
                            //no record return
                        }
                        ?>

                    </table>
                    <br/>
                    <input style="padding-left:5px;padding-right:5px;" type="submit" value="Deleted Checked" name="btnDelete" class="button" onclick="confirm('This will delete all checked records.\nAre you sure?')"/>
                    <input style="padding-left:5px;padding-right:5px;" type="button" value="Create new user account" name="btnInsert" class="button" onclick="location.href = 'insert-login.php';"/>
                </form>
            </div>
        </div>

        <h1>&nbsp;</h1>

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
