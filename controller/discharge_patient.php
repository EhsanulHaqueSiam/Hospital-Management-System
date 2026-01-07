<?php
session_start();
require_once('../model/roomModel.php');

if (isset($_GET['id']) && isset($_GET['room_id'])) {
    $id = $_GET['id'];
    $room_id = $_GET['room_id'];
    $date = date('Y-m-d'); // Today

    $status = dischargePatient($id, $room_id, $date);

    if ($status) {
        header('location: ../view/room_list.php');
    } else {
        echo "Failed to discharge patient";
    }
} else {
    header('location: ../view/room_list.php');
}
?>