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
$summary = [
    'total_revenue' => 0,
    'total_bills' => 0,
    'paid_bills' => 0,
    'unpaid_amount' => 0,
    'avg_bill' => 0
];

$data = [];

// Get total revenue (paid bills)
$query = "SELECT SUM(amount) as total FROM payments WHERE status = 'Paid'";
$result = $db->query($query);
if ($result) {
    $row = $result->fetch_assoc();
    $summary['total_revenue'] = $row['total'] ?? 0;
}

// Get total bills
$query = "SELECT COUNT(*) as count FROM bills";
$result = $db->query($query);
if ($result) {
    $row = $result->fetch_assoc();
    $summary['total_bills'] = $row['count'] ?? 0;
}

// Get paid bills
$query = "SELECT COUNT(*) as count FROM payments WHERE status = 'Paid'";
$result = $db->query($query);
if ($result) {
    $row = $result->fetch_assoc();
    $summary['paid_bills'] = $row['count'] ?? 0;
}

// Get unpaid amount
$query = "SELECT SUM(b.amount - COALESCE(SUM(p.amount), 0)) as unpaid
          FROM bills b
          LEFT JOIN payments p ON b.bill_id = p.bill_id
          WHERE b.status = 'Pending'
          GROUP BY b.bill_id";
$result = $db->query($query);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $summary['unpaid_amount'] += $row['unpaid'] ?? 0;
    }
}

// Get average bill amount
$query = "SELECT AVG(amount) as avg FROM bills";
$result = $db->query($query);
if ($result) {
    $row = $result->fetch_assoc();
    $summary['avg_bill'] = round($row['avg'] ?? 0, 2);
}

// Get revenue data by month
$query = "
    SELECT DATE_FORMAT(payment_date, '%Y-%m') as month, SUM(amount) as revenue
    FROM payments
    WHERE status = 'Paid'
    GROUP BY DATE_FORMAT(payment_date, '%Y-%m')
    ORDER BY month DESC
    LIMIT 12
";
$result = $db->query($query);
if ($result) {
    $data = $result->fetch_all(MYSQLI_ASSOC);
}

include(__DIR__ . '/../view/reports/revenue_report.php');
?>
