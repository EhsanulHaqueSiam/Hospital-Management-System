<?php
session_start();
require_once('../model/medicalRecordModel.php');
require_once('../model/patientModel.php');

// Check if logged in
if (!isset($_SESSION['user_id'])) {
    header('location: ../view/auth_signin.php');
    exit;
}

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

// Get record ID
$record_id = isset($_GET['id']) ? $_GET['id'] : 0;

if ($record_id == 0) {
    header('location: ../view/record_list.php');
    exit;
}

// Fetch record
$record = getMedicalRecordById($record_id);

if (!$record || !$record['file_path']) {
    header('location: ../view/record_list.php');
    exit;
}

// Check permissions
$canDownload = false;

if ($role == 'admin' || $role == 'doctor') {
    $canDownload = true;
} elseif ($role == 'patient') {
    $patient = getPatientByUserId($user_id);
    if ($patient && $patient['id'] == $record['patient_id']) {
        $canDownload = true;
    }
}

if (!$canDownload) {
    header('location: ../view/record_list.php');
    exit;
}

$file_path = '../' . $record['file_path'];

if (!file_exists($file_path)) {
    header('location: ../view/record_view.php?id=' . $record_id);
    exit;
}

// Get file info
$file_name = basename($record['file_path']);
$file_size = filesize($file_path);
$file_ext = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));

// Set content type based on extension
$content_types = [
    'pdf' => 'application/pdf',
    'jpg' => 'image/jpeg',
    'jpeg' => 'image/jpeg',
    'png' => 'image/png',
    'gif' => 'image/gif'
];

$content_type = isset($content_types[$file_ext]) ? $content_types[$file_ext] : 'application/octet-stream';

// Set headers for download
header('Content-Description: File Transfer');
header('Content-Type: ' . $content_type);
header('Content-Disposition: attachment; filename="' . $file_name . '"');
header('Content-Length: ' . $file_size);
header('Cache-Control: must-revalidate');
header('Pragma: public');


ob_clean();
flush();

readfile($file_path);
exit;
