<?php
require_once(__DIR__ . '/../models/session_helper.php');
SessionHelper::initSession();
require_once(__DIR__ . '/../core/validator.php');

// simple admin credentials (hardcoded)
$adminUsername = 'admin';
$adminEmail = 'admin@hospital.com';
$adminPassword = 'admin123';
$error = '';
$rememberMe = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['user'] ?? '';
    $password = $_POST['password'] ?? '';
    $rememberMe = isset($_POST['remember_me']) && $_POST['remember_me'] === 'on';

    // Server-side validation
    $data = ['user' => $user, 'password' => $password];
    $rules = [
        'user' => ['required' => true, 'required_message' => 'Username or Email is required.'],
        'password' => ['required' => true, 'required_message' => 'Password is required.']
    ];
    $errs = Validator::validate($data, $rules);
    if (!empty($errs)) {
        $error = implode(' ', $errs);
    } else {
        if ((strtolower($user) === strtolower($adminUsername) || strtolower($user) === strtolower($adminEmail)) && $password === $adminPassword) {
        // Set secure session with optional persistent cookie
        SessionHelper::setLoginSession($adminUsername, $adminEmail, 'Admin', 1, $rememberMe);

        // redirect to admin notice controller (or admin dashboard)
        header('Location: ./notice_controller.php');
        exit;
    } else {
        // fallback: check admins.json for additional admin accounts
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
        $foundAdmin = null;
        foreach ($admins as $a) {
            if ((strtolower($user) === strtolower($a['username']) || strtolower($user) === strtolower($a['email'])) && $password === $a['password']) {
                $foundAdmin = $a;
                $found = true;
                break;
            }
        }

        if ($found) {
            // Set secure session with optional persistent cookie
            SessionHelper::setLoginSession($foundAdmin['username'], $foundAdmin['email'], 'Admin', 1, $rememberMe);
            header('Location: ./notice_controller.php');
            exit;
        } else {
            $error = 'Invalid admin credentials.';
        }
        }
    }
}

// show signin view
require_once(__DIR__ . '/../view/admin_signin.php');
