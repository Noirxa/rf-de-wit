<?php
//$ID = $_GET['id'];
require_once 'includes/connection.php';
if(isset($_POST['submit'])) {
    /** @var mysqli $db */
//    require_once "includes/database.php";

    // Get form data
    $firstName=mysqli_escape_string ($db, $_POST['firstName']);
    $lastName=mysqli_escape_string ($db, $_POST['lastName']);
    $email=mysqli_escape_string ($db, $_POST['email']);
    $password=mysqli_escape_string ($db, $_POST['password']);



    // Server-side validation
    $errors=[];
    if ($firstName===''){
        $errors['firstName']= 'first name must be filled';
    }
    if ($lastName ===''){
        $errors['lastName']= 'Last name must be filled';
    }
    if ($email===''){
        $errors['email']= 'Email must be filled';
    }
    if ($password===''){
        $errors['password']= 'Password must be filled';
    }


    // If data valid
    if (empty($errors)){
        $hashedPassword=  password_hash($password,PASSWORD_DEFAULT);
//      echo $hashedPassword;
    }
    // create a secure password, with the PHP function password_hash()


    // store the new user in the database.
    $query= "
        INSERT INTO users (first_name,last_name,email,password)
        VALUES ('$firstName','$lastName','$email','$hashedPassword')
        ";
    echo $query;
    // If query succeeded
    $result = mysqli_query($db, $query);
    // Redirect to login page
    if ($result){
        header(header:'Location: index.php');
        // Exit the code
        exit;

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
        <link rel="stylesheet" href="my-bulma-project.css">
        <title>Registreren</title>
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
            <h2 class="title">Register With Email</h2>

            <section class="columns">
                <form class="column is-6" action="" method="post">

                    <!-- First name -->
                    <div class="field is-horizontal">
                        <div class="field-label is-normal">
                            <label class="label" for="firstName">First name</label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <div class="control has-icons-left">
                                    <input class="input" id="firstName" type="text" name="firstName" value="<?= htmlentities($name ?? '') ?>" />
                                    <span class="icon is-small is-left"><i class="fas fa-envelope"></i></span>
                                </div>
                                <p class="help is-danger">
                                    <?= $errors['firstName'] ?? '' ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Last name -->
                    <div class="field is-horizontal">
                        <div class="field-label is-normal">
                            <label class="label" for="lastName">Last name</label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <div class="control has-icons-left">
                                    <input class="input" id="lastName" type="text" name="lastName" value="<?=htmlentities( $lastName ?? '') ?>" />
                                    <span class="icon is-small is-left"><i class="fas fa-envelope"></i></span>
                                </div>
                                <p class="help is-danger">
                                    <?= $errors['lastName'] ?? '' ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="field is-horizontal">
                        <div class="field-label is-normal">
                            <label class="label" for="email">Email</label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <div class="control has-icons-left">
                                    <input class="input" id="email" type="text" name="email" value="<?= $email ?? '' ?>" />
                                    <span class="icon is-small is-left"><i class="fas fa-envelope"></i></span>
                                </div>
                                <p class="help is-danger">
                                    <?= $errors['email'] ?? '' ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="field is-horizontal">
                        <div class="field-label is-normal">
                            <label class="label" for="password">Password</label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <div class="control has-icons-left">
                                    <input class="input" id="password" type="password" name="password"/>
                                    <span class="icon is-small is-left"><i class="fas fa-lock"></i></span>
                                </div>
                                <p class="help is-danger">
                                    <?= $errors['password'] ?? '' ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="field is-horizontal">
                        <div class="field-label is-normal"></div>
                        <div class="field-body">
                            <button class="button is-link is-fullwidth" type="submit" name="submit">Register</button>
                        </div>
                    </div>

                </form>

                <div class=" m-4 pl-6">
<!--                    <br>-->
                    <img src="https://rfdewitautos.nl/wp-content/uploads/2022/04/occasions-home.jpg" alt="bedrijf"   width="450vw">
                </div>
            </section>

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
    </body>
    </html>
<?php
