<?php
require_once("../common/messageHandler.php");
require_once("../tablet/tablet.php");
class prescription
{
    private $conn;
    private $tableName = "prescription";
    public $userId;
    public $doctorId;
    public $tablets = [];
    private $prescriptionId;
    public $pre_name;
    public $pharmacyId;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    function addPrescription()
    {
        if (count($this->tablets) > 0) {
            $sql = "INSERT INTO " . $this->tableName . " (user_id, doctor_id, pre_name) VALUES ('" . $this->userId . "', '" . $this->doctorId . "', '" . $this->pre_name . "')";
            if ($this->conn->query($sql) === TRUE) {
                $this->prescriptionId = $this->conn->insert_id;
                $this->addTablets();
            } else {
                $messageHandler = new messageHandler("faild", 500, "Tablet add faild", "Server Failed");
                echo $messageHandler->getResponse();
            }
        } else {
            $messageHandler = new messageHandler('failed', 400, 'All filed required', 'Tablets required');
            echo $messageHandler->getResponse();
        }
    }

    function addTablets()
    {
        $tablets = new tablet($this->conn);
        $tablets->tablets = $this->tablets;
        $tablets->prescriptionId = $this->prescriptionId;
        $tablets->addTablets();
    }

    function getPrescriptionForPharmacy()
    {
        $tablets = new tablet($this->conn);
        $arr = $tablets->getPrescriptionForPharmacy();
        if (count($arr) > 0) {
            $tArr = array();
            foreach ($arr as $ar) {
                $query = "SELECT * FROM " . $this->tableName . " WHERE id = '$ar'";
                $stmt = $this->conn->query($query);
                while ($row = $stmt->fetch_assoc()) {
                    array_push($tArr, array("id" => $row["id"], "pre_name" => $row["pre_name"], "user_id"=> $row["user_id"], "View"=>"View"));
                }
            }
            $tArr = array("status" => 200, "details" => "prescription found", "details" => $tArr);
            echo json_encode($tArr);
        } else {
            $messageHandler = new messageHandler('failed', 400, array(),'All filed required');
            echo $messageHandler->getResponse();
        }
    }

    function getPrescriptionForReadyForDelivery(){
        $tablets = new tablet($this->conn);
        $tablets->pharmacyId = $this->pharmacyId;
        $arr = $tablets->getPrescriptionForReadyForDelivery();
        if (count($arr) > 0) {
            $tArr = array();
            foreach ($arr as $ar) {
                $query = "SELECT * FROM " . $this->tableName . " WHERE id = '$ar'";
                $stmt = $this->conn->query($query);
                while ($row = $stmt->fetch_assoc()) {
                    array_push($tArr, array("id" => $row["id"], "pre_name" => $row["pre_name"], "user_id"=> $row["user_id"], "Status"=>"Scan QR"));
                }
            }
            $tArr = array("status" => 200, "details" => "prescription found", "details" => $tArr);
            echo json_encode($tArr);
        } else {
            $messageHandler = new messageHandler('failed', 400, array(),'All filed required');
            echo $messageHandler->getResponse();
        }
    }

    function getPrescriptionForDelivered(){
        $tablets = new tablet($this->conn);
        $tablets->pharmacyId = $this->pharmacyId;
        $arr = $tablets->getPrescriptionForDelivered();
        if (count($arr) > 0) {
            $tArr = array();
            foreach ($arr as $ar) {
                $query = "SELECT * FROM " . $this->tableName . " WHERE id = '$ar'";
                $stmt = $this->conn->query($query);
                while ($row = $stmt->fetch_assoc()) {
                    array_push($tArr, array("id" => $row["id"], "pre_name" => $row["pre_name"], "user_id"=> $row["user_id"], "Status"=>"Delived"));
                }
            }
            $tArr = array("status" => 200, "details" => "prescription found", "details" => $tArr);
            echo json_encode($tArr);
        } else {
            $messageHandler = new messageHandler('failed', 400, array(),'All filed required');
            echo $messageHandler->getResponse();
        }
    }
}
