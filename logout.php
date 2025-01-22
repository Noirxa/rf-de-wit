<?php


// Start the session.
session_start();

session_unset();

// destroy the session.
session_destroy();

// Redirect to login page
header('location: hometryaya.php');
// Exit the code.
exit();
?>

