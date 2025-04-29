<?php
session_start();
require_once 'helper.php';
// Make sure user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit();
}


$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_SESSION['user_email'];
$sql = "
    SELECT 
        r.receiptID,
        r.eventName, 
         
        e.eventBanner, 
        r.quantity, 
        e.productPrice AS price,
        r.claimStatus
    FROM receipt r
    JOIN event e ON r.eventName = e.eventName
    WHERE r.email = ?
    ORDER BY r.claimStatus DESC
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $cartItems[] = $row;
}
$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order History</title>
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
                                    <p class="fw-semibold mb-0"><?= number_format($item['quantity']) ?></p>
                                </div>

                                <div class="text-center mx-2">
                                    <label class="form-label mb-1">Subtotal</label>
                                    <p class="fw-semibold mb-0">RM <?= number_format($item['price'] * $item['quantity'], 2) ?></p>
                                </div>
                                
                                <!-- CLAIMED / TO BE CLAIMED -->
                                <div class="text-center mx-2" style="width: 120px;">
                                    <?php if ($item['claimStatus'] === "TO BE CLAIMED"): ?>
                                        <p style="color:red; margin:0"><?= htmlspecialchars($item['claimStatus']) ?></p>
                                    <?php elseif ($item['claimStatus'] === "CLAIMED"): ?>
                                        <p style="color:green; margin:0"><?= htmlspecialchars($item['claimStatus']) ?></p>
                                    <?php endif; ?>
                                </div>

                                <div class="text-center">
                                    <a href="receipt.php?receiptID=<?= number_format($item['receiptID']) ?>"><button type="submit" class="btn btn-outline-primary me-2">View Receipt</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

    <?php endif; ?>
</div>

<p class="gap">&nbsp;</p>
<?php include 'footerUser.php'; ?>
</body>

</html>
