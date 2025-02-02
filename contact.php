<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form inputs
    $name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '';
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '';
    $subject = isset($_POST['subject']) ? htmlspecialchars($_POST['subject']) : '';
    $message = isset($_POST['message']) ? htmlspecialchars($_POST['message']) : '';

    // Validate required fields
    if (!empty($name) && !empty($email) && !empty($message)) {
        // Prepare email content
        $to = 'chaimtahapary01gmail.com'; // Change this to your contact email address
        $email_subject = "Contactformulier: $subject";
        $email_body = "Naam: $name\nE-mail: $email\nTelefoonnummer: $phone\n\nBericht:\n$message";

        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";

        // Send the email
        if (mail($to, $email_subject, $email_body, $headers)) {
            $success_message = "Uw bericht is succesvol verzonden!";
        } else {
            $error_message = "Er was een fout bij het verzenden van uw bericht. Probeer het later opnieuw.";
        }
    } else {
        $error_message = "Vul alstublieft alle vereiste velden in.";
    }
}

?>

<!-- Display Success or Error Message -->
<?php if (!empty($success_message)): ?>
    <div class="notification is-success">
        <?= $success_message ?>
    </div>
<?php elseif (!empty($error_message)): ?>
    <div class="notification is-danger">
        <?= $error_message ?>
    </div>
<?php endif; ?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contact </title>
    <link rel="stylesheet" href="my-bulma-project.css">
</head>
<body>
<nav class="navbar" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="">
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
<br>
<form action="" method="POST">
    <div class="container">
        <div class="columns is-centered">

            <!-- Image on the Left Column -->
            <div class="column is-half-mobile is-one-third-tablet is-one-third-desktop is-flex is-justify-content-start is-align-items-center mr-6">
                <figure class="image is-4by3 is-fullwidth">
                    <img src="https://rfdewitautos.nl/wp-content/uploads/2020/03/RF-de-Wit-Autos-Krimpen-ad-Lek-aug19-1-1024x683.jpg"
                         alt="Car Image"/>
                </figure>
            </div>

            <!-- Form on the Right Column -->
            <div class="column is-full-mobile is-two-thirds-tablet is-two-thirds-desktop">
                <!-- Contact Information Header -->
                <div class="field">
                    <h2 class="title is-4 has-text-centered">Uw contactgegevens</h2>
                </div>

                <!-- Name Field -->
                <div class="field">
                    <label class="label is-small">Naam</label>
                    <p class="control has-icons-left">
                        <input class="input is-small" type="text" name="name" placeholder="Vul naam in" required>
                        <span class="icon is-small is-left">
                        <i class="fas fa-user"></i>
                    </span>
                    </p>
                </div>

                <!-- Email Field -->
                <div class="field">
                    <label class="label is-small">Email</label>
                    <p class="control has-icons-left has-icons-right">
                        <input class="input is-small" type="email" name="email" placeholder="Vul email in" required>
                        <span class="icon is-small is-left">
                        <i class="fas fa-envelope"></i>
                    </span>
                        <span class="icon is-small is-right">
                        <i class="fas fa-check"></i>
                    </span>
                    </p>
                </div>

                <!-- Phone Number Field -->
                <div class="field">
                    <label class="label is-small">Telefoonnummer</label>
                    <div class="field has-addons">
                        <p class="control">
                            <a class="button is-static is-small">+31</a>
                        </p>
                        <p class="control is-expanded">
                            <input class="input is-small" type="tel" name="phone" placeholder="Uw telefoonnummer">
                        </p>
                    </div>
                    <p class="help is-small">Begin met uw nummer</p>
                </div>

                <!-- Subject Field -->
                <div class="field">
                    <label class="label is-small">Onderwerp</label>
                    <div class="control">
                        <div class="select is-small is-fullwidth">
                            <select name="subject" required>
                                <option>Occasions</option>
                                <option>Werkplaats</option>
                                <option>Anders</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Question Field -->
                <div class="field">
                    <label class="label is-small">Vraag</label>
                    <div class="control">
                        <textarea class="textarea is-small" name="message" placeholder="Leg uit hoe wij u kunnen helpen"
                                  required></textarea>
                    </div>
                </div>

                <!-- Send Message Button -->
                <div class="field">
                    <div class="control">
                        <button class="button is-primary is-small">Verzenden</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</form>

<!--<footer>-->

<footer style="background-color: #f4f4f4; padding: 20px; margin-top: 40px;">
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
            <p class=" has-text-grey-darker">E: <a
                        href="mailto:RFdeWitautos@outlook.com">RFdeWitautos@outlook.com</a>
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
