<?php
/*
 * Copyright (c) 2023. Hanzal Akbar
 */
session_start();

if (!isset($_SESSION['user'])) {
    header('location: http://localhost/fuelin');
}

use Fuelin\FillingStationController;

include($_SERVER['DOCUMENT_ROOT'] . "/fuelin/database/DBConn.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/fuelin/controllers/UserController.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/fuelin/controllers/FillingStationController.php");


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FUELIN - Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
<?php include($_SERVER['DOCUMENT_ROOT'] . "/fuelin/navbar.php") ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <?php
            if (isset($_SESSION['message'])) {
                echo "<h5>" . $_SESSION['message'] . "</h5>";
                unset($_SESSION['message']);
            }
            ?>
            <div class="card">
                <div class="card-header">
                    <h4>New User</h4>
                </div>
                <div class="card-body">

                    <form action="../User.php" method="POST">
                        <div class="mb-3">
                            <label for="">Email</label>
                            <input maxlength="50" type="email" name="email" required class="form-control"/>
                        </div>
                        <div class="mb-3">
                            <label for="">Username</label>
                            <input maxlength="50" type="text" name="username" required class="form-control"/>
                        </div>
                        <div class="mb-3">
                            <label for="">Password</label>
                            <input maxlength="50" type="password" name="password" required class="form-control"/>
                        </div>
                        <div class="mb-3">
                            <label for="">Category</label>
                            <select name="category" required class="form-control">
                                <option>Station Employee</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="">Filling Station</label>
                            <select name="fillingstationid" required class="form-control">
                                <?php
                                $station = new FillingStationController;
                                $stationresult = $station->allstations($_SESSION['station'], $_SESSION['user']);
                                if ($stationresult) {
                                    foreach ($stationresult as $row) {
                                        echo "<option value='" . $row['FillingStationId'] . "'>" . $row['Location'] . ' | ' . $row['Name'] . "</option>";
                                    }
                                } ?>
                            </select>
                        </div>
                        <div class="button-group mb-3 ">
                            <button type="submit" name="saveUser" class="btn btn-primary">Create</button>
                            <button class="btn btn-danger" onclick="history.go(-1);">Back</button>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>