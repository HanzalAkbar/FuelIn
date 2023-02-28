<?php
/*
 * Copyright (c) 2023. Hanzal Akbar
 */
session_start();

if (!isset($_SESSION['user'])) {
    header('location: http://localhost/fuelin');
}

use Fuelin\DatabaseConnection;
use Fuelin\FillingStationController;

include($_SERVER['DOCUMENT_ROOT'] . "/fuelin/database/DBConn.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/fuelin/controllers/FillingStationController.php");

$db = new DatabaseConnection;
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

<div class="container px-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Station Edit</h4>
                </div>
                <div class="card-body">
                    <?php
                    if (isset($_GET['id'])) {
                        $fillingstation_id = mysqli_real_escape_string($db->conn, $_GET['id']);
                        $fillingstation = new FillingStationController;
                        $result = $fillingstation->edit($fillingstation_id);

                        if ($result) {
                            ?>
                            <form action="../FillingStation.php" method="POST">
                                <input type="hidden" name="fillingstation_id"
                                       value="<?= $result['FillingStationId'] ?>">

                                <div class="mb-3">
                                    <label for="">Name</label>
                                    <input maxlength="50" type="text" name="name"
                                           value="<?= $result['Name'] ?>" required
                                           class="form-control"/>
                                </div>
                                <div class="mb-3">
                                    <label for="">Location</label>
                                    <input maxlength="50" type="text" name="location" value="<?= $result['Location'] ?>" required
                                           class="form-control"/>
                                </div>
                                <div class="mb-3">
                                    <label for="">Status</label>
                                    <select name="status" required class="form-control">
                                        <option selected value="<?= $result['Status'] ?>"><?= $result['Status'] ?></option>
                                        <option>Supply</option>
                                        <option>Discontinued</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="">Opening Hours</label>
                                    <input type="time" name="openinghours" value="<?= $result['OpeningHours'] ?>"
                                           required class="form-control"/>
                                </div>
                                <div class="mb-3">
                                    <label for="">Closing Hours</label>
                                    <input type="time" name="closinghours" value="<?= $result['ClosingHours'] ?>"
                                           required class="form-control"/>
                                </div>
                                <div class="mb-3">
                                    <label for="">Tank Capacity</label>
                                    <input type="number" min="10000" max="10000000" name="tankcapacity" value="<?= $result['TankCapacity'] ?>" required
                                           class="form-control"/>
                                </div>
                                <div class="mb-3">
                                    <label for="">Fuel Stock</label>
                                    <input type="number" min="10" max="10000000" name="fuelstock" value="<?= $result['FuelStock'] ?>" required
                                           class="form-control"/>
                                </div>
                                <div class="mb-3">
                                    <label for="">Fuel Booked</label>
                                    <input type="number" min="10" max="2000000" name="fuelbooked" value="<?= $result['FuelBooked'] ?>" required
                                           class="form-control"/>
                                </div>
                                <div class="button-group mb-3 ">
                                    <button type="submit" name="updateFillingStation" class="btn btn-primary">Update</button>
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