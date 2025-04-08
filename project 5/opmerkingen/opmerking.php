<?php
class Opmerking
{
    private $db;

    // Constructor to initialize the database connection
    public function __construct($db)
    {
        $this->db = $db;
    }

    // Add a comment to the database
    public function voegOpmerkingToe($les_id, $gebruiker_id, $opmerking)
    {
        // Prepare SQL query to insert the comment
        $stmt = $this->db->prepare("INSERT INTO opmerkingen (les_id, gebruiker_id, opmerking) VALUES (?, ?, ?)");

        // Bind parameters
        $stmt->bindParam(1, $les_id, PDO::PARAM_INT);
        $stmt->bindParam(2, $gebruiker_id, PDO::PARAM_INT);
        $stmt->bindParam(3, $opmerking, PDO::PARAM_STR);

        // Execute the query and return result
        return $stmt->execute();
    }

    // Get all lessons from the database
    public function getLessen()
    {
        $stmt = $this->db->prepare("SELECT id, onderwerp, les_datum FROM lessen WHERE status = 'gepland'");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
