<?php
session_start();
require_once 'helper.php';

// Check if the user is logged in
if (!isset($_SESSION['user_email'])) {
    header('Location: index.php');
    exit();
}
//Check if the user click any button?
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

if (isset($_POST["submit"])) {
    // Yes, user click on a button
    // Retrieve user input
    // Trim (ignore space) from user
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $address = trim($_POST["address"]);
    $address2 = trim($_POST["address2"]);
    $country = trim($_POST["country"]);
    $city = $_POST["city"];
    $region = $_POST["region"];
    $poscode = trim($_POST["poscode"]);
    $cardNumber = trim($_POST["cardNumber"]);
    $expMonth = $_POST["expMonth"];
    $expYear = $_POST["expYear"];
    $cvv = trim($_POST["cvv"]);

    // Initialize $error as an empty array
    $error = array();

    $error["email"] = checkEmail2($email);
    
    if (empty($address)) {
        $error["address"] = "Address is required.";
    }

    if (empty($poscode)) {
        $error["poscode"] = "Postal code is required.";
    } elseif (!preg_match("/^[0-9]{5}$/", $poscode)) {
        $error["poscode"] = "Invalid postal code format.";
    }

    if (empty($city)) {
        $error["city"] = "City is required.";
    }

    if (empty($region)) {
        $error["region"] = "Region is required.";
    }

    if (empty($cardNumber)) {
        $error["cardNumber"] = "Card number is required.";
    } elseif (!preg_match("/^[0-9-]{16}$/", $cardNumber)) {
        $error["cardNumber"] = "Invalid card number format.";
    }

    if (empty($cvv)) {
        $error["cvv"] = "CVV is required.";
    } elseif (!preg_match("/^[0-9]{3}$/", $cvv)) {
        $error["cvv"] = "Invalid CVV format.";
    }

    // Remove null value
    
    $errors = array_filter($error);

    if (!empty($errors)) {
        echo "<script>";
        foreach ($errors as $msg) {
            echo "alert('" . addslashes($msg) . "');";
        }
        echo "</script>";
    }

    if (empty($errors)) {
        // safe to proceed with DB insert
        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }

        // Get cart details
        $sql = "SELECT c.eventName, c.quantity, e.productPrice AS price
                FROM cart c
                JOIN event e ON c.eventName = e.eventName
                WHERE c.user_email = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("s", $useremail);
        $stmt->execute();
        $result = $stmt->get_result();

        // Insert payment
        $insertSQL = "INSERT INTO payment (email, eventName, price, cardNumber) VALUES (?, ?, ?, ?)";
        $insertStmt = $con->prepare($insertSQL);

        while ($row = $result->fetch_assoc()) {
            $eventName = $row['eventName'];
            $price = $row['price'];
            $quantity = $row['quantity'];

            while ($quantity > 0) {
            $insertStmt->bind_param("ssds", $useremail, $eventName, $price, $cardNumber);
            $insertStmt->execute();
            $quantity--;
            }
        }

        $insertStmt->close();

        $checkNum = "SELECT * FROM receipt";

            //ask coonection to run sql query 
            $resultR = $con->query($checkNum);

            if ($result->num_rows > 0) {
                //record found
                //why while loop? while i can still access the record
                //we will retreive 
                //fetch_object() - take record 1 by 1 from $result 

                $totalReceiptNum = $resultR->num_rows;

                $resultR->free();
            }

        // insert into receipt table
        $checkCart = "
            SELECT 
            c.eventName, 
            e.productPrice AS price,
            c.quantity
            FROM cart c
            JOIN event e ON c.eventName = e.eventName
            WHERE c.user_email = '$useremail'
        ";
        $result = $con->query($checkCart);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_object()) {
                // Cart is not empty, proceed with the insert
                $prodname = $row->eventName;
                $price = $row->price;
                $quantity = $row->quantity;
                $claimStatus = 'TO BE CLAIMED';
                $receiptID = $totalReceiptNum + 1; // Assuming receiptID is auto-incremented

                $insertReceiptSQL = "INSERT INTO receipt (receiptID, email, eventName, price, quantity, claimStatus) VALUES (?, ?, ?, ?, ?, ?)";
                $insertReceiptStmt = $con->prepare($insertReceiptSQL);
                $insertReceiptStmt->bind_param("issdis", $receiptID, $useremail, $prodname, $price, $quantity, $claimStatus);
                $insertReceiptStmt->execute();
                $totalReceiptNum++;

                $row = $result->fetch_object();
                if ($row !== null) {
                    $prodname = $row->eventName;
                    $price = $row->price;
                    $quantity = $row->quantity;
                    $claimStatus = 'TO BE CLAIMED';
                    $receiptID = $totalReceiptNum + 1; // Assuming receiptID is auto-incremented

                    $insertReceiptSQL = "INSERT INTO receipt (receiptID, email, eventName, price, quantity, claimStatus) VALUES (?, ?, ?, ?, ?, ?)";
                    $insertReceiptStmt = $con->prepare($insertReceiptSQL);
                    $insertReceiptStmt->bind_param("issdis", $receiptID, $useremail, $prodname, $price, $quantity, $claimStatus);
                    $insertReceiptStmt->execute();
                    $totalReceiptNum++;
                } else {
                    break; // No more rows to process
                }
            }
            $result->free();
            $insertReceiptStmt->close();
        }
        // Clear cart
        $con->query("DELETE FROM cart WHERE user_email = '$useremail'");
        $con->close();
        echo "<script>alert('Payment successful!'); window.location.href='orderHistory.php';</script>";
    }
}


