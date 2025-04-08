<?php

include_once '../Database/db.php';

class Lesson
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();  // Initialize the Database class
    }

    public function getAvailableCars()
    {
        // Use $this->db->getConnection() to access the PDO instance
        $stmt = $this->db->getConnection()->prepare("SELECT id, merk, model, kenteken FROM autos WHERE status = 'beschikbaar'");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all results as associative array
    }

    public function getInstructeurs()
    {
        // Use $this->db->getConnection() to access the PDO instance
        $stmt = $this->db->getConnection()->prepare("SELECT id, gebruikersnaam FROM gebruikers WHERE rol = 'instructeur'");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all results as associative array
    }

    public function getLeerlingen()
    {
        // Use $this->db->getConnection() to access the PDO instance
        $stmt = $this->db->getConnection()->prepare("SELECT id, gebruikersnaam FROM gebruikers WHERE rol = 'leerling'");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all results as associative array
    }

    public function createLesson($leerlingId, $instructeurId, $autoId, $lesDatum, $onderwerp)
    {
        // Use $this->db->getConnection() to access the PDO instance
        $stmt = $this->db->getConnection()->prepare("INSERT INTO lessen (leerling_id, instructeur_id, auto_id, les_datum, onderwerp, status) 
                                                        VALUES (?, ?, ?, ?, ?, 'gepland')");
        $stmt->bindParam(1, $leerlingId, PDO::PARAM_INT);
        $stmt->bindParam(2, $instructeurId, PDO::PARAM_INT);
        $stmt->bindParam(3, $autoId, PDO::PARAM_INT);
        $stmt->bindParam(4, $lesDatum, PDO::PARAM_STR);
        $stmt->bindParam(5, $onderwerp, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo "Les succesvol aangemaakt!";
        } else {
            echo "Fout bij het aanmaken van de les: " . implode(", ", $stmt->errorInfo());
        }
    }

    public function getLeerlingLessons($leerlingId)
    {
        // Use $this->db->getConnection() to access the PDO instance
        $stmt = $this->db->getConnection()->prepare("SELECT id, les_datum, onderwerp FROM lessen WHERE leerling_id = ? AND status = 'gepland'");
        $stmt->bindParam(1, $leerlingId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all results as associative array
    }

    public function cancelLesson($lesId, $reden)
    {
        // Use $this->db->getConnection() to access the PDO instance
        $stmt = $this->db->getConnection()->prepare("UPDATE lessen SET status = 'geannuleerd', reden = ? WHERE id = ?");
        $stmt->bindParam(1, $reden, PDO::PARAM_STR);
        $stmt->bindParam(2, $lesId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "Les succesvol geannuleerd!";
        } else {
            echo "Fout bij het annuleren van de les: " . implode(", ", $stmt->errorInfo());
        }
    }
}
?>
