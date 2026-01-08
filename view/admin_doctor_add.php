<?php
require_once('../controller/adminCheck.php');
require_once('../model/departmentModel.php');

$departments = getAllDepartments();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Add Doctor - Hospital Management System</title>
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
        <h2>Add New Doctor</h2>

        <form method="POST" action="../controller/add_doctor.php" enctype="multipart/form-data"
            onsubmit="return validateForm(this)">
            <fieldset>
                <legend>Doctor Information</legend>
                <table>
                    <tr>
                        <td>Full Name:</td>
                        <td><input type="text" name="full_name" required
                                onblur="validateRequiredBlur(this, 'Full Name')"></td>
                    </tr>

                    <tr>
                        <td>Email:</td>
                        <td><input type="email" name="email" required onblur="validateRequiredBlur(this, 'Email')"></td>
                    </tr>

                    <tr>
                        <td>Phone:</td>
                        <td><input type="tel" name="phone" required onblur="validateRequiredBlur(this, 'Phone')"></td>
                    </tr>

                    <tr>
                        <td>Username:</td>
                        <td><input type="text" name="username" required onblur="validateRequiredBlur(this, 'Username')">
                        </td>
                    </tr>

                    <tr>
                        <td>Password:</td>
                        <td><input type="password" name="password" required
                                onblur="validateRequiredBlur(this, 'Password')"></td>
                    </tr>

                    <tr>
                        <td>Department:</td>
                        <td>
                            <select name="department_id" required onchange="validateSelectBlur(this, 'Department')">
                                <option value="">-- Select --</option>
                                <?php foreach ($departments as $dept): ?>
                                    <option value="<?php echo $dept['id']; ?>"><?php echo $dept['department_name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>Specialization:</td>
                        <td><input type="text" name="specialization" required
                                onblur="validateRequiredBlur(this, 'Specialization')">
                        </td>
                    </tr>

                    <tr>
                        <td>Bio:</td>
                        <td><textarea name="bio" rows="4" cols="40"></textarea></td>
                    </tr>
                    <tr>
                        <td>Address:</td>
                        <td><textarea name="address" rows="3" cols="40" required
                                onblur="validateRequiredBlur(this, 'Address')"></textarea></td>
                    </tr>
                    <tr>
                        <td>Profile Picture:</td>
                        <td><input type="file" name="profile_picture" accept=".jpg,.jpeg,.png,.gif" required
                                onchange="validateRequiredBlur(this, 'Profile Picture')"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><small>Max 2MB. jpg, png, gif</small></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type="submit" name="submit" value="Create Doctor">
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