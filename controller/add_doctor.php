<?php
session_start();
require_once('../model/userModel.php');
require_once('../model/doctorModel.php');

if (isset($_POST['submit'])) {

    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $username = $_POST['username'];
    $password = $_POST['password'];


    $department_id = $_POST['department_id'];
    $specialization = $_POST['specialization'];
    $bio = isset($_POST['bio']) ? $_POST['bio'] : '';

    if ($full_name == "" || $email == "" || $phone == "" || $username == "" || $password == "" || $specialization == "") {
        echo "All required fields must be filled";
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