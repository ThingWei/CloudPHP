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
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Frequently Asked Question</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="css/faq.css" rel="stylesheet" type="text/css" />
        <link href="css/header.css" rel="stylesheet" type="text/css" />
        <link href="css/footer.css" rel="stylesheet" type="text/css" />

        <style>
            body {
                background: url(img/musicbg.jpg) no-repeat center;
                background-size: cover;
                width: 100%;
            }

            details {
                margin-bottom: 20px;
                background-color: #f2f2f2;
                padding: 10px;
                border-radius: 5px;
            }

            /* Style the summary element inside details */
            summary {
                cursor: pointer;
                font-size: 16px;
                font-weight: bold;
                background-color: #ddd;
                padding: 5px 10px;
                border-radius: 3px;
            }
            
        </style>
    </head>

    <body>
        <!-- Navbar -->
        <?php
        include 'headerUser.php';
        ?>
        <!-- End of Navbar -->

        <p class="gap">&nbsp;</p>
        <p class="gap">&nbsp;</p>
        <p class="gap">&nbsp;</p>

        <div class="container">
            <div class="header-text-box">
                <img src="https://www.smtusa.com/uploads/faqs.jpg" alt="alt"
                     style="width: 40%;margin-top: 50px;margin-left: 35%;margin-bottom: 70px;border-radius: 100px;" />
                <h1 style="margin-left: 32%;">About Frequently Asked Question</h1>
            </div>

            <section>
                <h2
                    style="margin-left: 35%;margin-top: 100px;margin-bottom: 20px; font-family: Times New Roman; font-weight: bold; font-size: 50px; color: #00566e">
                    Most for people ask</h2>
                <div class="grid-3-cols">
                    <div>
                        <p class="features-title"><strong>About Events</strong></p>
                        <p class="features-text">
                        <details>
                            <summary>What types of events does the society organize?</summary>
                            <p style=" font-size: 15px;color: #009987;">We will hosting all type of events.</p>
                        </details>
                        <details>
                            <summary>Are events open to non-members</summary>
                            <p style=" font-size: 15px;color: #009987;">Sometime we will open for non-members but just a few time.</p>
                        </details>
                        <details>
                            <summary>Can members suggest or organize events?</summary>
                            <p style=" font-size: 15px;color: #009987;">Sure.Members can request to related department and wait for
                                reply.</p>
                        </details>
                        </p>
                    </div>

                    <div>
                        <p class="features-title">
                            <strong>Instruments and Skill Levels</strong>
                        </p>
                        <p class="features-text">
                        <details>
                            <summary>What if I'm a beginner?</summary>
                            <p style=" font-size: 15px;color: #009987;">It is doesn't matter for that. </p>
                        </details>
                        <details>
                            <summary>Are there opportunities for lesson or workshops?</summary>
                            <p style=" font-size: 15px;color: #009987;">We have free lessons that is one hour for first time to let
                                people try.</p>
                        </details>
                        <details>
                            <summary>Is there equipment available use?</summary>
                            <p style=" font-size: 15px;color: #009987;">Yes, we have prepare some for spare.</p>
                        </details>
                        </p>
                    </div>

                    <div>
                        <p class="features-title">
                            <strong>Social and Networking</strong>
                        </p>
                        <p class="features-text">
                        <details>
                            <summary>Does the society organize social events?</summary>
                            <p style=" font-size: 15px;color: #009987;">Yes, something will have some event will be hold.</p>
                        </details>
                        <details>
                            <summary>Are there networking opportunities for members?</summary>
                            <p style=" font-size: 15px;color: #009987;">Don't worry, we also prepare some activity.</p>
                        </details>
                        </p>
                    </div>
                </div>
            </section>

            <section class="testimonial-section">
                <div class="grid-3-cols" style="margin-right: 20%;">

                    <div class="testimonial-box">
                        <h2>Is have other Frequently Asked Question can <a href="#">contest us</a></h2>
                    </div>
                </div>
            </section>
        </div>

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