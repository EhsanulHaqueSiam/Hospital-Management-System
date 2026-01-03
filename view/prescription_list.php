<<<<<<< Updated upstream:view/prescription_list.html
=======
<?php
require_once('../controller/sessionCheck.php');
require_once('../model/prescriptionModel.php');
require_once('../model/patientModel.php');
require_once('../model/doctorModel.php');
require_once('../model/userModel.php');

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

// Fetch prescriptions based on role
if ($role == 'admin') {
    $prescriptions = getAllPrescriptions();
} elseif ($role == 'doctor') {
    $doctor = getDoctorByUserId($user_id);
    $prescriptions = $doctor ? getPrescriptionsByDoctor($doctor['id']) : [];
} else {
    $patient = getPatientByUserId($user_id);
    $prescriptions = $patient ? getPrescriptionsByPatient($patient['id']) : [];
}
?>
>>>>>>> Stashed changes:view/prescription_list.php
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Prescription List - Hospital Management System</title>
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

    <!-- Prescription List -->
    <div class="main-container">
        <h2>Prescription Management</h2>

<<<<<<< Updated upstream:view/prescription_list.html
        <div>

            <a href="prescription_add.html" class="button">Create New Prescription</a>
            <button class="button" id="export-xml-btn">Export to XML</button>
        </div>

=======
        <!-- Actions -->
>>>>>>> Stashed changes:view/prescription_list.php
        <fieldset>
            <legend>Actions</legend>
            <table>
                <tr>
                    <td>
                        <form method="GET" action="">
                            Search: <input type="text" name="search" value="">
                            <input type="submit" value="Search">
                        </form>
                    </td>
                    <?php if ($role == 'doctor'): ?>
                        <td>
                            <a href="prescription_add.php"><button type="button">Create Prescription</button></a>
                        </td>
<<<<<<< Updated upstream:view/prescription_list.html
                        <td>

                            <select name="patient_id">
                                <option value="">-- Filter by Patient --</option>

                            </select>
                        </td>
                        <td>
                            <button type="submit" class="button">Search</button>
                            <a href="prescription_list.html" class="button">Reset</a>
                        </td>
                    </tr>
                </table>
            </form>
=======
                    <?php endif; ?>
                </tr>
            </table>
>>>>>>> Stashed changes:view/prescription_list.php
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
                        $patient = getPatientById($prescription['patient_id']);
                        $patient_user = $patient ? getUserById($patient['user_id']) : null;

                        $doctor = getDoctorById($prescription['doctor_id']);
                        $doctor_user = $doctor ? getUserById($doctor['user_id']) : null;
                        ?>
                        <tr>
                            <td><?php echo $prescription['id']; ?></td>
                            <td><?php echo $patient_user ? $patient_user['full_name'] : 'N/A'; ?></td>
                            <td><?php echo $doctor_user ? $doctor_user['full_name'] : 'N/A'; ?></td>
                            <td><?php echo substr($prescription['diagnosis'], 0, 30) . '...'; ?></td>
                            <td><?php echo $prescription['created_date']; ?></td>
                            <td>
                                <a href="prescription_view.php?id=<?php echo $prescription['id']; ?>"><button>View</button></a>
                                <?php if ($role == 'admin'): ?>
                                    <a href="../controller/delete_prescription.php?id=<?php echo $prescription['id']; ?>"
                                        onclick="return confirm('Are you sure?');"><button>Delete</button></a>
                                <?php endif; ?>
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