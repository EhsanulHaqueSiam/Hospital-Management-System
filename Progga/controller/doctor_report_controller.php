<?php
session_start();
require_once(__DIR__ . '/../models/db.php');
require_once(__DIR__ . '/../models/doctor_report_model.php');

/* Admin only */
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    echo "Access denied";
    exit;
}

$con = getConnection();

/* Filters */
$filters = [
    'department' => $_POST['department'] ?? 'All',
    'doctor' => $_POST['doctor'] ?? 'All',
    'from_date' => $_POST['from_date'] ?? '',
    'to_date' => $_POST['to_date'] ?? ''
];

$doctors = [];
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

/* Export XML */
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

require_once(__DIR__ . '/../view/reports/doctor_report.php');
