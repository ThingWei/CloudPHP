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
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms and Conditions - TARUMT Graduation Service</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('img2/background.png') no-repeat center center fixed;
                background-size: cover;
                width: 100%;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 40px;
        }
        .container-box {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 900px;
            margin: auto;
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #004080;
        }
        p, li {
            font-size: 16px;
            line-height: 1.6;
        }
        ol {
            padding-left: 20px;
        }
        #backbutton {
            background-color: #004080;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 8px;
            transition: 0.3s;
        }
        #backbutton:hover {
            background-color: #0059b3;
        }
    </style>
</head>
<body>

    <div class="container-box">
        <h1>Terms and Conditions</h1>
        <p>Welcome to the TARUMT Graduation Service portal. By using this platform, you agree to the following terms and conditions, which govern the use of services provided by TAR UMT related to graduation event bookings and associated services.</p>
        
        <p>The term <strong>TARUMT</strong>, <strong>we</strong>, or <strong>our</strong> refers to the management team of TAR UMT Graduation Services. The term <strong>you</strong> refers to the user or viewer of this portal.</p>
        
        <ol>
            <li>All information provided on this portal is subject to change without prior notice.</li>
            <li>The platform may use cookies for session tracking and personalization purposes. You agree to this by using the site.</li>
            <li>TARUMT is not liable for any inaccuracies in event details, schedules, or personal data entries.</li>
            <li>Users are responsible for ensuring that the data they enter during booking is accurate and up to date.</li>
            <li>All content, including logos, layout, and event materials, is owned by TARUMT and reproduction without permission is prohibited.</li>
            <li>Unauthorized use or tampering with the system may result in legal action or account suspension.</li>
            <li>The platform may link to external sites for graduation merchandise or services. TARUMT holds no responsibility over external content.</li>
            <li>Your use of this portal is subject to the laws of Malaysia, and any disputes will be resolved under Malaysian jurisdiction.</li>
        </ol>

        <div class="text-start mt-4">
            <input type="button" onclick="back()" value="Back" id="backbutton">
        </div>
    </div>

    <script>
        function back() {
            window.location.href = "feedback.php";
        }
    </script>

</body>
</html>
