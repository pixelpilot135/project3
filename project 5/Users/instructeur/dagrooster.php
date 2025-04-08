<?php

include_once '../../Database/db.php';

$db = new Database();

include_once '../session.php';

$date = date('Y-m-d');

//selecting todays lessons
$todaysLessons = $db->selectAll('SELECT id, leerling_id, instructeur_id, locatie, onderwerp, TIME(les_datum) as les_tijd FROM lessen WHERE DATE(les_datum) = CURDATE() ORDER BY les_datum ASC ');

$sqlToQueryName = 'SELECT gebruikersnaam FROM gebruikers WHERE id=?';

if ($todaysLessons) {
    try {
        $instructeur = $todaysLessons[0];
        $instructeur_id = $instructeur['instructeur_id'];
        $auto = $db->select([$instructeur_id], 'SELECT * FROM autos WHERE toegewezen_aan=? ');

    } catch (Exception $e) {

    }

}

if (isset($_POST['wijzigen'])) {
    $kilometerstand = $_POST['Kilometerstand'];
    $autoId = $_POST['autoId'];

    $params = array($kilometerstand, $autoId);

    $sql = 'UPDATE autos SET kilometerstand = ? WHERE id = ?';

    $db->execute($params, $sql);
    header("Refresh:0");


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
    <h1>DAGROOSTER</h1>



    <table>

        <thead>
            <th>Tijd</th>
            <th>Naam</th>
            <th>Onderwerp</th>
            <th>Ophaal locatie</th>
        </thead>

        <tbody>

            <?php foreach ($todaysLessons as $todayLesson) { ?>
                <td><?php echo $todayLesson['les_tijd']; ?> </td>
                <td><?php
                $leerling_id = $todayLesson['leerling_id'];
                $result = $db->select([$leerling_id], $sqlToQueryName);
                echo $result['gebruikersnaam']; ?> </td>
                <td><?php echo $todayLesson['onderwerp']; ?></td>
                <td><?php echo $todayLesson['locatie']; ?></td>

            </tbody>
        <?php } ?>
    </table>

    <h2> Auto</h2>

    <table>
        <thead>

            <th>Id</th>
            <th>Merk</th>
            <th>Kenteken</th>
            <th>Kilometerstand</th>
        </thead>
        <tbody>
            <td><?php echo $auto['id'] ?></td>
            <td><?php echo $auto['merk'] ?></td>
            <td><?php echo $auto['kenteken'] ?></td>
            <form method="POST">
                <input type="text" name="autoId" value="<?php echo $auto['id'] ?>" hidden>

                <td><input type="text" value="<?php echo $auto['kilometerstand'] ?>" name="Kilometerstand"></td>

                <td><button type="submit" name="wijzigen">Wijzig</button></td>
            </form>

        </tbody>

    </table>

</body>

</html>