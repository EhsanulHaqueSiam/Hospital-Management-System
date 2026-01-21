<?php
session_start();

// Check admin access
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header('Location: ./admin_signin.php');
    exit;
}

require_once(__DIR__ . '/../core/BaseModel.php');
require_once(__DIR__ . '/../models/db.php');

$db = Database::connect();

// Initialize variables
$overall = [
    'active_doctors' => 0,
    'total_appointments' => 0,
    'most_active_doctor' => 'N/A'
];

$doctors = [];

// Get active doctors count
$query = "SELECT COUNT(*) as count FROM users WHERE role = 'Doctor' AND status = 1 AND deleted = 0";
$result = $db->query($query);
if ($result) {
    $row = $result->fetch_assoc();
    $overall['active_doctors'] = $row['count'] ?? 0;
}

// Get total appointments
$query = "SELECT COUNT(*) as count FROM appointments WHERE status = 'Confirmed'";
$result = $db->query($query);
if ($result) {
    $row = $result->fetch_assoc();
    $overall['total_appointments'] = $row['count'] ?? 0;
}

// Get all doctors with appointment counts
$query = "
    SELECT u.user_id, u.name, d.department_name, COUNT(a.appointment_id) as appointments
    FROM users u
    LEFT JOIN departments d ON u.department_id = d.department_id
    LEFT JOIN appointments a ON u.user_id = a.doctor_id AND a.status = 'Confirmed'
    WHERE u.role = 'Doctor' AND u.deleted = 0
    GROUP BY u.user_id
    ORDER BY appointments DESC
";
$result = $db->query($query);
if ($result) {
    $doctors = $result->fetch_all(MYSQLI_ASSOC);
    if (!empty($doctors)) {
        $overall['most_active_doctor'] = $doctors[0]['name'];
    }
}

include(__DIR__ . '/../view/reports/doctor_report.php');
?>
