<<<<<<< Updated upstream:view/prescription_view.html
=======
<?php
require_once('../controller/sessionCheck.php');
require_once('../model/prescriptionModel.php');
require_once('../model/patientModel.php');
require_once('../model/doctorModel.php');
require_once('../model/userModel.php');

$role = $_SESSION['role'];

// Get prescription ID from URL
$prescription_id = isset($_GET['id']) ? $_GET['id'] : 0;

// Fetch prescription data
$prescription = getPrescriptionById($prescription_id);
if (!$prescription) {
    header('location: prescription_list.php');
    exit;
}

// Fetch patient and doctor data
$patient = getPatientById($prescription['patient_id']);
$patient_user = $patient ? getUserById($patient['user_id']) : null;

$doctor = getDoctorById($prescription['doctor_id']);
$doctor_user = $doctor ? getUserById($doctor['user_id']) : null;

// Fetch medicines for this prescription
$medicines = getPrescriptionMedicines($prescription_id);
?>
>>>>>>> Stashed changes:view/prescription_view.php
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Prescription Details - Hospital Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <!-- Navbar -->
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

    <!-- Prescription Details -->
    <div class="main-container">
        <h2>Prescription Details</h2>

        <div>
            <a href="prescription_list.php"><button>Back to List</button></a>
            <?php if ($role == 'admin'): ?>
                <a href="../controller/delete_prescription.php?id=<?php echo $prescription['id']; ?>"
                    onclick="return confirm('Are you sure?');"><button>Delete</button></a>
            <?php endif; ?>
            <button onclick="window.print();">Print</button>
        </div>

<<<<<<< Updated upstream:view/prescription_view.html
        <div>
            <a href="prescription_list.html" class="button">Back to List</a>
            <button class="button" onclick="window.print()">🖨️ Print Prescription</button>
            <button class="button">Download PDF</button>
=======
        <br>
>>>>>>> Stashed changes:view/prescription_view.php

        <fieldset>
            <legend>Prescription Information</legend>
            <table cellpadding="8" width="100%">
                <tr>
                    <td width="20%"><b>Prescription ID:</b></td>
                    <td><?php echo $prescription['id']; ?></td>
                </tr>
                <tr>
                    <td><b>Date:</b></td>
                    <td><?php echo $prescription['created_date']; ?></td>
                </tr>
                <tr>
                    <td><b>Follow-up Date:</b></td>
                    <td><?php echo $prescription['follow_up_date'] ? $prescription['follow_up_date'] : 'Not scheduled'; ?>
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
                    <td><b>Patient ID:</b></td>
                    <td><?php echo $prescription['patient_id']; ?></td>
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
            <legend>Diagnosis</legend>
            <p><?php echo nl2br($prescription['diagnosis']); ?></p>
        </fieldset>

        <br>

        <fieldset>
            <legend>Prescribed Medicines</legend>
            <?php if (count($medicines) > 0): ?>
                <table border="1" cellpadding="8" width="100%">
                    <tr>
                        <th>Medicine Name</th>
                        <th>Dosage</th>
                        <th>Frequency</th>
                        <th>Duration</th>
                    </tr>
                    <?php foreach ($medicines as $medicine): ?>
                        <tr>
                            <td><?php echo $medicine['medicine_name']; ?></td>
                            <td><?php echo $medicine['dosage']; ?></td>
                            <td><?php echo $medicine['frequency']; ?></td>
                            <td><?php echo $medicine['duration']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else: ?>
                <p>No medicines prescribed.</p>
            <?php endif; ?>
        </fieldset>

        <br>

        <fieldset>
            <legend>Instructions</legend>
            <p><?php echo $prescription['instructions'] ? nl2br($prescription['instructions']) : 'No special instructions.'; ?>
            </p>
        </fieldset>
    </div>
</body>

</html>