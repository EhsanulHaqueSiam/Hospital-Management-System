<?php
require_once('../controller/sessionCheck.php');
require_once('../model/patientModel.php');
require_once('../model/userModel.php');

$role = $_SESSION['role'];

// Only admin and doctor can access this page
if ($role != 'admin' && $role != 'doctor') {
    header('location: dashboard_patient.php');
    exit;
}

// Get patient ID from URL
$patient_id = isset($_GET['id']) ? $_GET['id'] : 0;

// Fetch patient data
$patient = getPatientById($patient_id);
if (!$patient) {
    header('location: patient_list.php');
    exit;
}

// Fetch user data
$user = getUserById($patient['user_id']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Patient Details - Hospital Management System</title>
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

    <!-- Patient Details -->
    <div class="main-container">
        <h2>Patient Details</h2>

        <div>
            <a href="patient_list.php"><button>Back to List</button></a>
            <?php if ($role == 'admin'): ?>
                <a href="patient_edit.php?id=<?php echo $patient['id']; ?>"><button>Edit Patient</button></a>
                <a href="../controller/delete_patient.php?id=<?php echo $patient['id']; ?>"
                    onclick="return confirm('Are you sure?');"><button>Delete</button></a>
            <?php endif; ?>
        </div>

        <br>

        <fieldset>
            <legend>Personal Information</legend>
            <table cellpadding="8" width="100%">
                <tr>
                    <td width="20%"><b>Patient ID:</b></td>
                    <td><?php echo $patient['id']; ?></td>
                </tr>
                <tr>
                    <td><b>Full Name:</b></td>
                    <td><?php echo $user ? $user['full_name'] : 'N/A'; ?></td>
                </tr>
                <tr>
                    <td><b>Date of Birth:</b></td>
                    <td><?php echo $patient['date_of_birth']; ?></td>
                </tr>
                <tr>
                    <td><b>Gender:</b></td>
                    <td><?php echo $patient['gender']; ?></td>
                </tr>
                <tr>
                    <td><b>Blood Group:</b></td>
                    <td><?php echo $patient['blood_group']; ?></td>
                </tr>
            </table>
        </fieldset>

        <br>

        <fieldset>
            <legend>Contact Information</legend>
            <table cellpadding="8" width="100%">
                <tr>
                    <td width="20%"><b>Email:</b></td>
                    <td><?php echo $user ? $user['email'] : 'N/A'; ?></td>
                </tr>
                <tr>
                    <td><b>Phone:</b></td>
                    <td><?php echo $user ? $user['phone'] : 'N/A'; ?></td>
                </tr>
                <tr>
                    <td><b>Address:</b></td>
                    <td><?php echo $patient['address']; ?></td>
                </tr>
                <tr>
                    <td><b>Emergency Contact:</b></td>
                    <td><?php echo $patient['emergency_contact']; ?></td>
                </tr>
            </table>
        </fieldset>

        <br>

        <fieldset>
            <legend>Medical History</legend>
            <p><?php echo $patient['medical_history'] ? $patient['medical_history'] : 'No medical history recorded.'; ?>
            </p>
        </fieldset>

        <br>

        <fieldset>
            <legend>Account Information</legend>
            <table cellpadding="8" width="100%">
                <tr>
                    <td width="20%"><b>Username:</b></td>
                    <td><?php echo $user ? $user['username'] : 'N/A'; ?></td>
                </tr>
                <tr>
                    <td><b>Registration Date:</b></td>
                    <td><?php echo $user ? $user['registration_date'] : 'N/A'; ?></td>
                </tr>
            </table>
        </fieldset>
    </div>
</body>

</html>