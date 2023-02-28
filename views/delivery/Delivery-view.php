<?php
/*
 * Copyright (c) 2023. Hanzal Akbar
 */
session_start();

if (!isset($_SESSION['user'])) {
    header('location: http://localhost/fuelin');
}

use Fuelin\DeliveryController;

include($_SERVER['DOCUMENT_ROOT'] . "/fuelin/database/DBConn.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/fuelin/controllers/DeliveryController.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FUELIN - Delivery Schedules</title>

    <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.css">
    <script type="text/javascript" src="http://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript"
            src="http://cdn.datatables.net/plug-ins/1.13.2/filtering/row-based/TableTools.ShowSelectedOnly.js"></script>


</head>
<body>
<?php include($_SERVER['DOCUMENT_ROOT'] . "/fuelin/navbar.php") ?>

<div class="container-fluid mt-4">
    <div class="row" style="font-size: large">
        <div class="col-md-12 flex-grow-1">
            <div class="card ">
                <div class="card-header">
                    <h1>FUELIN: Delivery Management</h1>
                </div>
                <div class="row">
                    <?php if ($_SESSION['user'] === 'Admin') { ?>
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-6">
                            <a href="Delivery-add.php" class="btn btn-primary" style="font-size: large; margin-top: 2%; margin-left: 80%;"> New Delivery </a>
                        </div>
                        <div class="col-md-12">
                            <hr>
                        </div>
                    <?php } ?>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="myTable" class="table table-borderless">
                            <thead>
                            <tr>
                                <th>Delivery ID</th>
                                <th>Estimated Delivery</th>
                                <th>Truck Number</th>
                                <th>Fuel Capacity</th>
                                <th>Status</th>
                                <th>Filling Station ID</th>
                                <?php if ($_SESSION['user'] === 'Admin') { ?>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                <?php } ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $delivery = new DeliveryController;
                            $result = $delivery->index($_SESSION['station'], $_SESSION['user']);
                            if ($result) {
                                foreach ($result as $row) {
                                    ?>
                                    <tr>
                                        <td><?= $row['DeliveryId'] ?></td>
                                        <td><?= $row['EstimatedDelivery'] ?></td>
                                        <td><?= $row['TruckNumber'] ?></td>
                                        <td><?= $row['FuelCapacity'] ?></td>
                                        <td><?= $row['Status'] ?></td>
                                        <td><?= $row['FillingStationId'] ?></td>
                                        <?php if ($_SESSION['user'] === 'Admin') { ?>
                                            <td>
                                                <a href="Delivery-edit.php?id=<?= $row['DeliveryId']; ?>"
                                                   class="btn btn-warning" style="font-size: large">Edit</a>
                                            </td>
                                            <td>
                                                <form action="../Delivery.php" method="POST">
                                                    <button type="submit" name="deleteDelivery"
                                                            value="<?= $row['DeliveryId'] ?>" class="btn btn-danger" style="font-size: large">
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                        <?php } ?>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo "No Record Found";
                            }
                            ?>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {

        $('#myTable thead th').each(function (index) {
            if (index <= 5) {
                let title = $('#myTable thead th').eq($(this).index()).text();
                $(this).html(
                    '<div class="form-outline w-100"><label  class="form-label" for="input1">' + title + '</label> <input type="text" id="input1" placeholder="Search.." class="form-control" /></div>'
                );
            }
        });

        let table = $('#myTable').DataTable({
            "sDom": "ltipr",
        });

        table.columns().eq(0).each(function (colIdx) {
            $('input', table.column(colIdx).header()).on('keyup change', function () {
                table
                    .column(colIdx)
                    .search(this.value)
                    .draw()
            });
            $('input', table.column(colIdx).header()).on('click', function (e) {
                e.stopPropagation();
            });
        });
    });
</script>

</body>
</html>