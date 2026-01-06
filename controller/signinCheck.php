<?php
require_once('../model/userModel.php');

session_start();

if (isset($_POST['signin'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username == "" || $password == "") {
        echo "Username and password are required";
    } else {
        $credentials = ['username' => $username, 'password' => $password];
        $user = login($credentials);

        if ($user != false) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['status'] = true;

            setcookie('status', 'true', time() + 3000, '/');

            if (isset($_POST['remember_me'])) {
                setcookie('remember_user', $username, time() + (86400 * 30), '/');
            }

            if ($user['role'] == 'admin') {
                header('location: ../view/dashboard_admin.php');
            } elseif ($user['role'] == 'doctor') {
                header('location: ../view/dashboard_doctor.php');
            } elseif ($user['role'] == 'patient') {
                header('location: ../view/dashboard_patient.php');
            } else {
                echo "Invalid role";
            }
        } else {
            echo "Invalid username or password";
        }
    }
} else {
    header('location: ../view/auth_signin.php');
}
?>