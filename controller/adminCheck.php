<?php
session_start();

// Check if user is logged in
if (isset($_COOKIE['status']) !== true) {
    header('location: ../view/auth_signin.php');
    exit;
}

// Check if user has admin role
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('location: ../view/auth_signin.php');
    exit;
}
?>