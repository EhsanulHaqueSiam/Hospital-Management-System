<?php
session_start();
require_once('../model/prescriptionModel.php');
require_once('../model/doctorModel.php');

// Check if logged in
if (!isset($_SESSION['user_id'])) {
    header('location: ../view/auth_signin.php');
    exit;
}

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Get prescription to check ownership
    $prescription = getPrescriptionById($id);

    if (!$prescription) {
        header('location: ../view/prescription_list.php');
        exit;
    }

    // Check permission - admin can delete any, doctor can delete their own
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