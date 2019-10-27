<?php
require_once("../common/messageHandler.php");
require_once("../tablet/tablet.php");
class prescription{
    private $conn;
    private $tableName = "prescription";
    public $userId;
    public $doctorId;
    public $tablets = [];
    private $prescriptionId;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    function addPrescription(){
        if(count($this->tablets) > 0){
            $sql = "INSERT INTO " . $this->tableName . " (user_id, doctor_id) VALUES ('".$this->userId."', '".$this->doctorId."')";
            if ($this->conn->query($sql) === TRUE) {
                $this->prescriptionId = $this->conn->insert_id;
                $this->addTablets();
            } else {
                $messageHandler = new messageHandler("faild", 500, "Tablet add faild", "Server Failed");
                echo $messageHandler->getResponse();
            }
        }
        else {
            $messageHandler = new messageHandler('failed', 400, 'All filed required', 'Tablets required');
            echo $messageHandler->getResponse();
        }
    }

    function addTablets(){
        $tablets = new tablet($this->conn);
        $tablets->tablets = $this->tablets;
        $tablets->prescriptionId = $this->prescriptionId;
        $tablets->addTablets();
    }
}
