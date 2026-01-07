<?php
require_once('../controller/adminCheck.php');
require_once('../model/doctorModel.php');
require_once('../model/userModel.php');
require_once('../model/departmentModel.php');

// Get doctor ID from URL
$doctor_id = isset($_GET['id']) ? $_GET['id'] : 0;

// Fetch doctor info
$doctor = getDoctorById($doctor_id);

if ($doctor) {
    $user = getUserById($doctor['user_id']);
    $dept = $doctor['department_id'] ? getDepartmentById($doctor['department_id']) : null;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>View Doctor - Hospital Management System</title>
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

    <!-- Doctor Details -->
    <div class="main-container">
        <h2>Doctor Details</h2>

        <?php if ($doctor && $user): ?>
            <fieldset>
                <legend>Personal Information</legend>
                <table>
                    <tr>
                        <td>Full Name:</td>
                        <td><?php echo $user['full_name']; ?></td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td><?php echo $user['email']; ?></td>
                    </tr>
                    <tr>
                        <td>Phone:</td>
                        <td><?php echo $user['phone']; ?></td>
                    </tr>
                    <tr>
                        <td>Username:</td>
                        <td><?php echo $user['username']; ?></td>
                    </tr>
                </table>
            </fieldset>

            <br>

            <fieldset>
                <legend>Professional Information</legend>
                <table>
                    <tr>
                        <td>Specialization:</td>
                        <td><?php echo $doctor['specialization']; ?></td>
                    </tr>
                    <tr>
                        <td>Department:</td>
                        <td><?php echo $dept ? $dept['department_name'] : 'N/A'; ?></td>
                    </tr>
                    <tr>
                        <td>Bio:</td>
                        <td><?php echo $doctor['bio']; ?></td>
                    </tr>
                </table>
            </fieldset>

            <br>
            <a href="admin_doctor_edit.php?id=<?php echo $doctor['id']; ?>"><button>Edit Doctor</button></a>
            <a href="admin_doctor_assign.php?id=<?php echo $doctor['id']; ?>"><button>Assign Dept</button></a>
            <a href="../controller/delete_doctor.php?id=<?php echo $doctor['id']; ?>"
                onclick="return confirm('Are you sure you want to delete this doctor?');"><button>Delete</button></a>
            <a href="admin_doctor_list.php"><button>Back to List</button></a>
        <?php else: ?>
            <p>Doctor not found.</p>
            <a href="admin_doctor_list.php"><button>Back to List</button></a>
        <?php endif; ?>
    </div>

    <script src="../assets/js/admin.js"></script>
</body>

</html>