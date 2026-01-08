<?php
require_once('../controller/adminCheck.php');
?>

<html>

<head>
    <title>Add Room - Hospital Management System</title>
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
        <h2>Add New Room</h2>

        <fieldset>
            <legend>Room Details</legend>
            <form method="POST" action="../controller/add_room.php" onsubmit="return validateForm(this)">
                <table cellpadding="5">
                    <tr>
                        <td>Room Number:</td>
                        <td><input type="text" name="room_number" required
                                onblur="validateRequiredBlur(this, 'Room Number')"></td>
                    </tr>
                    <tr>
                        <td>Room Type:</td>
                        <td>
                            <select name="room_type">
                                <option value="General Ward">General Ward</option>
                                <option value="Private">Private</option>
                                <option value="Semi-Private">Semi-Private</option>
                                <option value="ICU">ICU</option>
                                <option value="CCU">CCU</option>
                                <option value="Cabin">Cabin</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Floor:</td>
                        <td><input type="number" name="floor" min="0" onblur="validateIntegerBlur(this, 'Floor', 0)">
                        </td>
                    </tr>
                    <tr>
                        <td>Capacity:</td>
                        <td><input type="number" name="capacity" value="1" min="1"
                                onblur="validateIntegerBlur(this, 'Capacity', 1)"></td>
                    </tr>
                    <tr>
                        <td>Price Per Day:</td>
                        <td><input type="number" step="0.01" name="price" required
                                onblur="validatePositiveNumberBlur(this, 'Price')"></td>
                    </tr>
                    <tr>
                        <td>Facilities:</td>
                        <td><textarea name="facilities" rows="2"></textarea></td>
                    </tr>
                    <tr>
                        <td>Description:</td>
                        <td><textarea name="description" rows="2"></textarea></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right">
                            <input type="submit" name="submit" value="Add Room">
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