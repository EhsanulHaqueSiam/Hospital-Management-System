<?php
require_once('../controller/adminCheck.php');
require_once('../model/patientModel.php');
require_once('../model/doctorModel.php');
require_once('../model/appointmentModel.php');
$patients = getAllPatients();
$doctors = getAllDoctors();
$appointments = getAllAppointments();

$totalPatients = count($patients);
$totalDoctors = count($doctors);
$totalAppointments = count($appointments);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin Dashboard - Hospital Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <!-- Navbar -->
    <div class="navbar">
        <span class="navbar-title">Hospital Management System</span>
        <a href="dashboard_admin.php" class="navbar-link">Dashboard</a>
        <a href="profile_view.php" class="navbar-link">My Profile</a>
        <a href="../controller/logout.php" class="navbar-link">Logout</a>
    </div>

    <!-- Dashboard Content -->
    <div class="main-container">
        <h2>Admin Dashboard</h2>
        <p>Welcome, <?php echo $_SESSION['username']; ?></p>

        <!-- Stats -->
        <fieldset>
            <legend>Hospital Statistics</legend>
            <table border="1" cellpadding="10">
                <tr>
                    <td align="center"><b>Total Patients</b><br><br><?php echo $totalPatients; ?></td>
                    <td align="center"><b>Total Doctors</b><br><br><?php echo $totalDoctors; ?></td>
                    <td align="center"><b>Total Appointments</b><br><br><?php echo $totalAppointments; ?></td>
                </tr>
            </table>
        </fieldset>

        <br>

        <!-- Quick Links -->
        <fieldset>
            <legend>Quick Actions</legend>
            <a href="admin_department_list.php"><button>Manage Departments</button></a>
            <a href="admin_doctor_list.php"><button>Manage Doctors</button></a>
            <a href="patient_list.php"><button>Manage Patients</button></a>
            <a href="appointment_list.php"><button>Manage Appointments</button></a>
            <a href="schedule_today.php"><button>Today's Schedule</button></a>
            <a href="schedule_list.php"><button>Full Schedule</button></a>
            <a href="prescription_list.php"><button>Manage Prescriptions</button></a>
            <a href="record_list.php"><button>Medical Records</button></a>
            <!-- New Features -->
            <a href="medicine_list.php"><button>Manage Medicines</button></a>
            <a href="bill_list.php"><button>Billing & Invoices</button></a>
            <a href="payment_list.php"><button>Payments</button></a>
            <a href="room_list.php"><button>Manage Rooms</button></a>
        </fieldset>

        <br>

        <!-- Recent Appointments -->
        <fieldset>
            <legend>Recent Appointments</legend>
            <table border="1" cellpadding="8" width="100%">
                <tr>
                    <th>ID</th>
                    <th>Patient ID</th>
                    <th>Doctor ID</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Reason</th>
                    <th>Status</th>
                </tr>
                <?php if (count($appointments) > 0): ?>
                    <?php foreach (array_slice($appointments, 0, 5) as $appointment): ?>
                        <tr>
                            <td><?php echo $appointment['id']; ?></td>
                            <td><?php echo $appointment['patient_id']; ?></td>
                            <td><?php echo $appointment['doctor_id']; ?></td>
                            <td><?php echo $appointment['appointment_date']; ?></td>
                            <td><?php echo isset($appointment['appointment_time']) ? $appointment['appointment_time'] : 'N/A'; ?>
                            </td>
                            <td><?php echo $appointment['reason']; ?></td>
                            <td><?php echo $appointment['status']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" align="center">No appointments found</td>
                    </tr>
                <?php endif; ?>
            </table>
        </fieldset>
    </div>
</body>

</html>