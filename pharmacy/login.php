<?php
require_once('../common/header.php');
require_once('../common/connection.php');
require_once('./pharmacy.php');
$connection = new connection();
$conn = $connection->getConnection();

$pharmacy = new pharmacy($conn);
$pharmacy->login();


