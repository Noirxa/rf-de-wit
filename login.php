<?php
require_once('includes/connection.php');

// required when working with sessions
session_start();

$login = false;
// Is user logged in?

if (isset($_POST['submit'])) {

    // Get form data
    /** @var $db mysqli */
    $email = mysqli_escape_string($db, $_POST['email']);
    $password = $_POST['password'];

    // Server-side validation
    $errors = [];

    if ($password == '') {
        $errors['password'] = 'Please fill in a password';
    }
    if ($email == '') {
        $errors['email'] = 'Email cannot be empty';
    }

    // If data valid
    if (empty($errors)) {
        echo 'no errors';
        // SELECT the user from the database, based on the email address.
        $query = "SELECT * FROM users WHERE email = '$email'";

        /** @var $db mysqli */
        $result = mysqli_query($db, $query)
        or die('Error ' . mysqli_error($db) . ' with query ' . $query);
        print_r(mysqli_num_rows($result));
//        exit;
        // check if the user exists
        if (mysqli_num_rows($result) == 1) {

            // Get user data from result
            $user = mysqli_fetch_assoc($result);

            // Check if the provided password matches the stored password in the database
            if (password_verify($password, $user['password'])) {
                echo 'password correct';
//                exit;

                // Store the user in the session
                $_SESSION['user'] = $email;

                // Redirect to secure page
                header('Location: index.php');
                exit();
            } else {
                // Credentials not valid
                $errors['loginFailed'] = 'Username/password incorrect';
            }
            //error incorrect log in
        } else {
            // User doesn't exist
            $errors['loginFailed'] = 'Username/password incorrect';
        }
        //error incorrect log in

    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">
    <link rel="stylesheet" href="css/style.css">

    <title>Log in</title>
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


<section class="section">
    <div class="container content">
        <h2 class="title has-text-centered">Log in</h2>

        <?php if ($login) { ?>
            <div class="notification is-success is-light">
                <p>Je bent succesvol ingelogd!</p>
                <p class="mt-2">
                    <a class="button is-link is-light" href="logout.php">Uitloggen</a>
                    <a class="button is-primary is-light" href="secure.php">Naar secure page</a>
                </p>
            </div>
        <?php } else { ?>

            <div class="columns is-centered">
                <div class="column is-half">
                    <form action="" method="post" class="box">

                        <div class="field">
                            <label class="label" for="email">Email</label>
                            <div class="control has-icons-left">
                                <input class="input <?= isset($errors['email']) ? 'is-danger' : '' ?>"
                                       id="email" type="text" name="email"
                                       value="<?= htmlentities($email ?? '') ?>" placeholder="Voer je email in">
                                <span class="icon is-small is-left"><i class="fas fa-envelope"></i></span>
                            </div>
                            <?php if (isset($errors['email'])): ?>
                                <p class="help is-danger"><?= $errors['email'] ?></p>
                            <?php endif; ?>
                        </div>

                        <div class="field">
                            <label class="label" for="password">Wachtwoord</label>
                            <div class="control has-icons-left">
                                <input class="input <?= isset($errors['password']) ? 'is-danger' : '' ?>"
                                       id="password" type="password" name="password"
                                       placeholder="Voer je wachtwoord in">
                                <span class="icon is-small is-left"><i class="fas fa-lock"></i></span>
                            </div>
                            <?php if (isset($errors['password'])): ?>
                                <p class="help is-danger"><?= $errors['password'] ?></p>
                            <?php endif; ?>

                            <?php if (isset($errors['loginFailed'])): ?>
                                <div class="notification is-danger is-light mt-2">
                                    <button class="delete"></button>
                                    <?= $errors['loginFailed'] ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="field">
                            <div class="control">
                                <button class="button is-info is-fullwidth has-text-white"
                                        type="submit" name="submit">Log in met Email</button>
                            </div>
                        </div>

                        <div class="has-text-centered mt-4">
                            <a class="button is-light" href="index.php">&laquo; Terug naar de lijst</a>
                        </div>
                    </form>
                </div>
            </div>

        <?php } ?>
    </div>
</section>


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
</html>