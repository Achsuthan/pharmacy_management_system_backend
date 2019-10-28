<?php

require_once('../common/header.php');
require_once('../common/connection.php');
require_once('./prescription.php');
require_once('../common/messageHandler.php');

$connection = new connection();
$conn = $connection->getConnection();

$prescription = new prescription($conn);
$prescription->getPrescriptionForPharmacy();
