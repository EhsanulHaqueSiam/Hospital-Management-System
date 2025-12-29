<?php
require_once('../controller/sessionCheck.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Create Prescription - Hospital Management System</title>
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
        <h2>Create Prescription</h2>

        <form action="" method="POST" onsubmit="return validatePrescriptionForm(this)">
            <fieldset>
                <legend>Patient Details</legend>
                <table cellpadding="8" width="100%">
                    <tr>
                        <td>Patient:</td>
                        <td>

                            <select name="patient_id" required>
                                <option value="">-- Select Patient --</option>

                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Diagnosis:</td>
                        <td>
                            <input type="text" name="diagnosis" required placeholder="e.g. Common Cold"
                                onblur="validateMinLength(this, 3, 'Diagnosis')">
                        </td>
                    </tr>
                    <tr>
                        <td valign="top">Notes:</td>
                        <td>
                            <textarea name="notes" rows="3" placeholder="Clinical notes..."></textarea>
                        </td>
                    </tr>
                </table>
            </fieldset>

            <br>

            <fieldset>
                <legend>Medications</legend>
                <p>Add medicines below:</p>
                <br>

                <div id="medicines-container">
                    <!-- Initial Row -->
                    <div class="medicine-row">
                        <input type="text" name="medicine_name[]" placeholder="Medicine Name" required style="flex: 2;">
                        <input type="text" name="dosage[]" placeholder="Dosage (e.g. 500mg)" required style="flex: 1;">
                        <input type="text" name="frequency[]" placeholder="Frequency" required style="flex: 1;">
                        <input type="text" name="duration[]" placeholder="Duration" required style="flex: 1;">
                        <button type="button" class="button remove-medicine-btn" style="padding: 5px 10px;">X</button>
                    </div>
                </div>

                <br>
                <button type="button" class="button" id="add-medicine-btn">+ Add Medicine</button>
            </fieldset>

            <br>

            <fieldset>
                <legend>Instructions & Follow-up</legend>
                <table cellpadding="8" width="100%">
                    <tr>
                        <td valign="top">Instructions:</td>
                        <td>
                            <textarea name="instructions" rows="3"
                                placeholder="Patient instructions (e.g. take with food)..."></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Follow-up Date:</td>
                        <td>
                            <input type="date" name="follow_up_date">
                        </td>
                    </tr>
                </table>
            </fieldset>

            <br>

            <div>
                <button type="submit" name="create_prescription" class="button">Create Prescription</button>
                <a href="prescription_list.php" class="button btn-cancel">Cancel</a>
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
