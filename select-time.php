<?php
require_once "includes/connection.php";
/** @var mysqli $db */

$selectedTime = '';

if (isset($_POST['submit'])) {

    //Postback with the data showed to the user, first retrieve data from 'Super global'
    $name = mysqli_real_escape_string($db, $_POST['name']);
    $selectedTime = mysqli_real_escape_string($db, $_POST['time']);
    $date = mysqli_escape_string($db, $_POST['date']);
    $endTime = date('H:i', strtotime($selectedTime . ' 1hour'));

    //Require the form validation handling
    require_once "../includes/form-validation.php";

    if (empty($errors)) {
        //Save the record to the database
        $query = "INSERT INTO planning_system.reservations
                  (description, date, start_time, end_time)
                  VALUES ('$name', '$date', '$selectedTime', '$endTime')";
        $result = mysqli_query($db, $query)
        or die('Error: ' . mysqli_error($db) . 'QUERY: ' . $query);

        if ($result) {
            header('Location: index.php');
        } else {
            $errors[] = 'Something went wrong in your database query: ' . mysqli_error($db);
        }
    }
}

if (isset($_GET['date']) && !empty($_GET['date'])) {
    // Haal de datum op
    $date = mysqli_escape_string($db, $_GET['date']);

    // Haal de reserveringen uit de database voor een specifieke datum
    $query = "SELECT *
              FROM reservations
              WHERE date = '$date'";

    $result = mysqli_query($db, $query);

    if ($result) {
        $reservations = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $reservations[] = $row;
        }
    }
    // Maak een array met tijden van 09:00 - 17:00 met stappen van 30 minuten.
    $times = [];
    $time = strtotime('09:00');
    $timeToAdd = 30;

    // Blijf de times array vullen totdat 17:00 bereikt wordt.
    while ($time <= strtotime('17:00')) {
        // time toevoegen aan times array
        $times[] = date('H:i', $time);

        // time + een half uur optellen
        $time += 60 * $timeToAdd;
    }

    // Doorloop alle reserveringen en filter alle tijden die gelijk zijn
    // aan de tijd van een reservering t/m een uur later.
    // Zet alle overgebleven tijden in de array $availableTimes.
    $availableTimes = [];

    // doorloop alle tijden (van 9:00 - 17:00)
    foreach ($times as $time) {
        $time = strtotime($time);
        $occurs = false;
        // controleer de tijd tegen ALLE reserveringen van die dag
        foreach ($reservations as $reservation) {
            $startTime = strtotime($reservation['start_time']);
            $endTime = strtotime($reservation['end_time']);
            // ALS de tijd van de begintijd tot de eindtijd van
            // een reservering valt voeg deze tijd ($time) niet
            // toe aan availableTimes
            if ($time >= $startTime &&
                $time < $endTime) {
                $occurs = true;
            }
        }

        if (!$occurs) {
            $availableTimes[] = date('H:i', $time);
        }
    }
} else {
    header('Location: select-date.php');
}
?>
<!doctype html>
<html lang="en">
<head>
    <title>Nieuwe reservering - tijd</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
</head>
<body>
<section class="container content">
    <h1 class="title">Nieuwe reservering voor <?= date('j F Y', strtotime($date)) ?></h1>

    <form action="" method="post">

        <div class="field is-horizontal">
            <div class="field-label is-normal">
                <label class="label" for="name">Name afspraak</label>
            </div>
            <div class="field-body">
                <div class="field">
                    <div class="control">
                        <input class="input" id="name" type="text" name="name" value="<?= $name ?? '' ?>"/>
                    </div>
                    <p class="help is-danger">
                        <?= $errors['name'] ?? '' ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="field is-horizontal">
            <div class="field-label is-normal">
                <label for="time" class="label">Tijd</label>
            </div>
            <div class="field-body">
                <div class="field is-narrow">
                    <div class="control">
                        <div class="select is-fullwidth">
                            <select id="time" name="time">
                                <option value="" >Kies een tijd</option>
                                <?php foreach ($availableTimes as $availableTime) { ?>
                                    <option value="<?= $availableTime ?>" <?= $selectedTime == $availableTime ? 'selected' : '' ?>><?= $availableTime ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <p class="help is-danger">
                            <?= $errors['time'] ?? '' ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="date" value="<?= $date ?>"/>

        <div class="field is-horizontal">
            <div class="field-label">
                <!-- Left empty for spacing -->
            </div>
            <div class="field-body">
                <div class="field">
                    <div class="control">
                        <button class="button is-link" name="submit">
                            Afspraak maken
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>
</body>
</html>