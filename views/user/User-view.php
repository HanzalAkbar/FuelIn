<?php
/*
 * Copyright (c) 2023. Hanzal Akbar
 */
session_start();

if (!isset($_SESSION['user'])) {
    header('location: http://localhost/fuelin');
}

use Fuelin\UserController;

include($_SERVER['DOCUMENT_ROOT'] . "/fuelin/database/DBConn.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/fuelin/controllers/UserController.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FUELIN - Fuel Stations Owners</title>

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
                    <h1>FUELIN: User Management</h1>
                </div>
                <div class="row">
                    <div class="col-md-6">
                    </div>
                    <div class="col-md-6">
                        <a href="User-add.php" class="btn btn-primary" style="font-size: large; margin-top: 2%; margin-left: 80%;"> New User </a>
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
                                <th>User ID</th>
                                <th>Email</th>
                                <th>Username</th>
                                <th>Category</th>
                                <th>Filling Station ID</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $user = new UserController;
                            $result = $user->index($_SESSION['user'], $_SESSION['id']);
                            if ($result) {
                                foreach ($result as $row) {
                                    ?>
                                    <tr>
                                        <td><?= $row['UserId'] ?></td>
                                        <td><?= $row['Email'] ?></td>
                                        <td><?= $row['Username'] ?></td>
                                        <td><?= $row['Category'] ?></td>
                                        <td><?= $row['FillingStationId'] ?></td>
                                        <td>
                                            <a href="User-edit.php?id=<?= $row['UserId']; ?>"
                                               class="btn btn-warning" style="font-size: large">Edit</a>
                                        </td>
                                        <td>
                                            <form action="../User.php" method="POST">
                                                <button type="submit" name="deleteUser"
                                                        value="<?= $row['UserId'] ?>" class="btn btn-danger" style="font-size: large">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
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
            if (index <= 4) {
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