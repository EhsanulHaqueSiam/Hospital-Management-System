<?php
require_once('../controller/adminCheck.php');
require_once('../model/departmentModel.php');

// Fetch all departments
$departments = getAllDepartments();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Department List - Hospital Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <!-- Navbar -->
    <div class="navbar">
        <span class="navbar-title">Hospital Management System</span>
        <a href="dashboard_admin.php" class="navbar-link">Dashboard</a>
        <a href="profile_view.php" class="navbar-link">My Profile</a>
        <a href="../controller/logout.php" class="navbar-link">Logout</a>
    </div>

    <!-- Department List -->
    <div class="main-container">
        <h2>Department List</h2>

        <span class="success-message"></span>

        <!-- Actions -->
        <fieldset>
            <legend>Actions</legend>
            <table>
                <tr>
                    <td>
                        <form method="GET" action="">
                            Search: <input type="text" name="search" value="">
                            <input type="submit" value="Search">
                        </form>
                    </td>
                    <td>
                        <a href="admin_department_add.php"><button>Add Department</button></a>
                    </td>
                </tr>
            </table>
        </fieldset>

        <br>

        <!-- Department Table -->
        <fieldset>
            <legend>All Departments</legend>
            <table border="1" cellpadding="8" width="100%" id="department-table">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
                <?php if (count($departments) > 0): ?>
                    <?php foreach ($departments as $dept): ?>
                        <tr>
                            <td><?php echo $dept['id']; ?></td>
                            <td><?php echo $dept['department_name']; ?></td>
                            <td><?php echo $dept['description']; ?></td>
                            <td>
                                <a href="admin_department_edit.php?id=<?php echo $dept['id']; ?>"><button>Edit</button></a>
                                <a href="../controller/delete_department.php?id=<?php echo $dept['id']; ?>"
                                    onclick="return confirm('Are you sure?');"><button>Delete</button></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" align="center">No departments found</td>
                    </tr>
                <?php endif; ?>
            </table>

            <br>

            <!-- Pagination -->
            <div class="pagination-container">
            </div>
        </fieldset>
    </div>

    <script src="../assets/js/admin.js"></script>
</body>

</html>