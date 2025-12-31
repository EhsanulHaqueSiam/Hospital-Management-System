<?php
require_once('../controller/sessionCheck.php');
require_once('../model/patientModel.php');
require_once('../model/doctorModel.php');
require_once('../model/departmentModel.php');
require_once('../model/userModel.php');

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

// Fetch all patients and doctors for dropdowns
$patients = getAllPatients();
$doctors = getAllDoctors();
$departments = getAllDepartments();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Book Appointment - Hospital Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <!-- Navbar -->
    <div class="navbar">
        <span class="navbar-title">Hospital Management System</span>
        <?php if ($role == 'admin'): ?>
            <a href="dashboard_admin.php" class="navbar-link">Dashboard</a>
        <?php elseif ($role == 'doctor'): ?>
            <a href="dashboard_doctor.php" class="navbar-link">Dashboard</a>
        <?php else: ?>
            <a href="dashboard_patient.php" class="navbar-link">Dashboard</a>
        <?php endif; ?>
        <a href="profile_view.php" class="navbar-link">My Profile</a>
        <a href="../controller/logout.php" class="navbar-link">Logout</a>
    </div>

    <!-- Book Appointment Form -->
    <div class="main-container">
        <h2>Book New Appointment</h2>

        <form method="POST" action="../controller/add_appointment.php">
            <fieldset>
                <legend>Appointment Details</legend>
                <table cellpadding="8" width="100%">
                    <tr>
                        <td>Patient:</td>
                        <td>
                            <?php if ($role == 'patient'): ?>
                                <?php
                                $patient = getPatientByUserId($user_id);
                                $patient_user = $patient ? getUserById($patient['user_id']) : null;
                                ?>
                                <input type="hidden" name="patient_id" value="<?php echo $patient['id']; ?>">
                                <input type="text" value="<?php echo $patient_user['full_name']; ?>" disabled>
                            <?php else: ?>
                                <select name="patient_id" required>
                                    <option value="">-- Select Patient --</option>
                                    <?php foreach ($patients as $p): ?>
                                        <?php $p_user = getUserById($p['user_id']); ?>
                                        <option value="<?php echo $p['id']; ?>"><?php echo $p_user['full_name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Department:</td>
                        <td>
                            <select name="department_id" id="department_id">
                                <option value="">-- Select Department --</option>
                                <?php foreach ($departments as $dept): ?>
                                    <option value="<?php echo $dept['id']; ?>"><?php echo $dept['department_name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Doctor:</td>
                        <td>
                            <select name="doctor_id" required>
                                <option value="">-- Select Doctor --</option>
                                <?php foreach ($doctors as $d): ?>
                                    <?php $d_user = getUserById($d['user_id']); ?>
                                    <option value="<?php echo $d['id']; ?>"><?php echo $d_user['full_name']; ?> -
                                        <?php echo $d['specialization']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Date:</td>
                        <td><input type="date" name="appointment_date" required></td>
                    </tr>
                    <tr>
                        <td>Time:</td>
                        <td>
                            <select name="appointment_time" required>
                                <option value="">-- Select Time --</option>
                                <option value="09:00:00">09:00 AM</option>
                                <option value="09:30:00">09:30 AM</option>
                                <option value="10:00:00">10:00 AM</option>
                                <option value="10:30:00">10:30 AM</option>
                                <option value="11:00:00">11:00 AM</option>
                                <option value="11:30:00">11:30 AM</option>
                                <option value="12:00:00">12:00 PM</option>
                                <option value="14:00:00">02:00 PM</option>
                                <option value="14:30:00">02:30 PM</option>
                                <option value="15:00:00">03:00 PM</option>
                                <option value="15:30:00">03:30 PM</option>
                                <option value="16:00:00">04:00 PM</option>
                                <option value="16:30:00">04:30 PM</option>
                            </select>
                        </td>
                    </tr>
                </table>
            </fieldset>

            <br>

            <fieldset>
                <legend>Medical Info</legend>
                <table cellpadding="8" width="100%">
                    <tr>
                        <td>Reason:</td>
                        <td><textarea name="reason" rows="3" cols="50"
                                placeholder="Describe symptoms or reason for visit"></textarea></td>
                    </tr>
                </table>
            </fieldset>

            <br>

            <div>
                <input type="submit" name="submit" value="Book Appointment">
                <a href="appointment_list.php"><button type="button">Cancel</button></a>
            </div>
        </form>
    </div>
</body>

</html>