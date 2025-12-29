<?php
require_once('../controller/sessionCheck.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Appointment - Hospital Management System</title>
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
        <h2>Edit Appointment</h2>

        <form action="" method="POST">
            <input type="hidden" name="appointment_id" value="APT202501">

            <fieldset>
                <legend>Details</legend>
                <table cellpadding="8" width="100%">
                    <tr>
                        <td>Patient:</td>
                        <td> </td>
                    </tr>
                    <tr>
                        <td>Doctor:</td>
                        <td>
                            <select name="doctor_id" required>

                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Date:</td>
                        <td><input type="date" name="appointment_date" value="2025-12-15" required></td>
                    </tr>
                    <tr>
                        <td>Time Slot:</td>
                        <td>
                            <select name="time_slot" required>

                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Status:</td>
                        <td>
                            <select name="status">

                            </select>
                        </td>
                    </tr>
                </table>
            </fieldset>

            <br>

            <fieldset>
                <legend>Admin Notes</legend>
                <textarea name="admin_notes" rows="4">Rescheduled per patient request.</textarea>
            </fieldset>

            <br>

            <div>
                <button type="submit" name="update_appointment" class="button">Update Appointment</button>
                <a href="appointment_list.php" class="button btn-cancel">Cancel</a>
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
