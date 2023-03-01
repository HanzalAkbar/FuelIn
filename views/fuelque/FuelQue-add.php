<?php
/*
 * Copyright (c) 2023. Hanzal Akbar
 */

session_start();

use Fuelin\FillingStationController;

include($_SERVER['DOCUMENT_ROOT'] . "/fuelin/database/DBConn.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/fuelin/controllers/FuelQueController.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/fuelin/controllers/FillingStationController.php");

$dt = new DateTime();
$dt->modify('+1 day');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FUELIN - Fuel Stations</title>
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
                    <h4>New Fuel Request</h4>
                    <h6></h6>
                </div>
                <div class="card-body">

                    <form action="../FuelQue.php" method="POST">
                        <div class="mb-3">
                            <label for="">NIC</label>
                            <input maxlength="15" type="text" name="nic" required class="form-control"/>
                        </div>
                        <div class="mb-3">
                            <label for="">Vehicle Number</label>
                            <input pattern="[A-Za-z0-9]{3}-[A-Za-z0-9]{4}" maxlength="10" type="text" name="vehiclenumber" required class="form-control"/>
                        </div>
                        <div class="mb-3">
                            <label for="">Fuel Capacity</label>
                            <input type="number" min="1" max="500" name="fuelcapacity" required class="form-control"/>
                        </div>
                        <div class="mb-3">
                            <label for="">Filling Station</label>
                            <select name="fillingstationid" required class="form-control">
                                <?php
                                $station = new FillingStationController;
                                $stationresult = $station->stations();
                                if ($stationresult) {
                                    foreach ($stationresult as $row) {
                                        echo "<option value='" . $row['FillingStationId'] . "'>" . $row['Location'] . ' | ' . $row['Name'] . "</option>";
                                    }
                                } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="">Requested Date</label>
                            <input type="date" min="<?= $dt->format('Y-m-d') ?>" name="requesteddelivery" value="<?= $dt->format('Y-m-d') ?>" required class="form-control"/>
                        </div>
                        <div class="button-group mb-3 ">
                            <button type="submit" name="saveFuelQue" class="btn btn-success">Make Request</button>
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