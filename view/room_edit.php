<?php
require_once('../controller/adminCheck.php');
require_once('../model/roomModel.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$room = getRoomById($id);

if (!$room) {
    echo "Room not found!";
    exit;
}
?>

<html>

<head>
    <title>Edit Room - Hospital Management System</title>
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
        <h2>Edit Room</h2>

        <fieldset>
            <legend>Edit Information</legend>
            <form method="POST" action="../controller/edit_room.php" onsubmit="return validateForm(this)">
                <input type="hidden" name="id" value="<?php echo $room['id']; ?>">
                <table cellpadding="5">
                    <tr>
                        <td>Room Number:</td>
                        <td><input type="text" name="room_number" value="<?php echo $room['room_number']; ?>" required
                                onblur="validateRequiredBlur(this, 'Room Number')">
                        </td>
                    </tr>
                    <tr>
                        <td>Room Type:</td>
                        <td>
                            <select name="room_type">
                                <option value="General Ward" <?php if ($room['room_type'] == 'General Ward')
                                    echo 'selected'; ?>>General Ward</option>
                                <option value="Private" <?php if ($room['room_type'] == 'Private')
                                    echo 'selected'; ?>>
                                    Private</option>
                                <option value="Semi-Private" <?php if ($room['room_type'] == 'Semi-Private')
                                    echo 'selected'; ?>>Semi-Private</option>
                                <option value="ICU" <?php if ($room['room_type'] == 'ICU')
                                    echo 'selected'; ?>>ICU
                                </option>
                                <option value="CCU" <?php if ($room['room_type'] == 'CCU')
                                    echo 'selected'; ?>>CCU
                                </option>
                                <option value="Cabin" <?php if ($room['room_type'] == 'Cabin')
                                    echo 'selected'; ?>>Cabin
                                </option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Floor:</td>
                        <td><input type="number" name="floor" value="<?php echo $room['floor']; ?>" min="0"
                                onblur="validateIntegerBlur(this, 'Floor', 0)"></td>
                    </tr>
                    <tr>
                        <td>Capacity:</td>
                        <td><input type="number" name="capacity" value="<?php echo $room['capacity']; ?>" min="1"
                                onblur="validateIntegerBlur(this, 'Capacity', 1)"></td>
                    </tr>
                    <tr>
                        <td>Price Per Day:</td>
                        <td><input type="number" step="0.01" name="price" value="<?php echo $room['price_per_day']; ?>"
                                required onblur="validatePositiveNumberBlur(this, 'Price')"></td>
                    </tr>
                    <tr>
                        <td>Facilities:</td>
                        <td><textarea name="facilities" rows="2"><?php echo $room['facilities']; ?></textarea></td>
                    </tr>
                    <tr>
                        <td>Description:</td>
                        <td><textarea name="description" rows="2"><?php echo $room['description']; ?></textarea></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right">
                            <input type="submit" name="update" value="Update Room">
                            <a href="room_list.php"><button type="button">Cancel</button></a>
                        </td>
                    </tr>
                </table>
            </form>
        </fieldset>
    </div>
    <script src="../assets/js/validation-common.js"></script>
</body>

</html>