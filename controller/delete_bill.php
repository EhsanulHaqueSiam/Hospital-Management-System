<?php
require_once('adminCheck.php');
require_once('../model/billModel.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $status = deleteBill($id);

    if ($status) {
        header('location: ../view/bill_list.php');
    } else {
        echo "Failed to delete bill";
    }
} else {
    header('location: ../view/bill_list.php');
}
?>