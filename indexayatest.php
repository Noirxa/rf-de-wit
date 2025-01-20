<?php
$host = '127.0.0.1';
$username = 'root';
$password = '';
$database = 'rfdw';

$db = mysqli_connect($host, $username, $password, $database)
or die('Error: ' . mysqli_connect_error());

// Ophalen van de filterwaarde (datum) via GET
$filter_date = isset($_GET['date']) ? $_GET['date'] : '';

// Basissql-query
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

// Filter toevoegen aan de query als een datum is opgegeven
if (!empty($filter_date)) {
    $query .= " WHERE reservation.date_of = '" . mysqli_real_escape_string($db, $filter_date) . "'";
}

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
          content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>RF de Wit Auto's Index</title>
    <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css"
    >
</head>
<body>
<section class="head mx-5">
    <h1 class="is-size-2 has-text-white has-text-weight-bold"> Reservations </h1>
    <p> Welcome back, [USER]. </p>

    <a href="create.php" class="button"> Create An Appointment </a>
    <a href="register.php" class="button"> Register New Mechanic </a>
    <a href=" " class="button"> Go To Contact Questions </a>
</section>

<section class="section">
    <!-- Filter Form -->
    <form method="get" class="mb-5">
        <div class="field">
            <label class="label" for="date">Filter by Date:</label>
            <div class="control">
                <input class="input" type="date" name="date" id="date" value="<?= htmlspecialchars($filter_date) ?>">
            </div>
        </div>
        <button class="button is-primary" type="submit">Filter</button>
    </form>

    <!-- Tabel met resultaten -->
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
            <th> Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($reservations)): ?>
            <?php foreach ($reservations as $index => $res): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= htmlspecialchars($res['type_appointments_type']) ?></td>
                    <td><?= htmlspecialchars($res['type_vehicle_type']) ?></td>
                    <td><?= htmlspecialchars($res['date_of']) ?></td>
                    <td><?= htmlspecialchars($res['start_time']) ?></td>
                    <td><?= htmlspecialchars($res['end_time']) ?></td>
                    <td><?= htmlspecialchars($res['name']) ?></td>
                    <td><?= htmlspecialchars($res['email']) ?></td>
                    <td><?= htmlspecialchars($res['telephone']) ?></td>
                    <td>
                        <a href="edit.php?id=<?= $res['id']; ?>">Edit</a> |
                        <a href="delete.php?id=<?= $res['id']; ?>">Delete</a>
                        <a href="logout.php?id=<?= $res['id']; ?>">Delete</a>

                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="10" class="has-text-centered">No reservations found.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
    <p> R.F. De Wit Auto's © </p>
</section>
</body>
</html>
