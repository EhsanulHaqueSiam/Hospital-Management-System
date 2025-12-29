<?php
session_start();
require_once('../model/userModel.php');

if (isset($_POST['submit'])) {
    $user_id = $_SESSION['user_id'];
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($old_password == "" || $new_password == "" || $confirm_password == "") {
        echo "All fields are required";
    } else if ($new_password != $confirm_password) {
        echo "Passwords do not match";
    } else if (strlen($new_password) < 8) {
        echo "Password must be at least 8 characters";
    } else {
        // Verify old password
        $user = getUserById($user_id);

        if ($user && $user['password'] == $old_password) {
            $status = updatePassword($user_id, $new_password);

            if ($status) {
                header('location: ../view/profile_view.php');
            } else {
                echo "Failed to update password";
            }
        } else {
            echo "Old password is incorrect";
        }
    }
} else {
    header('location: ../view/profile_change_password.php');
}
?>