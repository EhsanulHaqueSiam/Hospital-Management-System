<?php
session_start();
require_once('../model/userModel.php');
require_once('../model/doctorModel.php');

if (isset($_POST['submit'])) {
    $doctor_id = $_POST['doctor_id'];
    $user_id = $_POST['user_id'];

    // User data
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Doctor data
    $department_id = $_POST['department_id'];
    $specialization = $_POST['specialization'];
    $bio = $_POST['bio'];

    if ($full_name == "" || $email == "" || $phone == "" || $specialization == "") {
        echo "All required fields must be filled";
    } else {
        // Update user
        $user = [
            'id' => $user_id,
            'full_name' => $full_name,
            'email' => $email,
            'phone' => $phone
        ];

        $user_status = updateUser($user);

        // Update doctor
        $doctor = [
            'id' => $doctor_id,
            'department_id' => $department_id,
            'specialization' => $specialization,
            'bio' => $bio
        ];

        $doctor_status = updateDoctor($doctor);

        if ($user_status || $doctor_status) {
            header('location: ../view/admin_doctor_list.php');
        } else {
            echo "Failed to update doctor";
        }
    }
} else {
    header('location: ../view/admin_doctor_list.php');
}
?>