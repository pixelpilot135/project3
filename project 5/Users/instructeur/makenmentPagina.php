<?php
include_once '../../Database/db.php';
include_once 'mankement.php';

$db = new Database();
$mededeling = new Mankement($db->getConnection());

$message = "";

$query = "SELECT id, merk, model FROM autos WHERE status = 'beschikbaar'";
$stmt = $db->getConnection()->prepare($query);
$stmt->execute();
$autos = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auto_id = $_POST['auto_id'];
    $beschrijving = $_POST['beschrijving'];
    $instructeur_id = 7;
    $mededeling->meldMankement($auto_id, $instructeur_id, $beschrijving);
    $message = "Mankement succesvol gemeld.";
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mankementen Melden</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Meld een Mankement aan een Auto</h1>

        <?php if (!empty($message)): ?>
            <div class="alert alert-success">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label for="auto_id" class="form-label">Auto:</label>
                <select class="form-control" id="auto_id" name="auto_id" required>
                    <option value="">Selecteer een auto</option>
                    <?php foreach ($autos as $auto): ?>
                        <option value="<?php echo $auto['id']; ?>"><?php echo $auto['merk'] . ' ' . $auto['model']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="beschrijving" class="form-label">Beschrijving van het mankement:</label>
                <textarea class="form-control" id="beschrijving" name="beschrijving" rows="4" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Meld Mankement</button>
        </form>
    </div>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>

</html>
