<?php
session_start();

//May I visit this page? Check the SESSION

// Redirect if not logged in
if (!isset($_SESSION['user'])){
//    print_r($_SESSION);
    // redirect to login page
    header('Location: login.php');
    exit();
}
