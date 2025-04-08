<?php
session_start();
include_once("functions.php");

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = new User();
    $message = $user->loginUser($username, $password);
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login.css">  
    <title>Inloggen</title>
</head>
<body>
    <div class="container">
        <div class="box form-box">
            <header>Inloggen</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="username">Gebruikersnaam</label>
                    <input type="text" name="username" id="username" autocomplete="off" required>
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
