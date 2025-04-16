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
        <title>Term and Condition</title>
    </head>
    <body>
        <style>
            
            h1{
    text-align:center;
    padding-top: 10px;
}



p{
    font-size:16px;
    padding-left:40px;
    padding-right:40px;
}


            
            input#backbutton {
    border-color: beige;
    border-radius: 10px;
    padding: 5px 10px 5px 10px;
}


            </style>
        <h1>Term And Condition</h1>
        <p>1. Introduction<br>
By becoming a volunteer for Rizzy Tempo Music Society, you agree to the following terms and conditions. This agreement outlines the expectations, responsibilities, and rights of volunteers within our organization.
</p>
<p>
    2. Volunteer Position<br>
You understand that your role as a volunteer with Rizzy Tempo Music Society is vital to the success of our mission. Your position may involve tasks such as event coordination, promotion, administrative support, or any other duties deemed necessary by the society.
</p>
<p>
    3. Commitment<br>
As a volunteer, you agree to dedicate your time, skills, and efforts to fulfill the tasks assigned to you by the society. You commit to attending scheduled meetings, events, and training sessions unless prior arrangements have been made
</p>
<p>4. Confidentiality<br>
You acknowledge that you may have access to sensitive information about the society, its members, partners, or sponsors. You agree to maintain confidentiality regarding any information disclosed to you during your volunteer service and not to disclose such information without explicit permission.
</p>
<p>5. Code of Conduct<br>
You agree to conduct yourself in a professional and respectful manner at all times while representing Rizzy Tempo Music Society. This includes interactions with fellow volunteers, members, sponsors, and the general public. Discriminatory, harassing, or otherwise inappropriate behavior will not be tolerated and may result in termination of your volunteer status.
</p>
<p>6. Intellectual Property<br>
Any intellectual property created or developed by you during your volunteer service shall belong to Rizzy Tempo Music Society. This includes, but is not limited to, written materials, artwork, designs, and software.</p>
<p>7. Health and Safety<br>
You agree to adhere to all health and safety protocols established by Rizzy Tempo Music Society during your volunteer service. You are responsible for your own well-being and must report any hazards or concerns to the appropriate authority.
</p>
<p>8. Termination<br>
Rizzy Tempo Music Society reserves the right to terminate your volunteer status at any time, with or without cause. Reasons for termination may include, but are not limited to, violation of these terms and conditions, failure to fulfill volunteer duties, or conduct detrimental to the society's reputation.
</p>
<p>9. Amendment<br>
These terms and conditions may be amended or updated by Rizzy Tempo Music Society at any time. Volunteers will be notified of any changes, and continued service will constitute acceptance of the revised terms.</p>
<p>10. Agreement<br>
By volunteering for Rizzy Tempo Music Society, you acknowledge that you have read, understood, and agreed to abide by these terms and conditions. You understand that failure to comply with these terms may result in termination of your volunteer status.
</p>
<input type="button" onclick="back()" value="Back" id="backbutton" style="margin-left:20px;">
        <script>
            function back(){
                window.history.back();
            }
        </script>
    </body>
</html>
