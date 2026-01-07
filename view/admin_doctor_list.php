<?php
require_once('../controller/adminCheck.php');
require_once('../model/doctorModel.php');
require_once('../model/userModel.php');
require_once('../model/departmentModel.php');

$search = isset($_GET['search']) ? $_GET['search'] : '';
if ($search != '') {
    $doctors = searchDoctors($search);
} else {
    $doctors = getAllDoctors();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Doctor List - Hospital Management System</title>
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
        <h2>Doctor List</h2>

        <fieldset>
            <legend>Actions</legend>
            <table>
                <tr>
                    <td>
                        <form method="GET" action="">
                            Search: <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>">
                            <input type="submit" value="Search">
                            <?php if ($search != ''): ?>
                                <a href="admin_doctor_list.php"><button type="button">Clear</button></a>
                            <?php endif; ?>
                        </form>
                    </td>
                    <td>
                        <a href="admin_doctor_add.php"><button type="button">Add Doctor</button></a>
                    </td>
                </tr>
            </table>
        </fieldset>

        <br>

        <!-- Doctor Table -->
        <fieldset>
            <legend>All Doctors</legend>
            <table border="1" cellpadding="8" width="100%">
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Specialization</th>
                    <th>Department</th>
                    <th>Bio</th>
                    <th>Actions</th>
                </tr>
                <?php if (count($doctors) > 0): ?>
                    <?php foreach ($doctors as $doctor): ?>
                        <?php
                        // Fetch user and department info separately
                        $user = getUserById($doctor['user_id']);
                        $dept = $doctor['department_id'] ? getDepartmentById($doctor['department_id']) : null;
                        ?>
                        <tr>
                            <td><?php echo $doctor['id']; ?></td>
                            <td><?php echo $user ? $user['full_name'] : 'N/A'; ?></td>
                            <td><?php echo $user ? $user['email'] : 'N/A'; ?></td>
                            <td><?php echo $user ? $user['phone'] : 'N/A'; ?></td>
                            <td><?php echo $doctor['specialization']; ?></td>
                            <td><?php echo $dept ? $dept['department_name'] : 'N/A'; ?></td>
                            <td><?php echo substr($doctor['bio'], 0, 50) . '...'; ?></td>
                            <td>
                                <a href="admin_doctor_view.php?id=<?php echo $doctor['id']; ?>"><button>View</button></a>
                                <a href="admin_doctor_edit.php?id=<?php echo $doctor['id']; ?>"><button>Edit</button></a>
                                <a href="admin_doctor_assign.php?id=<?php echo $doctor['id']; ?>"><button>Assign
                                        Dept</button></a>
                                <a href="../controller/delete_doctor.php?id=<?php echo $doctor['id']; ?>"
                                    onclick="return confirm('Are you sure?');"><button>Delete</button></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" align="center">No doctors found</td>
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