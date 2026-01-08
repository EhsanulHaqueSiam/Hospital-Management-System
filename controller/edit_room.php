<?php
require_once('adminCheck.php');
require_once('../model/roomModel.php');
require_once('../model/validationHelper.php');

function getRoomByNumber($room_number)
{
    $con = getConnection();
    $number = mysqli_real_escape_string($con, $room_number);
    $sql = "SELECT * FROM rooms WHERE room_number='{$number}'";
    $result = mysqli_query($con, $sql);
    return mysqli_fetch_assoc($result);
}

if (isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $room_number = trim($_POST['room_number']);
    $room_type = $_POST['room_type'];
    $floor = trim($_POST['floor']);
    $capacity = $_POST['capacity'];
    $price = $_POST['price'];
    $facilities = trim($_POST['facilities']);
    $description = trim($_POST['description']);

    $errors = [];
    if ($err = validateRequired($room_number, 'Room Number'))
        $errors[] = $err;
    if ($err = validatePositiveNumber($price, 'Price'))
        $errors[] = $err;

    if (count($errors) > 0) {
        echo "Validation errors:<br>" . implode("<br>", $errors);
        echo "<br><a href='../view/room_edit.php?id=" . $id . "'>Go Back</a>";
    } else {
        $existingRoom = getRoomByNumber($room_number);
        if ($existingRoom && $existingRoom['id'] != $id) {
            echo "Room number '" . $room_number . "' already exists. Please use a different room number.";
            echo "<br><a href='../view/room_edit.php?id=" . $id . "'>Go Back</a>";
        } else {
            $room = [
                'id' => $id,
                'room_number' => $room_number,
                'room_type' => $room_type,
                'floor' => $floor,
                'capacity' => $capacity,
                'price_per_day' => $price,
                'facilities' => $facilities,
                'description' => $description
            ];

            $status = updateRoom($room);

            if ($status) {
                header('location: ../view/room_list.php');
            } else {
                echo "Failed to update room";
                echo "<br><a href='../view/room_list.php'>Go Back</a>";
            }
        }
    }
} else {
    header('location: ../view/room_list.php');
}
?>