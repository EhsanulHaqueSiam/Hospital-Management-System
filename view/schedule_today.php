<?php
require_once('../controller/doctorCheck.php');
require_once('../model/appointmentModel.php');
require_once('../model/patientModel.php');
require_once('../model/doctorModel.php');
require_once('../model/userModel.php');

$user_id = $_SESSION['user_id'];

// Get doctor for current user
$doctor = getDoctorByUserId($user_id);

// Get today's date
$today = date('Y-m-d');

// Fetch all appointments for this doctor today
$all_appointments = $doctor ? getAppointmentsByDoctor($doctor['id']) : [];

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
</head>

<body>
    <!-- Navbar -->
    <div class="navbar">
        <span class="navbar-title">Hospital Management System</span>
        <a href="dashboard_doctor.php" class="navbar-link">Dashboard</a>
        <a href="profile_view.php" class="navbar-link">My Profile</a>
        <a href="../controller/logout.php" class="navbar-link">Logout</a>
    </div>

    <!-- Today's Schedule -->
    <div class="main-container">
        <h2>Today's Schedule (<?php echo date('F j, Y'); ?>)</h2>

        <div>
            <a href="schedule_list.php"><button>View Full Schedule</button></a>
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
                    <th>Reason</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                <?php if (count($appointments) > 0): ?>
                    <?php foreach ($appointments as $appointment): ?>
                        <?php
                        $patient = getPatientById($appointment['patient_id']);
                        $patient_user = $patient ? getUserById($patient['user_id']) : null;
                        ?>
                        <tr>
                            <td><?php echo $appointment['appointment_time']; ?></td>
                            <td><?php echo $patient_user ? $patient_user['full_name'] : 'N/A'; ?></td>
                            <td><?php echo $patient_user ? $patient_user['phone'] : 'N/A'; ?></td>
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
                            <td>
                                <a href="appointment_view.php?id=<?php echo $appointment['id']; ?>"><button>View</button></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" align="center">No appointments for today</td>
                    </tr>
                <?php endif; ?>
            </table>
        </fieldset>
    </div>
</body>

</html>