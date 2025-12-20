<?php
require_once('../controller/sessionCheck.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>View Profile - Hospital Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <!-- Navbar -->
    <div class="navbar">
        <span class="navbar-title">Hospital Management System</span>
        <a href="dashboard_main.php" class="navbar-link">Dashboard</a>
        <a href="profile_view.php" class="navbar-link">My Profile</a>
        <a href="../controller/logout.php" class="navbar-link">Logout</a>
    </div>

    <!-- Profile Content -->
    <div class="main-container">
        <h2>My Profile</h2>

        <fieldset>
            <legend>Profile Information</legend>
            <table>
                <tr>
                    <td>Profile Picture:</td>
                    <td>
                        <img src="../assets/images/default.jpg" alt="Profile Picture" width="100" height="100"
                            id="profile-picture">
                    </td>
                </tr>
                <tr>
                    <td>Full Name:</td>
                    <td>Md Ehsanul Haque</td>
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
                    <td><?php echo $_SESSION['username']; ?></td>
                </tr>
                <tr>
                    <td>Role:</td>
                    <td>Patient</td>
                </tr>
                <tr>
                    <td>Registration Date:</td>
                    <td>2024-01-01</td>
                </tr>
                <tr>
                    <td>Address:</td>
                    <td>1 Kuratoli, Dhaka 1229</td>
                </tr>
            </table>
        </fieldset>

        <br>
        <a href="profile_edit.php"><button>Edit Profile</button></a>
        <a href="profile_upload_picture.php"><button>Change Picture</button></a>
        <a href="profile_change_password.php"><button>Change Password</button></a>
    </div>

    <script src="../assets/js/profile.js"></script>
</body>

</html>