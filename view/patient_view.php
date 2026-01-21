<?php
require_once('../controller/sessionCheck.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Patient Details - Hospital Management System</title>
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
        <h2>Patient Details</h2>

        <div>
            <a href="patient_list.php" class="button">Back to List</a>

            <a href="patient_edit.php?id=" class="button">Edit Profile</a>
        </div>



        <div>
            <fieldset>
                <legend>Personal Information</legend>
                <table cellpadding="8" width="100%">
                    <tr>
                        <td width="20%"><b>Patient ID:</b></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><b>Full Name:</b></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><b>Date of Birth:</b></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><b>Gender:</b></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><b>Blood Group:</b></td>
                        <td></td>
                    </tr>
                </table>
            </fieldset>

            <br>

            <fieldset>
                <legend>Contact Information</legend>
                <table cellpadding="8" width="100%">
                    <tr>
                        <td width="20%"><b>Email:</b></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><b>Phone:</b></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><b>Address:</b></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><b>Emergency Contact:</b></td>
                        <td></td>
                    </tr>
                </table>
            </fieldset>

            <br>

            <fieldset>
                <legend>Medical History</legend>

                <table border="1" cellpadding="5" width="100%">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Doctor</th>
                            <th>Diagnosis/Reason</th>
                            <th>Prescription</th>
                        </tr>
                    </thead>
                    <tbody>



                    </tbody>
                </table>
            </fieldset>

            <br>

            <fieldset>
                <legend>Usage & Billing</legend>
                <table border="1" cellpadding="5" width="100%">
                    <thead>
                        <tr>
                            <th>Bill ID</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>


                    </tbody>
                </table>
            </fieldset>
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

