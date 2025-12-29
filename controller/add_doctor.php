<?php
session_start();
require_once('../model/userModel.php');
require_once('../model/doctorModel.php');

if (isset($_POST['submit'])) {
    // User data
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Doctor data
    $department_id = $_POST['department_id'];
    $specialization = $_POST['specialization'];
    $bio = $_POST['bio'];

    if ($full_name == "" || $email == "" || $phone == "" || $username == "" || $password == "" || $specialization == "") {
        echo "All required fields must be filled";
    } else {
        // Create user first
        $user = [
            'full_name' => $full_name,
            'email' => $email,
            'phone' => $phone,
            'username' => $username,
            'password' => $password,
            'role' => 'doctor',
            'address' => isset($_POST['address']) ? $_POST['address'] : ''
        ];

        $user_status = addUser($user);

        if ($user_status) {
            // Get the newly created user's ID
            $con = getConnection();
            $new_user_id = mysqli_insert_id($con);

            // Create doctor record
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
                echo "Failed to add doctor";
            }
        } else {
            echo "Failed to create user";
        }
    }
} else {
    header('location: ../view/admin_doctor_add.php');
}
?>