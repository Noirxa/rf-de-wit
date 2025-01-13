<?php
require_once 'includes/security_check.php';

$id = $_GET['id'];
global $query;
$host = '127.0.0.1';
$username = 'root';
$password = '';
$database = 'kdrama_list';

// Make a connection to the database
$db = mysqli_connect($host, $username, $password, $database)
or die('Error:' . mysqli_connect_error());

$id = mysqli_escape_string($db, $_GET['id']);

$query = "SELECT * FROM kdrama_listt WHERE id= $id";
$result = mysqli_query($db, $query) or die('Error ' . mysqli_error($db) . ' with query ' . $query);

if ($result) {
    $kdramaListt= mysqli_fetch_assoc($result);
    $name = mysqli_escape_string ($db, $kdramaListt['name']);
    $genre = mysqli_escape_string ($db, $kdramaListt['genre']);
    $rating =  mysqli_escape_string ($db,$kdramaListt['rating']);

} else {
    echo "Fout bij het ophalen van gegevens.";
}

if (isset($_POST['submit'])) {
    /** @var mysqli $db */
//    require_once "includes/database.php";

    // Get form data
    $name =  mysqli_escape_string($db, $_POST['name']);
    $genre = mysqli_escape_string($db, $_POST['genre']);;
    $rating = isset($_POST['rating']) && is_numeric($_POST['rating'])
        ? mysqli_escape_string($db, $_POST['rating'])
        : ''; // Default to 0 if not numeric or not set


    // Server-side validation
    $errors = [];
    if ($name === '') {
        $errors['name'] = 'Name must be filled';
    }
    if ($genre === '') {
        $errors['genre'] = 'Genre must be filled';
    }
    if ($rating === '') {
        $errors['rating'] = 'Rating must be filled';
    }

    if (empty($errors)) {
        require_once('includes/connect.php');
        // store the new user in the database.
        $query = "UPDATE `kdrama_listt`
                SET `name`='$name', `genre`='$genre', `rating`= '$rating'
                WHERE id = $id ";
//        echo $query;
//     If query succeeded

        $result = mysqli_query($db, $query)
        or die('Error' . mysqli_error($db) . ' with query' . $query);
        // Redirect to login page

        mysqli_close($db);

        header( 'Location: index.php');
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">
    <title>Muziekalbums - Create</title>
</head>
<body>
<div class="container px-4">

    <section class="columns is-centered">
        <div class="column is-10">
            <h2 class="title mt-4">Edit Album</h2>

            <form class="column is-6" action="" method="post">

                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                        <label class="label" for="name">Name</label>
                    </div>
                    <div class="field-body">
                        <div class="field">
                            <div class="control">
                                <input class="input" id="name" type="text" name="name" value="<?= htmlentities($name ?? '' )?>"/>
                            </div>
                            <p class="help is-danger">
                                <?= $errors['name'] ?? '' ?>

                            </p>
                        </div>
                    </div>
                </div>
                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                        <label class="label" for="genre">Genre</label>
                    </div>
                    <div class="field-body">
                        <div class="field">
                            <div class="control">
                                <input class="input" id="genre" type="text" name="genre" value="<?= htmlentities($genre ?? '') ?>"/>
                            </div>
                            <p class="help is-danger">
                                <?= $errors['genre'] ?? '' ?>

                            </p>
                        </div>
                    </div>
                </div>
                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                        <label class="label" for="rating">Rating</label>
                    </div>
                    <div class="field-body">
                        <div class="field">
                            <div class="control">
                                <input class="input" id="rating" type="text" name="rating"
                                       value="<?= htmlentities($rating ?? '' )?>"/>
                            </div>
                            <p class="help is-danger">
                                <?= $errors['rating'] ?? '' ?>

                            </p>
                        </div>
                    </div>
                </div>


                <div class="field is-horizontal">
                    <div class="field-label is-normal"></div>
                    <div class="field-body">
                        <button class="button is-link is-fullwidth" type="submit" name="submit">Save</button>
                    </div>
                </div>
            </form>

            <a class="button mt-4" href="index.php">&laquo; Go back to the list</a>
        </div>
    </section>
</div>
</body>
</html>
