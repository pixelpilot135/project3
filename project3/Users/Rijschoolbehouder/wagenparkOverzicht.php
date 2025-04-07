<?php
include_once '../../Database/db.php';

$db = new database();


include_once '../session.php';


$autos = $db->selectAll('Select * from autos');


if (isset($_POST['verwijderen'])) {
    $id = $_POST['IDv'];

    $sql = 'DELETE FROM autos WHERE id=?';

    $db->execute([$id], $sql);
}

?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <H1>Overzicht Wagenpark</H1>

    <table>
        <thead>
            <th>Merk</th>
            <th>Model</th>
            <th>Kenteken</th>
            <th>Status</th>
            <th>Kilometerstand</th>
            <th>Toegewezen aan</th>
            <th>Aangemaakt op</th>
            <th>Wijzigen</th>
            <th>Verwijderen</th>
            <th>Wijs instructeur aan</th>
        </thead>

        <tbody>
            <?php foreach ($autos as $auto) { ?>
                <td><?php echo $auto['merk']; ?></td>
                <td><?php echo $auto['model']; ?></td>
                <td><?php echo $auto['kenteken']; ?></td>
                <td><?php echo $auto['status']; ?></td>
                <td><?php echo $auto['kilometerstand']; ?></td>
                <td><?php echo $auto['toegewezen_aan']; ?></td>
                <td><?php echo $auto['aangemaakt_op']; ?></td>
                <td>
                    <form method="POST">
                        <input type="text" name="IDv" value="<?php echo $auto['id']; ?>" hidden>
                        <input type="submit" value="wijzig" name="wijzigen" id="wijzigen">
                    </form>
                </td>
                <td>
                    <form method="POST">
                        <input type="text" name="IDv" value="<?php echo $auto['id']; ?>" hidden>
                        <input type="submit" value="Verwijder" name="verwijderen" id="verwijderen">
                    </form>


                </td>
                <td><button>Kies</button></td>


            </tbody>

        <?php } ?>

    </table>


    <form method="POST" hidden>
                <input type="">

    </form>

</body>

</html>