<?php
include_once 'les.php';

$lesson = new Lesson();

$autos = $lesson->getAvailableCars();
$instructeurs = $lesson->getInstructeurs();
$leerlingen = $lesson->getLeerlingen();

if (isset($_POST['leerling_id']) && isset($_POST['instructeur_id']) && isset($_POST['auto_id']) && isset($_POST['les_datum']) && isset($_POST['onderwerp'])) {
    $leerlingId = $_POST['leerling_id']; 
    $instructeurId = $_POST['instructeur_id']; 
    $autoId = $_POST['auto_id']; 
    $lesDatum = $_POST['les_datum']; 
    $onderwerp = $_POST['onderwerp']; 

    $lesson->createLesson($leerlingId, $instructeurId, $autoId, $lesDatum, $onderwerp);
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Nieuwe Les Aanmaken</title>
</head>
<body>
    <h1>Nieuwe Les Aanmaken</h1>
    <form  method="post">
        <label for="leerling_id">Leerling:</label>
        <select name="leerling_id" id="leerling_id" required>
            <option value="">Kies een leerling</option>
            <?php foreach ($leerlingen as $leerling): ?>
                <option value="<?php echo $leerling['id']; ?>"><?php echo $leerling['gebruikersnaam']; ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="instructeur_id">Instructeur:</label>
        <select name="instructeur_id" id="instructeur_id" required>
            <option value="">Kies een instructeur</option>
            <?php foreach ($instructeurs as $instructeur): ?>
                <option value="<?php echo $instructeur['id']; ?>"><?php echo $instructeur['gebruikersnaam']; ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="auto_id">Auto:</label>
        <select name="auto_id" id="auto_id" required>
            <option value="">Kies een auto</option>
            <?php foreach ($autos as $auto): ?>
                <option value="<?php echo $auto['id']; ?>"><?php echo $auto['merk'] . ' ' . $auto['model'] . ' (' . $auto['kenteken'] . ')'; ?></option>
            <?php endforeach; ?>
        </select><br><br>
        
        <label for="les_datum">Les Datum en Tijd:</label>
        <input type="datetime-local" name="les_datum" id="les_datum" required><br><br>
        
        <label for="onderwerp">Onderwerp:</label>
        <input type="text" name="onderwerp" id="onderwerp" required><br><br>
        
        <input type="submit" value="Les Aanmaken">
    </form>
</body>
</html>
