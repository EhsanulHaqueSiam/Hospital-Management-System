<?php
require_once('adminCheck.php');
require_once('../model/roomModel.php');

if (isset($_POST['submit'])) {
    $room_number = $_POST['room_number'];
    $room_type = $_POST['room_type'];
    $floor = $_POST['floor'];
    $capacity = $_POST['capacity'];
    $price = $_POST['price'];
    $facilities = $_POST['facilities'];
    $description = $_POST['description'];

    if ($room_number == "" || $price == "") {
        echo "Room Number and Price are required";
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