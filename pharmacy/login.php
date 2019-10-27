<?php
require_once('../common/header.php');
require_once('../common/connection.php');
require_once('./pharmacy.php');
require_once('../common/messageHandler.php');
$connection = new connection();
$conn = $connection->getConnection();
$pharmacy = new pharmacy($conn);

$data = json_decode(file_get_contents("php://input"));


if(!empty($data->email) && !empty($data->password)){
    $pharmacy->pharmacy_email = $data->email;
    $pharmacy->pharmacy_password = $data->password;
    echo $pharmacy->login();
}
else {
    $messageHandler = new messageHandler('failed', 400, 'Email and Password required', 'User login failed');
    echo $messageHandler->getResponse();
}



