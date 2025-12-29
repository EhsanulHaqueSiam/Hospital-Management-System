<?php
session_start();
require_once('../model/departmentModel.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $status = deleteDepartment($id);

    if ($status) {
        header('location: ../view/admin_department_list.php');
    } else {
        echo "Failed to delete department";
    }
} else {
    header('location: ../view/admin_department_list.php');
}
?>