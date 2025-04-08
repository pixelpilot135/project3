<?php
$userId = 1; 

include_once 'les.php';

$lesson = new Lesson();

$lessen = $lesson->getLeerlingLessons($userId);

if (isset($_POST['les_id']) && isset($_POST['reden'])) {
    $lesId = $_POST['les_id'];
    $reden = $_POST['reden'];

    $lesson->cancelLesson($lesId, $reden);
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Les Annuleren</title>
</head>
<body>
    <h1>Les Annuleren</h1>
    <form method="post">
        <label for="les_id">Les:</label>
        <select name="les_id" id="les_id" required>
            <option value="">Kies een les</option>
            <?php foreach ($lessen as $les): ?>
                <option value="<?php echo $les['id']; ?>">
                    <?php echo $les['les_datum'] . ' - ' . $les['onderwerp']; ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="reden">Reden van annulering:</label>
        <textarea name="reden" id="reden" required></textarea><br><br>

        <input type="submit" value="Les Annuleren">
    </form>
</body>
</html>
