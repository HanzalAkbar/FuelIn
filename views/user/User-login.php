<?php
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