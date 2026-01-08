<?php
require_once('../model/userModel.php');
require_once('../model/validationHelper.php');

session_start();

if (isset($_POST['signup'])) {

    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];

    $errors = [];
    if ($err = validateRequired($full_name, 'Full Name'))
        $errors[] = $err;
    if ($err = validateEmail($email))
        $errors[] = $err;
    if ($err = validatePhone($phone))
        $errors[] = $err;
    if ($err = validateUsername($username))
        $errors[] = $err;
    if ($err = validatePassword($password))
        $errors[] = $err;
    if ($password != $confirm_password)
        $errors[] = "Passwords do not match";
    if ($err = validateRequired($role, 'Role'))
        $errors[] = $err;

    if (count($errors) > 0) {
        echo "Validation errors:<br>" . implode("<br>", $errors);
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
                header('location: ../view/auth_signin.php');
            } else {
                echo "Registration failed. Please try again.";
            }
        }
    }
} else {
    header('location: ../view/auth_signup.php');
}
?>