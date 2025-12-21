
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Prescriptions - Hospital Management System</title>
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
        <h2>Prescription Management</h2>

        <div>

            <a href="prescription_add.php" class="button">Create New Prescription</a>
            <button class="button" id="export-xml-btn">Export to XML</button>
        </div>

        <fieldset>
            <legend>Search Prescriptions</legend>
            <form action="" method="GET">
                <table width="100%">
                    <tr>
                        <td>
                            <input type="text" name="search" placeholder="Search by ID, Patient, or Diagnosis...">
                        </td>
                        <td>

                            <select name="patient_id">
                                <option value="">-- Filter by Patient --</option>

                            </select>
                        </td>
                        <td>
                            <button type="submit" class="button">Search</button>
                            <a href="prescription_list.php" class="button">Reset</a>
                        </td>
                    </tr>
                </table>
            </form>
        </fieldset>

        <br>

        <fieldset>
            <legend>Prescription List</legend>
            <table border="1" cellpadding="10" width="100%">
                <thead>
                    <tr>
                        <th>Prescription ID</th>
                        <th>Patient Name</th>
                        <th>Doctor</th>
                        <th>Diagnosis</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>

            <br>

            <div class="pagination">
                <span>Page 1 of 1</span>
            </div>
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
