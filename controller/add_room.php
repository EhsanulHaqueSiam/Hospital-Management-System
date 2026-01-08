<?php
require_once('adminCheck.php');
require_once('../model/roomModel.php');
require_once('../model/validationHelper.php');

if (isset($_POST['submit'])) {
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
    $existingRoom = getRoomByNumber($room_number);
    if ($existingRoom) {
        $errors[] = "Room number '$room_number' already exists";
    }

    if (count($errors) > 0) {
        echo "Validation errors:<br>" . implode("<br>", $errors);
    } else {
        $room = [
            'room_number' => $room_number,
            'room_type' => $room_type,
            'floor' => $floor,
            'capacity' => $capacity,
            'price_per_day' => $price,
            'facilities' => $facilities,
            'description' => $description
        ];

        $status = addRoom($room);

        if ($status) {
            header('location: ../view/room_list.php');
        } else {
            echo "Failed to add room (Number might be duplicate)";
        }
    }
} else {
    header('location: ../view/room_add.php');
}
?>