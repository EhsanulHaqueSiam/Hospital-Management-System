
<!DOCTYPE html>
<html lang="en">

<head>
    <title>View Prescription - Hospital Management System</title>
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
    <!-- Navbar (Hidden on Print) -->
    <div class="navbar">
        <span class="navbar-title">Hospital Management System</span>
        <a href="#" class="navbar-link">Dashboard</a>
        <a href="#" class="navbar-link">My Profile</a>
        <a href="#" class="navbar-link" id="logout-btn">Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main-container">

        <!-- Print Header (Visible only on Print) -->
        <div>
            <h1>AIUB General Hospital</h1>
            <p> 408/1, Kuratoli, Khilkhet, Dhaka 1229, Bangladesh</p>
            <p>Phone: +88 02 841 4050 | Email: aiubinfo@generalhospital.com</p>
        </div>

        <div>
            <a href="prescription_list.php" class="button">Back to List</a>
            <button class="button" onclick="window.print()">🖨️ Print Prescription</button>
            <button class="button">Download PDF</button>

            <button class="button" id="delete-record-btn">Delete</button>
        </div>

        <div>
            <fieldset>
                <legend>Prescription Details</legend>

                <table width="100%" cellpadding="5">
                    <tr>
                        <td width="50%">
                            <b>Patient Name:</b> <br>
                            <b>Age/Gender:</b> <br>
                            <b>ID:</b>
                        </td>
                        <td width="50%" align="right">
                            <b>Prescription ID:</b> <br>
                            <b>Date:</b> <br>
                            <b>Doctor:</b>
                        </td>
                    </tr>
                </table>

                <hr style="margin: 15px 0;">

                <p><b>Diagnosis:</b> </p>

                <br>

                <h3>Rx</h3>
                <table border="1" cellpadding="8" width="100%" style="border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th align="left">Medicine</th>
                            <th align="left">Dosage</th>
                            <th align="left">Frequency</th>
                            <th align="left">Duration</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>

                    </tbody>
                </table>

                <br>
                <p><b>Instructions:</b> </p>

                <br><br><br>

                <table width="100%">
                    <tr>
                        <td width="50%"></td>
                        <td width="50%" align="center" style="border-top: 1px solid black;">
                            Doctor's Signature
                        </td>
                    </tr>
                </table>

            </fieldset>
        </div>
    </div>

    <!-- Delete Modal (Re-using generic delete modal logic) -->
    <div class="logout-modal" id="delete-record-modal" style="display: none;">
        <div class="modal-content">
            <h3>Delete Prescription</h3>
            <p>Are you sure you want to delete this prescription?</p>
            <br>
            <button id="confirm-delete-record">Yes, Delete</button>
            <button id="cancel-delete-record" class="btn-cancel">Cancel</button>
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
