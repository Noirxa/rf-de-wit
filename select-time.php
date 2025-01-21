<?php
require_once "includes/connection.php";
/** @var mysqli $db */

$start_time = '';

if (isset($_POST['submit'])) {

    //Postback with the data showed to the user, first retrieve data from 'Super global'
    $type_appointments_id = isset($_POST['type_appointments_id']) && is_numeric($_POST['type_appointments_id']) ? $_POST['type_appointments_id'] : null;
    $vehicle_id = isset($_POST['vehicle_id']) && is_numeric($_POST['vehicle_id']) ? $_POST['vehicle_id'] : null;
    $date_of = mysqli_escape_string($db, $_POST['date_of']);
    $start_time = mysqli_real_escape_string($db, $_POST['time']);
    $end_time = date('H:i', strtotime($start_time . ' 30minutes'));
    $name = mysqli_real_escape_string($db, $_POST['name'] ?? '');
    $email = mysqli_escape_string($db, $_POST['email'] ?? '');
    $telephone = mysqli_escape_string($db, is_numeric($_POST['telephone']) ? $_POST['telephone'] : '');

    //Require the form validation handling
//    require_once "../includes/form-validation.php";

    if (empty($errors)) {
        //Save the record to the database
        $query = "INSERT INTO reservation
                  (type_appointments_id, vehicle_id ,date_of, start_time, end_time,name,email,telephone)
                  VALUES ('$type_appointments_id', '$vehicle_id','$date_of', '$start_time', '$end_time', '$name', '$email', '$telephone')";
        print_r($query);
        $result = mysqli_query($db, $query)
        or die('Error: ' . mysqli_error($db) . 'QUERY: ' . $query);

        if ($result) {
            header('Location: index.php');
            exit;
        } else {
            $errors[] = 'Something went wrong in your database query: ' . mysqli_error($db);
        }
    }
}

