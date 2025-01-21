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
    $query = "SELECT * FROM reservation WHERE id = $id";
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
<section class="section">
    <div class="container">
        <h1 class="title">Verwijder Reservering</h1>

        <!-- Show reservation details to the user -->
        <div class="box">
            <h2 class="subtitle">Weet je zeker dat je deze reservering wilt verwijderen?</h2>
            <p><strong>Naam:</strong> <?= htmlentities($reservation['name']) ?></p>
            <p><strong>E-mail:</strong> <?= htmlentities($reservation['email']) ?></p>
            <p><strong>Telefoonnummer:</strong> <?= htmlentities($reservation['telephone']) ?></p>
            <p><strong>Reserveringsdatum:</strong> <?= htmlentities($reservation['date_of']) ?></p>
            <p><strong>Starttijd:</strong> <?= htmlentities($reservation['start_time']) ?></p>
            <p><strong>Eindtijd:</strong> <?= htmlentities($reservation['end_time']) ?></p>
            <p><strong>Voertuig ID:</strong> <?= htmlentities($reservation['vehicle_id']) ?></p>

            <!-- Confirmation Form -->
            <form method="post" action="">
                <button class="button is-danger" type="submit" name="confirm_delete">Ja, verwijder</button>
                <a class="button is-light" href="index.php">Annuleren</a>
            </form>
        </div>
    </div>
</section>
</body>
</html>
