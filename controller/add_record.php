<?php
session_start();
require_once('../model/medicalRecordModel.php');

// Check if logged in and has permission
if (!isset($_SESSION['user_id'])) {
    header('location: ../view/auth_signin.php');
    exit;
}

$role = $_SESSION['role'];
if ($role != 'admin' && $role != 'doctor') {
    header('location: ../view/record_list.php');
    exit;
}

if (isset($_POST['submit'])) {
    $patient_id = $_POST['patient_id'];
    $record_type = $_POST['record_type'];
    $record_date = $_POST['record_date'];
    $description = $_POST['description'];
    $uploaded_by = $_SESSION['user_id'];

    // Handle file
    $file_path = '';
    if (isset($_FILES['record_file']) && $_FILES['record_file']['error'] == 0) {
        $upload_dir = '../uploads/records/';

        // Create directory if it doesn't exist
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $src = $_FILES['record_file']['tmp_name'];
        $ext = explode('.', $_FILES['record_file']['name']);
        $des = $upload_dir . time() . "." . $ext[count($ext) - 1];

        if (move_uploaded_file($src, $des)) {
            $file_path = 'uploads/records/' . time() . "." . $ext[count($ext) - 1];
        }
    }

    if ($patient_id == "" || $record_type == "" || $record_date == "" || $description == "") {
        echo "All required fields must be filled";
    } else {
        $record = [
            'patient_id' => $patient_id,
            'record_type' => $record_type,
            'record_date' => $record_date,
            'description' => $description,
            'file_path' => $file_path,
            'uploaded_by' => $uploaded_by
        ];

        $result = addMedicalRecord($record);

        if ($result) {
            header('location: ../view/record_list.php');
        } else {
            echo "Failed to add medical record";
        }
    }
} else {
    header('location: ../view/record_add.php');
}
?>