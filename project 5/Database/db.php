<?php
class Database
{
    private $dbh;
    protected $stmt;

    public function __construct($db = 'drivesmart', $host = "localhost:3306", $user = "root", $pass = "")
    {
        try {
            $this->dbh = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function run($sql, $placeholder = NULL)
    {
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute($placeholder);
        return $stmt;  
    }

    public function execute($params, $sql)
    {
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute($params);
        return $stmt->rowCount();
    }

    public function select($params, $sql){
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch();

    }

    public function selectAll($sql)
    {
        try {
            $sth = $this->dbh->prepare($sql);
            $sth->execute();
            $result = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo '' . $e->getMessage();
        }
    }

    public function getConnection()
    {
        return $this->dbh;
    }
}

$mydb = new Database("drivesmart");
?>
