<?php
require_once('../controller/patientCheck.php');
require_once('../model/patientModel.php');
require_once('../model/appointmentModel.php');

// Get logged-in patient's info
$patient = getPatientByUserId($_SESSION['user_id']);

if ($patient) {
    // Get appointments for this patient
    $appointments = getAppointmentsByPatient($patient['id']);
} else {
    $appointments = array();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Patient Dashboard - Hospital Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <!-- Navbar -->
    <div class="navbar">
        <span class="navbar-title">Hospital Management System</span>
        <a href="dashboard_patient.php" class="navbar-link">Dashboard</a>
        <a href="profile_view.php" class="navbar-link">My Profile</a>
        <a href="../controller/logout.php" class="navbar-link">Logout</a>
    </div>

    <!-- Dashboard Content -->
    <div class="main-container">
        <h2>Patient Dashboard</h2>
        <p>Welcome, <?php echo $_SESSION['username']; ?></p>

        <!-- Stats -->
        <fieldset>
            <legend>Your Statistics</legend>
            <table border="1" cellpadding="10">
                <tr>
                    <td align="center"><b>Upcoming Appointments</b><br><br><?php echo count($appointments); ?></td>
                    <td align="center"><b>Blood
                            Group</b><br><br><?php echo $patient ? $patient['blood_group'] : 'N/A'; ?></td>
                </tr>
            </table>
        </fieldset>

        <br>

        <!-- Appointment History -->
        <fieldset>
            <legend>Your Appointments</legend>
            <table border="1" cellpadding="8" width="100%">
                <tr>
                    <th>ID</th>
                    <th>Doctor Name</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Reason</th>
                    <th>Status</th>
                </tr>
                <?php if (count($appointments) > 0): ?>
                    <?php
                    require_once('../model/doctorModel.php');
                    require_once('../model/userModel.php');
                    foreach (array_slice($appointments, 0, 10) as $appointment):
                        $doctor = getDoctorById($appointment['doctor_id']);
                        $doctor_user = $doctor ? getUserById($doctor['user_id']) : null;
                        ?>
                        <tr>
                            <td><?php echo $appointment['id']; ?></td>
                            <td><?php echo $doctor_user ? 'Dr. ' . $doctor_user['full_name'] : 'Doctor #' . $appointment['doctor_id']; ?>
                            </td>
                            <td><?php echo $appointment['appointment_date']; ?></td>
                            <td><?php echo isset($appointment['appointment_time']) ? $appointment['appointment_time'] : 'N/A'; ?>
                            </td>
                            <td><?php echo $appointment['reason']; ?></td>
                            <td><?php echo $appointment['status']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" align="center">No appointments found</td>
                    </tr>
                <?php endif; ?>
            </table>
        </fieldset>
    </div>

    <script src="../assets/js/dashboard.js"></script>
</body>

</html>