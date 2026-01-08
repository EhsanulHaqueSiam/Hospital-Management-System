<?php
require_once('../controller/sessionCheck.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Change Password - Hospital Management System</title>
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

    <div class="main-container">
        <h2>Change Password</h2>

        <span class="success-message" id="success-message"></span>

        <form method="POST" action="../controller/change_password.php" onsubmit="return validateChangePassword()">
            <fieldset>
                <legend>Update Password</legend>
                <table>
                    <tr>
                        <td>Current Password:</td>
                        <td><input type="password" name="current_password" onblur="validateCurrentPasswordBlur()"
                                required></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><span class="error-message" id="current-password-error"></span></td>
                    </tr>
                    <tr>
                        <td>New Password:</td>
                        <td><input type="password" name="new_password" onblur="validateNewPasswordBlur()" required></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><span class="error-message" id="new-password-error"></span></td>
                    </tr>
                    <tr>
                        <td>Confirm Password:</td>
                        <td><input type="password" name="confirm_password" onblur="validateConfirmNewPasswordBlur()"
                                required></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><span class="error-message" id="confirm-password-error"></span></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type="submit" name="change_password" value="Change Password">
                            <a href="profile_view.php"><button type="button">Cancel</button></a>
                        </td>
                    </tr>
                </table>
            </fieldset>
        </form>
    </div>

    <script src="../assets/js/profile.js"></script>
</body>

</html>