if (!empty($_GET['date_of'])) {



    // Haal de datum op
    $date_of = mysqli_escape_string($db, $_GET['date_of']);

    // Haal de reserveringen uit de database voor een specifieke datum
    $query = "SELECT *
              FROM reservation
              WHERE date_of = '$date_of'";

    $result = mysqli_query($db, $query);

    if ($result) {
        $reservations = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $reservations[] = $row;
        }
    }
    // Maak een array met tijden van 09:00 - 17:00 met stappen van 30 minuten.
    $times = [];
    $time = strtotime('08:30');
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
        foreach ($reservations as $res) {
            $startTime = strtotime($res['start_time']);
            $endTime = strtotime($res['end_time']);
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
    <link rel="stylesheet" href="my-bulma-project.css">
</head>
<body>

<nav class="navbar" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="index.php">
            <figure class="image is-150x150px">
                <img src="https://rfdewitautos.nl/wp-content/uploads/2018/11/RF-de-wit-autos-logo.png" alt="logo" />
            </figure>
        </a>

        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>

    <div id="navbarBasicExample" class="navbar-menu">
        <div class="navbar-start">
            <a class="navbar-item">
                Home
            </a>
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">
                    Ocassions
                </a>

                <div class="navbar-dropdown">
                    <a class="navbar-item">
                        Auto leasen
                    </a>
                    <a class="navbar-item">
                        Auto kopen
                    </a>
                    <a class="navbar-item">
                        Contact
                    </a>
                    <hr class="navbar-divider">
                    <a class="navbar-item">
                        Meld een probleem
                    </a>
                </div>
            </div>

            <a class="navbar-item">
                Werkplaats
            </a>
            <a class="navbar-item">
                Reserveren
            </a>
            <a class="navbar-item">
                Contact
            </a>

        </div>

        <div class="navbar-end">
            <div class="navbar-item">
                <div class="buttons">
                    <a class="button is-primary">
                        <strong>+31 6 421 28724</strong>
                    </a>

                </div>
            </div>
        </div>
    </div>

</nav>




<section class="section  ">
    <div class="container content">
        <h1 class="title">Nieuwe reservering voor <?= date('j F Y', strtotime($date_of ?? '')) ?></h1>
        <form method="post" action="">
            <div class="field">
                <label class="label" for="type_appointments_id">Wat wilt u reserveren?</label>
                <div class="control">
                    <div class="select">
                        <select name="type_appointments_id" id="type_appointments_id">
                            <option value="">Selecteer een optie</option>
                            <option value="1" <?= isset($type_appointments_id) && $type_appointments_id == 1 ? 'selected' : '' ?>>APK keuring</option>
                            <option value="2" <?= isset($type_appointments_id) && $type_appointments_id == 2 ? 'selected' : '' ?>>Ruitschade</option>
                            <option value="3" <?= isset($type_appointments_id) && $type_appointments_id == 3 ? 'selected' : '' ?>>Airco onderhoud</option>
                        </select>
                    </div>
                    <p class="help is-danger"><?= $errors['type_appointments_id'] ?? '' ?></p>
                </div>
            </div>



            <div class="field">
                <label class="label" for="vehicle_id">Welk type voertuig?</label>
                <div class="control">
                    <div class="select">
                        <select name="vehicle_id" id="vehicle_id">
                            <option value="">Selecteer een voertuig</option>
                            <option value="1" <?= isset($vehicle_id) && $vehicle_id == 1 ? 'selected' : '' ?>>Auto</option>
                            <option value="2" <?= isset($vehicle_id) && $vehicle_id == 2 ? 'selected' : '' ?>>Motor</option>
                        </select>
                    </div>
                    <p class="help is-danger"><?= $errors['vehicle_id'] ?? '' ?></p>
                </div>
            </div>


            <div class="field is-horizontal">
                <div class="field-label">
                    <!-- Left empty for spacing -->
                </div>

            </div>



            <!--            <div class="field">-->
            <!--                <label class="label" for="date_of">Op welke datum?</label>-->
            <!--                <div class="control">-->
            <!--                    <input class="input" type="datetime-local" name="date_of" id="date_of" value="--><?php //= htmlentities($date_of) ?><!--">-->
            <!--                </div>-->
            <!--                <p class="help is-danger">--><?php //= $errors['date_of'] ?? '' ?><!--</p>-->
            <!--            </div>-->


            <div class="field">
                <label class="label" for="name">Naam</label>
                <div class="control">
                    <input class="input" type="text" name="name" id="name" value="<?= htmlentities($name ?? '') ?>" placeholder="Uw naam">
                </div>
                <p class="help is-danger"><?= $errors['name'] ?? '' ?></p>
            </div>

            <div class="field">
                <label class="label" for="email">E-mail</label>
                <div class="control">
                    <input class="input" type="email" name="email" id="email" value="<?= htmlentities($email ?? '') ?>" placeholder="Uw e-mail">
                </div>
                <p class="help is-danger"><?= $errors['email'] ?? '' ?></p>
            </div>

            <div class="field">
                <label class="label" for="telephone">Telefoonnummer</label>
                <div class="control">
                    <input class="input" type="tel" name="telephone" id="telephone" value="<?= htmlentities($telephone ?? '') ?>" placeholder="Uw telefoonnummer">
                </div>
                <p class="help is-danger"><?= $errors['telephone'] ?? '' ?></p>
            </div>


            <section class="container content">
                <form action="" method="POST">


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
                                                <option value="<?= $availableTime ?>" <?= $start_time == $availableTime ? 'selected' : '' ?>><?= $availableTime ?></option>
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

                    <input type="hidden" name="date_of" value="<?= $date_of ?>"/>

                    <div class="field-body">
                <div class="field">
                    <div class="control">
                        <button class="button is-link" name="submit">
                            Afspraak maken
                        </button>
                    </div>
                </div>
            </div>

        </form>
    </div>
</section>
<!--<footer>-->




<footer style="background-color: #f4f4f4; padding: 20px;">
    <div style="display: flex; justify-content: space-between; flex-wrap: wrap; max-width: 1200px; margin: auto;">
        <!--      <h1> <strong>contact</strong>Contact</h1>-->
        <div style="flex: 1; min-width: 250px;">
            <h2 class="has-text-black is-size-5	">Contact</h2>
            <br>
            <p class=" has-text-grey-darker	">R.F. de Wit Auto's<br>Buitenweg 12<br>2931AC Krimpen aan de Lek</p>
            <p><img src="https://www.abk-kunststoffen.nl/uploads/imagemanager/rdw_erkend_breed.jpg" alt="RDW Erkend" style="height: 40px; margin-top: 10px;"></p>

        </div>

        <div style="flex: 1; min-width: 250px;">
            <br>
            <br>
            <p  class=" has-text-grey-darker">M: 0642128724</p>
            <p  class=" has-text-grey-darker">E: <a href="mailto:RFdeWitautos@outlook.com">RFdeWitautos@outlook.com</a></p>
        </div>


        <div style="flex: 1; min-width: 250px;">
            <h2 class="has-text-black is-size-5	">Openingstijden</h2>
            <br>
            <ul style="list-style: none; padding: 0;" class=" has-text-grey-darker">
                <li>Maandag: 8:30 - 17:30</li>
                <li>Dinsdag: 8:30 - 17:30</li>
                <li>Woensdag: 8:30 - 17:30</li>
                <li>Donderdag: 8:30 - 17:30</li>
                <li>Vrijdag: 8:30 - 17:30</li>
                <li>Zaterdag: 10:00 - 15:00</li>
                <li>Zondag: Gesloten</li>
            </ul>
        </div>

        <div style="flex: 1; min-width: 250px;">
            <h2 class="has-text-black is-size-5	">Onze socials</h2>
            <p>
                <br>
                <a href="https://www.facebook.com/rfdewitautos/" style="text-decoration: none;">
                    <img src="https://z-m-static.xx.fbcdn.net/rsrc.php/v4/yD/r/5D8s-GsHJlJ.png" alt="Facebook" style="height: 30px;">
                </a>
        </div>
    </div>
</footer>

    </form>
</section>
</body>
</html>