?>

<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Payment</title>
        
        <!-- Bootstrap Css -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="css/payment.css">
    </head>
    <body>    
        <header>
            <div class="title">
                <h1><b>TARUMT Service</b></h1>
            </div>

            <div class="movementTitle">
                <h1 class="title2">Thank You For Your Support!</h1>
            </div>

        </header>
        <div class="everything">
            <div>
                <div class="receipt-container" >
                    <h1>&nbsp;</h1>
                    <h1>&nbsp;</h1>
                    <div class="receipt">
                        <div class="header">
                            <h2><b>Invoice</b></h2>
                        </div>
                        <?php


if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit();
}

$user_email = $_SESSION['user_email'];


$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

$sql = "
    SELECT 
        c.cartID, 
        c.eventName,  
        c.quantity, 
        e.productPrice AS price
    FROM cart c
    JOIN event e ON c.eventName = e.eventName
    WHERE c.user_email = ?
";

$stmt = $con->prepare($sql);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();

$total = 0;
?>
<div style="border solid 1px #ccc; padding: 10px; border-radius: 20px; background-color: #f9f9f9;">
<div style="max-height: 300px; overflow-y: scroll;">
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()):
            $subtotal = $row['price'] * $row['quantity'];
            $total += $subtotal;
            
        ?>     
        <div class="shadow-sm" style="padding: 20px">
            <h3 class="mb-0"><strong><?= htmlspecialchars($row['eventName']) ?></strong></h3>
            <p class="m-0" style="padding: 5px"><strong>Price:</strong> RM<?= number_format($row['price'], 2) ?></p><br>
            <p class="m-0" style="padding: 5px"><strong>Quantity:</strong> <?= $row['quantity'] ?></p><br>
            <p class="m-0" style="padding: 5px"><strong>Subtotal:</strong> RM<?= number_format($subtotal, 2) ?></p>
        </div>                    
                
        <?php endwhile; ?>
    <?php else: ?>
        <div class="alert alert-info text-center">Your cart is empty.</div>
    <?php endif; ?>
</div>
</div>
<?php if ($total > 0): 
        echo '<div style="padding-top: 10px;">';
        echo "<p><strong>Total: RM ".number_format($total, 2)."</strong</p>";
        echo '</div>';
else:
        echo '<div style="padding-top: 10px;">';
        echo "<p><strong>Total: RM0.00</strong></p>";
        echo '</div>';
    endif; 
?>

