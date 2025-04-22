<?php
session_start();
require_once 'helper.php';

// Check if the user is logged in
if (!isset($_SESSION['admin_email'])) {
    header('Location: index.php');
    exit();
}

?>

<?php
// Create associative array for table headers
$header = array(
    "username" => "Username",
    "gender" => "User Gender",
    "email" => "User Email",
    "action" => "Action"
);

// Retrieve order, sort, and email filter from URL
if (empty($_GET)) {
    // No parameters in the URL
    $sort = "username";
    $order = "ASC";
    $email = "%";
} else {
    // Parameters exist in the URL
    $sort = isset($_GET["sort"]) ? $_GET["sort"] : "username";
    $order = isset($_GET["order"]) ? $_GET["order"] : "ASC";
    $email = isset($_GET["email"]) ? $_GET["email"] : "%";
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>List Volunteer</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="css/header.css" rel="stylesheet" type="text/css"/>
        <link href="css/form.css" rel="stylesheet" type="text/css"/>
        <link href="css/footer.css" rel="stylesheet" type="text/css"/>

        <?php
        require_once 'helper.php';
        ?>
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
            /* === Action Buttons(update/delete) === */
            .action {
                font-size: 14px;
                padding: 6px 14px;
                border: none;
                background-color: #00b383;
                color: white;
                border-radius: 15px;
                transition: all 0.3s ease-in-out;
                margin-right: 5px;
                text-decoration: none;
                display: inline-block;
            }

            .action:hover {
                background-color: #009970;
                transform: scale(1.05);
            }
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

            /*Checkbox cursor*/
            input[type="checkbox"] {
                cursor: pointer;
                transform: scale(1.2);
                accent-color: #009970; /* Custom checkbox color (modern browsers) */
            }

            /* === Delete Checked Button === */
            input[type="submit"][name="btnDelete"] {
                margin-top: 20px;
                padding: 10px 20px;
                background-color: #dc3545;
                color: white;
                border: none;
                border-radius: 10px;
                font-size: 16px;
                transition: all 0.2s ease-in-out;
            }

            input[type="submit"][name="btnDelete"]:hover {
                background-color: #c82333;
                transform: scale(1.05);
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
// Check if the delete button is clicked
        if (isset($_POST["btnDelete"])) {
            // Delete button clicked
            // Retrieve userIds from the checkboxes
            $checked = isset($_POST["chkDelete"]) ? $_POST["chkDelete"] : null;

            if (!empty($checked)) {
                // Connect to the database
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                $escaped = array();

                foreach ($checked as $value) {
                    $escaped[] = $con->real_escape_string($value);
                }

                // Construct SQL query to delete selected records
                $sql = "DELETE FROM volunteer WHERE username IN ('" . implode("','", $escaped) . "')";

                // Execute the delete query
                if ($con->query($sql)) {
                    printf("<div class='info'><b>%d</b> records have been deleted.</div>", $con->affected_rows);
                }

                $con->close();
            }
        }
        ?>

        <div class="d-flex justify-content-center">
            <div style="width: 60%; text-align: center;">
                <h1 style="padding-bottom: 15px;margin-top:100px;">List Volunteer</h1>
                <form action='' method='POST'>
                    <div class="infotable">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <?php
                                    // Display table headers
                                    foreach ($header as $key => $value) {
                                        if ($key == $sort) {
                                            printf("<th scope='col'>
                                                <div class='sort-pill'>
                                                    <a href='?sort=%s&order=%s&email=%s'>%s</a>
                                                    <img src='img/%s' style='width: 14px; height: 14px; margin-left: 5px;'/>
                                                </div>
                                                </th>", $key, ($order == 'ASC') ? 'DESC' : 'ASC',
                                                $email,
                                                $value,
                                                ($order == 'ASC') ? 'asc.png' : 'desc.png');
                                                
                                                
                                        } else {
                                            printf("<th scope='col'>
                                                <div class='sort-pill'>
                                                    <a href='?sort=%s&order=ASC&email=%s'>%s</a>
                                                </div>
                                                </th>", $key, $email, $value);
                                        }
                                    }
                                    ?>
                                </tr> 
                            </thead>
                            <tbody class="table-group-divider">
                                <?php
                                // Connect to the database
                                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                                if ($con->connect_error) {
                                    die("Connection failed: " . $con->connect_error);
                                }

                                // Construct SQL query to fetch volunteer records
                                $sql = "SELECT * FROM volunteer WHERE email LIKE '$email' ORDER BY $sort $order";

                                $result = $con->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_object()) {
                                        // Use a default value for gender if getGender() returns NULL
                                        $genderValue = isset(getGender()[$row->gender]) ? getGender()[$row->gender] : "Unknown";

                                        printf("<tr>
                                        <td><input type='checkbox' name='chkDelete[]' value='%s' /></td>
                                        <td>%s</td>
                                        <td>%s</td>
                                        <td>%s</td>
                                        <td class='text-center'>
                                            <a href='updateVolunteer.php?username=%s' class='action'>Update</a>
                                            <a href='deleteVolunteer.php?username=%s' class='action-delete'>Delete</a>
                                        </td>
                                    </tr>", $row->username, $row->username, $genderValue, $row->email, $row->username, $row->username);
                                    }

                                    printf('<tr><td colspan="6" style="text-align:left;">
                                    %d Record(s) Returned.
                                    </td></tr>', $result->num_rows);

                                    $result->free();
                                    $con->close();
                                } else {
                                    printf('<tr><td colspan="6">No records found.</td></tr>');
                                }
                                ?>
                            </tbody>
                        </table>
                        <input type="submit" value="Delete Checked" name="btnDelete" onclick="return confirm('This will delete all checked records.\nAre you sure?');" style="text-align:left;"/>

                    </div>
                    <br/> 
                </form>
            </div> 
        </div>

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
