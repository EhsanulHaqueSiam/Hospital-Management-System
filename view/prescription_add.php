<?php
require_once('../controller/doctorCheck.php');
require_once('../model/patientModel.php');
require_once('../model/doctorModel.php');
require_once('../model/userModel.php');
require_once('../model/appointmentModel.php');

$user_id = $_SESSION['user_id'];

// Get doctor for current user
$doctor = getDoctorByUserId($user_id);

// Fetch all patients for dropdown
$patients = getAllPatients();

// Check if coming from an appointment
$selected_patient_id = isset($_GET['patient_id']) ? $_GET['patient_id'] : '';
$selected_appointment_id = isset($_GET['appointment_id']) ? $_GET['appointment_id'] : '';

// If appointment_id provided then fetch appointment details
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
        <a href="dashboard_doctor.php" class="navbar-link">Dashboard</a>
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

        <form method="POST" action="../controller/add_prescription.php">
            <input type="hidden" name="doctor_id" value="<?php echo $doctor['id']; ?>">
            <input type="hidden" name="appointment_id" value="<?php echo $selected_appointment_id; ?>">

            <fieldset>
                <legend>Patient Information</legend>
                <table cellpadding="8" width="100%">
                    <tr>
                        <td>Patient:</td>
                        <td>
                            <select name="patient_id" required>
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
                        <td><textarea name="diagnosis" rows="3" cols="50" required></textarea></td>
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
</body>

</html>