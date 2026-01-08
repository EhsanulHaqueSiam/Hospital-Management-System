<?php
require_once('../model/userModel.php');
require_once('../model/validationHelper.php');

session_start();

if (isset($_POST['reset_password'])) {

    $username = trim($_POST['username']);
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    $errors = [];
    if ($err = validateRequired($username, 'Username'))
        $errors[] = $err;
    if ($err = validatePassword($new_password))
        $errors[] = $err;
    if ($new_password != $confirm_password)
        $errors[] = "Passwords do not match";

    if (count($errors) > 0) {
        echo "Validation errors:<br>" . implode("<br>", $errors);
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