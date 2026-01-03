<?php
require_once('../controller/sessionCheck.php');
require_once('../model/medicalRecordModel.php');
require_once('../model/patientModel.php');
require_once('../model/userModel.php');

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

// Fetch medical records based on role
if ($role == 'admin' || $role == 'doctor') {
    $records = getAllMedicalRecords();
} else {
    // Patient can only see their own records
    $patient = getPatientByUserId($user_id);
    $records = $patient ? getMedicalRecordsByPatient($patient['id']) : [];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Medical Records - Hospital Management System</title>
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

    <!-- Medical Records List -->
    <div class="main-container">
        <h2>Medical Records</h2>

        <!-- Actions -->
        <fieldset>
            <legend>Actions</legend>
            <table>
                <tr>
                    <td>
                        <form method="GET" action="">
                            Search: <input type="text" name="search" value="">
                            <select name="type">
                                <option value="">All Types</option>
                                <option value="Lab Report">Lab Report</option>
                                <option value="X-Ray">X-Ray</option>
                                <option value="MRI">MRI</option>
                                <option value="CT Scan">CT Scan</option>
                                <option value="Prescription">Prescription</option>
                                <option value="Other">Other</option>
                            </select>
                            <input type="submit" value="Filter">
                        </form>
                    </td>
                    <?php if ($role == 'admin' || $role == 'doctor'): ?>
                        <td>
                            <a href="record_add.php"><button type="button">Upload Record</button></a>
                        </td>
                    <?php endif; ?>
                </tr>
            </table>
        </fieldset>

        <br>

        <!-- Records Table -->
        <fieldset>
            <legend>All Records</legend>
            <table border="1" cellpadding="8" width="100%">
                <tr>
                    <th>ID</th>
                    <th>Patient Name</th>
                    <th>Record Type</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
                <?php if (count($records) > 0): ?>
                    <?php foreach ($records as $record): ?>
                        <?php
                        $patient = getPatientById($record['patient_id']);
                        $patient_user = $patient ? getUserById($patient['user_id']) : null;
                        ?>
                        <tr>
                            <td><?php echo $record['id']; ?></td>
                            <td><?php echo $patient_user ? $patient_user['full_name'] : 'N/A'; ?></td>
                            <td><?php echo $record['record_type']; ?></td>
                            <td><?php echo substr($record['description'], 0, 40) . '...'; ?></td>
                            <td><?php echo $record['record_date']; ?></td>
                            <td>
                                <a href="record_view.php?id=<?php echo $record['id']; ?>"><button>View</button></a>
                                <?php if ($role == 'admin'): ?>
                                    <a href="../controller/delete_record.php?id=<?php echo $record['id']; ?>"
                                        onclick="return confirm('Are you sure?');"><button>Delete</button></a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" align="center">No medical records found</td>
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