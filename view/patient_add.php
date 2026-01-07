<?php
require_once('../controller/adminCheck.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Add Patient - Hospital Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

    <div class="navbar">
        <span class="navbar-title">Hospital Management System</span>
        <a href="dashboard_admin.php" class="navbar-link">Dashboard</a>
        <a href="profile_view.php" class="navbar-link">My Profile</a>
        <a href="../controller/logout.php" class="navbar-link">Logout</a>
    </div>

    <!-- Add Patient Form -->
    <div class="main-container">
        <h2>Add New Patient</h2>

        <form method="POST" action="../controller/add_patient.php" onsubmit="return validatePatientForm(this)">
            <fieldset>
                <legend>Personal Information</legend>
                <table cellpadding="5">
                    <tr>
                        <td>Full Name:</td>
                        <td><input type="text" name="full_name" required onblur="validateName(this)"></td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td><input type="email" name="email" required onblur="validateEmail(this)"></td>
                    </tr>
                    <tr>
                        <td>Phone:</td>
                        <td><input type="tel" name="phone" required onblur="validatePhone(this)"></td>
                    </tr>
                    <tr>
                        <td>Date of Birth:</td>
                        <td><input type="date" name="date_of_birth" required onblur="validateDOB(this)"></td>
                    </tr>
                    <tr>
                        <td>Gender:</td>
                        <td>
                            <select name="gender" required>
                                <option value="">-- Select --</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Blood Group:</td>
                        <td>
                            <select name="blood_group">
                                <option value="">-- Select --</option>
                                <option value="A+">A+</option>
                                <option value="A-">A-</option>
                                <option value="B+">B+</option>
                                <option value="B-">B-</option>
                                <option value="O+">O+</option>
                                <option value="O-">O-</option>
                                <option value="AB+">AB+</option>
                                <option value="AB-">AB-</option>
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
                        <td>Address:</td>
                        <td><textarea name="address" rows="3" cols="40"></textarea></td>
                    </tr>
                    <tr>
                        <td>Emergency Contact:</td>
                        <td><input type="tel" name="emergency_contact"></td>
                    </tr>
                </table>
            </fieldset>

            <br>

            <fieldset>
                <legend>Account Information</legend>
                <table cellpadding="5">
                    <tr>
                        <td>Username:</td>
                        <td><input type="text" name="username" required onblur="validateUsername(this)"></td>
                    </tr>
                    <tr>
                        <td>Password:</td>
                        <td><input type="password" name="password" required onblur="validatePassword(this)"></td>
                    </tr>
                </table>
            </fieldset>

            <br>

            <div>
                <input type="submit" name="submit" value="Register Patient">
                <a href="patient_list.php"><button type="button">Cancel</button></a>
            </div>
        </form>
    </div>
    <script src="../assets/js/validation-helpers.js"></script>
    <script src="../assets/js/validation-fields.js"></script>
    <script src="../assets/js/validation-patient.js"></script>
</body>

</html>