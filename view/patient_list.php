<?php
require_once('../controller/adminCheck.php');
require_once('../model/patientModel.php');
require_once('../model/userModel.php');

// Fetch all patients
$patients = getAllPatients();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Patient List - Hospital Management System</title>
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

    <!-- Patient List -->
    <div class="main-container">
        <h2>Patient Management</h2>

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
                        <a href="patient_add.php"><button type="button">Add New Patient</button></a>
                    </td>
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
                        // Fetch user info
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
                                <a href="patient_edit.php?id=<?php echo $patient['id']; ?>"><button>Edit</button></a>
                                <a href="../controller/delete_patient.php?id=<?php echo $patient['id']; ?>"
                                    onclick="return confirm('Are you sure?');"><button>Delete</button></a>
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

            <!-- Pagination -->
            <div class="pagination-container">
            </div>
        </fieldset>
    </div>
</body>

</html>