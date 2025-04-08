<?php
include_once '../Database/db.php';    // Include the Database connection
include_once 'Opmerking.php';         // Include the Opmerking class

// Initialize the database connection
$db = new Database(); // Zorg ervoor dat de Database klasse correct is gedefinieerd en verbinding maakt

// Maak een instantie van de Opmerking klasse en geef de databaseverbinding door
$opmerking = new Opmerking($db->getConnection()); // Verbind de database met de Opmerking klasse

$message = "";

$lessen = $opmerking->getLessen(); // Haal de lessen op

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verzamel POST data van het formulier
    $les_id = $_POST['les_id'];        // Het ID van de geselecteerde les
    $gebruiker_id = $_POST['gebruiker_id']; // Het ID van de instructeur (hardcoded voor nu, kan later dynamisch worden)
    $opmerkingText = $_POST['opmerking']; // De eigenlijke opmerking

    if ($opmerking->voegOpmerkingToe($les_id, $gebruiker_id, $opmerkingText)) {
        $message = "Opmerking succesvol toegevoegd!";
    } else {
        $message = "Er is een fout opgetreden bij het toevoegen van de opmerking.";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Opmerking Toevoegen</title>
</head>
<body>
    <h1>Voeg een opmerking toe aan een les</h1>

    <?php if (!empty($message)): ?>
        <p><?php echo $message; ?></p> <!-- Weergave van het succes- of foutbericht -->
    <?php endif; ?>

    <form method="POST">
        <label for="les_id">Kies een les:</label>
        <select id="les_id" name="les_id" required>
            <?php
            // Toon de lessen in een dropdown
            foreach ($lessen as $les) {
                echo "<option value='" . $les['id'] . "'>" . htmlspecialchars($les['onderwerp']) . " - " . htmlspecialchars($les['les_datum']) . "</option>";
            }
            ?>
        </select>

        <label for="opmerking">Opmerking:</label>
        <textarea id="opmerking" name="opmerking" required></textarea>

        <label for="gebruiker_id">Je ID (instructeur):</label>
        <input type="number" id="gebruiker_id" name="gebruiker_id" required>

        <button type="submit">Opmerking toevoegen</button>
    </form>
</body>
</html>
