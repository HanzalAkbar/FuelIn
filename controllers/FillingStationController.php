<?php
/*
 * Copyright (c) 2023. Hanzal Akbar
 */

namespace Fuelin;

use AllowDynamicProperties;
use mysqli_result;

#[AllowDynamicProperties] class FillingStationController
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
        $fillingstationQuery = "SELECT * FROM fillingstation WHERE FillingStationId='$station'";
        if ($category === 'Admin') {
            $fillingstationQuery = "SELECT * FROM fillingstation";
        }

        $result = $this->conn->query($fillingstationQuery);
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
        $fillingstationQuery = "SELECT DISTINCT fillingstation.FillingStationId FROM fillingstation";
        $result = $this->conn->query($fillingstationQuery);
        if ($result->num_rows > 0) {
            return $result;
        }
        return false;

    }

    /**
     * @return mysqli_result|bool
     */
    public function stations(): mysqli_result|bool
    {
        $fillingstationQuery = "SELECT DISTINCT fillingstation.FillingStationId,fillingstation.`Name`,fillingstation.Location FROM fillingstation WHERE fillingstation.Status='Supply' AND fillingstation.FuelStock+10000>=IFNULL(fillingstation.FuelBooked,0) ORDER BY fillingstation.Location";
        $result = $this->conn->query($fillingstationQuery);
        if ($result->num_rows > 0) {
            return $result;
        }
        return false;

    }

    /**
     * @param $station
     * @param $category
     * @return mysqli_result|bool
     */
    public function allstations($station, $category): mysqli_result|bool
    {

        $fillingstationQuery = "SELECT DISTINCT fillingstation.FillingStationId,fillingstation.`Name`,fillingstation.Location FROM fillingstation WHERE fillingstation.Status='Supply' AND FillingStationId='$station' ORDER BY fillingstation.Location";
        if ($category === 'Admin') {
            $fillingstationQuery = "SELECT DISTINCT fillingstation.FillingStationId,fillingstation.`Name`,fillingstation.Location FROM fillingstation WHERE fillingstation.Status='Supply' ORDER BY fillingstation.Location";
        }


        $result = $this->conn->query($fillingstationQuery);
        if ($result->num_rows > 0) {
            return $result;
        }
        return false;

    }


    /**
     * @param $id
     * @return false|array|null
     */
    public function edit($id): false|array|null
    {
        $fillingstation_id = mysqli_real_escape_string($this->conn, $id);
        $fillingstationQuery = "SELECT * FROM fillingstation WHERE FillingStationId='$fillingstation_id' LIMIT 1";
        $result = $this->conn->query($fillingstationQuery);
        if ($result->num_rows == 1) {
            return $result->fetch_assoc();
        }
        return false;

    }


    /**
     * @param $inputData
     * @return bool
     */
    public function create($inputData): bool
    {
        $name = $inputData['name'];
        $location = $inputData['location'];
        $status = $inputData['status'];
        $openinghours = $inputData['openinghours'];
        $closinghours = $inputData['closinghours'];
        $tankcapacity = $inputData['tankcapacity'];
        $fuelstock = $inputData['fuelstock'];
        $fuelbooked = $inputData['fuelbooked'];
        $fillingstationQuery = "INSERT INTO fillingstation (Name, Location, Status, OpeningHours, ClosingHours, TankCapacity, FuelStock, FuelBooked) VALUES ('$name','$location', '$status','$openinghours','$closinghours','$tankcapacity','$fuelstock','$fuelbooked')";
        $result = $this->conn->query($fillingstationQuery);
        if ($result) {
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
        $fillingstation_id = mysqli_real_escape_string($this->conn, $id);
        $name = $inputData['name'];
        $location = $inputData['location'];
        $status = $inputData['status'];
        $openinghours = $inputData['openinghours'];
        $closinghours = $inputData['closinghours'];
        $tankcapacity = $inputData['tankcapacity'];
        $fuelstock = $inputData['fuelstock'];
        $fuelbooked = $inputData['fuelbooked'];

        $fillingstationQuery = "UPDATE fillingstation SET TankCapacity='$tankcapacity', FuelStock='$fuelstock', FuelBooked='$fuelbooked', Name='$name', Location='$location', Status='$status', OpeningHours='$openinghours', ClosingHours='$closinghours' WHERE FillingStationId='$fillingstation_id' LIMIT 1";
        $result = $this->conn->query($fillingstationQuery);
        if ($result) {
            return true;
        }
        return false;

    }


    /**
     * @param $inputData
     * @param $id
     * @return bool
     */
    public function bookfuel($inputData, $id): bool
    {
        $fillingstation_id = mysqli_real_escape_string($this->conn, $id);
        $fuelbooked = $inputData['fuelcapacity'];

        $fillingstationQueryn = "SELECT fillingstation.FuelStock, fillingstation.FuelBooked FROM fillingstation WHERE FillingStationId='$fillingstation_id' LIMIT 1";
        $resultn = $this->conn->query($fillingstationQueryn);
        if ($resultn->num_rows > 0) {
            while ($row = $resultn->fetch_assoc()) {
                $finalfuelbooked = (int)$row['FuelBooked'] + (int)$fuelbooked;
                $finalfuelavailable = (int)$row['FuelStock'] - (int)$fuelbooked;
                $fillingstationQuery = "UPDATE fillingstation SET FuelBooked='$finalfuelbooked', FuelStock='$finalfuelavailable' WHERE FillingStationId='$fillingstation_id' LIMIT 1";
                $result = $this->conn->query($fillingstationQuery);
                if ($result) {
                    return true;
                }
            }
        }
        return false;
    }


    /**
     * @param $inputData
     * @param $id
     * @return bool
     */
    public function reservefuel($inputData, $id): bool
    {
        $fillingstation_id = mysqli_real_escape_string($this->conn, $id);
        $fuelstock = $inputData['fuelcapacity'];

        $fillingstationQueryn = "SELECT fillingstation.FuelStock FROM fillingstation WHERE FillingStationId='$fillingstation_id' LIMIT 1";
        $resultn = $this->conn->query($fillingstationQueryn);
        if ($resultn->num_rows > 0) {
            while ($row = $resultn->fetch_assoc()) {
                $finalfuelavailable = (int)$row['FuelStock'] + (int)$fuelstock;
                $fillingstationQuery = "UPDATE fillingstation SET FuelStock='$finalfuelavailable' WHERE FillingStationId='$fillingstation_id' LIMIT 1";
                $result = $this->conn->query($fillingstationQuery);
                if ($result) {
                    return true;
                }
            }
        }
        return false;
    }


    /**
     * @param $inputData
     * @return bool
     */
    public function releasefuel($inputData): bool
    {
        $fillingstation_id = $inputData['FillingStationId'];
        $fuelbook = $inputData['FuelCapacity'];

        $fillingstationQueryn = "SELECT fillingstation.FuelBooked FROM fillingstation WHERE FillingStationId='$fillingstation_id' LIMIT 1";
        $resultn = $this->conn->query($fillingstationQueryn);
        if ($resultn->num_rows > 0) {
            while ($row = $resultn->fetch_assoc()) {
                $finalfuelbooked = (int)$row['FuelBooked'] - (int)$fuelbook;
                $fillingstationQuery = "UPDATE fillingstation SET FuelBooked='$finalfuelbooked' WHERE FillingStationId='$fillingstation_id' LIMIT 1";
                $result = $this->conn->query($fillingstationQuery);
                if ($result) {
                    return true;
                }
            }
        }
        return false;
    }


    /**
     * @param $id
     * @return bool
     */
    public function delete($id): bool
    {
        $fillingstation_id = mysqli_real_escape_string($this->conn, $id);
        $fillingstationQuery = "DELETE FROM fillingstation WHERE FillingStationId='$fillingstation_id' LIMIT 1";
        $result = $this->conn->query($fillingstationQuery);
        if ($result) {
            return true;
        }
        return false;
    }
}