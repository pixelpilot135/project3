<?php
include_once '../Database/db.php';   
include_once 'Mededeling.php';       

$db = new Database();

$mededeling = new Mededeling($db->getConnection());

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $sick_date = $_POST['sick_date'];
    $reason = $_POST['reason'];
    $duration = $_POST['duration'];
    $return_date = $_POST['return_date'];

    $messageContent = "Ziekmelding van Instructeur: " . htmlspecialchars($name) . "\n";
    $messageContent .= "Datum ziekmelding: " . htmlspecialchars($sick_date) . "\n";
    $messageContent .= "Reden: " . ($reason ? htmlspecialchars($reason) : 'Geen reden opgegeven') . "\n";
    $messageContent .= "Duur van afwezigheid: " . htmlspecialchars($duration) . "\n";
    $messageContent .= "Verwachte hersteldatum: " . ($return_date ? htmlspecialchars($return_date) : 'Onbekend') . "\n";

    $gebruiker_id = 0; 

    if ($mededeling->voegZiekmeldingToe($messageContent, $gebruiker_id)) {
        $message = "Ziekmelding succesvol ingediend!";
    } else {
        $message = "Er is een fout opgetreden bij het indienen van de ziekmelding.";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ziekmelding Instructeur</title>
</head>
<body>
    <h1>Ziekmelding Instructeur</h1>

    <?php if (!empty($message)): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="POST">
        <label for="name">Naam:</label>
        <input type="text" id="name" name="name" required>

        <label for="sick_date">Datum ziekmelding:</label>
        <input type="date" id="sick_date" name="sick_date" required>

        <label for="reason">Reden van ziekte (optioneel):</label>
        <textarea id="reason" name="reason"></textarea>

        <label for="duration">Duur van afwezigheid:</label>
        <select id="duration" name="duration" required>
            <option value="1">1 dag</option>
            <option value="multiple">Meerdere dagen</option>
            <option value="unknown">Onbekend</option>
        </select>

        <label for="return_date">Verwachte datum herstel (optioneel):</label>
        <input type="date" id="return_date" name="return_date">

        <button type="submit">Ziekmelden</button>
    </form>
</body>
</html>
