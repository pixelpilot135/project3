<?php
session_start();

if (!isset($_SESSION['valid']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include_once("functions.php");

$username = $_SESSION['username'];
$id = $_SESSION['id'];
$email = '';

include_once("../Database/db.php");
$db = new Database();
$conn = $db->getConnection();

$query = $conn->prepare("SELECT id, gebruikersnaam, email, telefoon, geboortedatum, rol FROM gebruikers WHERE id = :id AND rol = 'admin'");
$query->bindParam(':id', $id, PDO::PARAM_INT);
$query->execute();
$admin = $query->fetch(PDO::FETCH_ASSOC);

if (!$admin) {
    echo "<p>Geen gebruiker gevonden. Log opnieuw in.</p>";
    exit();
}

?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../css/admin.css"> <!-- Eigen CSS bestand -->
</head>
<body>
    <!-- Navigatiebalk -->
    <nav>
        <a href="#">Drive Smart</a>
        <a href="../home/home.php">Home</a>
        <a href="wagenparkOverzicht.php">Wagenpark Overzicht</a>
        <a href="add-instructeur.php">Instructeur Toevoegen</a>
        <a href="mededeling-admin.php">Mededeling Maken</a>
    </nav>

    <div class="container">

        <!-- Welkomstbox voor de ingelogde admin -->
        <div class="mt-4">
            <h2>Welkom, <?php echo htmlspecialchars($admin['gebruikersnaam']); ?>!</h2>
            <p> Hier zijn uw gegevens:</p>

            <!-- Admin Gegevens Tabel -->
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Label</th>
                        <th>Informatie</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Gebruikersnaam</strong></td>
                        <td><?php echo htmlspecialchars($admin['gebruikersnaam']); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Email</strong></td>
                        <td><?php echo htmlspecialchars($admin['email']); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Telefoonnummer</strong></td>
                        <td><?php echo htmlspecialchars($admin['telefoon']); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Geboortedatum</strong></td>
                        <td><?php echo htmlspecialchars($admin['geboortedatum']); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Rol</strong></td>
                        <td><?php echo htmlspecialchars($admin['rol']); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

</body>
</html>
