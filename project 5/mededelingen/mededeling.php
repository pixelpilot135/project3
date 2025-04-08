<?php
class Mededeling
{
    private $db;

    // Constructor to initialize the database connection
    public function __construct($db)
    {
        $this->db = $db;
    }

    // Add a mededeling to the database
    public function voegZiekmeldingToe($bericht, $gebruiker_id)
    {
        $gebruiker_id = $gebruiker_id == 0 ? null : $gebruiker_id;

        $stmt = $this->db->prepare("INSERT INTO mededelingen (bericht, gebruiker_id) VALUES (?, ?)");

        $stmt->bindParam(1, $bericht, PDO::PARAM_STR);
        $stmt->bindParam(2, $gebruiker_id, PDO::PARAM_INT);

        return $stmt->execute();
    }



    public function getMededelingenByRole($rol)
    {
        $stmt = $this->db->prepare(
            "SELECT m.id, m.bericht, m.gebruiker_id, m.aangemaakt_op, g.rol
             FROM mededelingen m
             JOIN gebruikers g ON m.gebruiker_id = g.id
             WHERE g.rol = ? ORDER BY m.aangemaakt_op DESC"
        );
        $stmt->bindParam(1, $rol, PDO::PARAM_STR);
        $stmt->execute();

        // Fetch all results
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
