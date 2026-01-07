<?php
session_start();
require_once('../model/appointmentModel.php');
require_once('../model/patientModel.php');

// Check if logged in
if (!isset($_SESSION['user_id'])) {
    header('location: ../view/auth_signin.php');
    exit;
}

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

// Get appointment ID
$appointment_id = isset($_GET['id']) ? $_GET['id'] : 0;

if ($appointment_id == 0) {
    header('location: ../view/appointment_list.php');
    exit;
}

// Fetch appointment
$appointment = getAppointmentById($appointment_id);

if (!$appointment) {
    header('location: ../view/appointment_list.php');
    exit;
}

// Check permissions
$canCancel = false;

if ($role == 'admin') {
    $canCancel = true;
} elseif ($role == 'patient') {
    $patient = getPatientByUserId($user_id);
    if ($patient && $patient['id'] == $appointment['patient_id']) {
        $canCancel = true;
    }
}

if (!$canCancel || !in_array($appointment['status'], ['pending', 'confirmed'])) {
    header('location: ../view/appointment_list.php');
    exit;
}

$result = updateAppointmentStatus($appointment_id, 'cancelled');

header('location: ../view/appointment_list.php');
exit;
