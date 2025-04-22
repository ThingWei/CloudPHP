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
    "email" => "User Email",
    "eventName" => "Product Name",
    "price" => "Price",
);

//retrieve order, sort from URL
if (empty($_GET)) {
//URL has no parameter
    $sort = "email";
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
        <meta charset="UTF-8">
        <title>List Payment Detail</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <!--        <link href="css/list.css" rel="stylesheet" type="text/css"/>-->
        <link href="css/header.css" rel="stylesheet" type="text/css"/>
        <link href="css/footer.css" rel="stylesheet" type="text/css"/>
        <style>
            .navbar {
                box-sizing: content-box;
            }

            body {
                background-color: lightgray;
                font-family: Arial,sans-serif;
                background-size: cover;
                width: 100%;
            }

            .return {
                border: 0;
                width: 60px;
                height: 60px;
                background: transparent;
                margin-left: 20px;
            }

            /* === Table Wrapper === */
            .infotable {
                overflow: auto;
                white-space: nowrap;
                margin: 0 auto 100px auto;
                padding: 20px;
                background-color: white;
                border-radius: 10px;
                box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            }

            /* === Sort Header Pill === */
            .sort-pill {
                display: inline-block;
                background-color: #f8f9fa;
                padding: 8px 16px;
                border-radius: 20px;
                transition: transform 0.2s ease-in-out, background-color 0.2s ease-in-out;
                cursor: pointer;
            }

            .sort-pill a {
                text-decoration: none;
                color: #000;
                font-weight: 500;
            }

            .sort-pill:hover {
                transform: scale(1.07);
                background-color: #e0e0e0;
            }

            /* tr hover */
            table tbody tr:hover {
                background-color: #f9f9f9;
                transform: scale(1.01);
                box-shadow: 0 2px 8px rgba(0,0,0,0.1);
                transition: all 0.2s ease-in-out;
                cursor:default;
            }
            

            /* image scale */
            img{
                width:30px;
                height:30px;
            }

        </style>
    </head>
    <body>

        <!-- Navbar -->
        <?php include 'headerAdmin.php'; ?>
        <!-- End of Navbar -->

        <h1>&nbsp;</h1>
        <p>&nbsp;</p>
        <p>&nbsp;</p>

        <?php require_once 'helper.php'; ?>
     

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
                $sql = "DELETE FROM payment WHERE name IN('" . implode("','", $escaped) . "')";

// execute the query
                if ($con->query($sql) === TRUE) {
                    echo "Records deleted successfully";
                } else {
                    echo "Error deleting records: " . $con->error;
                }
            }
        }
        ?>
        <div class = "d-flex justify-content-center">
        <div style="width: 60%; text-align: center;">
        <h1 style="padding-bottom: 15px;margin-top:10px;">Payment List</h1>
                <form action='' method='POST'>
                    <div class="infotable">
                        <table class="table">
                    <thead>
                    <tr>
                        <th style="text-align: center;">No.</th>
                        <?php
                        
                        foreach ($header as $key => $value) {
                            if ($key == $sort) {
                                //check if the user sort based on
                                //a specific column?
                                printf("<th scope='col'>
                                <div class='sort-pill'>
                                    <a href='?sort=%s&order=%s&program=%s'>%s</a>
                                    <img src='img/%s'/>
                                </div>
                                </th>", $key, ($order == 'ASC') ? "DESC" : "ASC",
                                        $program,
                                        $value,
                                        ($order == 'ASC') ? 'asc.png' : 'desc.png');
                            } else {
                                //default ,the page run for the first time ,user never click to sort thee record
                                printf("<th scope='col'>
                                <div class='sort-pill'>
                            <a href='?sort=%s&order=ASC&program=%s'>%s</a>
                                </div>
                                </th>", $key, $program, $value);
                            }
                        }
                        ?>
                    </tr>
                    </thead>
                    <tbody>
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
                    $sql = "SELECT * FROM payment 
                            WHERE email LIKE '$program'
                            ORDER BY $sort $order";

//ask coonection to run sql query 
                    $result = $con->query($sql);

                    if ($result->num_rows > 0) {
                        //record found
                        //why while loop? while i can still access the record
                        //we will retreive 
                        //fetch_object() - take record 1 by 1 from $result 
                        $count=1;

                        while ($row = $result->fetch_object()) {
                            

                            printf("
                                <tr>
                                <td>$count</td>
                                <td>%s</td> 
                                <td>%s</td>
                               
                                <td>RM %s</td>
                                
                                </tr>
                                    "
                                    , $row->email
                                    , $row->eventName
                                    , $row->price
                            );
                            $count++;
                        }
                        printf("<tr><td colspan='4' style='text-align:left'>%d record(s) returned .</td></tr>", $result->num_rows);

                        $result->free();
                        $con->close();
                    } else {
                        echo '<tr><td colspan="3" style="text-align:left"> No Payment has been made yet.</td></tr>';
                    }
                    ?>
                </tbody>
                </table>
                </div>
            </form>
        </div>
        </div>

        <p>&nbsp;</p>
        <!-- Footer -->
        <?php include 'footerAdmin.php'; ?>
        <!-- End Of Footer -->

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    </body>
</html>
