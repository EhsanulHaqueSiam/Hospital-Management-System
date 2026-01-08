<?php
session_start();
require_once('../model/prescriptionModel.php');
require_once('../model/doctorModel.php');
if (!isset($_SESSION['user_id'])) {
    header('location: ../view/auth_signin.php');
    exit;
}

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $prescription = getPrescriptionById($id);

    if (!$prescription) {
        header('location: ../view/prescription_list.php');
        exit;
    }
    $canDelete = false;
    if ($role == 'admin') {
        $canDelete = true;
    } elseif ($role == 'doctor') {
        $current_doctor = getDoctorByUserId($user_id);
        if ($current_doctor && $current_doctor['id'] == $prescription['doctor_id']) {
            $canDelete = true;
        }
    }

    if (!$canDelete) {
        header('location: ../view/prescription_list.php');
        exit;
    }

    $status = deletePrescription($id);

    if ($status) {
        header('location: ../view/prescription_list.php');
    } else {
        echo "Failed to delete prescription";
    }
} else {
    header('location: ../view/prescription_list.php');
}
?>