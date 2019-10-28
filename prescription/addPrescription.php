<?php

require_once('../common/header.php');
require_once('../common/connection.php');
require_once('./prescription.php');
require_once('../common/messageHandler.php');

$connection = new connection();
$conn = $connection->getConnection();




$data = json_decode(file_get_contents("php://input"));

if (!empty($data->userId) && !empty($data->doctorId) && !empty($data->tablets) && !empty($data->name)) {
    if (is_array($data->tablets)) { 
        $prescription = new prescription($conn);
        $prescription->doctorId = $data->doctorId;
        $prescription->userId = $data->userId;
        $prescription->tablets = $data->tablets;
        $prescription->pre_name = $data->name;
        $prescription->addPrescription();
    } else {
        $messageHandler = new messageHandler('failed', 400, 'All filed required', 'Tablets required');
        echo $messageHandler->getResponse();
    }
} else {
    $messageHandler = new messageHandler('failed', 400, 'All filed required', 'All field required');
    echo $messageHandler->getResponse();
}
