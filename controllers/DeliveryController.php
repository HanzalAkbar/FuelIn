<?php
/*
 * Copyright (c) 2023. Bassam
 */

namespace Fuelin;

use AllowDynamicProperties;
use mysqli_result;

include_once($_SERVER['DOCUMENT_ROOT'] . "/fuelin/controllers/FillingStationController.php");

#[AllowDynamicProperties] class DeliveryController
{


    /**
     *
     */
    public function __construct()
    {
        $db = new DatabaseConnection;
        $this->conn = $db->conn;
    }

    /**
     * @param $station
     * @param $category
     * @return mysqli_result|bool
     */
    public function index($station, $category): mysqli_result|bool
    {
        $deliveryQuery = "SELECT * FROM delivery WHERE FillingStationId='$station'";
        if ($category === 'Admin') {
            $deliveryQuery = "SELECT * FROM delivery";
        }

        $result = $this->conn->query($deliveryQuery);
        if ($result->num_rows > 0) {
            return $result;
        }
        return false;

    }

    /**
     * @return mysqli_result|bool
     */
    public function primes(): mysqli_result|bool
    {
        $deliveryQuery = "SELECT DISTINCT delivery.DeliveryId FROM delivery";
        $result = $this->conn->query($deliveryQuery);
        if ($result->num_rows > 0) {
            return $result;
        }
        return false;

    }

    /**
     * @param $inputData
     * @return bool
     */
    public function create($inputData): bool
    {
        $estimateddelivery = $inputData['estimateddelivery'];
        $trucknumber = $inputData['trucknumber'];
        $fuelcapacity = $inputData['fuelcapacity'];
        $status = $inputData['status'];
        $fillingstationid = $inputData['fillingstationid'];

        $deliveryQuery = "INSERT INTO delivery (Status, EstimatedDelivery, TruckNumber, FuelCapacity, FillingStationId) VALUES ('$status', '$estimateddelivery','$trucknumber','$fuelcapacity','$fillingstationid')";
        $result = $this->conn->query($deliveryQuery);
        if ($result) {
            $fillingstation = new FillingStationController;
            $fillingstation->reservefuel($inputData, $fillingstationid);
            return true;
        }
        return false;

    }

    /**
     * @param $id
     * @return false|array|null
     */
    public function edit($id): false|array|null
    {
        $delivery_id = mysqli_real_escape_string($this->conn, $id);
        $deliveryQuery = "SELECT * FROM delivery WHERE DeliveryId='$delivery_id' LIMIT 1";
        $result = $this->conn->query($deliveryQuery);
        if ($result->num_rows == 1) {
            return $result->fetch_assoc();
        }
        return false;

    }

    /**
     * @param $inputData
     * @param $id
     * @return bool
     */
    public function update($inputData, $id): bool
    {
        $delivery_id = mysqli_real_escape_string($this->conn, $id);
        $estimateddelivery = $inputData['estimateddelivery'];
        $trucknumber = $inputData['trucknumber'];
        $fuelcapacity = $inputData['fuelcapacity'];
        $status = $inputData['status'];
        $fillingstationid = $inputData['fillingstationid'];

        $deliveryQuery = "UPDATE delivery SET FillingStationId='$fillingstationid', EstimatedDelivery='$estimateddelivery', FuelCapacity='$fuelcapacity', Status='$status', TruckNumber='$trucknumber' WHERE DeliveryId='$delivery_id' LIMIT 1";
        $result = $this->conn->query($deliveryQuery);
        if ($result) {
            return true;
        }
        return false;

    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id): bool
    {
        $delivery_id = mysqli_real_escape_string($this->conn, $id);
        $deliveryQuery = "DELETE FROM delivery WHERE DeliveryId='$delivery_id' LIMIT 1";
        $result = $this->conn->query($deliveryQuery);
        if ($result) {
            return true;
        }
        return false;

    }
}