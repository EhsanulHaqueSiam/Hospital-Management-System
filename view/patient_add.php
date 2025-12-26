<?php
require_once('../controller/sessionCheck.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Add Patient - Hospital Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="../assets/js/validation-helpers.js"></script>
    <script src="../assets/js/validation-fields.js"></script>
    <script src="../assets/js/validation-patient.js"></script>
    <script src="../assets/js/validation-appointment.js"></script>
    <script src="../assets/js/validation-prescription.js"></script>
    <script src="../assets/js/validation-record.js"></script>
    <script src="../assets/js/validation-init.js"></script>
</head>

<body>
    <!-- Navbar -->
    <div class="navbar">
        <span class="navbar-title">Hospital Management System</span>
        <a href="#" class="navbar-link">Dashboard</a>
        <a href="#" class="navbar-link">My Profile</a>
        <a href="#" class="navbar-link" id="logout-btn">Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main-container">
        <h2>Add New Patient</h2>


        <!-- <div class="success-message">Patient registered successfully!</div> -->

        <form action="" method="POST" onsubmit="return validatePatientForm(this)">


            <fieldset>
                <legend>Personal Information</legend>
                <table cellpadding="5">
                    <tr>
                        <td>Full Name:</td>
                        <td><input type="text" name="full_name" required onblur="validateName(this)"></td>
                    </tr>
                    <tr>
                        <td>Date of Birth:</td>
                        <td><input type="date" name="dob" required onblur="validateDOB(this)"></td>
                    </tr>
                    <tr>
                        <td>Gender:</td>
                        <td>
                            <select name="gender" required>
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
                <legend>Contact Details</legend>
                <table cellpadding="5">
                    <tr>
                        <td>Email:</td>
                        <td><input type="email" name="email" required onblur="validateEmail(this)"></td>
                    </tr>
                    <tr>
                        <td>Phone:</td>
                        <td><input type="tel" name="phone" required onblur="validatePhone(this)"></td>
                    </tr>
                    <tr>
                        <td>Address:</td>
                        <td><textarea name="address" rows="3"></textarea></td>
                    </tr>
                    <tr>
                        <td>Emergency Contact:</td>
                        <td><input type="text" name="emergency_contact"></td>
                    </tr>
                </table>
            </fieldset>

            <br>

            <fieldset>
                <legend>Account Credentials</legend>
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
                <button type="submit" name="submit_patient" class="button">Register Patient</button>
                <a href="patient_list.php" class="button btn-cancel">Cancel</a>
            </div>
        </form>
    </div>

    <!-- Logout Modal -->
    <div class="logout-modal" id="logout-modal">
        <div class="modal-content">
            <p>Are you sure you want to logout?</p>
            <br>
            <button id="confirm-logout">Yes</button>
            <button id="cancel-logout" class="btn-cancel">Cancel</button>
        </div>
    </div>
</body>

</html>
