<?php
require_once('../controller/doctorCheck.php');
require_once('../model/appointmentModel.php');
require_once('../model/patientModel.php');
require_once('../model/doctorModel.php');
require_once('../model/userModel.php');

$user_id = $_SESSION['user_id'];

// Get doctor for current user
$doctor = getDoctorByUserId($user_id);

// Fetch all appointments for this doctor
$appointments = $doctor ? getAppointmentsByDoctor($doctor['id']) : [];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>My Schedule - Hospital Management System</title>
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

    <!-- Schedule List -->
    <div class="main-container">
        <h2>My Appointment Schedule</h2>

        <!-- Filter -->
        <fieldset>
            <legend>Filter</legend>
            <form method="GET" action="">
                <table>
                    <tr>
                        <td>
                            Date: <input type="date" name="date" value="">
                        </td>
                        <td>
                            Status:
                            <select name="status">
                                <option value="">All</option>
                                <option value="pending">Pending</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
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
                    <th>Date</th>
                    <th>Time</th>
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
                            <td><?php echo $appointment['id']; ?></td>
                            <td><?php echo $patient_user ? $patient_user['full_name'] : 'N/A'; ?></td>
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
                            <td>
                                <a href="appointment_view.php?id=<?php echo $appointment['id']; ?>"><button>View</button></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" align="center">No appointments scheduled</td>
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