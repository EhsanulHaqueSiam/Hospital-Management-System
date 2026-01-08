<?php
session_start();
require_once('../model/userModel.php');
require_once('../model/validationHelper.php');

if (isset($_POST['submit'])) {
    $user_id = $_SESSION['user_id'];
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    $errors = [];
    if ($err = validateRequired($old_password, 'Old Password'))
        $errors[] = $err;
    if ($err = validatePassword($new_password))
        $errors[] = $err;
    if ($new_password != $confirm_password)
        $errors[] = "Passwords do not match";

    if (count($errors) > 0) {
        echo "Validation errors:<br>" . implode("<br>", $errors);
    } else {
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