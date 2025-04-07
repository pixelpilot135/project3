<?php
class Database {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "drivesmart";

    public $db;

    public function __construct() {
        $this->db = new mysqli($this->host, $this->username, $this->password, $this->database);
        
        if ($this->db->connect_error) {
            die("Verbinding mislukt: " . $this->db->connect_error);
        }
    }
}
?>
