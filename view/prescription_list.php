<?php
require_once('../controller/sessionCheck.php');
require_once('../model/prescriptionModel.php');
require_once('../model/patientModel.php');
require_once('../model/doctorModel.php');
require_once('../model/userModel.php');

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

// Get current doctor ID if role is doctor
$current_doctor_id = null;
if ($role == 'doctor') {
    $current_doctor = getDoctorByUserId($user_id);
    $current_doctor_id = $current_doctor ? $current_doctor['id'] : null;
}

// Fetch prescriptions based on role
if ($role == 'admin') {
    $prescriptions = getAllPrescriptions();
} elseif ($role == 'doctor') {
    $prescriptions = $current_doctor_id ? getPrescriptionsByDoctor($current_doctor_id) : [];
} else {
    $patient = getPatientByUserId($user_id);
    $prescriptions = $patient ? getPrescriptionsByPatient($patient['id']) : [];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Prescription List - Hospital Management System</title>
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

    <!-- Prescription List -->
    <div class="main-container">
        <h2>Prescription Management</h2>


        <fieldset>
            <legend>Actions</legend>
            <table>
                <tr>
                    <?php if ($role == 'doctor'): ?>
                        <td>
                            <a href="prescription_add.php"><button type="button">Create Prescription</button></a>
                        </td>
                    <?php endif; ?>
                </tr>
            </table>
        </fieldset>

        <br>

        <!-- Prescription Table -->
        <fieldset>
            <legend>All Prescriptions</legend>
            <table border="1" cellpadding="8" width="100%">
                <tr>
                    <th>ID</th>
                    <th>Patient Name</th>
                    <th>Doctor Name</th>
                    <th>Diagnosis</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
                <?php if (count($prescriptions) > 0): ?>
                    <?php foreach ($prescriptions as $prescription): ?>
                        <?php
                        $presc_patient = getPatientById($prescription['patient_id']);
                        $patient_user = $presc_patient ? getUserById($presc_patient['user_id']) : null;

                        $presc_doctor = getDoctorById($prescription['doctor_id']);
                        $doctor_user = $presc_doctor ? getUserById($presc_doctor['user_id']) : null;

                        // Check if current doctor owns this prescription
                        $isOwnPrescription = ($role == 'doctor' && $current_doctor_id == $prescription['doctor_id']);
                        ?>
                        <tr>
                            <td><?php echo $prescription['id']; ?></td>
                            <td><?php echo $patient_user ? $patient_user['full_name'] : 'N/A'; ?></td>
                            <td><?php echo $doctor_user ? $doctor_user['full_name'] : 'N/A'; ?></td>
                            <td><?php echo substr($prescription['diagnosis'], 0, 30) . '...'; ?></td>
                            <td><?php echo $prescription['created_date']; ?></td>
                            <td>
                                <a href="prescription_view.php?id=<?php echo $prescription['id']; ?>"><button>View</button></a>

                                <?php if ($role == 'admin' || $isOwnPrescription): ?>
                                    <a href="prescription_edit.php?id=<?php echo $prescription['id']; ?>"><button>Edit</button></a>
                                    <a href="../controller/delete_prescription.php?id=<?php echo $prescription['id']; ?>"
                                        onclick="return confirm('Are you sure?');"><button>Delete</button></a>
                                <?php endif; ?>

                                <button
                                    onclick="window.open('prescription_view.php?id=<?php echo $prescription['id']; ?>&print=1', '_blank');">Print</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" align="center">No prescriptions found</td>
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