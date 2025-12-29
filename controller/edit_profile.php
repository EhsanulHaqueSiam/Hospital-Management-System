<?php
session_start();
require_once('../model/userModel.php');

if (isset($_POST['submit'])) {
    $user_id = $_SESSION['user_id'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    if ($full_name == "" || $email == "" || $phone == "") {
        echo "All fields are required";
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
            // Update session data
            $_SESSION['full_name'] = $full_name;
            header('location: ../view/profile_view.php');
        } else {
            echo "Failed to update profile";
        }
    }
} else {
    header('location: ../view/profile_edit.php');
}
?>