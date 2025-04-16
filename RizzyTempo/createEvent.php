<?php
session_start();
require_once 'helper.php';

// Check if the user is logged in
if (!isset($_SESSION['admin_email'])) {
    header('Location: index.php');
    exit();
}

?>

<html>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Create Event</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="css/header.css" rel="stylesheet">
        <link href="css/footer.css" rel="stylesheet">
        <link href="css/dragdrop.css" rel="stylesheet">
        <link href="css/error.css" rel="stylesheet" type="text/css"/>
        <style>
            .navbar {
                box-sizing: content-box;
            }

            input,
            textarea {
                box-sizing: border-box;
            }

            body {
                background: url(img/musicbg.jpg) no-repeat center;
                background-size: cover;
                width: 100%;
            }

            .btn {
                background-color: #00b383;
                border: 0;
            }

        </style>
    </head>

    <body>

        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg fixed-top">
            <div class="container-fluid">
                <a class="navbar-brand me-auto" href="homeAdmin.php"><img class="mslogo" src="img/music.png"></a>
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                     aria-labelledby="offcanvasNavbarLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasNavbarLabel"><img class="mslogo" src="img/music.png">
                            &nbsp; RT Music Society</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
                            <li class="nav-item">
                                <a class="nav-link mx-lg-2" aria-current="page"
                                   href="homeAdmin.php">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mx-lg-2" href="eventsAdmin.php">Events</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active mx-lg-2" style='color:white;' href="createEvent.php">Create Event</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mx-lg-2" href="deleteTicket.php">Ticket List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mx-lg-2" href="adminTicket.php">Insert Ticket</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mx-lg-2" href="list-payment.php">Payment List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mx-lg-2" href="list-login.php">User List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mx-lg-2" href="listVolunteer.php">Volunteer List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mx-lg-2" href="adminFeedback.php">Feedback</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mx-lg-2" href="aboutUsAdmin.php">About Us</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mx-lg-2" href="faqAdmin.php">FAQ</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <a href="profileAdmin.php"><img class="profilepic" src="img/adminprofile.png"></a>
                <button class="navbar-toggler pe-0" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>
        <!-- End of Navbar -->

        <h1>&nbsp;</h1>
        <h1>&nbsp;</h1>

        <div class='errorpage'>
            <?php
            require_once 'helper.php';

            //check if the user click any button?
            if (empty($_POST)) {
                //USER never click anything
            } else {
                //Yes,user click on a button
                //retreive user input 
                //trim (ignore space)from user

                $eventname = trim($_POST["eventName"]);
                $headline = $_POST["headline"];
                $description = $_POST["description"];
                $banner = $_POST["input-file"];
                $dateofevent = $_POST["dateOfEvent"];
                $eventtime = $_POST["eventTime"];
                $location = trim($_POST["location"]);

                //validation
                $error["eventName"] = checkEventName($eventname);
                $error["headline"] = checkHeadline($headline);
                $error["description"] = checkDesc($description);
                $error["input-file"] = checkBanner($banner);
                $error["dateOfEvent"] = checkDateOfEvent($dateofevent);
                $error["eventTime"] = checkEventTime($eventtime);
                $error["location"] = checkLocation($location);

                //remove null value
                $error = array_filter($error);

                if (empty($error)) {
                    //GOOD ,proceed to insert record 

                    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                    //step 2:sql statement 
                    $sql = "INSERT INTO event
                        (eventName,headline,description,eventBanner,dateOfEvent,time,location) VALUES
                         (?,?,?,CONCAT('img/', ?),?,?,?)";

                    $newtable = str_replace(' ', '_', $eventname);

                    $sql2 = "CREATE TABLE $newtable (username VARCHAR(50), email VARCHAR(50),
                             gender CHAR(1), FOREIGN KEY (email) REFERENCES user(email))";
                    //step 2.1 run sql
                    //NOTE: $con->query($sql);<< is for sql without "?"
                    //NOTE: $con->prepare($sql);<<is for sql with "?"
                    //parameter
                    $stmt = $con->prepare($sql);
                    $crtbl = $con->query($sql2);
                    //step 2.2 supply data into the "?" parameter in the sql 
                    //NOTE:s-string ,i-integer ,d-double,b-blob
                    $stmt->bind_param("sssssss", $eventname, $headline, $description, $banner, $dateofevent, $eventtime, $location);

                    //step 3:execute sql
                    $stmt->execute();

                    if ($stmt->affected_rows > 0) {

                        // Display the alert box; note the Js tags within echo, it performs the magic
                        echo "<script>alert('Event has been created.');document.location='eventsAdmin.php';</script>";
                    }

                    $stmt->close();
                    $crtbl->close();
                    $con->close();

                    // Display the alert box; note the Js tags within echo, it performs the magic
                    echo "<script>alert('Event has been CREATED!');</script>";
                } else {
                    //Not good ,display error msg
                    echo"<ul class='error'>";
                    foreach ($error as $value) {
                        echo "<li>$value</li>";
                    }
                    echo"</ul>";
                }
            }
            ?>
        </div>
        <!-- Form -->
        <div class="container">
            <div class="row">
                <div class="col-12 col-sn-8 col-nd-6 m-auto">
                    <div class="card">
                        <h2 class="d-flex justify-content-center" style="padding-top: 20px;">Create New Event</h2>
                        <hr>
                        <div class="card-body">
                            <form action="" method="post">
                                <label for="eventName">Event Name:</label>
                                <input style="margin-bottom: 1rem !important;" type="text" name="eventName"
                                       class="form-control py-2" placeholder="e.g Voice Of The MS">
                                <label for="headline">Event headline:</label>
                                <input style="margin-bottom: 1rem !important;" type="text" name="headline"
                                       class="form-control py-2"
                                       placeholder="e.g It's the time of the year again for the rerun of Voice Of The MS!">
                                <label for="description">Event Description:</label>
                                <textarea style="margin-bottom: 1rem !important;" type="text" name="description"
                                          class="form-control py-2" rows="6"
                                          placeholder="e.g join us if you're confident in showing your talent to everyone!..."></textarea>
                                <label for="">Event Banner:</label>
                                <div class="d-flex justify-content-center">
                                    <label for="input-file" id="drop-area">
                                        <div id="img-view">
                                            <img class="dropicon" src="img/icon.png">
                                            <p>Drag and Drop or Click here<br>to upload event Banner</p>
                                            <span class="droptexts">Upload any images from your PC</span>
                                        </div>
                                        <input type="file" accept="image/*" id="input-file" name="input-file" hidden onchange="handleFileUpload(event)">
                                    </label>
                                </div>
                                <label for="dateOfEvent">Date Of Event:</label>
                                <input style="margin-bottom: 1rem !important;" type="date" name="dateOfEvent"
                                       class="form-control py-2">
                                <label for="eventTime">Time Of Event:</label>
                                <input style="margin-bottom: 1rem !important;" type="text" name="eventTime"
                                       class="form-control py-2" placeholder='8PM - 10PM'>
                                <label for="location">Location:</label>
                                <input style="margin-bottom: 1rem !important;" type="text" name="location"
                                       class="form-control py-2" placeholder='Main Foyer'>
                                <div class="text-center mt-3">
                                    <br>
                                    <button type="submit" name="btnSubmit" class="btn btn-primary">Create</button>
                                    <button type="reset" name="btnReset" class="btn btn-primary"
                                            onclick='location = "createEvent.php"'>Reset</button>
                                    <button type="button" name="btnBack" class="btn btn-primary"
                                            onclick='window.location.href = "eventsAdmin.php"'>Back</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Form  -->

        <h1>&nbsp;</h1>

        <!-- Footer -->
        <div class="foot">
            <footer>
                <div class="rowfoot">
                    <div class="colfoot">
                        <img src="img/music.png" class="logofoot">
                        <p class="parafoot">Welcome to Rizzy Tempo Music Society, where passion meets melody and rhythm!
                            Whether you're a seasoned virtuoso or just beginning your musical journey, our society offers a
                            harmonious space for creativity, learning, and collaboration.</p>
                        <br>
                        <p class="parafoot">Join us as we embark on a symphonic adventure, doesn't matter if you're here to
                            listen, learn, or lend your talents!</p>
                    </div>
                    <div class="colfoot">
                        <h3>Contact Us<div class="underline"><span class="uline"></span></div>
                        </h3>
                        <p class="parafoot">77, Lorong Lembah</p>
                        <p class="parafoot">Permai 3, 11200 </p>
                        <p class="parafoot">Tanjung Bungah,</p>
                        <p class="parafoot">Pulau Pinang, Malaysia</p>
                        <p class="email-id">penang@tarc.edu.my</p>
                        <h4><a class="callus" href="tel:+04-899 5230">(+6) 04-899 5230</a></h4>
                    </div>
                    <div class="colfoot">
                        <h3>Navigation<div class="underline"><span class="uline"></span></div></h3>
                        <ul class="footnav" style='padding:0'>
                            <li><a href="homeAdmin.php">Dashboard</a></li>
                            <li><a href="eventsAdmin.php">Events</a></li>
                            <li><a href="createEvent.php">Create Event</a></li>
                            <li><a href="deleteTicket.php">Ticket List</a></li>
                            <li><a href="adminTicket.php">Insert Ticket</a></li>
                            <li><a href="list-payment.php">Payment List</a></li>
                            <li><a href="list-user.php">User List</a></li>
                            <li><a href="listVolunteer.php">Volunteer List</a></li>
                            <li><a href="adminFeedback.php">Feedback</a></li>
                            <li><a href="aboutUsAdmin.php">About Us</a></li>
                            <li><a href="faqAdmin.php">FAQ</a></li>
                        </ul>
                    </div>
                    <div class="colfoot">
                        <h3 style="font-size: 12px;" class="fblow">Find Us Thru Our Social Media Below!<div
                                class="underline"><span class="uline"></span></div>
                        </h3>
                        <div>
                            <a href="https://www.instagram.com/"><button id="insta" style="background-image: url(img/instalogo.png);background-size: cover; width: 45px;
                                                                         height: 43px; box-sizing: border-box;"></button></a>
                            <a href="https://www.facebook.com/"><button id="facebook" style="background-image: url(img/facebooklogo.png);background-size: cover; width: 45px;
                                                                        height: 43px; box-sizing: border-box;"></button></a>
                            <a href="https://twitter.com/"><button id="twitter" style="background-image: url(img/twitterlogo.png);background-size: cover; width: 45px;
                                                                   height: 43px; box-sizing: border-box;"></button></a>
                            <a href="https://mail.google.com/"><button id="email" style="background-image: url(img/maillogo.png);background-size: cover; width: 45px;
                                                                       height: 43px; box-sizing: border-box;"></button></a>
                            <a href="https://www.whatsapp.com/"><button id="phone" style="background-image: url(img/whatsapplogo.png);background-size: cover; width: 45px;
                                                                        height: 43px; box-sizing: border-box;"></button></a>
                        </div>
                    </div>
                </div>
                <hr>
                <p class="parafoot" style="text-align: center; font-size: 16px;">Rizzy Tempo Music Society @ 2024</p>
            </footer>
        </div>
        <!-- End Of Footer -->

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
        <script src="dragdrop.js"></script>
        <script>
                                                function validateFileType() {
                                                    var selectedFile = document.getElementById('input-file').files[0];
                                                    var allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];

                                                    if (!allowedTypes.includes(selectedFile.type)) {
                                                        alert('Invalid file type. Please upload a JPEG or PNG file.');
                                                        document.getElementById('input-file').value = '';
                                                    }
                                                }
                                                // Function to handle file upload
                                                function handleFileUpload(event) {

                                                    validateFileType(event);

                                                    // Get the uploaded file
                                                    const file = event.target.files[0];

                                                    // Generate the complete URL of the uploaded image
                                                    const imageURL = window.URL.createObjectURL(file);

                                                    // Now you can use the imageURL for displaying the image or further processing
                                                    console.log('Complete URL of the uploaded image:', imageURL);

                                                    // You can also update the image preview in the drop area
                                                    const imgView = document.getElementById('img-view');
                                                    imgView.innerHTML = `<img src="${imageURL}" alt="Uploaded Image">`;

                                                }

        </script>
    </body>

</html>