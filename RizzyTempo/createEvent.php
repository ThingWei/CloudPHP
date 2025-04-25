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
        <title>Create Product</title>
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
                background-color: lightgray;
                background-size: cover;
                width: 100%;
            }

            .btn {
                background-color: #00b383;
                border: 0;
            }
            .createbtn{
            background-color:rgb(0, 202, 148);
            border: none;
            border-radius: 5px;
            padding: 5px;
            color: white;
            transition: 0.3s background-color;
        }

        .createbtn:hover{
            background-color: #009970;
            transform: scale(1.05);
        }
        .deletebtn{
            background-color:rgb(235, 0, 0);
            border: none;
            border-radius: 5px;
            padding: 5px;
            color: white;
            transition: 0.3s background-color;
        }

        .deletebtn:hover{
            background-color:rgb(185, 15, 15);
            transform: scale(1.05);
        }
        .backbtn{
            background-color:rgb(168, 168, 168);
            border: none;
            border-radius: 5px;
            padding: 5px;
            color: white;
            transition: 0.3s background-color;
        }

        .backbtn:hover{
            background-color:rgb(102, 102, 102);
            transform: scale(1.05);
        }
        </style>
    </head>

    <body>

        <!-- Navbar -->
        <?php
    include 'headerAdmin.php';
    ?>
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
                $banner = $_POST["base64-banner"];
                $productPrice = $_POST["productPrice"];
                $productType = $_POST["productType"];
                

                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                //validation
                function isEventNameDuplicate($eventname, $con) {
                    $sql = "SELECT * FROM event WHERE eventName = ?";
                    $stmt = $con->prepare($sql);
                    $stmt->bind_param("s", $eventname);
                    $stmt->execute();
                    $result = $stmt->get_result();
                
                    return $result->num_rows > 0; // true if found
                }

// Check if event name already exists
if (isEventNameDuplicate($eventname, $con)) {
    $error["eventName"] = "Event name already exists. Please choose a different name.";
} else {
    $error["eventName"] = checkEventName($eventname);
}
                $error["headline"] = checkHeadline($headline);
                $error["description"] = checkDesc($description);
                $error["base64-banner"] = checkBanner($banner);
                $error["productPrice"] = checkProductPrice($productPrice);
                $error["productType"] = checkProductType($productType);
                

                //remove null value
                $error = array_filter($error);

                if (empty($error)) {
                    //GOOD ,proceed to insert record 

                    //step 2:sql statement 
                    $sql = "INSERT INTO event
                        (eventName,headline,description,eventBanner,productPrice,productType) VALUES
                         (?,?,?,?,?,?)";

                    
                    //step 2.1 run sql
                    //NOTE: $con->query($sql);<< is for sql without "?"
                    //NOTE: $con->prepare($sql);<<is for sql with "?"
                    //parameter
                    $stmt = $con->prepare($sql);
                    
                    //step 2.2 supply data into the "?" parameter in the sql 
                    //NOTE:s-string ,i-integer ,d-double,b-blob
                    $stmt->bind_param("ssssss", $eventname, $headline, $description, $banner,$productPrice, $productType);

                    //step 3:execute sql
                    $stmt->execute();

                    if ($stmt->affected_rows > 0) {

                        // Display the alert box; note the Js tags within echo, it performs the magic
                        echo "<script>alert('$eventname has been created.');document.location='eventsAdmin.php';</script>";
                    }

                    $stmt->close();
                    
                    $con->close();

                    // Display the alert box; note the Js tags within echo, it performs the magic
                    echo "<script>alert('$eventname has been CREATED!');</script>";
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
                    <h1 class="d-flex justify-content-center" style="padding-top: 20px;">Create New Product</h1>
                    <div class="card">
                        
                        <hr>
                        <div class="card-body">
                            <form action="" method="post">
                                <label for="eventName">Product Name:</label>
                                <input style="margin-bottom: 1rem !important;" type="text" name="eventName"
                                       class="form-control py-2" placeholder="e.g Flower Bouquet">
                                <label for="headline">Product headline:</label>
                                <input style="margin-bottom: 1rem !important;" type="text" name="headline"
                                       class="form-control py-2"
                                       placeholder="e.g Good flowers for your loved ones!">
                                <label for="description">Product Description:</label>
                                <textarea style="margin-bottom: 1rem !important;" type="text" name="description"
                                          class="form-control py-2" rows="6"
                                          placeholder="e.g A very cute flowers for your loved ones"></textarea>
                                <label for="">Product Banner:</label>
                                <div class="d-flex justify-content-center">
                                    <label for="input-file" id="drop-area">
                                        <div id="img-view">
                                            <img class="dropicon" src="img/icon.png">
                                            <p>Drag and Drop or Click here<br>to upload Product Banner</p>
                                            <span class="droptexts">Upload any images from your PC</span>
                                        </div>
                                        <input type="file" id="input-file" onchange="base64(this)" hidden>
<input type="hidden" name="base64-banner" id="base64-banner">
<img id="b64img" hidden>

                                    </label>
                                    
                                    <img id="b64img" src="" alt="Image Preview" style="display:none; width: 100px; height: 100px; margin-left: 20px;">
                                </div>
                                <label for="productPrice">Product Price:</label>
<input type="number" name="productPrice" class="form-control py-2 mb-3"
       step="0.01" min="0"
       placeholder="e.g. 29.99">
       <label for="productType">Product Type:</label>
<select name="productType" class="form-control py-2 mb-3" required>
    <option value="" disabled selected>Select a product type</option>
    <option value="gifts">Gifts</option>
    <option value="flowers">Flowers</option>
    <option value="gowns">Gowns</option>
    <option value="caps">Caps</option>
    <option value="photo frame">Photo Frame</option>
</select>
                                <div class="text-center mt-3">
                                    <br>
                                    <button type="submit" name="btnSubmit" class="createbtn">Create</button>
                                    <button type="reset" name="btnReset" class="deletebtn"
                                            onclick='location = "createEvent.php"'>Reset</button>
                                    <button type="button" name="btnBack" class="backbtn"
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
        <?php 
        include 'footerAdmin.php';
        ?>
        <!-- End Of Footer -->

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
        <script src="dragdrop.js"></script>
        <script>


               function base64(obj) {
    if (!obj.files || !obj.files[0]) {
        alert("No file selected");
        return;
    }

    var reader = new FileReader();
    reader.readAsDataURL(obj.files[0]);

    reader.onload = function () {
        const result = reader.result;
        console.log("Base64 result:", result);
        document.getElementById("base64-banner").value = result;
        document.getElementById("b64img").src = result;
        document.getElementById("b64img").style.display = 'block';
    };

    reader.onerror = function (error) {
        console.error("Error reading file:", error);
    };
}


        </script>
    </body>

</html>