<?php
require_once('adminCheck.php');
require_once('../model/appointmentModel.php');
require_once('../model/validationHelper.php');

if (isset($_POST['submit'])) {
    $appointment_id = intval($_POST['appointment_id']);
    $patient_id = intval($_POST['patient_id']);
    $doctor_id = intval($_POST['doctor_id']);
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $status = $_POST['status'];
    $reason = trim($_POST['reason']);
    $notes = trim($_POST['notes']);

    $errors = [];
    if ($patient_id < 1)
        $errors[] = "Patient is required";
    if ($doctor_id < 1)
        $errors[] = "Doctor is required";
    if ($err = validateDate($appointment_date, 'Appointment Date'))
        $errors[] = $err;
    if ($err = validateRequired($appointment_time, 'Appointment Time'))
        $errors[] = $err;

    if (count($errors) > 0) {
        echo "Validation errors:<br>" . implode("<br>", $errors);
    } else {
        $con = getConnection();
        $appointment_id = intval($appointment_id);
        $patient_id = intval($patient_id);
        $doctor_id = intval($doctor_id);
        $appointment_date = mysqli_real_escape_string($con, $appointment_date);
        $appointment_time = mysqli_real_escape_string($con, $appointment_time);
        $status = mysqli_real_escape_string($con, $status);
        $reason = mysqli_real_escape_string($con, $reason);
        $notes = mysqli_real_escape_string($con, $notes);

        $sql = "UPDATE appointments SET patient_id='{$patient_id}', doctor_id='{$doctor_id}', 
                appointment_date='{$appointment_date}', appointment_time='{$appointment_time}', 
                status='{$status}', reason='{$reason}', notes='{$notes}' 
                WHERE id='{$appointment_id}'";

        if (mysqli_query($con, $sql)) {
            header('location: ../view/appointment_view.php?id=' . $appointment_id);
        } else {
            echo "Failed to update appointment";
        }
    }
} else {
    header('location: ../view/appointment_list.php');
}
?>