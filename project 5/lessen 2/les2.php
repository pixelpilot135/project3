<?php
class Les {
    private $db;

    public $leerling_id;
    public $instructeur_id;
    public $auto_id;
    public $les_datum;
    public $onderwerp;

    public function __construct($db) {
        $this->db = $db;
    }

    public function planLes() {
        $sql = "INSERT INTO lessen (leerling_id, instructeur_id, auto_id, les_datum, onderwerp, status)
                VALUES (:leerling_id, :instructeur_id, :auto_id, :les_datum, :onderwerp, 'gepland')";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':leerling_id', $this->leerling_id);
        $stmt->bindParam(':instructeur_id', $this->instructeur_id);
        $stmt->bindParam(':auto_id', $this->auto_id);
        $stmt->bindParam(':les_datum', $this->les_datum);
        $stmt->bindParam(':onderwerp', $this->onderwerp);

        try {
            if ($stmt->execute()) {
                return true;
            }
        } catch (PDOException $e) {
            echo "Fout bij het plannen van de les: " . $e->getMessage();
        }

        return false;  
    }
}

?>
