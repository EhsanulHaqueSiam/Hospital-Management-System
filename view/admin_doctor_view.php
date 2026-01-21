<?php
require_once('../controller/sessionCheck.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>View Doctor - Hospital Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <?php include(__DIR__ . "/partials/navbar.php"); ?>
    <!-- Navbar -->
    <div class="navbar">
        <span class="navbar-title">Hospital Management System</span>
        <a href="dashboard_admin.php" class="navbar-link">Dashboard</a>
        <a href="profile_view.php" class="navbar-link">My Profile</a>
        <a href="../controller/logout.php" class="navbar-link">Logout</a>
    </div>

    <!-- View Doctor Details -->
    <div class="main-container">
        <h2>Doctor Details</h2>

        <fieldset>
            <legend>Doctor Information</legend>
            <table>
                <tr>
                    <td>Profile Picture:</td>
                    <td><img src="../assets/images/default.jpg" alt="" width="100" height="100"></td>
                </tr>
                <tr>
                    <td>Doctor ID:</td>
                    <td>1</td>
                </tr>
                <tr>
                    <td>Full Name:</td>
                    <td>Dr. Md Ehsanul Haque</td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td>22-49370-3@student.aiub.edu</td>
                </tr>
                <tr>
                    <td>Phone:</td>
                    <td>01712378901</td>
                </tr>
                <tr>
                    <td>Username:</td>
                    <td>siam</td>
                </tr>
                <tr>
                    <td>Department:</td>
                    <td>Cardiology</td>
                </tr>
                <tr>
                    <td>Specialization:</td>
                    <td>Cardiologist</td>
                </tr>
                <tr>
                    <td>Bio:</td>
                    <td>Experienced cardiologist with 10 years of practice.</td>
                </tr>
                <tr>
                    <td>Status:</td>
                    <td>Active</td>
                </tr>
                <tr>
                    <td>Registered:</td>
                    <td>2024-01-01</td>
                </tr>
            </table>
        </fieldset>

        <br>
        <a href="admin_doctor_edit.php"><button>Edit Doctor</button></a>
        <a href="admin_doctor_list.php"><button>Back to List</button></a>
    </div>

    <script src="../assets/js/admin.js"></script>
</body>

</html>
