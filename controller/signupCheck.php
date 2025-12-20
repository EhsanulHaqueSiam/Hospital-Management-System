<?php
session_start();

if (!isset($_SESSION['users'])) {
    $_SESSION['users'] = array(
        array('username' => 'admin', 'email' => 'admin@hospital.com', 'password' => 'admin123')
    );
}

if (isset($_POST['signup'])) {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];

    $exists = false;
    foreach ($_SESSION['users'] as $user) {
        if ($user['username'] == $username || $user['email'] == $email) {
            $exists = true;
            break;
        }
    }

    if ($exists) {
        echo "Username or email already exists";
    } else if ($password != $confirm_password) {
        echo "Passwords do not match";
    } else {
        $_SESSION['users'][] = array(
            'full_name' => $full_name,
            'email' => $email,
            'phone' => $phone,
            'username' => $username,
            'password' => $password,
            'role' => $role
        );
        header('location: ../view/auth_signin.html');
    }
} else {
    header('location: ../view/auth_signup.html');
}
?>