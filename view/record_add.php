<?php
require_once('../controller/sessionCheck.php');
require_once('../model/patientModel.php');
require_once('../model/userModel.php');

$role = $_SESSION['role'];

// Only admin and doctor can add records
if ($role != 'admin' && $role != 'doctor') {
    header('location: record_list.php');
    exit;
}

// Fetch all patients for dropdown
$patients = getAllPatients();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Upload Medical Record - Hospital Management System</title>
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

    <!-- Upload Record Form -->
    <div class="main-container">
        <h2>Upload Medical Record</h2>

        <form method="POST" action="../controller/add_record.php" enctype="multipart/form-data">
            <fieldset>
                <legend>Record Information</legend>
                <table cellpadding="8" width="100%">
                    <tr>
                        <td>Patient:</td>
                        <td>
                            <select name="patient_id" required>
                                <option value="">-- Select Patient --</option>
                                <?php foreach ($patients as $p): ?>
                                    <?php $p_user = getUserById($p['user_id']); ?>
                                    <option value="<?php echo $p['id']; ?>"><?php echo $p_user['full_name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Record Type:</td>
                        <td>
                            <select name="record_type" required>
                                <option value="">-- Select Type --</option>
                                <option value="Lab Report">Lab Report</option>
                                <option value="X-Ray">X-Ray</option>
                                <option value="MRI">MRI</option>
                                <option value="CT Scan">CT Scan</option>
                                <option value="Prescription">Prescription</option>
                                <option value="Diagnosis">Diagnosis</option>
                                <option value="Other">Other</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Record Date:</td>
                        <td><input type="date" name="record_date" value="<?php echo date('Y-m-d'); ?>" required></td>
                    </tr>
                    <tr>
                        <td>Description:</td>
                        <td><textarea name="description" rows="4" cols="50" required></textarea></td>
                    </tr>
                    <tr>
                        <td>Upload File:</td>
                        <td>
                            <input type="file" name="record_file" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                            <br><small>Accepted: PDF, Images, Word documents (Max 5MB)</small>
                        </td>
                    </tr>
                </table>
            </fieldset>

            <br>

            <div>
                <input type="submit" name="submit" value="Upload Record">
                <a href="record_list.php"><button type="button">Cancel</button></a>
            </div>
        </form>
    </div>
</body>

</html>