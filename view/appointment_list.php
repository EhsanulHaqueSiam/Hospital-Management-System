<?php
require_once('../controller/sessionCheck.php');
require_once('../model/appointmentModel.php');
require_once('../model/patientModel.php');
require_once('../model/doctorModel.php');
require_once('../model/userModel.php');

// Get user role to determine what to show
$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

// Fetch appointments based on role
if ($role == 'admin') {
    $appointments = getAllAppointments();
} elseif ($role == 'doctor') {
    require_once('../model/doctorModel.php');
    $doctor = getDoctorByUserId($user_id);
    $appointments = $doctor ? getAppointmentsByDoctor($doctor['id']) : [];
} else {
    require_once('../model/patientModel.php');
    $patient = getPatientByUserId($user_id);
    $appointments = $patient ? getAppointmentsByPatient($patient['id']) : [];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Appointment List - Hospital Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <!-- Navbar -->
    <div class="navbar">
        <span class="navbar-title">Hospital Management System</span>
        <?php if ($role == 'admin'): ?>
            <a href="dashboard_admin.php" class="navbar-link">Dashboard</a>
        <?php elseif ($role == 'doctor'): ?>
            <a href="dashboard_doctor.php" class="navbar-link">Dashboard</a>
        <?php else: ?>
            <a href="dashboard_patient.php" class="navbar-link">Dashboard</a>
        <?php endif; ?>
        <a href="profile_view.php" class="navbar-link">My Profile</a>
        <a href="../controller/logout.php" class="navbar-link">Logout</a>
    </div>

    <!-- Appointment List -->
    <div class="main-container">
        <h2>Appointment Management</h2>

        <!-- Actions -->
        <fieldset>
            <legend>Actions</legend>
            <table>
                <tr>
                    <td>
                        <form method="GET" action="">
                            Search: <input type="text" name="search" value="">
                            <select name="status">
                                <option value="">All Statuses</option>
                                <option value="pending">Pending</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                            <input type="submit" value="Filter">
                        </form>
                    </td>
                    <td>
                        <a href="appointment_add.php"><button type="button">Book Appointment</button></a>
                    </td>
                </tr>
            </table>
        </fieldset>

        <br>

        <!-- Appointment Table -->
        <fieldset>
            <legend>All Appointments</legend>
            <table border="1" cellpadding="8" width="100%">
                <tr>
                    <th>ID</th>
                    <th>Patient Name</th>
                    <th>Doctor Name</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                <?php if (count($appointments) > 0): ?>
                    <?php foreach ($appointments as $appointment): ?>
                        <?php
                        // Fetch patient and doctor info
                        $patient = getPatientById($appointment['patient_id']);
                        $patient_user = $patient ? getUserById($patient['user_id']) : null;

                        $doctor = getDoctorById($appointment['doctor_id']);
                        $doctor_user = $doctor ? getUserById($doctor['user_id']) : null;
                        ?>
                        <tr>
                            <td><?php echo $appointment['id']; ?></td>
                            <td><?php echo $patient_user ? $patient_user['full_name'] : 'N/A'; ?></td>
                            <td><?php echo $doctor_user ? $doctor_user['full_name'] : 'N/A'; ?></td>
                            <td><?php echo $appointment['appointment_date']; ?></td>
                            <td><?php echo $appointment['appointment_time']; ?></td>
                            <td><?php echo ucfirst($appointment['status']); ?></td>
                            <td>
                                <a href="appointment_view.php?id=<?php echo $appointment['id']; ?>"><button>View</button></a>
                                <?php if ($role == 'admin'): ?>
                                    <a href="appointment_edit.php?id=<?php echo $appointment['id']; ?>"><button>Edit</button></a>
                                    <a href="../controller/delete_appointment.php?id=<?php echo $appointment['id']; ?>"
                                        onclick="return confirm('Are you sure?');"><button>Delete</button></a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" align="center">No appointments found</td>
                    </tr>
                <?php endif; ?>
            </table>

            <br>

            <div class="pagination-container">
            </div>
        </fieldset>
    </div>
</body>

</html>