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

    <section class="head py-5 px-5 has-background-white">
    <div class="columns is-vcentered">
        <div class="column">
            <h1 class="title is-1 has-text-black has-text-weight-bold"> Nieuwe Admin Toevoegen </h1>
            <p class="subtitle has-text-black mb-0 pt-4 pb-5"> Tool Voor Nieuwe Collega's </p>
        </div>
        <div class="column is-narrow">
            <div class="image is-128x128">
                <img src="https://cdn.discordapp.com/attachments/890599228437594175/1331584701969727548/download.png?ex=67922664&is=6790d4e4&hm=90ac17f69c0b5db2a566134126b28c22bd4ae19d0cacbf3342e2faa57f2a5791&" alt="RFDW Logo">
            </div>
        </div>
    </div>
    </section>

    <section class="section">
        <div class="container content">

            <section class="columns">
                <form class="column is-6" action="" method="post">

                    <!-- First name -->
                    <div class="field is-horizontal">
                        <div class="field-label is-normal">
                            <label class="label" for="firstName">Voornaam</label>
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
                            <label class="label" for="lastName">Achternaam</label>
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
                            <label class="label" for="password">Wachtwoord</label>
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
                            <button class="button is-link is-fullwidth" type="submit" name="submit">Registreer</button>
                        </div>
                    </div>

                </form>

                <div class=" m-4 pl-6">
<!--                    <br>-->
                    <img src="https://rfdewitautos.nl/wp-content/uploads/2022/04/occasions-home.jpg" alt="bedrijf"   width="450vw">
                </div>
            </section>
            <p> R.F. De Wit Auto's © </p>
        </div>
    </section>
    </body>
    </html>
<?php
