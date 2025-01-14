<?php

//$ID = $_GET['id'];
global $query;
$host = '127.0.0.1';
$username = 'root';
$password = '';
$database = 'rfdw';

// Make a connection to the database
$db = mysqli_connect($host, $username, $password, $database)
or die('Error:' . mysqli_connect_error());

//require_once 'includes/security_check.php';

// ALS id aanwezig in de url
if (isset ($_GET['id']) && $_GET['id'] !== '') {
    $id = mysqli_escape_string($db, $_GET['id']);

//    $id = $_GET['id'];

// create query
    $query = "DELETE FROM reservation WHERE id = $id";

// id ophalen en opslaan

    $result = mysqli_query($db, $query);

    if ($result) {
        header('Location: index.php');
        exit;
    }
}
?>