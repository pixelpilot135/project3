<?php
include_once '../../Database/db.php';
include_once '../session.php';

$db = new Database();

ini_set('display_errors', 0);
$autos = $db->selectAll('SELECT * FROM autos');
$instructeurs = $db->selectAll("SELECT rol, gebruikersnaam, id FROM gebruikers WHERE rol='instructeur'");

if (isset($_POST['verwijderen'])) {
    $id = $_POST['IDv'];
    $sql = 'DELETE FROM autos WHERE id=?';
    $db->execute([$id], $sql);
    header("Refresh:0");
}

if (isset($_POST['aanpassen'])) {
    $id = $_POST['autoId'];
    $status = $_POST['status'];
    $toegewezen_aan = $_POST['toegewezen_aan'];
    $params = array($status, $toegewezen_aan, $id);
    $sql = 'UPDATE autos SET status = ?, toegewezen_aan = ? WHERE id = ?';
    $db->execute($params, $sql);
    header("Refresh:0");
}

if (isset($_POST['voeg_auto_toe'])) {
    $merk = $_POST['merk'];
    $model = $_POST['model'];
    $kenteken = $_POST['kenteken'];
    $kilometerstand = $_POST['kilometerstand'];
    $status = $_POST['status'];
    $sql = "INSERT INTO autos (merk, model, kenteken, status, kilometerstand, toegewezen_aan, aangemaakt_op) 
            VALUES (?, ?, ?, ?, ?, NULL, NOW())";
    $params = array($merk, $model, $kenteken, $status, $kilometerstand);
    $db->execute($params, $sql);
    header("Refresh:0");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">

        <h1 class="text-center mb-4">Overzicht Wagenpark</h1>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Merk</th>
                    <th>Model</th>
                    <th>Kenteken</th>
                    <th>Status</th>
                    <th>Kilometerstand</th>
                    <th>Toegewezen aan</th>
                    <th>Aangemaakt op</th>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($autos as $auto): ?>
                    <tr>
                        <td><?= $auto['id']; ?></td>
                        <td><?= $auto['merk']; ?></td>
                        <td><?= $auto['model']; ?></td>
                        <td><?= $auto['kenteken']; ?></td>
                        <td><?= $auto['status']; ?></td>
                        <td><?= $auto['kilometerstand']; ?></td>
                        <td><?= $auto['toegewezen_aan']; ?></td>
                        <td><?= $auto['aangemaakt_op']; ?></td>
                        <td>
                            <div class="btn-group" role="group">
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="IDv" value="<?= $auto['id']; ?>">
                                    <button type="submit" class="btn btn-danger" name="verwijderen">Verwijder</button>
                                </form>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="IDv" value="<?= $auto['id']; ?>">
                                    <button type="submit" class="btn btn-warning" name="wijzigen">Wijzig</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php if (isset($_POST['wijzigen'])): ?>
            <form action="wagenparkOverzicht.php" method="POST" class="bg-white p-4 rounded shadow-sm">
                <h2>Wijzig Auto</h2>
                <div class="mb-3">
                    <label for="autoId" class="form-label">Auto ID:</label>
                    <input type="text" name="autoId" class="form-control" readonly value="<?= $_POST['IDv']; ?>">
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status:</label>
                    <select name="status" id="status" class="form-select">
                        <option value="Beschikbaar">Beschikbaar</option>
                        <option value="Onderhoud">Onderhoud</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="toegewezen_aan" class="form-label">Toewijzen aan:</label>
                    <select name="toegewezen_aan" id="toegewezen_aan" class="form-select">
                        <option value="" selected disabled hidden>Niemand</option>
                        <?php foreach ($instructeurs as $instructeur): ?>
                            <option value="<?= $instructeur['id']; ?>"><?= $instructeur['gebruikersnaam']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary" name="aanpassen">Aanpassen</button>
            </form>
        <?php endif; ?>

        <form action="wagenparkOverzicht.php" method="POST" class="bg-white p-4 rounded shadow-sm mt-4">
            <h2>Nieuwe Auto Toevoegen</h2>
            <div class="mb-3">
                <label for="merk" class="form-label">Merk:</label>
                <input type="text" name="merk" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="model" class="form-label">Model:</label>
                <input type="text" name="model" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="kenteken" class="form-label">Kenteken:</label>
                <input type="text" name="kenteken" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="kilometerstand" class="form-label">Kilometerstand:</label>
                <input type="number" name="kilometerstand" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status:</label>
                <select name="status" class="form-select" required>
                    <option value="Beschikbaar">Beschikbaar</option>
                    <option value="Onderhoud">Onderhoud</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success" name="voeg_auto_toe">Voeg Auto Toe</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
