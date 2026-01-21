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
$stats = [
    'total' => 0,
    'male' => 0,
    'female' => 0,
    'other' => 0,
    'avg_age' => 0
];

$patients = [];

// Get total patients
$query = "SELECT COUNT(*) as count FROM users WHERE role = 'Patient' AND deleted = 0";
$result = $db->query($query);
if ($result) {
    $row = $result->fetch_assoc();
    $stats['total'] = $row['count'] ?? 0;
}

// Get gender statistics
$query = "SELECT gender, COUNT(*) as count FROM users WHERE role = 'Patient' AND deleted = 0 GROUP BY gender";
$result = $db->query($query);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        if ($row['gender'] === 'Male') {
            $stats['male'] = $row['count'];
        } elseif ($row['gender'] === 'Female') {
            $stats['female'] = $row['count'];
        } else {
            $stats['other'] = $row['count'];
        }
    }
}

// Get average age
$query = "SELECT AVG(YEAR(CURDATE()) - YEAR(DOB)) as avg_age FROM users WHERE role = 'Patient' AND deleted = 0 AND DOB IS NOT NULL";
$result = $db->query($query);
if ($result) {
    $row = $result->fetch_assoc();
    $stats['avg_age'] = round($row['avg_age'] ?? 0, 1);
}

// Get all patients
$query = "
    SELECT u.user_id, u.name, u.email, u.phone, u.gender, 
           YEAR(CURDATE()) - YEAR(u.DOB) as age
    FROM users u
    WHERE u.role = 'Patient' AND u.deleted = 0
    ORDER BY u.user_id DESC
";
$result = $db->query($query);
if ($result) {
    $patients = $result->fetch_all(MYSQLI_ASSOC);
}

include(__DIR__ . '/../view/reports/patient_report.php');
?>
