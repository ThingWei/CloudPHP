<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand me-auto" href="home.php">
            <img class="mslogo" src="img2/graduationcap.png" style="height:65px;width:65px;">
        </a>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">
                    <img class="mslogo" src="img2/graduationcap.png"> 
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
                    <li class="nav-item">
                        <a class="nav-link mx-lg-2 <?= $currentPage == 'home.php' ? 'active text-white' : '' ?>" href="home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-lg-2 <?= $currentPage == 'event.php' ? 'active text-white' : '' ?>" href="event.php">Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-lg-2 <?= $currentPage == 'orderHistory.php' ? 'active text-white' : '' ?>" href="orderHistory.php">Order History</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-lg-2 <?= $currentPage == 'aboutus.php' ? 'active text-white' : '' ?>" href="aboutus.php">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-lg-2 <?= $currentPage == 'feedback.php' ? 'active text-white' : '' ?>" href="feedback.php">Feedback</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-lg-2 <?= $currentPage == 'cart.php' ? 'active text-white' : '' ?>" href="cart.php">Cart</a>
                    </li>
                </ul>
            </div>
        </div>
        <a href="profile.php"><img class="profilepic" src="img/profile.png"></a>
        <button class="navbar-toggler pe-0" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>
