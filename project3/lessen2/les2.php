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

    // Methode om een nieuwe les in te plannen
    public function planLes() {
        $sql = "INSERT INTO lessen (leerling_id, instructeur_id, auto_id, les_datum, onderwerp, status)
                VALUES (:leerling_id, :instructeur_id, :auto_id, :les_datum, :onderwerp, 'gepland')";

        // Maak de voorbereide statement aan
        $stmt = $this->db->prepare($sql);

        // Bind de parameters aan de statement
        $stmt->bindParam(':leerling_id', $this->leerling_id);
        $stmt->bindParam(':instructeur_id', $this->instructeur_id);
        $stmt->bindParam(':auto_id', $this->auto_id);
        $stmt->bindParam(':les_datum', $this->les_datum);
        $stmt->bindParam(':onderwerp', $this->onderwerp);

        // Voer de statement uit
        try {
            if ($stmt->execute()) {
                return true;  // Les succesvol ingepland
            }
        } catch (PDOException $e) {
            echo "Fout bij het plannen van de les: " . $e->getMessage();  // Foutmelding in geval van een probleem
        }

        return false;  // Als het niet gelukt is
    }
}

?>
