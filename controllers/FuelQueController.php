<?php
/*
 * Copyright (c) 2023. Hanzal Akbar
 */

namespace Fuelin;

use AllowDynamicProperties;
use mysqli_result;

include_once($_SERVER['DOCUMENT_ROOT'] . "/fuelin/controllers/FillingStationController.php");

#[AllowDynamicProperties] class FuelQueController
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
        $fuelqueQuery = "SELECT * FROM fuelque WHERE FillingStationId='$station'";
        if ($category === 'Admin') {
            $fuelqueQuery = "SELECT * FROM fuelque";
        }
        $result = $this->conn->query($fuelqueQuery);
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
        $fuelqueQuery = "SELECT DISTINCT fuelque.FuelQueId FROM fuelque";
        $result = $this->conn->query($fuelqueQuery);
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
        $requesteddelivery = $inputData['requesteddelivery'];
        $nic = $inputData['nic'];
        $vehiclenumber = $inputData['vehiclenumber'];
        $fuelcapacity = $inputData['fuelcapacity'];
        $fillingstationid = $inputData['fillingstationid'];

        if ((int)$fuelcapacity > 500) {
            return false;
        }

        $quotafuelqueQuery = "SELECT SUM(fuelque.FuelCapacity) FROM fuelque WHERE fuelque.VehicleNumber='$vehiclenumber' AND CONCAT(YEAR (fuelque.RequestedDelivery),'-',WEEK (fuelque.RequestedDelivery))=CONCAT(YEAR ('$requesteddelivery'),'-',WEEK ('$requesteddelivery'))";
        $queryresult = $this->conn->query($quotafuelqueQuery);
        if ($queryresult->num_rows > 0) {
            while ($row = $queryresult->fetch_assoc()) {
                if ((int)implode("", $row) <= 499) {
                    $fuelqueQuery = "INSERT INTO fuelque (RequestedDelivery, NIC, VehicleNumber, FuelCapacity, FillingStationId) VALUES ('$requesteddelivery','$nic','$vehiclenumber','$fuelcapacity','$fillingstationid')";
                    $result = $this->conn->query($fuelqueQuery);
                    if ($result) {
                        $fillingstation = new FillingStationController;
                        $fillingstation->bookfuel($inputData, $fillingstationid);
                        return true;
                    }
                }
            }
        } else {
            $fuelqueQuery = "INSERT INTO fuelque (RequestedDelivery, NIC, VehicleNumber, FuelCapacity, FillingStationId) VALUES ('$requesteddelivery','$nic','$vehiclenumber','$fuelcapacity','$fillingstationid')";
            $result = $this->conn->query($fuelqueQuery);
            if ($result) {
                $fillingstation = new FillingStationController;
                $fillingstation->bookfuel($inputData, $fillingstationid);
                return true;
            }
        }
        return false;
    }


    /**
     * @param $id
     * @return false|array|null
     */
    public function edit($id): false|array|null
    {
        $fuelque_id = mysqli_real_escape_string($this->conn, $id);
        $fuelqueQuery = "SELECT * FROM fuelque WHERE FuelQueId='$fuelque_id' LIMIT 1";
        $result = $this->conn->query($fuelqueQuery);
        if ($result->num_rows == 1) {
            return $result->fetch_assoc();
        }
        return false;

    }


    /**
     * @param $id
     * @return bool
     */
    public function paidstatus($id): bool
    {
        $fuelque_id = mysqli_real_escape_string($this->conn, $id);
        $status = "Paid";
        $fuelqueQuery = "UPDATE fuelque SET Status='$status' WHERE FuelQueId='$fuelque_id' LIMIT 1";
        $result = $this->conn->query($fuelqueQuery);
        if ($result) {
            $fuelqueQueryn = "SELECT DISTINCT FuelCapacity, FillingStationId FROM fuelque WHERE FuelQueId='$fuelque_id' LIMIT 1";
            $resultn = $this->conn->query($fuelqueQueryn);
            if ($resultn->num_rows > 0) {
                $row = $resultn->fetch_assoc();
                $fillingstation = new FillingStationController;
                $inputData = $row;
                $fillingstation->releasefuel($inputData);
                return true;

            }
            return true;
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
        $fuelque_id = mysqli_real_escape_string($this->conn, $id);
        $requesteddelivery = $inputData['requesteddelivery'];
        $nic = $inputData['nic'];
        $vehiclenumber = $inputData['vehiclenumber'];
        $fuelcapacity = $inputData['fuelcapacity'];
        $status = $inputData['status'];
        $mailstatus = $inputData['mailstatus'];
        $fillingstationid = $inputData['fillingstationid'];


        $fuelqueQuery = "UPDATE fuelque SET MailStatus='$mailstatus', FillingStationId='$fillingstationid', RequestedDelivery='$requesteddelivery', FuelCapacity='$fuelcapacity', NIC='$nic', Status='$status', VehicleNumber='$vehiclenumber' WHERE FuelQueId='$fuelque_id' LIMIT 1";
        $result = $this->conn->query($fuelqueQuery);
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
        $fuelque_id = mysqli_real_escape_string($this->conn, $id);
        $fuelqueQuery = "DELETE FROM fuelque WHERE FuelQueId='$fuelque_id' LIMIT 1";
        $result = $this->conn->query($fuelqueQuery);
        if ($result) {
            return true;
        }
        return false;

    }
}