<?php
require_once('../controller/adminCheck.php');
require_once('../model/roomModel.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$room = getRoomById($id);

if (!$room) {
    header('location: room_list.php');
    exit;
}
?>
<html>

<head>
    <title>View Room - Hospital Management System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <div class="navbar">
        <span class="navbar-title">Hospital Management System</span>
        <a href="dashboard_admin.php" class="navbar-link">Dashboard</a>
        <a href="room_list.php" class="navbar-link">Rooms</a>
        <a href="../controller/logout.php" class="navbar-link">Logout</a>
    </div>

    <div class="main-container">
        <h2>Room Details</h2>

        <fieldset>
            <legend>Room Information</legend>
            <table cellpadding="8">
                <tr>
                    <td><strong>Room ID:</strong></td>
                    <td>
                        <?php echo $room['id']; ?>
                    </td>
                </tr>
                <tr>
                    <td><strong>Room Number:</strong></td>
                    <td>
                        <?php echo $room['room_number']; ?>
                    </td>
                </tr>
                <tr>
                    <td><strong>Room Type:</strong></td>
                    <td>
                        <?php echo $room['room_type']; ?>
                    </td>
                </tr>
                <tr>
                    <td><strong>Floor:</strong></td>
                    <td>
                        <?php echo $room['floor']; ?>
                    </td>
                </tr>
                <tr>
                    <td><strong>Capacity:</strong></td>
                    <td>
                        <?php echo $room['capacity']; ?>
                    </td>
                </tr>
                <tr>
                    <td><strong>Price Per Day (Tk):</strong></td>
                    <td>
                        <?php echo $room['price_per_day']; ?>
                    </td>
                </tr>
                <tr>
                    <td><strong>Facilities:</strong></td>
                    <td>
                        <?php echo $room['facilities']; ?>
                    </td>
                </tr>
            </table>
        </fieldset>

        <br>

        <div>
            <a href="room_edit.php?id=<?php echo $room['id']; ?>"><button>Edit Room</button></a>
            <a href="room_list.php"><button>Back to List</button></a>
        </div>
    </div>
</body>

</html>