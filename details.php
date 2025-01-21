<?php
// Database connection
$host = '127.0.0.1';
$username = 'root';
$password = '';
$database = 'rfdw';

$db = mysqli_connect($host, $username, $password, $database)
or die('Error: ' . mysqli_connect_error());

require_once 'includes/connection.php';

$id = mysqli_escape_string($db, $_GET['id']);
$query = "SELECT * FROM reservation WHERE id = $id";

$result = mysqli_query($db, $query)
or die('Error ' . mysqli_error($db) . ' with query ' . $query);

$reservations = mysqli_fetch_assoc($result);

mysqli_close($db);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reservation Detail</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">
</head>
<body>

<header class="hero is-info">
    <div class="hero-body">
        <p class="title">Game completion</p>
        <p class="subtitle"> <?= $id ?>: <?= htmlentities($reservations['id']) ?></p>
    </div>
</header>

<main class="container">
    <section class="section content">
        <ul>
            <li>Genre: <?= htmlentities($games['genre']) ?></li>
            <li>Trophies: <?= htmlentities($games['trophies']) ?></li>
            <li>Time: <?= htmlentities($games['time']) ?>H</li>
            <li>Difficulty: <?= htmlentities($games['difficulty']) ?></li>
        </ul>
        <a class="button" href="index.php">Go back to the list</a>
    </section>

</body>
</html>
