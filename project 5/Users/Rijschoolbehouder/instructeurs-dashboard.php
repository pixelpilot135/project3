<?php
include_once '../../Database/db.php';
include_once '../session.php';

$db = new Database();

$instructeurs = $db->selectAll("SELECT * FROM gebruikers WHERE rol = 'instructeur'");

if (isset($_POST['verwijderen'])) {
    $id = $_POST['IDv'];

    $updateAutosSql = "UPDATE autos SET toegewezen_aan = NULL WHERE toegewezen_aan = ?";
    $db->execute([$id], $updateAutosSql);

    $deleteMankementenSql = "DELETE FROM mankementen WHERE instructeur_id = ?";
    $db->execute([$id], $deleteMankementenSql);

    $sql = 'DELETE FROM gebruikers WHERE id = ? AND rol = "instructeur"';
    $db->execute([$id], $sql);
    header("Refresh:0");
}

if (isset($_POST['aanpassen'])) {
    $id = $_POST['instructeurId'];
    $gebruikersnaam = $_POST['gebruikersnaam'];
    $email = $_POST['email'];
    $geboortedatum = $_POST['geboortedatum'];
    $telefoon = $_POST['telefoon'];
    $stad = $_POST['stad'];

    $sql = 'UPDATE gebruikers SET gebruikersnaam = ?, email = ?, geboortedatum = ?, telefoon = ?, stad = ? WHERE id = ? AND rol = "instructeur"';
    $db->execute([$gebruikersnaam, $email, $geboortedatum, $telefoon, $stad, $id], $sql);
    header("Refresh:0");
}

if (isset($_POST['toevoegen'])) {
    $gebruikersnaam = $_POST['gebruikersnaam'];
    $wachtwoord = $_POST['wachtwoord'];
    $email = $_POST['email'];
    $geboortedatum = $_POST['geboortedatum'];
    $telefoon = $_POST['telefoon'];
    $stad = $_POST['stad'];
    $wachtwoordHash = password_hash($wachtwoord, PASSWORD_BCRYPT);

    $sql = "INSERT INTO gebruikers (gebruikersnaam, wachtwoord, email, rol, geboortedatum, telefoon, stad)
            VALUES (?, ?, ?, 'instructeur', ?, ?, ?)";
    $params = [$gebruikersnaam, $wachtwoordHash, $email, $geboortedatum, $telefoon, $stad];
    $db->execute($params, $sql);
    header("Refresh:0");
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Instructeurs Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h1 class="text-center mb-4">Instructeurs Dashboard</h1>

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Gebruikersnaam</th>
            <th>Email</th>
            <th>Telefoon</th>
            <th>Stad</th>
            <th>Geboortedatum</th>
            <th>Acties</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($instructeurs as $instructeur): ?>
            <tr>
                <td><?= $instructeur['id']; ?></td>
                <td><?= $instructeur['gebruikersnaam']; ?></td>
                <td><?= $instructeur['email']; ?></td>
                <td><?= $instructeur['telefoon']; ?></td>
                <td><?= $instructeur['stad']; ?></td>
                <td><?= $instructeur['geboortedatum']; ?></td>
                <td>
                    <div class="btn-group" role="group">
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="IDv" value="<?= $instructeur['id']; ?>">
                            <button type="submit" class="btn btn-danger btn-sm" name="verwijderen">Verwijder</button>
                        </form>

                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="IDv" value="<?= $instructeur['id']; ?>">
                            <button type="submit" class="btn btn-warning btn-sm" name="wijzigen">Wijzig</button>
                        </form>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <?php if (isset($_POST['wijzigen'])): ?>
        <form method="POST" class="bg-white p-4 rounded shadow-sm mb-4">
            <h2>Wijzig Instructeur</h2>
            <input type="hidden" name="instructeurId" value="<?= $_POST['IDv']; ?>">

            <div class="mb-3">
                <label for="gebruikersnaam" class="form-label">Gebruikersnaam</label>
                <input type="text" name="gebruikersnaam" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="geboortedatum" class="form-label">Geboortedatum</label>
                <input type="date" name="geboortedatum" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="telefoon" class="form-label">Telefoonnummer</label>
                <input type="tel" name="telefoon" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="stad" class="form-label">Stad</label>
                <input type="text" name="stad" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary" name="aanpassen">Opslaan</button>
        </form>
    <?php endif; ?>

    <form method="POST" class="bg-white p-4 rounded shadow-sm">
        <h2>Nieuwe Instructeur Toevoegen</h2>

        <div class="mb-3">
            <label for="gebruikersnaam" class="form-label">Gebruikersnaam</label>
            <input type="text" id="gebruikersnaam" name="gebruikersnaam" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="wachtwoord" class="form-label">Wachtwoord</label>
            <input type="password" id="wachtwoord" name="wachtwoord" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="geboortedatum" class="form-label">Geboortedatum</label>
            <input type="date" name="geboortedatum" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="telefoon" class="form-label">Telefoonnummer</label>
            <input type="tel" name="telefoon" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="stad" class="form-label">Stad</label>
            <input type="text" name="stad" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success" name="toevoegen">Voeg Instructeur toe</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
