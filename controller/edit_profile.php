<?php
session_start();
require_once('../model/userModel.php');
require_once('../model/validationHelper.php');

if (isset($_POST['submit'])) {
    $user_id = $_SESSION['user_id'];
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = isset($_POST['address']) ? trim($_POST['address']) : '';

    $errors = [];
    if ($err = validateRequired($full_name, 'Full Name'))
        $errors[] = $err;
    if ($err = validateEmail($email))
        $errors[] = $err;
    if ($err = validatePhone($phone))
        $errors[] = $err;

    if (count($errors) > 0) {
        echo "Validation errors:<br>" . implode("<br>", $errors);
        echo "<br><a href='../view/profile_edit.php'>Go Back</a>";
        exit;
    } else {
        $user = [
            'id' => $user_id,
            'full_name' => $full_name,
            'email' => $email,
            'phone' => $phone,
            'address' => $address
        ];

        $status = updateUser($user);

        if ($status) {
            $_SESSION['full_name'] = $full_name;
            header('location: ../view/profile_view.php');
            exit;
        } else {
            echo "Failed to update profile";
            echo "<br><a href='../view/profile_edit.php'>Go Back</a>";
            exit;
        }
    }
} else {
    header('location: ../view/profile_edit.php');
    exit;
}
?>