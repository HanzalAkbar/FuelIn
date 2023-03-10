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
use Fuelin\FuelQueController;

include($_SERVER['DOCUMENT_ROOT'] . "/fuelin/database/DBConn.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/fuelin/controllers/FuelQueController.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/fuelin/controllers/FillingStationController.php");

$db = new DatabaseConnection;
$dt = new DateTime();
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
                    <h4>Fuel Que Edit</h4>
                </div>
                <div class="card-body">
                    <?php
                    if (isset($_GET['id'])) {
                        $fuelque_id = mysqli_real_escape_string($db->conn, $_GET['id']);
                        $fuelque = new FuelQueController();
                        $result = $fuelque->edit($fuelque_id);

                        if ($result) {
                            ?>
                            <form action="../FuelQue.php" method="POST">
                                <input type="hidden" name="fuelque_id"
                                       value="<?= $result['FuelQueId'] ?>">

                                <div class="mb-3">
                                    <label for="">NIC</label>
                                    <input maxlength="15" type="text"
                                           value="<?= $result['NIC'] ?>"
                                           name="nic" required class="form-control"/>
                                </div>
                                <div class="mb-3">
                                    <label for="">Vehicle Number</label>
                                    <input pattern="[A-Za-z0-9]{3}-[A-Z0-9]{7}" maxlength="11"
                                           value="<?= $result['VehicleNumber'] ?>"
                                           type="text" name="vehiclenumber" required class="form-control"/>
                                </div>
                                <div class="mb-3">
                                    <label for="">Fuel Capacity</label>
                                    <input type="number" min="1" max="500" name="fuelcapacity"
                                           value="<?= $result['FuelCapacity'] ?>"
                                           required class="form-control"/>
                                </div>
                                <div class="mb-3">
                                    <label for="">Filling Station ID / Name</label>
                                    <select name="fillingstationid" required class="form-control">
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
                                <?php $thisDate = gmdate("Y-m-d H:i:s", strtotime($result['RequestedDelivery'])) ?>
                                <div class="mb-3">
                                    <label for="">Requested Date</label>
                                    <input type="datetime-local" name="requesteddelivery"
                                           value="<?= $thisDate; ?>" required class="form-control"/>
                                </div>
                                <div class="mb-3">
                                    <label for="">Status</label>
                                    <select name="status" required class="form-control">
                                        <option selected value="<?= $result['Status'] ?>"><?= $result['Status'] ?></option>
                                        <option>Pending</option>
                                        <option>Paid</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="">MailStatus</label>
                                    <select name="mailstatus" required class="form-control">
                                        <option selected value="<?= $result['MailStatus'] ?>"><?= $result['MailStatus'] ?></option>
                                        <option>Email Pending</option>
                                        <option>Email Sent</option>
                                    </select>
                                </div>
                                <div class="button-group mb-3 ">
                                    <button type="submit" name="updateFuelQue" class="btn btn-primary">Update</button>
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
    </html><?php
/*
 * Copyright (c) 2023. Hanzal Akbar
 */


