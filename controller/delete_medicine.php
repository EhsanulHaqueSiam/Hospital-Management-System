<?php
require_once('adminCheck.php');
require_once('../model/medicineModel.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $status = deleteMedicine($id);

    if ($status) {
        header('location: ../view/medicine_list.php');
    } else {
        echo "Failed to delete medicine";
    }
} else {
    header('location: ../view/medicine_list.php');
}
?>