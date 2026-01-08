<?php
session_start();
require_once('../model/doctorModel.php');
require_once('../model/validationHelper.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header('location: ../view/auth_signin.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $doctor_id = intval($_POST['doctor_id']);
    $department_id = intval($_POST['department_id']);

    $errors = [];
    if ($doctor_id < 1)
        $errors[] = "Doctor is required";
    if ($department_id < 1)
        $errors[] = "Department is required";

    if (count($errors) > 0) {
        header('location: ../view/admin_doctor_list.php');
        exit;
    }

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
