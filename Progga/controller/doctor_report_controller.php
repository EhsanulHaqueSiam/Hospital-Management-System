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
$overall = [
    'active_doctors' => 0,
    'total_appointments' => 0,
    'most_active_doctor' => 'N/A'
];

if (isset($_POST['generate'])) {
    $doctors = getDoctorReport($con, $filters);

    $overall['active_doctors'] = count($doctors);

    $maxAppointments = 0;
    foreach ($doctors as &$doc) {
        $overall['total_appointments'] += $doc['total_appointments'];

        $doc['total_prescriptions'] = getPrescriptionCount($con, $doc['id']);

        $doc['avg_per_day'] = $doc['total_appointments']; // simplified

        if ($doc['total_appointments'] > $maxAppointments) {
            $maxAppointments = $doc['total_appointments'];
            $overall['most_active_doctor'] = $doc['name'];
        }
    }
}

if (isset($_POST['export_xml'])) {
    header("Content-Type: text/xml");
    header("Content-Disposition: attachment; filename=doctor_report.xml");

    echo "<doctors>";
    foreach ($doctors as $d) {
        echo "<doctor>";
        foreach ($d as $key => $value) {
            echo "<$key>$value</$key>";
        }
        echo "</doctor>";
    }
    echo "</doctors>";
    exit;
}

require_once('../view/reports/doctor_report.php');
