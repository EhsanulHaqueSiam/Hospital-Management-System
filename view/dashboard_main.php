<?php
require_once('../controller/sessionCheck.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Dashboard - Hospital Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <?php include(__DIR__ . "/partials/navbar.php"); ?>
    <!-- Navbar -->
    <div class="navbar">
        <span class="navbar-title">Hospital Management System</span>
        <a href="dashboard_main.php" class="navbar-link">Dashboard</a>
        <a href="profile_view.php" class="navbar-link">My Profile</a>
        <a href="../controller/logout.php" class="navbar-link">Logout</a>
    </div>

    <!-- Dashboard Selection -->
    <div class="main-container">
        <h2>Select Dashboard</h2>
        <p>Welcome, <?php echo $_SESSION['username']; ?></p>

        <br>

        <fieldset>
            <legend>Choose Your Dashboard</legend>
            <table>
                <tr>
                    <td><a href="dashboard_admin.php"><button>Admin Dashboard</button></a></td>
                    <td>For hospital administrators</td>
                </tr>
                <tr>
                    <td><a href="dashboard_doctor.php"><button>Doctor Dashboard</button></a></td>
                    <td>For doctors</td>
                </tr>
                <tr>
                    <td><a href="dashboard_patient.php"><button>Patient Dashboard</button></a></td>
                    <td>For patients</td>
                </tr>
            </table>
        </fieldset>
    </div>

    <script src="../assets/js/dashboard.js"></script>
</body>

</html>
