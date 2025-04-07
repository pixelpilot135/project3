<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("php/db.php");

session_start();

class Register {
    private $db;
    private $con;

    public function __construct() {
        $this->db = new Database();
        $this->con = $this->db->db;
    }

    public function registerUser($username, $email, $birthdate, $phone, $city, $password) {
        $verify_query = $this->con->prepare("SELECT Email FROM users WHERE Email = ?");
        $verify_query->bind_param('s', $email);
        $verify_query->execute();
        $verify_query->store_result();

        if ($verify_query->num_rows > 0) {
            return "Dit e-mailadres is al in gebruik probeer een andere manier.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $insert_query = $this->con->prepare("INSERT INTO users (Username, Email, Geboortedatum, Telefoonnummer, Stad, Wachtwoord) 
            VALUES (?, ?, ?, ?, ?, ?)");
            $insert_query->bind_param('ssssss', $username, $email, $birthdate, $phone, $city, $hashed_password);
            $insert_query->execute();
            return "Registratie succesvol!";
        }
    }
}

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $birthdate = $_POST['birthdate'];
    $phone = $_POST['phone'];
    $city = $_POST['city'];
    $password = $_POST['password'];

    $register = new Register();
    $message = $register->registerUser($username, $email, $birthdate, $phone, $city, $password);

    if ($message == "Registratie succesvol!") {
        $_SESSION['user_email'] = $email;
        header("Location: home.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Registreren</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <header>Aanmelden</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="username">Gebruikersnaam</label>
                    <input type="text" name="username" id="username" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="birthdate">Geboortedatum</label>
                    <input type="date" name="birthdate" id="birthdate" required>
                </div>

                <div class="field input">
                    <label for="phone">Telefoonnummer</label>
                    <input type="text" name="phone" id="phone" required>
                </div>

                <div class="field input">
                    <label for="city">Stad</label>
                    <input type="text" name="city" id="city" required>
                </div>

                <div class="field input">
                    <label for="password">Wachtwoord</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Registreer" required>
                </div>
                <div class="links">
                    Heb je al een Account? <a href="login.php">Login</a>
                </div>
            </form>

            <?php if(isset($message)) { echo "<div class='message'><p>$message</p></div>"; } ?>
        </div>
    </div>
</body>
</html>
