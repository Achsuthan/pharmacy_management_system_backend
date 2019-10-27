<?php
require_once('../common/header.php');
require_once('../common/connection.php');
require_once('./laboratory.php');
require_once('../common/messageHandler.php');
$connection = new connection();
$conn = $connection->getConnection();
$pharmacy = new laboratory($conn);

$data = json_decode(file_get_contents("php://input"));


if(!empty($data->email) && !empty($data->password) && !empty($data->name)){
    $pharmacy->pharmacy_email = $data->email;
    $pharmacy->pharmacy_password = $data->password;
    $pharmacy->pharmacy_name = $data->name;
    
    echo $pharmacy->register();
}
else {
    $messageHandler = new messageHandler('failed', 400, 'All filed required', 'All field required');
    echo $messageHandler->getResponse();
}



