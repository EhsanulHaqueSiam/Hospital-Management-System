
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Today's Schedule - Hospital Management System</title>
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

        <h2>Today's Schedule - <span id="current-date">Dec 15, 2025</span></h2>

        <div>
            <a href="schedule_list.php" class="button">Back to List</a>
            <button class="button" id="refresh-btn">Refresh Schedule</button>
        </div>

        <fieldset>
            <legend>Dr. Smith's Timeline</legend>
            <table border="1" cellpadding="10" width="100%">
                <thead>
                    <tr>
                        <th width="20%">Time Slot</th>
                        <th>Appointment Details</th>
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
