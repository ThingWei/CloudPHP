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
            body {
                background-color: lightgray;
                background-size: cover;
                width: 100%;
            }

            table {
                margin: auto; /* Center the table */
                margin-top: 200px;
                border: 1px solid #ccc;
                border-radius: 20px;
                margin-bottom: 500px;
            }
            .button-container {
                text-align: left;
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
        <form action="" method="POST">

            <table class="table" style="width:900px;justify-content:center;">

                <thead>
                    <tr>
                        <th colspan="6" class="management-heading" style="font-size:35px;text-align:center;">Feedback Details Management</th>
                    </tr>
                    <tr>
                        <th></th>
                        <?php
// Display table headers
                        foreach ($header as $key => $value) {
                            $sortIcon = ($key == $sort) ? (($order == 'ASC') ? 'asc.png' : 'desc.png') : '';
                            $newOrder = ($key == $sort && $order == 'ASC') ? 'DESC' : 'ASC';
                            printf("<th scope='col'><a href='?sort=%s&order=%s&description=%s'>%s</a> <img src='img/%s'/></th>",
                                    htmlspecialchars($key), htmlspecialchars($newOrder), htmlspecialchars($description), htmlspecialchars($value), htmlspecialchars($sortIcon));
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

                        printf('<tr><td colspan="6">%d record(s) returned.</td></tr>', $result->num_rows);
                    } else {
                        echo "<tr><td colspan='6'>No records found.</td></tr>";
                    }

// Close connections
                    $result->free();
                    $stmt->close();
                    $con->close();
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6" class="button-container">
                            <input type="submit" value="Delete Checked" name="btnDelete" onclick="return confirm('Are you sure you want to delete the selected records?');" />
                        </td>
                    </tr>
                </tfoot>
            </table>
            <br/>
        </form>

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
