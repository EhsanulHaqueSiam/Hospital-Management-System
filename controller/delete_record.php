<?php
require_once('adminCheck.php');
require_once('../model/medicalRecordModel.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $status = deleteMedicalRecord($id);

    if ($status) {
        header('location: ../view/record_list.php');
    } else {
        echo "Failed to delete medical record";
    }
} else {
    header('location: ../view/record_list.php');
}
?>