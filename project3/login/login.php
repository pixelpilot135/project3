<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("php/db.php");

session_start();

class Login {
    private $db;
    private $con;

    public function __construct() {
        $this->db = new Database();
        $this->con = $this->db->db; 
    }

    public function loginUser($email, $password) {
        $query = $this->con->prepare("SELECT * FROM users WHERE Email = ?");
        $query->bind_param('s', $email);
        $query->execute();
        $result = $query->get_result();
        $row = $result->fetch_assoc();

        if ($row && password_verify($password, $row['Wachtwoord'])) {
            $_SESSION['valid'] = $row['Email'];
            $_SESSION['username'] = $row['Username'];
            $_SESSION['id'] = $row['Id'];
            header("Location: home.php");
            exit;
        } else {
            return "Verkeerde e-mail of wachtwoord.";
        }
    }
}

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $login = new Login();
    $message = $login->loginUser($email, $password);
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Inloggen</title>
</head>
<body>
      <div class="container">
        <div class="box form-box">
            <header>Inloggen</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="password">Wachtwoord</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Inloggen" required>
                </div>
                <div class="links">
                    Geen Account? <a href="register.php">Registreer</a>
                </div>
            </form>

            <?php 
            if (isset($message)) {
                echo "<div class='message'>
                          <p>$message</p>
                      </div> <br>";
            }
            ?>
        </div>
      </div>
</body>
</html>