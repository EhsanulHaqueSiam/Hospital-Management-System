<?php
session_start();
require_once('../model/doctorModel.php');
require_once('../model/userModel.php');
require_once('../model/appointmentModel.php');
require_once('../model/prescriptionModel.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $doctor = getDoctorById($id);
    if (!$doctor) {
        echo "Doctor not found";
        echo "<br><a href='../view/admin_doctor_list.php'>Go Back</a>";
        exit;
    }

    $user_id = $doctor['user_id'];

    $appointmentCount = countAppointmentsByDoctor($id);
    if ($appointmentCount > 0) {
        echo "Cannot delete doctor: " . $appointmentCount . " appointment(s) are linked. Please delete or reassign appointments first.";
        echo "<br><a href='../view/admin_doctor_list.php'>Go Back</a>";
        exit;
    }

    $prescriptionCount = countPrescriptionsByDoctor($id);
    if ($prescriptionCount > 0) {
        echo "Cannot delete doctor: " . $prescriptionCount . " prescription(s) are linked. Please delete prescriptions first.";
        echo "<br><a href='../view/admin_doctor_list.php'>Go Back</a>";
        exit;
    }

    $status = deleteDoctor($id);

    if ($status) {
        deleteUser($user_id);
        header('location: ../view/admin_doctor_list.php');
        exit;
    } else {
        echo "Failed to delete doctor";
        echo "<br><a href='../view/admin_doctor_list.php'>Go Back</a>";
    }
} else {
    header('location: ../view/admin_doctor_list.php');
    exit;
}
?>