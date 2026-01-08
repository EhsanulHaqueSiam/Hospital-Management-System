<?php
require_once('../controller/adminCheck.php');
require_once('../model/doctorModel.php');
require_once('../model/userModel.php');
require_once('../model/departmentModel.php');

$id = isset($_GET['id']) ? $_GET['id'] : 0;
$doctor = getDoctorById($id);

if (!$doctor) {
    header('location: admin_doctor_list.php');
    exit;
}

$user = getUserById($doctor['user_id']);
$departments = getAllDepartments();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Doctor - Hospital Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <div class="navbar">
        <span class="navbar-title">Hospital Management System</span>
        <a href="dashboard_admin.php" class="navbar-link">Dashboard</a>
        <a href="profile_view.php" class="navbar-link">My Profile</a>
        <a href="../controller/logout.php" class="navbar-link">Logout</a>
    </div>

    <div class="main-container">
        <h2>Edit Doctor</h2>

        <form method="POST" action="../controller/edit_doctor.php" enctype="multipart/form-data"
            onsubmit="return validateForm(this)">
            <input type="hidden" name="doctor_id" value="<?php echo $doctor['id']; ?>">
            <input type="hidden" name="user_id" value="<?php echo $doctor['user_id']; ?>">

            <fieldset>
                <legend>Doctor Information</legend>
                <table>
                    <tr>
                        <td>Doctor ID:</td>
                        <td><b><?php echo $doctor['id']; ?></b></td>
                    </tr>
                    <tr>
                        <td>Full Name:</td>
                        <td><input type="text" name="full_name" value="<?php echo $user['full_name']; ?>" required
                                onblur="validateRequiredBlur(this, 'Full Name')"></td>
                    </tr>

                    <tr>
                        <td>Email:</td>
                        <td><input type="email" name="email" value="<?php echo $user['email']; ?>" required
                                onblur="validateRequiredBlur(this, 'Email')"></td>
                    </tr>

                    <tr>
                        <td>Phone:</td>
                        <td><input type="tel" name="phone" value="<?php echo $user['phone']; ?>" required
                                onblur="validateRequiredBlur(this, 'Phone')"></td>
                    </tr>

                    <tr>
                        <td>Department:</td>
                        <td>
                            <select name="department_id" required onchange="validateSelectBlur(this, 'Department')">
                                <option value="">-- Select --</option>
                                <?php foreach ($departments as $dept): ?>
                                    <option value="<?php echo $dept['id']; ?>" <?php echo ($dept['id'] == $doctor['department_id']) ? 'selected' : ''; ?>>
                                        <?php echo $dept['department_name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Specialization:</td>
                        <td><input type="text" name="specialization" value="<?php echo $doctor['specialization']; ?>"
                                required onblur="validateRequiredBlur(this, 'Specialization')"></td>
                    </tr>

                    <tr>
                        <td>Bio:</td>
                        <td><textarea name="bio" rows="4" cols="40"
                                onblur="validateRequiredBlur(this, 'Bio')"><?php echo $doctor['bio']; ?></textarea></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type="submit" name="submit" value="Update Doctor">
                            <a href="admin_doctor_list.php"><button type="button">Cancel</button></a>
                        </td>
                    </tr>
                </table>
            </fieldset>
        </form>
    </div>
    <script src="../assets/js/validation-common.js"></script>
</body>

</html>