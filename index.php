<?php
session_start();

$host = '127.0.0.1';
$username = 'root';
$password = '';
$database = 'rfdw';

$db = mysqli_connect($host, $username, $password, $database)
or die('Error: ' . mysqli_connect_error());

//LOG IN MESSAGE

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}
require_once('includes/connection.php');

$email = $_SESSION['user'];

$user_query = "SELECT first_name, last_name FROM users WHERE email = '$email'";

$user_result = mysqli_query($db, $user_query);

if ($user_result && mysqli_num_rows($user_result) == 1) {
    $user = mysqli_fetch_assoc($user_result);

    if (isset($user['first_name']) && isset($user['last_name'])) {
        $full_name = $user['first_name'] . ' ' . $user['last_name'];
    } else {
        $full_name = "Error: Full name not available.";
    }
} else {
    $full_name = "Error: User not found.";
}

mysqli_free_result($user_result);

//END OF BLOCK

$filter_date = isset($_GET['date']) ? $_GET['date'] : '';

// FILTERED OR NOT FILTERED
if (!empty($filter_date)) {
    $filter_query = "
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
    WHERE reservation.date_of = '" . mysqli_real_escape_string($db, $filter_date) . "'
    ";
    $result = mysqli_query($db, $filter_query)
    or die('Error ' . mysqli_error($db) . ' with query ' . $filter_query);
} else {
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
    $result = mysqli_query($db, $query)
    or die('Error ' . mysqli_error($db) . ' with query ' . $query);
}

$reservations = [];

while ($row = mysqli_fetch_assoc($result)) {
    $reservations[] = $row;
}

mysqli_free_result($result);

mysqli_close($db);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>RF de Wit Auto's Index</title>
    <link rel="stylesheet" type="text/css" href="my-bulma-project.css">
</head>
<body>


<section class="head py-5 px-5 has-background-white">
    <div class="columns is-vcentered">
        <div class="column">
            <h1 class="title is-1 has-text-black has-text-weight-bold"> Afspraken </h1>
            <p class="subtitle has-text-black mb-0 pt-4 pb-5"> Welkom Terug, <?php echo $full_name; ?> ! </p>

            <a href="select-date.php" class="button is-link"> Afspraak Aanmaken </a>
            <a href="register.php" class="button is-link"> Nieuwe Admin Toevoegen </a>
            <a href="contact.php" class="button is-link"> Contact Vragen Inzien </a>
        </div>
        <div class="column is-narrow">
            <div class="image is-128x128">
                <img src="https://cdn.discordapp.com/attachments/890599228437594175/1331584701969727548/download.png?ex=67922664&is=6790d4e4&hm=90ac17f69c0b5db2a566134126b28c22bd4ae19d0cacbf3342e2faa57f2a5791&" alt="RFDW Logo">
            </div>
        </div>
    </div>
</section>

<section class="section">
    <form method="get">
        <div class="field">
            <label class="label" for="date">Filter op Datum:</label>
            <div class="control">
                <input class="input" type="date" name="date" id="date" value="<?= htmlspecialchars($filter_date) ?>">
            </div>
        </div>
        <button class="button" type="submit">Filter</button>
    </form>
</section>

<section class="section py-2 px-6">
    <table class="table is-bordered">
        <thead>
        <tr>
            <th> Zaak ID</th>
            <th> Type Afspraak </th>
            <th> Soort Voertuig </th>
            <th> Datum van Afspraak</th>
            <th> Start Tijd </th>
            <th> Eind Tijd </th>
            <th> Client Naam </th>
            <th> Email</th>
            <th> Telefoon Nummer </th>
        </thead>
        <tfoot>
        <tr>
        </tr>
        </tfoot>
        <tbody>
        <?php foreach ($reservations as $index => $res) { ?>
            <tr>
                <th> <?php echo $res ['id'] ?> </th>
                <th> <?php echo $res ['type_appointments_type'] ?> </th>
                <th> <?php echo $res ['type_vehicle_type'] ?> </th>
                <th> <?php echo $res ['date_of'] ?> </th>
                <th> <?php echo $res ['start_time'] ?> </th>
                <th> <?php echo $res ['end_time'] ?> </th>
                <th> <?php echo $res ['name'] ?> </th>
                <th> <?php echo $res ['email'] ?> </th>
                <th> <?php echo $res ['telephone'] ?> </th>

                <td> <a href="detailsaya.php?id=<?php echo $res['id']; ?>"> Details </a></td>
                <td><a href="edit.php?id=<?php echo $res['id']; ?>"> Bewerken </a></td>
                <td><a href="delete.php?id=<?php echo $res['id']; ?>"> Verwijderen </a></td>


            </tr>
        <?php } ?>
        </tbody>
    </table>
</section>

<section class="section">
<a href="logout.php" class="button"> Log Uit </a>
    <br>
    <p class="pt-4"> R.F. De Wit Auto's © </p>
</section>

</body>
</html>

