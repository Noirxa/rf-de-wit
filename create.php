<?php
// Databaseverbinding instellen
$host = '127.0.0.1';
$username = 'root';
$password = '';
$database = 'rfdw';

// Maak verbinding met de database
$db = mysqli_connect($host, $username, $password, $database)
or die('Error: ' . mysqli_connect_error());

//require_once 'includes/security_check.php';

// Initialiseer variabelen
$errors = [];
$type_appointments_id = '';
$vehicle_id = '';
$date_of = '';
$name = '';
$email = '';
$telephone = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Haal gegevens op en valideer invoer
    $type_appointments_id = isset($_POST['type_appointments_id']) && is_numeric($_POST['type_appointments_id']) ? $_POST['type_appointments_id'] : null;
    $vehicle_id = isset($_POST['vehicle_id']) && is_numeric($_POST['vehicle_id']) ? $_POST['vehicle_id'] : null;
    $date_of = mysqli_escape_string($db, $_POST['date_of'] ?? '');
    $start_time = mysqli_escape_string($db, $_POST['start_time'] ?? '');
    $end_time = mysqli_escape_string($db, $_POST['end_time'] ?? '');
    $name = mysqli_escape_string($db, $_POST['name'] ?? '');
    $email = mysqli_escape_string($db, $_POST['email'] ?? '');
    $telephone = mysqli_escape_string($db, is_numeric($_POST['telephone']) ? $_POST['telephone'] : '');


    // Validatie van velden
    if (empty($type_appointments_id)) {
        $errors['type_appointments_id'] = 'Je moet een geldig type reservering kiezen.';
    }
    if (empty($vehicle_id)) {
        $errors['vehicle_id'] = 'Je moet een type voertuig selecteren.';
    }
    if (empty($date_of)) {
        $errors['date'] = 'Datum moet worden ingevuld.';
    }

    if (empty($start_time)) {
        $errors['start_time'] = 'starttijd moet worden ingevuld.';
    }

    if (empty($end_time)) {
        $errors['end_time'] = 'Eindtijd moet worden ingevuld.';
    }
    if (empty($name)) {
        $errors['name'] = 'Naam moet worden ingevuld.';
    }
    if (empty($email)) {
        $errors['email'] = 'E-mail moet worden ingevuld.';
    }
    if (empty($telephone)) {
        $errors['telephone'] = 'Telefoonnummer moet worden ingevuld.';
    }

    // Als er geen fouten zijn, voeg toe aan database
    if (empty($errors)) {
        $query = "
            INSERT INTO reservation (`type_appointments_id`, `vehicle_id`, `date_of`, `start_time`, `end_time`,`name`, `email`, `telephone`)
            VALUES ('$type_appointments_id', '$vehicle_id', '$date_of','$start_time','$end_time','$name', '$email', '$telephone'  )
        ";
        $result = mysqli_query($db, $query);

        if ($result) {
            header('Location: index.php');
            exit;
        } else {
            echo "Database Error: " . mysqli_error($db);
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Maak een reservering</title>
    <link rel="stylesheet" href="my-bulma-project.css">
</head>
<body>

<nav class="navbar" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="index.php">
            <figure class="image is-150x150px">
                <img src="https://rfdewitautos.nl/wp-content/uploads/2018/11/RF-de-wit-autos-logo.png" alt="logo"/>
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


<section class="section">
    <div class="container">
        <h1 class="title">Maak een reservering</h1>
        <form method="post" action="">
            <div class="field">
                <label class="label" for="type_appointments_id">Wat wilt u reserveren?</label>
                <div class="control">
                    <div class="select">
                        <select name="type_appointments_id" id="type_appointments_id">
                            <option value="">Selecteer een optie</option>
                            <option value="1" <?= isset($type_appointments_id) && $type_appointments_id == 1 ? 'selected' : '' ?>>
                                APK keuring
                            </option>
                            <option value="2" <?= isset($type_appointments_id) && $type_appointments_id == 2 ? 'selected' : '' ?>>
                                Ruitschade
                            </option>
                            <option value="3" <?= isset($type_appointments_id) && $type_appointments_id == 3 ? 'selected' : '' ?>>
                                Airco onderhoud
                            </option>
                        </select>
                    </div>
                    <p class="help is-danger"><?= $errors['type_appointments_id'] ?? '' ?></p>
                </div>
            </div>

            <!--            date-->

            <div class="field">
                <label class="label" for="date">Op welke datum?</label>
                <div class="control">
                    <input class="input" type="date" name="date_of" id="date_of"
                           value="<?= htmlentities($date_of) ?>">
                    <a href="select-date.php" class="button is-link">Nieuwe reservering</a>

                </div>
                <p class="help is-danger"><?= $errors['date_of'] ?? '' ?></p>
            </div>

            <div class="field">
                <label class="label" for="start_time">Op welke tijd?</label>
                <div class="control">
                    <input class="input" type="time" name="start_time" id="start_time"
                           value="<?= htmlentities($start_time) ?>">
                </div>
                <p class="help is-danger"><?= $errors['start_time'] ?? '' ?></p>
            </div>

            <div class="field">
                <label class="label" for="end_time">Op welke tijd?</label>
                <div class="control">
                    <input class="input" type="time" name="end_time" id="end_time"
                           value="<?= htmlentities($end_time) ?>">
                </div>
                <p class="help is-danger"><?= $errors['end_time'] ?? '' ?></p>
            </div>


            <div class="field">
                <label class="label" for="vehicle_id">Welk type voertuig?</label>
                <div class="control">
                    <div class="select">
                        <select name="vehicle_id" id="vehicle_id">
                            <option value="">Selecteer een voertuig</option>
                            <option value="1" <?= isset($vehicle_id) && $vehicle_id == 1 ? 'selected' : '' ?>>Auto
                            </option>
                            <option value="2" <?= isset($vehicle_id) && $vehicle_id == 2 ? 'selected' : '' ?>>Motor
                            </option>
                        </select>
                    </div>
                    <p class="help is-danger"><?= $errors['vehicle_id'] ?? '' ?></p>
                </div>
            </div>


            <!--            <div class="field">-->
            <!--                <label class="label" for="date_of">Op welke datum?</label>-->
            <!--                <div class="control">-->
            <!--                    <input class="input" type="datetime-local" name="date_of" id="date_of" value="-->
            <?php //= htmlentities($date_of) ?><!--">-->
            <!--                </div>-->
            <!--                <p class="help is-danger">--><?php //= $errors['date_of'] ?? '' ?><!--</p>-->
            <!--            </div>-->


            <div class="field">
                <label class="label" for="name">Naam</label>
                <div class="control">
                    <input class="input" type="text" name="name" id="name" value="<?= htmlentities($name) ?>"
                           placeholder="Uw naam">
                </div>
                <p class="help is-danger"><?= $errors['name'] ?? '' ?></p>
            </div>

            <div class="field">
                <label class="label" for="email">E-mail</label>
                <div class="control">
                    <input class="input" type="email" name="email" id="email" value="<?= htmlentities($email) ?>"
                           placeholder="Uw e-mail">
                </div>
                <p class="help is-danger"><?= $errors['email'] ?? '' ?></p>
            </div>

            <div class="field">
                <label class="label" for="telephone">Telefoonnummer</label>
                <div class="control">
                    <input class="input" type="tel" name="telephone" id="telephone"
                           value="<?= htmlentities($telephone) ?>" placeholder="Uw telefoonnummer">
                </div>
                <p class="help is-danger"><?= $errors['telephone'] ?? '' ?></p>
            </div>

            <div class="field">
                <div class="control">
                    <button class="button is-link" type="submit">Opslaan</button>
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
            <p><img src="https://www.abk-kunststoffen.nl/uploads/imagemanager/rdw_erkend_breed.jpg" alt="RDW Erkend"
                    style="height: 40px; margin-top: 10px;"></p>

        </div>

        <div style="flex: 1; min-width: 250px;">
            <br>
            <br>
            <p class=" has-text-grey-darker">M: 0642128724</p>
            <p class=" has-text-grey-darker">E: <a href="mailto:RFdeWitautos@outlook.com">RFdeWitautos@outlook.com</a>
            </p>
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
                    <img src="https://z-m-static.xx.fbcdn.net/rsrc.php/v4/yD/r/5D8s-GsHJlJ.png" alt="Facebook"
                         style="height: 30px;">
                </a>
        </div>
    </div>
</footer>

</body>
</html>
