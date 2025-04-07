<?php
session_start();
include("php/db.php");

class Home {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getUserInfo($id) {
        $query = $this->conn->prepare("SELECT * FROM users WHERE Id = ?");
        $query->bind_param('i', $id);
        $query->execute();
        $result = $query->get_result();
        return $result->fetch_assoc();
    }

    public function displayUserInfo($id) {
        $result = $this->getUserInfo($id);

        if (!$result) {
            echo "<p>Geen gebruiker gevonden. Je sessie is mogelijk verlopen. <a href='login.php'>Log opnieuw in</a>.</p>";
            exit();
        }

        return $result;
    }
}

if (!isset($_SESSION['valid'])) {
    header("Location: login.php");
    exit();
}

$id = $_SESSION['id'];
$db = new Database(); 
$home = new Home($db->db); 
$result = $home->displayUserInfo($id);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Home</title>
</head>
<body>
    <div class="nav">
        <div class="logo">
            <p><a href="home.php">DriveSmart</a></p>
        </div>
        <div class="right-links">
            <a href="edit.php?Id=<?php echo $result['Id']; ?>">Profiel Bewerken</a>
            <a href="php/logout.php"><button class="btn">Uitloggen</button></a>
        </div>
    </div>
    <main>
        <div class="main-box top">
            <div class="top">
                <div class="box">
                    <p>Hallo!<b><?php echo htmlspecialchars($result['Username']); ?></b> Welkom!</p>
                </div>
                <div class="box">
                    <p>Emailadres<b><?php echo htmlspecialchars($result['Email']); ?></b>.</p>
                </div>
            </div>
            <div class="bottom">
                <div class="box">
                    <p>Geboortedatum<b><?php echo htmlspecialchars($result['Geboortedatum']); ?></b>.</p>
                    <p>Telefoonnummer<b><?php echo htmlspecialchars($result['Telefoonnummer']); ?></b>.</p>
                    <p>Woonplaats<b><?php echo htmlspecialchars($result['Stad']); ?></b>.</p>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
