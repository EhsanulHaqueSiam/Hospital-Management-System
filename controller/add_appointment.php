<?php
session_start();
require_once('../model/appointmentModel.php');

if (isset($_POST['submit'])) {
    $patient_id = $_POST['patient_id'];
    $doctor_id = $_POST['doctor_id'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $reason = $_POST['reason'];

    if ($patient_id == "" || $doctor_id == "" || $appointment_date == "" || $appointment_time == "") {
        echo "All required fields must be filled";
    } else {
        $appointment = [
            'patient_id' => $patient_id,
            'doctor_id' => $doctor_id,
            'appointment_date' => $appointment_date,
            'appointment_time' => $appointment_time,
            'reason' => $reason,
            'status' => 'pending',
            'notes' => ''
        ];

        $result = addAppointment($appointment);

        if ($result) {
            header('location: ../view/appointment_list.php');
            exit;
        } else {
            echo "Failed to book appointment";
        }
    }
} else {
    header('location: ../view/appointment_add.php');
    exit;
}
?>