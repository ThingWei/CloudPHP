<!-- Navbar -->
<?php
$currentPage = basename($_SERVER['PHP_SELF']); // e.g., "homeAdmin.php"
?>

<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand me-auto" href="homeAdmin.php"><img class="mslogo" src="img2/graduationcap.png"></a>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
             aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel"><img class="mslogo" src="img2/graduationcap.png">
                    &nbsp; TARUMT Graduation Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-center flex-grow-1 pe-3">
                    <li class="nav-item">
                        <a class="nav-link mx-lg-2 <?= $currentPage == 'homeAdmin.php' ? 'active text-white' : '' ?>" href="homeAdmin.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-lg-2 <?= $currentPage == 'eventsAdmin.php' ? 'active text-white' : '' ?>" href="eventsAdmin.php">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-lg-2 <?= $currentPage == 'createEvent.php' ? 'active text-white' : '' ?>" href="createEvent.php">Create Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-lg-2 <?= $currentPage == 'list-payment.php' ? 'active text-white' : '' ?>" href="list-payment.php">Payment List</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-lg-2 <?= $currentPage == 'list-login.php' ? 'active text-white' : '' ?>" href="list-login.php">User List</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-lg-2 <?= $currentPage == 'listVolunteer.php' ? 'active text-white' : '' ?>" href="listVolunteer.php">Volunteer List</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-lg-2 <?= $currentPage == 'adminFeedback.php' ? 'active text-white' : '' ?>" href="adminFeedback.php">Feedback</a>
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