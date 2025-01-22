<?php
// Databaseverbinding instellen
$host = '127.0.0.1';
$username = 'root';
$password = '';
$database = 'rfdw';

// Maak verbinding met de database
$db = mysqli_connect($host, $username, $password, $database)
or die('Error: ' . mysqli_connect_error());

// Initialiseer variabelen
$errors = [];
$type_appointments_id = '';
$vehicle_id = '';
$date = '';
$name = '';
$email = '';
$telephone = '';
$id = '';  // Nieuwe variabele voor het identificeren van de record die we willen updaten

require_once 'includes/security_check.php';

// Controleer of er een id is meegegeven in de URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Haal bestaande gegevens op
    $query = "SELECT * FROM reservation WHERE id = $id";
    $selectResult = mysqli_query($db, $query);
    if ($selectResult) {
        $reservation = mysqli_fetch_assoc($selectResult);
        if ($reservation) {
            $type_appointments_id = $reservation['type_appointments_id'];
            $vehicle_id = $reservation['vehicle_id'];
            $date = $reservation['date_of'];
            $start_time = $reservation['start_time'];
            $end_time = $reservation['end_time'];
            $name = $reservation['name'];
            $email = $reservation['email'];
            $telephone = $reservation['telephone'];
        } else {
            echo "Reservering niet gevonden.";
            exit;
        }
    } else {
        echo "Database Error: " . mysqli_error($db);
        exit;
    }
}

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
    if (empty($date)) {
        $errors['date_of'] = 'Datum moet worden ingevuld.';
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

    // Als er geen fouten zijn, werk de record bij in de database
    if (empty($errors)) {
        

        $query = "
            UPDATE reservation 
            SET type_appointments_id = '$type_appointments_id', vehicle_id = '$vehicle_id', date_of = '$date', start_time = '$start_time',end_time = '$end_time' ,name = '$name', email = '$email', telephone = '$telephone'
            WHERE id = $id
        ";

        $updateResult = mysqli_query($db, $query);
        if ($updateResult) {
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
    <title>Update reservering</title>
    <link rel="stylesheet" href="my-bulma-project.css">
</head>
<body>

<section class="head py-5 px-5 has-background-white">
    <div class="columns is-vcentered">
        <div class="column">
            <h1 class="title is-1 has-text-black has-text-weight-bold"> Verander Uw Reservering </h1>
            <p class="subtitle has-text-black mb-0 pt-4 pb-5"> Bijwerken van Details </p>
        </div>
        <div class="column is-narrow">
            <div class="image is-128x128">
                <img src="https://cdn.discordapp.com/attachments/890599228437594175/1331584701969727548/download.png?ex=67922664&is=6790d4e4&hm=90ac17f69c0b5db2a566134126b28c22bd4ae19d0cacbf3342e2faa57f2a5791&" alt="RFDW Logo">
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
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


            <div class="field">
                <label class="label" for="start_time">Op welke tijd?</label>
                <div class="control">
                    <input class="input" type="time" name="start_time" id="start_time"
                           value="<?= htmlentities($start_time) ?>" min="08:30" max="17:00">
                </div>
                <p class="help is-danger"><?= $errors['start_time'] ?? '' ?></p>
            </div>

            <div class="field">
                <label class="label" for="end_time">Op welke tijd?</label>
                <div class="control">
                    <input class="input" type="time" name="end_time" id="end_time"
                           value="<?= htmlentities($end_time) ?>" min="08:30" max="17:00">
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
<p class="px-5 pb-4"> R.F. De Wit Auto's © </p>
</body>
</html>
