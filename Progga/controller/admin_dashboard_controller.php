<?php
session_start();

// Check admin access
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header('Location: ./admin_signin.php');
    exit;
}

require_once(__DIR__ . '/../core/BaseModel.php');
require_once(__DIR__ . '/../models/db.php');
require_once(__DIR__ . '/../models/staff_model.php');

// Get database connection
$db = Database::connect();

// Initialize variables
$totalPatients = 0;
$totalAppointments = 0;
$totalRevenue = 0;
$activeDoctors = 0;

// Get total patients
$query = "SELECT COUNT(*) as count FROM users WHERE role = 'Patient' AND deleted = 0";
$result = $db->query($query);
if ($result) {
    $row = $result->fetch_assoc();
    $totalPatients = $row['count'] ?? 0;
}

// Get appointments this month
$currentMonth = date('Y-m-01');
$query = "SELECT COUNT(*) as count FROM appointments WHERE status = 'Confirmed' AND appointment_date >= '$currentMonth'";
$result = $db->query($query);
if ($result) {
    $row = $result->fetch_assoc();
    $totalAppointments = $row['count'] ?? 0;
}

// Get revenue this month
$query = "SELECT SUM(amount) as total FROM payments WHERE status = 'Paid' AND DATE_FORMAT(payment_date, '%Y-%m') = DATE_FORMAT(CURDATE(), '%Y-%m')";
$result = $db->query($query);
if ($result) {
    $row = $result->fetch_assoc();
    $totalRevenue = $row['total'] ?? 0;
}

// Get active doctors
$query = "SELECT COUNT(*) as count FROM users WHERE role = 'Doctor' AND status = 1 AND deleted = 0";
$result = $db->query($query);
if ($result) {
    $row = $result->fetch_assoc();
    $activeDoctors = $row['count'] ?? 0;
}

// Include the view
include(__DIR__ . '/../view/reports/admin_dashboard.php');
?>
