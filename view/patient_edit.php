<?php
require_once('../controller/adminCheck.php');
require_once('../model/patientModel.php');
require_once('../model/userModel.php');

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
    <title>Edit Patient - Hospital Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <!-- Navbar -->
    <div class="navbar">
        <span class="navbar-title">Hospital Management System</span>
        <a href="dashboard_admin.php" class="navbar-link">Dashboard</a>
        <a href="profile_view.php" class="navbar-link">My Profile</a>
        <a href="../controller/logout.php" class="navbar-link">Logout</a>
    </div>

    <!-- Edit Patient Form -->
    <div class="main-container">
        <h2>Edit Patient Information</h2>

        <form method="POST" action="../controller/edit_patient.php" onsubmit="return validatePatientEditForm(this)">
            <input type="hidden" name="patient_id" value="<?php echo $patient['id']; ?>">
            <input type="hidden" name="user_id" value="<?php echo $patient['user_id']; ?>">

            <fieldset>
                <legend>Personal Information</legend>
                <table cellpadding="5">
                    <tr>
                        <td>Full Name:</td>
                        <td><input type="text" name="full_name" value="<?php echo $user['full_name']; ?>" required
                                onblur="validateName(this)"></td>
                    </tr>
                    <tr>
                        <td>Gender:</td>
                        <td>
                            <select name="gender" required>
                                <option value="Male" <?php echo $patient['gender'] == 'Male' ? 'selected' : ''; ?>>Male
                                </option>
                                <option value="Female" <?php echo $patient['gender'] == 'Female' ? 'selected' : ''; ?>>
                                    Female</option>
                                <option value="Other" <?php echo $patient['gender'] == 'Other' ? 'selected' : ''; ?>>Other
                                </option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Blood Group:</td>
                        <td>
                            <select name="blood_group">
                                <option value="">-- Select --</option>
                                <option value="A+" <?php echo $patient['blood_group'] == 'A+' ? 'selected' : ''; ?>>A+
                                </option>
                                <option value="A-" <?php echo $patient['blood_group'] == 'A-' ? 'selected' : ''; ?>>A-
                                </option>
                                <option value="B+" <?php echo $patient['blood_group'] == 'B+' ? 'selected' : ''; ?>>B+
                                </option>
                                <option value="B-" <?php echo $patient['blood_group'] == 'B-' ? 'selected' : ''; ?>>B-
                                </option>
                                <option value="O+" <?php echo $patient['blood_group'] == 'O+' ? 'selected' : ''; ?>>O+
                                </option>
                                <option value="O-" <?php echo $patient['blood_group'] == 'O-' ? 'selected' : ''; ?>>O-
                                </option>
                                <option value="AB+" <?php echo $patient['blood_group'] == 'AB+' ? 'selected' : ''; ?>>AB+
                                </option>
                                <option value="AB-" <?php echo $patient['blood_group'] == 'AB-' ? 'selected' : ''; ?>>AB-
                                </option>
                            </select>
                        </td>
                    </tr>
                </table>
            </fieldset>

            <br>

            <fieldset>
                <legend>Contact Information</legend>
                <table cellpadding="5">
                    <tr>
                        <td>Email:</td>
                        <td><input type="email" name="email" value="<?php echo $user['email']; ?>" required
                                onblur="validateEmail(this)"></td>
                    </tr>
                    <tr>
                        <td>Phone:</td>
                        <td><input type="tel" name="phone" value="<?php echo $user['phone']; ?>" required
                                onblur="validatePhone(this)"></td>
                    </tr>
                    <tr>
                        <td>Address:</td>
                        <td><textarea name="address" rows="3" cols="40"><?php echo $patient['address']; ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Emergency Contact:</td>
                        <td><input type="tel" name="emergency_contact"
                                value="<?php echo $patient['emergency_contact']; ?>"></td>
                    </tr>
                </table>
            </fieldset>

            <br>

            <p><i>Note: Username and Date of Birth cannot be changed.</i></p>

            <br>

            <div>
                <input type="submit" name="submit" value="Update Information">
                <a href="patient_list.php"><button type="button">Cancel</button></a>
            </div>
        </form>
    </div>
    <script src="../assets/js/validation-helpers.js"></script>
    <script src="../assets/js/validation-fields.js"></script>
    <script src="../assets/js/validation-patient.js"></script>
</body>

</html>