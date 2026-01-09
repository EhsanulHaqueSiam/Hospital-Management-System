<?php
session_start();
require_once(__DIR__ . '/../models/db.php');

/* -------------------------
   Admin access only
------------------------- */
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    echo "Access denied";
    exit;
}

/* -------------------------
   Database connection
------------------------- */
$con = getConnection();

/* -------------------------
   Default values
------------------------- */
$totalPatients = 0;
$totalAppointments = 0;
$totalRevenue = 0;
$activeDoctors = 0;

/* -------------------------
   Helper function
------------------------- */
function tableExists($con, $table) {
    $res = mysqli_query($con, "SHOW TABLES LIKE '$table'");
    return ($res && mysqli_num_rows($res) > 0);
}

/* -------------------------
   Patients
------------------------- */
if (tableExists($con, 'patients')) {
    $res = mysqli_query($con, "SELECT COUNT(*) AS total FROM patients");
    if ($res) {
        $row = mysqli_fetch_assoc($res);
        $totalPatients = $row['total'];
    }
}

/* -------------------------
   Appointments
------------------------- */
if (tableExists($con, 'appointments')) {
    $res = mysqli_query($con, "SELECT COUNT(*) AS total FROM appointments");
    if ($res) {
        $row = mysqli_fetch_assoc($res);
        $totalAppointments = $row['total'];
    }
}

/* -------------------------
   Revenue
------------------------- */
if (tableExists($con, 'payments')) {
    $res = mysqli_query($con, "SELECT SUM(amount) AS total FROM payments");
    if ($res) {
        $row = mysqli_fetch_assoc($res);
        $totalRevenue = $row['total'] ?? 0;
    }
}

/* -------------------------
   Active Doctors
------------------------- */
if (tableExists($con, 'doctors')) {
    $res = mysqli_query($con, "SELECT COUNT(*) AS total FROM doctors");
    if ($res) {
        $row = mysqli_fetch_assoc($res);
        $activeDoctors = $row['total'];
    }
}

/* -------------------------
   Load View
------------------------- */
require_once(__DIR__ . '/../view/reports/admin_dashboard.php');
