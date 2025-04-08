<?php
include_once '../Database/db.php';
include_once 'mededeling.php';

$db = new Database();
$mededeling = new Mededeling($db->getConnection());

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bericht = $_POST['bericht'];

    $mededeling->voegZiekmeldingToe($bericht, 0); 

    $mededeling->voegZiekmeldingToe($bericht, 0); 

    $message = "Mededeling succesvol verzonden naar instructeurs en leerlingen.";
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mededeling - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Mededeling voor Instructeurs en Leerlingen</h1>

        <?php if (!empty($message)): ?>
            <div class="alert alert-success">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label for="bericht" class="form-label">Bericht:</label>
                <textarea class="form-control" id="bericht" name="bericht" rows="4" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Verstuur Mededeling</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
