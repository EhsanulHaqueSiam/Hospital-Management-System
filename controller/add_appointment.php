<?php
session_start();
require_once('../model/appointmentModel.php');
require_once('../model/validationHelper.php');

if (isset($_POST['submit'])) {
    $patient_id = intval($_POST['patient_id']);
    $doctor_id = intval($_POST['doctor_id']);
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $reason = trim($_POST['reason']);

    $errors = [];
    if ($patient_id < 1)
        $errors[] = "Patient is required";
    if ($doctor_id < 1)
        $errors[] = "Doctor is required";
    if ($err = validateFutureDate($appointment_date, 'Appointment Date'))
        $errors[] = $err;
    if ($err = validateRequired($appointment_time, 'Appointment Time'))
        $errors[] = $err;

    if (count($errors) > 0) {
        echo "Validation errors:<br>" . implode("<br>", $errors);
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