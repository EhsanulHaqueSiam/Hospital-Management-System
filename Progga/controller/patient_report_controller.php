<?php
session_start();
require_once(__DIR__ . '/../models/db.php');
require_once(__DIR__ . '/../models/patient_model.php');

/* Admin only */
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    echo "Access denied";
    exit;
}

$con = getConnection();

/* Default */
$patients = [];
$stats = [
    'total' => 0,
    'male' => 0,
    'female' => 0,
    'other' => 0,
    'avg_age' => 0
];

$filters = [
    'from_date' => $_POST['from_date'] ?? '',
    'to_date' => $_POST['to_date'] ?? '',
    'gender' => $_POST['gender'] ?? 'All',
    'age_range' => $_POST['age_range'] ?? 'All'
];

if (isset($_POST['generate'])) {
    $patients = getPatients($con, $filters);

    if (count($patients) > 0) {
        $ageSum = 0;

        foreach ($patients as $p) {
            $stats['total']++;

            if ($p['gender'] === 'Male') $stats['male']++;
            elseif ($p['gender'] === 'Female') $stats['female']++;
            else $stats['other']++;

            $ageSum += $p['age'];
        }

        $stats['avg_age'] = round($ageSum / $stats['total'], 2);
    }
}

/* Export XML */
if (isset($_POST['export_xml'])) {
    header('Content-Type: text/xml');
    header('Content-Disposition: attachment; filename="patients_report.xml"');

    echo "<patients>";
    foreach ($patients as $p) {
        echo "<patient>";
        foreach ($p as $key => $value) {
            echo "<$key>$value</$key>";
        }
        echo "</patient>";
    }
    echo "</patients>";
    exit;
}

require_once(__DIR__ . '/../view/reports/patient_report.php');
