<?php
require_once('adminCheck.php');
require_once('../model/roomModel.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $status = deleteRoom($id);

    if ($status) {
        header('location: ../view/room_list.php');
    } else {
        echo "Failed to delete room";
    }
} else {
    header('location: ../view/room_list.php');
}
?>