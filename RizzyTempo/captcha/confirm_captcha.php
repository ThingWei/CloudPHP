<?php
session_start();
//$conn = mysqli_connect("localhost", "root", "test", "blog_samples") or die("Connection Error: " . mysqli_error($conn));

if (count($_POST) > 0) {
    if ($_POST["captcha_code"] == $_SESSION["captcha_code"]) {
        $success_message = "Your message received successfully";
        //mysqli_query($conn, "INSERT INTO tblcontact (user_name, user_email,subject,content) VALUES ('" . $_POST['userName'] . "', '" . $_POST['userEmail'] . "','" . $_POST['subject'] . "','" . $_POST['content'] . "')");
    } else {
        $error_message = "Incorrect Captcha Code";
    }
}
?>