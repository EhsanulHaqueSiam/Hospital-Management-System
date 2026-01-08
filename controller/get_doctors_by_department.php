<?php
session_start();
require_once('../model/doctorModel.php');
require_once('../model/userModel.php');

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Not authenticated']);
    exit;
}

$department_id = isset($_GET['department_id']) ? intval($_GET['department_id']) : 0;

if ($department_id) {
    $doctors = getDoctorsByDepartment($department_id);
} else {
    $doctors = getAllDoctors();
}

$result = [];
foreach ($doctors as $doctor) {
    $user = getUserById($doctor['user_id']);
    if ($user) {
        $result[] = [
            'id' => $doctor['id'],
            'name' => $user['full_name'],
            'specialization' => $doctor['specialization']
        ];
    }
}

echo json_encode(['success' => true, 'doctors' => $result]);
?>