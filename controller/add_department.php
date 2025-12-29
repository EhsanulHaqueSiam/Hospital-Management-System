<?php
session_start();
require_once('../model/departmentModel.php');

if (isset($_POST['submit'])) {
    $department_name = $_POST['department_name'];
    $description = $_POST['description'];

    if ($department_name == "") {
        echo "Department name is required";
    } else {
        $department = [
            'department_name' => $department_name,
            'description' => $description
        ];

        $status = addDepartment($department);

        if ($status) {
            header('location: ../view/admin_department_list.php');
        } else {
            echo "Failed to add department";
        }
    }
} else {
    header('location: ../view/admin_department_add.php');
}
?>