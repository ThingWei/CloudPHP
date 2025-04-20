<?php
session_start();
require_once 'helper.php';

// Check if the user is logged in
if (!isset($_SESSION['user_email'])) {
    header('Location: index.php');
    exit();

}

// Initialize variables
$eventName = "";
$headline = "";
$description = "";
$eventBanner = "";
$dateOfEvent = "";
$time = "";
$location = "";
$ticketData = [];

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['eventName'])) {
        $eventName = trim($_GET['eventName']);
        $eventTicketName = isset($_GET['eventTicketName']) ? trim($_GET['eventTicketName']) : "";

        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }

        $eventName = $con->real_escape_string($eventName);

        $sql = "SELECT * FROM event WHERE eventName = '$eventName'";
        $result = $con->query($sql);

        if ($row = $result->fetch_object()) {
            $eventName = $row->eventName;
            $headline = $row->headline;
            $description = $row->description;
            $eventBanner = $row->eventBanner;
            $productType = $row->productType;
        }

        $result->free();
        $con->close();
    }
}
?>

<!DOCTYPE html>
<html>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Products</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="css/header.css" rel="stylesheet">
        <link href="css/footer.css" rel="stylesheet">
        <link href="css/event1.css" rel="stylesheet" type="text/css" />
        <style>
            body {
                background-color: lightgray;
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
        </style>

    </head>

    <body>
        <!-- Navbar -->
        <?php
        include 'headerUser.php';
        ?>
        <!-- End of Navbar -->

        <h1>&nbsp;</h1>
        <p>&nbsp;</p>
        <p>&nbsp;</p>

        <a href="event.php"><button class="return"><img class="return" src="img/goback.png"></button></a>
     
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="row g-0">
                    
                    <!-- Left: Event Banner -->
                    <div class="col-md-6">
                        <img src="<?php echo isset($eventBanner) ? $eventBanner : 'img/default.jpg'; ?>" 
                             alt="Event Banner" 
                             class="img-fluid w-100 h-100" 
                             style="object-fit: cover; max-height: 100%;">
                    </div>

                    <!-- Right: Event Info -->
                    <div class="col-md-6 p-5 d-flex flex-column justify-content-between bg-light">
                        <div class="d-flex flex-column gap-3">

                            <h2 class="fw-bold">
                                <?php echo isset($eventName) ? htmlspecialchars($eventName) : "Product Name"; ?>
                            </h2>

                            <p class="text-muted">
                                <?php echo isset($headline) ? htmlspecialchars($headline) : "Product headline here..."; ?>
                            </p>

                            <p class="text-muted">
                                <?php echo isset($description) ? htmlspecialchars($description) : "Product description here..."; ?>
                            </p>

                            <p class="text-muted">
                                <?php echo isset($productType) ? htmlspecialchars($productType) : "Product Type here..."; ?>
                            </p>

                            <?php
                            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                            if ($con->connect_error) {
                                die("Connection failed: " . $con->connect_error);
                            }

                            $eventName = trim($_GET['eventName'] ?? '');

                            if (!empty($eventName)) {
                                $sql2 = "SELECT productPrice FROM event WHERE eventName = ?";
                                $stmt = $con->prepare($sql2);
                                $stmt->bind_param("s", $eventName);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                if ($row = $result->fetch_object()) {
                                    $price = $row->productPrice;
                                    echo "<h4 class='text-success fw-semibold'>RM $price</h4>";

                                    // Buy Now
                                    echo "<form action='payment.php' method='GET' class='mb-3'>";
                                    echo "<input type='hidden' name='eventName' value='" . htmlspecialchars($eventName) . "'>";
                                    echo "<button type='submit' class='btn btn-primary w-100'>Buy Now</button>";
                                    echo "</form>";

                                    // Add to Cart
                                    echo '<form method="POST" action="cart.php">';
                                    echo '<input type="hidden" name="eventName" value="' . htmlspecialchars($eventName) . '">';
                                    echo '<input type="hidden" name="price" value="' . htmlspecialchars($price) . '">';
                                    echo '<input type="hidden" name="eventBanner" value="' . htmlspecialchars($eventBanner) . '">';
                                    echo '<input type="hidden" name="quantity" value="1">';
                                    echo '<button type="submit" name="add_to_cart" class="btn btn-outline-success w-100">
                                            <i class="bi bi-cart-plus"></i> Add to Cart
                                          </button>';
                                    echo '</form>';
                                } else {
                                    echo "<p class='text-danger'>Out of stock.</p>";
                                }

                                $stmt->close();
                            } else {
                                echo "<p class='text-danger'>Invalid product name.</p>";
                            }

                            $con->close();
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
        <h1>&nbsp;</h1>
        <p>&nbsp;</p>
        <p>&nbsp;</p>

        <!-- Footer -->
<?php include 'footerUser.php'; ?>
<!-- End Of Footer -->
    </body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>


</html>
