<?php
require_once('../controller/adminCheck.php');
require_once('../model/doctorModel.php');
require_once('../model/departmentModel.php');
require_once('../model/userModel.php');
$doctor_id = isset($_GET['id']) ? $_GET['id'] : 0;
$doctor = getDoctorById($doctor_id);
if (!$doctor) {
    header('location: admin_doctor_list.php');
    exit;
}
$user = getUserById($doctor['user_id']);
$departments = getAllDepartments();
$current_dept = $doctor['department_id'] ? getDepartmentById($doctor['department_id']) : null;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Assign Doctor to Department - Hospital Management System</title>
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

    <!-- Assign Doctor Form -->
    <div class="main-container">
        <h2>Assign Doctor to Department</h2>

        <div>
            <a href="admin_doctor_list.php"><button>Back to Doctor List</button></a>
        </div>

        <br>

        <fieldset>
            <legend>Doctor Information</legend>
            <table cellpadding="8" width="100%">
                <tr>
                    <td width="20%"><b>Doctor ID:</b></td>
                    <td>
                        <?php echo $doctor['id']; ?>
                    </td>
                </tr>
                <tr>
                    <td><b>Full Name:</b></td>
                    <td>
                        <?php echo $user ? $user['full_name'] : 'N/A'; ?>
                    </td>
                </tr>
                <tr>
                    <td><b>Specialization:</b></td>
                    <td>
                        <?php echo $doctor['specialization']; ?>
                    </td>
                </tr>
                <tr>
                    <td><b>Current Department:</b></td>
                    <td>
                        <?php echo $current_dept ? $current_dept['department_name'] : 'Not Assigned'; ?>
                    </td>
                </tr>
            </table>
        </fieldset>

        <br>

        <fieldset>
            <legend>Assign to Department</legend>
            <form method="POST" action="../controller/assign_doctor.php" onsubmit="return validateForm(this)">
                <input type="hidden" name="doctor_id" value="<?php echo $doctor['id']; ?>">
                <table cellpadding="8">
                    <tr>
                        <td><label for="department_id">Select Department:</label></td>
                        <td>
                            <select name="department_id" id="department_id" required
                                onchange="validateSelectBlur(this, 'Department')">
                                <option value="">-- Select Department --</option>
                                <?php foreach ($departments as $dept): ?>
                                    <option value="<?php echo $dept['id']; ?>" <?php echo ($doctor['department_id'] == $dept['id']) ? 'selected' : ''; ?>>
                                        <?php echo $dept['department_name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type="submit" name="submit" value="Assign Department">
                            <a href="admin_doctor_list.php"><button type="button">Cancel</button></a>
                        </td>
                    </tr>
                </table>
            </form>
        </fieldset>
    </div>
    <script src="../assets/js/validation-common.js"></script>
</body>

</html>