<?php
$stmt->close();
$con->close();
?>

                        <div class="footer" style="margin-top: 0;">
                            <p>Please double check your order!</p>
                        </div>
                    </div>
                </div>
            </div>
            <form id="payment" method='post' action='payment.php'>
                <div class="container">
                    <div class="left">
                        <h1>Billing Address</h1>
                        <label>Username</label>
                        <input type="text" id="fnBox" name='name' value="<?php echo $uname ?>" placeholder="Enter Your Name"/>
                        <br><br>
                        <label>Email</label>
                        <input type="text" id="emailBox" name='email' onkeyup="validateEmail()" value="<?php echo $uemail ?>" placeholder="Enter Your Email"/>
                        <p id="emailError"></p>


                        <div class="input-box">
                            <label>Address</label>
                            <input type="text" id="inputBox" name="address" placeholder="Enter street address"/>
                            <?php if (!empty($error['address'])): ?>
        <span style="color: red;"><?php echo $error['address']; ?></span>
    <?php endif; ?>
    <br><br>
                            <input type="text" id="inputBox" name="address2" placeholder="Enter street address line 2"/>
                            <div class="column">
                                <input type="text" id="inputBox" name="country" placeholder="Enter your country"/>
                                <input type="text" id="inputBox" name="city" placeholder="Enter your city"/>
                            </div>
                            <div class="column">
                                <input id="region" type="text"  name="region" placeholder="Enter your region"/>                                                   
                                <input id="poscode" type="number" name="poscode" placeholder="Enter postal code"/>                   
                            </div>
                        </div>
                    </div>
                    <div class="right">
                    <button class='x' onclick="location = 'cart.php'">×</button>
                    <h1>Payment Details</h1>

                    <br><br>
                    <label>Accepted Cards</label>
                    <br>
                    <img src="img/visa.png">
                    <img src="img/mastercard.png">
                    <img src="img/jcb.png">                        
                    <img src="img/paypal.png">
                    <br>
                    <label>Card Number</label><br>
                    <input type="text" name="cardNumber" id="cardNumberBox" onkeyup="checkCardNumber()" placeholder="Enter Your Card Number" value="<?php echo isset($cardNumber) ? $cardNumber : ''; ?>" required>
                    <p id="message"></p>

                    <br>

                    <label for="expMonth">Exp Month</label>
                    <select name="expMonth" class="monthBox" required>
                        <option value="">Month</option>
                        <option value="01">01</option>
                        <option value="02">02</option>
                        <option value="03">03</option>
                        <option value="04">04</option>
                        <option value="05">05</option>
                        <option value="06">06</option>
                        <option value="07">07</option>
                        <option value="08">08</option>
                        <option value="09">09</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>

                    <br><br>

                    <label>Exp year</label>
                    <select name="expYear" class="yearBox" required>
                        <option value="" >Year</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                        <option value="2027">2027</option>
                        <option value="2028">2028</option>
                    </select>
                    </label>


                    <br><br>
                    <label>
                        CVV  
                        <input id="cvvBox" name="cvv" class="cvv"  onkeyup="checkCvvNumber()" placeholder="CVV" value="<?php echo isset($cvv) ? $cvv : ''; ?>" required>
                        <p id="response"></p>
                    </label>
                    <br><br>
                        <input id="submit" name="submit" type="submit" value="Proceed To Pay">
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>

<script>

    function checkCardNumber() {
        var cardNumberBox = document.getElementById("cardNumberBox");
        var message = document.getElementById("message");
        cardNumberBox.value = cardNumberBox.value.replace(/\D/g, '');
        if (cardNumberBox.value.length == 16) {
            message.innerHTML = "Valid card number";
            cardNumberBox.style.borderColor = "green";
            message.style.backgroundColor = "#3ae374";
            message.style.top = "120%";
            return true;
        } else {
            message.innerHTML = "Card Number must be 16 digits";
            cardNumberBox.style.borderColor = "red";
            message.style.backgroundColor = "#ff4d4d";
            message.style.top = "120%";
            return false;
        }
    }

    function checkCvvNumber() {
        var cvvNumberBox = document.getElementById("cvvBox");
        var response = document.getElementById("response");
        cvvNumberBox.value = cvvNumberBox.value.replace(/\D/g, '');
        if (cvvNumberBox.value.length == 3) {
            response.innerHTML = "Valid CVV number";
            cvvNumberBox.style.borderColor = "green";
            response.style.backgroundColor = "#3ae374";
            response.style.top = "120%";
            return true;
        } else {
            response.innerHTML = "CVV Number must be 3 digits";
            cvvNumberBox.style.borderColor = "red";
            response.style.backgroundColor = "#ff4d4d";
            response.style.top = "120%";
            return false;
        }
    }

    function validateEmail() {
        var emailField = document.getElementById("emailBox");
        var emailError = document.getElementById("emailError");

        if (!emailField.value.match(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/)) {
            emailError.innerHTML = "Please enter a valid email";
            emailField.style.borderColor = "red";
            emailError.style.backgroundColor = "#ff4d4d";
            emailError.style.top = "120%";
            return false;
        } else {
            emailError.innerHTML = "valid email";
            emailField.style.borderColor = "green";
            emailError.style.backgroundColor = "#3ae374";
            emailError.style.top = "120%";
            return true;
        }
    }
</script>
