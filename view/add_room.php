<?php
    session_start();
    setcookie('status', 'true', time()+3000, '/');
?>
<html>
<head>
    <title>ADD ROOM</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
    <h2>Add New Hospital Room</h2>
    
    <form method="POST" action="process_room.php" onsubmit="return validateAddRoom()">
        <div>
            Room No: <input type="text" name="room_no" onblur="validateRoomNoBlur()"> 
            <span id="room-no-error"></span>
        </div><br>

        <div>
            Type: 
            <select name="room_type" onblur="validateRoomTypeBlur()">
                <option value="">--Select Type--</option>
                <option value="General Ward">General Ward</option>
                <option value="Private Room">Private Room</option>
                <option value="ICU">ICU</option>
            </select>
            <span id="type-error"></span>
        </div><br>

        <div>
            Floor: <input type="text" name="room_floor" onblur="validateFloorBlur()">
            <span id="floor-error"></span>
        </div><br>

        <div>
            Price: <input type="text" name="room_price" onblur="validatePriceBlur()">
            <span id="price-error"></span>
        </div><br>

        <div>
            Status: 
            <select name="room_status" onblur="validateStatusBlur()">
                <option value="">--Select Status--</option>
                <option value="Available">Available</option>
                <option value="Occupied">Occupied</option>
                <option value="Maintenance">Maintenance</option>
            </select>
            <span id="status-error"></span>
        </div><br>

        <div>
            Patient: <input type="text" name="room_patient" onblur="validatePatientBlur()">
            <span id="patient-error"></span>
        </div><br>

        <input type="submit" name="submit" value="SAVE ROOM">
        <a href="room_management.php">Cancel</a>
    </form>

    <script src="validation_room.js"></script>
</body>
</html>