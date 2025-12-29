<?php
session_start();
require_once('../model/doctorModel.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $status = deleteDoctor($id);

    if ($status) {
        header('location: ../view/admin_doctor_list.php');
    } else {
        echo "Failed to delete doctor";
    }
} else {
    header('location: ../view/admin_doctor_list.php');
}
?>