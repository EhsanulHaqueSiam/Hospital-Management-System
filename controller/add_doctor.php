<?php
session_start();
require_once('../model/userModel.php');
require_once('../model/doctorModel.php');
require_once('../model/validationHelper.php');

if (isset($_POST['submit'])) {

    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $department_id = $_POST['department_id'];
    $specialization = trim($_POST['specialization']);
    $bio = isset($_POST['bio']) ? trim($_POST['bio']) : '';

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
    if ($err = validateRequired($specialization, 'Specialization'))
        $errors[] = $err;

    if (count($errors) > 0) {
        echo "Validation errors:<br>" . implode("<br>", $errors);
        echo "<br><a href='../view/admin_doctor_add.php'>Go Back</a>";
    } else {

        $existingUser = getUserByUsername($username);
        if ($existingUser) {
            echo "Username already exists. Please use a different username.";
            echo "<br><a href='../view/admin_doctor_add.php'>Go Back</a>";
        } else {

            $user = [
                'full_name' => $full_name,
                'email' => $email,
                'phone' => $phone,
                'username' => $username,
                'password' => $password,
                'role' => 'doctor',
                'address' => isset($_POST['address']) ? $_POST['address'] : ''
            ];

            $new_user_id = addUser($user);

            if ($new_user_id) {

                $doctor = [
                    'user_id' => $new_user_id,
                    'department_id' => $department_id,
                    'specialization' => $specialization,
                    'bio' => $bio
                ];

                $doctor_status = addDoctor($doctor);

                if ($doctor_status) {
                    header('location: ../view/admin_doctor_list.php');
                } else {
                    echo "Failed to add doctor record";
                    echo "<br><a href='../view/admin_doctor_list.php'>Go Back</a>";
                }
            } else {
                echo "Failed to create user account (email might be duplicate)";
                echo "<br><a href='../view/admin_doctor_add.php'>Go Back</a>";
            }
        }
    }
} else {
    header('location: ../view/admin_doctor_add.php');
}
?>