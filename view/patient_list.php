<?php
require_once('../controller/sessionCheck.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Patient List - Hospital Management System</title>
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
        <h2>Patient Management</h2>

        <div>
            <a href="patient_add.php" class="button">Add New Patient</a>
            <a href="#" class="button" id="export-xml-btn">Export to XML</a>
        </div>

        <fieldset>
            <legend>Search & Filter</legend>
            <form action="" method="GET">
                <input type="text" name="search" placeholder="Search by Name, Email, Phone...">
                <select name="filter_gender">
                    <option value="">All Genders</option>

                </select>
                <button type="submit" class="button">Search</button>
            </form>
        </fieldset>

        <br>

        <fieldset>
            <legend>Registered Patients</legend>
            <table border="1" cellpadding="10" width="100%">
                <thead>
                    <tr>
                        <th>Patient ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Last Visit</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>

            <br>

            <div class="pagination">
                <span>Page 1 of 5</span>
                <a href="#">Next ></a>
            </div>
        </fieldset>
    </div>

    <!-- Delete Modal -->
    <div id="delete-modal" class="logout-modal">
        <div class="modal-content">
            <h3>Delete Patient</h3>
            <p>Are you sure you want to delete <b id="delete-department-name"></b>?</p>
            <p style="color: red; font-size: 0.9em;">Warning: This will delete all medical records and history.</p>
            <br>
            <button id="confirm-delete">Yes, Delete</button>
            <button id="cancel-delete" class="btn-cancel">Cancel</button>
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

