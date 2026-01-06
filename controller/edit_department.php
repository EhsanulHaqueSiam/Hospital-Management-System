<?php
require_once('adminCheck.php');
require_once('../model/departmentModel.php');

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $department_name = $_POST['department_name'];
    $description = $_POST['description'];

    if ($department_name == "") {
        echo "Department name is required";
    } else {
        $department = [
            'id' => $id,
            'department_name' => $department_name,
            'description' => $description
        ];

        $status = updateDepartment($department);

        if ($status) {
            header('location: ../view/admin_department_list.php');
        } else {
            echo "Failed to update department";
        }
    }
} else {
    header('location: ../view/admin_department_list.php');
}
?>