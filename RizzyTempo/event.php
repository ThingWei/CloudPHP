<?php
session_start();
require_once 'helper.php';

// Check if the user is logged in
if (!isset($_SESSION['user_email'])) {
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
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Products</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="css/header.css" rel="stylesheet">
        <link href="css/footer.css" rel="stylesheet">
        <link href="css/event.css" rel="stylesheet">
        <style>
            .navbar {
                box-sizing: content-box;
            }

            body {
                background-color: lightgray;
                background-size: cover;
                width: 100%;
            }

            .img {
                width: 20px;
                height: 20px;
            }

            .custom-card:hover {
                .content_text {
                    margin: auto;
                    width: 70%;
                    border-radius: 10px;
                    background: rgba(255, 255, 255, 0.7);
                }
            }
        </style>
    </head>

    <body>
        <?php
        require_once 'helper.php';
        ?>

        <!-- Navbar -->
        <?php
        include 'headerUser.php';
        ?>
        <!-- End of Navbar -->

        <p class="gap">&nbsp;</p>

        <!-- Content -->
        <?php
        //connect php to database
        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }

        //sql statement
        $sql = "SELECT * FROM event";

        //ask coonection to run sql query 
        $result = $con->query($sql);

        if ($result->num_rows > 0) {
            // Record found
            echo '<div id="container">';
            echo '<h1 style="margin: auto; text-align: center; padding-bottom: 20px;">Our Products</h1>';
            echo '<div class="d-flex justify-content-end mb-3">
        <input type="text" id="searchBox" class="form-control w-25" placeholder="Search Product...">
    </div>';
    echo '<div class="container"><div class="row" id="productGrid">';

    $count = 0;
    while ($row = $result->fetch_object()) {
        echo '
            <div class="col-md-4 mb-4 product-item">
                <div class="card h-100 shadow-sm">
                    <img src="' . $row->eventBanner . '" class="card-img-top" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">' . $row->eventName . '</h5>
                        
                        <div class="d-flex justify-content-between mt-3">
                            <a href="eventdets.php?eventName=' . urlencode($row->eventName) . '" class="btn btn-outline-primary w-50 me-2">
                                <i class="bi bi-eye"></i> View
                            </a>
                            <form method="POST" action="cart.php" class="w-50">
                                <input type="hidden" name="eventName" value="' . htmlspecialchars($row->eventName) . '">

                                <input type="hidden" name="price" value="<?= $price ?>">
                                <input type="hidden" name="eventBanner" value="' . htmlspecialchars($row->eventBanner) . '">
    
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" name="add_to_cart" class="btn btn-outline-success w-100">
                                    <i class="bi bi-cart-plus"></i> Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>';
        $count++;
    }
    
    echo '</div></div>';
            echo '</div>';

            // Free result set and close connection
            $result->free();
            $con->close();
        } else {
            // No records returned
        }
        ?>

        <!-- End of content -->

        <!-- Footer -->
        <?php
include 'footerUser.php';
?>
<!-- End Of Footer -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    </body>

</html>

<script>
    document.getElementById('searchBox').addEventListener('input', function () {
        const searchTerm = this.value.toLowerCase();
        document.querySelectorAll('.product-item').forEach(item => {
            const title = item.querySelector('.card-title').textContent.toLowerCase();
            item.style.display = title.includes(searchTerm) ? 'block' : 'none';
        });
    });
</script>