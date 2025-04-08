<?php
include_once '../Database/db.php';
include_once 'Mededeling.php';

$db = new Database();
$mededeling = new Mededeling($db->getConnection());

$mededelingen = $mededeling->getMededelingenByRole('instructeur');
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mededelingen van Instructeurs</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">Mededelingen van Instructeurs</h1>

    <?php if (empty($mededelingen)): ?>
        <div class="alert alert-warning">
            Er zijn momenteel geen mededelingen van instructeurs beschikbaar.
        </div>
    <?php else: ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Bericht</th>
                    <th>Gebruiker ID</th>
                    <th>Aangemaakt op</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($mededelingen as $mededeling): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($mededeling['id']); ?></td>
                        <td><?php echo htmlspecialchars($mededeling['bericht']); ?></td>
                        <td><?php echo htmlspecialchars($mededeling['gebruiker_id']); ?></td>
                        <td><?php echo htmlspecialchars($mededeling['aangemaakt_op']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<!-- Bootstrap 5 JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
