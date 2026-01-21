<?php
session_start();
require_once('../core/Validator.php');

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
    $confirm_password = trim($_POST['confirm_password'] ?? '');

    $data = ['username' => $username, 'email' => $email, 'password' => $password, 'confirm_password' => $confirm_password];
    $rules = [
        'username' => [
            'required' => true, 
            'min' => 3, 
            'max' => 50, 
            'alphanumeric' => true,
            'required_message' => 'Username is required.',
            'min_message' => 'Username must be at least 3 characters.',
            'max_message' => 'Username cannot exceed 50 characters.',
            'alphanumeric_message' => 'Username can only contain letters and numbers.'
        ],
        'email' => [
            'required' => true, 
            'email' => true, 
            'required_message' => 'Email is required.',
            'email_message' => 'Please enter a valid email address.'
        ],
        'password' => [
            'required' => true, 
            'min' => 6, 
            'required_message' => 'Password is required.',
            'min_message' => 'Password must be at least 6 characters.'
        ],
        'confirm_password' => [
            'required' => true,
            'match' => 'password',
            'required_message' => 'Password confirmation is required.',
            'match_message' => 'Passwords do not match.'
        ]
    ];

    $errors = Validator::validate($data, $rules);

    if (empty($errors)) {
        $admins[] = [
            'username' => $username,
            'email' => $email,
            'password' => $password
        ];
        file_put_contents($adminsFile, json_encode($admins, JSON_PRETTY_PRINT));
        header('Location: admin_signin.php?created=1');
        exit;
    } else {
        $error = implode(' | ', $errors);
    }
}

require_once('../view/admin_signup.php');
