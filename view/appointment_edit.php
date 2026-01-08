<?php
require_once('../controller/adminCheck.php');
require_once('../model/appointmentModel.php');
require_once('../model/patientModel.php');
require_once('../model/doctorModel.php');
require_once('../model/userModel.php');
$appointment_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$appointment = getAppointmentById($appointment_id);
if (!$appointment) {
    header('location: appointment_list.php');
    exit;
}
$patients = getAllPatients();
$doctors = getAllDoctors();
$current_patient = getPatientById($appointment['patient_id']);
$current_patient_user = $current_patient ? getUserById($current_patient['user_id']) : null;

$current_doctor = getDoctorById($appointment['doctor_id']);
$current_doctor_user = $current_doctor ? getUserById($current_doctor['user_id']) : null;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Appointment - Hospital Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

    <div class="navbar">
        <span class="navbar-title">Hospital Management System</span>
        <a href="dashboard_admin.php" class="navbar-link">Dashboard</a>
        <a href="profile_view.php" class="navbar-link">My Profile</a>
        <a href="../controller/logout.php" class="navbar-link">Logout</a>
    </div>

    <!-- Edit Appointment Form -->
    <div class="main-container">
        <h2>Edit Appointment</h2>

        <form method="POST" action="../controller/edit_appointment.php" onsubmit="return validateForm(this)">
            <input type="hidden" name="appointment_id" value="<?php echo $appointment['id']; ?>">

            <fieldset>
                <legend>Appointment Details</legend>
                <table cellpadding="8" width="100%">
                    <tr>
                        <td>Patient:</td>
                        <td>
                            <select name="patient_id" required onchange="validateSelectBlur(this, 'Patient')">
                                <?php foreach ($patients as $p): ?>
                                    <?php $p_user = getUserById($p['user_id']); ?>
                                    <option value="<?php echo $p['id']; ?>" <?php echo $p['id'] == $appointment['patient_id'] ? 'selected' : ''; ?>>
                                        <?php echo $p_user['full_name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Doctor:</td>
                        <td>
                            <select name="doctor_id" required onchange="validateSelectBlur(this, 'Doctor')">
                                <?php foreach ($doctors as $d): ?>
                                    <?php $d_user = getUserById($d['user_id']); ?>
                                    <option value="<?php echo $d['id']; ?>" <?php echo $d['id'] == $appointment['doctor_id'] ? 'selected' : ''; ?>>
                                        <?php echo $d_user['full_name']; ?> - <?php echo $d['specialization']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Date:</td>
                        <td><input type="date" name="appointment_date"
                                value="<?php echo $appointment['appointment_date']; ?>" required
                                onchange="validateFutureDateBlur(this, 'Appointment Date')"></td>
                    </tr>
                    <tr>
                        <td>Time:</td>
                        <td>
                            <select name="appointment_time" required onchange="validateSelectBlur(this, 'Time')">
                                <option value="09:00:00" <?php echo $appointment['appointment_time'] == '09:00:00' ? 'selected' : ''; ?>>09:00 AM</option>
                                <option value="09:30:00" <?php echo $appointment['appointment_time'] == '09:30:00' ? 'selected' : ''; ?>>09:30 AM</option>
                                <option value="10:00:00" <?php echo $appointment['appointment_time'] == '10:00:00' ? 'selected' : ''; ?>>10:00 AM</option>
                                <option value="10:30:00" <?php echo $appointment['appointment_time'] == '10:30:00' ? 'selected' : ''; ?>>10:30 AM</option>
                                <option value="11:00:00" <?php echo $appointment['appointment_time'] == '11:00:00' ? 'selected' : ''; ?>>11:00 AM</option>
                                <option value="11:30:00" <?php echo $appointment['appointment_time'] == '11:30:00' ? 'selected' : ''; ?>>11:30 AM</option>
                                <option value="12:00:00" <?php echo $appointment['appointment_time'] == '12:00:00' ? 'selected' : ''; ?>>12:00 PM</option>
                                <option value="14:00:00" <?php echo $appointment['appointment_time'] == '14:00:00' ? 'selected' : ''; ?>>02:00 PM</option>
                                <option value="14:30:00" <?php echo $appointment['appointment_time'] == '14:30:00' ? 'selected' : ''; ?>>02:30 PM</option>
                                <option value="15:00:00" <?php echo $appointment['appointment_time'] == '15:00:00' ? 'selected' : ''; ?>>03:00 PM</option>
                                <option value="15:30:00" <?php echo $appointment['appointment_time'] == '15:30:00' ? 'selected' : ''; ?>>03:30 PM</option>
                                <option value="16:00:00" <?php echo $appointment['appointment_time'] == '16:00:00' ? 'selected' : ''; ?>>04:00 PM</option>
                                <option value="16:30:00" <?php echo $appointment['appointment_time'] == '16:30:00' ? 'selected' : ''; ?>>04:30 PM</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Status:</td>
                        <td>
                            <select name="status" required onchange="validateSelectBlur(this, 'Status')">
                                <option value="pending" <?php echo $appointment['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="confirmed" <?php echo $appointment['status'] == 'confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                                <option value="completed" <?php echo $appointment['status'] == 'completed' ? 'selected' : ''; ?>>Completed</option>
                                <option value="cancelled" <?php echo $appointment['status'] == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                            </select>
                        </td>
                    </tr>
                </table>
            </fieldset>

            <br>

            <fieldset>
                <legend>Reason & Notes</legend>
                <table cellpadding="8" width="100%">
                    <tr>
                        <td>Reason:</td>
                        <td><textarea name="reason" rows="3" cols="50"><?php echo $appointment['reason']; ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Notes:</td>
                        <td><textarea name="notes" rows="3" cols="50"><?php echo $appointment['notes']; ?></textarea>
                        </td>
                    </tr>
                </table>
            </fieldset>

            <br>

            <div>
                <input type="submit" name="submit" value="Update Appointment">
                <a href="appointment_view.php?id=<?php echo $appointment['id']; ?>"><button
                        type="button">Cancel</button></a>
            </div>
        </form>
    </div>
    <script src="../assets/js/validation-common.js"></script>
</body>

</html>