<?php
/*
 * Copyright (c) 2023. Hanzal Akbar
 */

session_start();

if (!isset($_SESSION['user'])) {
    header('location: http://localhost/fuelin');
}

use Fuelin\DatabaseConnection;
use Fuelin\UserController;
use Fuelin\FillingStationController;

include($_SERVER['DOCUMENT_ROOT'] . "/fuelin/database/DBConn.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/fuelin/controllers/UserController.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/fuelin/controllers/FillingStationController.php");

$db = new DatabaseConnection;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FUELIN - Users</title>
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

</head>
<body>
<?php include($_SERVER['DOCUMENT_ROOT'] . "/fuelin/navbar.php") ?>

<div class="container px-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>User Edit</h4>
                </div>
                <div class="card-body">
                    <?php
                    if (isset($_GET['id'])) {
                        $user_id = mysqli_real_escape_string($db->conn, $_GET['id']);
                        $user = new UserController;
                        $result = $user->edit($user_id);

                        if ($result) {
                            ?>
                            <form action="../User.php" method="POST">
                                <input type="hidden" name="user_id"
                                       value="<?= $result['UserId'] ?>">

                                <div class="mb-3">
                                    <label for="">Email</label>
                                    <input maxlength="50" value="<?= $result['Email'] ?>" type="email" name="email" required class="form-control"/>
                                </div>
                                <div class="mb-3">
                                    <label for="">Username</label>
                                    <input <?php if ($_SESSION['user'] !== 'Admin') { ?> disabled <?php } ?> maxlength="50" value="<?= $result['Username'] ?>" type="text"
                                                                                                             name="username" required class="form-control"/>
                                </div>
                                <div class="mb-3">
                                    <label for="">Password</label>
                                    <input value="<?= $result['Password'] ?>" type="password" name="password" required class="form-control"/>
                                </div>
                                <div class="mb-3">
                                    <label for="">Category</label>
                                    <select <?php if ($_SESSION['user'] !== 'Admin') { ?> disabled <?php } ?> name="category" required class="form-control">
                                        <option selected value="<?= $result['Category'] ?>"><?= $result['Category'] ?></option>
                                        <option>Station Employee</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="">Filling Station</label>
                                    <select <?php if ($_SESSION['user'] !== 'Admin') { ?> disabled <?php } ?> name="fillingstationid" required class="form-control">
                                        <option selected value="<?= $result['FillingStationId'] ?>"><?= $result['FillingStationId'] ?></option>
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
                                    <button type="submit" name="updateUser" class="btn btn-primary">Update</button>
                                    <button class="btn btn-danger" onclick="history.go(-1);">Back</button>
                                </div>
                            </form>
                            <?php
                        } else {
                            echo "<h4>No Record Found</h4>";
                        }
                    } else {
                        echo "<h4>Something Went Wront</h4>";
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>