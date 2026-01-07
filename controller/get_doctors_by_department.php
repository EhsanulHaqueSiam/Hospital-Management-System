<?php
session_start();
require_once('../model/doctorModel.php');
require_once('../model/userModel.php');

// Check if logged in
if (!isset($_SESSION['user_id'])) {
    echo '<option value="">Please login</option>';
    exit;
}

$department_id = isset($_GET['department_id']) ? $_GET['department_id'] : 0;

if ($department_id) {
    $doctors = getDoctorsByDepartment($department_id);
} else {
    $doctors = getAllDoctors();
}

echo '<option value="">-- Select Doctor --</option>';

foreach ($doctors as $doctor) {
    $user = getUserById($doctor['user_id']);
    if ($user) {
        echo '<option value="' . $doctor['id'] . '">' . $user['full_name'] . ' - ' . $doctor['specialization'] . '</option>';
    }
}
?>