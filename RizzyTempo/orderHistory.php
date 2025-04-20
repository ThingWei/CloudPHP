<?php
session_start();
require_once 'helper.php';
// Make sure user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit();
}

$host = 'localhost';
$db = 'music_society';
$user = 'root';
$pass = ''; // Update with your actual password

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // DELETE ITEM
    if (isset($_POST['remove'])) {
        $cartID = intval($_POST['remove']);
        $delete = $conn->prepare("DELETE FROM cart WHERE cartID = ?");
        $delete->bind_param("i", $cartID);
        $delete->execute();
        $delete->close();

        header("Location: cart.php");
        exit();
    }

    // UPDATE QUANTITIES
    if (isset($_POST['update']) && isset($_POST['quantities'])) {
        foreach ($_POST['quantities'] as $cartID => $newQty) {
            $newQty = intval($newQty);
            if ($newQty > 0) {
                $update = $conn->prepare("UPDATE cart SET quantity = ? WHERE cartID = ?");
                $update->bind_param("ii", $newQty, $cartID);
                $update->execute();
                $update->close();
            }
        }

        header("Location: cart.php");
        exit();
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $eventName = $_POST['eventName'];
    
    $price = $_POST['price'];
    $eventBanner = $_POST['eventBanner']; // or get it from DB
    $quantity = intval($_POST['quantity']);
    $email = $_SESSION['user_email'];

    // Check if item already exists in DB for this user
    $check = $conn->prepare("SELECT quantity FROM cart WHERE user_email = ? AND eventName = ?");
    $check->bind_param("ss", $email, $eventName);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        // If exists, update quantity
        $update = $conn->prepare("UPDATE cart SET quantity = quantity + ? WHERE user_email = ? AND eventName = ? ");
        $update->bind_param("iss", $quantity, $email, $eventName, );
        $update->execute();
        $update->close();
    } else {
        // Insert new cart item
        $insert = $conn->prepare("INSERT INTO cart (user_email, eventName, eventBanner,  price, quantity) VALUES (?, ?, ?, ?, ?)");
        $insert->bind_param("sssdi", $email, $eventName, $eventBanner, $price, $quantity);
        $insert->execute();
        $insert->close();
    }

    $check->close();

    header("Location: cart.php");
    exit();
}

$email = $_SESSION['user_email'];
$sql = "
    SELECT 
        c.cartID, 
        c.eventName, 
         
        c.eventBanner, 
        c.quantity, 
        e.productPrice AS price 
    FROM cart c
    JOIN event e ON c.eventName = e.eventName
    WHERE c.user_email = ?
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

$cartItems = [];
$total = 0;

while ($row = $result->fetch_assoc()) {
    $cartItems[] = $row;
    $total += $row['price'] * $row['quantity'];
}
$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
            <body class="bg-light">
<?php include 'headerUser.php'; ?>
<p class="gap">&nbsp;</p>
<p class="gap">&nbsp;</p>
<p class="gap">&nbsp;</p>

<div class="container mt-5">
    <button class="btn btn-outline-secondary mb-4" onclick="window.location.href='event.php'">
        ← Continue Shopping
    </button>

    <h2 class="mb-4 text-center fw-bold">Order History</h2>

    <?php if (empty($cartItems)): ?>
        <div class="alert alert-info text-center">Your order history is empty. Click <a href="event.php">here</a> to start browsing!</div>
    <?php else: ?>
        <form method="post" action="cart.php">
            <div class="row g-4">
                <?php foreach ($cartItems as $index => $item): ?>
                    <div class="col-md-12">
                        <div class="card shadow-sm">
                            <div class="card-body d-flex flex-wrap align-items-center justify-content-between">
                                <div class="d-flex align-items-center" style="min-width: 300px;">
                                    <img src="<?= htmlspecialchars($item['eventBanner']) ?>" alt="Banner" class="img-thumbnail me-3" style="width: 120px; height: 75px; object-fit: cover;">
                                    <div>
                                        <h5 class="card-title mb-1"><?= htmlspecialchars($item['eventName']) ?></h5>
                                        <p class="mb-0 text-muted">RM <?= number_format($item['price'], 2) ?></p>
                                    </div>
                                </div>

                                <div class="text-center mx-2">
                                    <label class="form-label mb-1">Quantity</label>
                                    <input type="number" name="quantities[<?= $item['cartID'] ?>]" value="<?= $item['quantity'] ?>" min="1" class="form-control text-center" style="width: 80px;">
                                </div>

                                <div class="text-center mx-2">
                                    <label class="form-label mb-1">Subtotal</label>
                                    <p class="fw-semibold mb-0">RM <?= number_format($item['price'] * $item['quantity'], 2) ?></p>
                                </div>

                                <div class="text-center">
                                    <button type="submit" name="remove" value="<?= $item['cartID'] ?>" class="btn btn-outline-danger">Remove</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="text-end mt-4">
                <h4 class="fw-bold">Total: RM <?= number_format($total, 2) ?></h4>
                <div class="mt-3">
                    <button type="submit" name="update" class="btn btn-outline-primary me-2">Update Cart</button>
                    <a href="payment.php" class="btn btn-success">Proceed to Payment</a>
                </div>
            </div>
        </form>
    <?php endif; ?>
</div>

<p class="gap">&nbsp;</p>
<?php include 'footerUser.php'; ?>
</body>

</html>
