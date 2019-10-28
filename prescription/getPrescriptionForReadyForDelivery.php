<?php

require_once('../common/header.php');
require_once('../common/connection.php');
require_once('./prescription.php');
require_once('../common/messageHandler.php');

$connection = new connection();
$conn = $connection->getConnection();

$prescription = new prescription($conn);

$data = json_decode(file_get_contents("php://input"));
if (!empty($data->pharmacyId)) {
    $prescription->pharmacyId = $data->pharmacyId;
    $prescription->getPrescriptionForReadyForDelivery();
} else {
    $messageHandler = new messageHandler('failed', 400, 'All filed required', 'All field required');
    echo $messageHandler->getResponse();
}
