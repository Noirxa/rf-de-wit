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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Haal gegevens op en valideer invoer
    $type_appointments_id = isset($_POST['type_appointments_id']) && is_numeric($_POST['type_appointments_id']) ? $_POST['type_appointments_id'] : null;
    $vehicle_id = isset($_POST['vehicle_id']) && is_numeric($_POST['vehicle_id']) ? $_POST['vehicle_id'] : null;
    $date = mysqli_escape_string($db, $_POST['date'] ?? '');
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
        $errors['date'] = 'Datum moet worden ingevuld.';
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
            INSERT INTO reservation (`type_appointments_id`, `vehicle_id`, `date`, `name`, `email`, `telephone`)
            VALUES ('$type_appointments_id', '$vehicle_id', '$date', '$name', '$email', '$telephone')
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">
</head>
<body>

<nav class="navbar" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="">
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

            <div class="field">
                <label class="label" for="date">Op welke datum?</label>
                <div class="control">
                    <input class="input" type="datetime-local" name="date" id="date" value="<?= htmlentities($date) ?>">
                </div>
                <p class="help is-danger"><?= $errors['date'] ?? '' ?></p>
            </div>

            <div class="field">
                <label class="label" for="name">Naam</label>
                <div class="control">
                    <input class="input" type="text" name="name" id="name" value="<?= htmlentities($name) ?>" placeholder="Uw naam">
                </div>
                <p class="help is-danger"><?= $errors['name'] ?? '' ?></p>
            </div>

            <div class="field">
                <label class="label" for="email">E-mail</label>
                <div class="control">
                    <input class="input" type="email" name="email" id="email" value="<?= htmlentities($email) ?>" placeholder="Uw e-mail">
                </div>
                <p class="help is-danger"><?= $errors['email'] ?? '' ?></p>
            </div>

            <div class="field">
                <label class="label" for="telephone">Telefoonnummer</label>
                <div class="control">
                    <input class="input" type="tel" name="telephone" id="telephone" value="<?= htmlentities($telephone) ?>" placeholder="Uw telefoonnummer">
                </div>
                <p class="help is-danger"><?= $errors['telephone'] ?? '' ?></p>
            </div>

            <div class="field">
                <div class="control">
                    <button class="button is-link" type="submit">Opslaan</button>
                </div>
            </div>
</body>
</html>
