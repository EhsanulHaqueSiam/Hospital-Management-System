<?php
require_once('../controller/sessionCheck.php');
require_once('../model/userModel.php');
$user = getUserById($_SESSION['user_id']);
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
        <?php
        if ($_SESSION['role'] == 'admin') {
            $dashboard_link = 'dashboard_admin.php';
        } elseif ($_SESSION['role'] == 'doctor') {
            $dashboard_link = 'dashboard_doctor.php';
        } elseif ($_SESSION['role'] == 'patient') {
            $dashboard_link = 'dashboard_patient.php';
        } else {
            header('location: ../controller/logout.php');
            exit;
        }
        ?>
        <a href="<?php echo $dashboard_link; ?>" class="navbar-link">Dashboard</a>
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
                        <img src="<?php echo $user && $user['profile_picture'] ? $user['profile_picture'] : '../assets/images/default.jpg'; ?>"
                            alt="Profile Picture" width="100" height="100" id="profile-picture">
                    </td>
                </tr>
                <tr>
                    <td>Full Name:</td>
                    <td><?php echo $user ? $user['full_name'] : 'N/A'; ?></td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><?php echo $user ? $user['email'] : 'N/A'; ?></td>
                </tr>
                <tr>
                    <td>Phone:</td>
                    <td><?php echo $user ? $user['phone'] : 'N/A'; ?></td>
                </tr>
                <tr>
                    <td>Username:</td>
                    <td><?php echo $user ? $user['username'] : 'N/A'; ?></td>
                </tr>
                <tr>
                    <td>Role:</td>
                    <td><?php echo $user ? $user['role'] : 'N/A'; ?></td>
                </tr>
                <tr>
                    <td>Registration Date:</td>
                    <td><?php echo $user ? $user['registration_date'] : 'N/A'; ?></td>
                </tr>
                <tr>
                    <td>Address:</td>
                    <td><?php echo $user && $user['address'] ? $user['address'] : 'N/A'; ?></td>
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