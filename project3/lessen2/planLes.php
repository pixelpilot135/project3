<?php
// Laad de database en Les klassen
include_once 'les2.php';
include_once '../Database/db.php';

// Maak verbinding met de database
$database = new Database();  // Nieuwe instantie van de Database klasse
$db = $database->getConnection();

// Haal instructeurs en auto's op uit de database
$instructeurs_query = "SELECT id, gebruikersnaam FROM gebruikers WHERE rol = 'instructeur'";
$autos_query = "SELECT id, merk, model, kenteken FROM autos WHERE status = 'beschikbaar'";

// Haal de gegevens op via de Database klasse
$instructeurs = $database->selectAll($instructeurs_query);  // Gebruik de Database methodes
$autos = $database->selectAll($autos_query);

// Stel het gebruikers-ID van de leerling handmatig in (bijvoorbeeld leerling met ID 1)
$leerling_id = 1; // Dit is een statisch ID, dit zou in de toekomst een dynamisch ID kunnen zijn na implementatie van login-systeem

// Controleer of het formulier is ingediend
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verkrijg formuliergegevens
    $instructeur_id = $_POST['instructeur_id'];
    $auto_id = $_POST['auto_id'];
    $les_datum = $_POST['les_datum'];
    $onderwerp = $_POST['onderwerp'];

    // Maak een Les object aan
    $les = new Les($db);
    $les->leerling_id = $leerling_id; // Stel het leerling ID in
    $les->instructeur_id = $instructeur_id;
    $les->auto_id = $auto_id;
    $les->les_datum = $les_datum;
    $les->onderwerp = $onderwerp;

    // Plan de les in
    if ($les->planLes()) {
        echo "<div style='color: green;'>Les succesvol ingepland!</div>";
    } else {
        echo "<div style='color: red;'>Er is een fout opgetreden. Probeer het opnieuw.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Plan een Les</title>
</head>
<body>
    <h2>Plan een Les</h2>
    <form action="planLes.php" method="POST">
        <label for="instructeur_id">Kies een instructeur:</label>
        <select name="instructeur_id" id="instructeur_id" required>
            <option value="">Selecteer een instructeur</option>
            <?php foreach ($instructeurs as $instructeur): ?>
                <option value="<?= $instructeur['id']; ?>"><?= $instructeur['gebruikersnaam']; ?></option>
            <?php endforeach; ?>
        </select><br>

        <label for="auto_id">Kies een auto:</label>
        <select name="auto_id" id="auto_id" required>
            <option value="">Selecteer een auto</option>
            <?php foreach ($autos as $auto): ?>
                <option value="<?= $auto['id']; ?>"><?= $auto['merk'] . ' ' . $auto['model'] . ' (' . $auto['kenteken'] . ')'; ?></option>
            <?php endforeach; ?>
        </select><br>

        <label for="les_datum">Les Datum:</label>
        <input type="datetime-local" id="les_datum" name="les_datum" required><br>

        <label for="onderwerp">Onderwerp:</label>
        <input type="text" id="onderwerp" name="onderwerp" required><br>

        <button type="submit">Plan Les</button>
    </form>
</body>
</html>
