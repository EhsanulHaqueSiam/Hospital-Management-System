<?php
session_start();

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
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    $error = '';
    if ($username === '' || $email === '' || $password === '') {
        $error = 'All fields are required.';
    } else {
        // check duplicates
        foreach ($admins as $a) {
            if (strtolower($a['username']) === strtolower($username) || strtolower($a['email']) === strtolower($email)) {
                $error = 'An admin with that username or email already exists.';
                break;
            }
        }
    }

    if ($error === '') {
        $admins[] = [
            'username' => $username,
            'email' => $email,
            'password' => $password
        ];
        file_put_contents($adminsFile, json_encode($admins, JSON_PRETTY_PRINT));
        header('Location: admin_signin.php?created=1');
        exit;
    }
}

require_once('../view/admin_signup.php');
