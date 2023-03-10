<?php
/*
 * Copyright (c) 2023. Hanzal Akbar
 */
session_start();

if (!isset($_SESSION['user'])) {
    header('location: http://localhost/fuelin');
}

include($_SERVER['DOCUMENT_ROOT'] . "/fuelin/database/DBConn.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/fuelin/controllers/FillingStationController.php");

$dt = new DateTime();

echo '';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FUELIN - Fuel Stations</title>
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
                    <h4>New Fuel Station</h4>
                </div>
                <div class="card-body">

                    <form action="../FillingStation.php" method="POST">
                        <div class="mb-3">
                            <label for="">Name</label>
                            <input maxlength="50" type="text" name="name" required class="form-control"/>
                        </div>
                        <div class="mb-3">
                            <label for="">Location</label>
                            <input maxlength="50" type="text" name="location" required class="form-control"/>
                        </div>
                        <div class="mb-3">
                            <label for="">Status</label>
                            <select name="status" required class="form-control">
                                <option>Supply</option>
                                <option>Discontinued</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="">Opening Hours</label>
                            <input type="time" name="openinghours" value="<?= $dt->format('H:i:s') ?>" required class="form-control"/>
                        </div>
                        <div class="mb-3">
                            <label for="">Closing Hours</label>
                            <input type="time" name="closinghours" value="<?= $dt->format('H:i:s') ?>" required class="form-control"/>
                        </div>
                        <div class="mb-3">
                            <label for="">Tank Capacity</label>
                            <input type="number" min="10000" max="2000000" name="tankcapacity" required
                                   class="form-control"/>
                        </div>
                        <div class="mb-3">
                            <label for="">Fuel Stock</label>
                            <input type="number" min="10" max="2000000" name="fuelstock" required
                                   class="form-control"/>
                        </div>
                        <div class="mb-3">
                            <label for="">Fuel Booked</label>
                            <input type="number" min="10" max="2000000" name="fuelbooked" required
                                   class="form-control"/>
                        </div>
                        <div class="button-group mb-3 ">
                            <button type="submit" name="saveFillingStation" class="btn btn-primary">Create</button>
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