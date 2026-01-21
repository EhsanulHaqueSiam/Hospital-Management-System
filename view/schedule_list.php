<?php
require_once('../controller/sessionCheck.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Appointment Schedule - Hospital Management System</title>
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
        <h2>Appointment Schedule</h2>

        <div>
            <a href="schedule_today.php" class="button">View Today's Timeline</a>
            <button class="button" id="print-btn">Print Schedule</button>
        </div>

        <fieldset>
            <legend>Filter Options</legend>
            <form action="" method="GET">
                <table width="100%">
                    <tr>
                        <td>

                            <select name="doctor_id">
                                <option value="">-- All Doctors --</option>

                            </select>
                        </td>
                        <td>
                            <label>From:</label>
                            <input type="date" name="date_from">
                        </td>
                        <td>
                            <label>To:</label>
                            <input type="date" name="date_to">
                        </td>
                        <td>
                            <button type="submit" class="button">Apply Filter</button>
                            <a href="schedule_list.php" class="button">Reset</a>
                        </td>
                    </tr>
                </table>
            </form>

            <br>

            <button class="filter-btn active">All</button>
        </fieldset>

        <br>

        <fieldset>
            <legend>Schedule Results</legend>

            <p>Showing appointments for: <b>All Dates</b></p>

            <table border="1" cellpadding="10" width="100%">
                <thead>
                    <tr>
                        <th>Time</th>
                        <th>Patient Name</th>
                        <th>Doctor</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </fieldset>
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

