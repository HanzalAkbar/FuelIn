<?php
/*
 * Copyright (c) 2023. Hanzal Akbar
 */

session_start();

//redirect if logged in
if (isset($_SESSION['user'])) {
    header('location: http://localhost/fuelin');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>FuelIn Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600&family=Rubik:wght@500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <link href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet"/>
    <link href="/fuelin/lib/animate/animate.min.css" rel="stylesheet">
    <link href="/fuelin/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="/fuelin/css/bootstrap.min.css" rel="stylesheet">
    <link href="/fuelin/css/style.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        .divider:after,
        .divider:before {
            content: "";
            flex: 1;
            height: 1px;
            background: #eee;
        }

        .h-custom {
            height: calc(100% - 73px);
        }

        @media (max-width: 450px) {
            .h-custom {
                height: 100%;
            }
        }
    </style>
</head>
<section class="vh-100">
    <div class="container-fluid h-custom">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-md-9 col-lg-6 col-xl-5">
                <a class="navbar-brand" href="/fuelin/index.php">
                    <img src="/fuelin/assets/images/logo.png"
                         class="img-fluid" alt="FuelIn">
                </a>
            </div>
            <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                <form method="POST" action="../User.php">
                    <fieldset>
                        <div class="form-outline mb-4">
                            <label class="form-label" for="userinput">Username</label>
                            <input name="username" id="userinput" class="form-control form-control-lg"
                                   placeholder="Enter Username"/>
                        </div>
                        <div class="form-outline mb-3">
                            <label class="form-label" for="passinput">Password</label>
                            <input name="password" type="password" id="passinput" class="form-control form-control-lg"
                                   placeholder="Enter Password"/>
                        </div>
                        <div class="text-center text-lg-start mt-4 pt-2">
                            <button type="submit" name="login" class="btn btn-primary btn-lg"
                                    style="padding-left: 2.5rem; padding-right: 2.5rem;">Login
                            </button>
                        </div>
                    </fieldset>
                </form>
            </div>
            <?php
            if (isset($_SESSION['message'])) {
                ?>
                <div class="alert alert-info text-center">
                    <?php echo $_SESSION['message']; ?>
                </div>
                <?php

                unset($_SESSION['message']);
            }
            ?>
        </div>
    </div>
</section>
</html>