<?php
session_start();
require_once(__DIR__ . '/../core/validator.php');

$adminUsername = 'admin';
$adminEmail = 'admin@hospital.com';
$adminPassword = 'admin123';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['user'] ?? '';
    $password = $_POST['password'] ?? '';

    $data = ['user' => $user, 'password' => $password];
    $rules = [
        'user' => [
            'required' => true,
            'required_message' => 'Username or Email is required.'
        ],
        'password' => [
            'required' => true,
            'required_message' => 'Password is required.'
        ]
    ];

    $errors = Validator::validate($data, $rules);

    if (!empty($errors)) {
        $error = implode(' | ', $errors);
    } else {
        if ((strtolower($user) === strtolower($adminUsername) || strtolower($user) === strtolower($adminEmail)) && $password === $adminPassword) {
            $_SESSION['username'] = $adminUsername;
            $_SESSION['role'] = 'Admin';
            $_SESSION['user_id'] = 1;

            header('Location: notice_controller.php');
            exit;
        } else {
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

}

require_once('../view/admin_signin.php');
