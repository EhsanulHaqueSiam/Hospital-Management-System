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
        <a href="dashboard_main.php" class="navbar-link">Dashboard</a>
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
                        <td>Current Picture:</td>
                        <td>
                            <img src="../assets/images/default.jpg" alt="Current Picture" width="100" height="100"
                                id="current-picture">
                        </td>
                    </tr>
                    <tr>
                        <td>New Picture:</td>
                        <td><input type="file" name="profile_picture" id="file-input" accept=".jpg,.jpeg,.png,.gif"
                                onchange="previewPicture()"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><small>Max 2MB. Allowed: jpg, jpeg, png, gif</small></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><span class="error-message" id="file-error"></span></td>
                    </tr>
                    <tr>
                        <td>Preview:</td>
                        <td><img src="" alt="Preview" width="100" height="100" id="preview-picture"
                                style="display:none;"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type="submit" name="upload" value="Upload Picture">
                            <input type="submit" name="remove" value="Remove Picture">
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