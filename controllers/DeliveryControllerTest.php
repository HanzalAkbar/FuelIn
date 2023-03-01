<?php
/*
 * Copyright (c) 2023. Bassam
 */

namespace Fuelin;

use PHPUnit\Framework\TestCase;

//include_once("DeliveryController.php");

class DeliveryControllerTest extends TestCase
{

    public function testCreate()
    {
        $delivery = new DeliveryController();
        $thisDate = gmdate("Y-m-d H:i:s", strtotime('2005-10-10 09:27:52'));
        $inputData = array("estimateddelivery" => $thisDate,
            "trucknumber" => "KUQ-D5OP4D",
            "fuelcapacity" => 5000,
            "status" => "En Route",
            "fillingstationid" => 1
        );
        $this->assertIsBool($delivery->create($inputData));
    }

    public function testIndex()
    {

    }

    public function testEdit()
    {

    }

    public function testUpdate()
    {

    }

    public function testPrimes()
    {

    }

    public function testDelete()
    {

    }
}
