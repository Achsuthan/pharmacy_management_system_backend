<?php
require_once '../tablet/tablet.php';
class qr
{
    private $conn;
    private $tableName = "qr";
    public $userId;
    public $prescriptionId;
    public $pharmacyId;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    function createQr()
    {
        $sql = "INSERT INTO " . $this->tableName . " (user_id, prescription_id, pharmacy_id) VALUES ('" . $this->userId . "', '" . $this->prescriptionId . "', '".$this->pharmacyId."')";
        if ($this->conn->query($sql) === TRUE) { } else { }
        return;
    }

    function validateQr(){
        $query = "SELECT * FROM " . $this->tableName . " WHERE user_id = '$this->userId' AND prescription_id ='$this->prescriptionId' AND pharmacy_id = '$this->pharmacyId'";
        $stmt = $this->conn->query($query);

        if ($stmt->num_rows > 0) {
            $tablet = new tablet($this->conn);
            $tablet->prescriptionId = $this->prescriptionId;
            $tablet->pharmacyId = $this->pharmacyId;
            $tablet->updateQR();
        } else {
            $messageHandler = new messageHandler("faild", 500, "QR validate faild", "QR validate faild");
            echo $messageHandler->getResponse();
        }
    }
}
