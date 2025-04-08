<?php
session_start();
include_once("../Database/db.php");

class Home {
    private $conn;

    public function __construct($db) {
        $this->conn = $db->getConnection();
    }

    public function getUserInfo($id) {
        $query = $this->conn->prepare("SELECT * FROM gebruikers WHERE Id = :id");
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            echo "<p>Geen gebruiker gevonden. <a href='login.php'>Log opnieuw in</a>.</p>";
            exit();
        }
        return $result;
    }

    public function getSchedule($id) {
        $query = $this->conn->prepare("SELECT * FROM roosters WHERE gebruiker_id = :id ORDER BY dag ASC, start_tijd ASC");
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function isValidUser() {
        if (!isset($_SESSION['valid']) || !isset($_SESSION['id'])) {
            header("Location: login.php");
            exit();
        }
        return $_SESSION['id'];
    }
}

$db = new Database();
$home = new Home($db);
$userId = $home->isValidUser();
$userInfo = $home->getUserInfo($userId);
$schedule = $home->getSchedule($userId);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/home.css">  
  <title>Home</title>
</head>
<body>
    <div class="nav">
        <div class="logo">
            <p><a href="home.php">DriveSmart</a></p>
        </div>
        <div class="right-links">
            <a href="logout.php"><button class="btn">Uitloggen</button></a>
            <a href="edit.php?Id=<?php echo htmlspecialchars($userInfo['id']); ?>">Profiel Bewerken</a>
        </div>
    </div>
    <main>
        <div class="main-box top">
            <div class="top">
                <div class="box">
                    <p>Welkom <b><?php echo htmlspecialchars($userInfo['gebruikersnaam']); ?></b></p>
                </div>
                <div class="box">
                    <p>Email <b><?php echo htmlspecialchars($userInfo['email']); ?></b></p>
                </div>
            </div>
            <div class="bottom">
                <div class="box">
                    <p>Geboortedatum <b><?php echo htmlspecialchars($userInfo['geboortedatum']); ?></b></p>
                    <p>Telefoonnummer <b><?php echo htmlspecialchars($userInfo['telefoon']); ?></b></p>
                    <p>Woonplaats <b><?php echo htmlspecialchars($userInfo['stad']); ?></b></p>
                </div>
            </div>
        </div>
        <div class="schedule">
            <h2>Je Lesrooster</h2>
            <table>
                <tr>
                    <th>Datum</th>
                    <th>Start Tijd</th>
                    <th>Eind Tijd</th>
                    <th>Locatie</th>
                    <th>Onderwerp</th>
                </tr>

                <?php
                if ($schedule) {
                    foreach ($schedule as $lesson) {
                        echo "
                            <tr>
                                <td>" . htmlspecialchars($lesson['dag']) . "</td>
                                <td>" . htmlspecialchars($lesson['start_tijd']) . "</td>
                                <td>" . htmlspecialchars($lesson['eind_tijd']) . "</td>
                                <td>" . htmlspecialchars($lesson['locatie']) . "</td>
                                <td>" . htmlspecialchars($lesson['onderwerp']) . "</td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Geen lesrooster gevonden.</td></tr>";
                }
                ?>
            </table>
            <p><a href="lesrooster.php">Bekijk volledig lesrooster</a></p>
        </div>
    </main>
</body>
</html>
