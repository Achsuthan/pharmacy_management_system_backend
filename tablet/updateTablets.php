<?php

require_once('../common/header.php');
require_once('../common/connection.php');
require_once('./tablet.php');
require_once('../common/messageHandler.php');

$connection = new connection();
$conn = $connection->getConnection();





$data = json_decode(file_get_contents("php://input"));

if (!empty($data->tablets) && !empty($data->prescriptionId) && !empty($data->pharmacyId)) {
    if (is_array($data->tablets)) { 
        $tablets = new tablet($conn);
        $tablets->tablets = $data->tablets;
        $tablets->prescriptionId = $data->prescriptionId;
        $tablets->pharmacyId = $data->pharmacyId;
        $tablets->updateTablets();
    } else {
        $messageHandler = new messageHandler('failed', 400, 'All filed required', 'Tablets required');
        echo $messageHandler->getResponse();
    }
} else {
    $messageHandler = new messageHandler('failed', 400, 'All filed required', 'All field required');
    echo $messageHandler->getResponse();
}
