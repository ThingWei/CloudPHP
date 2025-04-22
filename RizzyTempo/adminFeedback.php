<?php
session_start();
require_once 'helper.php';

// Check if the user is logged in
if (!isset($_SESSION['admin_email'])) {
    header('Location: index.php');
    exit();
}

// Create associative array for table headers
$header = array(
    "rating" => "Rating",
    "username" => "Username",
    "email" => "User Email",
    "description" => "User Review"
);

// Retrieve order, sort, and description filter from URL
$sort = isset($_GET["sort"]) && in_array($_GET["sort"], array_keys($header)) ? $_GET["sort"] : "rating";
$order = isset($_GET["order"]) && in_array(strtoupper($_GET["order"]), ["ASC", "DESC"]) ? strtoupper($_GET["order"]) : "ASC";
$description = isset($_GET["description"]) ? $_GET["description"] : "%";
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Feedback Details</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="css/header.css" rel="stylesheet">
        <link href="css/footer.css" rel="stylesheet">
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

        <?php
        require_once 'helper.php';

        // Check if the form has been submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btnDelete"])) {
            // Check if any checkboxes are checked
            if (isset($_POST['chkDelete']) && is_array($_POST['chkDelete'])) {
                // Connect to the database
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                if ($con->connect_error) {
                    die("Connection failed: " . $con->connect_error);
                }

                // Prepare SQL statement to delete checked records
                $sql = "DELETE FROM feedback WHERE rating = ?";
                $stmt = $con->prepare($sql);

                if ($stmt) {
                    // Bind parameter for the rating
                    $stmt->bind_param("i", $rating);

                    // Iterate over checked checkboxes
                    foreach ($_POST['chkDelete'] as $rating) {
                        // Execute the delete query for each checked record
                        if (!$stmt->execute()) {
                            // Error occurred while deleting record
                            echo "<div class='alert alert-danger'>Error deleting record with rating: " . $rating . "</div>";
                        }
                    }

                    // Close statement and database connection
                    $stmt->close();
                    $con->close();

                    // Redirect back to the page after deletion
                    echo '<script>document.location.href="adminFeedback.php"</script>';
                    exit();
                } else {
                    echo "<div class='alert alert-warning'>Error in prepared statement.</div>";
                }
            } else {
                echo "<div class='alert alert-warning'>Please select at least one record to delete.</div>";
            }
        }
        ?>
        <div class="d-flex justify-content-center">
            <div style="width: 60%; text-align: center;">
                <h1 style="padding-bottom: 15px;margin-top:150px;">Feedback Details Management</h1>
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

                                    //     $sortIcon = ($key == $sort) ? (($order == 'ASC') ? 'asc.png' : 'desc.png') : '';
                                    //     $newOrder = ($key == $sort && $order == 'ASC') ? 'DESC' : 'ASC';

                                         
                                    //     printf("<th scope='col'>
                                    //     <div class='sort-pill'>
                                    //     <a href='?sort=%s&order=%s&description=%s'>%s</a> 
                                    //     <img src='img/%s' style='width: 14px; height: 14px; margin-left: 5px;'/>
                                    //     </div>
                                    //     </th>",
                                    //             htmlspecialchars($key), htmlspecialchars($newOrder), htmlspecialchars($description), htmlspecialchars($value), htmlspecialchars($sortIcon));
                                    //     }else{
                                    //         printf("<th scope='col'>
                                    //             <div class='sort-pill'>
                                    //                 <a href='?sort=%s&order=ASC&email=%s'>%s</a>
                                    //             </div>
                                    //             </th>", $key, $description, $value);
                                    //     }

                                    printf("<th scope='col'>
                                                <div class='sort-pill'>
                                                    <a href='?sort=%s&order=%s&description=%s'>%s</a>
                                                    <img src='img/%s' style='width: 14px; height: 14px; margin-left: 5px;'/>
                                                </div>
                                                </th>", $key, ($order == 'ASC') ? 'DESC' : 'ASC',
                                                $description,
                                                $value,
                                                ($order == 'ASC') ? 'asc.png' : 'desc.png');
                                                
                                                
                                        } else {
                                            printf("<th scope='col'>
                                                <div class='sort-pill'>
                                                    <a href='?sort=%s&order=ASC&description=%s'>%s</a>
                                                </div>
                                                </th>", $key, $description, $value);
                                        }
                                    }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Connect to the database
                                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                                if ($con->connect_error) {
                                    die("Connection failed: " . $con->connect_error);
                                }

                                // Prepare and execute SQL statement
                                $sql = "SELECT * FROM feedback WHERE description LIKE ? ORDER BY $sort $order";
                                $stmt = $con->prepare($sql);
                                $stmt->bind_param("s", $description);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_object()) {
                                        printf("<tr>
                                        <td><input type='checkbox' name='chkDelete[]' value='%s' /></td>
                                        <td>%s</td>
                                        <td>%s</td>
                                        <td>%s</td>
                                        <td>%s</td>
                                        </tr>",
                                                htmlspecialchars($row->rating), htmlspecialchars($row->rating), htmlspecialchars($row->username),
                                                htmlspecialchars($row->email), htmlspecialchars($row->description));
                                    }

                                    printf('<tr><td colspan="6" style=text-align:left >%d record(s) returned.</td></tr>', $result->num_rows);
                                } else {
                                    echo "<tr><td colspan='6' style=text-align:left>No records found.</td></tr>";
                                }

                                // Close connections
                                $result->free();
                                $stmt->close();
                                $con->close();
                                ?>
                            </tbody>
                        </table>
                        <input type="submit" value="Delete Checked" name="btnDelete" onclick="return confirm('Are you sure you want to delete the selected records?');" />
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
