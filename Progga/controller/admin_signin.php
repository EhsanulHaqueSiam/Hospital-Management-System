<?php
session_start();

// simple admin credentials (hardcoded)
$adminUsername = 'admin';
$adminEmail = 'admin@hospital.com';
$adminPassword = 'admin123';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['user'] ?? '';
    $password = $_POST['password'] ?? '';

    if ((strtolower($user) === strtolower($adminUsername) || strtolower($user) === strtolower($adminEmail)) && $password === $adminPassword) {
        // set admin session only within Progga
        $_SESSION['username'] = $adminUsername;
        $_SESSION['role'] = 'Admin';
        $_SESSION['user_id'] = 1;

        // redirect to admin notice controller (or admin dashboard)
        header('Location: notice_controller.php');
        exit;
    } else {
        $error = 'Invalid admin credentials.';
    // Use admins.json for admin accounts
    $adminsFile = __DIR__ . '/../models/admins.json';
    if (!file_exists($adminsFile)) {
        $default = [
            [
                'username' => 'admin',
                'email' => 'admin@hospital.com',
                'password' => 'admin123'
            ]
        ];
        file_put_contents($adminsFile, json_encode($default, JSON_PRETTY_PRINT));
    }

    $admins = json_decode(file_get_contents($adminsFile), true) ?: [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user = $_POST['user'] ?? '';
        $password = $_POST['password'] ?? '';

        $found = false;
        foreach ($admins as $a) {
            if ((strtolower($user) === strtolower($a['username']) || strtolower($user) === strtolower($a['email'])) && $password === $a['password']) {
                $_SESSION['username'] = $a['username'];
                $_SESSION['role'] = 'Admin';
                $_SESSION['user_id'] = 1;
                $found = true;
                break;
            }
        }

        if ($found) {
            header('Location: notice_controller.php');
            exit;
        } else {
            $error = 'Invalid admin credentials.';
        }
    }

    require_once('../view/admin_signin.php');
