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
    $date = mysqli_escape_string($db, $_POST['date_of'] ?? '');
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
            SET type_appointments_id = '$type_appointments_id', vehicle_id = '$vehicle_id', date_of = '$date', name = '$name', email = '$email', telephone = '$telephone'
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">
</head>
<body>

<!-- Je navbar en andere HTML-code blijft hetzelfde -->

<section class="section">
    <div class="container">
        <h1 class="title">Update reservering</h1>
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
                <label class="label" for="date">Op welke datum?</label>
                <div class="control">
                    <input class="input" type="datetime-local" name="date_of" id="date"
                           value="<?= htmlentities($date) ?>">
                </div>
                <p class="help is-danger"><?= $errors['date'] ?? '' ?></p>
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
                    <button class="button is-link" type="submit" name="submit">Opslaan</button>
                </div>
            </div>
        </form>
    </div>
</section>

</body>
</html>
