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
            $dateOfEvent = $row->dateOfEvent;
            $time = $row->time;
            $location = $row->location;
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
        <title>Events</title>
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
        <nav class="navbar navbar-expand-lg fixed-top">
            <div class="container-fluid">
                <a class="navbar-brand me-auto" href="home.php"><img class="mslogo" src="img/music.png"
                                                                     style="height:65px;width:65px;"></a>
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
                                <a class="nav-link mx-lg-2" aria-current="page" href="home.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mx-lg-2" aria-current="page" href="event.php">Events</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mx-lg-2" aria-current="page" href="displayTicket.php">Purchased Tickets</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mx-lg-2" href="aboutus.php">About Us</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mx-lg-2" href="feedback.php">Feedback</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mx-lg-2" href="faq.php">FAQ</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <a href="profile.php"><img class="profilepic" src="img/profile.png"></a>
                <button class="navbar-toggler pe-0" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                </button>
            </div>
        </nav>
        <!-- End of Navbar -->

        <h1>&nbsp;</h1>
        <p>&nbsp;</p>
        <p>&nbsp;</p>

        <a href="event.php"><button class="return"><img class="return" src="img/goback.png"></button></a>
        <div class="container">
        <div class="container mt-5 bg-white p-4 rounded shadow" style="max-width: 900px;">
    <div class="row">
        <!-- Event Banner -->
        <div class="col-md-6 text-center">
            <img src="<?php echo isset($eventBanner) ? $eventBanner : 'img/default.jpg'; ?>" alt="Event Banner" class="img-fluid rounded" style="max-height: 500px; object-fit: cover;">
        </div>

        <!-- Event Details -->
        <div class="col-md-6">
            <h2 class="mb-3"><?php echo isset($eventName) ? $eventName : "Event Title"; ?></h2>
            <p class="text-muted"><?php echo isset($description) ? $description : "Event description here..."; ?></p>
            <p><strong>Date:</strong> <?php echo isset($dateOfEvent) ? $dateOfEvent : "TBA"; ?></p>
            <p><strong>Time:</strong> <?php echo isset($time) ? $time : "TBA"; ?></p>
            <p><strong>Location:</strong> <?php echo isset($location) ? $location : "TBA"; ?></p>

            <!-- Pricing and Buttons -->
            <?php
            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if ($con->connect_error) {
                die("Connection failed: " . $con->connect_error);
            }

            $sql2 = "SELECT * FROM ticket WHERE eventTicketName = '$eventName'";
            $result2 = $con->query($sql2);
            if ($row = $result2->fetch_object()) {
                echo "<h4 class='text-success mt-4'>From RM$row->price</h4>";
            
                // Buy Now form
                echo "<form action='payment.php' method='GET' class='w-50'>";
                echo "<input type='hidden' name='eventTicketName' value='" . htmlspecialchars($eventName) . "'>";
                echo "<input type='hidden' name='ticketType' value='" . htmlspecialchars($row->ticketType) . "'>";
                echo "<button type='submit' class='btn btn-primary w-100'>Buy Now</button>";
                echo "</form>";
            
                // Add to Cart form (separate!)
                echo "<form method='POST' action='cart.php' class='w-50 mt-2'>";
                echo "<input type='hidden' name='eventTicketName' value='" . htmlspecialchars($eventName) . "'>";
                echo "<input type='hidden' name='ticketType' value='" . htmlspecialchars($row->ticketType) . "'>";
                echo "<input type='hidden' name='quantity' value='1'>";
                echo "<button type='submit' name='add_to_cart' class='btn btn-outline-success w-100'>
                        <i class='bi bi-cart-plus'></i> Add to Cart
                      </button>";
                echo "</form>";
            }
            else {
                echo "<p class='text-danger mt-4'>No tickets available for this event right now.</p>";
            }
            $result2->free();
            $con->close();
            ?>
        </div>
    </div>
</div>
        </div>

        <h1>&nbsp;</h1>
        <p>&nbsp;</p>
        <p>&nbsp;</p>

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
                <h3>Navigation<div class="underline"><span class="uline"></span></div>
                </h3>
                <ul class="footnav">
                    <li><a href="home.php">Home</a></li>
                    <li><a href="event.php">Events</a></li>
                    <li><a href="displayTicket.php">Purchased Tickets</a></li>
                    <li><a href="aboutus.php">About Us</a></li>
                    <li><a href="feedback.php">Feedback</a></li>
                    <li><a href="faq.php">FAQ</a></li>
                </ul>
            </div>
            <div class="colfoot">
                <h3 style="font-size: 14px;" class="fblow">Find Us Thru Our Social Media Below!<div
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
    </body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

    <script>
        // Cart data structure
        let cart = [];
        let totalPrice = 0;

        // Initialize cart display
        updateTotalDisplay();

        // Add to cart function
        function addToCart(ticketType, price, quantity) {
            cart.push({ticketType, price, quantity});
            totalPrice += price * quantity;
            updateTotalDisplay();
        }

        // Update total display function
        function updateTotalDisplay() {
            const cartTotalElement = document.getElementById('cart-total');
            // Display total price
            cartTotalElement.textContent = `RM${totalPrice}`;
        }

        // Event listener for "add to cart" buttons
        const addToCartButtons = document.querySelectorAll('.add-to-cart');
        addToCartButtons.forEach(button => {
            button.addEventListener('click', () => {
                const ticketType = button.getAttribute('data-ticket-type');
                const price = ticketType === 'standard' ? 40 : 80; // Sample prices
                const quantity = parseInt(button.parentElement.querySelector('.quantity').textContent);
                addToCart(ticketType, price, quantity);
            });
        });

        // Event listeners for increase and decrease buttons
        const increaseButtons = document.querySelectorAll('.increase-quantity');
        increaseButtons.forEach(button => {
            button.addEventListener('click', () => {
                const quantityElement = button.parentElement.querySelector('.quantity');
                let quantity = parseInt(quantityElement.textContent);
                quantity++;
                quantityElement.textContent = quantity;
            });
        });

        const decreaseButtons = document.querySelectorAll('.decrease-quantity');
        decreaseButtons.forEach(button => {
            button.addEventListener('click', () => {
                const quantityElement = button.parentElement.querySelector('.quantity');
                let quantity = parseInt(quantityElement.textContent);
                if (quantity > 0) {
                    quantity--;
                    quantityElement.textContent = quantity;
                }
            });
        });
    </script>

</html>
