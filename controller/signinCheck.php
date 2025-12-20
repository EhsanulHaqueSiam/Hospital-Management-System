<?php
session_start();

if (!isset($_SESSION['users'])) {
    $_SESSION['users'] = array(
        array('username' => 'admin', 'email' => 'admin@hospital.com', 'password' => 'admin123')
    );
}

if (isset($_POST['signin'])) {
    $email_username = $_POST['email_username'];
    $password = $_POST['password'];

    $found = false;
    foreach ($_SESSION['users'] as $user) {
        if (($user['username'] == $email_username || $user['email'] == $email_username) && $user['password'] == $password) {
            $found = true;
            $_SESSION['username'] = $user['username'];
            break;
        }
    }

    if ($found) {
        setcookie('status', 'true', time() + 3000, '/');

        if (isset($_POST['remember_me'])) {
            setcookie('remember_user', $email_username, time() + (86400 * 30), '/');
        }

        header('location: ../view/dashboard_main.php');
    } else {
        echo "Invalid username/email or password";
    }
} else {
    header('location: ../view/auth_signin.html');
}
?>