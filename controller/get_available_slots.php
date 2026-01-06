<?php
session_start();
require_once('../model/appointmentModel.php');

// Check if logged in
if (!isset($_SESSION['user_id'])) {
    echo '<option value="">Please login</option>';
    exit;
}

$doctor_id = isset($_GET['doctor_id']) ? $_GET['doctor_id'] : 0;
$date = isset($_GET['date']) ? $_GET['date'] : '';

if (!$doctor_id || !$date) {
    echo '<option value="">-- Select Time --</option>';
    exit;
}

// Get all appointments for this doctor on this date
$appointments = getAppointmentsByDoctor($doctor_id);
$booked_times = [];

foreach ($appointments as $apt) {
    if ($apt['appointment_date'] == $date && $apt['status'] != 'cancelled') {
        $booked_times[] = $apt['appointment_time'];
    }
}

// Available time slots
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

echo '<option value="">-- Select Time --</option>';

foreach ($all_slots as $value => $label) {
    if (!in_array($value, $booked_times)) {
        echo '<option value="' . $value . '">' . $label . '</option>';
    } else {
        echo '<option value="' . $value . '" disabled>' . $label . ' (Booked)</option>';
    }
}
?>