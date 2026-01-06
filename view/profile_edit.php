<?php
require_once('../controller/sessionCheck.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Profile - Hospital Management System</title>
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
            // Undefined role - redirect to logout
            header('location: ../controller/logout.php');
            exit;
        }
        ?>
        <a href="<?php echo $dashboard_link; ?>" class="navbar-link">Dashboard</a>
        <a href="profile_view.php" class="navbar-link">My Profile</a>
        <a href="../controller/logout.php" class="navbar-link">Logout</a>
    </div>

    <div class="main-container">
        <h2>Edit Profile</h2>

        <span class="success-message" id="success-message"></span>

        <?php
        require_once('../model/userModel.php');
        $user = getUserById($_SESSION['user_id']);
        ?>

        <form method="POST" action="../controller/edit_profile.php" onsubmit="return validateEditProfile()">
            <fieldset>
                <legend>Update Information</legend>
                <table>
                    <tr>
                        <td>Full Name:</td>
                        <td><input type="text" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>"
                                onblur="validateProfileNameBlur()" required></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><span class="error-message" id="fullname-error"></span></td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td><input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required></td>
                    </tr>
                    <tr>
                        <td>Phone:</td>
                        <td><input type="tel" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" onblur="validateProfilePhoneBlur()"
                                required></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><span class="error-message" id="phone-error"></span></td>
                    </tr>
                    <tr>
                        <td>Address:</td>
                        <td><input type="text" name="address" value="<?php echo htmlspecialchars($user['address'] ?? ''); ?>"></td>
                    </tr>

                    <?php if ($_SESSION['role'] == 'doctor'): ?>
                    <tr class="doctor-only-field">
                        <td>Specialization:</td>
                        <td><input type="text" name="specialization" value=""></td>
                    </tr>
                    <tr class="doctor-only-field">
                        <td></td>
                        <td><span class="error-message" id="specialization-error"></span></td>
                    </tr>
                    <tr class="doctor-only-field">
                        <td>Bio:</td>
                        <td><textarea name="bio" rows="4" cols="30"></textarea></td>
                    </tr>
                    <?php endif; ?>

                    <tr>
                        <td></td>
                        <td>
                            <input type="submit" name="submit" value="Update Profile">
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