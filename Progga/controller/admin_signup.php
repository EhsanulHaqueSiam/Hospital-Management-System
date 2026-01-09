<?php
session_start();

require_once(__DIR__ . '/../core/validator.php');

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
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $data = ['username' => $username, 'email' => $email, 'password' => $password];
    $rules = [
        'username' => ['required' => true, 'min' => 3, 'max' => 50, 'required_message' => 'Username is required.'],
        'email' => ['required' => true, 'email' => true, 'required_message' => 'Email is required.'],
        'password' => ['required' => true, 'min' => 6, 'required_message' => 'Password is required.']
    ];

    $errors = Validator::validate($data, $rules);

    if (!empty($errors)) {
        $error = implode(' ', $errors);
    } else {
        // check duplicates
        $dup = false;
        foreach ($admins as $a) {
            if (strtolower($a['username']) === strtolower($username) || strtolower($a['email']) === strtolower($email)) {
                $dup = true;
                break;
            }
        }

        if ($dup) {
            $error = 'An admin with that username or email already exists.';
        } else {
            // sanitize before saving
            $admins[] = [
                'username' => Validator::sanitize($username),
                'email' => Validator::sanitize($email),
                'password' => $password
            ];
            file_put_contents($adminsFile, json_encode($admins, JSON_PRETTY_PRINT));
            header('Location: ../view/admin_signin.php?created=1');
            exit;
        }
    }

}

require_once(__DIR__ . '/../view/admin_signup.php');
