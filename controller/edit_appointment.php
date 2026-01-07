<?php
require_once('adminCheck.php');
require_once('../model/appointmentModel.php');

if (isset($_POST['submit'])) {
    $appointment_id = $_POST['appointment_id'];
    $patient_id = $_POST['patient_id'];
    $doctor_id = $_POST['doctor_id'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $status = $_POST['status'];
    $reason = $_POST['reason'];
    $notes = $_POST['notes'];

    if ($patient_id == "" || $doctor_id == "" || $appointment_date == "" || $appointment_time == "") {
        echo "All required fields must be filled";
    } else {
        // Update appointment
        $con = getConnection();
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