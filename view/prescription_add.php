<?php
require_once('../controller/sessionCheck.php');
require_once('../model/patientModel.php');
require_once('../model/doctorModel.php');
require_once('../model/userModel.php');
require_once('../model/appointmentModel.php');
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'doctor' && $_SESSION['role'] !== 'admin')) {
    header('location: ../view/auth_signin.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];
$current_doctor = null;
if ($role == 'doctor') {
    $current_doctor = getDoctorByUserId($user_id);
}
$patients = getAllPatients();
$doctors = getAllDoctors();
$selected_patient_id = isset($_GET['patient_id']) ? $_GET['patient_id'] : '';
$selected_appointment_id = isset($_GET['appointment_id']) ? $_GET['appointment_id'] : '';
$selected_appointment = null;
if ($selected_appointment_id) {
    $selected_appointment = getAppointmentById($selected_appointment_id);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Create Prescription - Hospital Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
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

    <!-- Create Prescription Form -->
    <div class="main-container">
        <h2>Create New Prescription</h2>

        <?php if ($selected_appointment): ?>
            <fieldset>
                <legend>Linked Appointment</legend>
                <p>This prescription is linked to Appointment #<?php echo $selected_appointment['id']; ?>
                    dated <?php echo $selected_appointment['appointment_date']; ?></p>
            </fieldset>
            <br>
        <?php endif; ?>

        <form method="POST" action="../controller/add_prescription.php" onsubmit="return validateForm(this)">
            <input type="hidden" name="appointment_id" value="<?php echo $selected_appointment_id; ?>">

            <fieldset>
                <legend>Prescription Details</legend>
                <table cellpadding="8" width="100%">
                    <!-- Doctor Selection (Admin Only) or Hidden (Doctor) -->
                    <?php if ($role == 'admin'): ?>
                        <tr>
                            <td>Doctor:</td>
                            <td>
                                <select name="doctor_id" required onchange="validateSelectBlur(this, 'Doctor')">
                                    <option value="">-- Select Doctor --</option>
                                    <?php foreach ($doctors as $d): ?>
                                        <?php $d_user = getUserById($d['user_id']); ?>
                                        <option value="<?php echo $d['id']; ?>">
                                            <?php echo $d_user['full_name']; ?> - <?php echo $d['specialization']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                        </tr>
                    <?php else: ?>
                        <input type="hidden" name="doctor_id" value="<?php echo $current_doctor['id']; ?>">
                    <?php endif; ?>

                    <tr>
                        <td>Patient:</td>
                        <td>
                            <select name="patient_id" required onchange="validateSelectBlur(this, 'Patient')">
                                <option value="">-- Select Patient --</option>
                                <?php foreach ($patients as $p): ?>
                                    <?php $p_user = getUserById($p['user_id']); ?>
                                    <option value="<?php echo $p['id']; ?>" <?php echo ($p['id'] == $selected_patient_id) ? 'selected' : ''; ?>>
                                        <?php echo $p_user['full_name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                </table>
            </fieldset>

            <br>

            <fieldset>
                <legend>Diagnosis & Instructions</legend>
                <table cellpadding="8" width="100%">
                    <tr>
                        <td>Diagnosis:</td>
                        <td><textarea name="diagnosis" rows="3" cols="50" required
                                onblur="validateRequiredBlur(this, 'Diagnosis')"></textarea></td>
                    </tr>
                    <tr>
                        <td>Instructions:</td>
                        <td><textarea name="instructions" rows="4" cols="50"
                                placeholder="General instructions for the patient"></textarea></td>
                    </tr>
                    <tr>
                        <td>Follow-up Date:</td>
                        <td><input type="date" name="follow_up_date"></td>
                    </tr>
                </table>
            </fieldset>

            <br>

            <fieldset>
                <legend>Medicines</legend>
                <p><i>Add medicines to this prescription:</i></p>

                <div id="medicines-container">
                    <table cellpadding="5" border="1" width="100%">
                        <tr>
                            <th>Medicine Name</th>
                            <th>Dosage</th>
                            <th>Frequency</th>
                            <th>Duration</th>
                        </tr>
                        <tr>
                            <td><input type="text" name="medicine_name[]" placeholder="e.g., Paracetamol 500mg"></td>
                            <td><input type="text" name="dosage[]" placeholder="e.g., 1 tablet"></td>
                            <td><input type="text" name="frequency[]" placeholder="e.g., 3 times daily"></td>
                            <td><input type="text" name="duration[]" placeholder="e.g., 7 days"></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="medicine_name[]" placeholder=""></td>
                            <td><input type="text" name="dosage[]" placeholder=""></td>
                            <td><input type="text" name="frequency[]" placeholder=""></td>
                            <td><input type="text" name="duration[]" placeholder=""></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="medicine_name[]" placeholder=""></td>
                            <td><input type="text" name="dosage[]" placeholder=""></td>
                            <td><input type="text" name="frequency[]" placeholder=""></td>
                            <td><input type="text" name="duration[]" placeholder=""></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="medicine_name[]" placeholder=""></td>
                            <td><input type="text" name="dosage[]" placeholder=""></td>
                            <td><input type="text" name="frequency[]" placeholder=""></td>
                            <td><input type="text" name="duration[]" placeholder=""></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="medicine_name[]" placeholder=""></td>
                            <td><input type="text" name="dosage[]" placeholder=""></td>
                            <td><input type="text" name="frequency[]" placeholder=""></td>
                            <td><input type="text" name="duration[]" placeholder=""></td>
                        </tr>
                    </table>
                </div>
            </fieldset>

            <br>

            <div>
                <input type="submit" name="submit" value="Create Prescription">
                <a href="prescription_list.php"><button type="button">Cancel</button></a>
            </div>
        </form>
    </div>
    <script src="../assets/js/validation-common.js"></script>
</body>

</html>