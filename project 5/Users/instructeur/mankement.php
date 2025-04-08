<?php
class Mankement
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function meldMankement($auto_id, $instructeur_id, $beschrijving)
    {
        $this->db->beginTransaction();

        try {

            $query = "INSERT INTO mankementen (auto_id, instructeur_id, beschrijving)
                      VALUES (:auto_id, :instructeur_id, :beschrijving)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':auto_id', $auto_id);
            $stmt->bindParam(':instructeur_id', $instructeur_id);
            $stmt->bindParam(':beschrijving', $beschrijving);
            $stmt->execute();

            $updateQuery = "UPDATE autos SET status = 'onderhoud' WHERE id = :auto_id";
            $updateStmt = $this->db->prepare($updateQuery);
            $updateStmt->bindParam(':auto_id', $auto_id);
            $updateStmt->execute();
            $this->db->commit();

            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }
}
?>
