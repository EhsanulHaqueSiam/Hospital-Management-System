<?php
require_once('../controller/adminCheck.php');
require_once('../model/roomModel.php');
require_once('../model/patientModel.php');
require_once('../model/userModel.php');

$rooms = getAllRooms();
$patients = getAllPatients();
?>

<html>

<head>
    <title>Assign Room - Hospital Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

    <div class="navbar">
        <span class="navbar-title">Hospital Management System</span>
        <a href="dashboard_admin.php" class="navbar-link">Dashboard</a>
        <a href="room_list.php" class="navbar-link">Rooms</a>
        <a href="../controller/logout.php" class="navbar-link">Logout</a>
    </div>

    <div class="main-container">
        <h2>Assign Patient to Room</h2>

        <form method="POST" action="../controller/assign_patient_room.php" onsubmit="return validateAssignForm(this)">
            <fieldset>
                <legend>Assignment Details</legend>
                <table cellpadding="5">
                    <tr>
                        <td>Select Patient:</td>
                        <td>
                            <select name="patient_id" required onchange="validateSelectBlur(this, 'Patient')">
                                <option value="">-- Select Patient --</option>
                                <?php foreach ($patients as $p): ?>
                                    <?php $user = getUserById($p['user_id']); ?>
                                    <option value="<?php echo $p['id']; ?>">
                                        <?php echo $user['full_name']; ?> (ID:
                                        <?php echo $p['id']; ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Select Room:</td>
                        <td>
                            <select name="room_id" required onchange="validateSelectBlur(this, 'Room')">
                                <option value="">-- Select Available Room --</option>
                                <?php foreach ($rooms as $r): ?>
                                    <?php if ($r['status'] == 'Available'): ?>
                                        <option value="<?php echo $r['id']; ?>">
                                            <?php echo $r['room_number']; ?> -
                                            <?php echo $r['room_type']; ?>
                                            (Price:
                                            <?php echo $r['price_per_day']; ?>)
                                        </option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Admission Date:</td>
                        <td><input type="date" name="admission_date" id="admission_date"
                                value="<?php echo date('Y-m-d'); ?>" required
                                onchange="validateDateBlur(this, 'Admission Date'); validateDischargeDate();"></td>
                    </tr>
                    <tr>
                        <td>Expected Discharge:</td>
                        <td><input type="date" name="expected_discharge_date" id="expected_discharge_date"
                                onchange="validateDischargeDate()"></td>
                    </tr>
                    <tr>
                        <td>Admission Notes:</td>
                        <td><textarea name="notes" rows="2"></textarea></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right">
                            <input type="submit" name="submit" value="Assign Room">
                            <a href="room_list.php"><button type="button">Cancel</button></a>
                        </td>
                    </tr>
                </table>
        </form>
        </fieldset>
    </div>
    <script src="../assets/js/validation-common.js"></script>
    <script>
        function validateDischargeDate() {
            var admission = document.getElementById('admission_date');
            var discharge = document.getElementById('expected_discharge_date');

            if (!discharge.value) {
                clearFieldError(discharge);
                return true;
            }

            if (admission.value) {
                var admDate = new Date(admission.value);
                var disDate = new Date(discharge.value);
                admDate.setHours(0, 0, 0, 0);
                disDate.setHours(0, 0, 0, 0);

                if (disDate < admDate) {
                    showFieldError(discharge, 'Discharge cannot be before Admission');
                    return false;
                }
            }
            clearFieldError(discharge);
            return true;
        }

        function validateAssignForm(form) {
            if (!validateForm(form)) return false;
            if (!validateDischargeDate()) return false;
            return true;
        }
    </script>
</body>

</html>