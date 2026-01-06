<?php
require_once('../controller/sessionCheck.php');
require_once('../model/appointmentModel.php');
require_once('../model/patientModel.php');
require_once('../model/doctorModel.php');
require_once('../model/userModel.php');

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';

if ($role == 'admin') {
    $appointments = getAllAppointments();
} elseif ($role == 'doctor') {
    $doctor = getDoctorByUserId($user_id);
    $appointments = $doctor ? getAppointmentsByDoctor($doctor['id']) : [];
} else {
    $patient = getPatientByUserId($user_id);
    $appointments = $patient ? getAppointmentsByPatient($patient['id']) : [];
}

// Filter by status if selected
if ($status_filter != '') {
    $filtered = [];
    foreach ($appointments as $apt) {
        if ($apt['status'] == $status_filter) {
            $filtered[] = $apt;
        }
    }
    $appointments = $filtered;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Appointment List - Hospital Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
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

    <div class="main-container">
        <h2>Appointment Management</h2>

        <fieldset>
            <legend>Actions</legend>
            <table>
                <tr>
                    <td>
                        <form method="GET" action="">
                            Status:
                            <select name="status">
                                <option value="">All Statuses</option>
                                <option value="pending" <?php if ($status_filter == 'pending')
                                    echo 'selected'; ?>>Pending
                                </option>
                                <option value="confirmed" <?php if ($status_filter == 'confirmed')
                                    echo 'selected'; ?>>
                                    Confirmed</option>
                                <option value="completed" <?php if ($status_filter == 'completed')
                                    echo 'selected'; ?>>
                                    Completed</option>
                                <option value="cancelled" <?php if ($status_filter == 'cancelled')
                                    echo 'selected'; ?>>
                                    Cancelled</option>
                            </select>
                            <input type="submit" value="Filter">
                            <?php if ($status_filter != ''): ?>
                                <a href="appointment_list.php"><button type="button">Clear</button></a>
                            <?php endif; ?>
                        </form>
                    </td>
                    <?php if ($role == 'admin' || $role == 'patient'): ?>
                        <td>
                            <a href="appointment_add.php"><button type="button">Book Appointment</button></a>
                        </td>
                    <?php endif; ?>
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
                        $appt_patient = getPatientById($appointment['patient_id']);
                        $patient_user = $appt_patient ? getUserById($appt_patient['user_id']) : null;

                        $appt_doctor = getDoctorById($appointment['doctor_id']);
                        $doctor_user = $appt_doctor ? getUserById($appt_doctor['user_id']) : null;
                        ?>
                        <tr>
                            <td><?php echo $appointment['id']; ?></td>
                            <td><?php echo $patient_user ? $patient_user['full_name'] : 'N/A'; ?></td>
                            <td><?php echo $doctor_user ? $doctor_user['full_name'] : 'N/A'; ?></td>
                            <td><?php echo $appointment['appointment_date']; ?></td>
                            <td><?php echo $appointment['appointment_time']; ?></td>
                            <td>
                                <span style="font-weight: bold; color: 
                                    <?php
                                    switch ($appointment['status']) {
                                        case 'pending':
                                            echo 'orange';
                                            break;
                                        case 'confirmed':
                                            echo 'blue';
                                            break;
                                        case 'completed':
                                            echo 'green';
                                            break;
                                        case 'cancelled':
                                            echo 'red';
                                            break;
                                        default:
                                            echo 'black';
                                    }
                                    ?>;">
                                    <?php echo ucfirst($appointment['status']); ?>
                                </span>
                            </td>
                            <td>
                                <a href="appointment_view.php?id=<?php echo $appointment['id']; ?>"><button>View</button></a>

                                <?php if ($role == 'admin'): ?>
                                    <a href="appointment_edit.php?id=<?php echo $appointment['id']; ?>"><button>Edit</button></a>
                                    <a href="../controller/delete_appointment.php?id=<?php echo $appointment['id']; ?>"
                                        onclick="return confirm('Are you sure?');"><button>Delete</button></a>
                                <?php endif; ?>

                                <?php if ($role == 'patient' && in_array($appointment['status'], ['pending', 'confirmed'])): ?>
                                    <a href="../controller/cancel_appointment.php?id=<?php echo $appointment['id']; ?>"
                                        onclick="return confirm('Are you sure you want to cancel this appointment?');"><button>Cancel</button></a>
                                <?php endif; ?>

                                <?php if ($role == 'doctor' && in_array($appointment['status'], ['confirmed', 'completed'])): ?>
                                    <a
                                        href="prescription_add.php?appointment_id=<?php echo $appointment['id']; ?>&patient_id=<?php echo $appointment['patient_id']; ?>"><button>Add
                                            Prescription</button></a>
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