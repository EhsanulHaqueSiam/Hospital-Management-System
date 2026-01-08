<?php
require_once('../controller/sessionCheck.php');
require_once('../model/prescriptionModel.php');
require_once('../model/patientModel.php');
require_once('../model/doctorModel.php');
require_once('../model/userModel.php');

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];
$prescription_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$prescription = getPrescriptionById($prescription_id);
if (!$prescription) {
    header('location: prescription_list.php');
    exit;
}
$canEdit = false;
if ($role == 'admin') {
    $canEdit = true;
} elseif ($role == 'doctor') {
    $current_doctor = getDoctorByUserId($user_id);
    if ($current_doctor && $current_doctor['id'] == $prescription['doctor_id']) {
        $canEdit = true;
    }
}

if (!$canEdit) {
    header('location: prescription_list.php');
    exit;
}
$patient = getPatientById($prescription['patient_id']);
$patient_user = $patient ? getUserById($patient['user_id']) : null;

$doctor = getDoctorById($prescription['doctor_id']);
$doctor_user = $doctor ? getUserById($doctor['user_id']) : null;
$patients = getAllPatients();
$medicines = getPrescriptionMedicines($prescription_id);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Prescription - Hospital Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <!-- Navbar -->
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

    <!-- Edit Prescription Form -->
    <div class="main-container">
        <h2>Edit Prescription</h2>

        <div>
            <a href="prescription_list.php"><button type="button">Back to List</button></a>
            <a href="prescription_view.php?id=<?php echo $prescription['id']; ?>"><button type="button">View
                    Details</button></a>
        </div>

        <br>

        <form method="POST" action="../controller/edit_prescription.php" onsubmit="return validateForm(this)">
            <input type="hidden" name="prescription_id" value="<?php echo $prescription['id']; ?>">
            <input type="hidden" name="doctor_id" value="<?php echo $prescription['doctor_id']; ?>">

            <fieldset>
                <legend>Patient Information</legend>
                <table cellpadding="8" width="100%">
                    <tr>
                        <td>Patient:</td>
                        <td>
                            <select name="patient_id" required onchange="validateSelectBlur(this, 'Patient')">
                                <option value="">-- Select Patient --</option>
                                <?php foreach ($patients as $p): ?>
                                    <?php $p_user = getUserById($p['user_id']); ?>
                                    <option value="<?php echo $p['id']; ?>" <?php echo ($p['id'] == $prescription['patient_id']) ? 'selected' : ''; ?>>
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
                                onblur="validateRequiredBlur(this, 'Diagnosis')"><?php echo htmlspecialchars($prescription['diagnosis']); ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Instructions:</td>
                        <td><textarea name="instructions" rows="4"
                                cols="50"><?php echo htmlspecialchars($prescription['instructions']); ?></textarea></td>
                    </tr>
                    <tr>
                        <td>Follow-up Date:</td>
                        <td><input type="date" name="follow_up_date"
                                value="<?php echo $prescription['follow_up_date']; ?>"></td>
                    </tr>
                </table>
            </fieldset>

            <br>

            <fieldset>
                <legend>Medicines</legend>
                <p><i>Update medicines for this prescription:</i></p>

                <div id="medicines-container">
                    <table cellpadding="5" border="1" width="100%">
                        <tr>
                            <th>Medicine Name</th>
                            <th>Dosage</th>
                            <th>Frequency</th>
                            <th>Duration</th>
                        </tr>
                        <?php
                        $medicine_count = count($medicines);
                        for ($i = 0; $i < 5; $i++):
                            $med = isset($medicines[$i]) ? $medicines[$i] : null;
                            ?>
                            <tr>
                                <td><input type="text" name="medicine_name[]"
                                        value="<?php echo $med ? htmlspecialchars($med['medicine_name']) : ''; ?>"></td>
                                <td><input type="text" name="dosage[]"
                                        value="<?php echo $med ? htmlspecialchars($med['dosage']) : ''; ?>"></td>
                                <td><input type="text" name="frequency[]"
                                        value="<?php echo $med ? htmlspecialchars($med['frequency']) : ''; ?>"></td>
                                <td><input type="text" name="duration[]"
                                        value="<?php echo $med ? htmlspecialchars($med['duration']) : ''; ?>"></td>
                            </tr>
                        <?php endfor; ?>
                    </table>
                </div>
            </fieldset>

            <br>

            <div>
                <input type="submit" name="submit" value="Update Prescription">
                <a href="prescription_view.php?id=<?php echo $prescription['id']; ?>"><button
                        type="button">Cancel</button></a>
            </div>
        </form>
    </div>
    <script src="../assets/js/validation-common.js"></script>
</body>

</html>