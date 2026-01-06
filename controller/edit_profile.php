<?php
session_start();
require_once('../model/userModel.php');

if (isset($_POST['submit'])) {
    $user_id = $_SESSION['user_id'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = isset($_POST['address']) ? $_POST['address'] : '';

    if ($full_name == "" || $email == "" || $phone == "") {
        echo "All fields are required";
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