<?php
// deze code regelt het ophalen en bijwerken van de gebruikersprofielinformatie
session_start();
include_once("../Database/db.php");

class Profile {
    private $conn;

    // constructor die het databaseverbinding maakt
    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // haalt de gebruikersinformatie op van het database
    public function getUserInfo($id) {
        $query = $this->conn->prepare("SELECT * FROM gebruikers WHERE id = :id");
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    // update de profielinformatie van de gebruiker in het database
    public function updateUserProfile($id, $username, $email, $birthdate, $phone, $city) {
        $query = $this->conn->prepare("UPDATE gebruikers SET gebruikersnaam = ?, email = ?, geboortedatum = ?, telefoon = ?, stad = ? WHERE id = ?");
        $query->bindParam(1, $username);
        $query->bindParam(2, $email);
        $query->bindParam(3, $birthdate);
        $query->bindParam(4, $phone);
        $query->bindParam(5, $city);
        $query->bindParam(6, $id, PDO::PARAM_INT);
        $query->execute();
        return $query->rowCount() > 0;
    }
}

class ProfileController {
    private $profile;
    private $userId;

    // constructor die het profiel object maakt en het gebruikersid ontvangt
    public function __construct($userId) {
        $this->profile = new Profile();
        $this->userId = $userId;
    }

    // haalt het profiel van de gebruiker op
    public function getProfile() {
        return $this->profile->getUserInfo($this->userId);
    }

    // werkt het profiel bij en slaat de wijzigingen op
    public function updateProfile($data) {
        $result = $this->profile->updateUserProfile($this->userId, $data['username'], $data['email'], $data['birthdate'], $data['phone'], $data['city']);
        if ($result) {
            $_SESSION['username'] = $data['username'];
            $_SESSION['email'] = $data['email'];
            $_SESSION['birthdate'] = $data['birthdate'];
            $_SESSION['phone'] = $data['phone'];
            $_SESSION['city'] = $data['city'];
        }
        return $result;
    }
}

if (!isset($_SESSION['valid'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['id'];
$controller = new ProfileController($userId);
$result = $controller->getProfile();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = [
        'username' => $_POST['username'],
        'email' => $_POST['email'],
        'birthdate' => $_POST['birthdate'],
        'phone' => $_POST['phone'],
        'city' => $_POST['city'],
    ];
    $updateSuccess = $controller->updateProfile($data);
    if ($updateSuccess) {
        header("Location: leerling-dashboard.php");
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login.css">  
    <title>Profiel Bewerken</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <header>Profiel Bewerken</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="username">Gebruikersnaam</label>
                    <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($result['gebruikersnaam'] ?? ''); ?>" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" value="<?php echo htmlspecialchars($result['email'] ?? ''); ?>" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="birthdate">Geboortedatum</label>
                    <input type="date" name="birthdate" id="birthdate" value="<?php echo htmlspecialchars($result['geboortedatum'] ?? ''); ?>" required>
                </div>

                <div class="field input">
                    <label for="phone">Telefoonnummer</label>
                    <input type="text" name="phone" id="phone" value="<?php echo htmlspecialchars($result['telefoon'] ?? ''); ?>" required>
                </div>

                <div class="field input">
                    <label for="city">Stad</label>
                    <input type="text" name="city" id="city" value="<?php echo htmlspecialchars($result['stad'] ?? ''); ?>" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" value="Bijwerken">
                </div>
                
                <a href="leerling-dashboard.php">Terug naar Home</a>
            </form>
        </div>
    </div>
</body>
</html>
