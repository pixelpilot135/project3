<?php
include_once 'les2.php';
include_once '../Database/db.php';

$database = new Database();
$db = $database->getConnection();

$instructeurs_query = "SELECT id, gebruikersnaam FROM gebruikers WHERE rol = 'instructeur'";
$instructeurs = $database->selectAll($instructeurs_query);

$autos_query = "SELECT id, merk, model, kenteken, toegewezen_aan FROM autos WHERE status = 'beschikbaar' AND toegewezen_aan IS NULL";
$autos = $database->selectAll($autos_query);

$leerling_id = 5;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $instructeur_id = $_POST['instructeur_id'];
    $les_datum = $_POST['les_datum'];
    $onderwerp = $_POST['onderwerp'];
    $auto_id = getAutoToegewezenAanInstructeur($instructeur_id, $autos);

    if ($auto_id) {
        $les = new Les($db);
        $les->leerling_id = $leerling_id;
        $les->instructeur_id = $instructeur_id;
        $les->auto_id = $auto_id;
        $les->les_datum = $les_datum;
        $les->onderwerp = $onderwerp;
        if ($les->planLes()) {
            echo "<div>Les succesvol ingepland!</div>";
        } else {
            echo "<div>Er is een fout opgetreden. Probeer het opnieuw.</div>";
        }
    } else {
        echo "<div>Geen beschikbare auto's voor deze instructeur.</div>";
    }
}

function getAutoToegewezenAanInstructeur($instructeur_id, $autos) {
    foreach ($autos as $auto) {
        if ($auto['toegewezen_aan'] === null) {
            global $db;
            $update_query = "UPDATE autos SET toegewezen_aan = :instructeur_id WHERE id = :auto_id";
            $stmt = $db->prepare($update_query);
            $stmt->bindParam(':instructeur_id', $instructeur_id);
            $stmt->bindParam(':auto_id', $auto['id']);
            $stmt->execute();

            return $auto['id'];
        }
    }

    return null;
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

        <label for="les_datum">Les Datum:</label>
        <input type="datetime-local" id="les_datum" name="les_datum" required><br>

        <label for="onderwerp">Onderwerp:</label>
        <input type="text" id="onderwerp" name="onderwerp" required><br>

        <button type="submit">Plan Les</button>
    </form>
</body>
</html>
