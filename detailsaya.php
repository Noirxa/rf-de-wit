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
WHERE reservation.id = $id
";

// Execute the query and store the result (table in $result)
$result = mysqli_query($db, $query) or die('Error ' . mysqli_error($db) . ' with query ' . $query);

// Create an empty array to store all albums
$res = mysqli_fetch_assoc($result);


mysqli_close($db);
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Details </title>
    <link rel="stylesheet" href="my-bulma-project.css">
</head>
<body>

<header class="hero is-info">
    <div class="hero-body">
        <p class="title">Details</p>
        <p class="subtitle"><?= $res['name'] ?> </p>
    </div>
</header>

<main class="container">
    <section class="section content">
        <ul>
            
            <li><?= htmlspecialchars($res['type_appointments_type']) ?></li>
            <li><?= htmlspecialchars($res['type_vehicle_type']) ?></li>
            <li><?= htmlspecialchars($res['date_of']) ?></li>
            <li><?= htmlspecialchars($res['start_time']) ?></li>
            <li><?= htmlspecialchars($res['end_time']) ?></li>
            <li><?= htmlspecialchars($res['name']) ?></li>
            <li><?= htmlspecialchars($res['email']) ?></li>
            <li><?= htmlspecialchars($res['telephone']) ?></li>
        </ul>
        <a class="button" href="index.php">Go back to the list</a>
    </section>
</main>
</body>
</html>

