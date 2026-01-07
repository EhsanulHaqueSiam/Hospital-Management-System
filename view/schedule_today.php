<?php
require_once('../controller/sessionCheck.php');
require_once('../model/appointmentModel.php');
require_once('../model/patientModel.php');
require_once('../model/doctorModel.php');
require_once('../model/userModel.php');

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

// Only doctor and admin can access this page
if ($role != 'doctor' && $role != 'admin') {
    header('location: dashboard_patient.php');
    exit;
}

// Get today's date
$today = date('Y-m-d');

// Fetch appointments based on role
if ($role == 'admin') {
    $all_appointments = getAllAppointments();
} else {
    // Get doctor for current user
    $doctor = getDoctorByUserId($user_id);
    $all_appointments = $doctor ? getAppointmentsByDoctor($doctor['id']) : [];
}

// Filter for today's appointments
$appointments = [];
foreach ($all_appointments as $apt) {
    if ($apt['appointment_date'] == $today) {
        $appointments[] = $apt;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Today's Schedule - Hospital Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        @media print {

            .navbar,
            .no-print {
                display: none !important;
            }

            .main-container {
                margin: 0;
                padding: 20px;
            }
        }
    </style>
</head>

<body>

    <div class="navbar">
        <span class="navbar-title">Hospital Management System</span>
        <?php if ($role == 'admin'): ?>
            <a href="dashboard_admin.php" class="navbar-link">Dashboard</a>
        <?php else: ?>
            <a href="dashboard_doctor.php" class="navbar-link">Dashboard</a>
        <?php endif; ?>
        <a href="profile_view.php" class="navbar-link">My Profile</a>
        <a href="../controller/logout.php" class="navbar-link">Logout</a>
    </div>

    <!-- Today's Schedule -->
    <div class="main-container">
        <h2>Today's Schedule (<?php echo date('F j, Y'); ?>)</h2>

        <div class="no-print">
            <a href="schedule_list.php"><button>View Full Schedule</button></a>
            <button onclick="window.print();">Print Schedule</button>
        </div>

        <br>

        <!-- Today's Appointments Table -->
        <fieldset>
            <legend>Today's Appointments</legend>
            <table border="1" cellpadding="8" width="100%">
                <tr>
                    <th>Time</th>
                    <th>Patient Name</th>
                    <th>Phone</th>
                    <?php if ($role == 'admin'): ?>
                        <th>Doctor Name</th>
                    <?php endif; ?>
                    <th>Reason</th>
                    <th>Status</th>
                    <th class="no-print">Actions</th>
                </tr>
                <?php if (count($appointments) > 0): ?>
                    <?php foreach ($appointments as $appointment): ?>
                        <?php
                        $appt_patient = getPatientById($appointment['patient_id']);
                        $patient_user = $appt_patient ? getUserById($appt_patient['user_id']) : null;

                        if ($role == 'admin') {
                            $appt_doctor = getDoctorById($appointment['doctor_id']);
                            $doctor_user = $appt_doctor ? getUserById($appt_doctor['user_id']) : null;
                        }
                        ?>
                        <tr>
                            <td><?php echo $appointment['appointment_time']; ?></td>
                            <td><?php echo $patient_user ? $patient_user['full_name'] : 'N/A'; ?></td>
                            <td><?php echo $patient_user ? $patient_user['phone'] : 'N/A'; ?></td>
                            <?php if ($role == 'admin'): ?>
                                <td><?php echo $doctor_user ? $doctor_user['full_name'] : 'N/A'; ?></td>
                            <?php endif; ?>
                            <td><?php echo substr($appointment['reason'], 0, 30) . '...'; ?></td>
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
                            <td class="no-print">
                                <a href="appointment_view.php?id=<?php echo $appointment['id']; ?>"><button>View</button></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="<?php echo $role == 'admin' ? '7' : '6'; ?>" align="center">No appointments for today
                        </td>
                    </tr>
                <?php endif; ?>
            </table>
        </fieldset>
    </div>
</body>

</html>