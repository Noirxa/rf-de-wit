<?php
//$ID= $_GET['id'];

$host = '127.0.0.1';
$username = 'root';
$password = '';
$database = 'rfdw';

// Maak verbinding met de database
$db = mysqli_connect($host, $username, $password, $database)
or die('Error: ' . mysqli_connect_error());

require_once 'includes/security_check.php';

$id = mysqli_escape_string($db, $_GET['id']);

// Query to get all albums
$query = "
SELECT 
    reservation.id, 
    type_appointments.type AS type_appointments_type, 
    type_vehicle.type AS type_vehicle_type, 
    reservation.date_of, 
    reservation.start_time, 
    reservation.end_time,
    reservation.name, 
    reservation.email, 
    reservation.telephone 
FROM 
    reservation 
LEFT JOIN 
    type_appointments 
ON 
    reservation.type_appointments_id = type_appointments.type_appointments_id
LEFT JOIN  
    type_vehicle
ON 
   reservation.vehicle_id = type_vehicle.vehicle_id
";

// Execute the query and store the result (table in $result)
$result = mysqli_query($db, $query) or die('Error ' . mysqli_error($db) . ' with query ' . $query);

// Create an empty array to store all albums
$products = mysqli_fetch_assoc($result);


mysqli_close($db);
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kdrama - Details </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">
</head>
<body>

<header class="hero is-info">
    <div class="hero-body">
        <p class="title">K-Drama</p>
        <p class="subtitle"><?= $products['name'] ?> </p>
    </div>
</header>

<main class="container">
    <section class="section content">
        <ul>
            <li>Name:<?= htmlentities($products['name']) ?></li>
            <li>Genre:<?= htmlentities($products['genre']) ?> </li>
            <li>Rating:<?=htmlentities( $products['rating']) ?></li>
            <li>Actors: <?= htmlentities($products['actor']) ?> </li>
        </ul>
        <a class="button" href="index.php">Go back to the list</a>
    </section>
</main>
</body>
</html>

