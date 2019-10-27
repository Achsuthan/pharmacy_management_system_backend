<?php
class tablet
{
    private $conn;
    private $tableName = "tablet";
    public $tablets = [];
    public $prescriptionId;
    public $pharmacyId;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function addTablets()
    {
        echo $this->prescriptionId;
        foreach ($this->tablets as $tablet) {
            $sql = "INSERT INTO " . $this->tableName . " (tablet_name, time, is_done, prescription_id) VALUES ('" . $tablet->tablet_name . "', '" . $tablet->time . "', '', '" . $this->prescriptionId . "')";
            if ($this->conn->query($sql) === TRUE) { } else {
                $messageHandler = new messageHandler("faild", 500, "user register faild", "Something wrong");
                echo $messageHandler->getResponse();
                break;
            }
        }

        $arr = array('code' => 200, 'message' => 'Prescription added successfuly', 'details' => "Prescription added successfully");
        echo json_encode($arr);
    }

    function updateTablets()
    {
        foreach ($this->tablets as $tablet) {
            if (!$this->checkTabletsFree($tablet->id)) {
                $sql = "UPDATE " . $this->tableName . " SET is_done='".$this->pharmacyId."' WHERE id='".$tablet->id."'";

                if ($this->conn->query($sql) === TRUE) {
                    echo "Record updated successfully";
                } else {
                    $messageHandler = new messageHandler("faild", 500, "user register faild", "Something wrong");
                    echo $messageHandler->getResponse();
                    break;
                }
            }
        }
        $arr = array('code' => 200, 'message' => 'Tablets updated successfuly', 'details' => "Tablets updated successfully");
        echo json_encode($arr);
    }

    function checkTabletsFree($tabletId)
    {
        $query = "SELECT * FROM " . $this->tableName . " WHERE id = '$this->tabletId' AND is_done =''";
        $stmt = $this->conn->query($query);

        if ($stmt->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }
}
