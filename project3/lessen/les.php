<?php

include_once '../Database/db.php';

class Lesson
{
    private $db;

    public function __construct()
    {
        $this->db = new Database(); 
    }

    public function getAvailableCars()
    {
        $stmt = $this->db->db->prepare("SELECT id, merk, model, kenteken FROM autos WHERE status = 'beschikbaar'");
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getInstructeurs()
    {
        $stmt = $this->db->db->prepare("SELECT id, gebruikersnaam FROM gebruikers WHERE rol = 'instructeur'");
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getLeerlingen()
    {
        $stmt = $this->db->db->prepare("SELECT id, gebruikersnaam FROM gebruikers WHERE rol = 'leerling'");
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function createLesson($leerlingId, $instructeurId, $autoId, $lesDatum, $onderwerp)
    {
        $stmt = $this->db->db->prepare("INSERT INTO lessen (leerling_id, instructeur_id, auto_id, les_datum, onderwerp, status) 
                                        VALUES (?, ?, ?, ?, ?, 'gepland')");
        $stmt->bind_param("iiiss", $leerlingId, $instructeurId, $autoId, $lesDatum, $onderwerp);

        if ($stmt->execute()) {
            echo "Les succesvol aangemaakt!";
        } else {
            echo "Fout bij het aanmaken van de les: " . $stmt->error;
        }

        $stmt->close();
    }



    public function getLeerlingLessons($leerlingId)
{
    $stmt = $this->db->db->prepare("SELECT id, les_datum, onderwerp FROM lessen WHERE leerling_id = ? AND status = 'gepland'");
    $stmt->bind_param("i", $leerlingId);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);
}

public function cancelLesson($lesId, $reden)
{
    $stmt = $this->db->db->prepare("UPDATE lessen SET status = 'geannuleerd', reden = ? WHERE id = ?");
    $stmt->bind_param("si", $reden, $lesId);

    if ($stmt->execute()) {
        echo "Les succesvol geannuleerd!";
    } else {
        echo "Fout bij het annuleren van de les: " . $stmt->error;
    }

    $stmt->close();
}


}
?>
