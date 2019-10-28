<?php

require_once('../common/header.php');
require_once('../common/connection.php');
require_once('./tablet.php');
require_once('../common/messageHandler.php');

$connection = new connection();
$conn = $connection->getConnection();


$data = json_decode(file_get_contents("php://input"));

if (!empty($data->prescriptionId)) {
    $tablets = new tablet($conn);
    $tablets->prescriptionId = $data->prescriptionId;
    $tablets->getTabletsFromPrescription();
} else {
    $messageHandler = new messageHandler('failed', 400, 'All filed required', 'All field required');
    echo $messageHandler->getResponse();
}
