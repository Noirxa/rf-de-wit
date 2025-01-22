<?php
// Database connection
$host = '127.0.0.1';
$username = 'root';
$password = '';
$database = 'rfdw';

// Make a connection to the database
$db = mysqli_connect($host, $username, $password, $database)
or die('Error:' . mysqli_connect_error());

// Check if 'id' is present in the URL
if (isset($_GET['id']) && $_GET['id'] !== '') {
    $id = mysqli_escape_string($db, $_GET['id']);

    // Get the reservation details before deleting
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
    WHERE id = $id";
    $result = mysqli_query($db, $query);

    if (mysqli_num_rows($result) > 0) {
        $reservation = mysqli_fetch_assoc($result);
    } else {
        echo 'Reservering niet gevonden.';
        exit;
    }
} else {
    echo 'Geen reservering geselecteerd om te verwijderen.';
    exit;
}

// Handle the delete confirmation
if (isset($_POST['confirm_delete'])) {
    $query = "DELETE FROM reservation WHERE id = $id";
    $deleteResult = mysqli_query($db, $query);

    if ($deleteResult) {
        header('Location: index.php');
        exit;
    } else {
        echo 'Fout bij het verwijderen van de reservering: ' . mysqli_error($db);
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Verwijder Reservering</title>
    <link rel="stylesheet" href="my-bulma-project.css">
</head>
<body>

<section class="head py-5 px-5 has-background-white">
    <div class="columns is-vcentered">
        <div class="column">
            <h1 class="title is-1 has-text-black has-text-weight-bold"> Verwijderen </h1>
            <p class="subtitle has-text-black mb-0 pt-4 pb-5"> Weet U Het Zeker? </p>

        </div>
        <div class="column is-narrow">
            <div class="image is-128x128">
                <img src="https://cdn.discordapp.com/attachments/890599228437594175/1331584701969727548/download.png?ex=67922664&is=6790d4e4&hm=90ac17f69c0b5db2a566134126b28c22bd4ae19d0cacbf3342e2faa57f2a5791&" alt="RFDW Logo">
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">

        <!-- Show reservation details to the user -->
        <div>
            <p class="pb-1"><strong> Type Afspraak:</strong> <?= htmlentities($reservation['type_appointments_type']) ?></p>
            <p class="pb-1"><strong> Soort Voertuig:</strong> <?= htmlentities($reservation['type_vehicle_type']) ?></p>
            <p class="pb-1"><strong> Datum van Afspraak :</strong> <?= htmlentities($reservation['date_of']) ?></p>
            <p class="pb-1"><strong> Start Tijd:</strong> <?= htmlentities($reservation['start_time']) ?></p>
            <p class="pb-1"><strong> Eind Tijd:</strong> <?= htmlentities($reservation['end_time']) ?></p>
            <p class="pb-1"><strong> Client Naam:</strong> <?= htmlentities($reservation['name']) ?></p>
            <p class="pb-1"><strong>Email:</strong> <?= htmlentities($reservation['email']) ?></p>
            <p class="pb-5"><strong> Telefoon Nummer:</strong> <?= htmlentities($reservation['telephone']) ?></p>

            <!-- Confirmation Form -->
            <form method="post" action="">
                <button class="button is-link" type="submit" name="confirm_delete">Ja, verwijder</button>
                <a class="button is-light" href="index.php">Annuleren</a>
            </form>
        </div>
    </div>
    <p class="pl-6 pt-4"> R.F. De Wit Auto's © </p>
</section>

</body>
</html>
