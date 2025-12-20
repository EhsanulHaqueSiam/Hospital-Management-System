<?php
require_once('../controller/sessionCheck.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Add Department - Hospital Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <div class="navbar">
        <span class="navbar-title">Hospital Management System</span>
        <a href="dashboard_admin.php" class="navbar-link">Dashboard</a>
        <a href="profile_view.php" class="navbar-link">My Profile</a>
        <a href="../controller/logout.php" class="navbar-link">Logout</a>
    </div>

    <div class="main-container">
        <h2>Add Department</h2>

        <span class="success-message"></span>

        <form method="POST" action="../controller/add_department.php" onsubmit="return validateDepartment()">
            <fieldset>
                <legend>Department Information</legend>
                <table>
                    <tr>
                        <td>Department Name:</td>
                        <td><input type="text" name="department_name" onblur="validateDeptNameBlur()" required></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><span class="error-message" id="department-name-error"></span></td>
                    </tr>
                    <tr>
                        <td>Description:</td>
                        <td><textarea name="description" rows="4" cols="40"></textarea></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type="submit" name="add_department" value="Add Department">
                            <a href="admin_department_list.php"><button type="button">Cancel</button></a>
                        </td>
                    </tr>
                </table>
            </fieldset>
        </form>
    </div>

    <script src="../assets/js/admin.js"></script>
</body>

</html>