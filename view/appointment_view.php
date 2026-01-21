<?php
require_once('../controller/sessionCheck.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Appointment Details - Hospital Management System</title>
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
    <?php include(__DIR__ . "/partials/navbar.php"); ?>
    <!-- Navbar -->
    <div class="navbar">
        <span class="navbar-title">Hospital Management System</span>
        <a href="#" class="navbar-link">Dashboard</a>
        <a href="#" class="navbar-link">My Profile</a>
        <a href="#" class="navbar-link" id="logout-btn">Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main-container">
        <h2>Appointment Details</h2>

        <div>
            <a href="appointment_list.php" class="button">Back to List</a>
            <a href="appointment_edit.php?id=APT202501" class="button">Edit Appointment</a>
            <button class="button" onclick="openCancelModal()">Cancel Appointment</button>
        </div>

        <div>
            <fieldset>
                <legend>Appointment Info</legend>
                <table cellpadding="8" width="100%">
                    <tr>
                        <td><b>Appointment ID:</b></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><b>Date & Time:</b></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><b>Status:</b></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><b>Type:</b></td>
                        <td></td>
                    </tr>
                </table>
            </fieldset>

            <br>

            <fieldset>
                <legend>Patient Info</legend>
                <table cellpadding="8" width="100%">
                    <tr>
                        <td><b>Name:</b></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><b>Age/Gender:</b></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><b>Contact:</b></td>
                        <td></td>
                    </tr>
                </table>
            </fieldset>

            <br>

            <fieldset>
                <legend>Doctor Info</legend>
                <table cellpadding="8" width="100%">
                    <tr>
                        <td><b>Doctor:</b></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><b>Department:</b></td>
                        <td></td>
                    </tr>
                </table>
            </fieldset>

            <br>

            <fieldset>
                <legend>Medical Info</legend>
                <p><b>Symptoms:</b> </p>
                <br>
                <p><b>Prescription:</b></p>

                <div>
                    No prescription added yet.
                </div>
            </fieldset>
        </div>
    </div>

    <!-- Cancel Modal -->
    <div class="logout-modal" id="cancel-appointment-modal" style="display: none;">
        <div class="modal-content">
            <h3>Cancel Appointment</h3>
            <p>Are you sure you want to cancel this appointment?</p>
            <textarea placeholder="Reason for cancellation" style="width: 100%; height: 60px;"></textarea>
            <br><br>
            <button onclick="confirmCancel()">Confirm Cancel</button>
            <button onclick="closeCancelModal()" class="btn-cancel">Back</button>
        </div>
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

