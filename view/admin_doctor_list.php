<?php
require_once('../controller/sessionCheck.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Doctor List - Hospital Management System</title>
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

    <!-- Doctor List -->
    <div class="main-container">
        <h2>Doctor List</h2>

        <span class="success-message"></span>

        <!-- Actions -->
        <fieldset>
            <legend>Actions</legend>
            <form method="GET" action="">
                <table>
                    <tr>
                        <td>Search: <input type="text" name="search" value="">
                        </td>
                        <td>
                            Department:
                            <select name="department">
                                <option value="">-- All --</option>
                                <option value="1">Cardiology</option>
                            </select>
                        </td>
                        <td>
                            <input type="submit" value="Filter">
                            <a href="admin_doctor_add.php"><button type="button">Add Doctor</button></a>
                        </td>
                    </tr>
                </table>
            </form>
        </fieldset>

        <br>

        <!-- Doctor Table -->
        <fieldset>
            <legend>All Doctors</legend>
            <table border="1" cellpadding="8" width="100%" id="doctor-table">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Department</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Dr. Md Ehsanul Haque</td>
                    <td>22-49370-3@student.aiub.edu</td>
                    <td>01712378901</td>
                    <td>Cardiology</td>
                    <td>Active</td>
                    <td>
                        <a href="admin_doctor_view.php"><button>View</button></a>
                        <a href="admin_doctor_edit.php"><button>Edit</button></a>
                        <a href="../controller/delete_doctor.php?id=1"><button>Delete</button></a>
                    </td>
                </tr>
            </table>

            <br>
            <div class="pagination-container">
            </div>
        </fieldset>
    </div>

    <script src="../assets/js/admin.js"></script>
</body>

</html>