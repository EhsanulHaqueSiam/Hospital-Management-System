<?php
require_once('adminCheck.php');
require_once('../model/departmentModel.php');
require_once('../model/doctorModel.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $doctors = getDoctorsByDepartment($id);
    if (count($doctors) > 0) {
        echo "Cannot delete department: " . count($doctors) . " doctor(s) are assigned to it. Please reassign them first.";
        echo "<br><a href='../view/admin_department_list.php'>Go Back</a>";
        exit;
    }

    $status = deleteDepartment($id);

    if ($status) {
        header('location: ../view/admin_department_list.php');
    } else {
        echo "Failed to delete department";
        echo "<br><a href='../view/admin_department_list.php'>Go Back</a>";
    }
} else {
    header('location: ../view/admin_department_list.php');
}
?>