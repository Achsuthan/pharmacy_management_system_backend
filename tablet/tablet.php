<?php
include_once('../qr/qr.php');
class tablet
{
    private $conn;
    private $tableName = "tablet";
    public $tablets = [];
    public $prescriptionId;
    public $pharmacyId;
    public $userId;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function addTablets()
    {
        $success = true;
        foreach ($this->tablets as $tablet) {
            $sql = "INSERT INTO " . $this->tableName . " (tablet_name, time, is_done, prescription_id, isQr) VALUES ('" . $tablet->tablet_name . "', '" . $tablet->time . "', '', '" . $this->prescriptionId . "', '')";
            echo $sql;
            if ($this->conn->query($sql) === TRUE) { } else {
                $success = false;
                $messageHandler = new messageHandler("faild", 500, "user register faild", "Something wrong");
                echo $messageHandler->getResponse();
                break;
            }
        }

        if ($success) {
            $arr = array('status' => 200, 'message' => 'Prescription added successfuly', 'details' => "Prescription added successfully");
            echo json_encode($arr);
        }
    }

    function updateTablets()
    {
        $status = true;
        foreach ($this->tablets as $tablet) {
            if (!$this->checkTabletsFree($tablet->id)) {
                $sql = "UPDATE " . $this->tableName . " SET is_done='" . $this->pharmacyId . "' WHERE id='" . $tablet->id . "'";

                if ($this->conn->query($sql) === TRUE) { } else {
                    $status = false;
                    $messageHandler = new messageHandler("faild", 500, "user register faild", "Something wrong");
                    echo $messageHandler->getResponse();
                    break;
                }
            }
        }

        if ($status) {
            $qr = new qr($this->conn);
            $qr->userId = $this->userId;
            $qr->prescriptionId = $this->prescriptionId;
            $qr->pharmacyId = $this->pharmacyId;
            $qr->createQr();

            $arr = array('status' => 200, 'message' => 'Tablets updated successfuly', 'details' => "Tablets updated successfully");
            echo json_encode($arr);
        }
    }

    function checkTabletsFree($tabletId)
    {
        $query = "SELECT * FROM " . $this->tableName . " WHERE id = '$this->tabletId' AND is_done ='' AND isQr= ''";
        $stmt = $this->conn->query($query);

        if ($stmt->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    function getPrescriptionForPharmacy()
    {

        $query = "SELECT DISTINCT prescription_id  FROM " . $this->tableName . " Where is_done ='' AND isQR = ''";
        $stmt = $this->conn->query($query);
        $arr = array();
        if ($stmt->num_rows > 0) {
            while ($row = $stmt->fetch_assoc()) {
                array_push($arr, $row["prescription_id"]);
            }
            return $arr;
        } else {
            return $arr;
        }
    }

    function getPrescriptionForReadyForDelivery(){
        $query = "SELECT DISTINCT prescription_id  FROM " . $this->tableName . " Where is_done ='".$this->pharmacyId."' AND isQR = ''";
        $stmt = $this->conn->query($query);
        $arr = array();
        if ($stmt->num_rows > 0) {
            
            while ($row = $stmt->fetch_assoc()) {
                array_push($arr, $row["prescription_id"]);
            }
            return $arr;
        } else {
            return $arr;
        }
    }
    function getPrescriptionForDelivered(){
        $query = "SELECT DISTINCT prescription_id  FROM " . $this->tableName . " Where is_done ='".$this->pharmacyId."' AND isQR = 'true'";
        $stmt = $this->conn->query($query);
        $arr = array();
        if ($stmt->num_rows > 0) {
            
            while ($row = $stmt->fetch_assoc()) {
                array_push($arr, $row["prescription_id"]);
            }
            return $arr;
        } else {
            return $arr;
        } 
    }

    function getTabletsFromPrescription()
    {
        $query = "SELECT *  FROM " . $this->tableName . " Where is_done ='' and prescription_id = '" . $this->prescriptionId . "'";
        $stmt = $this->conn->query($query);

        if ($stmt->num_rows > 0) {
            $arr = array();
            while ($row = $stmt->fetch_assoc()) {
                array_push($arr, array("id" => $row[id], "tablet_name" => $row["tablet_name"], "time" => $row["time"], "prescription_id" => $row["prescription_id"], "isAvailable"=> false));
            }
            $tArr = array("status" => 200, "details" => "Tablets found", "details" => $arr);
            echo json_encode($tArr);
        } else {
            $messageHandler = new messageHandler("faild", 400, "Tablets not found", "Tablets not found");
            echo $messageHandler->getResponse();
        }
    }

    function updateQR()
    {
        $sql = "UPDATE " . $this->tableName . " SET isQR='true' WHERE prescription_id='" . $this->prescriptionId . "' and is_done='" . $this->pharmacyId . "'";

        if ($this->conn->query($sql) === TRUE) {
            $arr = array('status' => 200, 'message' => 'QR validated successfuly', 'details' => "QR validated successfully");
            echo json_encode($arr);
        } else {
            $messageHandler = new messageHandler("faild", 500, "QR validation faild", "QR validation faild");
            echo $messageHandler->getResponse();
        }
    }
}
