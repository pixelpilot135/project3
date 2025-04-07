<?php
session_start();
include("php/db.php");

class Profile {
    private $db;
    private $con;

    public function __construct() {
        $this->db = new Database();
        $this->con = $this->db->db;
    }

    public function getUserInfo($id) {
        $query = $this->con->prepare("SELECT * FROM users WHERE Id = ?");
        $query->bind_param('i', $id);
        $query->execute();
        return $query->get_result()->fetch_assoc();
    }

    public function updateUserProfile($id, $username, $email, $birthdate, $phone, $city) {
        $update_query = $this->con->prepare("UPDATE users SET Username = ?, Email = ?, Geboortedatum = ?, Telefoonnummer = ?, Stad = ? WHERE Id = ?");
        $update_query->bind_param('sssssi', $username, $email, $birthdate, $phone, $city, $id);
        $update_query->execute();
    }
}

if (!isset($_SESSION['valid'])) {
    header("Location: login.php");
    exit();
}

$id = $_SESSION['id'];
$profile = new Profile();
$result = $profile->getUserInfo($id);

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $birthdate = $_POST['birthdate'];
    $phone = $_POST['phone'];
    $city = $_POST['city'];

    $profile->updateUserProfile($id, $username, $email, $birthdate, $phone, $city);

    $_SESSION['username'] = $username;
    $_SESSION['email'] = $email;
    $_SESSION['birthdate'] = $birthdate;
    $_SESSION['phone'] = $phone;
    $_SESSION['city'] = $city;

    header("Location: home.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Profiel Bewerken</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <header>Profiel Bewerken</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="username">Gebruikersnaam</label>
                    <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($result['Username']); ?>" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" value="<?php echo htmlspecialchars($result['Email']); ?>" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="birthdate">Geboortedatum</label>
                    <input type="date" name="birthdate" id="birthdate" value="<?php echo htmlspecialchars($result['Geboortedatum']); ?>" required>
                </div>

                <div class="field input">
                    <label for="phone">Telefoonnumer</label>
                    <input type="text" name="phone" id="phone" value="<?php echo htmlspecialchars($result['Telefoonnummer']); ?>" required>
                </div>

                <div class="field input">
                    <label for="city">Stad</label>
                    <input type="text" name="city" id="city" value="<?php echo htmlspecialchars($result['Stad']); ?>" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Bijwerken" required>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
