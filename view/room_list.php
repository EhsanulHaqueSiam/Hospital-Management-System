<?php
require_once('../controller/adminCheck.php');
require_once('../model/roomModel.php');

$rooms = getAllRooms();
$assignments = getActiveAssignments();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Room Management - Hospital Management System</title>
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

    <div class="main-container">
        <h2>Room Management</h2>

        <fieldset>
            <legend>Actions</legend>
            <a href="room_add.php"><button type="button">Add New Room</button></a>
            <a href="room_assign.php"><button type="button">Assign Patient to Room</button></a>
        </fieldset>

        <br>

        <!-- Rooms Table -->
        <fieldset>
            <legend>All Rooms</legend>
            <table border="1" cellpadding="8" width="100%">
                <tr>
                    <th>Room No</th>
                    <th>Type</th>
                    <th>Floor</th>
                    <th>Price/Day</th>
                    <th>Capacity</th>
                    <th>Occupancy</th>
                    <th>Facilities</th>
                    <th>Actions</th>
                </tr>
                <?php if (count($rooms) > 0): ?>
                    <?php foreach ($rooms as $room): ?>
                        <?php
                        $occupancy = getRoomOccupancy($room['id']);
                        $capacity = $room['capacity'];
                        $isFull = ($occupancy >= $capacity);
                        ?>
                        <tr <?php if ($isFull)
                            echo 'style="background-color: #ffe6e6;"'; ?>>
                            <td>
                                <?php echo $room['room_number']; ?>
                            </td>
                            <td>
                                <?php echo $room['room_type']; ?>
                            </td>
                            <td>
                                <?php echo $room['floor']; ?>
                            </td>
                            <td>
                                <?php echo $room['price_per_day']; ?>
                            </td>
                            <td>
                                <?php echo $capacity; ?>
                            </td>
                            <td><strong>
                                    <?php echo $occupancy . '/' . $capacity; ?>
                                    <?php if ($isFull): ?>
                                        <span style="color: red;">(Full)</span>
                                    <?php elseif ($occupancy > 0): ?>
                                        <span style="color: orange;">(Partial)</span>
                                    <?php else: ?>
                                        <span style="color: green;">(Available)</span>
                                    <?php endif; ?>
                                </strong></td>
                            <td>
                                <?php echo $room['facilities']; ?>
                            </td>
                            <td>
                                <a href="room_edit.php?id=<?php echo $room['id']; ?>"><button>Edit</button></a>
                                <a href="../controller/delete_room.php?id=<?php echo $room['id']; ?>"
                                    onclick="return confirm('Delete this room?');"><button>Delete</button></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" align="center">No rooms found</td>
                    </tr>
                <?php endif; ?>
            </table>
        </fieldset>

        <br>

        <!-- Assignments Table -->
        <fieldset>
            <legend>Active Room Assignments</legend>
            <table border="1" cellpadding="8" width="100%">
                <tr>
                    <th>Room No</th>
                    <th>Patient Name</th>
                    <th>Admission Date</th>
                    <th>Expected Discharge</th>
                    <th>Action</th>
                </tr>
                <?php if (count($assignments) > 0): ?>
                    <?php foreach ($assignments as $a): ?>
                        <tr>
                            <td>
                                <?php echo $a['room_number']; ?>
                            </td>
                            <td>
                                <?php echo $a['patient_name']; ?>
                            </td>
                            <td>
                                <?php echo $a['admission_date']; ?>
                            </td>
                            <td>
                                <?php echo $a['expected_discharge_date']; ?>
                            </td>
                            <td>
                                <a href="../controller/discharge_patient.php?id=<?php echo $a['id']; ?>&room_id=<?php echo $a['room_id']; ?>"
                                    onclick="return confirm('Discharge this patient and free the room?');"><button>Discharge</button></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" align="center">No active assignments</td>
                    </tr>
                <?php endif; ?>
            </table>
        </fieldset>
    </div>
</body>

</html>