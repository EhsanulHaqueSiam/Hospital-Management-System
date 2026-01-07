<?php
session_start();
require_once('../model/patientModel.php');
require_once('../model/userModel.php');
require_once('../model/appointmentModel.php');
require_once('../model/prescriptionModel.php');
require_once('../model/billModel.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $patient = getPatientById($id);
    if (!$patient) {
        echo "Patient not found";
        echo "<br><a href='../view/patient_list.php'>Go Back</a>";
        exit;
    }

    $user_id = $patient['user_id'];

    $appointmentCount = countAppointmentsByPatient($id);
    if ($appointmentCount > 0) {
        echo "Cannot delete patient: " . $appointmentCount . " appointment(s) are linked. Please delete appointments first.";
        echo "<br><a href='../view/patient_list.php'>Go Back</a>";
        exit;
    }

    $prescriptionCount = countPrescriptionsByPatient($id);
    if ($prescriptionCount > 0) {
        echo "Cannot delete patient: " . $prescriptionCount . " prescription(s) are linked. Please delete prescriptions first.";
        echo "<br><a href='../view/patient_list.php'>Go Back</a>";
        exit;
    }

    $billCount = countBillsByPatient($id);
    if ($billCount > 0) {
        echo "Cannot delete patient: " . $billCount . " bill(s) are linked. Please delete bills first.";
        echo "<br><a href='../view/patient_list.php'>Go Back</a>";
        exit;
    }

    $status = deletePatient($id);

    if ($status) {
        deleteUser($user_id);
        header('location: ../view/patient_list.php');
        exit;
    } else {
        echo "Failed to delete patient";
        echo "<br><a href='../view/patient_list.php'>Go Back</a>";
    }
} else {
    header('location: ../view/patient_list.php');
    exit;
}
?>