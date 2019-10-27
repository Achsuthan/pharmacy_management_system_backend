<?php
class connection
{
    // specify your own database credentials
    private $host = "localhost";
    private $db_name = "PLMS";
    private $username = "root";
    private $password = "root";
    public $conn;

    // get the database connection
    public function getConnection()
    {

        $this->conn = null;
        // Create connection
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);
        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
        return $this->conn;
    }
}
