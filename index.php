<?php
require_once 'includes/connection.php';

$host = '127.0.0.1';
$username = 'root';
$password = '';
$database = 'rfdw';

// Maak verbinding met de database
$db = mysqli_connect($host, $username, $password, $database)
or die('Error: ' . mysqli_connect_error());
//require_once 'includes/security_check.php';

if (isset($_POST['submit'])) {
    $type_appointments_id =  mysqli_escape_string ($db,isset($_POST['actor_id']) && is_numeric($_POST['actor_id']) ? $_POST['actor_id'] : null);
    $vehicle_id =  mysqli_escape_string ($db,isset($_POST['vehicle_id']) && is_numeric($_POST['vehicle_id']) ? $_POST['vehicle_id'] : null);
    $date = mysqli_escape_string ($db, $_POST['date'] ?? '');
    $name = mysqli_escape_string ($db, $_POST['name'] ?? '');
    $email = mysqli_escape_string ($db, $_POST['email'] ?? '');
    $telephone = mysqli_escape_string ($db, is_numeric($_POST['telephone']) ? $_POST['telephone'] : '');


    // Server-side validatie
    $errors = [];
    if ($type_appointments_id === null) {
        $errors['type_appointments_id'] = 'You must select a valid actor';
    }
    if ($vehicle_id === '') {
        $errors['vehicle_id'] = 'vehicle must be filled';
    }
    if ($date === '') {
        $errors['date'] = 'Date must be filled';
    }
    if ($name === '') {
        $errors['name'] = 'Name must be filled';
    }

    if ($email === '') {
        $errors['email'] = 'Email must be filled';
    }
    if ($telephone === '') {
        $errors['telephone'] = 'Telephone must be filled';
    }


    if (empty($errors)) {
        // Invoegen in de database
        $query = "
            INSERT INTO rfdw (`type_appointments_id`, vehicle_id, date, name,email, telephone)
            VALUES ('$type_appointments_id, '$vehicle_id', $date, '$name', '$email','$telephone')
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

<!--Navbar-->
<!DOCTYPE html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>create</title>
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


<!--&lt;!&ndash; Actor veld &ndash;&gt;-->
<!--<section class="column-gap has-text-centered ">-->
<!--    <div class=" column ">-->

<!--        <div class=" column has-text-centered has-text-white">-->
<!--        <h1 class="title">Reservatie</h1>-->

<!--            <br>-->
<!--</div>-->
<!--<div class="control columns">-->
<!--    <p class="mb-4 is-size-5 column">Wat wilt u reserveren?</p>-->
<!--    <div class="select ">-->
<!--        <select>-->
<!--            <option>Select dropdown</option>-->
<!--            <option>APK keuring</option>-->
<!--            <option>Ruitschade</option>-->
<!--            <option>Airco onderhoud</option>-->
<!---->
<!--        </select>-->
<!---->
<!--    </div>-->

<!--</div>-->
<!---->
<!--</div>-->

<!--</section>-->
<section class=" section">
    <div class="field container is-one-third">
        <label class="label" for="type_appointments_id" >Wat wilt u reserveren?</label>
        <div class="control container">
            <div class="select ">
                <select name="type_appointments_id" id="type_appointments_id">

                    <option>Select dropdown</option>
                    <option value="2" <?= htmlentities(isset($type_appointments_id) && $type_appointments_id == 2 ? 'selected' : '') ?>> APK keuring </option>
                    <option value="2" <?= htmlentities(isset($type_appointments_id) && $type_appointments_id == 2 ? 'selected' : '') ?>> Ruitschade </option>
                    <option value="2" <?= htmlentities(isset($type_appointments_id) && $type_appointments_id == 2 ? 'selected' : '') ?>> Airco onderhoud </option>
                    <option value="2" <?= htmlentities(isset($type_appointments_id) && $type_appointments_id == 2 ? 'selected' : '') ?>> Reparatie </option>

                </select>

            </div>
            <p class="help is-danger"><?= $errors['type_appointments_id'] ?? '' ?></p>
        </div>

            </div>

    <div class="field is-horizontal">
        <div class="field-label is-normal">
            <label class="label" for="vehicle_id">Welke type voertuig?</label>
        </div>
        <div class="field-body">
            <div class="field">
                <div class="control">
                    <select name="vehicle_id" id="actor_id">
                        <option value="">Selecteer</option>
                        <option value="2" <?= htmlentities(isset($vehicle_id) && $vehicle_id == 2 ? 'selected' : '') ?>> Auto</option>
                        <option value="3" <?= htmlentities(isset($vehicle_id) && $vehicle_id == 3 ? 'selected' : '' )?>>Motor</option>
                    </select>
                </div>
                <p class="help is-danger"><?= $errors['vehicle_id'] ?? '' ?></p>
            </div>
        </div>
    </div>
        <br>




    <div class="field container is-one-third">
        <label class="label">Op welke datum?</label>
        <div class="control">
            <input class="input" type="datetime-local" placeholder="Text input">
        </div>
    </div>

    <div class="field container is-one-third">
        <h1> <strong> Gegevens </strong</h1>
        <label class="label">Naam</label>
        <div class="control">
            <input class="input" type="text" placeholder="Layla">
        </div>
    </div>
    <div class="field container is-one-third">
        <label class="label">Email</label>
        <div class="control">
            <input class="input" type="email" placeholder="123@gmail.com">
        </div>
    </div>
    <div class="field container is-one-third">
        <label class="label">Telefoonnummer</label>
        <div class="control">
            <input class="input" type="number" placeholder="+31 6 123 456 890">
        </div>
    </div>


    <br>

    <div class="field container">
        <div class="control">
            <label class="checkbox">
                <input type="checkbox">
                I agree to the <a href="#">terms and conditions</a>
            </label>
        </div>
    </div>

    <br>
<!--    Opslaan knop -->-->
<!--    <div class="field is-horizontal">-->
<!--        <div class="field-label is-normal"></div>-->
<!--        <div class="field-body">-->
<!--            <button class="button is-link is-fullwidth" type="submit" name="submit">Save</button>-->
<!--        </div>-->
<!--    </div>-->

    <  <!-- Opslaan knop -->
    <div class="field is-horizontal">
        <div class="field-label is-normal"></div>
        <div class="field-body">
            <button class="button is-link is-fullwidth" type="submit" name="submit">Save</button>
        </div>
    </div>

    <a class="button mt-4" href="loll.php">&laquo; Go back to the list</a>

</body>
</html>
