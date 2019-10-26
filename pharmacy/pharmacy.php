<?php
require_once('../common/messageHandler.php');
class pharmacy{
    private $conn;
    private $tableName = "pharmacy";

    public $pharmacy_name;
    public $pharmacy_email;
    public $pharmacy_password;

    public function __construct($db){
        $this->conn = $db;
    }

    function login(){
        $messageHandler = new messageHandler("success", 200, "user login successfull", "user login successfully");
        echo $messageHandler->getResponse();
    }

    function register(){

    }

    function checkemail(){
        return false;
    }
}
