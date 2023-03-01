<?php
/*
 * Copyright (c) 2023. Bassam
 */

if (!isset($_SESSION['user'])) {
    header('location: http://localhost/fuelin');
}

use Fuelin\DatabaseConnection;
use Fuelin\DeliveryController;


include($_SERVER['DOCUMENT_ROOT'] . "/fuelin/database/DBConn.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/fuelin/controllers/DeliveryController.php");

$db = new DatabaseConnection;

if (isset($_POST['saveDelivery'])) {
    if (!isset($_SESSION['user'])) {
        header('location: http://localhost/fuelin');
    }

    $inputData = [
        'estimateddelivery' => mysqli_real_escape_string(mysql: $db->conn, string: $_POST['estimateddelivery']),
        'trucknumber' => mysqli_real_escape_string(mysql: $db->conn, string: $_POST['trucknumber']),
        'fuelcapacity' => mysqli_real_escape_string(mysql: $db->conn, string: $_POST['fuelcapacity']),
        'status' => mysqli_real_escape_string(mysql: $db->conn, string: $_POST['status']),
        'fillingstationid' => mysqli_real_escape_string(mysql: $db->conn, string: $_POST['fillingstationid']),
    ];

    $delivery = new DeliveryController;
    $result = $delivery->create($inputData);

    if ($result) {
        $_SESSION['message'] = "Delivery Scheduled Successfully";
    } else {
        $_SESSION['message'] = "Delivery Not Added";
    }
    header("Location:  http://localhost/fuelin");
    exit(0);
}

if (isset($_POST['updateDelivery'])) {
    if (!isset($_SESSION['user'])) {
        header('location: http://localhost/fuelin');
    }

    $id = mysqli_real_escape_string($db->conn, $_POST['delivery_id']);
    $inputData = [
        'estimateddelivery' => mysqli_real_escape_string($db->conn, $_POST['estimateddelivery']),
        'trucknumber' => mysqli_real_escape_string($db->conn, $_POST['trucknumber']),
        'fuelcapacity' => mysqli_real_escape_string($db->conn, $_POST['fuelcapacity']),
        'status' => mysqli_real_escape_string(mysql: $db->conn, string: $_POST['status']),
        'fillingstationid' => mysqli_real_escape_string($db->conn, $_POST['fillingstationid']),
    ];
    $delivery = new DeliveryController;
    $result = $delivery->update($inputData, $id);

    if ($result) {
        $_SESSION['message'] = "Delivery Updated Successfully";
    } else {
        $_SESSION['message'] = "Delivery Not Updated";
    }
    header("Location: delivery\Delivery-view.php");
    exit(0);
}

if (isset($_POST['deleteDelivery'])) {
    if (!isset($_SESSION['user'])) {
        header('location: http://localhost/fuelin');
    }

    $id = mysqli_real_escape_string($db->conn, $_POST['deleteDelivery']);
    $delivery = new DeliveryController;
    $result = $delivery->delete($id);
    if ($result) {
        $_SESSION['message'] = "Delivery Deleted Successfully";
    } else {
        $_SESSION['message'] = "Delivery Not Deleted";
    }
    header("Location: delivery\Delivery-view.php");
    exit(0);
}
