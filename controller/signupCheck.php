<?php
require_once('../model/userModel.php');

session_start();

if (isset($_POST['signup'])) {

    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];

    if ($full_name == "" || $email == "" || $phone == "" || $username == "" || $password == "" || $role == "") {
        echo "All fields are required";
    } else if ($password != $confirm_password) {
        echo "Passwords do not match";
    } else {
        $existingUserByUsername = getUserByUsername($username);

        if ($existingUserByUsername != false) {
            echo "Username already exists";
        } else {
            $user = [
                'full_name' => $full_name,
                'email' => $email,
                'phone' => $phone,
                'username' => $username,
                'password' => $password,
                'role' => $role
            ];

            $status = addUser($user);

            if ($status) {
                header('location: ./../view/auth_signin.php');
            } else {
                echo "Registration failed. Please try again.";
            }
        }
    }
} else {
    header('location: ./../view/auth_signup.php');
}
?>
