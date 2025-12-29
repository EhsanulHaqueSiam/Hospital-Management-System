<?php
session_start();

// Check if user is logged in
if (isset($_COOKIE['status']) !== true) {
    header('location: ../view/auth_signin.php');
    exit;
}

// Check if user has doctor role
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'doctor') {
    header('location: ../view/auth_signin.php');
    exit;
}
?>