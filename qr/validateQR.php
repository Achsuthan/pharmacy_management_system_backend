<?php

require_once('../common/header.php');
require_once('../common/connection.php');
require_once('./qr.php');
require_once('../common/messageHandler.php');

$connection = new connection();
$conn = $connection->getConnection();


$data = json_decode(file_get_contents("php://input"));

if (!empty($data->userId) && !empty($data->prescriptionId) && !empty($data->pharmacyId) && !empty($data->pharmacyId)) {
    $qr = new qr($conn);
    $qr->prescriptionId = $data->prescriptionId;
    $qr->pharmacyId = $data->pharmacyId;
    $qr->userId = $data->userId;
    $qr->validateQr();
} else {
    $messageHandler = new messageHandler('failed', 400, 'All filed required', 'All field required');
    echo $messageHandler->getResponse();
}
