<?php
require_once('../controller/sessionCheck.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Upload Picture - Hospital Management System</title>
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

    <!-- Upload Picture Form -->
    <div class="main-container">
        <h2>Upload Profile Picture</h2>

        <span class="success-message" id="success-message"></span>

        <form method="POST" action="../controller/upload_picture.php" enctype="multipart/form-data"
            onsubmit="return validatePicture()">
            <fieldset>
                <legend>Profile Picture</legend>
                <table>
                    <tr>
                        <td>Image:</td>
                        <td><input type="file" id="file-input" name="myfile" accept=".jpg,.jpeg,.png,.gif,image/*"
                                onchange="validatePicture()" /></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><small>Max 2MB. Allowed: jpg, jpeg, png, gif</small></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type="submit" name="submit" value="Upload" />
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