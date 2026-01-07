<?php
session_start();
require_once('../model/doctorModel.php');

// Check if admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('location: ../view/auth_signin.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $doctor_id = $_POST['doctor_id'];
    $department_id = $_POST['department_id'];

    // Validate inputs
    if (empty($doctor_id) || empty($department_id)) {
        header('location: ../view/admin_doctor_list.php');
        exit;
    }

    // Update doctor's department
    $result = updateDoctorDepartment($doctor_id, $department_id);

    if ($result) {
        header('location: ../view/admin_doctor_list.php');
    } else {
        header('location: ../view/admin_doctor_assign.php?id=' . $doctor_id);
    }
    exit;
} else {
    header('location: ../view/admin_doctor_list.php');
    exit;
}
