<?php
session_start();
require_once('../models/db.php');
require_once('../models/revenue_report_model.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    echo "Access denied";
    exit;
}

$con = getConnection();

/* Filters */
$filters = [
    'type' => $_POST['report_type'] ?? 'Daily',
    'from_date' => $_POST['from_date'] ?? '',
    'to_date' => $_POST['to_date'] ?? ''
];

$data = [];
$summary = [
    'total_revenue' => 0,
    'total_bills' => 0,
    'paid_bills' => 0,
    'unpaid_amount' => 0,
    'avg_bill' => 0
];

if (isset($_POST['generate'])) {
    $data = getRevenueData($con, $filters);

    foreach ($data as $row) {
        $summary['total_revenue'] += $row['paid_amount'];
        $summary['total_bills'] += $row['bills_generated'];
        $summary['unpaid_amount'] += $row['unpaid_amount'];
    }

    if ($summary['total_bills'] > 0) {
        $summary['avg_bill'] = round($summary['total_revenue'] / $summary['total_bills'], 2);
        $summary['paid_bills'] = $summary['total_bills']; // simplified
    }
}

if (isset($_POST['export_xml'])) {
    header("Content-Type: text/xml");
    header("Content-Disposition: attachment; filename=revenue_report.xml");

    echo "<revenueReport>";
    foreach ($data as $row) {
        echo "<record>";
        foreach ($row as $key => $value) {
            echo "<$key>$value</$key>";
        }
        echo "</record>";
    }
    echo "</revenueReport>";
    exit;
}

require_once('../view/reports/revenue_report.php');
