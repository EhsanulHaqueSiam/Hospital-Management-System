<?php
session_start();
require_once('../model/appointmentModel.php');

// Check if logged in
if (!isset($_SESSION['user_id'])) {
    header('location: ../view/auth_signin.php');
    exit;
}

$role = $_SESSION['role'];
// Only admin and doctor can update appointment status
if ($role != 'admin' && $role != 'doctor') {
    header('location: ../view/appointment_list.php');
    exit;
}

if (isset($_POST['submit'])) {
    $appointment_id = $_POST['appointment_id'];
    $status = $_POST['status'];

    $result = updateAppointmentStatus($appointment_id, $status);

    if ($result) {
        header('location: ../view/appointment_view.php?id=' . $appointment_id);
    } else {
        echo "Failed to update status";
    }
} else {
    header('location: ../view/appointment_list.php');
}
?>