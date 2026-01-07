<?php
require_once('../controller/doctorCheck.php');
require_once('../model/doctorModel.php');
require_once('../model/appointmentModel.php');

// Get logged-in doctor's info
$doctor = getDoctorByUserId($_SESSION['user_id']);

if ($doctor) {
    // Get appointments for this doctor
    $appointments = getAppointmentsByDoctor($doctor['id']);
} else {
    $appointments = array();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Doctor Dashboard - Hospital Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <!-- Navbar -->
    <div class="navbar">
        <span class="navbar-title">Hospital Management System</span>
        <a href="dashboard_doctor.php" class="navbar-link">Dashboard</a>
        <a href="profile_view.php" class="navbar-link">My Profile</a>
        <a href="../controller/logout.php" class="navbar-link">Logout</a>
    </div>

    <!-- Dashboard Content -->
    <div class="main-container">
        <h2>Doctor Dashboard</h2>
        <p>Welcome, Dr. <?php echo $_SESSION['username']; ?></p>

        <!-- Stats -->
        <fieldset>
            <legend>Your Statistics</legend>
            <table border="1" cellpadding="10">
                <tr>
                    <td align="center"><b>Total Appointments</b><br><br><?php echo count($appointments); ?></td>
                    <td align="center">
                        <b>Specialization</b><br><br><?php echo $doctor ? $doctor['specialization'] : 'N/A'; ?>
                    </td>
                </tr>
            </table>
        </fieldset>

        <br>

        <!-- Quick Links -->
        <fieldset>
            <legend>Quick Actions</legend>
            <a href="schedule_today.php"><button>Today's Schedule</button></a>
            <a href="schedule_list.php"><button>View Full Schedule</button></a>
            <a href="appointment_list.php"><button>My Appointments</button></a>
            <a href="patient_list.php"><button>View Patients</button></a>
            <a href="prescription_list.php"><button>My Prescriptions</button></a>
            <a href="prescription_add.php"><button>Create Prescription</button></a>
            <a href="record_list.php"><button>Medical Records</button></a>
        </fieldset>

        <br>
        <fieldset>
            <legend>Your Appointments</legend>
            <table border="1" cellpadding="8" width="100%">
                <tr>
                    <th>ID</th>
                    <th>Patient Name</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Reason</th>
                    <th>Status</th>
                </tr>
                <?php if (count($appointments) > 0): ?>
                    <?php
                    require_once('../model/patientModel.php');
                    require_once('../model/userModel.php');
                    foreach (array_slice($appointments, 0, 10) as $appointment):
                        $patient = getPatientById($appointment['patient_id']);
                        $patient_user = $patient ? getUserById($patient['user_id']) : null;
                        ?>
                        <tr>
                            <td><?php echo $appointment['id']; ?></td>
                            <td><?php echo $patient_user ? $patient_user['full_name'] : 'Patient #' . $appointment['patient_id']; ?>
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