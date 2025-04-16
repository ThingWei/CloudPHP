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
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="UTF-8">
        <title>Term And Condition</title>
        <link href="css/condition.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <style>
            h1{
    text-align:center;
    padding-top: 10px;
}

div {
    padding-bottom: 30px;
}

p{
    font-size:16px;
    padding-left:40px;
    padding-right:40px;
}

ol {
    font-size: 19px;
}

li{
    font-size:16px;
    padding-left:25px;
    padding-right:25px;
}

input#backbutton {
    border-color: beige;
    border-radius: 10px;
    padding: 5px 10px 5px 10px;
}


        </style>
         <div class="container" style="width:800px;height:700px;;background-color:grey;margin-left:400px;">
             <h1>Term And Condition</h1>
        <p>Welcome to our website. If you continue to browse and use this website, you are agreeing to comply with and be bound by the following terms and conditions of use, which together with our privacy policy govern Rizzy Tempo Music Society's relationship with you in relation to this website. If you disagree with any part of these terms and conditions, please do not use our website.</p>
        <p>The term Rizzy Tempo Music Society or 'us' or 'we' refers to the owner of the website whose registered office is 77, Lorong Lembah Permai 3, 11200 Tanjung Bungah,Pulau Pinang, Malaysia
 The term 'you' refers to the user or viewer of our website.</p>
        <ol>The use of this website is subject to the following terms of use:</ol>
        <li>The content of the pages of this website is for your general information and use only. It is subject to change without notice. </li>
        <li>This website uses cookies to monitor browsing preferences. If you do allow cookies to be used, the following personal information may be stored by us for use by third parties: [insert list of information].</li>
        <li>Neither we nor any third parties provide any warranty or guarantee as to the accuracy, timeliness, performance, completeness or suitability of the information and materials found or offered on this website for any particular purpose. You acknowledge that such information and materials may contain inaccuracies or errors and we expressly exclude liability for any such inaccuracies or errors to the fullest extent permitted by law.
        </li>
        <li>Your use of any information or materials on this website is entirely at your own risk, for which we shall not be liable. It shall be your own responsibility to ensure that any products, services or information available through this website meet your specific requirements</li>
        <li>This website contains material which is owned by or licensed to us. This material includes, but is not limited to, the design, layout, look, appearance and graphics. Reproduction is prohibited other than in accordance with the copyright notice, which forms part of these terms and conditions.
        </li>
        <li>All trade marks reproduced in this website which are not the property of, or licensed to, the operator are acknowledged on the website.
        </li>
        <li>Unauthorised use of this website may give rise to a claim for damages and/or be a criminal offence.</li>
        <li>From time to time this website may also include links to other websites. These links are provided for your convenience to provide further information. They do not signify that we endorse the website(s). We have no responsibility for the content of the linked website(s).
        </li>
        <li>Your use of this website and any dispute arising out of such use of the website is subject to the laws of Malaysia.
        </li>
        <br>
        <input type="button" onclick="back()" value="Back" id="backbutton" style="margin-left:20px;">
        <script>
            function back(){
                window.open("feedback.php");
            }
        </script>
        </div>
        
    </body>
</html>
