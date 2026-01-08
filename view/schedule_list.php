<?php
require_once('../controller/sessionCheck.php');
require_once('../model/appointmentModel.php');
require_once('../model/patientModel.php');
require_once('../model/doctorModel.php');
require_once('../model/userModel.php');

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

if ($role != 'doctor' && $role != 'admin') {
    header('location: dashboard_patient.php');
    exit;
}

$date_from = isset($_GET['date_from']) ? $_GET['date_from'] : '';
$date_to = isset($_GET['date_to']) ? $_GET['date_to'] : '';
$filter_status = isset($_GET['status']) ? $_GET['status'] : '';

if ($role == 'admin') {
    $appointments = getAllAppointments();
} else {
    $doctor = getDoctorByUserId($user_id);
    $appointments = $doctor ? getAppointmentsByDoctor($doctor['id']) : [];
}

$filtered = [];
foreach ($appointments as $apt) {
    if ($date_from && $apt['appointment_date'] < $date_from)
        continue;
    if ($date_to && $apt['appointment_date'] > $date_to)
        continue;
    if ($filter_status && $apt['status'] != $filter_status)
        continue;
    $filtered[] = $apt;
}
$appointments = $filtered;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Appointment Schedule - Hospital Management System</title>
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

    <!-- Schedule List -->
    <div class="main-container">
        <h2>Appointment Schedule</h2>


        <div class="no-print">
            <a href="schedule_today.php"><button>Today's Schedule</button></a>
            <button onclick="window.print();">Print Schedule</button>
        </div>

        <br>

        <!-- Filter -->
        <fieldset class="no-print">
            <legend>Filter</legend>
            <form method="GET" action="">
                <table>
                    <tr>
                        <td>
                            From: <input type="date" name="date_from" value="<?php echo $date_from; ?>">
                        </td>
                        <td>
                            To: <input type="date" name="date_to" value="<?php echo $date_to; ?>">
                        </td>
                        <td>
                            Status:
                            <select name="status">
                                <option value="">All</option>
                                <option value="pending" <?php echo $filter_status == 'pending' ? 'selected' : ''; ?>>
                                    Pending</option>
                                <option value="confirmed" <?php echo $filter_status == 'confirmed' ? 'selected' : ''; ?>>
                                    Confirmed</option>
                                <option value="completed" <?php echo $filter_status == 'completed' ? 'selected' : ''; ?>>
                                    Completed</option>
                                <option value="cancelled" <?php echo $filter_status == 'cancelled' ? 'selected' : ''; ?>>
                                    Cancelled</option>
                            </select>
                        </td>
                        <td>
                            <input type="submit" value="Filter">
                        </td>
                    </tr>
                </table>
            </form>
        </fieldset>

        <br>

        <!-- Schedule Table -->
        <fieldset>
            <legend>All Appointments</legend>
            <table border="1" cellpadding="8" width="100%">
                <tr>
                    <th>ID</th>
                    <th>Patient Name</th>
                    <?php if ($role == 'admin'): ?>
                        <th>Doctor Name</th>
                    <?php endif; ?>
                    <th>Date</th>
                    <th>Time</th>
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
                            <td><?php echo $appointment['id']; ?></td>
                            <td><?php echo $patient_user ? $patient_user['full_name'] : 'N/A'; ?></td>
                            <?php if ($role == 'admin'): ?>
                                <td><?php echo $doctor_user ? $doctor_user['full_name'] : 'N/A'; ?></td>
                            <?php endif; ?>
                            <td><?php echo $appointment['appointment_date']; ?></td>
                            <td><?php echo $appointment['appointment_time']; ?></td>
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
                        <td colspan="<?php echo $role == 'admin' ? '8' : '7'; ?>" align="center">No appointments scheduled
                        </td>
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