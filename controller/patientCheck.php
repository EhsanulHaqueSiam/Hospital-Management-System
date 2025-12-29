<?php
session_start();

// Check if user is logged in
if (isset($_COOKIE['status']) !== true) {
    header('location: ../view/auth_signin.php');
    exit;
}

// Check if user has patient role
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'patient') {
    header('location: ../view/auth_signin.php');
    exit;
}
?>