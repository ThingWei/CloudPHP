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
                background-color: lightgray;
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

            th a{
                color:white;
            }

            tr:nth-child(even) {
                background-color: #f2f2f2;
            }

            tr:nth-child(odd) {
                background-color: white;

            }
            table {
                border-collapse: separate !important;
                border-spacing: 0;
                width: 100%;
                overflow: hidden;
                border-radius: 12px;
                background-color: white;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            }

            th {
                background-color: #343a40;
                color: white;
                padding: 12px;
                text-align: left;
                font-weight: bold;
            }

            td {
                padding: 12px;
                vertical-align: middle;
                border-top: 1px solid #dee2e6;
            }

            tr:first-child td:first-child {
                border-top-left-radius: 12px;
            }

            tr:first-child td:last-child {
                border-top-right-radius: 12px;
            }

            tr:last-child td:first-child {
                border-bottom-left-radius: 12px;
            }

            tr:last-child td:last-child {
                border-bottom-right-radius: 12px;
            }

            tr:hover {
                background-color:rgb(198, 197, 197);
                transition: 0.2s;
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
                transform: scale(1.5);
                background-color: #00b383;
                box-shadow: 0 4px 12px rgba(0,0,0,0.2);
                transition: all 0.2s ease-in-out;
            }
            .delete {
                background-color: #dc3545; /* Bootstrap red */
                border: none;
                color: white;
                padding: 8px 16px;
                border-radius: 8px;
                cursor: pointer;
                font-size: 16px;
                transition: transform 0.2s ease-in-out, background-color 0.2s ease-in-out;
            }

            .delete a {
                color: white;
                text-decoration: none;
                display: block;
                width: 100%;
                height: 100%;
            }

            .delete:hover {
                transform: scale(1.1);
                background-color: #c82333; /* darker red on hover */
            }
            img{
                width:30px;
                height:30px;
            }

            .sort-pill {
                border-collapse: separate;
                display: grid;
                background-color:#343a40;
                padding: 0px;
                border-radius: 20px;
                transition: transform 0.2s ;
                cursor: pointer;
            }

            .sort-pill a {
                text-decoration: none;
                color: white;
                font-weight: 500;
            }

            .sort-pill:hover {
                transform: scale(1.02);
                background-color:#343a40;
            }

            /*Checkbox cursor*/
            input[type="checkbox"] {
                cursor: pointer;
                transform: scale(1.2);
                accent-color: #009970; /* Custom checkbox color (modern browsers) */
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
        <div class="container" style="max-width: 90%; margin: 0 auto;">
        <div class="card shadow rounded" style="padding: 20px;">
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
                                    <div class='sort-pill'>
                                        <a href='?sort=%s&order=%s&program=%s'>%s</a>&nbsp;
                                        <img src='img/%s'/>
                                        </div>
                                </th>", $key, ($order == 'ASC') ? "DESC" : "ASC",
                                            $program,
                                            $value,
                                            ($order == 'ASC') ? 'asc.png' : 'desc.png');
                                } else {
                                    //default ,the page run for the first time ,user never click to sort thee record
                                    printf("<th>
                                    <div class='sort-pill'>
                                    <a href='?sort=%s&order=ASC&program=%s'>%s</a>
                                    </div>
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
                                <button class='delete'><a href='delete-login.php?id=%s'>Delete</a></button>
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
                    <input type="submit" value="Delete Checked" name="btnDelete" class="btn btn-danger mx-2" onclick="return confirm('This will delete all checked records.\nAre you sure?')" />
                    <input type="button" value="Create New User Account" name="btnInsert" class="btn btn-success" onclick="location.href='insert-login.php';" />
                </form>
            </div>
        </div>
        </div>

        <h1>&nbsp;</h1>

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
