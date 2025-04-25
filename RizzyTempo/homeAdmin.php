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
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Welcome to TARUMT Graduation Service</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined"
              rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="css/adminhome.css" rel="stylesheet" type="text/css"/>
        <link href="css/header.css" rel="stylesheet" type="text/css"/>
        <link href="css/footer.css" rel="stylesheet" type="text/css"/>
        <style>
            .navbar {
                box-sizing: content-box;
            }

            body {
                background-color: lightgray;
                background-size: cover;
                width: 100%;
                height: 100%;
            }

            .img {
                width: 20px;
                height: 20px;
            }
            .card:hover {
                background-color: #f9f9f9;
                transform: scale(1.01);
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
                transition: all 0.2s ease-in-out;
                cursor:default;
            }
        </style>
        <!-- Material Icons -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

        <!-- Custom CSS -->
    </head>
    <body>

        <?php
            require_once 'helper.php';
            //connect php to database
            //NOTE: the sequence of the parameter in myspli
            //must be followed
            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            //NOTE:
            //-> will only appear and used in database access
            //=> used in associative array
            if ($con->connect_error) {
                die("Connection failed: " . $con->connect_error);
            }

            //sql statement
            //SELECT * FROM Student ORDER BY StudentName ASC;
            $sql = "SELECT * FROM user";

            //ask coonection to run sql query 
            $result = $con->query($sql);

            if ($result->num_rows > 0) {
                //record found
                //why while loop? while i can still access the record
                //we will retreive 
                //fetch_object() - take record 1 by 1 from $result 

                $totalNumUser = $result->num_rows;

                $result->free();
                $con->close();
            } else {
                //no record return
            }
            //connect php to database
            //NOTE: the sequence of the parameter in myspli
            //must be followed
            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            //NOTE:
            //-> will only appear and used in database access
            //=> used in associative array
            if ($con->connect_error) {
                die("Connection failed: " . $con->connect_error);
            }

            //sql statement
            //SELECT * FROM Student ORDER BY StudentName ASC;
            $sql = "SELECT * FROM event";

            //ask coonection to run sql query 
            $result = $con->query($sql);

            if ($result->num_rows > 0) {
                //record found
                //why while loop? while i can still access the record
                //we will retreive 
                //fetch_object() - take record 1 by 1 from $result 

                $totalNumEvent = $result->num_rows;

                $result->free();
                $con->close();
            } else {
                //no record return
            }
            
            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            //NOTE:
            //-> will only appear and used in database access
            //=> used in associative array
            if ($con->connect_error) {
                die("Connection failed: " . $con->connect_error);
            }

            //sql statement
            //SELECT * FROM Student ORDER BY StudentName ASC;
            $sql = "SELECT * FROM payment";

            //ask coonection to run sql query 
            $result = $con->query($sql);

            if ($result->num_rows > 0) {
                //record found
                //why while loop? while i can still access the record
                //we will retreive 
                //fetch_object() - take record 1 by 1 from $result 

                $totalNumPay = $result->num_rows;

                $result->free();
                $con->close();
            } else {
                //no record return
            }
        ?>


        <!-- Navbar -->
        <?php include 'headerAdmin.php'; ?>
        <!-- End of Navbar -->

        <h1>&nbsp;</h1>
        <p>&nbsp;</p>
        <p>&nbsp;</p>

        <div class="container" style='display:block;margin-left: auto;margin-right: auto;'>

            <!-- Main -->
            <main class="main-container">
                <div class="main-title">
                    <p class="font-weight-bold" style='text-align:center'>DASHBOARD</p>
                </div>

                <div class="main-cards">

                    <div class="card">
                        <div class="card-inner">
                            <p class="text-primary">Number of Member(s)</p>
                            <span class="material-icons-outlined text-blue">assignment_ind</span>
                        </div>
                        <span class="text-primary font-weight-bold"><?php echo isset($totalNumUser) ? $totalNumUser : "0"; ?></span>
                    </div>

                    <div class="card">
                        <div class="card-inner">
                            <p class="text-primary">Number of Product(s) Available</p>
                            <span class="material-icons-outlined text-red">event</span>
                        </div>
                        <span class="text-primary font-weight-bold"><?php echo isset($totalNumEvent) ? $totalNumEvent : "0"; ?></span>
                    </div>
                    
                    <div class="card" style='border-left: 7px solid #458B74'>
                        <div class="card-inner">
                            <p class="text-primary">Number of Product(s) Sold</p>
                            <span class="material-icons-outlined text-green">payment</span>
                        </div>
                        <span class="text-primary font-weight-bold"><?php echo isset($totalNumPay) ? $totalNumPay : "0"; ?></span>
                    </div>

                </div>
            </main>
            <!-- End Main -->

        </div>

        <!-- Footer -->
        <?php include 'footerAdmin.php'; ?>
        <!-- End Of Footer -->
        
        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

        <!-- ApexCharts -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.3/apexcharts.min.js"></script>

    </body>
</html>