<?php
/*
 * Copyright (c) 2023. Hanzal Akbar
 */

session_start();

if (!isset($_SESSION['user'])) {
    header('location: http://localhost/fuelin');
}

use Fuelin\FuelQueController;

include($_SERVER['DOCUMENT_ROOT'] . "/fuelin/database/DBConn.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/fuelin/controllers/FuelQueController.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FUELIN - Fuel Que</title>


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600&family=Rubik:wght@500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script type="text/javascript" src="http://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="http://cdn.datatables.net/plug-ins/1.13.2/filtering/row-based/TableTools.ShowSelectedOnly.js"></script>


</head>
<body>
<?php include($_SERVER['DOCUMENT_ROOT'] . "/fuelin/navbar.php") ?>

<div class="container-fluid mt-4">
    <div class="row" style="font-size: large">
        <div class="col-md-12 flex-grow-1">
            <div class="card ">
                <div class="card-header">
                    <h1>FUELIN: Fuel Que Management</h1>
                </div>
                <div class="row">
                    <div class="col-md-6">
                    </div>
                    <div class="col-md-6">
                        <a href="FuelQue-add.php" class="btn btn-primary" style="font-size: large; margin-top: 2%; margin-left: 80%;"> New Request </a>
                    </div>
                    <div class="col-md-12">
                        <hr>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="myTable" class="table table-borderless">
                            <thead>
                            <tr>
                                <th>Fuel Que ID</th>
                                <th>Requested Delivery</th>
                                <th>NIC</th>
                                <th>Vehicle Number</th>
                                <th>Fuel Capacity</th>
                                <th>Status</th>
                                <th>Mail Status</th>
                                <th>Filling Station ID</th>
                                <th>Paid</th>
                                <?php if ($_SESSION['user'] === 'Admin') { ?>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                <?php } ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $fuelque = new FuelQueController;
                            $result = $fuelque->index($_SESSION['station'], $_SESSION['user']);
                            if ($result) {
                                foreach ($result as $row) {
                                    ?>
                                    <tr>
                                        <td><?= $row['FuelQueId'] ?></td>
                                        <td><?= $row['RequestedDelivery'] ?></td>
                                        <td><?= $row['NIC'] ?></td>
                                        <td><?= $row['VehicleNumber'] ?></td>
                                        <td><?= $row['FuelCapacity'] ?></td>
                                        <td><?= $row['Status'] ?></td>
                                        <td><?= $row['MailStatus'] ?></td>
                                        <td><?= $row['FillingStationId'] ?></td>
                                        <td>
                                            <form action="../FuelQue.php" method="POST">
                                                <button type="submit" name="payFuelQue"
                                                        value="<?= $row['FuelQueId'] ?>" class="btn btn-success" style="font-size: large">
                                                    Paid
                                                </button>
                                            </form>
                                        </td>
                                        <?php if ($_SESSION['user'] === 'Admin') { ?>
                                            <td>
                                                <a href="FuelQue-edit.php?id=<?= $row['FuelQueId']; ?>"
                                                   class="btn btn-warning" style="font-size: large">Edit</a>
                                            </td>
                                            <td>
                                                <form action="../FuelQue.php" method="POST">
                                                    <button type="submit" name="deleteFuelQue"
                                                            value="<?= $row['FuelQueId'] ?>" class="btn btn-danger" style="font-size: large">
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
            if (index <= 7) {
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