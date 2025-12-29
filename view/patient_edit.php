<?php
require_once('../controller/sessionCheck.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Patient - Hospital Management System</title>
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
        <h2>Edit Patient Information</h2>



        <form action="" method="POST" onsubmit="return validatePatientEditForm(this)">

            <input type="hidden" name="patient_id" value="PAT_ID_HERE">

            <fieldset>
                <legend>Personal Information</legend>
                <table cellpadding="5">
                    <tr>
                        <td>Full Name:</td>
                        <td><input type="text" name="full_name" value="" required onblur="validateName(this)"></td>
                    </tr>
                    <tr>
                        <td>Gender:</td>
                        <td>

                            <select name="gender" required>

                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Blood Group:</td>
                        <td>

                            <select name="blood_group">

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
                        <td><input type="email" name="email" value="" required onblur="validateEmail(this)"></td>
                    </tr>
                    <tr>
                        <td>Phone:</td>
                        <td><input type="tel" name="phone" value="" required onblur="validatePhone(this)"></td>
                    </tr>
                    <tr>
                        <td>Address:</td>
                        <td><textarea name="address" rows="3"></textarea></td>
                    </tr>
                    <tr>
                        <td>Emergency Contact:</td>
                        <td><input type="text" name="emergency_contact" value="">
                        </td>
                    </tr>
                </table>
            </fieldset>

            <br>
            <p><i>Note: Username and Date of Birth cannot be changed.</i></p>
            <br>

            <div>
                <button type="submit" name="update_patient" class="button">Update Information</button>
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
