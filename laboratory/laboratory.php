<?php
require_once('../common/messageHandler.php');
class laboratory
{
    private $conn;
    private $tableName = "laboratory";

    public $pharmacy_name;
    public $pharmacy_email;
    public $pharmacy_password;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    function login()
    {
        // select all query
        $query = "SELECT * FROM " . $this->tableName . " WHERE email = '" . $this->pharmacy_email . "' AND password = '" . $this->pharmacy_password . "'";

        $stmt = $this->conn->query($query);

        if ($stmt->num_rows > 0) {
            // output data of each row
            while ($row = $stmt->fetch_assoc()) {
                $arr = array('code' => 200, 'message' => 'User login successfuly', 'details' => array('name' => $row["name"], 'eamil' => $row["email"]));
                echo json_encode($arr);
            }
        } else {
            $messageHandler = new messageHandler("faild", 400, "user login failed", "user email or password not matched");
            echo $messageHandler->getResponse();
        }
    }

    function register()
    {
        if (!$this->checkemail()) {
            $sql = "INSERT INTO " . $this->tableName . " (name, email, password) VALUES ('".$this->pharmacy_name."', '".$this->pharmacy_email."', '".$this->pharmacy_password."')";
            if ($this->conn->query($sql) === TRUE) {
                $arr = array('code' => 200, 'message' => 'User added successfuly', 'details' => array('name' => $this->pharmacy_name, 'eamil' => $this->pharmacy_email));
                echo json_encode($arr);
            } else {
                $messageHandler = new messageHandler("faild", 500, "user register faild", "Something wrong");
                echo $messageHandler->getResponse();
            }
        } else {
            $messageHandler = new messageHandler("faild", 400, "user login failed", "user email already exisit");
            echo $messageHandler->getResponse();
        }
    }

    function checkemail()
    {
        // select all query
        $query = "SELECT * FROM " . $this->tableName . " WHERE email = '$this->pharmacy_email'";
        $stmt = $this->conn->query($query);

        if ($stmt->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }
}
