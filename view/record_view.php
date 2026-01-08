<?php
require_once('../controller/sessionCheck.php');
require_once('../model/medicalRecordModel.php');
require_once('../model/patientModel.php');
require_once('../model/userModel.php');

$role = $_SESSION['role'];
$record_id = isset($_GET['id']) ? $_GET['id'] : 0;
$record = getMedicalRecordById($record_id);
if (!$record) {
    header('location: record_list.php');
    exit;
}
$patient = getPatientById($record['patient_id']);
$patient_user = $patient ? getUserById($patient['user_id']) : null;

$uploader = getUserById($record['uploaded_by']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Medical Record Details - Hospital Management System</title>
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

    <!-- Record Details -->
    <div class="main-container">
        <h2>Medical Record Details</h2>

        <div>
            <a href="record_list.php"><button>Back to Records</button></a>

            <?php if ($record['file_path']): ?>
                <a href="../controller/download_record.php?id=<?php echo $record['id']; ?>"><button>Download
                        File</button></a>
            <?php endif; ?>

            <?php if ($role == 'admin'): ?>
                <a href="../controller/delete_record.php?id=<?php echo $record['id']; ?>"
                    onclick="return confirm('Are you sure?');"><button>Delete</button></a>
            <?php endif; ?>

            <button onclick="window.print();">Print</button>
        </div>

        <br>

        <fieldset>
            <legend>Record Information</legend>
            <table cellpadding="8" width="100%">
                <tr>
                    <td width="20%"><b>Record ID:</b></td>
                    <td><?php echo $record['id']; ?></td>
                </tr>
                <tr>
                    <td><b>Record Type:</b></td>
                    <td><?php echo $record['record_type']; ?></td>
                </tr>
                <tr>
                    <td><b>Record Date:</b></td>
                    <td><?php echo $record['record_date']; ?></td>
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
                    <td><?php echo $record['patient_id']; ?></td>
                </tr>
            </table>
        </fieldset>

        <br>

        <fieldset>
            <legend>Description</legend>
            <p><?php echo nl2br($record['description']); ?></p>
        </fieldset>

        <br>

        <fieldset>
            <legend>Attached File</legend>
            <?php if ($record['file_path']): ?>
                <p>
                    <a href="../controller/download_record.php?id=<?php echo $record['id']; ?>"><button>Download
                            File</button></a>
                </p>
            <?php else: ?>
                <p>No file attached to this record.</p>
            <?php endif; ?>
        </fieldset>

        <br>

        <fieldset>
            <legend>Metadata</legend>
            <table cellpadding="8" width="100%">
                <tr>
                    <td width="20%"><b>Uploaded By:</b></td>
                    <td><?php echo $uploader ? $uploader['full_name'] : 'N/A'; ?></td>
                </tr>
                <tr>
                    <td><b>Upload Date:</b></td>
                    <td><?php echo $record['upload_date']; ?></td>
                </tr>
            </table>
        </fieldset>
    </div>
</body>

</html>