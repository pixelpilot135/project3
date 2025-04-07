<?php
class Database
{

    public $db;

    public $host_name, $dbname, $username, $password;

    function __construct()
    {
        $this->host_name = "localhost";
        $this->dbname = "drivesmart";
        $this->username = "root";
        $this->password = "";
        try {

            $this->db = new PDO("mysql:host=$this->host_name;dbname=$this->dbname", $this->username, $this->password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function execute($params, $sql)
    {

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->rowCount();


    }

    public function selectAll($sql)
    {
        try {
            $sth = $this->db->prepare($sql);
            $sth->execute();
            $result = $sth->fetchAll(\PDO::FETCH_ASSOC);

            return $result;
        } catch (PDOException $e) {
            echo '' . $e->getMessage();

        }
    }
    public function getConnection()
    {
        return $this->db;  // Geef de bestaande PDO-verbinding terug
    }


}






?>