<?php
require_once('../controller/sessionCheck.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Department List - Hospital Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <?php include(__DIR__ . "/partials/navbar.php"); ?>
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
                    <th>Doctors</th>
                    <th>Actions</th>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Cardiology</td>
                    <td>Heart and cardiovascular care</td>
                    <td>5</td>
                    <td>
                        <a href="admin_department_edit.php"><button>Edit</button></a>
                        <a href="../controller/delete_department.php?id=1"><button>Delete</button></a>
                    </td>
                </tr>
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
