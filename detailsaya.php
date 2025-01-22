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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">
</head>
<body>

<section class="head py-5 px-5 has-background-white">
    <div class="columns is-vcentered">
        <div class="column">
            <h1 class="title is-1 has-text-black has-text-weight-bold"> Details </h1>
            <p class="subtitle has-text-black mb-0 pt-4 pb-5"> Alle Informatie Voor Uw Gekozen Afspraak </p>
        </div>
        <div class="column is-narrow">
            <div class="image is-128x128">
                <img src="https://cdn.discordapp.com/attachments/890599228437594175/1331584701969727548/download.png?ex=67922664&is=6790d4e4&hm=90ac17f69c0b5db2a566134126b28c22bd4ae19d0cacbf3342e2faa57f2a5791&" alt="RFDW Logo">
            </div>
        </div>
    </div>
</section>

<main class="container">
    <section class="section content pb-0">
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
        <a class="button" href="index.php">Terug Naar De Afspraken</a>
        <p class="px-3 pt-4"> R.F. De Wit Auto's © </p>
    </section>
</main>
</body>
</html>

