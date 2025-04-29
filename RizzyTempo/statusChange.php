<?php
session_start();
require_once 'helper.php';
// Make sure user is logged in
if (!isset($_SESSION['admin_email'])) {
    header("Location: login.php");
    exit();
}
ini_set('display_errors', 1);
error_reporting(E_ALL);

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = ($_GET['email']);
$sql = "
    SELECT 
        r.*, 
        e.eventBanner, 
        e.productPrice AS price
    FROM receipt r
    JOIN event e ON r.eventName = e.eventName
    WHERE r.email = ?
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $cartItems[] = $row;
}
$stmt->close();

if (isset($_POST['submit']) && !empty($_POST['receiptID']) && !empty($_POST['changeStatus'])) {
    $email = $_GET['email'];

    foreach ($_POST['receiptID'] as $index => $receiptID) {
        $receiptID = intval($receiptID); // Ensure receiptID is an integer
        $claimStatus = $_POST['changeStatus'][$index];

        $updateSql = "UPDATE receipt SET added_at = added_at, claimStatus = ? WHERE receiptID = ?";
        $updateStmt = $conn->prepare($updateSql);
        if ($updateStmt) {
            $updateStmt->bind_param("si", $claimStatus, $receiptID);

            if (!$updateStmt->execute()) {
                echo "<script>alert('Update failed for receipt ID $receiptID, please try again.');</script>";
            }

            $updateStmt->close();
        } else {
            echo "<script>alert('Failed to prepare the statement for receipt ID $receiptID.');</script>";
        }
    }

    echo "<script>alert('Purchase statuses have been updated.');window.location.href = 'statusChange.php?email=$email';</script>";
}
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
<?php include 'headerAdmin.php'; ?>
<p class="gap">&nbsp;</p>
<p class="gap">&nbsp;</p>
<p class="gap">&nbsp;</p>

<div class="container mt-5">

    <button class="btn btn-outline-secondary mb-4" onclick="window.location.href='adminCheckStatus.php'">
        ← Back
    </button>
    <form method="post" action="">    
    <h2 class="mb-4 text-center fw-bold">Order History</h2>

    <?php if (empty($cartItems)): ?>
        <div class="alert alert-info text-center">User's Purchase History is empty.</div>
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

                                <div class="text-center">
                                    <label class="form-label mb-1">Quantity</label>
                                    <p class="fw-semibold mb-0"><?= number_format($item['quantity']) ?></p>
                                </div>

                                <div class="text-center mx-2">
                                    <label class="form-label mb-1">Subtotal</label>
                                    <p class="fw-semibold mb-0">RM <?= number_format($item['price'] * $item['quantity'], 2) ?></p>
                                </div>

                                <div class="text-center mx-2">
                                    <label class="form-label mb-1">Purchased at</label>
                                    <p class="fw-semibold mb-0"><?= $item['added_at'] ?></p>
                                </div>

                                <div class="text-center mx-2" style="width: 150px;">
                                        <input type="hidden" name="receiptID[<?= $index ?>]" value="<?= htmlspecialchars($item['receiptID']) ?>">
                                        <select name="changeStatus[<?= $index ?>]" class="form-select form-select-sm">
                                            <option value="TO BE CLAIMED" <?= $item['claimStatus'] === "TO BE CLAIMED" ? 'selected' : '' ?>>TO BE CLAIMED</option>
                                            <option value="CLAIMED" <?= $item['claimStatus'] === "CLAIMED" ? 'selected' : '' ?>>CLAIMED</option>
                                        </select>
                                </div>

                                <div class="text-center">
                                    <button name ="submit" type="submit" class="btn btn-outline-primary me-2">Update Status</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
    <?php endif; ?>
</form>
</div>

<p class="gap">&nbsp;</p>
<?php include 'footerAdmin.php'; ?>
</body>

</html>
