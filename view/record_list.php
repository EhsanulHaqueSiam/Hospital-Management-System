<?php
require_once('../controller/sessionCheck.php');
require_once('../model/medicalRecordModel.php');
require_once('../model/patientModel.php');
require_once('../model/userModel.php');

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];
$type_filter = isset($_GET['type']) ? $_GET['type'] : '';

if ($role == 'admin' || $role == 'doctor') {
    $records = getAllMedicalRecords();
} else {
    $patient = getPatientByUserId($user_id);
    $records = $patient ? getMedicalRecordsByPatient($patient['id']) : [];
}
if ($type_filter != '') {
    $filtered = [];
    foreach ($records as $record) {
        if ($record['record_type'] == $type_filter) {
            $filtered[] = $record;
        }
    }
    $records = $filtered;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Medical Records - Hospital Management System</title>
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

    <div class="main-container">
        <h2>Medical Records</h2>

        <fieldset>
            <legend>Actions</legend>
            <table>
                <tr>
                    <td>
                        <form method="GET" action="">
                            Type:
                            <select name="type">
                                <option value="">All Types</option>
                                <option value="Lab Report" <?php if ($type_filter == 'Lab Report')
                                    echo 'selected'; ?>>Lab
                                    Report</option>
                                <option value="X-Ray" <?php if ($type_filter == 'X-Ray')
                                    echo 'selected'; ?>>X-Ray
                                </option>
                                <option value="MRI" <?php if ($type_filter == 'MRI')
                                    echo 'selected'; ?>>MRI</option>
                                <option value="CT Scan" <?php if ($type_filter == 'CT Scan')
                                    echo 'selected'; ?>>CT Scan
                                </option>
                                <option value="Prescription" <?php if ($type_filter == 'Prescription')
                                    echo 'selected'; ?>>Prescription</option>
                                <option value="Blood Test" <?php if ($type_filter == 'Blood Test')
                                    echo 'selected'; ?>>
                                    Blood Test</option>
                                <option value="Other" <?php if ($type_filter == 'Other')
                                    echo 'selected'; ?>>Other
                                </option>
                            </select>
                            <input type="submit" value="Filter">
                            <?php if ($type_filter != ''): ?>
                                <a href="record_list.php"><button type="button">Clear</button></a>
                            <?php endif; ?>
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
                        $rec_patient = getPatientById($record['patient_id']);
                        $patient_user = $rec_patient ? getUserById($rec_patient['user_id']) : null;
                        ?>
                        <tr>
                            <td><?php echo $record['id']; ?></td>
                            <td><?php echo $patient_user ? $patient_user['full_name'] : 'N/A'; ?></td>
                            <td><?php echo $record['record_type']; ?></td>
                            <td><?php echo substr($record['description'], 0, 40) . '...'; ?></td>
                            <td><?php echo $record['record_date']; ?></td>
                            <td>
                                <a href="record_view.php?id=<?php echo $record['id']; ?>"><button>View</button></a>

                                <?php if ($record['file_path']): ?>
                                    <a
                                        href="../controller/download_record.php?id=<?php echo $record['id']; ?>"><button>Download</button></a>
                                <?php endif; ?>

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