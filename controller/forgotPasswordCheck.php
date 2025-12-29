<?php
require_once('../model/userModel.php');

session_start();

if (isset($_POST['reset_password'])) {

    $username = $_POST['username'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($username == "" || $new_password == "" || $confirm_password == "") {
        echo "All fields are required";
    } else if ($new_password != $confirm_password) {
        echo "Passwords do not match";
    } else if (strlen($new_password) < 8) {
        echo "Password must be at least 8 characters long";
    } else {
        $user = getUserByUsername($username);

        if ($user != false) {
            $status = updatePassword($user['id'], $new_password);

            if ($status) {
                echo "Password reset successfully! Redirecting to login...";
                header('refresh:2; url=../view/auth_signin.php');
            } else {
                echo "Password reset failed. Please try again.";
            }
        } else {
            echo "Username not found";
        }
    }
} else {
    header('location: ../view/auth_forgot_password.php');
}
?>