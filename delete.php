<?php

global $db;
require_once 'includes/connection.php';

$id = mysqli_escape_string($db, $_GET['id']);

$query = "SELECT * FROM reservation WHERE id = $id";

$selectedResult = mysqli_query($db, $query)
or die('Error ' . mysqli_error($db) . ' with query ' . $query);

$reservation = mysqli_fetch_assoc($selectedResult);

if (isset($_POST['submit'])) {
    $query = "DELETE FROM reservation WHERE id = '$id'";

    $updateResults = mysqli_query($db, $query)
    or die('Error ' . mysqli_error($db) . ' with query ' . $query);

    header('Location: Index.php');
    mysqli_close($db);
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">
    <title>Game completion - Delete</title>
</head>
<body>
<div class="container px-4">
    <h1 class="title mt-4">Are you sure you want to DELETE <?= htmlentities($reservation['']) ?> from your list?</h1>

    <section class="columns">

        <!--Toon de inhoud van het hidden field-->
        <form class="column is-6" action="" method="post">

            <input type="hidden" name="hidden" value="<?= htmlentities($reservation['id']) ?>"/>
            <input type="hidden" name="hidden" value="<?= htmlentities($reservation['type_appointments_type']) ?>"/>
            <input type="hidden" name="hidden" value="<?= htmlentities($reservation['vehicle_id']) ?>"/>
            <input type="hidden" name="hidden" value="<?= htmlentities($reservation['date_of']) ?>"/>
            <input type="hidden" name="hidden" value="<?= htmlentities($reservation['name']) ?>"/>
            <input type="hidden" name="hidden" value="<?= htmlentities($reservation['email']) ?>"/>
            <input type="hidden" name="hidden" value="<?= htmlentities($reservation['telephone']) ?>"/>


            <div class="field is-horizontal">
                <div class="field-label is-normal"></div>
                <div class="field-body">
                    <button class="button is-link is-fullwidth" type="submit" name="submit">Delete</button>
                </div>
            </div>
        </form>
    </section>
    <a class="button mt-4" href="index.php">&laquo; Terug naar albums</a>
</div>
</body>
</html>

