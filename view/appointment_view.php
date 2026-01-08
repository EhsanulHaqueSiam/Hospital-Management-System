<?php
require_once('../controller/sessionCheck.php');
require_once('../model/appointmentModel.php');
require_once('../model/patientModel.php');
require_once('../model/doctorModel.php');
require_once('../model/userModel.php');

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];
$appointment_id = isset($_GET['id']) ? $_GET['id'] : 0;
$appointment = getAppointmentById($appointment_id);
if (!$appointment) {
    header('location: appointment_list.php');
    exit;
}
$patient = getPatientById($appointment['patient_id']);
$patient_user = $patient ? getUserById($patient['user_id']) : null;

$doctor = getDoctorById($appointment['doctor_id']);
$doctor_user = $doctor ? getUserById($doctor['user_id']) : null;
$canCancel = false;
if ($role == 'patient') {
    $current_patient = getPatientByUserId($user_id);
    if ($current_patient && $current_patient['id'] == $appointment['patient_id']) {
        $canCancel = true;
    }
}
$canAddPrescription = false;
if ($role == 'doctor') {
    $current_doctor = getDoctorByUserId($user_id);
    if ($current_doctor && $current_doctor['id'] == $appointment['doctor_id']) {
        $canAddPrescription = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Appointment Details - Hospital Management System</title>
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

    <!-- Appointment Details -->
    <div class="main-container">
        <h2>Appointment Details</h2>

        <div>
            <a href="appointment_list.php"><button>Back to List</button></a>

            <?php if ($role == 'admin'): ?>
                <a href="appointment_edit.php?id=<?php echo $appointment['id']; ?>"><button>Edit</button></a>
                <a href="../controller/delete_appointment.php?id=<?php echo $appointment['id']; ?>"
                    onclick="return confirm('Are you sure?');"><button>Delete</button></a>
            <?php endif; ?>

            <?php if ($canCancel && in_array($appointment['status'], ['pending', 'confirmed'])): ?>
                <a href="../controller/cancel_appointment.php?id=<?php echo $appointment['id']; ?>"
                    onclick="return confirm('Are you sure you want to cancel this appointment?');"><button>Cancel
                        Appointment</button></a>
            <?php endif; ?>

            <?php if ($canAddPrescription && in_array($appointment['status'], ['confirmed', 'completed'])): ?>
                <a
                    href="prescription_add.php?appointment_id=<?php echo $appointment['id']; ?>&patient_id=<?php echo $appointment['patient_id']; ?>"><button>Add
                        Prescription</button></a>
            <?php endif; ?>
        </div>

        <br>

        <fieldset>
            <legend>Appointment Information</legend>
            <table cellpadding="8" width="100%">
                <tr>
                    <td width="20%"><b>Appointment ID:</b></td>
                    <td><?php echo $appointment['id']; ?></td>
                </tr>
                <tr>
                    <td><b>Date:</b></td>
                    <td><?php echo $appointment['appointment_date']; ?></td>
                </tr>
                <tr>
                    <td><b>Time:</b></td>
                    <td><?php echo $appointment['appointment_time']; ?></td>
                </tr>
                <tr>
                    <td><b>Status:</b></td>
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
                </tr>
            </table>
        </fieldset>

        <br>

        <fieldset>
            <legend>Patient Information</legend>
            <table cellpadding="8" width="100%">
                <tr>
                    <td width="20%"><b>Patient Name:</b></td>
                    <td><?php echo $patient_user ? $patient_user['full_name'] : 'N/A'; ?></td>
                </tr>
                <tr>
                    <td><b>Phone:</b></td>
                    <td><?php echo $patient_user ? $patient_user['phone'] : 'N/A'; ?></td>
                </tr>
                <tr>
                    <td><b>Email:</b></td>
                    <td><?php echo $patient_user ? $patient_user['email'] : 'N/A'; ?></td>
                </tr>
            </table>
        </fieldset>

        <br>

        <fieldset>
            <legend>Doctor Information</legend>
            <table cellpadding="8" width="100%">
                <tr>
                    <td width="20%"><b>Doctor Name:</b></td>
                    <td><?php echo $doctor_user ? $doctor_user['full_name'] : 'N/A'; ?></td>
                </tr>
                <tr>
                    <td><b>Specialization:</b></td>
                    <td><?php echo $doctor ? $doctor['specialization'] : 'N/A'; ?></td>
                </tr>
            </table>
        </fieldset>

        <br>

        <fieldset>
            <legend>Reason & Notes</legend>
            <table cellpadding="8" width="100%">
                <tr>
                    <td width="20%"><b>Reason:</b></td>
                    <td><?php echo $appointment['reason'] ? $appointment['reason'] : 'Not specified'; ?></td>
                </tr>
                <tr>
                    <td><b>Notes:</b></td>
                    <td><?php echo $appointment['notes'] ? $appointment['notes'] : 'No notes'; ?></td>
                </tr>
            </table>
        </fieldset>

        <?php if ($role == 'doctor' || $role == 'admin'): ?>
            <br>
            <fieldset>
                <legend>Update Status</legend>
                <form method="POST" action="../controller/update_appointment_status.php"
                    onsubmit="return validateForm(this)">
                    <input type="hidden" name="appointment_id" value="<?php echo $appointment['id']; ?>">
                    <select name="status" required onchange="validateSelectBlur(this, 'Status')">
                        <option value="pending" <?php echo $appointment['status'] == 'pending' ? 'selected' : ''; ?>>Pending
                        </option>
                        <option value="confirmed" <?php echo $appointment['status'] == 'confirmed' ? 'selected' : ''; ?>>
                            Confirmed</option>
                        <option value="completed" <?php echo $appointment['status'] == 'completed' ? 'selected' : ''; ?>>
                            Completed</option>
                        <option value="cancelled" <?php echo $appointment['status'] == 'cancelled' ? 'selected' : ''; ?>>
                            Cancelled</option>
                    </select>
                    <input type="submit" name="submit" value="Update Status">
                </form>
            </fieldset>
        <?php endif; ?>
    </div>
    <script src="../assets/js/validation-common.js"></script>
</body>

</html>