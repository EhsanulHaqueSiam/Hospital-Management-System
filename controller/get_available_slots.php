<?php
session_start();
require_once('../model/appointmentModel.php');

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Not authenticated']);
    exit;
}

$doctor_id = isset($_GET['doctor_id']) ? intval($_GET['doctor_id']) : 0;
$date = isset($_GET['date']) ? $_GET['date'] : '';

if (!$doctor_id || !$date) {
    echo json_encode(['success' => false, 'message' => 'Doctor and date required']);
    exit;
}

$appointments = getAppointmentsByDoctor($doctor_id);
$booked_times = [];

foreach ($appointments as $apt) {
    if ($apt['appointment_date'] == $date && $apt['status'] != 'cancelled') {
        $booked_times[] = $apt['appointment_time'];
    }
}

$all_slots = [
    '09:00:00' => '09:00 AM',
    '09:30:00' => '09:30 AM',
    '10:00:00' => '10:00 AM',
    '10:30:00' => '10:30 AM',
    '11:00:00' => '11:00 AM',
    '11:30:00' => '11:30 AM',
    '12:00:00' => '12:00 PM',
    '14:00:00' => '02:00 PM',
    '14:30:00' => '02:30 PM',
    '15:00:00' => '03:00 PM',
    '15:30:00' => '03:30 PM',
    '16:00:00' => '04:00 PM',
    '16:30:00' => '04:30 PM'
];

$slots = [];
foreach ($all_slots as $value => $label) {
    $slots[] = [
        'value' => $value,
        'label' => $label,
        'available' => !in_array($value, $booked_times)
    ];
}

echo json_encode(['success' => true, 'slots' => $slots]);
?>