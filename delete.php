<?php

//$ID = $_GET['id'];
global $query;
$host = '127.0.0.1';
$username = 'root';
$password = '';
$database = 'rfdw';

// Make a connection to the database
$db = mysqli_connect($host, $username, $password, $database)
or die('Error:' . mysqli_connect_error());

//require_once 'includes/security_check.php';

// ALS id aanwezig in de url
if (isset ($_GET['id']) && $_GET['id'] !== '') {
    $id = mysqli_escape_string($db, $_GET['id']);

//    $id = $_GET['id'];

// create query
    $query = "DELETE FROM reservation WHERE id = $id";

// id ophalen en opslaan

    $result = mysqli_query($db, $query);

    if ($result) {
        header('Location: index.php');
        exit;
    }
}


?>

<!--<!doctype html>-->
<!--<html lang="en">-->
<!--<head>-->
<!--    <meta charset="UTF-8">-->
<!--    <meta name="viewport"-->
<!--          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">-->
<!--    <meta http-equiv="X-UA-Compatible" content="ie=edge">-->
<!--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">-->
<!--    <title>Game completion - Delete</title>-->
<!--</head>-->
<!--<body>-->
<!--<div class="container px-4">-->
<!--    <h1 class="title mt-4">Are you sure you want to DELETE --><?php //= htmlentities($res['id']) ?>
<!--        from your list?</h1>-->
<!---->
<!--    <section class="columns">-->
<!---->
<!--        <!--Toon de inhoud van het hidden field-->-->
<!--        <form class="column is-6" action="" method="post">-->
<!---->
<!--            <input type="hidden" name="hidden" value="--><?php //= htmlentities($res['id']) ?><!--"/>-->
<!--            <input type="hidden" name="hidden" value="--><?php //= htmlentities($res['type_appointments_type']) ?><!--"/>-->
<!--            <input type="hidden" name="hidden" value="--><?php //= htmlentities($res['vehicle_id']) ?><!--"/>-->
<!--            <input type="hidden" name="hidden" value="--><?php //= htmlentities($res['date_of']) ?><!--"/>-->
<!--            <input type="hidden" name="hidden" value="--><?php //= htmlentities($res['name']) ?><!--"/>-->
<!--            <input type="hidden" name="hidden" value="--><?php //= htmlentities($res['email']) ?><!--"/>-->
<!--            <input type="hidden" name="hidden" value="--><?php //= htmlentities($res['telephone']) ?><!--"/>-->
<!---->
<!---->
<!--            <div class="field is-horizontal">-->
<!--                <div class="field-label is-normal"></div>-->
<!--                <div class="field-body">-->
<!--                    <button class="button is-link is-fullwidth" type="submit" name="submit">Delete</button>-->
<!--                </div>-->
<!--            </div>-->
<!--        </form>-->
<!--    </section>-->
<!--    <a class="button mt-4" href="index.php">&laquo; Terug naar albums</a>-->
<!--</div>-->
<!--</body>-->
<!--</html>-->
<!---->
