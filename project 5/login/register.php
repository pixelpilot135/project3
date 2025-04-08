<?php
// Deze code laat een gebruiker inloggen door de gegevens in te voeren en te controleren of ze kloppen.
session_start();
include_once("functions.php");

class Registration {
    private $username;
    private $email;
    private $birthdate;
    private $phone;
    private $city;
    private $password;
    private $user;

    // Constructor die de gegevens van de gebruiker ontvangt en opslaat
    public function __construct($username, $email, $birthdate, $phone, $city, $password) {
        $this->username = $username;
        $this->email = $email;
        $this->birthdate = $birthdate;
        $this->phone = $phone;
        $this->city = $city;
        $this->password = $password;
        $this->user = new User(); // Maak een nieuw gebruikers object aan
    }

    // Functie die de registratie uitvoert en de gebruiker doorstuurt bij succes
    public function register() {
        $message = $this->user->registerUser($this->username, $this->email, $this->birthdate, $this->phone, $this->city, $this->password);

        // Als de registratie succesvol is wordt de gebruiker doorgestuurd naar de homepagin
        if ($message == "Registratie succesvol!") {
            $_SESSION['user_email'] = $this->email;
            header("Location: home.php");
            exit;
        }

        return $message; // Als er een fout is, wordt het bericht teruggegeven
    }
}

// Controleer of het formulier is ingediend en voer de registratie uit
if (isset($_POST['submit'])) {
    $registration = new Registration(
        $_POST['username'],
        $_POST['email'],
        $_POST['birthdate'],
        $_POST['phone'],
        $_POST['city'],
        $_POST['password']
    );
    $message = $registration->register(); // Voer de registratie uit
}
?>


<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login.css">  
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
