<?php


if (isset($_SESSION['user'])) {
    ?>

    <!-- Bootstrap CSS -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600&family=Rubik:wght@500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">


    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow" style="height: 100px">
        <div class="container">
            <a class="navbar-brand" href="http://localhost/fuelin" style="margin-top: -1%">
                <img src="/fuelin/assets/images/logo.png" class="web-logo" alt="FuelIn"
                     style=""
                >
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <ul class="navbar-nav ms-auto mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost/fuelin" style="font-size: medium">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/fuelin/views/fillingstation/FillingStation-view.php"
                           style="font-size: medium">Filling Stations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/fuelin/views/fuelque/FuelQue-view.php"
                           style="font-size: medium">Fuel Que</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/fuelin/views/delivery/Delivery-view.php"
                           style="font-size: medium">Delivery Schedules</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/fuelin/views/user/User-view.php"
                           style="font-size: medium">User Management</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/fuelin/views/user/User-logout.php"
                           style="font-size: medium">Logout</a>
                    </li>
                </ul>

            </div>
        </div>
    </nav>
    <?php
} else {
    ?>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600&family=Rubik:wght@500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow" style="height: 100px">
        <div class="container">
            <a class="navbar-brand" href="http://localhost/fuelin" style="margin-top: -1%">
                <img src="/fuelin/assets/images/logo.png" class="web-logo" alt="FuelIn">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <ul class="navbar-nav ms-auto mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost/fuelin" style="font-size: medium">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/fuelin/views/fuelque/FuelQue-add.php"
                           style="font-size: medium">Make a Fuel Request</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/fuelin/views/user/User-login.php"
                           style="font-size: medium">Login</a>
                    </li>
            </div>
        </div>
    </nav>
    <?php
}
?>