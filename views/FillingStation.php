<?php
/*
 * Copyright (c) 2023. Fahmy
 */

if (!isset($_SESSION['user'])) {
    header('location: http://localhost/fuelin');
}

use Fuelin\DatabaseConnection;
use Fuelin\FillingStationController;

include($_SERVER['DOCUMENT_ROOT'] . "/fuelin/database/DBConn.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/fuelin/controllers/FillingStationController.php");

$db = new DatabaseConnection;

if (isset($_POST['saveFillingStation'])) {
    if (!isset($_SESSION['user'])) {
        header('location: http://localhost/fuelin');
    }
    $inputData = [
        'name' => mysqli_real_escape_string(mysql: $db->conn, string: $_POST['name']),
        'location' => mysqli_real_escape_string(mysql: $db->conn, string: $_POST['location']),
        'status' => mysqli_real_escape_string(mysql: $db->conn, string: $_POST['status']),
        'openinghours' => mysqli_real_escape_string(mysql: $db->conn, string: $_POST['openinghours']),
        'closinghours' => mysqli_real_escape_string(mysql: $db->conn, string: $_POST['closinghours']),
        'tankcapacity' => mysqli_real_escape_string(mysql: $db->conn, string: $_POST['tankcapacity']),
        'fuelstock' => mysqli_real_escape_string(mysql: $db->conn, string: $_POST['fuelstock']),
        'fuelbooked' => mysqli_real_escape_string(mysql: $db->conn, string: $_POST['fuelbooked']),
    ];

    $fillingstation = new FillingStationController;
    $result = $fillingstation->create($inputData);

    if ($result) {
        $_SESSION['message'] = "Station Added Successfully";
    } else {
        $_SESSION['message'] = "Station Not Added";
    }
    header("Location:  http://localhost/fuelin");
    exit(0);
}

if (isset($_POST['updateFillingStation'])) {
    if (!isset($_SESSION['user'])) {
        header('location: http://localhost/fuelin');
    }
    $id = mysqli_real_escape_string($db->conn, $_POST['fillingstation_id']);
    $inputData = [
        'name' => mysqli_real_escape_string($db->conn, $_POST['name']),
        'location' => mysqli_real_escape_string($db->conn, $_POST['location']),
        'status' => mysqli_real_escape_string(mysql: $db->conn, string: $_POST['status']),
        'openinghours' => mysqli_real_escape_string($db->conn, $_POST['openinghours']),
        'closinghours' => mysqli_real_escape_string($db->conn, $_POST['closinghours']),
        'tankcapacity' => mysqli_real_escape_string($db->conn, $_POST['tankcapacity']),
        'fuelstock' => mysqli_real_escape_string($db->conn, $_POST['fuelstock']),
        'fuelbooked' => mysqli_real_escape_string($db->conn, $_POST['fuelbooked']),
    ];
    $fillingstation = new FillingStationController;
    $result = $fillingstation->update($inputData, $id);

    if ($result) {
        $_SESSION['message'] = "Station Updated Successfully";
    } else {
        $_SESSION['message'] = "Station Not Updated";
    }
    header("Location: http://localhost/fuelin/fillingstation/FillingStation-view.php");
    exit(0);
}

if (isset($_POST['deleteFillingStation'])) {
    if (!isset($_SESSION['user'])) {
        header('location: http://localhost/fuelin');
    }
    $id = mysqli_real_escape_string($db->conn, $_POST['deleteFillingStation']);
    $fillingstation = new FillingStationController;
    $result = $fillingstation->delete($id);
    if ($result) {
        $_SESSION['message'] = "Station Deleted Successfully";
    } else {
        $_SESSION['message'] = "Station Not Deleted";
    }
    header("Location: http://localhost/fuelin/fillingstation/FillingStation-view.php");
    exit(0);
}
