<?php
session_start();
require_once 'helper.php';

// Check if the user is logged in
if (!isset($_SESSION['user_email'])) {
    header('Location: index.php');
    exit();
}
$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
$useremail = $_SESSION['user_email'];

$sql2 = "SELECT * FROM user WHERE email = '$useremail'";
$result2 = $con->query($sql2);
if ($row2 = $result2->fetch_object()) {
    $uname = $row2->username;
    $uemail = $row2->email;
    $ugender = $row2->gender;
}

$result2->free();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <title>Receipt</title>
        <style>
            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background-color: #f8f8f8;
                margin: 0;
                padding: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                background: url(img/musicbg.jpg) no-repeat center;
                background-size: cover;
                width: 100%;
            }
            .receipt {
                background-color: #fff;
                border-radius: 20px;
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.5);
                padding: 30px;
                text-align: center;
                max-width: 500px;
                width: 100%;
                position: relative;
                margin: 50px 0 50px 0;
            }
            .receipt::before {
                content: '';
                position: absolute;
                top: -20px;
                left: calc(50% - 20px);
                width: 40px;
                height: 40px;
                background-color: #FF5722;
                border-radius: 50%;
                box-shadow: 0 0 20px rgba(255, 87, 34, 0.5);
            }
            .receipt h2 {
                color: #333;
                margin-bottom: 20px;
            }
            .receipt p {
                margin: 10px 0;
            }
            .receipt .highlight {
                color: #FF5722;
                font-weight: bold;
            }
            .receipt .header {
                background-color: #FF5722;
                color: #fff;
                border-radius: 20px 20px 0 0;
                padding: 20px;
                margin-bottom: 20px;
            }
            .receipt .footer {
                background-color: #f8f8f8;
                border-radius: 0 0 20px 20px;
                padding: 20px;
                margin-top: 20px;
            }
            .btn {
                background-color: #00b383;
                border: 0;
                margin-top: 20px;
            }
            .unclaimDiv {
                margin: auto;
                border: 2px solid red;
                border-radius: 10px;
                background-color: pink;
                max-width: 200px;
                margin-top: 5px;
            }
            .claimedDiv {
                margin: auto;
                border: 2px solid #00ab41;
                border-radius: 10px;
                background-color: #d1ffbd;
                max-width: 200px;
                margin-top: 5px;
            }
        </style>
    </head>
    <body>
        <div class="receipt-container">
            <div class="receipt">
                <div class="header">
                    <h2>Thank you</h2>
                </div>
                <?php
                require_once 'helper.php';

                // Create connection
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                // Check connection
                if ($con->connect_error) {
                    die("Connection failed: " . $con->connect_error);
                }

                $id = $_GET['receiptID'] ?? '';
                $sql = "SELECT receipt.*, event.eventBanner FROM receipt 
                JOIN event ON receipt.eventName = event.eventName
                WHERE email = '$uemail' AND receiptID = '$id'";

                
                $result = $con->query($sql);

               
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    
                    echo "<img src='".htmlspecialchars($row['eventBanner'])."' alt='Banner' class='img-thumbnail' style='width: 170px; height: 100px; object-fit: cover;'>";
                    echo "<h3 class='mb-0' style='padding: 20px;'><strong>" .htmlspecialchars($row['eventName']). "</strong></h3>";
                    echo "<p><strong>Price:</strong> RM " .number_format($row['price'], 2). "</p>";
                    echo "<p><strong>Quantity:</strong> " .$row['quantity']. "</p>";
                    echo "<p><strong>Subtotal:</strong> RM " .number_format($row['price'] * $row['quantity'], 2). "</p>";
                    echo "<p><strong>Purchased at:</strong> " .htmlspecialchars($row['added_at']). "</p>";
                    if ($row['claimStatus'] === "TO BE CLAIMED"){
                        echo "<p style='color:red; margin:0'>" .htmlspecialchars($row['claimStatus']) ."</p>";
                        echo "<div class='unclaimDiv' style='padding:5px;'>";
                        echo "Please show this receipt to the receptionist and claim your item at TARUMT Main Foyer.";
                        echo "</div>";
                    } else {
                        echo "<p style='color:green; margin:0'>" .htmlspecialchars($row['claimStatus']) ."</p>";
                        echo "<div class='claimedDiv' style='padding:5px;'>";
                        echo "Thanks for purchasing from us!<br>We hope to see you again soon!";
                        echo "</div>";
                    }
                        
                }

              
                $result->free();
                $con->close();
                ?>
                <div class="footer">
                    <p>Thank you for your purchase!<br>You may print out or present this receipt.</p>
                </div>
                <button type="button" name='print' class='btn btn-primary' onclick='print()'>Print Receipt</button>
                <button type="button" name="btnBack" class="btn btn-primary"
                        onclick='window.location.href = "orderHistory.php"'>Back</button>
            </div>
        </div>

    </body>
</html>
