<?php
session_start();
require_once 'helper.php';
// Make sure user is logged in
if (!isset($_SESSION['admin_email'])) {
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

$sql = "SELECT u.*, COUNT(r.receiptID) AS total_receipts, 
    SUM(CASE WHEN r.claimStatus = 'TO BE CLAIMED' THEN 1 ELSE 0 END) AS to_be_claimed_count 
    FROM user u 
    LEFT JOIN receipt r ON u.email = r.email 
    GROUP BY u.email";

$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

$userList = [];
$totalReceiptsByUser = [];
$toBeClaimedCountByUser = [];

while ($row = $result->fetch_assoc()) {
    $userList[] = $row;
    $totalReceiptsByUser[$row['email']] = $row['total_receipts'];
    $toBeClaimedCountByUser[$row['email']] = $row['to_be_claimed_count'];
}

$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Claim Status</title>
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

        </style>
            </head>
            <body class="bg-light">
<?php include 'headerAdmin.php'; ?>
<p class="gap">&nbsp;</p>
<p class="gap">&nbsp;</p>
<p class="gap">&nbsp;</p>

<div class="container mt-5">

    <h2 class="mb-4 text-center fw-bold">Check User's Purchases</h2>

    <?php if (empty($userList)): ?>
        <div class="alert alert-info text-center">No user is registered to this system.</div>
    <?php else: ?>
        
            <div class="row g-4">
                <?php foreach ($userList as $index => $item): ?>
                    <div class="col-md-12">
                        <div class="card shadow-sm">
                            <div class="card-body d-flex flex-wrap align-items-center justify-content-between">
                                <div class="d-flex align-items-center" style="min-width: 300px;">
                                    <div>
                                        <h5 class="card-title mb-1"><?= htmlspecialchars($item['username']) ?></h5>
                                        <p class="mb-0 text-muted"><?= htmlspecialchars($item['email']) ?></p>
                                    </div>
                                </div>

                                <div class="text-center mx-2">
                                    <label class="form-label mb-1">Purchase made: </label>
                                    <p class="fw-semibold mb-0"><?= number_format($totalReceiptsByUser[$item['email']]) ?></p>
                                </div>

                                <div class="text-center mx-2">
                                    <label class="form-label mb-1">No. of unclaimed items: </label>
                                    <p class="fw-semibold mb-0"><?= number_format($toBeClaimedCountByUser[$item['email']]) ?></p>
                                </div>

                                <div class="text-center">
                                <a href="statusChange.php"><button type="submit" class="btn btn-outline-primary me-2">View User's Purchase</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

    <?php endif; ?>
</div>

<p class="gap">&nbsp;</p>
<?php include 'footerAdmin.php'; ?>
</body>

</html>
