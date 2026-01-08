<?php
session_start();
require_once('../model/userModel.php');
require_once('../model/doctorModel.php');
require_once('../model/validationHelper.php');

if (isset($_POST['submit'])) {
    $doctor_id = intval($_POST['doctor_id']);
    $user_id = intval($_POST['user_id']);

    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    $department_id = intval($_POST['department_id']);
    $specialization = trim($_POST['specialization']);
    $bio = trim($_POST['bio']);

    $errors = [];
    if ($err = validateRequired($full_name, 'Full Name'))
        $errors[] = $err;
    if ($err = validateEmail($email))
        $errors[] = $err;
    if ($err = validatePhone($phone))
        $errors[] = $err;
    if ($err = validateRequired($specialization, 'Specialization'))
        $errors[] = $err;

    if (count($errors) > 0) {
        echo "Validation errors:<br>" . implode("<br>", $errors);
    } else {

        $user = [
            'id' => $user_id,
            'full_name' => $full_name,
            'email' => $email,
            'phone' => $phone
        ];

        $user_status = updateUser($user);


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