<?php
$host       = '127.0.0.1';
$username   = 'root';
$password   = '';
$database   = 'rfdw';

$db = mysqli_connect($host, $username, $password, $database)
or die('Error: '.mysqli_connect_error());

$query = "SELECT * FROM reservation
LEFT JOIN type_appointments
ON reservation.type_appointments_id = type_appointments.id";

$result = mysqli_query($db, $query)
or die('Error '.mysqli_error($db).' with query '.$query);

$reservations = [];


while($row = mysqli_fetch_assoc($result))
{
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
</head>
<body>

<section class="head">
    <h1> Reservations </h1>
    <p> Welcome back, [USER]. </p>
</section>

<section class="section">
    <table class="table mx-auto">
        <thead>
        <tr>
            <th> Case ID </th>
            <th> Type of Appointment </th>
            <th> Vehicle in Question </th>
            <th> Date of Appointment </th>
            <th> Name Client </th>
            <th> Email </th>
            <th> Phone Number </th>
        </thead>
        <tfoot>
        <tr>
            <td colspan="6"> </td>
        </tr>
        </tfoot>
        <tbody>
        <?php foreach ($reservations as $index => $res) { ?>
            <tr>
                <th> <?php echo $res ['id'] ?> </th>
                <th> <?php echo $res ['type_appointments_id'] ?> </th>
                <th> <?php echo $res ['vehicle_id'] ?> </th>
                <th> <?php echo $res ['date'] ?> </th>
                <th> <?php echo $res ['name'] ?> </th>
                <th> <?php echo $res ['email'] ?> </th>
                <th> <?php echo $res['telephone'] ?> </th>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</section>

</body>
</html>

