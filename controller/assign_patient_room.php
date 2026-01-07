<?php
session_start();
require_once('../model/roomModel.php');

if (isset($_POST['submit'])) {
    $patient_id = $_POST['patient_id'];
    $room_id = $_POST['room_id'];
    $admission_date = $_POST['admission_date'];
    $expected = $_POST['expected_discharge_date'];
    $notes = $_POST['notes'];
    $assigned_by = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    if (!$assigned_by) {
        echo "Please login first";
        exit;
    }

    if ($patient_id == "" || $room_id == "" || $admission_date == "") {
        echo "Required fields are missing";
    } else {
        $assignment = [
            'patient_id' => $patient_id,
            'room_id' => $room_id,
            'admission_date' => $admission_date,
            'expected_discharge_date' => $expected,
            'admission_notes' => $notes,
            'assigned_by' => $assigned_by
        ];

        $status = assignPatientToRoom($assignment);

        if ($status) {
            header('location: ../view/room_list.php');
        } else {
            echo "Failed to assign room";
        }
    }
} else {
    header('location: ../view/room_assign.php');
}
?>