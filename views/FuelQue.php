<?php
/*
 * Copyright (c) 2023. Hanzal Akbar
 */

use Fuelin\DatabaseConnection;
use Fuelin\FuelQueController;


include($_SERVER['DOCUMENT_ROOT'] . "/fuelin/database/DBConn.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/fuelin/controllers/FuelQueController.php");

$db = new DatabaseConnection;

if (isset($_POST['saveFuelQue'])) {

    $inputData = [
        'requesteddelivery' => mysqli_real_escape_string(mysql: $db->conn, string: $_POST['requesteddelivery']),
        'nic' => mysqli_real_escape_string(mysql: $db->conn, string: $_POST['nic']),
        'vehiclenumber' => mysqli_real_escape_string(mysql: $db->conn, string: $_POST['vehiclenumber']),
        'fuelcapacity' => mysqli_real_escape_string(mysql: $db->conn, string: $_POST['fuelcapacity']),
        'fillingstationid' => mysqli_real_escape_string(mysql: $db->conn, string: $_POST['fillingstationid']),
    ];

    $fuelque = new FuelQueController;
    $result = $fuelque->create($inputData);

    if ($result) {
        $_SESSION['message'] = "Fuel Que Added Successfully";
        header("Location:  http://localhost/fuelin");
    } else {
        $_SESSION['message'] = "Sorry, Request above quota for the selected week. Not accepted.";
        echo '<script>alert("Sorry, Request above quota for the selected week. Not accepted.")</script>';
        echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">';
        echo "<button class='btn btn-danger' style='margin: 10px' onclick='history.go(-1);'>Back</button>";
    }
    exit(0);
}

if (isset($_POST['updateFuelQue'])) {
    if (!isset($_SESSION['user'])) {
        header('location: http://localhost/fuelin');
    }
    $id = mysqli_real_escape_string($db->conn, $_POST['fuelque_id']);
    $inputData = [
        'requesteddelivery' => mysqli_real_escape_string($db->conn, $_POST['requesteddelivery']),
        'nic' => mysqli_real_escape_string($db->conn, $_POST['nic']),
        'vehiclenumber' => mysqli_real_escape_string($db->conn, $_POST['vehiclenumber']),
        'fuelcapacity' => mysqli_real_escape_string($db->conn, $_POST['fuelcapacity']),
        'status' => mysqli_real_escape_string($db->conn, $_POST['status']),
        'mailstatus' => mysqli_real_escape_string($db->conn, $_POST['mailstatus']),
        'fillingstationid' => mysqli_real_escape_string($db->conn, $_POST['fillingstationid']),
    ];
    $fuelque = new FuelQueController;
    $result = $fuelque->update($inputData, $id);

    if ($result) {
        $_SESSION['message'] = "Fuel Que Updated Successfully";
    } else {
        $_SESSION['message'] = "Fuel Que Not Updated";
    }
    header("Location: fuelque\FuelQue-view.php");
    exit(0);
}

if (isset($_POST['payFuelQue'])) {
    if (!isset($_SESSION['user'])) {
        header('location: http://localhost/fuelin');
    }
    $id = mysqli_real_escape_string($db->conn, $_POST['payFuelQue']);
    $fuelque = new FuelQueController;
    $result = $fuelque->paidstatus($id);
    if ($result) {
        $_SESSION['message'] = "Fuel Que Updated Successfully";
    } else {
        $_SESSION['message'] = "Fuel Que Not Updated";
    }
    header("Location: fuelque\FuelQue-view.php");
    exit(0);
}

if (isset($_POST['deleteFuelQue'])) {
    if (!isset($_SESSION['user'])) {
        header('location: http://localhost/fuelin');
    }
    $id = mysqli_real_escape_string($db->conn, $_POST['deleteFuelQue']);
    $fuelque = new FuelQueController;
    $result = $fuelque->delete($id);
    if ($result) {
        $_SESSION['message'] = "Fuel Que Deleted Successfully";
    } else {
        $_SESSION['message'] = "Fuel Que Not Deleted";
    }
    header("Location: fuelque\FuelQue-view.php");
    exit(0);
}