<?php
session_start();

if (isset($_COOKIE['status']) !== true) {
    header('location: ../view/auth_signin.php');
    exit;
}
?>