<?php
require_once('../controller/sessionCheck.php');
require_once('../model/patientModel.php');
require_once('../model/userModel.php');

$role = $_SESSION['role'];

if ($role != 'admin' && $role != 'doctor') {
    header('location: dashboard_patient.php');
    exit;
}

$search = isset($_GET['search']) ? $_GET['search'] : '';
if ($search != '') {
    $patients = searchPatients($search);
} else {
    $patients = getAllPatients();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Patient List - Hospital Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <div class="navbar">
        <span class="navbar-title">Hospital Management System</span>
        <?php if ($role == 'admin'): ?>
            <a href="dashboard_admin.php" class="navbar-link">Dashboard</a>
        <?php else: ?>
            <a href="dashboard_doctor.php" class="navbar-link">Dashboard</a>
        <?php endif; ?>
        <a href="profile_view.php" class="navbar-link">My Profile</a>
        <a href="../controller/logout.php" class="navbar-link">Logout</a>
    </div>

    <div class="main-container">
        <h2>Patient Management</h2>

        <fieldset>
            <legend>Actions</legend>
            <table>
                <tr>
                    <td>
                        <form method="GET" action="">
                            Search: <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>">
                            <input type="submit" value="Search">
                            <?php if ($search != ''): ?>
                                <a href="patient_list.php"><button type="button">Clear</button></a>
                            <?php endif; ?>
                        </form>
                    </td>
                    <?php if ($role == 'admin'): ?>
                        <td>
                            <a href="patient_add.php"><button type="button">Add New Patient</button></a>
                        </td>
                    <?php endif; ?>
                </tr>
            </table>
        </fieldset>

        <br>

        <!-- Patient Table -->
        <fieldset>
            <legend>Registered Patients</legend>
            <table border="1" cellpadding="8" width="100%">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Gender</th>
                    <th>Blood Group</th>
                    <th>Actions</th>
                </tr>
                <?php if (count($patients) > 0): ?>
                    <?php foreach ($patients as $patient): ?>
                        <?php
                        $user = getUserById($patient['user_id']);
                        ?>
                        <tr>
                            <td><?php echo $patient['id']; ?></td>
                            <td><?php echo $user ? $user['full_name'] : 'N/A'; ?></td>
                            <td><?php echo $user ? $user['email'] : 'N/A'; ?></td>
                            <td><?php echo $user ? $user['phone'] : 'N/A'; ?></td>
                            <td><?php echo $patient['gender']; ?></td>
                            <td><?php echo $patient['blood_group']; ?></td>
                            <td>
                                <a href="patient_view.php?id=<?php echo $patient['id']; ?>"><button>View</button></a>
                                <?php if ($role == 'admin'): ?>
                                    <a href="patient_edit.php?id=<?php echo $patient['id']; ?>"><button>Edit</button></a>
                                    <a href="../controller/delete_patient.php?id=<?php echo $patient['id']; ?>"
                                        onclick="return confirm('Are you sure?');"><button>Delete</button></a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" align="center">No patients found</td>
                    </tr>
                <?php endif; ?>
            </table>

            <br>

            <div class="pagination-container">
            </div>
        </fieldset>
    </div>
</body>

</html>