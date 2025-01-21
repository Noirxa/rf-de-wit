<?php
session_start(); // Start the session to access session variables

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

//$query = "SELECT id, type_appointments_id AS type_appointments.type_appointments.type, vehicle_id, date_of, name, email, telephone FROM reservation
//LEFT JOIN type_appointments
//ON reservation.type_appointments_id = type_appointments.type_appointments_id";

$result = mysqli_query($db, $query)
or die('Error ' . mysqli_error($db) . ' with query ' . $query);

$reservations = [];


while ($row = mysqli_fetch_assoc($result)) {
    $reservations[] = $row;
}

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
    <link rel="stylesheet" href="my-bulma-project.css">
</head>
<body>


<section class="head mx-5">
    <h1 class="is-size-2 has-text-white has-text-weight-bold"> Reservations </h1>
    <p> Welcome Back, <?php echo $full_name; ?> ! </p>

    <a href="create.php" class="button"> Create An Appointment </a>
    <a href="register.php" class="button"> Register New Mechanic </a>
    <a href=" " class="button"> Go To Contact Questions </a>
</section>

<section class="section">
    <table class="table is-bordered mx-auto">
        <thead>
        <tr>
            <th> Case ID</th>
            <th> Type of Appointment</th>
            <th> Vehicle in Question</th>
            <th> Date of Appointment</th>
            <th> Start Time</th>
            <th> End Time</th>
            <th> Name Client</th>
            <th> Email</th>
            <th> Phone Number</th>
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

                <td><a href="edit.php?id=<?php echo $res['id']; ?>"> Edit </a></td>
                <td><a href="delete.php?id=<?php echo $res['id']; ?>"> Delete </a></td>
<!--                <td><a href="indexayatest.php?id=--><?php //echo $res['id']; ?><!--"> yo </a></td>-->

            </tr>
        <?php } ?>
        </tbody>
    </table>
    <p> R.F. De Wit Auto's © </p>
</section>

</body>
</html>

