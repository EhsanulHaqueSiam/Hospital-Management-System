<?php
require_once('../controller/adminCheck.php');
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

        <span class="success-message"></span>

        <form method="POST" action="../controller/add_doctor.php" enctype="multipart/form-data"
            onsubmit="return validateDoctor()">
            <fieldset>
                <legend>Doctor Information</legend>
                <table>
                    <tr>
                        <td>Full Name:</td>
                        <td><input type="text" name="full_name" onblur="validateDoctorNameBlur()" required></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><span class="error-message" id="fullname-error"></span></td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td><input type="email" name="email" onblur="validateDoctorEmailBlur()" required></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><span class="error-message" id="email-error"></span></td>
                    </tr>
                    <tr>
                        <td>Phone:</td>
                        <td><input type="tel" name="phone" onblur="validateDoctorPhoneBlur()" required></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><span class="error-message" id="phone-error"></span></td>
                    </tr>
                    <tr>
                        <td>Username:</td>
                        <td><input type="text" name="username" onblur="validateDoctorUsernameBlur()" required></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><span class="error-message" id="username-error"></span></td>
                    </tr>
                    <tr>
                        <td>Password:</td>
                        <td><input type="password" name="password" onblur="validateDoctorPasswordBlur()" required></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><span class="error-message" id="password-error"></span></td>
                    </tr>
                    <tr>
                        <td>Department:</td>
                        <td>
                            <select name="department_id" required>
                                <option value="">-- Select --</option>
                                <option value="1">Cardiology</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><span class="error-message" id="department-error"></span></td>
                    </tr>
                    <tr>
                        <td>Specialization:</td>
                        <td><input type="text" name="specialization" onblur="validateSpecializationBlur()" required>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><span class="error-message" id="specialization-error"></span></td>
                    </tr>
                    <tr>
                        <td>Bio:</td>
                        <td><textarea name="bio" rows="4" cols="40"></textarea></td>
                    </tr>
                    <tr>
                        <td>Address:</td>
                        <td><textarea name="address" rows="3" cols="40"></textarea></td>
                    </tr>
                    <tr>
                        <td>Profile Picture:</td>
                        <td><input type="file" name="profile_picture" accept=".jpg,.jpeg,.png,.gif"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><small>Max 2MB. jpg, png, gif</small></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type="submit" name="create_doctor" value="Create Doctor">
                            <a href="admin_doctor_list.php"><button type="button">Cancel</button></a>
                        </td>
                    </tr>
                </table>
            </fieldset>
        </form>
    </div>

    <script src="../assets/js/admin.js"></script>
</body>

</html>