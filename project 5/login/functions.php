<?php

// deze code verbind database met de code
include_once("../Database/db.php");

class User {
    private $db;

    // constructor die het databaseverbinding maakt
    public function __construct() {
        $this->db = new Database();
    }

    public function loginUser($username, $password) {
        $sql = "SELECT * FROM gebruikers WHERE gebruikersnaam = :gebruikersnaam";
        $stmt = $this->db->run($sql, ['gebruikersnaam' => $username]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row && password_verify($password, $row['wachtwoord'])) {

            $_SESSION['valid'] = $row['gebruikersnaam'];
            $_SESSION['username'] = $row['gebruikersnaam'];
            $_SESSION['id'] = $row['id'];
            $_SESSION['role'] = $row['rol'];
            
            switch ($row['rol']) {
                case 'admin':
                    header("Location: admin-panel.php");
                    break;
                case 'instructeur':
                    header("Location: instructeur-panel.php");
                    break;
                case 'leerling':
                    header("Location: leerling-dashboard.php");
                    break;
                default:
                    return "Onbekende rol.";
            }
            exit;
        } else {
            return "Verkeerde gebruikersnaam of wachtwoord.";
        }
    }

    // registratiefunctie voor nieuwe gebruikers
    public function registerUser($username, $email, $birthdate, $phone, $city, $password) {
        $con = $this->db->getConnection();
        $verify_query = $con->prepare("SELECT email FROM gebruikers WHERE email = :email");
        $verify_query->bindParam(':email', $email);
        $verify_query->execute();
        
        // controleer of het emailadres al in gebruik is
        if ($verify_query->rowCount() > 0) {
            return "Dit e-mailadres is al in gebruik.";
        } else {
            // als het emailadres niet in gebruik is wordt de gebruiker geregistreerd
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $insert_query = $con->prepare("INSERT INTO gebruikers (gebruikersnaam, email, geboortedatum, telefoon, stad, wachtwoord, rol) 
                                          VALUES (:username, :email, :birthdate, :phone, :city, :password, 'leerling')");
            $insert_query->bindParam(':username', $username);
            $insert_query->bindParam(':email', $email);
            $insert_query->bindParam(':birthdate', $birthdate);
            $insert_query->bindParam(':phone', $phone);
            $insert_query->bindParam(':city', $city);
            $insert_query->bindParam(':password', $hashed_password);
            $insert_query->execute();
            return "Registratie succesvol!";
        }
    }
}
?>
