<?php
require_once('../controller/adminCheck.php');
require_once('../model/departmentModel.php');

$id = isset($_GET['id']) ? $_GET['id'] : 0;
$department = getDepartmentById($id);

if (!$department) {
    header('location: admin_department_list.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Department - Hospital Management System</title>
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
        <h2>Edit Department</h2>

        <form method="POST" action="../controller/edit_department.php">
            <input type="hidden" name="id" value="<?php echo $department['id']; ?>">

            <fieldset>
                <legend>Department Information</legend>
                <table>
                    <tr>
                        <td>Department ID:</td>
                        <td><b><?php echo $department['id']; ?></b></td>
                    </tr>
                    <tr>
                        <td>Department Name:</td>
                        <td><input type="text" name="department_name"
                                value="<?php echo $department['department_name']; ?>" required></td>
                    </tr>
                    <tr>
                        <td>Description:</td>
                        <td><textarea name="description" rows="4"
                                cols="40"><?php echo $department['description']; ?></textarea></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type="submit" name="submit" value="Update Department">
                            <a href="admin_department_list.php"><button type="button">Cancel</button></a>
                        </td>
                    </tr>
                </table>
            </fieldset>
        </form>
    </div>
</body>

</html>