<?php
session_start();
require_once('../model/roomModel.php');
require_once('../model/validationHelper.php');

if (isset($_POST['submit'])) {
    $patient_id = intval($_POST['patient_id']);
    $room_id = intval($_POST['room_id']);
    $admission_date = $_POST['admission_date'];
    $expected = $_POST['expected_discharge_date'];
    $notes = trim($_POST['notes']);
    $assigned_by = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    if (!$assigned_by) {
        echo "Please login first";
        exit;
    }

    $errors = [];
    if ($patient_id < 1)
        $errors[] = "Patient is required";
    if ($room_id < 1)
        $errors[] = "Room is required";
    if ($err = validateDate($admission_date, 'Admission Date'))
        $errors[] = $err;

    if (count($errors) > 0) {
        echo "Validation errors:<br>" . implode("<br>", $errors);
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